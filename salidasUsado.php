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
                    <input type="number" min="2" step="1" class="form-control" id="empleadoInput" placeholder="Empleado">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="valeInput" placeholder="Vale">
                </div>
                <div class="col-4 col-md-auto">
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#seleccionarArticuloModal">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                </div>
                <div class="col-12 col-md-auto">
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
                            <th>ID</th>
                            <th>nombre</th>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
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
                                                           echo "<option value='".$articulo['id_categoria']."'>".$articulo['categoria']."</option>";
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