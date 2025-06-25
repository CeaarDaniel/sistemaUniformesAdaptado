<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
include('./conexion.php'); 


$opcion = $_POST['opcion'];

//ARTICULOS DEBAJO DEL STOCK MINIMO
if($opcion=='1'){
        /*
            SELECT ua.id_articulo, ua.cantidad, ua.nombre, uc.categoria, ut.talla, ug.genero
                from uni_articulos as ua
                    inner join uni_categoria as uc on ua.id_categoria = uc.id_categoria
                    inner join uni_genero as ug on ua.genero = ug.id_genero
                    inner join uni_talla as ut on ua.id_talla = ut.id_talla
            where cantidad <= stock_min";
        */

    $sql= "SELECT ua.id_articulo, (ua.stock_max - ua.cantidad) as cantidad, 
		   ua.nombre, uc.categoria, ut.talla, ug.genero,
           CASE 
            WHEN EXISTS (
                SELECT 1 
                FROM uni_pedido p 
                INNER JOIN uni_pedido_articulo pa ON p.id_pedido = pa.id_pedido
                WHERE p.status IN (1, 2) 
                AND pa.id_articulo = ua.id_articulo) THEN 1
            ELSE 0
        END AS en_pedido
        from uni_articulos as ua
			inner join uni_categoria as uc on ua.id_categoria = uc.id_categoria
			inner join uni_genero as ug on ua.genero = ug.id_genero
			inner join uni_talla as ut on ua.id_talla = ut.id_talla
		where (ua.cantidad < 10 or ua.cantidad < stock_min) AND (ua.stock_max - ua.cantidad) > 0";

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
                                   'genero' => $articulo['genero'], 
                                   'en_pedido' => $articulo['en_pedido']);
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

    //Obtener los generos y tallas de las categorias
    else 
        if($opcion == '3'){
             $categoria = (isset($_POST['categoria']) && !empty($_POST['categoria'])) ? $_POST['categoria'] : 0;
             $consultaGenero = "SELECT ug.id_genero, ug.genero from uni_articulos as ua 
                                        left join uni_genero as ug on ua.genero = ug.id_genero 
                                    where id_categoria= :categoria
                                group by id_categoria, ug.genero, ug.id_genero";

             $consultaTalla = "SELECT ua.id_talla, ut.talla from uni_articulos ua
                			    	    inner join uni_talla as ut on ua.id_talla = ut.id_talla  
                                    where id_categoria= :categoria
                                group by id_categoria, ua.id_talla, ut.tipo_talla, ut.talla";

             $listaTallas = null;
             $listaGeneros = null;

              $talla = $conn->prepare($consultaTalla); 
              $genero = $conn->prepare($consultaGenero); 


                $talla->bindparam(':categoria', $categoria);
                $genero->bindparam(':categoria', $categoria);


                if($talla->execute()){
                    while($tallas = $talla->fetch(PDO::FETCH_ASSOC)){
                        $listaTallas[] = $tallas;
                    }

                    $response['tallas'] = $listaTallas;
                }

                else 
                    $response['tallas'] = array('error' => $talla->errorInfo()[2]);

                if($genero->execute()){
                    while($generos = $genero->fetch(PDO::FETCH_ASSOC)){
                        $listaGeneros[] = $generos;
                    }

                    $response['generos'] = $listaGeneros;
                }

                else 
                    $response['generos'] = array('error' => $talla->errorInfo()[2]);

            echo json_encode($response);
        }
    
       else 
        if($opcion == '4'){
             $categoria = (isset($_POST['categoria']) && !empty($_POST['categoria'])) ? $_POST['categoria'] : "";
             $talla = (isset($_POST['talla']) && !empty($_POST['talla'])) ? $_POST['talla'] : "";
             $genero = (isset($_POST['genero']) && !empty($_POST['genero'])) ? $_POST['genero'] : "";

             $consultaArticulo = "SELECT id_articulo, nombre, cantidad, precio from uni_articulos where id_talla = :id_talla and genero= :genero and id_categoria= :id_categoria and eliminado = 0 ";

              $articulo = $conn->prepare($consultaArticulo); 


                $articulo->bindparam(':id_talla', $talla);
                $articulo->bindparam(':id_categoria', $categoria);
                $articulo->bindparam(':genero', $genero);


                if ($articulo->execute()) {
                    $fila = $articulo->fetch(PDO::FETCH_ASSOC);

                    // Verificar si la consulta devolvió alguna fila
                    if ($fila !== false) {
                    // Hay resultado
                    $response['articulo'] = $fila;
                } else {
                    // No hay resultado
                    $response['articulo'] = null;
                }
                } else {
                    // Error en la consulta
                    $response['error'] = $articulo->errorInfo()[2];
                }

                echo json_encode($response);
        }
?>