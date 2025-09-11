  <!-- Botón de contacto flotante -->
    <button id="contactanos" type="button" class="btn contactanos" data-bs-toggle="modal" data-bs-target="#contactModal">
        <i class="fas fa-envelope me-2"></i> CONTÁCTANOS
    </button>

    <!-- Modal de contactanos-->
    <div class="modal fade" id="contactModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">CONTÁCTANOS</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="contactar" action="" method="post">
                        <input type="hidden" name="opcion" value="3">
                        
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Correo</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="mensage" class="form-label">Mensaje</label>
                            <textarea class="form-control" id="mensage" name="mensage" placeholder="Mensaje" rows="4" required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="numero" class="form-label">Número de teléfono</label>
                            <input type="tel" class="form-control" id="numero" name="numero" placeholder="Número de teléfono" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="archivo" class="form-label">Agregar un archivo (opcional)</label>
                            <input type="file" class="form-control" id="archivo" name="archivo">
                        </div>
                        
                        <button type="submit" class="btn btn-submit">
                            ENVIAR MENSAJE
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>