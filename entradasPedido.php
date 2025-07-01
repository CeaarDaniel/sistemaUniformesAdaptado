<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
include('./api/conexion.php');

    $sql= "SELECT  FORMAT(GETDATE(), 'yyyy/MM') 
				+ '/' 
				+ RIGHT('000' + CAST((SELECT COUNT(*) + 1 FROM uni_pedido 
										WHERE FORMAT(fecha_creacion, 'yyyy/MM')  = FORMAT(GETDATE(), 'yyyy/MM')) AS VARCHAR), 3) 
			as num_pedido";

    $numPedido = $conn->prepare($sql); 
    $pedido = '';

    //$articulos->bindparam(':id_salida', $id_salida);

        if($numPedido->execute()){
             $pedido = $numPedido->fetch(PDO::FETCH_ASSOC); 
        }
?>

        <div id="entradasPedido" class="my-3">
                <div class="row">
                    <div class="col-12">
                        <h1 class="title">Entradas por pedidos</h1>
                    </div>
                </div>

                <!-- Filtros -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="remarcado-font" style="font-size: 19px">NUM PEDIDO: <span id="entradaConsecutivo"><?php echo $pedido['num_pedido'] ?></span></div>
                    </div>
                    <div class="col-md-6 text-end">
                        <button class="btn btn-success" id="generarPedidoBtn">
                            <i class="fas fa-plus"></i> Generar Pedido
                        </button>
                    </div>
                </div>
        </div>

        <label  for=""><b> Seleccionar todos los articulos </b></label>
        <input type='checkbox' id="checkPadre" class='select-checkbox'>

        <!-- Tabla de artículos -->
            <table id="tablaArticulos">
                <thead>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Cantidad</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Talla</th>
                        <th>Género</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <p class="my-0"> <b class="text-danger">*</b> Los artículos remarcados en rojo son artículos que ya están en un pedido creado</p>


    <!-- Modal de confirmación de generar pedido -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirmar Pedido</h5>
                    <button class="btn" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-close" style="background-color:none; color:white; font-size:18px;"></i></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de generar un pedido con los siguientes artículos?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="confirmarPedidoBtn">Generar Pedido</button>
                </div>
            </div>
        </div>
    </div>