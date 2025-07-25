<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
include('./conexion.php'); 


$opcion = $_POST['opcion'];

    //Obtener los datos de los articulos con los valores asociados en las demas tablas
    if ($opcion == '1'){
        $categoria = isset($_POST['categoriaCat']) ? $_POST['categoriaCat'] : 0;
        $estado = isset($_POST['estado']) ? $_POST['estado'] : 0;
        $genero = isset($_POST['generoCat']) ? $_POST['generoCat'] : 0;
        $cont = 0;

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

        $sql="SELECT a.id_articulo, a.nombre, u.talla, g.genero, a.cantidad as [cant. fisica], 
                     isNULL(cantTran, 0) as cantTran, (isNULL ((a.cantidad + cantTran), 0)) as total,
                     a.costo, a.precio,  a.stock_max, a.stock_min
                    from uni_articulos as a 
                        inner join uni_talla as u on a.id_talla = u.id_talla 
                        inner join uni_estado as e on a.id_estado = e.id_estado
                        inner join uni_genero as g on a.genero = g.id_genero
                        left join ( select distinct(id_articulo) as id_articulo, SUM(cantidad) as cantTran from uni_pedido as up 
										inner join uni_pedido_articulo as upa on up.id_pedido = upa.id_pedido 
									where status='2' group by id_articulo) as atr on a.id_articulo= atr.id_articulo
                    where a.activo = 1 and 1=1 ".$filtroCategoria." ".$filtroEstado." ".$filtroGenero;

        $articulosAlmacen = $conn->prepare($sql);

        if($articulosAlmacen->execute()) {
            while ($articulo = $articulosAlmacen->fetch(PDO::FETCH_ASSOC)) {
                    $articulos[] = array ( 'id_articulo' => $articulo['id_articulo'],
                    'nombre' => $articulo['nombre'],
                    'talla' => $articulo['talla'],
                    'genero' => $articulo['genero'],
                    'cantFisica' => $articulo['cant. fisica'],
                    'cantTran' => $articulo['cantTran'],
                    'total' => $articulo['total'],
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
                $cont++;
            }

            /* Valores para el valor devuelto en caso de que no haya ninguna consulta que cumpla con las condiciones de los filtros
                if($cont <= 0) {
                    $articulos[] = array ( 'id_articulo' => '',
                                            'nombre' => '',
                                            'talla' => '',
                                            'genero' => '',
                                            'cant_fisica' => '',
                                            'estado' => '',
                                            'costo'=> '',
                                            'precio' => '',
                                            'stock_max' => '',
                                            'stock_min' => '',
                                            'acciones' =>   ''
                                            ); 
                    } //Se puede hacer eso o se puede hacer un catch en el archivo js y omitir o comentar estas lineas en el arvhico php,
            */
        }

        else 
            $articulos = array('error'=> $articulosAlmacen->errorInfo()[2] );

           
        echo json_encode($articulos);
    }

    //Obtneer los datos de un articulo 
     else
    if($opcion == '2'){
        $id_articulo = $_POST['id_articulo'];

        $sql= 'SELECT a.id_articulo, a.nombre, c.categoria, t.talla, g.genero, a.descripcion, a.costo, a.precio, a.stock_min, a.stock_max
		            from uni_articulos as a inner join uni_categoria as c on a.id_categoria=c.id_categoria 
								inner join uni_genero as g on a.genero=g.id_genero 
								inner join uni_talla as t on a.id_talla = t.id_talla  where id_articulo = :id_articulo';
        $articulo = $conn->prepare($sql);
        $articulo->bindparam(':id_articulo', $id_articulo);

        if($articulo->execute()){
            $articuloC = $articulo->fetch(PDO::FETCH_ASSOC);
            echo json_encode ($articuloC);
        }

        else {
            $response = array('error'=> $articulo->errorInfo()[2]);
            echo json_encode ($response);
        }
        
    }

    //Consulta para obtener solamente los datos de los articulos
     else 
        if($opcion == '3'){
            $sql= "SELECT id_articulo, nombre, clave_comercial, descripcion, precio, costo, stock_max, stock_min, cantidad 
                    from uni_articulos WHERE activo = 1";
            $articulos = $conn->prepare($sql);

            if ($articulos ->execute()){
                while($articulo = $articulos->fetch(PDO::FETCH_ASSOC))
                    $response[] = $articulo;
            }

            else
                $response = array('error' => $articulos->errorInfo()[2]);
            
            echo json_encode($response);
        }

    //Actualizar los datos de un articulo del almacen
     else 
        if($opcion == '4'){
            $costo = (isset($_POST['costo'])) ? $_POST['costo'] : null; 
            $precio = (isset($_POST['precio'])) ? $_POST['precio'] : null; 
            $cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : null; 
            $stock_max = (isset($_POST['stock_max'])) ? $_POST['stock_max'] : null; 
            $stock_min = (isset($_POST['stock_min'])) ? $_POST['stock_min'] : null;
            $id_articulo = (isset($_POST['id_articulo'])) ? $_POST['id_articulo'] : ''; 
            $descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : null; 
            $clave_comercial = (isset($_POST['clave_comercial'])) ? $_POST['clave_comercial'] : null; 

            $campos;

            ($costo) ? $campos[] = 'costo = :costo' : '';
            ($precio) ? $campos[] = 'precio = :precio' : '';
            ($cantidad) ? $campos[] = 'cantidad = :cantidad' : '';
            ($stock_max) ? $campos[] = 'stock_max = :stock_max' : '';
            ($stock_min) ? $campos[] = 'stock_min = :stock_min' : '';
            ($descripcion) ? $campos[] = 'descripcion = :descripcion' : '';
            ($clave_comercial) ? $campos[] = 'clave_comercial = :clave_comercial' : '';

            /*
                $datos = [
                        'descripcion' => $descripcion,
                        'costo' => $costo,
                        'precio' => $precio,
                        'stock_max' => $stock_max,
                        'stock_min' => $stock_min
                    ];

                    $campos = [];

                    // se toma el valor de la clave y el valor asociado
                    foreach ($datos as $campo => $valor) {
                        if (!empty($valor)) {
                            $campos[] = "$campo = :$campo";
                        }
                    }
            */

            if (!empty($campos)) {
                 $sql = 'UPDATE uni_articulos set '.implode(', ', $campos).' WHERE id_articulo = :id_articulo';

                 $update = $conn->prepare($sql);

                  ($costo) ? $update->bindparam(':costo', $costo) : '';
                  ($cantidad) ? $update->bindparam(':cantidad', $cantidad) : '';
                  ($precio) ? $update->bindparam(':precio', $precio) : '';
                  ($stock_max) ? $update->bindparam(':stock_max', $stock_max) : '';
                  ($stock_min) ? $update->bindparam(':stock_min', $stock_min) : '';
                  ($descripcion) ? $update->bindparam(':descripcion', $descripcion) : '';
                  ($clave_comercial) ? $update->bindparam(':clave_comercial', $clave_comercial) : '';
                  $update->bindparam(':id_articulo', $id_articulo);

                 if($update->execute())
                     $response = array("response" => 'se ha actualizado la información del articulo',
                                       'modificado' => true);

                 else
                     $response = array('response'=> $update->errorInfo()[2], 
                                       'modificado' => false);
            }

            else 
                 $response = array('response'=> "Debe ingresar al menos un valor válido para actualizar el registro. La actualización no se realiza si el campo está vacío, en blanco, o con valor de 0",
                                    'modificado' => false);

            echo json_encode ($response);
        }

     //Eliminar un articulo del almacen
     else 
        if($opcion == '5'){
            $id_articulo = (isset($_POST['id_articulo'])) ? $_POST['id_articulo'] : null;
            $sql = 'UPDATE uni_articulos set activo=0, eliminado = 1  WHERE id_articulo = :id_articulo';

            $update = $conn->prepare($sql);
            $update->bindparam(':id_articulo', $id_articulo);

                if($update->execute())
                    $response = array("response" => 'se a dado de baja el articulo');

                else
                    $response = array('response'=> $update->errorInfo()[2]);
           

            echo json_encode ($response);       
        }
?>