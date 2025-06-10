<?php
include('./api/conexion.php');

//ARTICULOS BAOS DE STOCk
$stockBajo = $conn->prepare("SELECT id_articulo, nombre,cantidad, talla 
                                from uni_articulos ua 
                                    inner join uni_talla ut on ua.id_talla = ut.id_talla  
                              where cantidad <= stock_min"); 
$stockBajo->execute();

//ULTIMOS PEDIDOS
$pedidos = $conn->prepare("SELECT TOP 5 p.num_pedido, pe.pedido_estado, FORMAT(p.fecha_creacion, 'yyyy/MM/dd HH:mm') as fecha_inicio, 
                                        ISNULL(FORMAT(p.fecha_termino , 'yyyy/MM/dd HH:mm'), '-') fecha_fin
                                    FROM uni_pedido AS p, uni_pedido_estado AS pe 
                                WHERE p.status = pe.id_estado 
                            ORDER BY p.id_pedido DESC");
$pedidos->execute();


//ULTIMAS ENTRADAS
$entradas = $conn->prepare("SELECT TOP 5 e.id_entrada, FORMAT(e.fecha, 'yyyy/MM:dd HH:mm') as fecha, 
                                            d.Nombre AS nombre_usuario, 
                                            e.tipo_entrada
                                    FROM uni_entrada AS e, DIRECTORIO_0 AS d 
                                WHERE e.id_usuario = d.ID 
                            ORDER BY id_entrada DESC");

$entradas->execute();

//ULTIMAS SALIDAS
$salidas = $conn->prepare("SELECT TOP 5 s.id_salida, FORMAT(s.fecha, 'yyyy/MM:dd HH:mm') AS fecha, 
                                        ts.tipo_salida, 
                                        e.usuario AS nombre_empleado, 
                                        d.Nombre AS nombre_usuario 
                                    FROM uni_salida AS s, uni_tipo_salida AS ts, empleado AS e, DIRECTORIO_0 AS d 
                                WHERE e.id_usuario = s.id_empleado AND d.ID = s.id_usuario AND s.tipo_salida = ts.id_tipo_salida 
                            ORDER BY id_salida DESC"); 
$salidas->execute();
?>

<div id="dashboard">
    <!-- Sección de Atajos -->
    <div class="padding-header">
        <div class="row">
            <div class="title-dash">ATAJOS</div>
        </div>
        <div class="row table-container">
            <!-- Tarjeta 1: Entrega de uniforme -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 my-2">
                <a href="#/salidasPlanta" class="text-decoration-none">
                    <div class="card-shortcut text-center q-card p-4">
                        <div class="">
                            <div class="q-avatar bg-blue-10 text-white">
                                <i class="far fa-id-card"></i>
                            </div>
                        </div>
                        <div>
                            <span style="font-size: 16px; font-weight: bold; color:black;">Entrega de uniforme</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Tarjeta 2: Venta de uniforme -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 my-2">
                <a href="#/salidasVenta" class="text-decoration-none">
                    <div class="card-shortcut text-center q-card p-4">
                        <div class="">
                            <div class="q-avatar bg-blue-10 text-white">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                        <div class="">
                            <span style="font-size: 16px; font-weight: bold; color:black;">Venta de uniforme</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Tarjeta 3: Entrega de uniforme usado -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 my-2">
                <a href="#/salidasUsado" class="text-decoration-none">
                    <div class="card-shortcut text-center q-card p-4">
                        <div class="">
                            <div class="q-avatar bg-blue-10 text-white">
                                <i class="fas fa-tshirt"></i>
                            </div>
                        </div>
                        <div class="">
                            <span style="font-size: 16px; font-weight: bold; color:black;">Entrega de uniforme usado</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Tarjeta 4: Reposición de uniforme -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 my-2">
                <a href="#/salidasReposicion" class="text-decoration-none">
                    <div class="card-shortcut text-center q-card p-4">
                        <div class="">
                            <div class="q-avatar bg-blue-10 text-white">
                                <i class="fas fa-exchange-alt"></i>
                            </div>
                        </div>
                        <div class="">
                            <span style="font-size: 16px; font-weight: bold; color:black;">Reposición de uniforme</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Tarjeta 5: Consulta de salidas -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 my-2">
                <a href="#/consultaSalidas" class="text-decoration-none">
                    <div class="card-shortcut text-center q-card p-4">
                        <div class="">
                            <div class="q-avatar bg-blue-10 text-white">
                                <i class="fas fa-file-upload"></i>
                            </div>
                        </div>
                        <div class="">
                            <span style="font-size: 16px; font-weight: bold; color:black;">Consulta de salidas</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Tarjeta 6: Pedidos -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 my-2">
                <a href="#/pedidos" class="text-decoration-none">
                    <div class="card-shortcut text-center q-card p-4">
                        <div class="">
                            <div class="q-avatar bg-blue-10 text-white">
                                <i class="fas fa-truck-loading"></i>
                            </div>
                        </div>
                        <div class="">
                            <span style="font-size: 16px; font-weight: bold; color:black;">Pedidos</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Tarjeta 7: Renovación de uniforme -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 my-2">
                <a href="#/salidasRenovacion" class="text-decoration-none">
                    <div class="card-shortcut text-center q-card p-4">
                        <div class="">
                            <div class="q-avatar bg-blue-10 text-white">
                                <i class="fas fa-sync-alt"></i>
                            </div>
                        </div>
                        <div class="">
                            <span style="font-size: 16px; font-weight: bold; color:black;">Renovación de uniforme</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Sección de Tablas -->
    <div class="row table-container">
        <!-- Tabla 1: Artículos en bajo stock -->
        <div class="col-12 col-lg-8 my-4 card-dash">
            <div class="q-card">
                <div class="">
                    <div class="text-h6 title-dash">
                        Artículos en bajo stock
                        <i class="fas fa-sort-amount-down"></i>
                    </div>
                </div>
                <div class="">
                    <div style="overflow: auto scroll; height: 180px;">
                        <table class="table">
                            <thead class="header-table">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Talla</th>
                                    <th>Cant. física</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Filas de la tabla -->
                                <?php
                                    while($articulo = $stockBajo->fetch(PDO::FETCH_ASSOC))
                                    echo '<tr data-v-f3a234b4="" class="header-body">
                                            <td data-v-f3a234b4="">'.$articulo['id_articulo'].'</td>
                                            <td data-v-f3a234b4="">'.$articulo['nombre'].'</td>
                                            <td data-v-f3a234b4="">'.$articulo['cantidad'].'</td>
                                            <td data-v-f3a234b4="">'.$articulo['talla'].'</td>
                                        </tr>';
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla 2: Últimos pedidos -->
        <div class="col-12 col-lg-8 my-4 card-dash">
            <div class="q-card">
                <div class="">
                    <div class="text-h6 title-dash">
                        Últimos pedidos
                        <i class="fas fa-box-open"></i>
                    </div>
                </div>
                <div class="">
                    <div style="overflow: auto scroll; height: 180px;">
                        <table class="table">
                            <thead class="header-table">
                                <tr>
                                    <th>Consecutivo</th>
                                    <th>Estado</th>
                                    <th>Fecha inicio</th>
                                    <th>Fecha termino</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <!-- Filas de la tabla -->
                                <?php
                                    while($pedido = $pedidos->fetch(PDO::FETCH_ASSOC))
                                    echo '<tr data-v-f3a234b4="" class="header-body">
                                            <td data-v-f3a234b4="">'.$pedido['num_pedido'].'</td>
                                            <td data-v-f3a234b4="">'.$pedido['pedido_estado'].'</td>
                                            <td data-v-f3a234b4="">'.$pedido['fecha_inicio'].'</td>
                                            <td data-v-f3a234b4="">'.$pedido['fecha_fin'].'</td>
                                        </tr>';
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla 3: Últimas entradas -->
        <div class="col-12 col-lg-8 my-4 card-dash">
            <div class="q-card">
                <div class="">
                    <div class="text-h6 title-dash">
                        Últimas entradas
                        <i class="fas fa-sign-in-alt"></i>
                    </div>
                </div>
                <div class="">
                    <div style="overflow: auto scroll; height: 180px;">
                        <table class="table">
                            <thead class="header-table">
                                <tr>
                                    <th>Num.</th>
                                    <th>Fecha</th>
                                    <th>Tipo</th>
                                    <th>Realizado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Filas de la tabla aquí -->
                                <?php
                                    while($entrada = $entradas->fetch(PDO::FETCH_ASSOC)){
                                        switch ($entrada['tipo_entrada']) {
                                            case '1':
                                                $tipoEntrada = 'ENTRADA POR PEDIDO';
                                                break;
                                            case '2':
                                                $tipoEntrada = 'ENTRADA POR SALIDA';
                                                break;
                                            case '3':
                                                $tipoEntrada = 'ENTRADA MANUAL';
                                                break;
                                            case '4':
                                                $tipoEntrada = 'ENTRADA DE UNIFORME USADO';
                                                break;
                                            case '5':
                                                $tipoEntrada = 'ENTRADA POR CAMBIO';
                                                break;
                                            default:
                                                $tipoEntrada = '-';
                                                break;
                                        }

                                    echo '<tr data-v-f3a234b4="" class="header-body">
                                            <td data-v-f3a234b4="">'.$entrada['id_entrada'].'</td>
                                            <td data-v-f3a234b4="">'.$entrada['fecha'].'</td>
                                            <td data-v-f3a234b4="">'.$tipoEntrada.'</td>
                                            <td data-v-f3a234b4="">'.$entrada['nombre_usuario'].'</td>
                                        </tr>';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla 4: Últimas salidas -->
        <div class="col-12 col-lg-8 my-4 card-dash">
            <div class="q-card">
                    <div class="text-h6 title-dash">
                        Últimas salidas
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <div style="overflow: auto scroll; height: 220px;">
                        <table class="table">
                            <thead class="header-table">
                                <tr>
                                    <th>Num.</th>
                                    <th>Fecha</th>
                                    <th>Tipo</th>
                                    <th>Realizado</th>
                                    <th>Usuario</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Filas de la tabla aquí -->
                                <?php
                                    while($salida = $salidas->fetch(PDO::FETCH_ASSOC))
                                        echo '<tr class="header-body">
                                                <td>'.$salida['id_salida'].'</td>
                                                <td>'.$salida['fecha'].'</td>
                                                <td>'.$salida['tipo_salida'].'</td>
                                                <td>'.$salida['nombre_usuario'].'</td>
                                                <td>'.$salida['nombre_empleado'].'</td>
                                            </tr>';
                                ?>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</div>