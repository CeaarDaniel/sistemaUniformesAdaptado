<?php
    include('./api/conexion.php');

    //AÑOS
    $years = $conn->prepare("SELECT distinct(YEAR(fecha)) as fecha from uni_venta order by fecha"); 
    $years->execute();
?>    
    <!-- Contenido principal -->
    <div class="my-4 mx-3">
        <div class="col-12">
            <h1 class="title"> Reporte de ventas</h1>
        </div>
    </div>

       
        <div class="row mx-5 px-3">
                <div class="col-md-12 col-lg-3 my-1">
                        <label for="categoriaCat"><b>TIPO DE REPORTE</b></label>
                        <select class="form-select" id="categoriaCat">
                            <option value="consultasReportes">De ventas</option>
                            <option value="consultasReportesInventario">De inventario</option>
                        </select>
                </div>
                
                <!-- Filtros -->
                <div class="col-md-12 col-lg-5 my-1">
                        <label for="categoriaCat"><b>FILTROS</b></label>
                        <div class="d-flex column">
                            <select class="form-select mx-1" id="mes">
                                <option value="0">Todos</option>
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                            <div class="input-group">
                                <select class="form-select" id="anio">
                                    <option value="0">Todos</option>
                                        <?php
                                            while($year = $years->fetch(PDO::FETCH_ASSOC))
                                            echo '<option value="'.$year['fecha'].'">'.$year['fecha'].'</option>';
                                        ?>
                                </select>
                            </div>
                        </div>
                </div>

                <div class="col-md-12 col-lg-3 my-1">
                    <label for="categoriaCat"><b>AGRUPAR POR</b></label>
                    <div class="input-group">
                        <select class="form-select" id="grupoFecha">
                            <option value="0">Todos</option>
                            <OPTion value="yyyy">año</OPTion>
                            <OPTion value="'yyyy/MM">año y mes</OPTion>
                            <option value="yyyy/MM/dd">año, mes y día</option>
                        </select>
                        <button class="btn btn-success" id="generarReporte">Generar</button>
                    </div>
                </div>
        </div>

        <!-- Reporte de ventas -->
        <div class="row mt-4 mx-5 px-5">
            <div class="col-12 p-0">
                <div class="reporte-card">
                    <h3 class="text-center" id="tituloReporte"></h3>

                    <!-- Ventas generales -->
                    <div class="row top-dashed-line">
                        <div class="col-md-4">
                            <span class="fs-5 text-success"><b>Ventas totales:</b></span>
                            <span class="fs-6" id="ventasTotales"></span>
                        </div>
                        <div class="col-md-4">
                            <span class="fs-5 text-success"><b>Número de ventas:</b></span>
                            <span class="fs-6" id="numVentas"></span>
                        </div>
                        <div class="col-md-4">
                            <span class="fs-5 text-success"><b>Venta promedio:</b></span>
                            <span class="fs-6" id="ventaPromedio"></span>
                        </div>
                    </div>

                    <!-- Ventas diarias -->
                    <div id="ventasDiariasPadre" class="top-dashed-line">
                        <div class="d-flex justify-content-center" id="ventasDiarias" style="width:100%">
                            <div class="fs-5"><b>Ventas</b></div>
                                <!-- Las ventas diarias se llenarán dinámicamente -->
                                 <div id="tableContainer" style="width:500px;">
                                    <table id="ventasDiariasTabla" class="table-striped responsive">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Venta total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ganancias por categoría -->
                    <div class="row top-dashed-line p-0 m-0"  style="width:100%;">
                        <!-- Ganancia total -->
                        <div class="fs-4 text-center my-3"><b> Ganancias y ventas por categoría</b></div>
                        <div class="col-md-6 my-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fs-5"><b>Ganancia total:</b></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fs-5 text-danger" id="gananciaTotal"></div>
                                </div>
                            </div>
                        </div>

                        <!--TABLA DE GANANCIAS POR CATEGORIA -->
                        <div class="col-md-12 p-0 m-0"  style="width:100%;">
                            <div class="p-0 m-0" id="gananciasCategoria" style="width:100%;">
                                <!-- Las ganancias por categoría se llenarán dinámicamente -->
                                 <table id="tablaGanVenCategorias" class="table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>Categoria</th>
                                            <th>Costo promedio por venta</th>
                                            <th>Costo de venta</th>
                                            <th>Costo de compra</th>
                                            <th>Ganancia</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                 </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>