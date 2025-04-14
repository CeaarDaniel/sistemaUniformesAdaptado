<?php 
 include('./api/conexion.php');

 //CATEGORIAS DE ARTICULO
$categorias = $conn->prepare("SELECT 
                                    MIN(id_categoria) AS id_categoria,
                                    MIN(abrev) AS abrev,
                                    MIN(categoria) AS categoria,
                                    tipo_talla
                                FROM uni_categoria
                                GROUP BY tipo_talla"); 
$categorias->execute();
?>

<div id="altaCategoriaModal">
    <!-- Barra de progreso (simulada) -->
    <div class="progress-bar" style="height: 8px; background-color: #6c757d;"></div>

    <!-- Formulario -->
    <div class="form-container">

      <!-- Título -->
      <h3 class="">Alta de categorías</h3>

        <div class="row">
            <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
                <!-- Nombre -->
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Ej. Camisa Manga Larga">
                    <small id="nombreHelpTextC" class="form-text text-muted ms-3" style="font-size:12px">Ej. Camisa Manga Larga</small>
                </div>

                <!-- Abreviatura -->
                <div class="mb-3">
                    <label for="abrev" class="form-label">Abreviatura</label>
                    <input type="text" class="form-control text-uppercase" id="abrev" placeholder="Ej. CAMISA ML">
                    <small id="nombreHelpTextA" class="form-text text-muted ms-3" style="font-size:12px">Ej. CAMISA ML (visible para el nombre del artículo)</small>
                </div>

                <!-- Tallas -->
                <div class="mb-3">
                    <div class="text-h6">
                        <p>Tallas</p>
                        <button id="btnChangeTalla" class="btn btn-primary btn-sm mb-3" style="color:white; background-color:rgb(25, 118, 210);">CREAR TALLAS</button>
                    </div>
                    <div id="tallasSection">
                        <!-- Opción 1: Usar tipo de talla existente -->
                        <div id="tallasExistente">
                            <select class="form-select mb-3" id="tipoTalla" onchange="buscarTallas()">
                                <option value="-1">--Seleccionar--</option>
                                    <?php
                                        while($tipoTalla = $categorias->fetch(PDO::FETCH_ASSOC))
                                        echo '<option value="'.$tipoTalla['tipo_talla'].'" >'.$tipoTalla['categoria'].'</option>';
                                    ?>
                            </select>
                            <div id="tallasChips" class="chip-container"></div>
                        </div>

                        <!-- Opción 2: Crear nuevas tallas -->
                        <div id="tallasNuevas" style="display: none;">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="tallaLabel" placeholder="Ej. SM" maxlength="25">
                                <span class="input-group-text" data-bs-toggle="tooltip" data-bs-placement="top" title="Para ir agregando tallas, escribe una y en seguida presiona enter para agregarla, agrega las tallas de menor a mayor tamaño de preferencia.">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </div>
                            <div id="tallasAltaChips" class="chip-container"></div>
                        </div>
                    </div>
                </div>

                <!-- Botón de Agregar Categoría -->
                <div class="row q-mt-sm">
                    <div class="col-12 text-end">
                        <button class="btn btn-success" id="btnAgregarCategoria">AGREGAR CATEGORÍA</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirmar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de agregar la categoría <b id="nombreCategoria"></b>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="agregarCategoria()">Ok</button>
                </div>
            </div>
        </div>
    </div>
</div>