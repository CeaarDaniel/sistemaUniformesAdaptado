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
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="mx-5 d-flex justify-content-between">
                            <img src="./imagenes/beyonz.jpg" style="max: width 150px; max-height:50px;">
                            <table>
                                <tbody>
                                    <tr style="background-color: #0A0A85;
                                               color: white;">
                                        <td class="p-0 border border-dark"><b>NUM PEDIDO</b></td>
                                    </tr>
                                    <tr>
                                        <td class="p-0 border border-dark"><b id="modalVernumPedido"></b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Detalles del pedido -->
                        <div class="row mt-5">
                            <div class="my-1 col-3"><b>Fecha de elaboración:</b></div>
                            <div class="my-1 col-auto"><label class="mx-0 px-0 text-uppercase" id="modalVerfechaCreacion"></label></div>
                        </div>

                        <div class="row mt-1">
                            <div class="my-1 col-3"><b>Realizado por:</b></div>
                            <div class="my-1 col-auto"><label id="modalVerNombre"></label></div>
                        </div>

                        <div class="row mt-1">
                            <div class="my-1 col-3"><b>Estado:</b></div>
                            <div class="my-1 col-auto text-uppercase"><label id ="modalVerEstado"></label></div>
                         </div>

                         <hr class="my-5" style="height: 5px; background: linear-gradient(90deg,rgba(9, 11, 122, 1) 33%, rgba(133, 133, 133, 1) 0%); opacity: 1; border:none;">

                            <!--TABLA DE PRODUCTOS -->
                            <p class="text-center fs-7"><b> PRODUCTOS </b></p>
                            <div style="overflow: auto scroll; max-height: 400px;">
                                <table id="" class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Clave</th>
                                            <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Articulo</th>
                                            <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Cantidad</th>
                                            <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Precio Unitario</th>
                                            <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyDetallePedido">
                                        <!-- Filas de la tabla se llenarán dinámicamente -->
                                    </tbody>
                                </table>

                                <div class="mx-3 d-flex justify-content-end">
                                    <b>Total:</b> &nbsp; &nbsp; <label id='totalCostoPedido'></label>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><b>Cerrar</b></button>
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
                        <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-close" style="background-color:none; color:white; font-size:18px;"></i></button>
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
                        <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-close" style="background-color:none; color:white; font-size:18px;"></i></button>
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