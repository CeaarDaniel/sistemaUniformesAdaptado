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

        $detalleSalida= "SELECT usa.id_articulo, usa.cantidad, ua.nombre, ua.id_categoria, ut.talla, usa.precio, (usa.cantidad * usa.precio) as total  
                            from uni_salida as us 
                                left join uni_salida_articulo as usa on us.id_salida = usa.id_salida 
                                left join uni_articulos as ua on usa.id_articulo = ua.id_articulo
                                left join uni_talla as ut on ua.id_talla = ut.id_talla
                            where us.id_salida =  :id_salida";
            
            $salidas = $conn->prepare($detalleSalida); 

            $salidas->bindparam(':id_salida', $id_salida);

            if($salidas->execute()){
                while($salida = $salidas->fetch(PDO::FETCH_ASSOC)) {
                     $salida['agregado'] = false;
                    $response[]= $salida;
                } 
            }

            else 
                $response = array('error' => $salidas->errorInfo()[2]);

        echo json_encode($response);
    }
    
//REGISTRO DE ENTRADA POR CAMBIO
else 
    if($opcion == '2'){
        $articulosEntrada = (isset($_POST['articulosEntrada']) && !empty($_POST['articulosEntrada']) ) ? $_POST['articulosEntrada'] : '';
        $articulosSalida = (isset($_POST['articulosSalida']) && !empty($_POST['articulosSalida']) ) ? $_POST['articulosSalida'] : '';
        $idUsuario = 96;
        $tipoEntrada = (isset($_POST['tipoEntrada']) && !empty($_POST['tipoEntrada']) ) ? $_POST['tipoEntrada'] : '';
        $idEmpleado = (isset($_POST['idEmpleado']) && !empty($_POST['idEmpleado']) ) ? $_POST['idEmpleado'] : '';
        $fecha = date("Y-m-d H:i:s");

         if (is_array(json_decode($articulosSalida, true)) && is_array(json_decode($articulosEntrada, true))) {
                $articulosSalida = json_decode($articulosSalida, true);
                $articulosEntrada = json_decode($articulosEntrada, true);

                try {
                        $conn->beginTransaction();

                            $stmt1 = $conn->prepare("INSERT INTO uni_entrada(fecha, tipo_entrada, id_usuario) 
                                                    VALUES (:fecha, :tipoEntrada, :idUsuario)");
                            $stmt1->execute([
                                ':fecha' => $fecha,
                                ':tipoEntrada' => $tipoEntrada,
                                ':idUsuario' => $idUsuario
                            ]);

                             $idEntrada = $conn->lastInsertId();

                            $stmt2 = $conn->prepare("INSERT INTO uni_entrada_articulo(id_entrada, id_articulo, cantidad) 
                                                        VALUES (?, ?, ?)");

                            $i=0;
                            foreach ($articulosEntrada as $item) {
                                 
                                $detalle = $articulosSalida[$i];
                                $stmt2->execute([
                                    $idEntrada,
                                    $item,
                                    $detalle['cantidad']
                                ]);
                                $i++;
                            }

                            $stmt3 = $conn->prepare("INSERT INTO uni_salida(fecha, tipo_salida, id_usuario, id_empleado) 
                                                    VALUES(:fecha, :tipoEntrada, :idUsuario, :idEmpleado)");
                            $stmt3->execute([
                                ':fecha' => $fecha,
                                ':tipoEntrada' => $tipoEntrada,
                                ':idUsuario' => $idUsuario,
                                ':idEmpleado' => $idEmpleado
                            ]);

                             $idSalida = $conn->lastInsertId();

                            $stmt4 = $conn->prepare("INSERT INTO uni_salida_articulo(id_salida, id_articulo, cantidad, precio) 
                                                        VALUES (?, ?, ?, ?)");

                            foreach ($articulosSalida as $item) {
                                $stmt4->execute([
                                    $idSalida,
                                    $item['id_articulo'],
                                    $item['cantidad'],
                                    $item['precio'],
                                ]);
                            }

                             $stmt5 = $conn->prepare("UPDATE uni_articulos SET cantidad = uni_articulos.cantidad + ea.cantidad 
                                                        from uni_entrada_articulo ea
                                                            WHERE ea.id_entrada = :idEntrada");
                        
                                $stmt5->execute([
                                    ':idEntrada' => $idEntrada,
                                ]);

                             $stmt6 = $conn->prepare("UPDATE uni_articulos SET cantidad = uni_articulos.cantidad - sa.cantidad 
                                                        from uni_salida_articulo sa
                                                            WHERE sa.id_salida = :idSalida");
                        
                                $stmt6->execute([
                                    ':idSalida' => $idSalida,
                                ]);
                            

                        $conn->commit();
                        $respuesta = array('response' => 'Se ha echo el cambio');

                    } catch (Exception $e) {
                        $conn->rollBack();
                        $respuesta = array('response' => $e->getMessage());
                    }
            }

        else 
            $respuesta = array('response' => 'Datos invalidos');
        

        echo json_encode($respuesta);
    }
?>