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
                    $respuesta = array('ok' => true, 
                                       'nombreEmpleado' => $res['usuario'],
                                       'tipoNomina' => $res['nivel_organigrama']
                                    );  
         
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
            $fecha = date('Y-m-d H:i:s');

            $sqlre="INSERT INTO uni_salida(fecha, tipo_salida, id_usuario, id_empleado, nota, vale)
                        VALUES(:fecha, :tipoSalida, :idUsuario, :idEmpleado, :nota, :vale)";

            $entrada = $conn->prepare($sqlre);
            $entrada->bindparam(':tipoSalida', $tipoSalida);
            $entrada->bindparam(':idUsuario', $idUsuario);
            $entrada->bindparam(':idEmpleado', $idEmpleado);
            $entrada->bindparam(':nota', $nota);
            $entrada->bindparam(':vale', $vale);
            $entrada->bindparam(':fecha', $fecha);

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

                                if($uArticulos->execute()) {
                                    if($tipoSalida== 2)
                                        $respuesta = registroVenta($fecha);

                                    else
                                        $respuesta = array('response' => 'Salida registrada');
                                    }

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

   else 
        if($opcion== '5')
            {
                $veces = $_POST['numDescuentos'];
                $tipoNomina = $_POST['tipoNomina'];
                $respuesta = obtenerFechas($veces, $tipoNomina);

                echo json_encode($respuesta[0]);
                echo "\n";
                echo json_encode($respuesta[1] ?? null);
                echo "\n";
                echo json_encode($respuesta[2] ?? null);
                echo "\n";
                echo json_encode($respuesta[3] ?? null); 

            }

//Funcion para el proceso adicional del registro de la salida cunado es una salida por venta
    function registroVenta($fecha, $idSalida){
        $idUsuario = (isset($_POST['idUsuario']) && !$_POST['idUsuario']=='') ? $_POST['idUsuario'] : NULL;
        $fecha;
        $idEmpleado = (isset($_POST['idEmpleado']) && !$_POST['idEmpleado']=='') ? $_POST['idEmpleado'] : NULL;
        $pagoTotal = (isset($_POST['pagoTotal']) && !$_POST['pagoTotal']) ? $_POST['pagoTotal'] : NULL;
        $articulosPedido = (isset($_POST['articulosSalida']) && !empty($_POST['articulosSalida']) ) ? $_POST['articulosSalida'] : '';
        $idSalida;
        $firma = (isset($_POST['firma']) && !$_POST['firma']) ? $_POST['firma'] : NULL;
        $tipoNomina = (isset($_POST['tipoNomina']) && !$_POST['tipoNomina']) ? $_POST['tipoNomina'] : NULL;
        $numDescuentos = (isset($_POST['numDescuentos']) && !$_POST['numDescuentos']) ? $_POST['numDescuentos'] : NULL;
        $fechaDescuento;
        $cantidadDescuento;

            /*
                pago_total
                id_usuario
                id_salida
                firma
                tipo_nomina
                num_descuentos
                check_1
                check_2
                check_3
                check_4
                fecha_1
                fecha_2
                fecha_3
                fecha_4
                descuento_1
                descuento_2
                descuento_3
                descuento_4 
            */

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

     return $respuesta;
    }


    /*
        function obtenerFechas15y30($repeticiones) {
            $fechas = [];

            // Comenzar desde la próxima semana
            $inicio = new DateTime();
            $inicio->modify('next monday'); // Empieza la próxima semana

            // Avanzar mes a mes
            for ($i = 0; $i < $repeticiones; $i++) {
                // Clonar la fecha de inicio y avanzar $i meses
                $mesBase = clone $inicio;
                $mesBase->modify("+$i month");

                // Días objetivo: 15 y 30
                foreach ([15, 30] as $dia) {
                    $fecha = DateTime::createFromFormat('Y-m-d', $mesBase->format("Y-m-$dia"));

                    // Validar que la fecha sea válida (el día 30 puede no existir en febrero, por ejemplo)
                    if ($fecha && $fecha->format('d') == $dia) {
                        // Ajustar si cae sábado (6) o domingo (7)
                        $diaSemana = $fecha->format('N'); // 1 (lunes) a 7 (domingo)
                        if ($diaSemana == 6) {
                            $fecha->modify('-1 day'); // sábado → viernes
                        } elseif ($diaSemana == 7) {
                            $fecha->modify('-2 days'); // domingo → viernes
                        }

                        $fechas[] = $fecha->format('Y-m-d');
                    }
                }
            }

            return $fechas;
        }
    */


    function obtenerFechas($veces, $tipoNomina) {
        $fechas = [];

        if( $tipoNomina == 'Q'){
            $actual = new DateTime();
            $actual->modify('next monday'); // Empezar desde la próxima semana

            while (count($fechas) < $veces) {
                $anio = (int)$actual->format('Y');
                $mes = (int)$actual->format('m');

                foreach ([15, 30] as $dia) {
                    // Intentar crear la fecha
                    $fecha = DateTime::createFromFormat('Y-m-d', sprintf('%04d-%02d-%02d', $anio, $mes, $dia));
                    //$fecha = DateTime::createFromFormat('Y-m-d', sprintf('%04d-%02d-%02d', 2025, 8, $dia));


                    if (!$fecha) continue; // Fecha inválida (ej. 30 de febrero)

                    // Saltar fechas pasadas
                    if ($fecha < $actual) continue;

                    // Ajustar si cae en fin de semana
                    $diaSemana = $fecha->format('N'); // 6 = sábado, 7 = domingo
                    if ($diaSemana == 6) {
                        $fecha->modify('-1 day'); // sábado → viernes
                    } elseif ($diaSemana == 7) {
                        $fecha->modify('-2 days'); // domingo → viernes
                    }

                    // Añadir si aún no tenemos suficientes fechas
                    if (count($fechas) < $veces) {
                        $fechas[] = $fecha->format('Y-m-d');
                    } else {
                        break 2; // Salir de ambos bucles si ya tenemos suficientes
                    }
                }

                // Avanzar al siguiente mes
                $actual->modify('first day of next month');
            }
        }


      else 
        if($tipoNomina == 'S'){
                    $hoy = new DateTime('2025-09-01');
                    $hoy->modify('next monday');                
            while(count($fechas) < $veces){
                // Crear objeto con la fecha actual
                    // Obtener el próximo viernes de la siguiente semana
                    $hoy->modify('next friday'); // Este viernes

                    // Formatear la fecha en formato SQL o como necesites
                    $fechas[] = $hoy->format('Y-m-d');
            } 
        }

    return $fechas;
}

?>