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

        $sql='SELECT a.id_articulo, a.nombre, u.talla, g.genero, a.cantidad as [cant. fisica], 
                    e.estado, a.costo, a.precio,  a.stock_max, a.stock_min  
                    from uni_articulos as a 
                        inner join uni_talla as u on a.id_talla = u.id_talla 
                        inner join uni_estado as e on a.id_estado = e.id_estado
                        inner join uni_genero as g on a.genero = g.id_genero
                    where 1=1 '.$filtroCategoria.' '.$filtroEstado.' '.$filtroGenero;

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

    //Consulta para obtener solamente los datos de un articulo
    else 
        if($opcion == '3'){
            $sql= "select id_articulo, nombre, clave_comercial, descripcion, precio, costo, stock_max, stock_min, cantidad from uni_articulos";
            $articulos = $conn->prepare($sql);

            if ($articulos ->execute()){
                while($articulo = $articulos->fetch(PDO::FETCH_ASSOC))
                    $response[] = $articulo;
            }

            else
                $response = array('error' => $articulos->errorInfo()[2]);
            
            echo json_encode($response);
        }
?>