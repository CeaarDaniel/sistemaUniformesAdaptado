<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
include('./conexion.php'); 


$opcion = $_POST['opcion'];

    //Consulta para obtener los datos de la tabla de PEDIDOS
    if($opcion == '1'){
        $anio = isset($_POST['anio'] ) ? $_POST['anio'] : 0;
        $mes = (isset($_POST['mes']) && !$_POST['mes']=='') ? $_POST['mes'] : 0;
        $status = isset($_POST['status']) ? $_POST['status'] : 5;

        //Cadenas con la condicion de filtrado para generar la consulta
        if($anio != 0) 
                $filtroanio= ' AND YEAR(p.fecha_creacion) = '.$anio;
        else 
            $filtroanio=' ';

        if($mes != 0) 
                $filtromes= ' AND MONTH(p.fecha_creacion) = '.$mes;

        else
            $filtromes=' ';
        //EN la tabla de uni_pedido_estado existe el registro de todos con el id = 5
        if($status != 5)  
                $filtrostatus= ' AND e.id_estado = '.$status.' ';
        
        else 
            $filtrostatus=' ';    

        $sql= "SELECT p.id_pedido, p.num_pedido, p.fecha_creacion, e.pedido_estado, d.nombre from uni_pedido as p 
                    inner join DIRECTORIO_0 AS d on p.id_usuario = d.ID
                    inner join uni_pedido_estado as e on p.status = e.id_estado
                WHERE 1=1 
                        ".$filtroanio." 
                        ".$filtromes."
                        ".$filtrostatus."
                order by id_pedido";
        $pedidos = $conn->prepare($sql);

        if ($pedidos ->execute()){
            while($pedido = $pedidos->fetch(PDO::FETCH_ASSOC))
                $response[] = array ( 'id_pedido' => $pedido['id_pedido'],
                                      'num_pedido' => $pedido['num_pedido'],
                                      'fecha_creacion' => $pedido['fecha_creacion'],
                                      'pedido_estado' => $pedido['pedido_estado'],
                                      'nombre' => $pedido['nombre'], 
                                      'acciones' => '<button class="btn btnConcretar"
                                                                    data-id="'.$pedido['id_pedido'].'">
                                                        <i class="fas fa-check" style="font-size:20px; color:#198754; background-color:none"></i>
                                                    </button>
                                                     <button class="btn btnCancelar"
                                                             data-id="'.$pedido['id_pedido'].'">
                                                        <i class="fas fa-times" style="font-size:20px; color:red; background-color:none"></i>
                                                    </button>
                                                    <button class="btn btnVer"
                                                            data-id="'.$pedido['id_pedido'].'"
                                                            data-numPedido="'.$pedido['num_pedido'].'"
                                                            data-fechaCreacion="'.$pedido['fecha_creacion'].'"
                                                            data-estado="'.$pedido['pedido_estado'].'"
                                                            data-nombre="'.$pedido['nombre'].'"
                                                            >
                                                        <i class="fas fa-eye" style="font-size:20px; color:blue; background-color:none"></i>
                                                    </button>
                                                    <button class="btn btnImprimir p-0 my-0 mx-1" 
                                                            data-id="'.$pedido['id_pedido'].'"
                                                            data-numPedido="'.$pedido['num_pedido'].'"
                                                            data-fechaCreacion="'.$pedido['fecha_creacion'].'"
                                                            data-estado="'.$pedido['pedido_estado'].'"
                                                            data-nombre="'.$pedido['nombre'].'">
                                                        <i class="fas fa-print" style="font-size:20px; color:black; background-color:none"></i>
                                                    </button>'
                                    );
        }

        else
            $response = array('error' => $pedidos->errorInfo()[2]);
        
        echo json_encode($response);
    }

    //Consulta para obtener el detalle del pedido
    else 
        if($opcion == '2'){
            $id_pedido= (isset($_POST['id_pedido']) && !$_POST['id_pedido']=='') ? $_POST['id_pedido'] : NULL;

            $detallePedido= "SELECT a.id_articulo as clave, a.nombre as Articulo, dp.Cantidad, dp.costo, (dp.cantidad* dp.costo) as total 
                    from uni_pedido_articulo as dp 
                        inner join uni_articulos as a on dp.id_articulo= a.id_articulo 
                where id_pedido = :id_pedido";
                
                $pedido = $conn->prepare($detallePedido); 

                $pedido->bindparam(':id_pedido', $id_pedido);

                if($pedido->execute()){
                    while($p = $pedido->fetch(PDO::FETCH_ASSOC))
                     $response[]= $p;
                }

                else 
                    $response = array('error' => $pedido->errorInfo()[2]);

            echo json_encode($response);
        }
?>