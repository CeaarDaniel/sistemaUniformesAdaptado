<div id="salidasReposicion">
    <div class="padding-header my-4">
        <h1 class="title">Reposición de Uniforme</h1>
        
        <div class="row g-3 my-4">
            <div class="col-md-4">
                <input type="text" class="form-control" id="empleadoInput" placeholder="Empleado">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" id="valeInput" placeholder="Vale">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" id="articuloInput" placeholder="Artículo" readonly>
            </div>
            <div class="col-md-2">
                <input type="number" class="form-control" id="cantidadInput" value="1" min="1">
            </div>
            <div class="col-md-4 mt-3">
                <button class="btn btn-success" id="agregarBtn">
                    <i class="bi bi-plus-lg"></i> Agregar Artículo
                </button>
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#articuloModal">
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
                    <th>Género</th>
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

    <div class="text-end mb-4">
        <button class="btn btn-secondary me-2" id="cancelarBtn">Cancelar</button>
        <button class="btn btn-primary" id="confirmarBtn">Confirmar Reposición</button>
    </div>

    <!-- Modales -->
    <div class="modal fade" id="confirmModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Reposición</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de realizar la reposición de uniforme?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirmAction">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
</div>