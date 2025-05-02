<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
include('./conexion.php'); 

$opcion = $_POST['opcion'];


    if($opcion == '1'){  
        $tipo = (isset($_POST['tipo']) && !$_POST['tipo']=='') ? $_POST['tipo'] : 0;
        $anio = (isset($_POST['anio']) && !$_POST['anio']=='') ? $_POST['anio'] : 0;
        $mes = (isset($_POST['mes']) && !$_POST['mes']=='') ? $_POST['mes'] : 0;
        $busquedaEmp = (isset($_POST['busquedaEmp']) && !$_POST['busquedaEmp']=='') ? $_POST['busquedaEmp'] : 0;
        

        //Cadenas con la condicion de filtrado para generar la consulta
        $filtroanio = ($anio != 0) ? ' AND YEAR(us.fecha) = :$anio' : '';
        $filtromes = ($mes != 0) ? ' AND MONTH(us.fecha) = :mes ' : '';
        $filtrotipo = ($tipo != 0) ? '  ' : '';
        $filtrobusquedaEmp = ($busquedaEmp != 0) ? '  ' : '';



        //$filtrotipoSalida = ($tipoSalida != 0) ? ' AND us.tipo_salida= :tipoSalida ' : ' ';
        //$filtroempleado = ($empleado != 0) ? ' AND us.id_empleado= :empleado ' : ' ';
        //$filtrousuario = ($usuario != 0) ? ' AND us.id_usuario = :usuario ' : ' ';
                            
        $sql= "SELECT us.id_salida, FORMAT(us.fecha, 'yyyy-MM-dd HH:mm') AS fecha, ts.tipo_salida,  d.Nombre as realizado_por, e.usuario as empleado
                    FROM uni_salida as us 
                left join DIRECTORIO_0 AS d on us.id_usuario = d.ID
                left join (select id_usuario, usuario from empleado group by id_usuario, usuario) as e on us.id_empleado = e.id_usuario
                inner join uni_tipo_salida as ts on us.tipo_salida = ts.id_tipo_salida WHERE 1=1";
        $salidas = $conn->prepare($sql);

        //($tipoSalida != 0) ? $salidas->bindparam(':tipoSalida', $tipoSalida) : '';
        //$empleado != 0) ? $salidas->bindparam(':empleado', $empleado) : '';
        //($usuario != 0) ? $salidas->bindparam(':usuario', $usuario) : '';
        /*
        if ($startDate != 0 && $endDate != 0){
            $salidas->bindparam(':startDate', $startDate);
            $salidas->bindparam(':endDate', $endDate);
        }*/

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
                                                                >
                                                            <i class="fas fa-eye" style="font-size:20px; color:blue; background-color:none"></i>
                                                        </button>
                                                        <button class="btn btnImprimir p-0 my-0 mx-1" 
                                                                data-id="'.$salida['id_salida'].'">
                                                            <i class="fas fa-print" style="font-size:20px; color:black; background-color:none"></i>
                                                        </button>');
            }

            else 
                $response = $salidas->errorInfo()[2];

        echo json_encode($response);
    }
?>