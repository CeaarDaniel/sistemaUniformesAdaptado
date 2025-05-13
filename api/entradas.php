<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
include('./conexion.php'); 


$opcion = $_POST['opcion'];

//ARTICULOS DEBAJO DEL STOCK MINIMO
if($opcion=='1'){
    $sql= "SELECT ua.id_articulo, ua.cantidad, ua.nombre, uc.categoria, ut.talla, ug.genero 
        from uni_articulos as ua
		inner join uni_categoria as uc on ua.id_categoria = uc.id_categoria
		inner join uni_genero as ug on ua.genero = ug.id_genero
		inner join uni_talla as ut on ua.id_talla = ut.id_talla
		where cantidad <= stock_min";    
        
    $articulos = $conn->prepare($sql); 

    //$articulos->bindparam(':id_salida', $id_salida);

        if($articulos->execute()){
            while($articulo = $articulos->fetch(PDO::FETCH_ASSOC))
                $response[]= array( 'check' => "<input type='checkbox' class='select-checkbox' data-id='" . $articulo['id_articulo'] . "'>",
                                   'id_articulo' => $articulo['id_articulo'],
                                   'cantidad' => $articulo['cantidad'], 
                                   'nombre' => $articulo['nombre'], 
                                   'categoria' => $articulo['categoria'], 
                                   'talla' => $articulo['talla'],  
                                   'genero' => $articulo['genero']); 
        }

        else 
            $response = array('error' => $articulos->errorInfo()[2]);

    echo json_encode($response);
}

?>