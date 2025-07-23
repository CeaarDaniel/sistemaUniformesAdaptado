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
else 
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
else
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
else 
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

//REGISTRO DE UN GRUPO DE TALLAS Y UNA CATEGORIA
else 
    if($opcion == '5'){
        $abrev = (isset($_POST['abrev']) && !empty($_POST['abrev'])) ? $_POST['abrev'] : null; 
        $nombre = (isset($_POST['nombre']) && !empty($_POST['nombre'])) ? $_POST['nombre'] : null;
        $tipoTalla = (isset($_POST['tallas']) && $_POST['tallas'] != '') ? $_POST['tallas'] : null; // empty(0) = empty (null)

            //REGISTRO DE LAS TALLAS PARA EL NUEVO TIPO DE TALLA
           if (is_array(json_decode($tipoTalla, true))) {
                $tipoTalla = json_decode($tipoTalla, true);
                try {
                        $conn->beginTransaction();
                        // Obtener el último valor y calcular el siguiente tipo_talla
                        $lastValue = $conn->query("SELECT ISNULL(MAX(tipo_talla), 0) FROM uni_talla WITH (TABLOCKX)")->fetchColumn();
                        $newTalla = $lastValue + 1;

                        $stmt = $conn->prepare("INSERT INTO uni_talla(talla, tipo_talla) VALUES (?, ?)");

                        foreach ($tipoTalla as $item) {
                            $stmt->execute([
                                $item['label'],
                                $newTalla
                            ]);
                        }

                        $conn->commit();
                        $tipoTalla = $newTalla;
                } 
                catch (Exception $e) {
                    $conn->rollBack(); 
                    $respuesta = array("response" => "error: ".$e->getMessage());
                    die();
            }
        }

        //REGISTRO DE LA NUEVA CATEGORIA
        $registrarCategoria = "INSERT INTO uni_categoria(abrev, categoria, tipo_talla) 
                                    VALUES (:abrev, :categoria, :tipoTalla)";

        $stmt = $conn->prepare($registrarCategoria);

        $stmt->bindParam(':abrev',$abrev);
        $stmt->bindParam(':categoria',$nombre);
        $stmt->bindParam(':tipoTalla',$tipoTalla);

            // Ejecuta la consulta
            if ($stmt->execute()) 
                    $response = array('response' => 'Categoria registrada');
      
            else 
                $response = array('response' => $stmt->errorInfo()[2]);

        echo json_encode($response);
    }

//REGISTRO DE UN ARTICULO
else 
    if($opcion == '6'){
         $nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : null; 
         $clvComercial = (isset($_POST['clvComercial'])) ? $_POST['clvComercial'] : ''; 
         $descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
         $categoria = (isset($_POST['categoria'])) ? $_POST['categoria'] : null;
         $talla = (isset($_POST['talla'])) ? $_POST['talla'] : null;
         $genero = (isset($_POST['genero'])) ? $_POST['genero'] : null;
         $estado = (isset($_POST['estado'])) ? $_POST['estado'] : null;
         $costo = (isset($_POST['costo'])) ? $_POST['costo'] : null;
         $precio = (isset($_POST['precio'])) ? $_POST['precio'] : null;
         $stock_max = (isset($_POST['stock_max'])) ? $_POST['stock_max'] : null;
         $stock_min = (isset($_POST['stock_min'])) ? $_POST['stock_min'] : null;

         $activo = 1; 
         $eliminado = 0;
         $cantidad = 0;

         if($nombre === null || $categoria === null || $talla === null || $genero === null || $estado === null || $costo === null || $precio === null || $stock_max === null || $stock_min === null){
                $response = array('response' => "NO SE HAN COMPLETADO TODOS LOS CAMPOS");
                  echo json_encode($response);
                 exit();
         }

         $sql= 'INSERT INTO UNI_ARTICULOS (nombre, clave_comercial, descripcion, precio, costo, stock_max,
                                            stock_min, genero, cantidad, id_estado, id_talla, id_categoria, activo, eliminado) 
                VALUES(:nombre, :clave_comercial, :descripcion, :precio, :costo, :stock_max,
                        :stock_min, :genero, :cantidad, :id_estado, :id_talla, :id_categoria, :activo, :eliminado)';

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':nombre',$nombre);
        $stmt->bindParam(':clave_comercial',$clvComercial);
        $stmt->bindParam(':descripcion',$descripcion);
        $stmt->bindParam(':precio',$precio);
        $stmt->bindParam(':costo',$costo);
        $stmt->bindParam(':stock_max',$stock_max);
        $stmt->bindParam(':stock_min',$stock_min);
        $stmt->bindParam(':genero',$genero);
        $stmt->bindParam(':cantidad',$cantidad);
        $stmt->bindParam(':id_estado',$estado);
        $stmt->bindParam(':id_talla',$talla);
        $stmt->bindParam(':id_categoria',$categoria);
        $stmt->bindParam(':activo',$activo);
        $stmt->bindParam(':eliminado',$eliminado);

        if($stmt->execute()){ 
            $response = array("response" => "Articulo registrado correctamente");
        }

        else 
            $response = array("response" => $stmt->errorInfo()[2]);

        echo json_encode($response);
    }
?>