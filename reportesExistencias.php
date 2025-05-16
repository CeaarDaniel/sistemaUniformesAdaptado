<?php
include('./api/conexion.php');

 //CATEGORIAS DE ARTICULO
 $categorias = $conn->prepare("SELECT* from uni_categoria"); 
 $categorias->execute();

 //EMPLEADO
 $generos = $conn->prepare("SELECT* from uni_genero"); 
 $generos->execute();

 //Estado
 $estados = $conn->prepare("SELECT* from uni_estado"); 
 $estados->execute();
?>

    <div id="reportesExistencias">
        <!-- Header Section -->
            <div class="row my-4 justify-content-between">
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
                        <input class="form-check-input" type="radio" id="groupRadioTodos" name="rbnExistencia" value="1" checked>
                        <label class="form-check-label" for="groupRadioTodos">Todos</label>
                    </div>
                    <div class="form-check form-check-inline ms-3">
                        <input class="form-check-input" type="radio" id="groupRadioSolo" name="rbnExistencia" value="2">
                        <label class="form-check-label"  for="groupRadioSolo">Solo con existencia</label>
                    </div>
                    <div class="form-check form-check-inline ms-3">
                        <input class="form-check-input" type="radio" id="groupRadioSin" name="rbnExistencia" value="3">
                        <label class="form-check-label" for="groupRadioSin">Sin existencia</label>
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
                            <input class="form-check-input" type="checkbox" id="ftrCategorios" checked>
                            <label class="form-check-label">Todas las categorías</label>
                        </div>
                    </div>
                    <div class="col-4 ms-3">
                        <select class="form-select" id="valCategorio" disabled>
                            <option value="0">Seleccione una categoría</option>
                                <?php
                                    while($categoria = $categorias->fetch(PDO::FETCH_ASSOC))
                                    echo '<option value="'.$categoria['id_categoria'].'">'.$categoria['categoria'].'</option>';
                                ?>
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
                            <option value="0">Seleccione un género</option>
                                <?php
                                    while($genero = $generos->fetch(PDO::FETCH_ASSOC))
                                    echo '<option value="'.$genero['id_genero'].'">'.$genero['genero'].'</option>';
                                ?>
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
                            <option value="0">Seleccione un estado</option>
                                <?php
                                    while($estado = $estados->fetch(PDO::FETCH_ASSOC))
                                    echo '<option value="'.$estado['id_estado'].'">'.$estado['estado'].'</option>';
                                ?>
                        </select>
                    </div>
                </div>
            </div>


        <!-- Table Section -->
        <div class="padding-side">
            <div class="row justify-content-center">
                <div id="emptyState" class="text-center flex-wrap align-content-center py-5 d-none" style="width:100%; height:100%;">
                    <i class="bi bi-emoji-neutral display-4 text-muted"></i>
                    <p class="text-muted fs-5 mt-3">No se encontraron resultados</p>
                </div>

                
                <table id="reportExistencias">
                    <thead>
                        <tr id="tableHeader">
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Stock min.</th>
                            <th>Stock max.</th>
                            <th>Existencia</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>   
            </div>
        </div>
    </div>