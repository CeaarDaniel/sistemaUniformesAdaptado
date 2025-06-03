<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
include('./conexion.php'); 

$opcion = $_POST['opcion'];

function numeroALetras($numero) {
    $formatter = new NumberFormatter("es", NumberFormatter::SPELLOUT);
    $partes = explode(".", number_format($numero, 2, '.', ''));
    $entero = $formatter->format($partes[0]); 
    //Poner una condicion para que no agregue la parte decimal si es igual a cero
    $decimal = isset($partes[1]) ? $formatter->format($partes[1]) : "cero";
    return "$entero punto $decimal";
}

//CONSULTAS DE SALIDAS
    if($opcion == '1'){  
        $tipo = (isset($_POST['tipo']) && !$_POST['tipo']=='') ? $_POST['tipo'] : 0;
        $anio = (isset($_POST['anio']) && !$_POST['anio']=='') ? $_POST['anio'] : 0;
        $mes = (isset($_POST['mes']) && !$_POST['mes']=='') ? $_POST['mes'] : 0;
        $busquedaEmp = (isset($_POST['busquedaEmp']) && !$_POST['busquedaEmp']=='') ? $_POST['busquedaEmp'] : 0;
        

        //Cadenas con la condicion de filtrado para generar la consulta
        $filtroanio = ($anio != 0) ? ' AND YEAR(us.fecha) = :anio ' : '';
        $filtromes = ($mes != 0) ? ' AND MONTH(us.fecha) = :mes ' : '';
        $filtrotipo = ($tipo != 0) ? ' AND us.tipo_salida = :tipo ' : '';
        $filtrobusquedaEmp = ($busquedaEmp != 0) ? ' AND us.id_empleado = :empleado' : '';

        //$filtrotipoSalida = ($tipoSalida != 0) ? ' AND us.tipo_salida= :tipoSalida ' : ' ';
        //$filtroempleado = ($empleado != 0) ? ' AND us.id_empleado= :empleado ' : ' ';
        //$filtrousuario = ($usuario != 0) ? ' AND us.id_usuario = :usuario ' : ' ';
                            
        $sql= "SELECT us.id_salida, us.vale, FORMAT(us.fecha, 'yyyy-MM-dd HH:mm') AS fecha, ts.id_tipo_salida, ts.tipo_salida,  d.Nombre as realizado_por, e.id_usuario as NN, e.usuario as empleado, tv.nombre
                    FROM uni_salida as us 
                left join DIRECTORIO_0 AS d on us.id_usuario = d.ID
                left join (select id_usuario, usuario from empleado group by id_usuario, usuario) as e on us.id_empleado = e.id_usuario
                left join uni_tipo_salida as ts on us.tipo_salida = ts.id_tipo_salida
				left join (select tipo_vale,barcode from uni_vale group by tipo_vale, barcode) as uv on us.vale = uv.barcode 
				left join uni_tipo_vale as tv on uv.tipo_vale = tv.id_tipo_vale WHERE 1=1 ".$filtrotipo." ".$filtrobusquedaEmp." ".$filtroanio." ".$filtromes." ";
        $salidas = $conn->prepare($sql);

         ($anio != 0) ? $salidas->bindparam(':anio', $anio) : '';
         ($mes != 0) ? $salidas->bindparam(':mes', $mes) : '';
         ($tipo != 0) ? $salidas->bindparam(':tipo',$tipo ) : '';
         ($busquedaEmp != 0) ? $salidas->bindparam(':empleado', $busquedaEmp ) : '';

            if($salidas->execute()){
                while($salida = $salidas->fetch(PDO::FETCH_ASSOC))
                    $response[] = array('id_salida' => $salida['id_salida'],
                                        'fecha' => $salida['fecha'],
                                        'tipo_salida' => $salida['tipo_salida'] ,
                                        'realizado_por' => $salida['realizado_por'],
                                        'empleado' => $salida['empleado'],
                                        'acciones' => '<button class="btn btnCambiar" onclick="cargarRuta(`cambios`, '.$salida['id_salida'].')"
                                                                            data-id="'.$salida['id_salida'].'">
                                                                    <i class="fas fa-exchange-alt" style="font-size:20px; color:green; background-color:none"></i>
                                                        </button>
                                                        <button class="btn btnVer"
                                                                data-id="'.$salida['id_salida'].'"
                                                                data-salidaFecha="'.$salida['fecha'].'"
                                                                data-salidaIdTipo="'.$salida['id_tipo_salida'].'"
                                                                data-salidaTipo="'.$salida['tipo_salida'].'"
                                                                data-salidaRealizadoPor="'.$salida['realizado_por'].'"
                                                                data-salidaEmpleado="'.$salida['empleado'].'"
                                                                data-salidaVale = "'.$salida['vale'].'"
                                                                data-tipoVale = "'.$salida['nombre'].'"
                                                                >
                                                            <i class="fas fa-eye" style="font-size:20px; color:blue; background-color:none"></i>
                                                        </button>
                                                        <button class="btn btnImprimir p-0 my-0 mx-1" 
                                                                data-id="'.$salida['id_salida'].'"
                                                                data-salidaFecha="'.$salida['fecha'].'"
                                                                data-salidaIdTipo="'.$salida['id_tipo_salida'].'"
                                                                data-salidaTipo="'.$salida['tipo_salida'].'"
                                                                data-salidaRealizadoPor="'.$salida['realizado_por'].'"
                                                                data-salidaEmpleado="'.$salida['empleado'].'"
                                                                data-salidaVale = "'.$salida['vale'].'"
                                                                data-tipoVale = "'.$salida['nombre'].'"
                                                                data-NN = "'.$salida['NN'].'"
                                                                >
                                                            <i class="fas fa-print" style="font-size:20px; color:black; background-color:none"></i>
                                                        </button>');
            }

            else 
                $response = $salidas->errorInfo()[2];

        echo json_encode($response);
    }

    //DETALLE DE SALIDA
    else 
        if($opcion == '2'){
            $id_salida= (isset($_POST['id_salida']) && !$_POST['id_salida']=='') ? $_POST['id_salida'] : NULL;

            $detalleSalida= "SELECT usa.id_articulo, usa.cantidad, ua.nombre, usa.precio, (usa.cantidad * usa.precio) as total  
                                from uni_salida as us left join uni_salida_articulo as usa on us.id_salida = usa.id_salida 
                                        left join uni_articulos as ua on usa.id_articulo = ua.id_articulo
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
    
    //CONSULTAS DE VENTAS
    else 
      if($opcion == '3'){
            $anio = (isset($_POST['anio']) && !$_POST['anio']=='') ? $_POST['anio'] : 0;
            $mes = (isset($_POST['mes']) && !$_POST['mes']=='') ? $_POST['mes'] : 0;

            //Cadenas con la condicion de filtrado para generar la consulta
            $filtroanio = ($anio != 0) ? ' AND YEAR(uv.fecha) = :anio ' : '';
            $filtromes = ($mes != 0) ? ' AND MONTH(uv.fecha) = :mes ' : '';

            $sql = "SELECT id_venta, e.id_usuario, FORMAT(fecha, 'yyyy-MM-dd HH:mm') as fecha, e.usuario, pago_total, 
						num_descuentos, (ISNULL(CASE WHEN uv.check_1 = 1 THEN 1 ELSE 0 END, 0) +
										 ISNULL(CASE WHEN uv.check_2 = 1 THEN 1 ELSE 0 END, 0) +
										 ISNULL(CASE WHEN uv.check_3 = 1 THEN 1 ELSE 0 END, 0) +
										 ISNULL(CASE WHEN uv.check_4 = 1 THEN 1 ELSE 0 END, 0)) AS aplicados, firma, SUM(pago_total) OVER () as total
					from uni_venta as uv left join (select id_usuario, usuario from empleado group by id_usuario, usuario) 
					as e on uv.id_empleado = e.id_usuario WHERE 1=1  ".$filtroanio." ".$filtromes." 
				  order by uv.num_descuentos";

        $ventas = $conn->prepare($sql);
        $response= array();

        ($anio != 0) ? $ventas->bindparam(':anio', $anio) : '';
        ($mes != 0) ? $ventas->bindparam(':mes', $mes) : '';
        //$ventas->bindparam(':id_salida', $id_salida);

                if($ventas->execute()){
                    while($venta = $ventas->fetch(PDO::FETCH_ASSOC)) {

                      $text = ($venta['num_descuentos'] > $venta['aplicados']) ? "text-danger" : "text-success";
                      $response[]= array('id_venta' => $venta['id_venta'],
                                        'fecha' => $venta['fecha'],
                                        'empleado' => $venta['usuario'],
                                        'pago_total' => $venta['pago_total'],
                                        'num_descuentos' => $venta['num_descuentos'],
                                        'aplicados' => $venta['aplicados'], 
                                        'total' => $venta['total'],
                                        'concretar' => '<button class="btn btnConcretar" 
                                                                       data-id="'.$venta['id_venta'].'"
                                                                       data-empleado="'.$venta['usuario'].'"
                                                                       data-fecha="'.$venta['fecha'].'"
                                                                       data-costo="'.$venta['pago_total'].'"
                                                                       data-descuentos="'.$venta['num_descuentos'].'">
                                                                <i class="fas fa-check-circle '.$text.' " style="font-size:24px;"></i>
                                                            </button>',
                                        'firma' => '<button class="btn btnFirma btn-sm btn-primary" 
                                                                   data-id="'.$venta['id_venta'].'" 
                                                                   data-NN="'.$venta['id_usuario'].'" 
                                                                   data-firma="'.$venta['firma'].'"
                                                                   data-fecha="'.$venta['fecha'].'"
                                                                   data-empleado="'.$venta['usuario'].'"
                                                                   data-costo="'.$venta['pago_total'].'"
                                                                   data-costoTexto="'.numeroALetras($venta['pago_total']).'"
                                                                   >
                                                        <i class="fas fa-signature" style="font-size:20px;"></i>
                                                    </button>');
                    }
                }

                else 
                    $response = array('error' => $ventas->errorInfo()[2]);

            echo json_encode($response);

    }

    //CONSULTA PARA OBTENER LOS DESCUENTOS CONCRETADOS EL NUMERO DE DESCUENTOS Y FECHA DE LA VENTA
    else 
        if($opcion == '4'){
            $id_venta= (isset($_POST['id_venta']) && !$_POST['id_venta']=='') ? $_POST['id_venta'] : NULL;

            $sql = "SELECT id_venta, check_nombre, check_valor, fechaC, descuento
                        FROM uni_venta
                        CROSS APPLY (
                                        VALUES
                                            ('check_1', check_1, fecha_1, descuento_1),
                                            ('check_2', check_2, fecha_2, descuento_2),
                                            ('check_3', check_3, fecha_3, descuento_3),
                                            ('check_4', check_4, fecha_4, descuento_4)
                                    ) AS datos(check_nombre, check_valor, fechaC, descuento)
                        where id_venta = :id_venta;";


            $descuentos = $conn->prepare($sql);
            $response= array();

            $descuentos->bindparam(':id_venta', $id_venta);

                if($descuentos->execute()){
                    while($descuento = $descuentos->fetch(PDO::FETCH_ASSOC)) {
                        $response[] = $descuento;
                    }
                }

                else 
                    $response = array('error' => $ventas->errorInfo()[2]);

            echo json_encode($response);
        }

    //CONSULTA PARA ACTUALIZAR LOS ESTATUS DE LOS DESCUENTOS DE UNA VENTA
    else 
        if($opcion == '5'){
            $id_venta= (isset($_POST['id_venta']) && !$_POST['id_venta']=='') ? $_POST['id_venta'] : NULL;
            $fecha_valor= (isset($_POST['fecha']) && !$_POST['fecha']=='') ? (new DateTime($_POST['fecha']))->format('Y-m-d H:i') : NULL;
            $check= (isset($_POST['check']) && !$_POST['check']=='') ? $_POST['check'] : 0;


            $partes = explode("_", $check); // Divide la cadena por el guion bajo "_" 
            $fecha_nombre = "fecha_".$partes[1]; // Accede a la segunda parte (índice 1) y la convierte a número

            $sql = "UPDATE uni_venta set ".$check." = 1, ".$fecha_nombre." = :fecha where id_venta= :id_venta";

            $updateVenta = $conn->prepare($sql);
            $response= array();

            $updateVenta->bindparam(':id_venta', $id_venta);
            $updateVenta->bindparam(':fecha', $fecha_valor);

                if($updateVenta->execute()){
                        $response = array('ok' => true);
                }

                else 
                    $response = array(  'ok' => false,
                                        'error' => $ventas->errorInfo()[2]);

            echo json_encode($response);
    }

    //CONSULTA PARA OBTENER LAS GANANCIAS Y VENTAS POR CATEGORIAS
    else 
    if($opcion == '6'){
        $anio= (isset($_POST['anio']) && !$_POST['anio']=='') ? $_POST['anio'] : 0;
        $mes= (isset($_POST['mes']) && !$_POST['mes']=='') ? $_POST['mes'] : 0;

         $filtromes = ($mes != 0) ? ' AND MONTH(uv.fecha) = :mes ' : '';
         $filtroanio = ($anio != 0) ? ' AND YEAR(uv.fecha) = :anio ' : '';

        $sql= "SELECT uc.categoria, 
                    AVG(ISNULL(uva.costo, 0)) as costoPromedio, 
                    SUM(uva.precio * uva.cantidad) costoVenta, 
                    SUM(uva.costo * uva.cantidad) as costoCompra,
                    ( SUM(uva.precio * uva.cantidad) - SUM(uva.costo * uva.cantidad)) as gananciaPorCategoria,
                    SUM(SUM(uva.precio * uva.cantidad) - SUM(uva.costo * uva.cantidad)) over () as gananciaTotal
                from uni_venta_articulo as uva 
                        inner join uni_articulos as ua on uva.id_articulo = ua.id_articulo
                        inner join uni_categoria as uc on ua.id_categoria = uc.id_categoria 
                        left join uni_venta as uv on uv.id_venta =uva.id_venta
                            WHERE 1=1 ".$filtromes." ".$filtroanio."
                    group by categoria 
                order by categoria";

        $ganVenCat = $conn->prepare($sql);
        $response= array();

         ($mes != 0 && $mes != null) ? $ganVenCat->bindparam(':mes', $mes) : '';
        ($anio != 0 && $anio != null) ? $ganVenCat->bindparam(':anio', $anio) : '';

        //$updateVenta->bindparam(':id_venta', $id_venta);
        //$updateVenta->bindparam(':fecha', $fecha_valor);

            if($ganVenCat->execute()){
                while($row = $ganVenCat->fetch(PDO::FETCH_ASSOC)) {
                    $response[] = $row;
                }
            }

            else 
                $response = array(  'ok' => false,
                                    'error' => $ganVenCat->errorInfo()[2]);

        echo json_encode($response);
    }

    //CONSULTA PARA OBTENER LAS VENTAS CON LOS PROMEDIOS
    else 
        if($opcion=='7'){
            $grupoFecha = (isset($_POST['grupoFecha']) && !empty($_POST['grupoFecha'])) ? $_POST['grupoFecha'] : '';
            $mes = (isset($_POST['mes']) && !empty($_POST['mes'])) ? $_POST['mes'] : 0;
            $anio = (isset($_POST['anio']) && !empty($_POST['anio'])) ? $_POST['anio'] : 0;

            $filtromes = ($mes != 0) ? ' AND MONTH(fecha) = :mes ' : '';
            $filtroanio = ($anio != 0) ? ' AND YEAR(fecha) = :anio ' : '';

            $sql="SELECT count(id_venta) as numVentas, 
                         sum(pago_total) as ventasTotales, 
                         AVG(isNULL(pago_total,0)) AS ventasPromeio 
                    from uni_venta WHERE 1=1 ".$filtromes." ".$filtroanio;

            $ventasSql = "SELECT FORMAT(fecha, '".$grupoFecha."') as fecha, SUM(pago_total) as ventaTotal, SUM( SUM(pago_total)) over () AS ventasTotales
                                from uni_venta WHERE 1=1 ".$filtromes." ".$filtroanio."
                            group by  FORMAT(fecha, '".$grupoFecha."') order by fecha";

             $ventas = $conn->prepare($sql);
             $listaVEntas = $conn->prepare($ventasSql);
             $listaVEntasResponse;

            ($mes != 0) ? $ventas->bindparam(':mes', $mes) : '';
            ($anio != 0) ? $ventas->bindparam(':anio', $anio) : '';


            ($mes != 0) ? $listaVEntas->bindparam(':mes', $mes) : '';
            ($anio != 0) ? $listaVEntas->bindparam(':anio', $anio) : '';

                if($ventas->execute()){
                    $promedio = $ventas->fetch(PDO::FETCH_ASSOC);
                        $response = array('promedio' => $promedio);
                }

                else 
                    $response = array( 'error' => $ventas->errorInfo()[2]);

                if($listaVEntas->execute()){
                    while($venta = $listaVEntas->fetch(PDO::FETCH_ASSOC)) {
                        $listaVEntasResponse[] = $venta;
                    }

                    $response['ventas'] = $listaVEntasResponse;
                }

                else 
                    $response = array( 'error' => $listaVEntasResponse->errorInfo()[2]);

            echo json_encode($response);
        }

    //CONSULTA PARA LA SECCION DE INVENTARIOS
    else 
        if($opcion=='8'){
            $categoria = (isset($_POST['categoria']) && !empty($_POST['categoria'])) ? $_POST['categoria'] : 0;

            $filtroCategoria = ($categoria != 0) ? ' AND ua.id_categoria = :categoria ' : '';
            
             $sql= "SELECT ua.id_articulo, ua.nombre, ua.costo, ua.precio, ua.cantidad, ua.stock_min, ua.stock_max 
					        from uni_articulos ua 
                        inner join uni_categoria as uc 
                    on ua.id_categoria = uc.id_categoria AND 1=1 ".$filtroCategoria;

            $inventario = $conn->prepare($sql);
            ($categoria != 0) ? $inventario->bindparam(':categoria', $categoria) : '';
             $response= array();

            if($inventario->execute()){
                    while($inv = $inventario->fetch(PDO::FETCH_ASSOC)) {
                        $response[] = $inv;
                    }
                }

            else 
                $response = array( 'error' => $inventario->errorInfo()[2]);

            echo json_encode($response);
    }

    //CONSULTA PARA OBTENER EL DETALLE DE LA VENTA PARA LA IMPRESION DE LA CARTA DE ACEPTACION DE DESCUENTO
    else 
        if ($opcion == '9'){
            $id_venta = (isset($_POST['id_venta']) && !$_POST['id_venta']=='') ? $_POST['id_venta'] : NULL;
            $sql = "SELECT ua.nombre, uva.id_venta, uva.cantidad, uva.precio, uva.costo 
                            from uni_venta_articulo uva 
                        inner join uni_articulos  ua on uva.id_articulo = ua.id_articulo
                    where id_venta = :id_venta";

            $salidas = $conn->prepare($sql); 

            $salidas->bindparam(':id_venta', $id_venta);

            if($salidas->execute()){
                while($salida = $salidas->fetch(PDO::FETCH_ASSOC))
                    $response[]= $salida;
            }

            else 
                $response = array('error' => $salidas->errorInfo()[2]);

            echo json_encode($response);
    }
?>