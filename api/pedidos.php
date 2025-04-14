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
                                      'acciones' => '<button class="btn btn-success btnConcretar"
                                                                    data-id="'.$pedido['id_pedido'].'">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                     <button class="btn btn-danger btnCancelar"
                                                             data-id="'.$pedido['id_pedido'].'">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                    <button class="btn btn-primary btnVer"
                                                            data-id="'.$pedido['id_pedido'].'">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btnImprimir p-0 my-0 mx-1" 
                                                            data-id="'.$pedido['id_pedido'].'">
                                                        <i class="fas fa-print" style="font-size:20px; color:black; background-color:none"></i>
                                                    </button>'
                                    );
        }

        else
            $response = array('error' => $pedidos->errorInfo()[2]);
        
        echo json_encode($response);
    }

    //Obtener los datos de los articulos con los valores asociados en las demas tablas
    else 
        if ($opcion == '2'){
            $genero = isset($_POST['genero']) ? $_POST['genero'] : '';
            $categoria = isset($_POST['categoriaCat']) ? $_POST['categoriaCat'] : 0;
            $estado = isset($_POST['estado']) ? $_POST['estado'] : 0;
            $genero = isset($_POST['generoCat']) ? $_POST['generoCat'] : 0;

            //Cadenas con la condicion de filtrado para generar la consulta
            if($categoria != 0) 
                    $filtroCategoria= 'and a.id_categoria = '.$categoria;
            else 
                $filtroCategoria=' ';

            if($estado != 0) 
                    $filtroEstado= 'and e.id_estado = '.$estado;
    
            else
                $filtroEstado=' ';

            if($genero != 0) 
                    $filtroGenero= 'and g.id_genero = '.$genero;
            
            else 
                $filtroGenero=' ';                                                

            $sql='SELECT p.id_pedido, p.num_pedido, p.fecha_creacion, e.pedido_estado, d.nombre from uni_pedido as p 
                        inner join DIRECTORIO_0 AS d on p.id_usuario = d.ID
                        inner join uni_pedido_estado as e on p.status = e.id_estado
                    order by id_pedido';

            $articulosAlmacen = $conn->prepare($sql);

            if($articulosAlmacen->execute()) {
                while ($articulo = $articulosAlmacen->fetch(PDO::FETCH_ASSOC)) {
                        $articulos[] = array ( 'id_articulo' => $articulo['id_articulo'],
                        'nombre' => $articulo['nombre'],
                        'talla' => $articulo['talla'],
                        'genero' => $articulo['genero'],
                        'cant_fisica' => $articulo['cant. fisica'],
                        'estado' => $articulo['estado'],
                        'costo'=> $articulo['costo'],
                        'precio' => $articulo['precio'],
                        'stock_max' => $articulo['stock_max'],
                        'stock_min' => $articulo['stock_min'],
                        'acciones' =>   '<div class="d-flex flex-row">
                                            <button class="btn btn-action btn-editar"
                                                    data-bs-toggle="modal" 
                                                    data-id="'.$articulo['id_articulo'].'" 
                                                    style="color:green; background:none; font-size:20px;"
                                                    ><i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-action  btn-eliminar" 
                                                            data-id="'.$articulo['id_articulo'].'"
                                                            data-bs-toggle="modal" 
                                                        style="color:rgb(193, 0, 21); background-color:none; font-size:20px;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>');
                }
            }

            else 
                $articulos = array('error'=> $articulosAlmacen->errorInfo()[2] );

            
            echo json_encode($articulos);
        }
?>