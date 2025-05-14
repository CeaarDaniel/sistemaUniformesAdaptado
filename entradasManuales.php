    <div id="entradasUsado">
        <div class="padding-header">
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h1 class="title">Entradas manuales</h1>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="remarcado-font fs-5" id="numPedido"></div>
            </div>
            
            <div class="row g-3 align-items-center mb-4">
                <div class="col-auto">
                    <button class="btn btn-success" id="generarEntradaBtn" data-bs-toggle="tooltip" title="Confirmar entrada (alt + c)">
                        <i class="bi bi-box-arrow-in-down"></i> Generar entrada
                    </button>
                </div>
                <div class="col-auto">
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#seleccionarArticuloModal">
                        <i class="bi bi-search"></i> Escoger artículo
                    </button>
                    <button class="btn btn-danger" id="eliminarBtn">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>


        <div class="table-container">
            <table id="tablaArticulos" class="table-striped">
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
                <tbody></tbody>
            </table>
        </div>

        <!-- Modales -->
        <div class="modal fade" id="confirmarEliminarModal">
            <!-- Contenido del modal de eliminación -->
        </div>

        <div class="modal fade" id="confirmarEntradaModal">
            <!-- Contenido del modal de confirmación -->
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
                            <form>
                                <h3><i class="bi bi-box-seam"></i> Agregar Artículo</h3>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <label class="form-label">
                                                <i class="bi bi-key-fill bi-icon"></i>
                                                ID
                                            </label>
                                            <input type="text" id="id" class="form-control" placeholder="ID" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <label class="form-label">
                                                <i class="bi bi-tag-fill bi-icon"></i>
                                                Nombre
                                            </label>
                                            <input type="text" id="nombre" class="form-control" placeholder="Nombre" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <label class="form-label">
                                                <i class="bi bi-123 bi-icon"></i>
                                                Cantidad
                                            </label>
                                            <input type="number" id="cantidadArt" class="form-control" placeholder="Cantidad" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <label class="form-label">
                                                <i class="bi bi-grid-fill bi-icon"></i>
                                                Categoría
                                            </label>
                                            <input type="text" id="tipo" class="form-control" placeholder="Categoría" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <label class="form-label">
                                                <i class="bi bi-rulers bi-icon"></i>
                                                Talla
                                            </label>
                                            <input type="text" class="form-control" placeholder="Talla" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <label class="form-label">
                                                <i class="bi bi-gender-ambiguous bi-icon"></i>
                                                Género
                                            </label>
                                            <select class="form-control" id="genero" required>
                                                <option value="" disabled selected>Seleccione género</option>
                                                <option value="hombre">Hombre</option>
                                                <option value="mujer">Mujer</option>
                                                <option value="unisex">Unisex</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <label class="form-label">
                                                <i class="bi bi-currency-exchange bi-icon"></i>
                                                Precio
                                            </label>
                                            <input type="number" id="precio" class="form-control" placeholder="Precio" step="0.01" required>
                                        </div>
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
    </div>