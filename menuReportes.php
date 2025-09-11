    <div id="menuReportes">
        <!-- Título -->
        <div class="title mt-5 mx-5">
            <h2>Reportes</h2>
        </div>
        <div class="row px-5 mx-0 mx-md-4 justify-content-center">
            <!-- Tarjeta 2: Venta de uniforme -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 my-2" >
                <a onclick="cargarRuta('reporteVentas')"  class="text-decoration-none">
                    <div class="card-shortcut text-center q-card p-4">
                        <div class="">
                            <div class="q-avatar bg-blue-10 text-white">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                        </div>
                        <div class="">
                            <span style="font-size: 16px; font-weight: bold; color:black;">Ventas</span>
                            <p style="font-size: 16px; color:black;">Salidas</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Tarjeta 3: Entrega de uniforme usado -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 my-2">
                <a onclick="cargarRuta('reportesExistencias')" class="text-decoration-none">
                    <div class="card-shortcut text-center q-card p-4">
                        <div class="">
                            <div class="q-avatar bg-blue-10 text-white">
                                <i class="fas fa-warehouse"></i>
                            </div>
                        </div>
                        <div class="">
                            <span style="font-size: 16px; font-weight: bold; color:black;">Existencias</span>
                            <p style="font-size: 16px; color:black;">Inventario</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Tarjeta 4: Reposición de uniforme -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 my-2">
                <a onclick="cargarRuta('reportesSalidas')" class="text-decoration-none">
                    <div class="card-shortcut text-center q-card p-4">
                        <div class="">
                            <div class="q-avatar bg-blue-10 text-white">
                                <i class="fas fa-external-link-alt"></i>
                            </div>
                        </div>
                        <div class="">
                            <span style="font-size: 16px; font-weight: bold; color:black;">Salidas</span>
                            <p style="font-size: 16px; color:black;">Almacén</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>