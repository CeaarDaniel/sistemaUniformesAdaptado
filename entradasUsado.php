<div id="entradasUsado">

    <div class="padding-header">
        <div class="row align-items-center mb-4">
            <div class="col">
                <h1 class="title">Entradas de uniforme usado</h1>
            </div>
            <div class="col-auto">
                <button class="btn btn-success" id="generarEntradaBtn" data-bs-toggle="tooltip" title="Confirmar entrada (alt + c)">
                <i class="fas fa-sign-out-alt"></i> Generar entrada
                </button>
            </div>
        </div>
        
        <div class="row g-3 align-items-center mb-4">
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control" id="articuloNombre" placeholder="Artículo" readonly 
                            data-bs-toggle="modal" data-bs-target="#seleccionarArticuloModal">
                    <input type="number" class="form-control" id="cantidad" value="1" min="1" style="max-width: 100px;">
                    <button class="btn btn-success" id="agregarArticuloBtn">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="col-auto">
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#seleccionarArticuloModal">
                    <i class="fa fa-search"></i> Escoger artículo
                </button>
                <button class="btn btn-danger" id="eliminarBtn">
                    <i class="fa fa-trash"></i>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de eliminar los artículos seleccionados?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmarEliminacionBtn">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmarEntradaModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar entrada</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de realizar la entrega de uniforme?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="confirmarEntradaBtn">Confirmar</button>
                </div>
            </div>
        </div>
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