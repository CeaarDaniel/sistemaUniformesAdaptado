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
    <div id="catalogo">

        <!-- Título y Botones -->
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="title">Almacén</h1>
                <div>
                    <button class="btn" onclick="cargarRuta('editarAlmacen')"  style="background: #26a69a; color:white;">
                        <i class="fas fa-edit"></i> Editar almacén
                    </button>
                    <button id='btnactualizartabla' class="btn btn-primary" style="background: #1976d2">
                        <i class="fas fa-refresh"></i> Actualizar
                    </button>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="container mt-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <select class="form-select" id="categoriaCat">
                        <option value="0">Todos</option>
                            <?php
                                while($categoria = $categorias->fetch(PDO::FETCH_ASSOC))
                                echo '<option value="'.$categoria['id_categoria'].'" data-abrev="'.$categoria['abrev'].'"  data-tipoTalla ='.$categoria['tipo_talla'].'>'.$categoria['categoria'].'</option>';
                            ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="estado">
                        <option value="0">Todos</option>
                        <?php
                            while($dato = $estado->fetch(PDO::FETCH_ASSOC))
                            echo '<option value="'.$dato['id_estado'].'">'.$dato['estado'].'</option>';
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="generoCat">
                        <option value="0">Todos</option>
                            <?php
                                while($genero = $generos->fetch(PDO::FETCH_ASSOC))
                                echo '<option value="'.$genero['id_genero'].'">'.$genero['genero'].'</option>';
                            ?>
                    </select>
                </div>
                <div class="col-md-3 text-end">
                    <!--
                        <button class="btn bg-blue-10" style="color: white;">
                            <i class="fas fa-print"></i> IMPRIMIR
                        </button>
                        
                        <button class="btn btn-success" onclick="exportToExcel()" style="background-color: #1b5e20">
                            <i class="fas fa-file-excel"></i> Exportar Excel
                        </button>
                      -->
                      <button id="btnImprimirAlmacen" class="btn bg-blue-10" style="color: white;">
                        <i class="fas fa-print"></i> IMPRIMIR
                      </button>
                </div>
            </div>
        </div>

        <!-- Tabla de Artículos -->
        <div class="mt-4 p-0" style="height: 250px; width:100%;">
            <table id ='tablaArticulos' class="table table-striped" style="width:100%;">
                <thead>
                    <tr> 
                        <th style="background-color: rgb(13, 71, 161); color:white">ID</th>
                        <th style="background-color: rgb(13, 71, 161); color:white">Nombre</th>
                        <th style="background-color: rgb(13, 71, 161); color:white">Talla</th>
                        <th style="background-color: rgb(13, 71, 161); color:white">Género</th>
                        <th style="background-color: rgb(13, 71, 161); color:white">Cant. física</th>
                        <th style="background-color: rgb(13, 71, 161); color:white">Cant. en tránsito</th>
                        <th style="background-color: rgb(13, 71, 161); color:white">Cant. total</th>
                        <th style="background-color: rgb(13, 71, 161); color:white">Costo</th>
                        <th style="background-color: rgb(13, 71, 161); color:white">Precio</th>
                        <th style="background-color: rgb(13, 71, 161); color:white">Stock Máximo</th>
                        <th style="background-color: rgb(13, 71, 161); color:white">Stock Mínimo</th>
                        <th style="background-color: rgb(13, 71, 161); color:white">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Filas de la tabla se llenarán dinámicamente -->
                </tbody>
            </table>
        </div>

        <!-- Modal de Confirmación de Eliminación -->
        <div class="modal fade" id="eliminarArtModal" tabindex="-1" aria-labelledby="eliminarArtModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eliminarArtModalLabel">Confirmar Eliminación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-close" style="background-color:none; color:white; font-size:18px;"></i></button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de eliminar el artículo seleccionado?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn " data-bs-dismiss="modal" style="background-color:  none;">Cancelar</button>
                        <button type="button" class="btn" style="background-color:  none;">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal de Confirmación de Eliminación -->
        <div class="modal fade" id="modalModificar" tabindex="-1" aria-labelledby="eliminarArtModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal">EDITAR ARTICULO</h5>
                        <button class="btn" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-close" style="background-color:none; color:white; font-size:18px;"></i></button>
                    </div>
                    <div class="modal-body py-1" id='modalModificarArticulo'>
                    </div>
                    <div class="modal-footer">
                        <button id="btnCrearArticulo" class="btn" style="color:white; background-color:#21ba45;">
                            Modificar
                        </button>                                                          
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="d-none p-0 m-0">
        <div id="impresionInventario" class="hojaImpresion" style="font-size:13px;">
        </div>
    </div>