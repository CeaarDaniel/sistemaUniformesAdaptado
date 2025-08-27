<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
include('./conexion.php'); 


$opcion= $_POST['opcion'];

//GUARDAR EL REGISTRO DE LA FIRMA COMO IMAGEN
if($opcion == '1'){
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../imagenes/';
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) 
            $response = array('ok' => 'Se ha registrado la firma');

        else 
            $response = array('error' => 'Error al mover el archivo');
         
    } 
    else 
        $response = array('error' => 'No se recibió ninguna imagen');

  echo json_encode($response);
}

//OBTENER GENEROS Y CATEGORIAS DEL BARCODE
else 
    if( $opcion == '2'){
         $barcode = (isset($_POST['barcode']) && !$_POST['barcode']=='') ? $_POST['barcode'] : NULL;
         $sqlB= 'SELECT tv.id_tipo_vale, tv.nombre, vu.uniforme 
			            FROM uni_vale v inner join uni_vale_uniforme vu on vu.id_vale = v.tipo_vale 
							inner join uni_tipo_vale tv on v.tipo_vale = tv.id_tipo_vale 
		         WHERE v.barcode = :barcode AND v.tipo_vale = tv.id_tipo_vale AND vu.id_vale = v.tipo_vale';

        $cateGen = $conn->prepare($sqlB);
        $cateGen->bindparam(':barcode', $barcode);
            if($cateGen->execute()){
                $result = $cateGen->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                        $response = array(
                            'nombre' => $result['nombre'],
                            'uniforme' => json_decode($result['uniforme'])
                        );
                    } 
                    else 
                        $response = array('error' => 'No se encontraron resultados');
                }

            else 
            $response = array ('error' => $cateGen->errorInfo()[2]);

        echo json_encode($response);
}


//OBTENER DATOS DEL EMPLEADO
else
if($opcion == '3'){
    $NN =  isset($_POST['NN']) ? $_POST['NN'] : '';

    ($NN == 1 || $NN =='1') ? $NN=0 : '';
    $sn = "select* from empleado where id_usuario = :NN and estatus='1'"; 
    $consulta = $conn->prepare($sn);
    $consulta->bindParam(':NN', $NN);
 
     if ($consulta->execute()) {
              if( $res = $consulta->fetch(PDO::FETCH_ASSOC))
                    $respuesta = array('ok' => true, 'nombreEmpleado' => $res['usuario']);  
         
               else $respuesta = array('ok' => false);
       }

    else 
       $respuesta = array('error'=> $stmt->errorInfo()[2]);
   
   echo json_encode($respuesta);
}


//REGISTRO DE UNA SALIDA
else 
    if($opcion == '4'){
        //$fecha = (isset($_POST['fecha']) && !$_POST['fecha']=='') ? $_POST['fecha'] : NULL;
        $tipoSalida = (isset($_POST['tipoSalida']) && !$_POST['tipoSalida']=='') ? $_POST['tipoSalida'] : NULL;
        $idUsuario = (isset($_POST['idUsuario']) && !$_POST['idUsuario']=='') ? $_POST['idUsuario'] : NULL;
        $idEmpleado = (isset($_POST['idEmpleado']) && !$_POST['idEmpleado']=='') ? $_POST['idEmpleado'] : NULL;
        $nota = (isset($_POST['nota']) && !$_POST['nota']=='') ? $_POST['nota'] : NULL;
        $vale = (isset($_POST['vale']) && !$_POST['vale']=='') ? $_POST['vale'] : NULL;
        $articulosPedido = (isset($_POST['articulosSalida']) && !empty($_POST['articulosSalida']) ) ? $_POST['articulosSalida'] : '';

        $sqlre="INSERT INTO uni_salida(fecha, tipo_salida, id_usuario, id_empleado, nota, vale)
                    VALUES(format(GETDATE(), 'yyyy-MM-dd HH:mm:ss'), :tipoSalida, :idUsuario, :idEmpleado, :nota, :vale)";

        $entrada = $conn->prepare($sqlre);
        $entrada->bindparam(':tipoSalida', $tipoSalida);
        $entrada->bindparam(':idUsuario', $idUsuario);
        $entrada->bindparam(':idEmpleado', $idEmpleado);
        $entrada->bindparam(':nota', $nota);
        $entrada->bindparam(':vale', $vale);

            // Ejecuta la consulta
            if ($entrada->execute()) {
                 $lastID = $conn->lastInsertId();
                //Se revisa que la estructura de los datos sea un arreglo para poder generar la consulta 
                if (is_array(json_decode($articulosPedido, true))) {
                        $articulosPedido = json_decode($articulosPedido, true);

                        //INSERTAR MULTIPLES REGISTROS USANDO INSERT
                        try {
                            $conn->beginTransaction();

                            $stmt = $conn->prepare("INSERT INTO uni_salida_articulo(id_salida, id_articulo, cantidad, precio) VALUES (?, ?, ?, ?)");

                            foreach ($articulosPedido as $item) {
                                $stmt->execute([
                                    $lastID,
                                    (int)$item['id'],
                                    (int)$item['cantidad'],
                                    ($tipoSalida != 2) ? null : (float)$item['precio'],
                                ]);
                            }

                            $conn->commit();

                            //Actualizar los articulos correspondientes al pedido
                                $sqluA = "UPDATE ua SET ua.cantidad = (ua.cantidad - usa.cantidad)
                                                        FROM uni_articulos ua
                                                    INNER JOIN uni_salida_articulo usa ON ua.id_articulo = usa.id_articulo
                                            WHERE usa.id_salida = :idPedido";

                            $uArticulos = $conn ->prepare($sqluA);
                            $uArticulos->bindparam(':idPedido', $lastID);

                            if($uArticulos->execute())
                                 $respuesta = array('response' => 'Salida registrada');

                            else 
                                $response = array('response' => $uArticulos->errorInfo()[2]);
                           

                        } catch (Exception $e) {
                            $conn->rollBack(); 
                            $respuesta = array("response" => "error: ".$e->getMessage());
                        }
                }

                else 
                    $respuesta = array("response" => "Datos invalidos");
            }

            else 
                $respuesta = array('response' => $stmt->errorInfo()[2]);

     echo json_encode($respuesta);
    }
?>