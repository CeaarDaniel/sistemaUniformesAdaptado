
    <div id="cambios">
        <!-- Barra de progreso (simulada) -->
        <div class="progress-bar" style="height: 8px; background-color: #6c757d;"></div>

        <!-- Título -->
        <div class="container mt-4">
            <h1 class="title text-center">Cambio de Artículos</h1>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="container mt-4">
            <div class="row g-3 align-items-center">
                <!-- Número de Salida -->
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="numSalida" placeholder="Núm. Salida">
                        <button class="btn btn-warning">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Información de la Salida -->
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Fecha:</strong> <span id="fechaSalida"></span></p>
                            <p><strong>Realizado por:</strong> <span id="realizadoPor"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Para:</strong> <span id="paraUsuario"></span></p>
                            <p><strong>Tipo:</strong> <span id="tipoSalida"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tablas de Artículos -->
        <div class="container mt-4">
            <div class="row">
                <!-- Tabla de Artículos Originales -->
                <div class="col-md-6">
                    <h4>Artículos (Original)</h4>
                    <div class="table-container">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cantidad</th>
                                    <th>Nombre</th>
                                    <th>Talla</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody id="tablaOriginal">
                                <!-- Filas de la tabla se llenarán dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tabla de Artículos de Cambio -->
                <div class="col-md-6">
                    <h4>Artículos (Cambio)</h4>
                    <div class="table-container">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cantidad</th>
                                    <th>Nombre</th>
                                    <th>Talla</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody id="tablaCambio">
                                <!-- Filas de la tabla se llenarán dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón de Realizar Cambio -->
        <div class="container mt-4 text-end">
            <button class="btn btn-success">Realizar Cambio</button>
        </div>

        <!-- Modal de Confirmación -->
        <div class="modal fade" id="modalConfirmacion" tabindex="-1" aria-labelledby="modalConfirmacionLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalConfirmacionLabel">Confirmar Cambio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de realizar el cambio de artículos? Los artículos cambiados serán regresados al almacén.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Selección de Artículo -->
        <div class="modal fade" id="escogerArtModal" tabindex="-1" aria-labelledby="escogerArtModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="escogerArtModalLabel">Seleccionar Artículo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Selecciona un artículo para realizar el cambio.</p>
                        <!-- Aquí iría la lista de artículos disponibles -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary">Seleccionar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>