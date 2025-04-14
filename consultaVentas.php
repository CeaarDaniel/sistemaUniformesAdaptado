
    <!-- Contenido principal -->
    <div class="padding-header">
        <div class="row">
            <div class="col-12">
                <h1 class="title">Consultas de ventas</h1>
            </div>
        </div>

        <!-- Filtros -->
        <div class="row mt-3">
            <div class="col-md-3">
                <select class="form-select" id="mes">
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
            <div class="col-md-3">
                <select class="form-select" id="anio">
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                    <option value="2030">2030</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="orden">
                    <option value="ASC">Ascendente</option>
                    <option value="DESC">Descendente</option>
                </select>
            </div>
            <div class="col-md-3 text-end">
                <h4>Total: <span id="totalVentas">$1,209.00</span></h4>
            </div>
        </div>

        <!-- Tabla de ventas -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="table-wrapper">
                    <table id="tablaVentas">
                        <thead>
                            <tr>
                                <th colspan="4">VENTA</th>
                                <th colspan="12">CANT. DE DESCUENTOS</th>
                                <th rowspan="2">TOTAL DESC.</th>
                                <th rowspan="2">FIRMA</th>
                            </tr>
                            <tr>
                                <th colspan="3">1 de 1</th>
                                <th colspan="3">2 de 1</th>
                                <th colspan="3">3 de 1</th>
                                <th colspan="3">4 de 1</th>
                            </tr>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Empleado</th>
                                <th>Costo total</th>
                                <th></th>
                                <th>Descuento</th>
                                <th>Fecha</th>
                                <th></th>
                                <th>Descuento</th>
                                <th>Fecha</th>
                                <th></th>
                                <th>Descuento</th>
                                <th>Fecha</th>
                                <th></th>
                                <th>Descuento</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Ejemplo de fila de venta -->
                            <tr class="row-venta">
                                <td>2411</td>
                                <td>06/03/2025 08:51:20 AM</td>
                                <td><b>1109-HERNANDEZ CARDONA VICTOR EDUARDO</b></td>
                                <td>$79.00</td>
                                <td class="desc-1">
                                    <input type="checkbox">
                                </td>
                                <td class="desc-1" style="font-weight: bold;">$19.75</td>
                                <td class="desc-1">
                                    <input type="text" value="06/03/2025" disabled>
                                </td>
                                <td class="desc-2">
                                    <input type="checkbox">
                                </td>
                                <td class="desc-2" style="font-weight: bold;">$19.75</td>
                                <td class="desc-2">
                                    <input type="text" value="06/03/2025" disabled>
                                </td>
                                <td class="desc-3">
                                    <input type="checkbox">
                                </td>
                                <td class="desc-3" style="font-weight: bold;">$19.75</td>
                                <td class="desc-3">
                                    <input type="text" value="06/03/2025" disabled>
                                </td>
                                <td class="desc-4">
                                    <input type="checkbox">
                                </td>
                                <td class="desc-4" style="font-weight: bold;">$19.75</td>
                                <td class="desc-4">
                                    <input type="text" value="06/03/2025" disabled>
                                </td>
                                <td><b>$0.00</b></td>
                                <td>
                                    <button class="btn btn-sm btn-primary">
                                        <i class="fas fa-signature"></i>
                                    </button>
                                </td>
                            </tr>
                            <!-- Más filas de ventas se pueden agregar dinámicamente -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>