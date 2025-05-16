<?php
include('./api/conexion.php');

 //TIPO DE SALIDA
 $salidas = $conn->prepare("SELECT* from uni_tipo_salida"); 
 $salidas->execute();

 //USUARIOS
 $usuarios = $conn->prepare("SELECT rs.id_usuario, d.Nombre from uni_roles_sesion AS rs inner join DIRECTORIO_0 as d ON rs.id_usuario = d.ID "); 
 $usuarios->execute();
?>

<div class="container-fluid">
        <!-- Header Section -->
        <div class="row my-3 justify-content-between">
            <div class="col-3 align-self-center">
                <div class="title">Reporte de salidas</div>
            </div>
            <div class="col-2 align-self-center">
                <button id="btngenerarReporte" class="btn btn-success">
                    <i class="fas fa-file-invoice me-2"></i>Generar
                </button>
            </div>
        </div>

        <!-- Filtros Principales -->
        <div class="row mt-2 mb-2">
            <div class="col-1 align-self-center">Periodo:</div>
            <div class="col-4">
                <div class="input-group">
                    <input type="date" id="startDate" class="form-control">
                    <span class="input-group-text">a</span>
                    <input type="date" id="endDate" class="form-control">
                </div>
            </div>
            
            <div class="col-auto ms-3">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="soloSalidas" name="rbnSalida" value="1" checked>
                    <label class="form-check-label" for="soloSalidas">Solo salidas</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="soloArticulos" name="rbnSalida" value="2">
                    <label class="form-check-label" for="soloArticulos">Solo artículos</label>
                </div>
            </div>
            
            <div class="col-auto ms-auto">
                <button id="toggleFilter" class="btn btn-success">
                    <i class="fas fa-sliders-h"></i>
                </button>
            </div>
        </div>

        <!-- Filtros Avanzados -->
        <div class="filter-transition" id="filterSection">
            <hr>
            <!-- Tipo Salidas -->
            <div class="row mt-2">
                <div class="col-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ftrTipoSalidos" checked>
                        <label class="form-check-label">Todos los tipos</label>
                    </div>
                </div>
                <div class="col-4 ms-3">
                    <select class="form-select" id="valTipoSalido" disabled>
                        <option value="">Seleccione un tipo de salida</option>
                            <?php
                                while($tiposalida = $salidas->fetch(PDO::FETCH_ASSOC))
                                echo '<option value="'.$tiposalida['id_tipo_salida'].'">'.$tiposalida['tipo_salida'].'</option>';
                            ?>
                    </select>
                </div>
            </div>

            <!-- Empleados -->
            <div class="row mt-2">
                <div class="col-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ftrEmpleados" checked>
                        <label class="form-check-label">Todos empleados</label>
                    </div>
                </div>
                <div class="col-4 ms-3">
                    <input type="number" class="form-control" id="valEmpleado"  min="2" step="1" placeholder="Número de nómina del empleado" disabled>
                </div>
            </div>

            <!-- Usuarios -->
            <div class="row mt-2 mb-3">
                <div class="col-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ftrUsuarios" checked>
                        <label class="form-check-label">Todos usuarios</label>
                    </div>
                </div>
                <div class="col-4 ms-3">
                    <select class="form-select" id="valUsuario" disabled>
                        <option value="">Seleccione un usuario</option>
                            <?php
                                while($usuario = $usuarios->fetch(PDO::FETCH_ASSOC))
                                echo '<option value="'.$usuario['id_usuario'].'">'.$usuario['Nombre'].'</option>';
                            ?>
                    </select>
                </div>
            </div>
        </div>

    <!-- Tabla de Resultados -->
        <div class="table-container" style="background-color:white; height: 420px;">
            <div id="emptyState" class="text-center flex-wrap align-content-center py-5 d-none" style="width:100%; height:100%;">
                <i class="bi bi-emoji-neutral display-4 text-muted"></i>
                <p class="text-muted fs-5 mt-3">No se encontraron resultados</p>
            </div>
            <div id="tableContent" class="card-body p-0 d-flex justify-content-center">
                <table id="reporteTable" class="table table-striped">
                    <thead class="sticky-header">
                        <tr id="tableHeader">
                        </tr>
                    </thead>
                    <tbody id=""></tbody>
                </table>
            </div>
        </div>
</div>


        <!-- Modal Detalle de Venta -->
        <div class="modal fade" id="modalDetalleSalida" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal">DETALLE DE SALIDA</h5>
                        <button class="btn" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-close" style="background-color:none; color:white; font-size:18px;"></i></button>
                    </div>
                    <div class="modal-body py-1" id='modalBodyDetalleVenta'>
                        <div class="mx-5 d-flex justify-content-between">
                            <img src="./imagenes/beyonz.jpg" style="max: width 150px; max-height:50px;">
                        </div>

                        <!-- Detalles de la venta -->
                        <div class="row mt-5">
                            <div class="my-1 col-3"><b>Fecha de elaboración:</b></div>
                            <div class="my-1 col-auto"><label class="mx-0 px-0 text-uppercase" id="modalfecha"></label></div>
                        </div>

                        <div class="row mt-1">
                            <div class="my-1 col-3"><b>Realizado por:</b></div>
                            <div class="my-1 col-auto"><label id="modalusuario"></label></div>
                        </div>

                        <div class="row mt-1">
                            <div class="my-1 col-3"><b>Empleado:</b></div>
                            <div class="my-1 col-auto text-uppercase"><label id="modalEmpleado"></label></div>
                         </div>

                         <div class="row mt-1">
                            <div class="my-1 col-3"><b>Tipo de salida:</b></div>
                            <div class="my-1 col-auto text-uppercase"><label id="modaltipoSalida"></label></div>
                         </div>

                         <hr class="my-5" style="height: 5px; background: linear-gradient(90deg,rgba(9, 11, 122, 1) 33%, rgba(133, 133, 133, 1) 0%); opacity: 1; border:none;">

                            <!--TABLA DE ARTICULOS -->
                            <p class="text-center fs-7"><b> ARTICULOS DE SALIDA </b></p>
                            <div style="overflow: auto scroll; max-height: 400px;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="background-color: rgb(13, 71, 161); color: white;">SALIDA</th>
                                            <th style="background-color: rgb(13, 71, 161); color: white;">ID ARTICULO</th>
                                            <th style="background-color: rgb(13, 71, 161); color: white;">NOMBRE</th>
                                            <th style="background-color: rgb(13, 71, 161); color: white;">CANTIDAD</th>
                                            <th style="background-color: rgb(13, 71, 161); color: white;">PRECIO</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableDetalleSalida"></tbody>
                                </table>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btnCrearArticulo" class="btn" style="color:white; background-color:#21ba45;">
                            ACPETAR
                        </button>                                                          
                    </div>
                </div>
            </div>
        </div>