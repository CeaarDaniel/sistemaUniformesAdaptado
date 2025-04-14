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

        <!-- Modales -->
        <div class="modal fade" id="confirmarModal">
            <!-- Contenido del modal de confirmación -->
        </div>

        <div class="modal fade" id="descuentosModal">
            <!-- Contenido del modal de descuentos -->
        </div>
    </div>