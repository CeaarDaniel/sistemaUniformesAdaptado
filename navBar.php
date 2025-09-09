<div id="inicio">
    <!-- Header -->
    <header class="fixed-top bg-white shadow-sm">
        <nav class="navbar navbar-expand-xl navbar-light bg-white" style="box-shadow: 0px 1px 10px #888888;">
            <div class="container-fluid">

                <div class="ps-5 d-flex justify-content-between align-items-center" style="width:25%">
                    <!-- Logo -->
                    <a class="navbar-brand" onclick="cargarRuta('dashboard')">
                        <img src="MainLogo.svg" alt="Logo" class="img-logo">
                    </a>

                    <!-- Botón para menú en móviles -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>

                <!-- Menú de navegación -->
                <div class="collapse navbar-collapse px-4" id="navbarNav">
                    <ul class="pe-3 navbar-nav d-flex justify-content-between w-100 p-0 m-0">
                        <!-- Notificaciones -->
                        <li class="nav-item position-relative">
                            <a class="nav-link" style="font-size:20px;">
                                <i class="fas fa-bell"></i>
                            </a>
                            <span class="notification-badge">3</span>
                        </li>

                        <!-- Menú desplegable: Altas -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="altasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                ALTAS
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="altasDropdown">
                                <li><a class="dropdown-item" onclick="cargarRuta('altasArticulos')">Altas de artículos</a></li>
                                <li><a class="dropdown-item" onclick="cargarRuta('altasCategorias')">Altas de categorias</a></li>
                            </ul>
                        </li>

                        <!-- Enlaces -->
                        <li class="nav-item">
                            <a class="nav-link" onclick="cargarRuta('entradas')">ENTRADAS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" onclick="cargarRuta('salidas')">SALIDAS</a>
                        </li>

                        <!-- Menú desplegable: Consultas -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="consultasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                CONSULTAS
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="consultasDropdown">
                                <li><a class="dropdown-item" onclick="cargarRuta('consultaSalidas')">De salidas</a></li>
                                <li><a class="dropdown-item" onclick="cargarRuta('consultaVentas')">De ventas</a></li>
                                <li><a class="dropdown-item" onclick="cargarRuta('consultasReportes')">De reportes</a></li>
                            </ul>
                        </li>

                        <!-- Más enlaces -->
                        <li class="nav-item">
                            <a class="nav-link" onclick="cargarRuta('almacen')">ALMACÉN</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" onclick="cargarRuta('pedidos')">PEDIDOS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" onclick="cargarRuta('menuReportes')">REPORTES</a>
                        </li>

                        <!-- Avatar y Cerrar sesión -->
                        <li class="nav-item">
                            <div class="text-white d-flex align-items-center justify-content-center p-0" 
                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="MIGUEL ALEJANDRO GOMEZ ASPEITIA"
                                style="background-color: #1976d2; border-radius:50%; width: 40px; height: 40px; display: inline-block;">
                                <b style="font-size:18px;">M</b>
                            </div>
                        </li>
                        <li class="nav-item" onclick ="logOut()">
                            <a class="nav-link p-0" style="font-size:25px;">
                                <i class="fas fa-sign-out-alt"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</div>