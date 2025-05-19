var btnBuscar = document.getElementById('btnBuscar');
var btnSeleccionarArticuloCambio = document.getElementById('btnSeleccionarArticuloCambio');


btnBuscar.addEventListener('click', function () {
    navegar('cambios',$('#numSalida').val(),'mainContent')
})

btnSeleccionarArticuloCambio.addEventListener('click', seleccionarArticulo);


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
                    <td class="${ids_articulos.includes(art.id_articulo) ? 'text-decoration-underline' : ''}">${art.id_articulo}</td>
                    <td class="${ids_articulos.includes(art.id_articulo) ? 'text-disabled text-line-through' : ''}">${art.cantidad}</td>
                    <td class="${ids_articulos.includes(art.id_articulo) ? 'text-disabled text-line-through' : ''}">${art.nombre}</td>
                    <td class="${ids_articulos.includes(art.id_articulo) ? 'text-disabled text-line-through' : ''}">${art.talla}</td>
                    <td>
                        ${!ids_articulos.includes(art.id_articulo) ? `
                            <button class='btn btn-success btn-action btnEscoger' 
                                    data-id = '${art.id_articulo}' 
                                    data-nombre = '${art.nombre}' >
                                <i class="fas fa-exchange-alt"></i>
                            </button>
                        ` : ''}
                    </td>
                </tr>
            `).join('');

    

                let btnEscoger = document.querySelectorAll(".btnEscoger");
                btnEscoger.forEach(boton => {
                    boton.removeEventListener("click", abrirEscogerArtModal);
                    boton.addEventListener("click", abrirEscogerArtModal);
                });



            // Tabla de Artículos de Cambio
            const tbodyCambio = document.getElementById('tablaCambio');
            tbodyCambio.innerHTML = articulos_cambio.map(art => `
                <tr>
                    <td>${art.id_articulo}</td>
                    <td>${art.cantidad}</td>
                    <td>${art.nombre}</td>
                    <td>${art.talla}</td>
                    <td>
                        <button class="btn btn-danger btnCancelarCambio" 
                                data-id="${art.id_articulo}" >
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `).join('');

            let btnCancelar = document.querySelectorAll(".btnCancelarCambio");

            btnCancelar.forEach(boton => {
                boton.removeEventListener("click", cancelarCambio);
                boton.addEventListener("click", cancelarCambio);
            });
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
        function abrirEscogerArtModal(event) {
            const boton = event.target.closest("button"); // Accede al atributo data-id del botón que disparó el evento
            var id = boton.getAttribute('data-id');
            var nombre = boton.getAttribute('data-nombre');

            //Se agrega un data-id con dataset.id, igual al valor del data del boton que disparo el boton
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
            console.log(ids_articulos)
        }

        // Función para cancelar un cambio
        function cancelarCambio(event) {
            const boton = event.target.closest("button");
            var id = boton.getAttribute('data-id');
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