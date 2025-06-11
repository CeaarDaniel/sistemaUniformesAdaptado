<?php
    include('./api/conexion.php');

    //TIPOS DE SALIDAS
    $tipoSalida = $conn->prepare("select* from uni_tipo_salida"); 
    $tipoSalida->execute();

    //GENERO
    $years = $conn->prepare("select DISTINCT YEAR(fecha_creacion) as año from uni_pedido"); 
    $years->execute();
?>    



    <div id="consultaSalidas" class="m-0 p-0" style="overflow:hidden;">
        <!-- Título -->
        <div class="container mt-4">
            <h1 class="title text-center">Consultas de Salidas</h1>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="container mt-4">
            <div class="row g-3 align-items-center">
                <!-- Tipo de Salida -->
                <div class="col-md-4">
                    <select class="form-select filtroBusqueda" id="tipo">
                        <option value="0">Todos</option>
                        <?php
                            while($salida = $tipoSalida->fetch(PDO::FETCH_ASSOC))
                                echo '<option value="'.$salida['id_tipo_salida'].'">'.$salida['tipo_salida'].'</option>';
                        ?>
                    </select>
                </div>

                <!-- Mes -->
                <div class="col-md-2">
                    <select class="form-select filtroBusqueda" id="mes">
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

                <!-- Año -->
                <div class="col-md-2">
                    <select class="form-select filtroBusqueda" id="anio">
                        <option value="0">Todos</option>
                            <?php
                                while($year = $years->fetch(PDO::FETCH_ASSOC))
                                echo '<option value="'.$year['año'].'">'.$year['año'].'</option>';
                            ?>
                    </select>
                </div>

                <!-- Búsqueda -->
                <div class="col-md-4">
                    <div class="input-group"> 
                        <input type="number" class="form-control filtroBusqueda" id="busquedaEmp" min="2" step="1" placeholder="Buscar empleado">
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Salidas -->
        <div class="mt-4 mb-0 display nowrap" style="max-height:400px; width:100%; overflow-y:auto">
            <table id="tablaSalidas" class="table table-striped" style="width:100%;">
                <thead class="sticky-header">
                    <tr>
                        <th style="background-color: rgb(13, 71, 161); color:white">ID</th>
                        <th style="background-color: rgb(13, 71, 161); color:white">Fecha</th>
                        <th style="background-color: rgb(13, 71, 161); color:white">Tipo</th>
                        <th style="background-color: rgb(13, 71, 161); color:white">Realizado por</th>
                        <th style="background-color: rgb(13, 71, 161); color:white">Empleado</th>
                        <th style="background-color: rgb(13, 71, 161); color:white">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Filas de la tabla se llenarán dinámicamente -->
                </tbody>
            </table>
        </div>

        <!-- Modal de Ver Salida -->
        <div class="modal fade" id="verSalidaModal" tabindex="-1" aria-labelledby="verSalidaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verSalidaModalLabel">DETALLE DE SALIDA</h5>
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
                                        <td class="p-0 border border-dark"><b id="salidaId"></b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Detalles del pedido -->
                        <div class="row mt-5">
                            <div class="my-1 col-3"><b>Fecha de elaboración:</b></div>
                            <div class="my-1 col-auto"><label class="mx-0 px-0 text-uppercase" id="salidaFecha"></label></div>
                        </div>

                        <div class="row mt-1">
                            <div class="my-1 col-3"><b>Realizado por:</b></div>
                            <div class="my-1 col-auto"><label id="salidaRealizadoPor"></label></div>
                        </div>

                        <div class="row mt-1">
                            <div class="my-1 col-3"><b>Entregado a:</b></div>
                            <div class="my-1 col-auto text-uppercase"><label id ="salidaEmpleado"></label></div>
                         </div>
                         
                         <!-- TIPO DE SALIDA -->
                         <div class="row mt-1">
                            <div class="my-1 col-3"><b>Tipo de salida:</b></div>
                            <div class="my-1 col-auto text-uppercase"><label id ="salidaTipo"></label></div>
                         </div>

                        <!-- VALE -->
                        <div id="columVale" class="row mt-1"></div>

                        <!-- TIPO DE VALE -->
                        <div id="columTipoVale" class="row my-0"></div>

                         <hr class="my-4" style="height: 5px; background: linear-gradient(90deg,rgba(9, 11, 122, 1) 33%, rgba(133, 133, 133, 1) 0%); opacity: 1; border:none;">

                            <!--TABLA DE PRODUCTOS -->
                            <p class="text-center fs-7"><b> PRODUCTOS </b></p>
                            <div style="overflow: auto scroll; max-height: 400px;">
                                <table id="" class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">ID Artículo</th>
                                            <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Cantidad</th>
                                            <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Artículo</th>
                                            <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Precio Unitario</th>
                                            <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyDetallePedido">
                                        <!-- Filas de la tabla se llenarán dinámicamente -->
                                    </tbody>
                                </table>

                                <div class="mx-3 d-flex justify-content-end">
                                    <b>Total:</b> &nbsp; &nbsp; <label id='totalCostoSalida'></label>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-none p-0 m-0">
        <div id="impresionDetalleSalida" class="hojaImpresion" style="font-size:13px;   z-index: 100;">
        </div>
    </div>