<div class="container-fluid">
    <!-- Header Section -->
    <div class="padding-header">
        <div class="row mt-3 justify-content-between">
            <div class="col-3 align-self-center">
                <div class="title">Reporte de salidas</div>
            </div>
            <div class="col-2 align-self-center">
                <button id="btngenerarReporte" class="btn btn-success">
                    <i class="fas fa-file-invoice me-2"></i>Generar
                </button>
            </div>
        </div>

        <!-- Filtros Principales -->
        <div class="row mt-2 mb-2">
            <div class="col-1 align-self-center">Periodo:</div>
            <div class="col-4">
                <div class="input-group">
                    <input type="date" id="fechaDesde" class="form-control">
                    <span class="input-group-text">a</span>
                    <input type="date" id="fechaHasta" class="form-control">
                </div>
            </div>
            
            <div class="col-auto ms-3">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rbnSalida" value="1" checked>
                    <label class="form-check-label">Solo salidas</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rbnSalida" value="2">
                    <label class="form-check-label">Salida con detalles</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rbnSalida" value="3">
                    <label class="form-check-label">Solo artículos</label>
                </div>
            </div>
            
            <div class="col-auto ms-auto">
                <button id="toggleFilter" class="btn btn-success">
                    <i class="fas fa-sliders-h"></i>
                </button>
            </div>
        </div>

        <!-- Filtros Avanzados -->
        <div class="filter-transition" id="filterSection">
            <hr>
            <!-- Tipo Salidas -->
            <div class="row mt-2">
                <div class="col-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ftrTipoSalidas" checked>
                        <label class="form-check-label">Todos los tipos</label>
                    </div>
                </div>
                <div class="col-4 ms-3">
                    <select class="form-select" id="valTipoSalida" disabled>
                        <option value="1">Seleccione tipo</option>
                    </select>
                </div>
            </div>

            <!-- Empleados -->
            <div class="row mt-2">
                <div class="col-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ftrEmpleados" checked>
                        <label class="form-check-label">Todos empleados</label>
                    </div>
                </div>
                <div class="col-4 ms-3">
                    <input type="text" class="form-control" id="iptEmpleado" disabled>
                </div>
            </div>

            <!-- Usuarios -->
            <div class="row mt-2 mb-3">
                <div class="col-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ftrUsuarios" checked>
                        <label class="form-check-label">Todos usuarios</label>
                    </div>
                </div>
                <div class="col-4 ms-3">
                    <select class="form-select" id="valUsuario" disabled>
                        <option value="3">Seleccione usuario</option>
                    </select>
                </div>
            </div>

            <hr>

            <!-- Ordenamiento -->
            <div class="row mt-2">
                <div class="col-2 align-self-center">Ordenar por:</div>
                <div class="col-2">
                    <select class="form-select" id="valTipoOrden">
                        <option>ID</option>
                        <option>Cantidad</option>
                        <option>Categoria</option>
                    </select>
                </div>
                <div class="col-2 ms-3">
                    <select class="form-select" id="valAscDecOrden">
                        <option>ASC</option>
                        <option>DESC</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Resultados -->
    <div class="padding-side">
        <div class="row justify-content-center">
            <div class="col-11">
                <div class="card mt-3" style="height: 63vh;">
                    <div id="emptyState" class="card-body text-center d-none">
                        <i class="far fa-meh-blank mb-3" style="font-size: 7em; color: #E7E9EC"></i>
                        <p class="empty-state">No se encontraron resultados :(</p>
                    </div>
                    
                    <div id="tableContent" class="card-body p-0">
                        <div class="table-wrapper" style="height: 63vh;">
                            <table id="reporteTable" style="position: sticky;
                                                            top: 0;
                                                            background: #0a0ad6;
                                                            color: white;
                                                            width:100%"
                                                            >
                                <thead id="tableHeader"></thead>
                                <tbody id="reporteBody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>