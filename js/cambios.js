    var btnBuscar = document.getElementById('btnBuscar');
    var btnSeleccionarArticuloCambio = document.getElementById('btnSeleccionarArticuloCambio');
    var btnRealizarCambio = document.getElementById('btnRealizarCambio');
   
    //VARIABLES DE REGISTROS
    var salida_articulos = []; //Datos de los articulos de la salida ya registrada
    const articulos_regreso = [] // Datos de los articulos que regresaran al almacen
    const ids_articulos = []; //Id de los articulos de la salida que seran devueltos
    const articulos_cambio = []; //Datos para la tabla de los articulos agregados
    const ids_articulos_cambio = []; //Id de los nuevos articulos agregados

    //INPUTS DEL FORMULARIO 
        var categoria = document.getElementById('tipo') //Select de Categoria
        var selectTalla = document.getElementById('talla');
        var selectGenero = document.getElementById('genero'); 
        var idArticulo = document.getElementById('id');
        var nombre = document.getElementById('nombre');
        var precio = document.getElementById('precio');
        var cantidad = document.getElementById('cantidadArt');


    btnBuscar.addEventListener('click', function () {
        navegar('cambios',$('#numSalida').val(),'mainContent'); 
    });

    btnSeleccionarArticuloCambio.addEventListener('click', seleccionarArticulo);
    btnRealizarCambio.addEventListener('click', realizarCambio);


    categoria.addEventListener('change', function () {
        //AGREGAR LOS VALORES A LOS CAMPOS DE ACUERDO AL VALOR DE LA CATEGORIA 
        if (categoria && categoria.value) actualizarFormulario();

        //LIMPIAR LOS VALORES DEL FORMULARIO
        else {
            var tallas = '<option value="" selected>Seleccione una talla</option>';
            var generos = '<option value="" selected>Seleccione género</option>';
            selectTalla.innerHTML = `${tallas}`;
            selectGenero.innerHTML = `${generos}`;
        }
        actualizarArticulo();
    })

    selectTalla.addEventListener('change', actualizarArticulo);
    selectGenero.addEventListener('change', actualizarArticulo);

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
                                    data-nombre = '${art.nombre}' 
                                    data-cantidad = '${art.cantidad}'>
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
                                data-id="${art.id_articuloSalida}">
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
            var cantidad = boton.getAttribute ('data-cantidad')

            console.log(id, nombre)

            //Se agrega un data-id con dataset.id, igual al valor del data del boton que disparo el boton
            document.getElementById('escogerArtModal').dataset.id = id;
            $("#cantidadArt").val(cantidad);
            document.getElementById('escogerArtModalLabel').textContent = `Seleccionar Artículo para ${nombre}`;
            new bootstrap.Modal(document.getElementById('escogerArtModal')).show();
        }

        // Función para seleccionar un artículo
        function seleccionarArticulo() {
            const id = document.getElementById('escogerArtModal').dataset.id;
            console.log(cantidad.max)

            if(cantidad.value > cantidad.max) 
                alert("No hay suficientes unidades para este artículo")

            else 
                if(id == $("#id").val()) 
                    alert("No puedes cambiar un artículo por el mismo, selecciona uno diferente");
                
             else {
                 var fmamantenimiento = document.getElementById("formAgregarArticulo");
                 var isValidfm = fmamantenimiento.reportValidity();

                 if (isValidfm) {

                     //ARTICULO SELECCIONADO
                     const articulo = {
                         id_articulo: $('#id').val(),
                         cantidad: $("#cantidadArt").val(), //Nuevo articulo agregado
                         nombre: $('#nombre').val(),
                         talla: $('#talla option:selected').text(),
                         precio: $('#precio').val(),
                         id_articuloSalida: id //ARTICULO DE LA SALIDA AL QUE SE LE AGREGO EL ARTICULO DE ENTRADA
                     };

                     ids_articulos.push(parseInt(id)); //Se agrega el articulo que sera devuelto, a la lista de articulos
                     ids_articulos_cambio.push(articulo.id_articulo); //Se agrega el articulo que saldra
                     articulos_cambio.push(articulo); //Se agrega el articulo a los datos de la tabla
                     renderTables();
                     bootstrap.Modal.getInstance(document.getElementById('escogerArtModal')).hide();
                 }
             }
        }

        // Función para cancelar un cambio
        function cancelarCambio(event) {
            const boton = event.target.closest("button");
            var id = boton.getAttribute('data-id');
            const index = articulos_cambio.findIndex(a => a.id_articuloSalida === id);
           // console.log("indice borrado",index);
           //console.log("Valor del indice",id);
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

        function realizarCambio() {
            let cont = 0;
            salida_articulos.forEach(articulo => {
                articulo.agregado = ids_articulos.includes(parseInt(articulo.id_articulo));

                if(articulo.agregado)
                    cont ++;
            });

            if(cont <= 0) alert("No se ha seleccionado ningún artículo para realizar el cambio")

            else {
                alert("Se a realizado el cambio");
                
            } 
        }


        function actualizarFormulario(){
            var formDataGet = new FormData;
            formDataGet.append('opcion', 3);
            formDataGet.append('categoria', categoria.value);

            //Obtiene las tallas y generos de la categoria seleccionada
            fetch("./api/entradas.php", {
                method: "POST",
                body: formDataGet,
            })
                .then((response) => response.json())
                .then((data) => {
                    var tallas = '<option value="" selected>Seleccione una talla</option>';
                    var generos = '<option value="" selected>Seleccione género</option>';

                    data.generos.forEach(genero => {
                        generos += `<option value="${genero.id_genero}"> ${genero.genero} </option>`;
                    })

                    data.tallas.forEach(talla => {
                        tallas += `<option value="${talla.id_talla}"> ${talla.talla} </option>`;
                    })
                    selectTalla.innerHTML = `${tallas}`;
                    selectGenero.innerHTML = `${generos}`;
                })
                .catch((error) => {
                    console.log(error);
                })
        }

        //Esta funcion obtiene el articulo correspondiente a las categorias, talla y genero seleccionados 
        function actualizarArticulo(){
            var formDataGet = new FormData;
            formDataGet.append('opcion', 4);
            formDataGet.append('categoria', categoria.value);
            formDataGet.append('talla', selectTalla.value);
            formDataGet.append('genero', selectGenero.value);
            fetch("./api/entradas.php", {
                method: "POST",
                body: formDataGet,
            })
                .then((response) => response.json())
                .then((data) => {

                    if(data.articulo == null) {
                       // $('#btnSeleccionarArticuloCambio').prop('disabled', true);
                        $('#nombre').val("")
                    }
                    else {
                        btnSeleccionarArticuloCambio.disabled= false
                        nombre.value = data.articulo.nombre;
                        precio.value= data.articulo.precio;
                        cantidad.max = data.articulo.cantidad;
                        cantidad.min = (cantidad.max <= 0) ? cantidad.max : 1;
                        $('#id').val(data.articulo.id_articulo);
                    }

                })
                .catch((error) => {
                    console.log(error);
                })
        }
        // Renderizar las tablas al cargar la página
        getDatos();