<?php
    include('./api/conexion.php');

    //TIPOS DE SALIDAS
    $tipoSalida = $conn->prepare("select* from uni_tipo_salida"); 
    $tipoSalida->execute();

    //GENERO
    $years = $conn->prepare("select DISTINCT YEAR(fecha_creacion) as año from uni_pedido"); 
    $years->execute();
?>    



<div id="consultaSalidas">
        <!-- Título -->
        <div class="container mt-4">
            <h1 class="title text-center">Consultas de Salidas</h1>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="container mt-4">
            <div class="row g-3 align-items-center">
                <!-- Tipo de Salida -->
                <div class="col-md-4">
                    <select class="form-select filtroBusqueda" id="tipo">
                        <?php
                            while($salida = $tipoSalida->fetch(PDO::FETCH_ASSOC))
                                echo '<option value="'.$salida['id_tipo_salida'].'">'.$salida['tipo_salida'].'</option>';
                        ?>
                    </select>
                </div>

                <!-- Mes -->
                <div class="col-md-2">
                    <select class="form-select filtroBusqueda" id="mes">
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
                    <select class="form-select filtroBusqueda" id="anio">
                        <option value="0">Todos</option>
                            <?php
                                while($year = $years->fetch(PDO::FETCH_ASSOC))
                                echo '<option value="'.$year['año'].'">'.$year['año'].'</option>';
                            ?>
                    </select>
                </div>

                <!-- Búsqueda -->
                <div class="col-md-4">
                    <div class="input-group"> 
                        <input type="number" class="form-control filtroBusqueda" id="busquedaEmp" min="2" step="1" placeholder="Buscar empleado">
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Salidas -->
        <div class="container mt-4 table-container">
            <table id="tablaSalidas" class="table table-striped">
                <thead class="sticky-header">
                    <tr>
                        <th style="background-color: rgb(13, 71, 161); color:white">ID</th>
                        <th style="background-color: rgb(13, 71, 161); color:white">Fecha</th>
                        <th style="background-color: rgb(13, 71, 161); color:white">Tipo</th>
                        <th style="background-color: rgb(13, 71, 161); color:white">Realizado por</th>
                        <th style="background-color: rgb(13, 71, 161); color:white">Empleado</th>
                        <th style="background-color: rgb(13, 71, 161); color:white">Acciones</th>
                    </tr>
                </thead>
                <tbody>
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