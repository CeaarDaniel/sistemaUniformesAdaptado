        let state = {
            articulos: [],
            selected: [],
            currentArticulo: null
        };

        // Elementos del DOM
        const elementos = {
            cantidad: document.getElementById('cantidad'),
            tablaArticulos: document.getElementById('tablaArticulos'),
            progressBar: document.getElementById('progressBar')
        };

        // Event Listeners
        document.getElementById('agregarArticuloBtn').addEventListener('click', agregarArticulo);
        document.getElementById('eliminarBtn').addEventListener('click', mostrarModalEliminar);
        document.getElementById('generarEntradaBtn').addEventListener('click', mostrarModalConfirmacion);
        document.getElementById('selectAll').addEventListener('change', toggleSelectAll);
        document.getElementById('confirmarEliminacionBtn').addEventListener('click', confirmarEliminacion);
        document.getElementById('confirmarEntradaBtn').addEventListener('click', generarEntrada);
        
        // Teclas rápidas
        document.addEventListener('keydown', (e) => {
            if (e.altKey) {
                if (e.key === 'a') document.getElementById('seleccionarArticuloModal').click();
                if (e.key === 'c') mostrarModalConfirmacion();
                if (e.key === 'Enter') agregarArticulo();
            }
        });

        // Funciones principales
        function agregarArticulo() {
            const cantidad = parseInt(elementos.cantidad.value);
            
            if (!state.currentArticulo) {
                mostrarAlerta('Selecciona un artículo primero', 'warning');
                return;
            }
            
            if (cantidad < 1) {
                mostrarAlerta('La cantidad debe ser mayor a cero', 'warning');
                return;
            }

            const existente = state.articulos.find(a => a.id === state.currentArticulo.id);
            
            if (existente) {
                existente.cantidad += cantidad;
            } else {
                state.articulos.push({
                    ...state.currentArticulo,
                    cantidad: cantidad
                });
            }

            elementos.cantidad.value = 1;
            state.currentArticulo = null;
            document.getElementById('articuloNombre').value = '';
            actualizarVista();
        }

        function actualizarVista() {
            elementos.tablaArticulos.innerHTML = state.articulos.map(articulo => `
                <tr data-id="${articulo.id}">
                    <td>${articulo.id}</td>
                    <td>${articulo.cantidad}</td>
                    <td>${articulo.nombre}</td>
                    <td>${articulo.categoria}</td>
                    <td>${articulo.talla}</td>
                    <td>${articulo.genero}</td>
                    <td><input type="checkbox" class="select-item"></td>
                </tr>
            `).join('');

            document.querySelectorAll('.select-item').forEach(checkbox => {
                checkbox.addEventListener('change', (e) => {
                    const id = parseInt(e.target.closest('tr').dataset.id);
                    if (e.target.checked) {
                        state.selected.push(id);
                    } else {
                        state.selected = state.selected.filter(item => item !== id);
                    }
                });
            });
        }

        function toggleSelectAll(e) {
            const checkboxes = document.querySelectorAll('.select-item');
            checkboxes.forEach(checkbox => {
                checkbox.checked = e.target.checked;
                checkbox.dispatchEvent(new Event('change'));
            });
        }

        function mostrarModalEliminar() {
            if (state.selected.length === 0) {
                mostrarAlerta('Selecciona al menos un artículo', 'warning');
                return;
            }
            new bootstrap.Modal('#confirmarEliminarModal').show();
        }

        function confirmarEliminacion() {
            state.articulos = state.articulos.filter(articulo => 
                !state.selected.includes(articulo.id)
            );
            state.selected = [];
            actualizarVista();
            mostrarAlerta('Artículos eliminados correctamente', 'success');
            bootstrap.Modal.getInstance('#confirmarEliminarModal').hide();
        }

        async function generarEntrada() {
            if (state.articulos.length === 0) {
                mostrarAlerta('No hay artículos para procesar', 'danger');
                return;
            }
            
            elementos.progressBar.classList.remove('d-none');
            
            // Simular envío a la API
            try {
                const user = JSON.parse(localStorage.getItem('user'));
                const response = await fetch('/api/entradas', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        datosEntrada: {
                            fecha: new Date().toISOString().split('T')[0],
                            tipo_entrada: 2,
                            id_usuario: user.id
                        },
                        articulos: state.articulos
                    })
                });

                if (!response.ok) throw new Error('Error en la solicitud');
                
                mostrarAlerta('Entrada generada correctamente', 'success');
                window.location.href = '/uniformes/dashboard';
            } catch (error) {
                mostrarAlerta('Error al generar la entrada', 'danger');
            } finally {
                elementos.progressBar.classList.add('d-none');
            }
        }

        function mostrarAlerta(mensaje, tipo) {
            const alerta = document.createElement('div');
            alerta.className = `alert alert-${tipo} alert-dismissible fade show fixed-alert`;
            alerta.innerHTML = `
                ${mensaje}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(alerta);
            setTimeout(() => alerta.remove(), 3000);
        }

        function mostrarModalConfirmacion() {
            new bootstrap.Modal('#confirmarEntradaModal').show();
        }