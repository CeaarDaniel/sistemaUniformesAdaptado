<!DOCTYPE html>
<html dir="ltr" lang="es">
<head>
    <title>Cambio de Artículos</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/ico" href="logo_b.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome (para íconos) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <style>
        .table-container {
            max-height: 63vh;
            overflow-y: auto;
        }
        .table thead th {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
            z-index: 1;
        }
        .btn-action {
            margin: 0 2px;
        }
        .btn-action i {
            font-size: 1rem;
        }
        .text-disabled {
            color: #ccc;
        }
        .text-line-through {
            text-decoration: line-through;
        }
    </style>
</head>
<body class="desktop no-touch body--light">
    <div id="cambios">
        <!-- Título -->
        <div class="container mt-4">
            <h1 class="title text-center">Cambio de Artículos</h1>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="container mt-4">
            <div class="row g-3 align-items-center">
                <!-- Número de Salida -->
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="numSalida" placeholder="Núm. Salida">
                        <button class="btn btn-warning" onclick="buscarArticulos()">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Información de la Salida -->
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Fecha:</strong> <span id="fechaSalida"></span></p>
                            <p><strong>Realizado por:</strong> <span id="realizadoPor"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Para:</strong> <span id="paraUsuario"></span></p>
                            <p><strong>Tipo:</strong> <span id="tipoSalida"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tablas de Artículos -->
        <div class="container mt-4">
            <div class="row">
                <!-- Tabla de Artículos Originales -->
                <div class="col-md-6">
                    <h4>Artículos (Original)</h4>
                    <div class="table-container">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cantidad</th>
                                    <th>Nombre</th>
                                    <th>Talla</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody id="tablaOriginal">
                                <!-- Filas de la tabla se llenarán dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tabla de Artículos de Cambio -->
                <div class="col-md-6">
                    <h4>Artículos (Cambio)</h4>
                    <div class="table-container">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cantidad</th>
                                    <th>Nombre</th>
                                    <th>Talla</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody id="tablaCambio">
                                <!-- Filas de la tabla se llenarán dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón de Realizar Cambio -->
        <div class="container mt-4 text-end">
            <button class="btn btn-success" onclick="abrirModalConfirmacion()">Realizar Cambio</button>
        </div>

        <!-- Modal de Confirmación -->
        <div class="modal fade" id="modalConfirmacion" tabindex="-1" aria-labelledby="modalConfirmacionLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalConfirmacionLabel">Confirmar Cambio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de realizar el cambio de artículos? Los artículos cambiados serán regresados al almacén.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="realizarCambio()">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Selección de Artículo -->
        <div class="modal fade" id="escogerArtModal" tabindex="-1" aria-labelledby="escogerArtModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="escogerArtModalLabel">Seleccionar Artículo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Selecciona un artículo para realizar el cambio.</p>
                        <!-- Aquí iría la lista de artículos disponibles -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="seleccionarArticulo()">Seleccionar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <!-- Script personalizado -->
    <script>
        // Datos de ejemplo (simulados)
        const salida = {
            fecha: "2023-10-01",
            nombre: "Usuario 1",
            usuario: "Empleado 1",
            tipo_salida: "Tipo 1"
        };

        const salida_articulos = [
            { id_articulo: 1, cantidad: 5, nombre: "Camisa", talla: "M" },
            { id_articulo: 2, cantidad: 3, nombre: "Pantalón", talla: "L" }
        ];

        const articulos_cambio = [];
        const ids_articulos = [];
        const ids_articulos_cambio = [];

        // Función para renderizar las tablas
        function renderTables() {
            // Tabla de Artículos Originales
            const tbodyOriginal = document.getElementById('tablaOriginal');
            tbodyOriginal.innerHTML = salida_articulos.map(art => `
                <tr>
                    <td class="${ids_articulos.includes(art.id_articulo) ? 'text-disabled text-line-through' : ''}">${art.id_articulo}</td>
                    <td class="${ids_articulos.includes(art.id_articulo) ? 'text-disabled text-line-through' : ''}">${art.cantidad}</td>
                    <td class="${ids_articulos.includes(art.id_articulo) ? 'text-disabled text-line-through' : ''}">${art.nombre}</td>
                    <td class="${ids_articulos.includes(art.id_articulo) ? 'text-disabled text-line-through' : ''}">${art.talla}</td>
                    <td>
                        ${!ids_articulos.includes(art.id_articulo) ? `
                            <button class="btn btn-success btn-action" onclick="abrirEscogerArtModal(${art.id_articulo}, '${art.nombre}')">
                                <i class="fas fa-exchange-alt"></i>
                            </button>
                        ` : ''}
                    </td>
                </tr>
            `).join('');

            // Tabla de Artículos de Cambio
            const tbodyCambio = document.getElementById('tablaCambio');
            tbodyCambio.innerHTML = articulos_cambio.map(art => `
                <tr>
                    <td>${art.id_articulo}</td>
                    <td>${art.cantidad}</td>
                    <td>${art.nombre}</td>
                    <td>${art.talla}</td>
                    <td>
                        <button class="btn btn-danger btn-action" onclick="cancelarCambio(${art.id_articulo})">
                            <i class="fas fa-times"></i>
                        </button>
                    </td>
                </tr>
            `).join('');
        }

        // Función para buscar artículos
        function buscarArticulos() {
            const numSalida = document.getElementById('numSalida').value;
            if (!numSalida) {
                alert('Ingresa un número de salida válido.');
                return;
            }
            // Simulación de carga de datos
            document.getElementById('fechaSalida').textContent = salida.fecha;
            document.getElementById('realizadoPor').textContent = salida.nombre;
            document.getElementById('paraUsuario').textContent = salida.usuario;
            document.getElementById('tipoSalida').textContent = salida.tipo_salida;
            renderTables();
        }

        // Función para abrir el modal de selección de artículo
        function abrirEscogerArtModal(id, nombre) {
            document.getElementById('escogerArtModal').dataset.id = id;
            document.getElementById('escogerArtModalLabel').textContent = `Seleccionar Artículo para ${nombre}`;
            new bootstrap.Modal(document.getElementById('escogerArtModal')).show();
        }

        // Función para seleccionar un artículo
        function seleccionarArticulo() {
            const id = document.getElementById('escogerArtModal').dataset.id;
            const articulo = { id_articulo: 3, cantidad: 5, nombre: "Camisa Nueva", talla: "M" }; // Simulación de selección
            ids_articulos.push(parseInt(id));
            ids_articulos_cambio.push(articulo.id_articulo);
            articulos_cambio.push(articulo);
            renderTables();
            new bootstrap.Modal(document.getElementById('escogerArtModal')).hide();
        }

        // Función para cancelar un cambio
        function cancelarCambio(id) {
            const index = articulos_cambio.findIndex(a => a.id_articulo === id);
            ids_articulos.splice(index, 1);
            ids_articulos_cambio.splice(index, 1);
            articulos_cambio.splice(index, 1);
            renderTables();
        }

        // Función para abrir el modal de confirmación
        function abrirModalConfirmacion() {
            if (ids_articulos.length === 0) {
                alert('No has seleccionado ningún artículo para cambiar.');
                return;
            }
            new bootstrap.Modal(document.getElementById('modalConfirmacion')).show();
        }

        // Función para realizar el cambio
        function realizarCambio() {
            alert('Cambio realizado correctamente.');
            new bootstrap.Modal(document.getElementById('modalConfirmacion')).hide();
            // Aquí iría la lógica para guardar los cambios
        }

        // Renderizar las tablas al cargar la página
        renderTables();
    </script>
</body>
</html>