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

//ARTICULOS PARA REGISTRAR COMO ENTRADA POR SALIDA
else 
    if($opcion== '2'){
         $startDate = (isset($_POST['startDate']) && !$_POST['startDate']=='') ? (new DateTime($_POST['startDate']))->format('Y/m/d') : 0;
         $endDate = (isset($_POST['endDate']) && !$_POST['endDate']=='') ? (new DateTime($_POST['endDate']))->format('Y/m/d') : 0;
    
        $filtroFecha = ($startDate != 0 && $endDate != 0) 
                                ? $filtroFecha = " AND FORMAT(us.fecha, 'yyyy/MM/dd') between :startDate and :endDate " 
                                : $filtroFecha = '';

        $sql = "SELECT id_articulo, SUM(cantidad) as cantidad from uni_salida as us inner join uni_salida_articulo as usa on us.id_salida = usa.id_salida 
                    where 1=1 ".$filtroFecha." 
                 group by id_articulo order by id_articulo";
        
        $articulos = $conn->prepare($sql); 

        if ($startDate != 0 && $endDate != 0){
            $articulos->bindparam(':startDate', $startDate);
            $articulos->bindparam(':endDate', $endDate);
        }


        if($articulos->execute()){
            while($articulo = $articulos->fetch(PDO::FETCH_ASSOC))
                $response[]= array( 'id_articulo' => $articulo['id_articulo'],
                                    'cantidad' => $articulo['cantidad'],
                                    'boton' => "<button class='btn btn-danger my-0 mx-1 btn-eliminar' data-id='".$articulo['id_articulo']."'><i class='fas fa-trash'></i></button>");
        }

        else 
            $response = array('error' => $articulos->errorInfo()[2]);

    echo json_encode($response);
    }

?>