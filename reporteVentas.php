<?php
include('./api/conexion.php');

 //CATEGORIAS DE ARTICULO
 $categorias = $conn->prepare("SELECT* from uni_categoria"); 
 $categorias->execute();

 //USUARIOS
 $usuarios = $conn->prepare("SELECT rs.id_usuario, d.Nombre from uni_roles_sesion AS rs inner join DIRECTORIO_0 as d ON rs.id_usuario = d.ID "); 
 $usuarios->execute();
?>
    <div class="container-fluid report-header">
        <!-- Encabezado y Botón Generar -->
        <div class="row align-items-center mb-4">
            <div class="col-md-8">
                <h2 class="mb-0">Reporte de ventas</h2>
            </div>
            <div class="col-md-4 text-end">
                <button id="generateReport" class="btn btn-success">
                        <i class="bi bi-file-earmark-pdf"></i> Generar
                </button>    

                <button id="btnReporteVentas" class="btn bg-blue-10" style="color: white;">
                    <i class="fas fa-print"></i>
                </button>
            </div>
        </div>

        <!-- Filtros Principales -->
        <div class="row mb-3">
             <label class="mx-2"> <b>Periodo:</b></label>
            <div class="col-md-2">
                <input type="date" class="form-control" id="startDate">
            </div>
            <div class="col-md-2">
                <input type="date" class="form-control mx-1" id="endDate">
            </div>
            <div class="col-md-4 d-flex flex-wrap align-content-center">
                <div class="mx-2 form-check form-check-inline">
                    <div style="max-width:150px">
                        <input class="form-check-input" type="radio" name="reportType" id="filtro1" value="1" checked>
                        <label class="form-check-label" for="filtro1" >SOLO VENTA</label>
                    </div>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="reportType" id="filtro2" value="2">
                    <label class="form-check-label" for="filtro2">SOLO ARTICULOS</label>
                </div>
            </div>
            
            <div class="col-md-4">
                <button class="btn btn-success" id="toggleFilters">
                    <i class="bi bi-funnel"></i> Filtros
                </button>
            </div>
        </div>

        <!-- Filtros Avanzados (Inicialmente ocultos) -->
        <div class="filter-section collapse" id="advancedFilters">
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="card p-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="allCategories" checked>
                            <label class="form-check-label">Todas las categorías</label>
                        </div>
                        <select class="form-select" id="categorySelect" disabled>
                            <option class="text-center" value='0'>--- CATEGORIAS ---</option>
                                <?php
                                    while($categoria = $categorias->fetch(PDO::FETCH_ASSOC))
                                    echo '<option value="'.$categoria['id_categoria'].'">'.$categoria['categoria'].'</option>';
                                ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card p-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="allEmployees" checked>
                            <label class="form-check-label">Todos los empleados</label>
                        </div>
                        <input type="number" min=2 step="1" class="form-control" id="employeeInput" placeholder="Número de nómina del empleado" disabled>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card p-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="allUsers" checked>
                            <label class="form-check-label">Todos los usuarios</label>
                        </div>
                        <select class="form-select" id="userSelect" disabled>
                            <option class="text-center" value='0'>--- USUARIOS ---</option>
                            <?php
                                while($usuario = $usuarios->fetch(PDO::FETCH_ASSOC))
                                echo '<option value="'.$usuario['id_usuario'].'">'.$usuario['Nombre'].'</option>';
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Resultados -->
        <div class="table-container" style="background-color:white; height: 420px;">
            <table class="table table-striped" id='reportResults'>
                <thead class="sticky-header">
                    <!--CABECERA DE LA TABLA -->
                    <tr id="tableHeader">
                    </tr>
                </thead>
                <tbody id="">
                    <!-- Datos se insertarán aquí dinámicamente -->
                </tbody>
            </table>
            <div id="emptyState" class="text-center flex-wrap align-content-center py-5 d-none" style="width:100%; height:100%;">
                <i class="bi bi-emoji-neutral display-4 text-muted"></i>
                <p class="text-muted fs-5 mt-3">No se encontraron resultados</p>
            </div>
        </div>

        <!-- Modal Detalle de Venta -->
        <div class="modal fade" id="modalDetalleVenta" tabindex="-1" aria-labelledby="eliminarArtModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal">DETALLE DE VENTA</h5>
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
                            <div class="my-1 col-3"><b>Pago total:</b></div>
                            <div class="my-1 col-auto text-uppercase"><label id="modalPagoTotal"></label></div>
                         </div>

                         <hr class="my-5" style="height: 5px; background: linear-gradient(90deg,rgba(9, 11, 122, 1) 33%, rgba(133, 133, 133, 1) 0%); opacity: 1; border:none;">

                            <!--TABLA DE ARTICULOS -->
                            <p class="text-center fs-7"><b> Articulos vendidos </b></p>
                            <div style="overflow: auto scroll; max-height: 400px;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="background-color: rgb(13, 71, 161); color: white;">VENTA</th>
                                            <th style="background-color: rgb(13, 71, 161); color: white;">ID ARTICULO</th>
                                            <th style="background-color: rgb(13, 71, 161); color: white;">NOMBRE</th>
                                            <th style="background-color: rgb(13, 71, 161); color: white;">CANTIDAD</th>
                                            <th style="background-color: rgb(13, 71, 161); color: white;">PRECIO</th>
                                            <th style="background-color: rgb(13, 71, 161); color: white;">COSTO</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableDetallVenta"></tbody>
                                </table>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btnCrearArticulo" class="btn" style="color:white; background-color:#21ba45;">
                            Modificar
                        </button>                                                          
                    </div>
                </div>
            </div>
        </div>

        <div class="d-none p-0 m-0">
            <div id="impresionInventario" class="hojaImpresion" style="font-size:13px;">
            </div>
        </div>