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
                <h1 class="title">Venta de uniforme</h1>
            </div>
            
            <div class="row g-3 align-items-center mb-4">
                <div class="col-md-4">
                    <input type="number" min="2" step="1" class="form-control" id="empleadoInput" placeholder="Empleado">
                    <label id="nombreEmpleado" class="ms-2 my-0 fw-bold" for="empleadoInput"></label>
                </div>
                <div class="col-4 col-md-auto mb-4">
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#seleccionarArticuloModal">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                </div>
                <div class="col-12 col-md-auto mb-4">
                    <button class="btn btn-secondary" id="cancelarBtn">Cancelar</button>
                    <button class="btn btn-success" id="confirmarBtn">Confirmar</button>
                </div>
            </div>
        </div>

        <div class="text-end fs-3">
            <b>TOTAL:</b> $ <label id="costoTotalVenta" class="fs-3">0</label>
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
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
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

             
        <!--Modal confirmar numero de descuentos -->
        <div class="modal fade" id="descuentosModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="text-center textDescuentos">CANTIDAD DE DESCUENTOS DE NÓMINA</h5>
                        <button class="btn" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-close" style="background-color:none; color:white; font-size:18px;"></i></button>
                    </div>
                    <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="">
                                            <label class="form-label textDescuentos">
                                                Tipo de nómina: <span id="tipoPago"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="from-group">
                                            <label class="form-label textDescuentos">
                                               <i class="bi bi-tags-fill bi-icon"></i>
                                                Numero de descuentos:
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 mx-0 px-0">
                                        <input type="number" id="cantidadDescuentos" min= "1" max="4" class="form-control textDescuentos" placeholder="Cantidad" required>
                                    </div>
                                    <div class="col-12">
                                        <button id="btnModalDescuentos" class="btn btn-custom textDescuentos" type="button">
                                             Registrar
                                        </button>
                                    </div>
                                </div>
                    </div>
                </div>
            </div>
        </div>
        
<!-- 
    <div id="salidasVenta">
        <div class="padding-header">
            <h1 class="title mb-4">Venta de uniforme</h1>
            
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <input type="text" class="form-control" id="empleadoInput" placeholder="Empleado">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="articuloInput" placeholder="Artículo" readonly>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" id="cantidadInput" value="1" min="1">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-success" id="agregarArticuloBtn">
                        <i class="bi bi-plus-lg"></i> Agregar
                    </button>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#seleccionarArticuloModal">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="table-container mb-4">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Acciones</th>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Talla</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody id="articulosBody"></tbody>
            </table>
            <div id="emptyState" class="text-center py-5 d-none">
                <i class="bi bi-emoji-neutral display-4 text-muted"></i>
                <p class="text-muted fs-5 mt-3">No hay artículos agregados</p>
            </div>
        </div>

        <div class="row justify-content-end mb-4">
            <div class="col-auto">
                <h3 id="totalDisplay" class="text-end"></h3>
            </div>
        </div>

        <div class="row justify-content-end">
            <div class="col-auto">
                <button class="btn btn-secondary" id="cancelarBtn">Cancelar</button>
                <button class="btn btn-success" id="confirmarBtn">Confirmar</button>
            </div>
        </div>

         Modales 
        <div class="modal fade" id="confirmarModal">
             Contenido del modal de confirmación
        </div>

        <div class="modal fade" id="descuentosModal">
             Contenido del modal de descuentos 
        </div>
    </div> 
-->