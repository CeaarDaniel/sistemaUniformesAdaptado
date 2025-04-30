<div id="consultaSalidas">
        <!-- Barra de progreso (simulada) -->
        <div class="progress-bar" style="height: 8px; background-color: #6c757d;"></div>

        <!-- Título -->
        <div class="container mt-4">
            <h1 class="title text-center">Consultas de Salidas</h1>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="container mt-4">
            <div class="row g-3 align-items-center">
                <!-- Tipo de Salida -->
                <div class="col-md-4">
                    <select class="form-select" id="tipo" onchange="fechaOnChange()">
                        <option value="1">Tipo 1</option>
                        <option value="2">Tipo 2</option>
                        <option value="3">Tipo 3</option>
                    </select>
                </div>

                <!-- Mes -->
                <div class="col-md-2">
                    <select class="form-select" id="mes" onchange="fechaOnChange()">
                        <option value="1">Enero</option>
                        <option value="2">Febrero</option>
                        <option value="3">Marzo</option>
                        <option value="4">Abril</option>
                        <option value="5">Mayo</option>
                        <option value="6">Junio</option>
                        <option value="7">Julio</option>
                        <option value="8">Agosto</option>
                        <option value="9">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                </div>

                <!-- Año -->
                <div class="col-md-2">
                    <select class="form-select" id="anio" onchange="fechaOnChange()">
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                    </select>
                </div>

                <!-- Búsqueda -->
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="busquedaEmp" placeholder="Buscar empleado" oninput="filtrarPorBusqueda()">
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Salidas -->
        <div class="container mt-4 table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Realizado por</th>
                        <th>Empleado</th>
                        <th>Vale</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaSalidas">
                    <!-- Filas de la tabla se llenarán dinámicamente -->
                </tbody>
            </table>
        </div>

        <!-- Modal de Ver Salida -->
        <div class="modal fade" id="verSalidaModal" tabindex="-1" aria-labelledby="verSalidaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verSalidaModalLabel">Ver Salida</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Detalles de la salida -->
                        <p><strong>ID:</strong> <span id="salidaId"></span></p>
                        <p><strong>Fecha:</strong> <span id="salidaFecha"></span></p>
                        <p><strong>Tipo:</strong> <span id="salidaTipo"></span></p>
                        <p><strong>Realizado por:</strong> <span id="salidaRealizadoPor"></span></p>
                        <p><strong>Empleado:</strong> <span id="salidaEmpleado"></span></p>
                        <p><strong>Vale:</strong> <span id="salidaVale"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="#/cambios" onclick="cargarRuta('cambios')">CAMBIOS</a>
      <!-- Script personalizado -->