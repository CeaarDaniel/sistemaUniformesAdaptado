    var btnBuscar = document.getElementById('btnBuscar');
    var btnSeleccionarArticuloCambio = document.getElementById('btnSeleccionarArticuloCambio');
   
    var salida_articulos = []; //Datos de los articulos de la salida ya registrada
    const ids_articulos = []; //Id de los articulos de la salida que seran devueltos
    const articulos_cambio = []; //Datos para la tabla de los articulos agregados
    const ids_articulos_cambio = []; //Id de los nuevos articulos agregados


    btnBuscar.addEventListener('click', function () {
        navegar('cambios',$('#numSalida').val(),'mainContent'); 
    });

    btnSeleccionarArticuloCambio.addEventListener('click', seleccionarArticulo);

        // Función para renderizar las tablas
        function renderTables() {
            // Tabla de Artículos Originales
            const tbodyOriginal = document.getElementById('tablaOriginal');
            tbodyOriginal.innerHTML = salida_articulos.map(art => `
                <tr>
                    <td class="${ids_articulos.includes(parseInt(art.id_articulo)) ? 'text-decoration-line-through' : ''}">${art.id_articulo}</td>
                    <td class="${ids_articulos.includes(parseInt(art.id_articulo)) ? 'text-decoration-line-through' : ''}">${art.cantidad}</td>
                    <td class="${ids_articulos.includes(parseInt(art.id_articulo)) ? 'text-decoration-line-through' : ''}">${art.nombre}</td>
                    <td class="${ids_articulos.includes(parseInt(art.id_articulo)) ? 'text-decoration-line-through' : ''}">${art.talla}</td>
                    <td>
                        ${!ids_articulos.includes(parseInt(art.id_articulo)) ? `
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

        // Función para abrir el modal donde se ecnutra el formulario para la selección de artículos
        function abrirEscogerArtModal(event) {
            const boton = event.target.closest("button"); // Accede al atributo data-id del botón que disparó el evento
            var id = boton.getAttribute('data-id');
            var nombre = boton.getAttribute('data-nombre');

            console.log(id, nombre)

            //Se agrega un data-id con dataset.id, igual al valor del data del boton que disparo el boton
            document.getElementById('escogerArtModal').dataset.id = id;
            document.getElementById('escogerArtModalLabel').textContent = `Seleccionar Artículo para ${nombre}`;
            new bootstrap.Modal(document.getElementById('escogerArtModal')).show();
        }

        // Función para seleccionar un artículo
        function seleccionarArticulo() {
            const id = document.getElementById('escogerArtModal').dataset.id;
            const articulo = { id_articulo: 5, cantidad: 5, //Nuevo articulo agregado
                               nombre: "Camisa Nueva", talla: "M", 
                               precio: "50.00", total: "50.00" }; // Simulación de selección
            ids_articulos.push(parseInt(id)); //Se agrega el articulo que sera devuelto, a la lista de articulos
            ids_articulos_cambio.push(articulo.id_articulo); //Se agrega el articulo que saldra
            articulos_cambio.push(articulo); //Se agrega el articulo a los datos de la tabla
            renderTables();
            new bootstrap.Modal(document.getElementById('escogerArtModal')).hide();
            console.log(ids_articulos)
        }

        // Función para cancelar un cambio
        function cancelarCambio(event) {
            const boton = event.target.closest("button");
            var id = boton.getAttribute('data-id');
            const index = articulos_cambio.findIndex(a => a.id_articulo === id);
            console.log(index);
            ids_articulos.splice(index, 1);
            ids_articulos_cambio.splice(index, 1);
            articulos_cambio.splice(index, 1);
            renderTables();
        }

        function getDatos() {
            var formData = new FormData;
            formData.append("opcion", "1");
            formData.append("id_salida", $("#numSalida").val());

            fetch("./api/cambios.php", {
                method: "POST",
                body: formData,
            })
                .then((response) => response.json())
                .then((data) => {
                    salida_articulos = data;

                    //Renderizar la tabla al cargar los datos
                    renderTables();
                })
                .catch((error) => {
                    console.log(error);
                });
        }

        // Renderizar las tablas al cargar la página
        getDatos();