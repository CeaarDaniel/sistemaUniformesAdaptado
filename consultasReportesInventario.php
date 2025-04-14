

    <style>
        .title {
            font-size: 24px;
            color: #3f7aaa;
        }

        .title-content {
            font-size: 24px;
            color: #757779;
        }

        .table-content {
            font-size: 17px;
            color: black;
        }

        .table-subtitle {
            font-size: 17px;
            color: #757779;
        }

        .top-dashed-line {
            border-top: 1px dashed #757779;
            padding-bottom: 1.5rem;
            padding-top: 1.5rem;
        }

        .reporte-card {
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .striped-list .row:nth-of-type(odd) {
            background-color: #f2f1ff;
        }

        .btn-custom {
            background-color: green;
            color: white;
        }
    </style>


    <!-- Contenido principal -->
        <div class="padding-header mx-5">
            <div class="row">
                <div class="col-sm-3 my-1">
                        <label for="">Reportes</label>
                        <select class="form-select" id="categoriaCat">
                            <option value="0">De ventas</option>
                            <option value="1">De inventario</option>
                            <option value="2">De entradas</option>
                        </select>
                </div>
                <div class="col-sm-3 my-1">
                    <label for="">De inventarios</label>
                    <div class="input-group">
                        <select class="form-select" id="categoria">
                            <option value="todos">Todos</option>
                            <option value="playera">Playera</option>
                            <option value="camisa">Camisa</option>
                            <option value="pantalon">Pantalón</option>
                            <option value="zapatos">Zapatos</option>
                            <option value="gorra">Gorra</option>
                            <option value="guantes">Guantes</option>
                        </select>
                        <button class="btn btn-success" id="generarReporte">Generar</button>
                    </div>
                </div>
            </div>

            <!-- Reporte de inventario -->
            <div class="row mt-4 mx-5" style="background-color:white">
                <div class="col-12">
                    <div class="reporte-card">
                        <h2 class="text-center" id="tituloReporte">Reporte de inventario</h2>
                        <!-- Ventas generales -->
                        <div class="row px-5 top-dashed-line">
                            <div class="col-md-4">
                                <span class="title">Categoria: </span>
                                <span class="title-content" id="ventasTotales">Todos</span>
                            </div>
                            <div class="col-md-4">
                                <span class="title">Costo del inventario: </span>
                                <span class="title-content" id="numVentas">$503,342.00</span>
                            </div>
                            <div class="col-md-4">
                                <span class="title">Cantidad de productos:</span>
                                <span class="title-content" id="ventaPromedio">5523</span>
                            </div>
                        </div>
                        <div class="row p-0 m-0" style="border-top: 1px dashed #757779;">
                            <div class="col-12 py-3">
                                <div class="p-0" style="overflow: auto scroll; height: 300px;">
                                    <table class="table">
                                        <thead class="header-table">
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Costo</th>
                                                <th>Precio Venta</th>
                                                <th>Existencia</th>
                                                <th>Stock min.</th>
                                                <th>Stock max.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Ejemplo de fila de inventario -->
                                            <tr>
                                                <td>1</td>
                                                <td>PLAYERA ML-Hombre T XS</td>
                                                <td>$243.00</td>
                                                <td>$243.00</td>
                                                <td>3</td>
                                                <td>10</td>
                                                <td>6</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>PLAYERA ML-Hombre T S</td>
                                                <td>$243.00</td>
                                                <td>$243.00</td>
                                                <td>22</td>
                                                <td>30</td>
                                                <td>20</td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>PLAYERA ML-Hombre T M</td>
                                                <td>$243.00</td>
                                                <td>$243.00</td>
                                                <td>13</td>
                                                <td>30</td>
                                                <td>20</td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>PLAYERA ML-Hombre T L</td>
                                                <td>$243.00</td>
                                                <td>$243.00</td>
                                                <td>17</td>
                                                <td>30</td>
                                                <td>20</td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>PLAYERA ML-Hombre T XL</td>
                                                <td>$243.00</td>
                                                <td>$243.00</td>
                                                <td>22</td>
                                                <td>20</td>
                                                <td>16</td>
                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td>PLAYERA ML-Hombre T 2XL</td>
                                                <td>$243.00</td>
                                                <td>$243.00</td>
                                                <td>18</td>
                                                <td>20</td>
                                                <td>16</td>
                                            </tr>
                                            <tr>
                                                <td>7</td>
                                                <td>PLAYERA ML-Mujer T XS</td>
                                                <td>$243.00</td>
                                                <td>$243.00</td>
                                                <td>0</td>
                                                <td>20</td>
                                                <td>10</td>
                                            </tr>
                                            <tr>
                                                <td>8</td>
                                                <td>PLAYERA ML-Mujer T S</td>
                                                <td>$243.00</td>
                                                <td>$243.00</td>
                                                <td>23</td>
                                                <td>30</td>
                                                <td>20</td>
                                            </tr>
                                            <tr>
                                                <td>9</td>
                                                <td>PLAYERA ML-Mujer T M</td>
                                                <td>$243.00</td>
                                                <td>$243.00</td>
                                                <td>19</td>
                                                <td>30</td>
                                                <td>20</td>
                                            </tr>
                                            <tr>
                                                <td>10</td>
                                                <td>PLAYERA ML-Mujer T L</td>
                                                <td>$243.00</td>
                                                <td>$243.00</td>
                                                <td>16</td>
                                                <td>30</td>
                                                <td>20</td>
                                            </tr>
                                            <tr>
                                                <td>11</td>
                                                <td>PLAYERA ML-Mujer T XL</td>
                                                <td>$243.00</td>
                                                <td>$243.00</td>
                                                <td>17</td>
                                                <td>20</td>
                                                <td>16</td>
                                            </tr>
                                            <tr>
                                                <td>12</td>
                                                <td>PLAYERA ML-Mujer T 2XL</td>
                                                <td>$243.00</td>
                                                <td>$243.00</td>
                                                <td>22</td>
                                                <td>20</td>
                                                <td>16</td>
                                            </tr>
                                            <!-- Más filas de inventario se pueden agregar dinámicamente -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>