<?php
    include('./api/conexion.php');

    //CATEGORIAS DE ARTICULO
    $estadoPedido = $conn->prepare("select* from uni_pedido_estado order by id_estado desc"); 
    $estadoPedido->execute();

    //GENERO
    $years = $conn->prepare("select DISTINCT YEAR(fecha_creacion) as año from uni_pedido"); 
    $years->execute();
?>    

    <div id="pedidos">
        <!-- Barra de progreso (simulada) -->
        <div class="progress-bar" style="height: 8px; background-color: #6c757d;"></div>

        <!-- Título -->
        <div class="container mt-4">
            <h1 class="title">Pedidos</h1>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="container mt-4">
            <div class="row g-3 align-items-center">
                <!-- Búsqueda -->
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" id="busqueda" placeholder="Buscar" style="max-width:200px">
                        <button class="btn btn-warning" onclick="navegar()">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Mes -->
                <div class="col-md-2">
                    <select class="form-select" id="mes">
                        <option value="0">Todos</option>
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
                    <select class="form-select" id="anio">
                        <option value="0">Todos</option>
                            <?php
                                while($year = $years->fetch(PDO::FETCH_ASSOC))
                                echo '<option value="'.$year['año'].'">'.$year['año'].'</option>';
                            ?>
                    </select>
                </div>

                <!-- Estado -->
                <div class="col-md-2">
                    <select class="form-select" id="status">
                            <?php
                                while($estado = $estadoPedido->fetch(PDO::FETCH_ASSOC))
                                echo '<option value="'.$estado['id_estado'].'">'.$estado['pedido_estado'].'</option>';
                            ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- Tabla de Pedidos -->
        <div class="mt-4 p-0"  style="widht:100%; height: 400px;">
            <table id="tablaPedidos" class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center" style="background-color: rgb(13, 71, 161); color:white">ID</th>
                        <th class="text-center" style="background-color: rgb(13, 71, 161); color:white">Núm. Pedido</th>
                        <th class="text-center" style="background-color: rgb(13, 71, 161); color:white">Fecha</th>
                        <th class="text-center" style="background-color: rgb(13, 71, 161); color:white">Estado</th>
                        <th class="text-center" style="background-color: rgb(13, 71, 161); color:white">Realizado por</th>
                        <th class="text-center" style="background-color: rgb(13, 71, 161); color:white">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Filas de la tabla se llenarán dinámicamente -->
                </tbody>
            </table>
        </div>

        <!-- Modal de Ver Pedido -->
        <div class="modal fade" id="verPedidoModal" tabindex="-1" aria-labelledby="verPedidoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verPedidoModalLabel">Ver Pedido</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Detalles del pedido -->
                        <p><strong>ID:</strong> <span id="pedidoId"></span></p>
                        <p><strong>Núm. Pedido:</strong> <span id="pedidoNum"></span></p>
                        <p><strong>Fecha:</strong> <span id="pedidoFecha"></span></p>
                        <p><strong>Estado:</strong> <span id="pedidoEstado"></span></p>
                        <p><strong>Realizado por:</strong> <span id="pedidoRealizadoPor"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Cancelar Pedido -->
        <div class="modal fade" id="cancelarPedidoModal" tabindex="-1" aria-labelledby="cancelarPedidoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cancelarPedidoModalLabel">Cancelar Pedido</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de cancelar este pedido?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="button" class="btn btn-danger" onclick="cancelarPedido()">Sí, cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Concretar Pedido -->
        <div class="modal fade" id="concretarPedidoModal" tabindex="-1" aria-labelledby="concretarPedidoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="concretarPedidoModalLabel">Concretar Pedido</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de concretar este pedido?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="button" class="btn btn-success" onclick="concretarPedido()">Sí, concretar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

 
