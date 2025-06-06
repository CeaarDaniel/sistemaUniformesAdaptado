<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
include('./conexion.php');


$opcion= $_POST['opcion'];

//FUNCION PARA OBTENER LAS TALLAS
if($opcion=='1'){
    $tipoTalla = $_POST['tipoTalla'];

    $tallas = $conn->prepare("select* from uni_talla where tipo_Talla = ".$tipoTalla); 
        if($tallas->execute()){
            while($talla = $tallas->fetch(PDO::FETCH_ASSOC))    
            $response[]= $talla; 
        }

        else 
            $response = array('error'=> $tallas->errorInfo()[2]);
        
    echo json_encode ($response);
}


//VERIFICAR SI EXISTE EL NOMBRE
if($opcion=='2'){
    $nombre = $_POST['nombre'];

    $nombresArticulo = $conn->prepare("select 1 as exist from uni_articulos where nombre = :nombre");
    $nombresArticulo -> bindParam(':nombre' , $nombre); 

        if($nombresArticulo->execute()){
            $talla = $nombresArticulo->fetch(PDO::FETCH_ASSOC);
     
            echo json_encode ($talla);
        }

        else {
            $response = array('error'=> $nombresArticulo->errorInfo()[2]);
            echo json_encode ($response);
        }
}

//VERIFICAR SI EXISTE LA CATEGORÍA
if($opcion=='3'){
    $categoria = $_POST['categoria'];

    $nombresCategoria = $conn->prepare("select 1 as exist from uni_categoria where categoria = :categoria");
    $nombresCategoria -> bindParam(':categoria' , $categoria); 

        if($nombresCategoria->execute()){
            $categorias = $nombresCategoria->fetch(PDO::FETCH_ASSOC);
            echo json_encode ($categorias);
        }

        else {
            $response = array('error'=> $nombresCategoria->errorInfo()[2]);
            echo json_encode ($response);
        }
}

//VERIFICAR SI EXISTE EL NOMBRE ABREVIADO DE LA CATEGORÍA
if($opcion=='4'){
    $abrev = $_POST['abrev'];

    $nombresAbrev= $conn->prepare("select 1 as exist from uni_categoria where abrev = :abrev");
    $nombresAbrev -> bindParam(':abrev' , $abrev); 

        if($nombresAbrev->execute()){
            $abrevs = $nombresAbrev->fetch(PDO::FETCH_ASSOC);
            echo json_encode ($abrevs);
        }

        else {
            $response = array('error'=> $nombresAbrev->errorInfo()[2]);
            echo json_encode ($response);
        }
}
?>
