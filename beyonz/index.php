<?php include('./header.php'); ?>

    <!-- Sección de misión -->
    <section id="mission" class="mission-section animate-on-scroll">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto mission-content">
                    <div class="text-center mb-5">
                        <h2 class="mb-3" style="color: var(--primary);">Nuestra Filosofía</h2>
                        <div class="divider mx-auto" style="width: 80px; height: 4px; background: var(--secondary);"></div>
                    </div>
                    
                    <div class="bg-white p-4 p-lg-5 rounded-4 shadow">
                        <p class="lead text-center mb-4">
                            <span class="mission-highlight">BEYONZ MEXICANA ES UN EQUIPO.</span> Cada uno de los empleados es un miembro importante del equipo.
                        </p>
                        
                        <p class="text-center">
                            Satisfacción del Cliente, éxito del equipo, crecimiento y felicidad del integrante es el origen de la administración de la empresa.
                        </p>
                        
                        <div class="text-center mt-5">
                            <img src="./img/imagenes/footer-logo.png" class="img-fluid mb-4" style="max-height: 80px;">
                            <br>
                            <a href="politica_de_calidad" class="btn btn-warning px-4 py-2" id="boton-index-politica">
                                <b>Ver nuestra calidad</b>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Últimas noticias -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5 animate-on-scroll">
                <h2 class="mb-3" style="color: var(--primary);">Últimas Noticias</h2>
                <p class="text-muted">Mantente informado sobre nuestras actividades y logros</p>
                <div class="divider mx-auto" style="width: 80px; height: 4px; background: var(--secondary);"></div>
            </div>
            
            <div class="row card-index-noticia d-flex justify-content-center">
                <div class="col-lg-4 col-md-6 mb-4 animate-on-scroll">
                    <div class="card h-100">
                        <img src="./img/noticias/POSADA 1.jpg" class="card-img-top" alt="Posada Beyonz">
                        <div class="card-body">
                            <h4 class="card-title">POSADA</h4>
                            <p class="card-text">
                                En un ambiente festivo y lleno de alegría, Beyonz celebró su anual Posada Navideña 2023 a finales de diciembre, marcando el cierre del año con gratitud y camaradería.
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="noticia?id=Mw==" class="btn btn-primary d-block mx-auto">Leer noticia</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4 animate-on-scroll">
                    <div class="card h-100">
                        <img src="./img/noticias/MES DE LA CALIDAD 2.jpeg" class="card-img-top" alt="Mes de la Calidad">
                        <div class="card-body">
                            <h4 class="card-title">MES DE LA CALIDAD</h4>
                            <p class="card-text">
                                El Mes de la Calidad, un periodo dedicado a promover la cultura de la calidad, concientizar al personal en la realización de sus actividades diarias.
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="noticia?id=MQ==" class="btn btn-primary d-block mx-auto">Leer noticia</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4 animate-on-scroll">
                    <div class="card h-100">
                        <img src="./img/noticias/0c6bf15c-b93e-4a08-9dfe-72311c039f9f.jpg" class="card-img-top" alt="Meximold 2023">
                        <div class="card-body">
                            <h4 class="card-title">MEXIMOLD 2023</h4>
                            <p class="card-text">
                                El evento MEXIMOLD es una exposición de moldes que se llevo a cabo los días 11 y 12 de octubre del 2023 en la ciudad de Queretaro.
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="noticia?id=MTQ=" class="btn btn-primary d-block mx-auto">Leer noticia</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4 animate-on-scroll">
                <a href="noticias" class="btn btn-gen px-4 py-2 btn-noticias" >
                    <b>Ver todas las noticias</b> <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <?php 
        include('./modalContactanos.php')    
    ?>

    <?php 
        include('./footer.php')    
    ?>