<?php
    session_start();
    include('./api/conexion.php');

    //Captura del id de salida
    if (!empty($_POST['id'])) {
        $_SESSION['idCambios'] = $_POST['id'];
    }

    if(empty($_SESSION['idCambios'])) 
        $_SESSION['idCambios'] = '';


    $id = '';
    $fecha = '';
    $NN = '';
    $tipoSalida = '';
    $empleado = '';
    $usuario = ''; 
    
    //Consulta para traer el registro del id de salida
    $sql= "SELECT us.id_salida, FORMAT(us.fecha, 'yyyy-MM-dd HH:mm') as fecha, uts.tipo_salida, us.id_empleado, e.usuario as empleado, d.Nombre as usuario from uni_salida as us 
				inner join uni_tipo_salida as uts on us.tipo_salida = uts.id_tipo_salida
				inner join empleado as e on us.id_empleado = e.id_usuario
				inner join DIRECTORIO_0 as d on us.id_usuario = d.ID 
            WHERE id_salida = :id_salida";

    $salida = $conn->prepare($sql); 

    $salida->bindParam(':id_salida', $_SESSION['idCambios'] );
    
    if($salida->execute()){
        $registro =  $salida->fetch(PDO::FETCH_ASSOC);
          if($registro) {
                $id = $registro['id_salida'];
                $fecha = $registro['fecha'];
                $NN = $registro['id_empleado'];
                $tipoSalida = $registro['tipo_salida'];
                $empleado = $registro['empleado'];
                $usuario = $registro['usuario']; // Nombre de quien realiza la operacion
           }
    }

    $sqlArticulos= "SELECT* from uni_categoria";

    $articulos = $conn->prepare($sqlArticulos); 
    $articulos->execute()
?>

    <div id="cambios">
        <!-- Título -->
        <div class="container mt-4">
            <h1 class="title text-center">Cambio de Artículos</h1>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="container mt-4">
            <div class="row g-3 align-items-center">
                <!-- Número de Salida -->
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="numSalida" placeholder="Núm. Salida" value='<?php echo $_SESSION['idCambios']?>'>
                        <button id='btnBuscar' class="btn btn-warning">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Información de la Salida -->
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Fecha:</strong><span id="fechaSalida"> <?php echo $fecha?> </span></p>
                            <p><strong>Realizado por:</strong><span id="realizadoPor"><?php echo $usuario?></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Para:</strong> <span id="paraUsuario"><?php echo $empleado ?></span></p>
                            <p><strong>Tipo:</strong> <span id="tipoSalida"><?php echo $tipoSalida?></span></p>
                        </div>
                    </div>
                </div>

                <input id="NN" name="NN" value="<?php echo $NN?>" type="hidden">
            </div>
        </div>


        <div class="modal fade" id="escogerArtModal" tabindex="-1" aria-labelledby="escogerArtModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="escogerArtModalLabel">Seleccionar Artículo</h5>
                        <button class="btn" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-close" style="background-color:none; color:white; font-size:18px;"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-container">
                            <form id="formAgregarArticulo" class="form-control">
                                <h3><i class="bi bi-box-seam"></i> Agregar Artículo</h3>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="">
                                            <label class="form-label">
                                                <i class="bi bi-grid-fill bi-icon"></i>
                                                Categoría
                                            </label>
                                            <select class="form-select" name="tipo" id="tipo" disabled>
                                                <option value="">Seleccione una categoría</option>
                                                <?php 
                                                    while($articulo = $articulos->fetch(PDO::FETCH_ASSOC))
                                                           echo "<option value='".$articulo['id_categoria']."'>".$articulo['categoria']."</option>";
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="">
                                            <label class="form-label">
                                                <i class="bi bi-rulers bi-icon"></i>
                                                Talla
                                            </label>
                                            <select name="talla" id="talla" class="form-select" required>
                                                <option value="" selected>Seleccione una talla</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="">
                                            <label class="form-label">
                                                <i class="bi bi-gender-ambiguous bi-icon"></i>
                                                Género
                                            </label>
                                            <select id="genero" name="genero" class="form-select" required>
                                                <option value="" selected>Seleccione género</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                            <label class="form-label">
                                                <i class="bi bi-tag-fill bi-icon"></i>
                                                Nombre
                                            </label>
                                            <input type="text" id="nombre" class="form-control" placeholder="Nombre" readonly style="background-color:#3f51b521">
                                    </div>
                                    

                                    <div class="col-md-6">
                                            <label class="form-label">
                                                <i class="bi bi-currency-exchange bi-icon"></i>
                                                Precio
                                            </label>
                                            <input type="number" id="precio" class="form-control" placeholder="Precio" step="0.01" readonly style="background-color:#3f51b521">
                                    </div>

                                    <div class="col-md-6">
                                        <div class="">
                                            <label class="form-label">
                                                <i class="bi bi-123 bi-icon"></i>
                                                Cantidad
                                            </label>
                                            <input type="number" id="cantidadArt" class="form-control" placeholder="Cantidad" readonly style="background-color:#3f51b521">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <!--
                                            <label class="form-label">
                                                <i class="bi bi-key-fill bi-icon"></i> ID
                                            </label> 
                                        -->
                                            <input id="id" class="form-control d-none" type="text" >
                                    </div>

                                    <div class="col-12">
                                        <button id="btnSeleccionarArticuloCambio" class="btn btn-custom" type="button">
                                            <i class="bi bi-plus-circle"></i> Agregar Artículo
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Tablas de Artículos -->
            <div class="container mt-4">
                <div class="row">
                    <!-- Tabla de Artículos Originales -->
                    <div class="col-md-6">
                        <h4>Artículos (Original)</h4>
                        <div class="table-container">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cantidad</th>
                                        <th>Nombre</th>
                                        <th>Talla</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaOriginal">
                                    <!-- Filas de la tabla se llenarán dinámicamente -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tabla de Artículos de Cambio -->
                    <div class="col-md-6">
                        <h4>Artículos (Cambio)</h4>
                        <div class="table-container">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cantidad</th>
                                        <th>Nombre</th>
                                        <th>Talla</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaCambio">
                                    <!-- Filas de la tabla se llenarán dinámicamente -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Botón de Realizar Cambio -->
        <div class="container mt-4 text-end">
            <button id="btnRealizarCambio" class="btn btn-success">Realizar Cambio</button>
        </div>
    </div>