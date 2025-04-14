<?php
include('./api/conexion.php');

//CATEGORIAS DE ARTICULO
$categorias = $conn->prepare("select* from uni_categoria"); 
$categorias->execute();

//GENERO
$generos = $conn->prepare("select* from uni_genero"); 
$generos->execute();



//ESTADO DEL ARTICULO (NUEVO USADO)
$estado = $conn->prepare("select* from uni_estado"); 
$estado->execute();
?>

<div id="altasArt">
    <!-- Título -->
    <div class="row padding-header">
        <h3 class="m-0 p-0">Alta de artículos</h3>
    </div>

    <!-- Formulario -->
    <div class="form-container my-1">
        <div class="row">
            <!-- Columna 1 -->
            <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
                <!-- Nombre -->
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" readonly>
                    <small id="nombreHelpText" class="form-text text-muted ms-3">El nombre se genera automáticamente</small>
                </div>

                <!-- Categoría -->
                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoría</label>
                    <div class="d-flex">
                        <select class="form-select" id="categoria" style="max-width:300px">
                            <!-- <option value="">--- SELECCIONE UNA OPCIÓN ---</option> -->
                            <?php
                                while($categoria = $categorias->fetch(PDO::FETCH_ASSOC))
                                echo '<option value="'.$categoria['id_categoria'].'" data-abrev="'.$categoria['abrev'].'"  data-tipoTalla ='.$categoria['tipo_talla'].'>'.$categoria['categoria'].'</option>';
                            ?>
                        </select>

                        <!--BOTON ALTA DE CATEGORIA -->
                        <button class="btn border rounded mx-1" style="color:white; background-color:rgb(25, 118, 210); font-size:18px;" onclick="navegar('altasCategorias','0','mainContent')">
                            <span class="fas fa-plus"></span>
                        </button>
                    </div>
                    
                </div>

                <!-- Talla -->
                <div class="mb-3">
                    <label for="talla" class="form-label">Talla</label>
                    <select class="form-select" id="talla">
                       <!--  <option value="">--- SELECCIONE UNA CATEGORÍA ---</option> -->
                    </select>
                </div>

                <!-- Género -->
                <div class="mb-3">
                    <label for="genero" class="form-label">Género</label>
                    <select class="form-select" id="genero">
                        <?php
                            while($genero = $generos->fetch(PDO::FETCH_ASSOC))
                            echo '<option value="'.$genero['id_genero'].'">'.$genero['genero'].'</option>';
                        ?>
                    </select>
                </div>

                <!-- Estado -->
                <div class="mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-select" id="estado">
                        <?php
                            while($dato = $estado->fetch(PDO::FETCH_ASSOC))
                            echo '<option value="'.$dato['id_estado'].'">'.$dato['estado'].'</option>';
                        ?>
                    </select>
                </div>

                <!-- Descripción -->
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" rows="3" maxlength=500></textarea>
                </div>
            </div>

            <!-- Columna 2 -->
            <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
                <!-- Clave Comercial -->
                <div class="mb-3">
                    <label for="clvComercial" class="form-label">Clave Comercial</label>
                    <input type="text" class="form-control" id="clvComercial">
                </div>

                <!-- Costo -->
                <div class="mb-3">
                    <label for="costo" class="form-label">Costo</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input min=0 type="number" class="form-control" id="costo">
                    </div>
                </div>

                <!-- Precio -->
                <div class="mb-3">
                    <label for="precio" class="form-label">Precio</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input min=0 type="number" class="form-control" id="precio">
                    </div>
                </div>

                <!-- Stock Máximo -->
                <div class="mb-3">
                    <label for="stock_max" class="form-label">Stock máximo</label>
                    <div class="input-group">
                        <input min=0 type="number" class="form-control" id="stock_max" readonly>
                        <span class="input-group-text">pzas</span>
                    </div>
                </div>

                <!-- Stock Mínimo -->
                <div class="mb-3">
                    <label for="stock_min" class="form-label">Stock mínimo</label>
                    <div class="input-group">
                        <input min=0 type="number" class="form-control" id="stock_min">
                        <span class="input-group-text">pzas</span>
                    </div>
                </div>

                <!-- Botón de Crear Artículo -->
                    <div class="col-4 ms-auto">
                        <button id="btnCrearArticulo"
                                class="btn btn-primary btn-submit" 
                                data-bs-toggle="modal" 
                                data-bs-target="#confirmModal" 
                                style="color:white; background-color:rgb(25, 118, 210);">
                                CREAR ARTÍCULO
                        </button>
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
                    ¿Estás seguro de agregar el artículo <b id="nombreArticulo"></b>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarArticulo()">Ok</button>
                </div>
            </div>
        </div>
    </div>
</div>