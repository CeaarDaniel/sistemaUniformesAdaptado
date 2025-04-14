    <div id="salidasPlanta">
        <!-- Barra de progreso -->
        <div id="progressBar" class="progress fixed-bottom d-none" style="height: 8px;">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary" style="width: 100%"></div>
        </div>

        <div class="padding-header">
            <div class="row mb-4">
                <h1 class="title">Entrega de uniforme</h1>
            </div>
            
            <div class="row g-3 align-items-center mb-4">
                <div class="col-md-4">
                    <input type="text" class="form-control" id="empleadoInput" placeholder="Empleado">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="valeInput" placeholder="Vale">
                </div>
                <div class="col-md-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipoEntrega" id="becarioRadio">
                        <label class="form-check-label" for="becarioRadio">Becario</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipoEntrega" id="obsequioRadio">
                        <label class="form-check-label" for="obsequioRadio">Obsequio</label>
                    </div>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#seleccionarArticuloModal">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="table-container">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Acciones</th>
                        <th>Estado</th>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Género</th>
                        <th>Talla</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody id="articulosTableBody"></tbody>
            </table>
            <div id="emptyState" class="text-center py-5 d-none">
                <i class="bi bi-emoji-neutral display-4 text-muted"></i>
                <p class="text-muted fs-5 mt-3">No hay ningún artículo agregado</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="padding-header">
            <div class="row justify-content-end">
                <div class="col-auto">
                    <button class="btn btn-secondary" id="cancelarBtn">Cancelar</button>
                    <button class="btn btn-success" id="confirmarBtn">Confirmar</button>
                </div>
            </div>
        </div>

        <!-- Modales -->
        <div class="modal fade" id="confirmarModal">
            <!-- Contenido del modal de confirmación -->
        </div>

        <div class="modal fade" id="notasModal">
            <!-- Contenido del modal de notas -->
        </div>
    </div>