    <div class="container-fluid report-header">
        <!-- Encabezado y Botón Generar -->
        <div class="row align-items-center mb-4">
            <div class="col-md-8">
                <h2 class="mb-0">Reporte de ventas</h2>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-success" id="generateReport">
                    <i class="bi bi-file-earmark-pdf"></i> Generar
                </button>
            </div>
        </div>

        <!-- Filtros Principales -->
        <div class="row mb-3">
            <div class="col-md-3">
                <label>Periodo:</label>
                <div class="d-flex gap-2">
                    <input type="date" class="form-control" id="startDate">
                    <input type="date" class="form-control mx-1" id="endDate">
                </div>
            </div>
            
            <div class="col-md-6 d-flex align-items-center">
                <div class="mx-4 form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="reportType" value="1" checked>
                    <label class="form-check-label">Solo venta</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="reportType" value="2">
                    <label class="form-check-label">Venta con detalles</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="reportType" value="3">
                    <label class="form-check-label">Solo artículos</label>
                </div>
            </div>
            
            <div class="col-md-3 text-end">
                <button class="btn btn-primary" id="toggleFilters">
                    <i class="bi bi-funnel"></i> Filtros
                </button>
            </div>
        </div>

        <!-- Filtros Avanzados (Inicialmente ocultos) -->
        <div class="filter-section collapse" id="advancedFilters">
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="card p-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="allCategories">
                            <label class="form-check-label">Todas las categorías</label>
                        </div>
                        <select class="form-select" id="categorySelect" disabled>
                            <option value="1">Categoría 1</option>
                            <option value="2">Categoría 2</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card p-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="allEmployees">
                            <label class="form-check-label">Todos los empleados</label>
                        </div>
                        <input type="text" class="form-control" id="employeeInput" disabled>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card p-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="allUsers">
                            <label class="form-check-label">Todos los usuarios</label>
                        </div>
                        <select class="form-select" id="userSelect" disabled>
                            <option value="1">Usuario 1</option>
                            <option value="2">Usuario 2</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Ordenamiento -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Ordenar por:</label>
                    <select class="form-select" id="sortField">
                        <option>ID</option>
                        <option>Cantidad</option>
                        <option>Categoría</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Dirección:</label>
                    <select class="form-select" id="sortDirection">
                        <option>ASC</option>
                        <option>DESC</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Resultados -->
    <div class="container-fluid mt-4">
        <div class="table-container">
            <table class="table table-striped">
                <thead class="sticky-header">
                    <tr id="tableHeader">
                        <th>Cant.</th>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Empleado</th>
                        <th>Usuario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="reportResults">
                    <!-- Datos se insertarán aquí dinámicamente -->
                </tbody>
            </table>
            <div id="emptyState" class="text-center py-5 d-none">
                <i class="bi bi-emoji-neutral display-4 text-muted"></i>
                <p class="text-muted fs-5 mt-3">No se encontraron resultados</p>
            </div>
        </div>
    </div>