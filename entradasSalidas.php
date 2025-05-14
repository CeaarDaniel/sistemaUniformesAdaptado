    <div id="entradasSalidas">
        <div class="padding-header">
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h1 class="title">Entradas por salidas</h1>
                </div>
                <div class="col-auto">
                    <button class="btn btn-success" id="generarPedidoBtn" data-bs-toggle="tooltip" title="Confirmar pedido (alt + c)">
                        <i class="bi bi-file-earmark-plus"></i> Generar pedido
                    </button>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col">
                    <div class="remarcado-font fs-5" id="numPedido"></div>
                </div>
            </div>
            
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <label class="form-label">Periodo:</label>
                    <div class="input-group">
                        <input type="date" class="form-control" id="fechaDesde">
                        <span class="input-group-text">a</span>
                        <input type="date" class="form-control" id="fechaHasta">
                    </div>
                </div>
            </div>
        </div>

        <div class="padding-side">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <table id="tableBody" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
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
    </div>