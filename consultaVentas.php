<?php 
    include('./api/conexion.php');
    $sql = "SELECT distinct(YEAR(fecha)) AS año from uni_venta order by año";

    $years = $conn->prepare($sql); 
    $years->execute();
?>

    <div id="pantallaConsultasVentas" class="m-0 p-0" style="overflow:hidden;">
    <!-- Contenido principal -->
    <div class="p-0 my-3 mx-2">
        <div class="row">
            <div class="col-12">
                <h1 class="title">Consultas de ventas</h1>
            </div>
        </div>
    </div>

        <!-- Filtros -->
        <div class="row mt-3">
            <!-- FILTRO DE AÑO -->
            <div class="col-md-3">
                <select class="form-select" id="mes">
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
            </div>

            <!-- FILTRO DE MES -->
            <div class="col-md-3">
                <select class="form-select" id="anio">
                    <option value="0">Todos</option>
                        <?php
                            while($year = $years->fetch(PDO::FETCH_ASSOC))
                            echo '<option value="'.$year['año'].'">'.$year['año'].'</option>';
                        ?>
                </select>
            </div>

            <div class="col-md-3 text-end">
                <h4>Total: <span id="totalVentas"></span></h4>
            </div>
        </div>

        <!-- Tabla de ventas -->
            <div class="mt-4 mb-0 p-0 display nowrap" style="max-height:400px; width:100%; overflow-y:auto">
                <table id="tablaVentas" class="table table-striped" style="width:100%;">
                    <thead class="sticky-header">
                        <tr>
                            <th style="background-color:#0A0A85; color:white;">ID</th>
                            <th style="background-color:#0A0A85; color:white;">FECHA</th>
                            <th style="background-color:#0A0A85; color:white;">EMPLEADO</th>
                            <th style="background-color:#0A0A85; color:white;">COSTO TOTAL</th>
                            <th style="background-color:#0A0A85; color:white;">DESCUENTOS</th>
                            <th style="background-color:#0A0A85; color:white;">DESC. APLICADOS</th>
                            <th style="background-color:#0A0A85; color:white;">CONCRETAR</th>
                            <th style="background-color:#0A0A85; color:white;">FIRMAS</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        <!-- Modal de Ver Salida -->
            <div class="modal fade" id="detalleVentadaModal" tabindex="-1" aria-labelledby="detalleVentadaModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detalleVentadaModalLabel">REGISTRAR DESCUENTOS</h5>
                        <button class="btn" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-close" style="background-color:none; color:white; font-size:18px;"></i></button>
                    </div>
                    <div class="modal-body">
                        <!-- Detalles de la salida -->
                        <div class="mx-5 d-flex justify-content-between">
                            <img src="./imagenes/beyonz.jpg" style="max: width 150px; max-height:50px;">
                            <table>
                                <tbody>
                                    <tr style="background-color: #0A0A85;
                                                color: white;">
                                        <td class="p-0 border border-dark"><b>NUM SALIDA</b></td>
                                    </tr>
                                    <tr>
                                        <td class="p-0 border border-dark"><b id="ventaId"></b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Detalles del pedido -->
                        <div class="row mt-5">
                            <div class="my-1 col-3"><b>Fecha:</b></div>
                            <div class="my-1 col-auto"><label class="mx-0 px-0 text-uppercase" id="ventaFecha"></label></div>
                        </div>

                        <div class="row mt-1">
                            <div class="my-1 col-3"><b>Empleado: </b></div>
                            <div class="my-1 col-auto text-uppercase"><label id ="ventaEmpleado"></label></div>
                            </div>

                            <div class="row mt-1">
                            <div class="my-1 col-3"><b>Costo total:</b></div>
                            <div class="my-1 col-auto text-uppercase"><label id ="ventaCosto"></label></div>
                            </div>

                            <div class="row mt-1">
                            <div class="my-1 col-3"><b>Descuentos:</b></div>
                            <div class="my-1 col-auto text-uppercase"><label id ="ventaDescuentos"></label></div>
                            </div>

                            <hr class="my-4" style="height: 5px; background: linear-gradient(90deg,rgba(9, 11, 122, 1) 33%, rgba(133, 133, 133, 1) 0%); opacity: 1; border:none;">

                            <!--SECCION DE DECUENTOS -->
                                <div class="form-card my-0">                                    
                                    <form>
                                        <p class="text-center fs-7 my-0 p-0 textlabelVentas"><b> DESCUENTOS</b></p>
                                        
                                        <!--LISTADO DE DESCUENTOS -->
                                        <div id="descuentosModal">
                                        </div>
                                    </form>
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-none p-0 m-p">
        <div id="contenido" class="hojaImpresion">
        </div>
    </div>

