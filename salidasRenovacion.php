    <div class="container mt-4">
        <h1 class="title mb-4">Renovación de Uniforme</h1>
        
        <!-- Sección de búsqueda -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" class="form-control" id="empleadoInput" placeholder="Número de empleado">
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary" id="buscarEmpleadoBtn">
                    <i class="bi bi-search"></i> Buscar Empleado
                </button>
            </div>
        </div>

        <!-- Tabla de artículos -->
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
            <div id="emptyState" class="text-center py-5">
                <i class="bi bi-emoji-neutral display-4 text-muted"></i>
                <p class="text-muted fs-5 mt-3">No hay artículos agregados</p>
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="d-flex justify-content-end gap-2 mb-4">
            <button class="btn btn-secondary" id="cancelarBtn">Cancelar</button>
            <button class="btn btn-success" id="confirmarBtn">Confirmar Renovación</button>
        </div>
    </div>

    <!-- Modales -->
    <div class="modal fade" id="confirmModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Renovación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de realizar la renovación de uniforme?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirmarRenovacionBtn">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tipoUniformeModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Seleccionar Tipo de Uniforme</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card uniform-type-card h-100" data-tipo="operario">
                                <img src="operario.jpg" class="card-img-top" alt="Uniforme Operario">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Uniforme Operario</h5>
                                    <p class="card-text">1 Playera MC, 1 Playera ML, 2 Pantalones</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card uniform-type-card h-100" data-tipo="staff">
                                <img src="staff.jpg" class="card-img-top" alt="Uniforme Staff">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Uniforme Staff</h5>
                                    <p class="card-text">1 Camisa MC, 1 Camisa ML, 2 Pantalones</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>