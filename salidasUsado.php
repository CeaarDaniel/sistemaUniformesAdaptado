    <div id="salidasPlanta">
        <div class="padding-header my-4">
            <h1 class="title">Salidas de uniforme usado</h1>
            
            <div class="row g-3 my-4">
                <div class="col-md-4">
                    <input type="text" class="form-control" id="empleadoInput" placeholder="Empleado" @keyup.enter="buscarEmpleado">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="articuloInput" placeholder="Artículo" readonly>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" id="cantidadInput" value="1" min="1">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-success" id="agregarBtn">
                        <i class="bi bi-plus-lg"></i> Agregar
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
                        <th>Categoría</th>
                        <th>Talla</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody id="articulosBody"></tbody>
            </table>
            <div id="emptyState" class="text-center py-5">
                <i class="bi bi-emoji-neutral display-4 text-muted"></i>
                <p class="text-muted fs-5 mt-3">No hay artículos agregados</p>
            </div>
        </div>

        <div class="text-end mb-4">
            <button class="btn btn-success btn-lg" id="confirmarBtn">Confirmar Salida</button>
        </div>

        <!-- Modal Confirmación -->
        <div class="modal fade" id="confirmModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmar Salida</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de realizar la entrega de uniforme?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="confirmAction">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
