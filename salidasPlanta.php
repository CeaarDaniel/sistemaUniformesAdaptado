<?php 
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
include('./api/conexion.php');

        $sql= "SELECT* from uni_categoria";

        $articulos = $conn->prepare($sql); 
        $articulos->execute()
?>


        <div class="padding-header">
            <div class="row mb-4">
                <h1 class="title">Entrega de uniforme</h1>
            </div>
            
            <div class="row g-3 align-items-center mb-4">
                <div class="col-md-4">
                    <input type="text" class="form-control" id="empleadoInput" data-data-id-empleado='' placeholder="Empleado">
                    <label id="nombreEmpleado" class="ms-2 my-0 fw-bold" for="empleadoInput"></label>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="valeInput" placeholder="Vale">
                    <label class="ms-2 my-0 fw-bold"></label>
                </div>
                <div class="col-6 col-md-4 mb-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipoEntrega" id="empleadoRadio" value = '' checked>
                        <label class="form-check-label" for="empleadoRadio">Empleado</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipoEntrega" id="becarioRadio" value = '0'>
                        <label class="form-check-label" for="becarioRadio">Becario</label>
                    </div>
                    <div class="form-check form-check-inline"> 
                        <input class="form-check-input" type="radio" name="tipoEntrega" id="obsequioRadio" value = '567'>
                        <label class="form-check-label" for="obsequioRadio">Obsequio</label>
                    </div>
                </div>
                <div class="col-4 col-md-auto">
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#seleccionarArticuloModal">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                </div>
                <div class="col-12">
                    <button class="btn btn-secondary" id="cancelarBtn">Cancelar</button>
                    <button class="btn btn-success" id="confirmarBtn">Confirmar</button>
                </div>
            </div>
        </div>

        <div class="table-container" style="background-color:white; height: 420px;">
            <div id="emptyState" class="text-center flex-wrap align-content-center py-5" style="width:100%; height:100%;">
                <i class="bi bi-emoji-neutral display-4 text-muted"></i>
                <p class="text-muted fs-5 mt-3">No se encontraron resultados</p>
            </div>

            <div id="contenedorTabla" class="table-container d-none">
                <table id="tablaArticulos" class="table table-striped">
                <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                            <th>Genero</th>
                            <th>Boton</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>

        <!-- Modal para selección de artículos -->
        <div class="modal fade" id="seleccionarArticuloModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">SELECCIONAR ARTÍCULO</h5>
                        <button class="btn" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-close" style="background-color:none; color:white; font-size:18px;"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-container">
                            <form id="formAgregarArticulo" class="form-control">
                                <h3><i class="bi bi-box-seam"></i> Agregar Artículo</h3>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="">
                                            <label class="form-label">
                                                <i class="bi bi-grid-fill bi-icon"></i>
                                                Categoría
                                            </label>
                                            <select class="form-select" name="tipo" id="tipo" required>
                                                <option value="">Seleccione una categoría</option>
                                                <?php 
                                                    while($articulo = $articulos->fetch(PDO::FETCH_ASSOC))
                                                           echo "<option data-abrev='".$articulo['abrev']."' value='".$articulo['id_categoria']."'>".$articulo['categoria']."</option>";
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="">
                                            <label class="form-label">
                                                <i class="bi bi-rulers bi-icon"></i>
                                                Talla
                                            </label>
                                            <select name="talla" id="talla" class="form-select" required>
                                                <option value="" selected>Seleccione una talla</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="">
                                            <label class="form-label">
                                                <i class="bi bi-gender-ambiguous bi-icon"></i>
                                                Género
                                            </label>
                                            <select id="genero" name="genero" class="form-select" required>
                                                <option value="" selected>Seleccione género</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                            <label class="form-label">
                                                <i class="bi bi-tag-fill bi-icon"></i>
                                                Nombre
                                            </label>
                                            <input type="text" id="nombre" class="form-control" placeholder="Nombre" readonly>
                                    </div>
                                    

                                    <div class="col-md-6">
                                            <label class="form-label">
                                                <i class="bi bi-currency-exchange bi-icon"></i>
                                                Precio
                                            </label>
                                            <input type="number" id="precio" class="form-control" placeholder="Precio" step="0.01" readonly>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="">
                                            <label class="form-label">
                                                <i class="bi bi-123 bi-icon"></i>
                                                Cantidad
                                            </label>
                                            <input type="number" id="cantidadArt" class="form-control" placeholder="Cantidad" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <!--
                                            <label class="form-label">
                                                <i class="bi bi-key-fill bi-icon"></i> ID
                                            </label> 
                                        -->
                                            <input id="id" class="form-control d-none" type="text" >
                                    </div>

                                    <div class="col-12">
                                        <button id="btnAgregarArticulo" class="btn btn-custom" type="button">
                                            <i class="bi bi-plus-circle"></i> Agregar Artículo
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para la seleccion de articulos con el uso del barcode del vale -->
        <div class="modal fade" id="seleccionarValeArticuloModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">SELECCIONAR ARTÍCULO</h5>
                        <button class="btn" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-close" style="background-color:none; color:white; font-size:18px;"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="my-3" style="width:100%; height:auto; overflow-x: auto;">
                                <table id="talbaBarcodePrueba" class="table" style="width:100%">
                                    <thead class="header-table">
                                        <tr>
                                            <th>ACTIONS</th>
                                            <th>ID</th>
                                            <th>CATEGORIA</th>
                                            <th>GENERO</th> 
                                            <th>TALLA</th>
                                            <th>CANTIDAD</th>
                                        </tr>
                                    </thead>
                                <tbody style="width:100%">
                                    <!-- Los datos se cargarán dinámicamente -->
                                </tbody>
                                </table>
                            </div>

                            <div class="text-left">
                                 <button id="btnConfirmarVale" class="btn" style="color:white; background-color:#21ba45;">
                                    CONFIRMAR
                                </button>
                            </div>
                        </div>
                </div>
            </div>
        </div>