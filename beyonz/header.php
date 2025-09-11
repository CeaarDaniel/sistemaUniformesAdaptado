<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Beyonz Mexican S.A de C.V.</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Montserrat:wght@600;700&display=swap" rel="stylesheet">

    <!--Estilos personalisdos-->
    <link rel="stylesheet" href="estilos.css">

</head>
<body>
    <!-- Header con animación -->
    <header id="header" class="container-fluid p-0">
        <div class="d-flex text-center text-light justify-content-center p-5">
            <div class="pt-5 header-content">
                <h1 class="my-0 encabezado">Beyonz Mexicana S.A de C.V.</h1>
                <h3 class="mt-3 encabezado" style="font-weight: 400;">Trabajamos siempre con calidad y disciplina</h3>
                <div class="mt-4">
                    <a href="#navbarNav" class="btn btn-lg btn-warning px-5 py-3 rounded-pill" style="font-weight: 600;">
                        Conoce más <i class="fas fa-arrow-down ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Navbar -->
    <div class="sticky-top" id="navbar">
        <nav class="navbar navbar-expand-lg navbar-light py-2">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="img/imagenes/logo.png" alt="Beyonz Logo">
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php">INICIO</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="nosotros" id="drop1">
                                NOSOTROS
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="nosotros">¿QUIENES SOMOS?</a>
                                <a class="dropdown-item" href="politica_de_calidad">NUESTRA CALIDAD</a>
                                <a class="dropdown-item" href="nosotros#plantas">PLANTAS</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="procesos2" id="drop2">
                                PROCESO
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="proceso_automotriz">PROCESO AUTOMOTRÍZ</a>
                                <a class="dropdown-item" href="proceso_moldes">PROCESO MOLDES</a>
                                <a class="dropdown-item" href="equipos">NUESTROS EQUIPOS</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="productos" id="drop3">
                                PRODUCTOS
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="productos#">AUTOMOTRÍZ</a>
                                <a class="dropdown-item" href="productos#contenedor-productos-moldes">MOLDES</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="noticias">NOTICIAS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="clientes">CLIENTES</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="empleos">EMPLEOS</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn nav-link" href="contacto.php#navbar">CONTACTO</a>
                        </li>
                        <li class="nav-item ms-lg-3 py-1">
                            <a class="btn btn-idioma" href="#" onclick="cambiarIdioma()">
                                INGLÉS
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>