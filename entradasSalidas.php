    <div id="entradasSalidas">
            <div class="row align-items-center mt-3">
                <div class="col">
                    <h1 class="title">Entradas por salidas</h1>
                </div>
            </div>
    </div>
            <div class="row mb-3">
                <div class="col">
                    <div class="remarcado-font fs-5" id="numPedido"></div>
                </div>
            </div>
            
            <div class="row mt-2 mb-2">
                    <div class="col-1 align-self-center">Periodo:</div>
                    <div class="col-4">
                        <div class="input-group">
                            <input type="date" id="startDate" class="form-control">
                            <span class="input-group-text">a</span>
                            <input type="date" id="endDate" class="form-control">
                        </div>
                    </div>
                    <div class="col-auto text-end">
                    <button class="btn btn-success" id="generarPedidoBtn">
                        <i class="bi bi-file-earmark-plus"></i> Generar pedido
                    </button>
                </div>
            </div>

        <div class="d-flex justify-content-center" style="width:100%">
            <div id="tableContainer" style="width:100%;">
                <table id="tableBody" class="table-striped responsive">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Categoria</th> 
                            <th class="text-center">Talla</th>
                            <th class="text-center">Genero</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <!-- Modal de confirmación -->
        <div class="modal fade" id="confirmModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmar pedido</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de generar un pedido con los siguientes artículos?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="confirmarBtn">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>