<div id="entradasPedido">
    <div class="padding-header">
        <div class="row">
            <div class="col-12">
                <h1 class="title">Entradas por Pedidos</h1>
            </div>
        </div>

        <!-- Filtros -->
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="remarcado-font" style="font-size: 19px">NUM PEDIDO: <span id="entradaConsecutivo"></span></div>
            </div>
            <div class="col-md-6 text-end">
                <button class="btn btn-success" id="generarPedidoBtn">
                    <i class="fas fa-plus"></i> Generar Pedido
                </button>
                <button class="btn btn-danger" id="eliminarSeleccionadosBtn">
                    <i class="fas fa-trash"></i> Eliminar Seleccionados
                </button>
            </div>
        </div>

        <!-- Tabla de artículos -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="table-wrapper" style="overflow-y:auto; height:350px;">
                    <table id="tablaArticulos" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th>O</th>
                                <th>ID</th>
                                <th>Cantidad</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Talla</th>
                                <th>Género</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Las filas de artículos se llenarán dinámicamente -->
                            <tr class="">
                                <td class="q-table--col-auto-width">
                                    <div tabindex="0" role="checkbox" aria-checked="false"
                                        class="q-checkbox cursor-pointer no-outline row inline no-wrap items-center">
                                        <div class=""><input type="checkbox" class="hidden q-checkbox__native absolute q-ma-none q-pa-none">
                                        </div><span tabindex="-1" class="no-outline"></span>
                                    </div>
                                </td>
                                <td class="text-left">1</td>
                                <td data-v-538c87d8="" class="q-td text-left" style="font-weight: bold;">
                                    3
                                </td>
                                <td data-v-538c87d8="" class="q-td text-left">
                                    <div data-v-538c87d8=""><strong data-v-538c87d8=""><span data-v-538c87d8=""
                                                style="color: red; font-weight: bold;">PLAYERA ML-Hombre T XS *</span></strong><!----></div>
                                </td>
                                <td class="text-left">PLAYERA ML</td>
                                <td class="text-left">XS</td>
                                <td class="text-left">Hombre</td>
                            </tr>
                                <tr class="">
                                    <td class="q-table--col-auto-width">
                                        <div tabindex="0" role="checkbox" aria-checked="false"
                                            class="q-checkbox cursor-pointer no-outline row inline no-wrap items-center">
                                            <div class="q-checkbox__inner relative-position non-selectable q-checkbox__inner--falsy"><input
                                                    type="checkbox" class="hidden q-checkbox__native absolute q-ma-none q-pa-none">
                                            </div><span tabindex="-1" class="no-outline"></span>
                                        </div>
                                    </td>
                                    <td class="text-left">7</td>
                                    <td data-v-538c87d8="" class="q-td text-left" style="font-weight: bold;">
                                        10
                                    </td>
                                    <td data-v-538c87d8="" class="q-td text-left">
                                        <div data-v-538c87d8=""><strong data-v-538c87d8=""><span data-v-538c87d8=""
                                                    style="color: red; font-weight: bold;">PLAYERA ML-Mujer T XS *</span></strong><!----></div>
                                    </td>
                                    <td class="text-left">PLAYERA ML</td>
                                    <td class="text-left">XS</td>
                                    <td class="text-left">Mujer</td>
                                </tr>
                                <tr class="">
                                    <td class="q-table--col-auto-width">
                                        <div tabindex="0" role="checkbox" aria-checked="false"
                                            class="q-checkbox cursor-pointer no-outline row inline no-wrap items-center">
                                            <div class="q-checkbox__inner relative-position non-selectable q-checkbox__inner--falsy"><input
                                                    type="checkbox" class="hidden q-checkbox__native absolute q-ma-none q-pa-none">
                                            </div><span tabindex="-1" class="no-outline"></span>
                                        </div>
                                    </td>
                                    <td class="text-left">13</td>
                                    <td data-v-538c87d8="" class="q-td text-left" style="font-weight: bold;">
                                        3
                                    </td>
                                    <td data-v-538c87d8="" class="q-td text-left">
                                        <div data-v-538c87d8=""><strong data-v-538c87d8=""><span data-v-538c87d8=""
                                                    style="color: red; font-weight: bold;">PLAYERA MC-Hombre T XS *</span></strong><!----></div>
                                    </td>
                                    <td class="text-left">PLAYERA MC</td>
                                    <td class="text-left">XS</td>
                                    <td class="text-left">Hombre</td>
                                </tr>
                                <tr class="">
                                    <td class="q-table--col-auto-width">
                                        <div tabindex="0" role="checkbox" aria-checked="false"
                                            class="q-checkbox cursor-pointer no-outline row inline no-wrap items-center">
                                            <div class="q-checkbox__inner relative-position non-selectable q-checkbox__inner--falsy"><input
                                                    type="checkbox" class="hidden q-checkbox__native absolute q-ma-none q-pa-none">
                                            </div><span tabindex="-1" class="no-outline"></span>
                                        </div>
                                    </td>
                                    <td class="text-left">19</td>
                                    <td data-v-538c87d8="" class="q-td text-left" style="font-weight: bold;">
                                        1
                                    </td>
                                    <td data-v-538c87d8="" class="q-td text-left">
                                        <div data-v-538c87d8=""><strong data-v-538c87d8=""><span data-v-538c87d8=""
                                                    style="color: red; font-weight: bold;">PLAYERA MC-Mujer T XS *</span></strong><!----></div>
                                    </td>
                                    <td class="text-left">PLAYERA MC</td>
                                    <td class="text-left">XS</td>
                                    <td class="text-left">Mujer</td>
                                </tr>
                                <tr class="">
                                <td class="q-table--col-auto-width">
                                    <div tabindex="0" role="checkbox" aria-checked="false"
                                        class="q-checkbox cursor-pointer no-outline row inline no-wrap items-center">
                                        <div class=""><input type="checkbox" class="hidden q-checkbox__native absolute q-ma-none q-pa-none">
                                        </div><span tabindex="-1" class="no-outline"></span>
                                    </div>
                                </td>
                                <td class="text-left">1</td>
                                <td data-v-538c87d8="" class="q-td text-left" style="font-weight: bold;">
                                    3
                                </td>
                                <td data-v-538c87d8="" class="q-td text-left">
                                    <div data-v-538c87d8=""><strong data-v-538c87d8=""><span data-v-538c87d8=""
                                                style="color: red; font-weight: bold;">PLAYERA ML-Hombre T XS *</span></strong><!----></div>
                                </td>
                                <td class="text-left">PLAYERA ML</td>
                                <td class="text-left">XS</td>
                                <td class="text-left">Hombre</td>
                            </tr>
                                <tr class="">
                                    <td class="q-table--col-auto-width">
                                        <div tabindex="0" role="checkbox" aria-checked="false"
                                            class="q-checkbox cursor-pointer no-outline row inline no-wrap items-center">
                                            <div class="q-checkbox__inner relative-position non-selectable q-checkbox__inner--falsy"><input
                                                    type="checkbox" class="hidden q-checkbox__native absolute q-ma-none q-pa-none">
                                            </div><span tabindex="-1" class="no-outline"></span>
                                        </div>
                                    </td>
                                    <td class="text-left">7</td>
                                    <td data-v-538c87d8="" class="q-td text-left" style="font-weight: bold;">
                                        10
                                    </td>
                                    <td data-v-538c87d8="" class="q-td text-left">
                                        <div data-v-538c87d8=""><strong data-v-538c87d8=""><span data-v-538c87d8=""
                                                    style="color: red; font-weight: bold;">PLAYERA ML-Mujer T XS *</span></strong><!----></div>
                                    </td>
                                    <td class="text-left">PLAYERA ML</td>
                                    <td class="text-left">XS</td>
                                    <td class="text-left">Mujer</td>
                                </tr>
                                <tr class="">
                                    <td class="q-table--col-auto-width">
                                        <div tabindex="0" role="checkbox" aria-checked="false"
                                            class="q-checkbox cursor-pointer no-outline row inline no-wrap items-center">
                                            <div class="q-checkbox__inner relative-position non-selectable q-checkbox__inner--falsy"><input
                                                    type="checkbox" class="hidden q-checkbox__native absolute q-ma-none q-pa-none">
                                            </div><span tabindex="-1" class="no-outline"></span>
                                        </div>
                                    </td>
                                    <td class="text-left">13</td>
                                    <td data-v-538c87d8="" class="q-td text-left" style="font-weight: bold;">
                                        3
                                    </td>
                                    <td data-v-538c87d8="" class="q-td text-left">
                                        <div data-v-538c87d8=""><strong data-v-538c87d8=""><span data-v-538c87d8=""
                                                    style="color: red; font-weight: bold;">PLAYERA MC-Hombre T XS *</span></strong><!----></div>
                                    </td>
                                    <td class="text-left">PLAYERA MC</td>
                                    <td class="text-left">XS</td>
                                    <td class="text-left">Hombre</td>
                                </tr>
                                <tr class="">
                                    <td class="q-table--col-auto-width">
                                        <div tabindex="0" role="checkbox" aria-checked="false"
                                            class="q-checkbox cursor-pointer no-outline row inline no-wrap items-center">
                                            <div class="q-checkbox__inner relative-position non-selectable q-checkbox__inner--falsy"><input
                                                    type="checkbox" class="hidden q-checkbox__native absolute q-ma-none q-pa-none">
                                            </div><span tabindex="-1" class="no-outline"></span>
                                        </div>
                                    </td>
                                    <td class="text-left">19</td>
                                    <td data-v-538c87d8="" class="q-td text-left" style="font-weight: bold;">
                                        1
                                    </td>
                                    <td data-v-538c87d8="" class="q-td text-left">
                                        <div data-v-538c87d8=""><strong data-v-538c87d8=""><span data-v-538c87d8=""
                                                    style="color: red; font-weight: bold;">PLAYERA MC-Mujer T XS *</span></strong><!----></div>
                                    </td>
                                    <td class="text-left">PLAYERA MC</td>
                                    <td class="text-left">XS</td>
                                    <td class="text-left">Mujer</td>
                                </tr>
                                <tr class="">
                                <td class="q-table--col-auto-width">
                                    <div tabindex="0" role="checkbox" aria-checked="false"
                                        class="q-checkbox cursor-pointer no-outline row inline no-wrap items-center">
                                        <div class=""><input type="checkbox" class="hidden q-checkbox__native absolute q-ma-none q-pa-none">
                                        </div><span tabindex="-1" class="no-outline"></span>
                                    </div>
                                </td>
                                <td class="text-left">1</td>
                                <td data-v-538c87d8="" class="q-td text-left" style="font-weight: bold;">
                                    3
                                </td>
                                <td data-v-538c87d8="" class="q-td text-left">
                                    <div data-v-538c87d8=""><strong data-v-538c87d8=""><span data-v-538c87d8=""
                                                style="color: red; font-weight: bold;">PLAYERA ML-Hombre T XS *</span></strong><!----></div>
                                </td>
                                <td class="text-left">PLAYERA ML</td>
                                <td class="text-left">XS</td>
                                <td class="text-left">Hombre</td>
                            </tr>
                                <tr class="">
                                    <td class="q-table--col-auto-width">
                                        <div tabindex="0" role="checkbox" aria-checked="false"
                                            class="q-checkbox cursor-pointer no-outline row inline no-wrap items-center">
                                            <div class="q-checkbox__inner relative-position non-selectable q-checkbox__inner--falsy"><input
                                                    type="checkbox" class="hidden q-checkbox__native absolute q-ma-none q-pa-none">
                                            </div><span tabindex="-1" class="no-outline"></span>
                                        </div>
                                    </td>
                                    <td class="text-left">7</td>
                                    <td data-v-538c87d8="" class="q-td text-left" style="font-weight: bold;">
                                        10
                                    </td>
                                    <td data-v-538c87d8="" class="q-td text-left">
                                        <div data-v-538c87d8=""><strong data-v-538c87d8=""><span data-v-538c87d8=""
                                                    style="color: red; font-weight: bold;">PLAYERA ML-Mujer T XS *</span></strong><!----></div>
                                    </td>
                                    <td class="text-left">PLAYERA ML</td>
                                    <td class="text-left">XS</td>
                                    <td class="text-left">Mujer</td>
                                </tr>
                                <tr class="">
                                    <td class="q-table--col-auto-width">
                                        <div tabindex="0" role="checkbox" aria-checked="false"
                                            class="q-checkbox cursor-pointer no-outline row inline no-wrap items-center">
                                            <div class="q-checkbox__inner relative-position non-selectable q-checkbox__inner--falsy"><input
                                                    type="checkbox" class="hidden q-checkbox__native absolute q-ma-none q-pa-none">
                                            </div><span tabindex="-1" class="no-outline"></span>
                                        </div>
                                    </td>
                                    <td class="text-left">13</td>
                                    <td data-v-538c87d8="" class="q-td text-left" style="font-weight: bold;">
                                        3
                                    </td>
                                    <td data-v-538c87d8="" class="q-td text-left">
                                        <div data-v-538c87d8=""><strong data-v-538c87d8=""><span data-v-538c87d8=""
                                                    style="color: red; font-weight: bold;">PLAYERA MC-Hombre T XS *</span></strong><!----></div>
                                    </td>
                                    <td class="text-left">PLAYERA MC</td>
                                    <td class="text-left">XS</td>
                                    <td class="text-left">Hombre</td>
                                </tr>
                                <tr class="">
                                    <td class="q-table--col-auto-width">
                                        <div tabindex="0" role="checkbox" aria-checked="false"
                                            class="q-checkbox cursor-pointer no-outline row inline no-wrap items-center">
                                            <div class="q-checkbox__inner relative-position non-selectable q-checkbox__inner--falsy"><input
                                                    type="checkbox" class="hidden q-checkbox__native absolute q-ma-none q-pa-none">
                                            </div><span tabindex="-1" class="no-outline"></span>
                                        </div>
                                    </td>
                                    <td class="text-left">19</td>
                                    <td data-v-538c87d8="" class="q-td text-left" style="font-weight: bold;">
                                        1
                                    </td>
                                    <td data-v-538c87d8="" class="q-td text-left">
                                        <div data-v-538c87d8=""><strong data-v-538c87d8=""><span data-v-538c87d8=""
                                                    style="color: red; font-weight: bold;">PLAYERA MC-Mujer T XS *</span></strong><!----></div>
                                    </td>
                                    <td class="text-left">PLAYERA MC</td>
                                    <td class="text-left">XS</td>
                                    <td class="text-left">Mujer</td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <p> <b class="text-danger">*</b> Los artículos remarcados en rojo son artículos que ya están en un pedido creado</p>
    </div>

    <!-- Modal de confirmación de eliminar -->
    <div class="modal fade" id="modalConfirm" tabindex="-1" aria-labelledby="modalConfirmLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalConfirmLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de eliminar los artículos seleccionados?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmarEliminarBtn">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación de generar pedido -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirmar Pedido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
</div>
