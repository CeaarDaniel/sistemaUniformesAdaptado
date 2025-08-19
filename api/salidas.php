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
                    $respuesta = array('ok' => true);  
         
               else  $respuesta = array('ok' => false);
       }

    else 
       $respuesta = array('error'=> $stmt->errorInfo()[2]);
   
   echo json_encode($respuesta);
}
?>