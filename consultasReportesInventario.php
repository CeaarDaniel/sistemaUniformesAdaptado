<?php 
    include('./api/conexion.php');

    //CATEGORIAS DE ARTICULO
    $categorias = $conn->prepare("SELECT* from uni_categoria"); 
    $categorias->execute();
?>


<!-- Contenido principal -->
    <div class="my-4 mx-3">
        <div class="col-12">
            <h1 class="title"> Reporte de inventarios</h1>
        </div>
    </div>

    <!-- Contenido principal --> 
            <div class="row mx-5 px-3">
                <div class="col-12 col-md-6 col-lg-3 my-1">
                        <label for="categoriaCat"><b>TIPO DE REPORTE</b></label>
                        <select class="form-select" id="categoriaCat">
                            <option value="consultasReportes">De ventas</option>
                            <option value="consultasReportesInventario" selected>De inventario</option>
                        </select>
                </div>
                <div class="col-12 col-md-6 col-lg-3 my-1">
                    <label for="categoriaCat"><b>FILTROS</b></label>
                    <div class="input-group">
                        <select class="form-select" id="categoria">
                            <option value="todos">Todos</option>
                                <?php
                                    while($categoria = $categorias->fetch(PDO::FETCH_ASSOC))
                                    echo '<option value="'.$categoria['id_categoria'].'">'.$categoria['categoria'].'</option>';
                                ?>
                        </select>
                        <button class="btn btn-success" id="generarReporte">Generar</button>
                    </div>
                </div>
            </div>

            <!-- Reporte de inventario -->
            <div class="row mt-4 mx-5" style="background-color:white">
                <div class="col-12">
                    <div class="reporte-card">
                        <h2 class="text-center" id="tituloReporte">Reporte de inventario</h2>
                        <!-- Ventas generales -->
                        <div class="row px-5 top-dashed-line">
                            <div class="col-md-4">
                                <span class="fs-5 text-success"><b>Categoria:</b></span>
                                <span class="fs-5" id="ventasTotales">Todos</span>
                            </div>
                            <div class="col-md-4">
                                <span class="fs-5 text-success"><b>Costo del inventario:</b></span>
                                <span class="fs-5" id="numVentas">$503,342.00</span>
                            </div>
                            <div class="col-md-4">
                                <span class="fs-5 text-success"><b>Cantidad de productos:</b></span>
                                <span class="fs-5" id="ventaPromedio">5523</span>
                            </div>
                        </div>
                        <div id="tableContainer" class="row p-0 m-0" style="border-top: 1px dashed #757779;">
                            <div class="col-12 py-3">
                                <!--TABLA DE INVENTARIO-->
                                    <table id="tablaInventario" class="table-striped responsive">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Costo</th>
                                                <th>Precio Venta</th>
                                                <th>Existencia</th>
                                                <th>Stock min.</th>
                                                <th>Stock max.</th>
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