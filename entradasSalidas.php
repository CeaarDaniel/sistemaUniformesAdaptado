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
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal">
                        <i class="bi bi-file-earmark-plus"></i> Generar pedido
                    </button>
                    <button id="btnactualizartabla" class="btn btn-primary">
                        <i class="fas fa-refresh"></i> Actualizar tabla
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
                            <th class="text-center">Costo</th>
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
                        <button class="btn" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fas fa-close" style="background-color:none; color:white; font-size:18px;"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de generar un pedido con los siguientes artículos?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="generarPedidoBtn">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>