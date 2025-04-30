    <!-- Contenido principal -->
    <div class="padding-header">
        <div class="row">
            <label for="">Reportes</label>
            <div class="col-md-3">

                <ul>
                    <li>De ventas</li>
                    <li><a onclick="cargarRuta('consultasReportesInventario')">De inventario</a></li>
                    <li>De entradas</li>
                </ul>
                    <select class="form-selet" id="categoriaCat">
                        <option value="0">De ventas</option>
                        <option value="1"><a onclick="cargarRuta('consultasReportesInventario')">De inventario</a></option>
                        <option value="2">De entradas</option>
                    </select>
            </div>
            <div class="col-12">
                <h1 class="title">Reporte de Ventas</h1>
            </div>
        </div>

        <!-- Filtros -->
        <div class="row mt-3">
            <div class="col-md-8">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="opcion_ventas" id="mesActual" value="0" checked>
                    <label class="form-check-label" for="mesActual">Mes actual</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="opcion_ventas" id="mesAnterior" value="1">
                    <label class="form-check-label" for="mesAnterior">Mes anterior</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="opcion_ventas" id="anioActual" value="2">
                    <label class="form-check-label" for="anioActual">Año actual</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="opcion_ventas" id="periodo" value="3">
                    <label class="form-check-label" for="periodo">Periodo...</label>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-custom" id="generarReporte">Generar</button>
            </div>
        </div>

        <!-- Reporte de ventas -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="reporte-card">
                    <h2 class="text-center" id="tituloReporte">Ventas de Octubre del 2023</h2>

                    <!-- Ventas generales -->
                    <div class="row top-dashed-line">
                        <div class="col-md-4">
                            <span class="title">Ventas totales: </span>
                            <span class="title-content" id="ventasTotales">$10,000.00</span>
                        </div>
                        <div class="col-md-4">
                            <span class="title">Número de ventas: </span>
                            <span class="title-content" id="numVentas">50</span>
                        </div>
                        <div class="col-md-4">
                            <span class="title">Venta promedio: </span>
                            <span class="title-content" id="ventaPromedio">$200.00</span>
                        </div>
                    </div>

                    <!-- Ventas diarias -->
                    <div class="row top-dashed-line">
                        <div class="col-md-6">
                            <div class="title">Ventas</div>
                            <div class="striped-list" id="ventasDiarias">
                                <!-- Las ventas diarias se llenarán dinámicamente -->
                            </div>
                        </div>

                        <!-- Ventas por categoría -->
                        <div class="col-md-6">
                            <div class="title">Ventas por categoría</div>
                            <div class="striped-list" id="ventasCategoria">
                                <!-- Las ventas por categoría se llenarán dinámicamente -->
                            </div>
                        </div>
                    </div>

                    <!-- Ganancias por categoría -->
                    <div class="row top-dashed-line">
                        <div class="col-md-6">
                            <div class="title">Ganancias por categoría</div>
                            <div class="striped-list" id="gananciasCategoria">
                                <!-- Las ganancias por categoría se llenarán dinámicamente -->
                            </div>
                        </div>

                        <!-- Ganancia total -->
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="title">Ganancia total:</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="title-content" id="gananciaTotal">$5,000.00</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>