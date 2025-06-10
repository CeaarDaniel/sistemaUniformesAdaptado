<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
include('./conexion.php'); 

$opcion = $_POST['opcion'];


// OBTENER LOS DATOS DE LAS VENTAS Y ARTICULOS DE VANTAS 
    if ($opcion=='1'){
        //VARIABLES PARA LOS FILTROS DE BUSQUEDA 
        $categoria = (isset($_POST['categorySelect']) && !$_POST['categorySelect']=='') ? $_POST['categorySelect'] : 0; 
        $usuario =  (isset($_POST['userSelect']) && !$_POST['userSelect']=='' ) ? $_POST['userSelect'] :  0; //USUARIO QUIEN REGISTRO LA VENTA
        $empleado = (isset($_POST['employeeInput']) && !$_POST['employeeInput']=='' ) ? $_POST['employeeInput'] :  0;
        $reportType = (isset($_POST['reportType']) && !$_POST['reportType']=='') ? $_POST['reportType'] : '';

        $startDate = (isset($_POST['startDate']) && !$_POST['startDate']=='') ? (new DateTime($_POST['startDate']))->format('Y-m-d') : 0;
        $endDate = (isset($_POST['endDate']) && !$_POST['endDate']=='') ? (new DateTime($_POST['endDate']))->format('Y-m-d') : 0;

        if($categoria != 0) 
            $filtrocategoria = ' AND a.id_categoria = :categoria';
        else 
            $filtrocategoria = ' ';

        if($usuario != 0) 
            $filtrousuario = ' AND v.id_usuario = :usuario ';
        else 
            $filtrousuario = ' ';

        if($empleado != 0) 
            $filtroempleado = ' AND v.id_empleado = :empleado ';
        else 
            $filtroempleado = ' ';

        if($startDate != 0 && $endDate != 0){
            $filtroFecha = ' AND v.fecha between :startDate and :endDate ';
        }

        else {
            $filtroFecha = '';
        } 


        if ($reportType=='1'){
                $sql= "SELECT v.id_venta, FORMAT(v.fecha, 'yyyy-MM-dd HH:mm') as fecha, e.usuario as EMPLEADO, dr.Nombre as USUARIO, v.pago_total from uni_venta as v 
                            inner join (SELECT
                                                MIN(id_usuario) AS id_usuario,
                                                MIN(usuario) AS usuario
                                        FROM empleado
                                        GROUP BY id_usuario) as e on v.id_empleado = e.id_usuario
                            left join DIRECTORIO_0 as dr on v.id_usuario= dr.ID
                            left join uni_venta_articulo as va on v.id_venta = va.id_venta
                            left join uni_articulos as a  on va.id_articulo = a.id_articulo 
                                WHERE 1=1 ".$filtrocategoria."  ".$filtrousuario."  ".$filtroempleado." ".$filtroFecha." 
                        group by v.id_venta, v.fecha, e.usuario, dr.Nombre, v.pago_total ";
        }

        else 
        if($reportType=='2'){
                $sql= "SELECT va.id_articulo, a.nombre, sum(va.cantidad) as cantidad from uni_venta_articulo va 
                                inner join uni_articulos as a on va.id_articulo = a.id_articulo
                                left join uni_venta as v on v.id_venta= va.id_venta
                            WHERE 1=1 ".$filtrocategoria."  ".$filtrousuario."  ".$filtroempleado." ".$filtroFecha."
                            group by va.id_articulo, a.nombre
                        ORDER BY va.id_articulo";
        } 

        $ventas = $conn->prepare($sql);
        if($categoria != 0) 
            $ventas->bindparam(':categoria', $categoria);

        if($usuario != 0) 
            $ventas->bindparam(':usuario', $usuario);

        if($empleado != 0) 
            $ventas->bindparam(':empleado', $empleado);

            
        if($startDate != 0 && $endDate != 0){
            $ventas->bindparam(':startDate', $startDate);
            $ventas->bindparam(':endDate', $endDate);
        }


        $response= array();

        if($ventas -> execute()){
            while($venta= $ventas->fetch(PDO::FETCH_ASSOC))
                $response[] = $venta;
        }

        else 
            $response = $ventas->errorInfo()[2];

        echo json_encode($response);
    }

//OPCION PARA TRAER LOS ARTICULOS DE CADA VENTA
    else
    if($opcion == '2'){
        $idVenta = (isset($_POST['idVenta']) && !$_POST['idVenta']=='') ? $_POST['idVenta'] : NULL;

        $sql= 'SELECT uva.id_venta, uva.id_articulo, ua.nombre, uva.cantidad, uva.precio, uva.costo from uni_venta_articulo as uva 
                    inner join uni_articulos as ua on uva.id_articulo = ua.id_articulo
                WHERE id_venta = :idVenta'; 

        $articulos = $conn->prepare($sql);
        $articulos->bindparam(':idVenta', $idVenta);
        $response = array();

            if($articulos->execute()){
                while($articulo = $articulos->fetch(PDO::FETCH_ASSOC))
                    $response[] = $articulo;
            }

            else 
            $response = $articulos->errorInfo()[2];

        echo json_encode($response);
        
    }

    else 
    if($opcion == '3'){ 
        $existencia = (isset($_POST['existencia']) && !$_POST['existencia']=='') ? $_POST['existencia'] : 0;
        $genero = (isset($_POST['genero']) && !$_POST['genero']=='') ? $_POST['genero'] : 0;
        $categoria = (isset($_POST['categoria']) && !$_POST['categoria']=='') ? $_POST['categoria'] : 0;
        $estado = (isset($_POST['estado']) && !$_POST['estado']=='') ? $_POST['estado'] : 0;
        $filtroExistencia ='';

        if($existencia == 2)
            $filtroExistencia =' AND cantidad > 0 ';

        else 
            if($existencia == 3)
                $filtroExistencia= ' AND cantidad < 1 '; 

        else if($existencia == 1)
            $filtroExistencia = '';

            $filtroGenero = ($genero != 0) ? 'AND genero = :genero' : ' ';
            $filtroCategoria = ($categoria != 0) ? 'AND id_categoria = :id_categoria' : ' ';
            $filtroEstado = ($estado != 0) ? 'AND id_estado = :id_estado' : ' ';

        $sql = 'SELECT id_articulo, nombre, stock_min, stock_max, cantidad from uni_articulos WHERE 1=1 '.$filtroExistencia.' '.$filtroGenero.' '.$filtroCategoria.' '.$filtroEstado.' ';
        $articulos = $conn->prepare($sql);

        ($genero != 0) ? $articulos->bindparam(':genero', $genero) : '';
        ($categoria != 0) ? $articulos->bindparam(':id_categoria', $categoria) : '';
        ($estado != 0) ? $articulos->bindparam(':id_estado', $estado) : '';

        $response = array();

        if($articulos->execute()){
            while($articulo = $articulos->fetch(PDO::FETCH_ASSOC))
                    $response[] = array('ID' => $articulo['id_articulo'],
                                        'NOMBRE' => $articulo['nombre'],
                                        'Stock min' => $articulo['stock_min'],
                                        'Stock max' => $articulo['stock_max'],
                                        'EXISTENCIA' => $articulo['cantidad'],
                                        );
        }

        else 
            $response = $articulos->errorInfo()[2];

        echo json_encode($response);
    }

    //Reporte de existencia, traer las salidas y articulos de cada salida
    else 
        if($opcion == '4'){  
            $reportType = (isset($_POST['reportType']) && !$_POST['reportType']=='') ? $_POST['reportType'] : 0;

            $tipoSalida = (isset($_POST['valTipoSalido']) && !$_POST['valTipoSalido']=='') ? $_POST['valTipoSalido'] : 0;
            $empleado = (isset($_POST['valEmpleado']) && !$_POST['valEmpleado']=='') ? $_POST['valEmpleado'] : 0;
            $usuario = (isset($_POST['valUsuario']) && !$_POST['valUsuario']=='') ? $_POST['valUsuario'] : 0;


            $startDate = (isset($_POST['startDate']) && !$_POST['startDate']=='') ? (new DateTime($_POST['startDate']))->format('Y-m-d') : 0;
            $endDate = (isset($_POST['endDate']) && !$_POST['endDate']=='') ? (new DateTime($_POST['endDate']))->format('Y-m-d') : 0;
            
            $filtrotipoSalida = ($tipoSalida != 0) ? ' AND us.tipo_salida= :tipoSalida ' : ' ';
            $filtroempleado = ($empleado != 0) ? ' AND us.id_empleado= :empleado ' : ' ';
            $filtrousuario = ($usuario != 0) ? ' AND us.id_usuario = :usuario ' : ' ';

            $filtroFecha = ($startDate != 0 && $endDate != 0) 
                                ? $filtroFecha = ' AND fecha between :startDate and :endDate ' 
                                : $filtroFecha = '';

            //SOLO SALIDAS
            if($reportType == 1) $sql= "SELECT us.id_salida, FORMAT(us.fecha, 'yyyy-MM-dd HH:mm') AS fecha, e.usuario as empleado, d.Nombre as usuario, ts.tipo_salida 
                                                FROM uni_salida as us 
                                            left join DIRECTORIO_0 AS d on us.id_usuario = d.ID
                                            left join (select id_usuario, usuario from empleado group by id_usuario, usuario) as e on us.id_empleado = e.id_usuario
                                            inner join uni_tipo_salida as ts on us.tipo_salida = ts.id_tipo_salida WHERE 1=1 ".$filtrotipoSalida." ".$filtroempleado. " ".$filtrousuario." ".$filtroFecha;

            //SOLO ARTICULOS
            else 
                if($reportType == 2)
                $sql= "SELECT usa.id_salida, FORMAT(us.fecha, 'yyyy-MM-dd HH:mm') as fecha, a.nombre as articulo, usa.cantidad
                                from uni_salida_articulo as usa 
                            left join uni_articulos as a on usa.id_articulo = a.id_articulo
                            inner join uni_salida as us on usa.id_salida = us.id_salida ".$filtrotipoSalida." ".$filtroempleado. " ".$filtrousuario." ".$filtroFecha;

            $salidas = $conn->prepare($sql);

            ($tipoSalida != 0) ? $salidas->bindparam(':tipoSalida', $tipoSalida) : '';
            ($empleado != 0) ? $salidas->bindparam(':empleado', $empleado) : '';
            ($usuario != 0) ? $salidas->bindparam(':usuario', $usuario) : '';

            if ($startDate != 0 && $endDate != 0){
                $salidas->bindparam(':startDate', $startDate);
                $salidas->bindparam(':endDate', $endDate);
            }

            
            $response = array();

                if($salidas->execute()){
                    while($salida = $salidas->fetch(PDO::FETCH_ASSOC))
                        $response[] = $salida;
                }

                else 
                    $response = $salidas->errorInfo()[2];

            echo json_encode($response);
        }

    else 
        if($opcion == '5'){
            $idSalida = (isset($_POST['idSalida']) && !$_POST['idSalida']=='') ? $_POST['idSalida'] : NULL;

            $sql = 'SELECT usa.id_salida, usa.id_articulo, ua.nombre, usa.cantidad, usa.precio 
                                from uni_salida_articulo as usa 
                            inner join uni_articulos as ua on usa.id_articulo = ua.id_articulo WHERE usa.id_salida = :id_salida';

            $articulos = $conn->prepare($sql);
            $articulos->bindparam(':id_salida', $idSalida);
            $response = array();

                if($articulos->execute()){
                    while($articulo = $articulos->fetch(PDO::FETCH_ASSOC))
                        $response[] = $articulo;
                }

                else 
                $response = $articulos->errorInfo()[2];

            echo json_encode($response);
        }
?>