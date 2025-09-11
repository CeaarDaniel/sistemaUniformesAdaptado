<?php include('./header.php'); ?>

    <!-- Sección de contacto -->
    <section class="contact-hero animate-on-scroll">
        <div class="container">
            <h2 class="mb-4">CONTÁCTANOS</h2>
            <div class="contact-intro">
                <p>Déjanos saber tus necesidades y nos pondremos en contacto contigo. También puedes enviarnos un mensaje a nuestra dirección de correo, comunicarte a nuestro número de teléfono o por vía WhatsApp. Nuestro horario de atención es de 8:00 am a 5:36 pm.</p>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="map-container animate-on-scroll">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14793.18428938518!2d-102.2839736!3d22.0382671!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8429e493820f0541%3A0x81fbbb95d74d80b9!2sBeyonz%20Mexicana%20Planta%20Transmisi%C3%B3nes%20y%20Suspensi%C3%B3nes!5e0!3m2!1ses!2smx!4v1693505308751!5m2!1ses!2smx" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>

    <section class="contact-form-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="form-container animate-on-scroll">
                        <h3 class="form-title">FORMULARIO DE CONTACTO</h3>
                        <p class="mb-4">Déjanos tus comentarios y en breve un representante se comunicará contigo.</p>
                        
                        <form id="contactanos" method="post" role="form" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Correo</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="mensage" class="form-label">Mensaje</label>
                                <textarea class="form-control" id="mensage" name="mensage" placeholder="Escribe tu mensaje aquí..." rows="6" required></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="numero" class="form-label">Número de teléfono</label>
                                <input type="tel" class="form-control" id="numero" name="numero" placeholder="Número de teléfono" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="archivo" class="form-label">Agregar un archivo (opcional)</label>
                                <input type="file" class="form-control" id="archivo" name="archivo">
                            </div>
                            
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary px-5 py-3">
                                    Enviar mensaje <i class="fas fa-paper-plane ms-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-info-section">
        <div class="container text-center">
            <h3 class="mb-5">Otras formas de contactarnos</h3>
            
            <div class="contact-methods">
                <div class="contact-card animate-on-scroll">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h4>Correo Electrónico</h4>
                    <p>Escríbenos directamente a:</p>
                    <a href="mailto:info@beyonz.com.mx" class="contact-link">info@beyonz.com.mx</a>
                </div>
                
                <div class="contact-card animate-on-scroll">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h4>Teléfono</h4>
                    <p>Llámanos de lunes a viernes</p>
                    <a href="tel:+524494782500" class="contact-link">+52 (449) 478 2500</a>
                </div>
                
                <div class="contact-card animate-on-scroll">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h4>Visítanos</h4>
                    <p>Circuito Cerezos Sur #104</p>
                    <p>Parque Industrial San Francisco</p>
                    <p>San Francisco de los Romo, Ags.</p>
                </div>
            </div>
            
            <div class="mt-5 animate-on-scroll">
                <h4 class="mb-4">¿Prefieres contactarnos por WhatsApp?</h4>
                <a href="https://wa.me/524494782500" class="btn btn-success px-4 py-2" target="_blank">
                    <i class="fab fa-whatsapp me-2"></i> Enviar mensaje por WhatsApp
                </a>
            </div>
        </div>
    </section>

<?php 
    include('./footer.php')    
?>