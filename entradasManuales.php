    <div id="entradasUsado">
        <!-- Barra de progreso -->
        <div id="progressBar" class="progress fixed-bottom d-none" style="height: 8px;">
            <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%"></div>
        </div>

        <div class="padding-header">
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h1 class="title">Entradas manuales</h1>
                </div>
                <div class="col-auto">
                    <button class="btn btn-success" id="generarEntradaBtn" data-bs-toggle="tooltip" title="Confirmar entrada (alt + c)">
                        <i class="bi bi-box-arrow-in-down"></i> Generar entrada
                    </button>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="remarcado-font fs-5" id="numPedido"></div>
            </div>
            
            <div class="row g-3 align-items-center mb-4">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="articuloNombre" placeholder="Artículo" readonly 
                               data-bs-toggle="modal" data-bs-target="#seleccionarArticuloModal">
                        <input type="number" class="form-control" id="cantidad" value="1" min="1" style="max-width: 100px;">
                        <button class="btn btn-success" id="agregarArticuloBtn">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </div>
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
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cantidad</th>
                        <th>Nombre</th>
                        <th>Categoria</th>
                        <th>Talla</th>
                        <th>Género</th>
                        <th><input type="checkbox" id="selectAll"></th>
                    </tr>
                </thead>
                <tbody id="tablaArticulos"></tbody>
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
                        <h5 class="modal-title">Seleccionar Artículo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Contenido de selección de artículos -->
                    </div>
                </div>
            </div>
        </div>
    </div>