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


?>