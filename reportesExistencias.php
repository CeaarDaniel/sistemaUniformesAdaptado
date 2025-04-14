    <div id="reportesExistencias">
        <!-- Header Section -->
        <div class="padding-header">
            <div class="row mt-3 justify-content-between">
                <div class="col-3 align-self-center">
                    <div  class="title" style="font-size: 1.5rem; font-weight: 500;">Reporte de existencias</div>
                </div>
                <div class="col-2 align-self-center">
                    <button id="btngenerarReporte" class="btn btn-success">
                        <i class="fas fa-file-invoice me-2"></i>Generar
                    </button>
                </div>
            </div>

            <!-- Radio Buttons -->
            <div class="row mt-2 mb-2">
                <div class="col-auto ms-3">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rbnExistencia" value="1" checked>
                        <label class="form-check-label">Todos</label>
                    </div>
                    <div class="form-check form-check-inline ms-3">
                        <input class="form-check-input" type="radio" name="rbnExistencia" value="2">
                        <label class="form-check-label">Solo con existencia</label>
                    </div>
                    <div class="form-check form-check-inline ms-3">
                        <input class="form-check-input" type="radio" name="rbnExistencia" value="3">
                        <label class="form-check-label">Sin existencia</label>
                    </div>
                </div>
                <div class="col-auto ms-auto">
                    <button id="toggleFilter" class="btn btn-success">
                        <i class="fas fa-sliders-h"></i>
                    </button>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="filter-transition" id="filterSection">
                <hr>
                <!-- Categorías -->
                <div class="row mt-2">
                    <div class="col-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ftrCategorias" checked>
                            <label class="form-check-label">Todas las categorías</label>
                        </div>
                    </div>
                    <div class="col-4 ms-3">
                        <select class="form-select" id="valCategoria" disabled>
                            <option value="1">Seleccione categoría</option>
                        </select>
                    </div>
                </div>

                <!-- Géneros -->
                <div class="row mt-2">
                    <div class="col-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ftrGeneros" checked>
                            <label class="form-check-label">Todos los géneros</label>
                        </div>
                    </div>
                    <div class="col-4 ms-3">
                        <select class="form-select" id="valGenero" disabled>
                            <option value="1">Seleccione género</option>
                        </select>
                    </div>
                </div>

                <!-- Estados -->
                <div class="row mt-2 mb-3">
                    <div class="col-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ftrEstados" checked>
                            <label class="form-check-label">Todos los estados</label>
                        </div>
                    </div>
                    <div class="col-4 ms-3">
                        <select class="form-select" id="valEstado" disabled>
                            <option value="1">Seleccione estado</option>
                        </select>
                    </div>
                </div>

                <hr>

                <!-- Ordenar -->
                <div class="row mt-2">
                    <div class="col-2 align-self-center">Ordenar por:</div>
                    <div class="col-2">
                        <select class="form-select" id="valTipoOrden">
                            <option>ID</option>
                            <option>Existencia</option>
                            <option>Categoria</option>
                        </select>
                    </div>
                    <div class="col-2 ms-3">
                        <select class="form-select" id="valAscDescOrden">
                            <option>ASC</option>
                            <option>DESC</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="padding-side">
            <div class="row justify-content-center">
                <div class="col-11">
                    <div class="card mt-3" style="height: 350;">
                        <div id="emptyState" class="card-body text-center d-none">
                            <i class="far fa-meh-blank mb-3" style="font-size: 7em; color: #E7E9EC"></i>
                            <p class="empty-state">No se encontraron resultados :(</p>
                        </div>
                        
                        <div id="tableContent" class="card-body p-0">
                            <div class="table-wrapper" style="height:350px;  overflow-y:auto">
                                <table style="width: 100%;  border-spacing: 0;">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Stock min.</th>
                                            <th>Stock max.</th>
                                            <th>Existencia</th>
                                        </tr>
                                    </thead>
                                    <tbody id="reporteBody"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


