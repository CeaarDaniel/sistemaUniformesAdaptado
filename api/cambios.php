<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
include('./conexion.php'); 

$opcion = $_POST['opcion'];


    //FUNCION PARA OBTENER LOS DETALLES DE LA SALIDA PARA HACER EL CAMBIO
    if($opcion == '1'){
        $id_salida= (isset($_POST['id_salida']) && !$_POST['id_salida']=='') ? $_POST['id_salida'] : NULL;

        $detalleSalida= "SELECT usa.id_articulo, usa.cantidad, ua.nombre, ut.talla, usa.precio, (usa.cantidad * usa.precio) as total  
                            from uni_salida as us 
                                left join uni_salida_articulo as usa on us.id_salida = usa.id_salida 
                                left join uni_articulos as ua on usa.id_articulo = ua.id_articulo
                                left join uni_talla as ut on ua.id_talla = ut.id_talla
                            where us.id_salida =  :id_salida";
            
            $salidas = $conn->prepare($detalleSalida); 

            $salidas->bindparam(':id_salida', $id_salida);

            if($salidas->execute()){
                while($salida = $salidas->fetch(PDO::FETCH_ASSOC))
                    $response[]= $salida;
            }

            else 
                $response = array('error' => $salidas->errorInfo()[2]);

        echo json_encode($response);
    }

?>