        var empleado = document.getElementById('empleadoInput');
        var nombreEmpleado = document.getElementById('nombreEmpleado');
        var emptyState = document.getElementById('emptyState');
        var confirmarBtn = document.getElementById('confirmarBtn');
        let datos = []
        let total = 0;
        let tipoNomina= '';
        var isEmpleado = false;
        const descuentosModal = new bootstrap.Modal(document.getElementById("descuentosModal"));

    
    // Fuente de datos inicial
        var  btnAgregarArticulo = document.getElementById('btnAgregarArticulo');
         let btnModalDescuentos = document.getElementById('btnModalDescuentos');

        var  eliminarBtn = document.getElementById('cancelarBtn');
        var categoria = document.getElementById('tipo') //Select de Categoria
        var selectTalla = document.getElementById('talla');
        var selectGenero = document.getElementById('genero'); 
        var idArticulo = document.getElementById('id');
        var nombre = document.getElementById('nombre');
        var precio = document.getElementById('precio');
        var cantidad = document.getElementById('cantidadArt');


        const table = $('#tablaArticulos').DataTable();

        btnAgregarArticulo.addEventListener('click', agregarArticulo)

        eliminarBtn.addEventListener('click', function(){
            datos= [];
            isEmpleado = false;
            total=0;
            empleado.value= '';
            nombreEmpleado.textContent ="";
            $('#costoTotalVenta').text(total)
            actualizarVista();
            ocultarMostrarTabla();
        })
    
        categoria.addEventListener('change', function () {
                if(categoria && categoria.value) actualizarFormulario();

                else {
                    var tallas  = '<option value="" selected>Seleccione una talla</option>';
                    var generos = '<option value="" selected>Seleccione género</option>';
                        selectTalla.innerHTML= `${tallas}`;
                        selectGenero.innerHTML = `${generos}`;
                }
                actualizarArticulo();
        })

        //VALIDAR EL NUMERO DE NOMINA DEL EMPLEADO
        empleado.addEventListener('change', function(){
                        var formDataGetUser = new FormData;
                        formDataGetUser.append('opcion', 3);
                        formDataGetUser.append('NN', Number(empleado.value)); 
                        fetch("./api/salidas.php", {
                            method: "POST",
                            body: formDataGetUser,
                        }).then((response) => response.json())
                            .then((dataUs) => {
                                if(dataUs.ok){
                                    nombreEmpleado.textContent = dataUs.nombreEmpleado;
                                    tipoNomina = dataUs.tipoNomina;
                                    isEmpleado = true;
                                }

                                else {
                                    nombreEmpleado.textContent = '';
                                    isEmpleado = false ;
                                    tipoNomina = '';
                                }
                            })
                            .catch((error) => {
                                console.log(error);
                            })
        })


        selectTalla.addEventListener('change', actualizarArticulo);
        selectGenero.addEventListener('change', actualizarArticulo);
        confirmarBtn.addEventListener('click', validarSalida);
        btnModalDescuentos.addEventListener('click', registrarSalida)
    

    function actualizarVista() {
            var ancho = window.innerWidth;

            $('#tablaArticulos').DataTable().destroy(); //Restaurar la tablas
            //Crear el dataTable con las nuevas configuraciones
            var tabla = $('#tablaArticulos').DataTable({
                responsive: true,
                scrollX: ancho - 100,
                scrollY: 340,
                scrollCollapse: true,
                data: datos,
                columns: [
                    { "data": "id" },
                    { "data": "nombre" },
                    { "data": "tipo" },
                    { "data": "cantidad" },
                    { "data": "precio" },
                    { "data": "genero"},
                    { "data": "boton" }
                ],
                columnDefs: [
                    {
                        targets: [0, 1, 2, 3, 4, 5],
                        className: 'text-center'
                    }
                ],
                "drawCallback": function (settings) {

                    var api = this.api();
                    // Delegar evento a los botones de eliminar en la página actual
                    api.rows({ page: 'current' }).nodes().each(function (row, index) {
                        $(row).find('.btn-eliminar').off('click').on('click', function (e) {
                            e.stopPropagation(); // evita que se dispare otro evento en la fila
                            var fila = tabla.row($(this).closest('tr'));
                            total -= (fila.data().cantidad * fila.data().precio)
                            fila.remove().draw();

                            // Luego de eliminar una fila o cuando lo necesites
                            datos = tabla.rows().data().toArray();
                            ocultarMostrarTabla();
                            $('#costoTotalVenta').text(total)
                        });
                    });
                }
            });
            // document.getElementById('reporteTable').classList.add('d-none');
    }

    //Esta funcion obtiene las tallas y generos de la categoria seleccionada
    function actualizarFormulario(){
        
        var formDataGet = new FormData;
        formDataGet.append('opcion', 3);
        formDataGet.append('categoria', categoria.value);

        fetch("./api/entradas.php", {
            method: "POST",
            body: formDataGet,
        })
            .then((response) => response.json())
            .then((data) => {

                console.log("Tallas: ", data.tallas);
                console.log("Generos: ", data.generos);

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
                cantidad.value = "";
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
        cantidad.value ="" 
        fetch("./api/entradas.php", {
            method: "POST",
            body: formDataGet,
        })
            .then((response) => response.json())
            .then((data) => {

                if(data.articulo == null) {
                    $('#btnAgregarArticulo').prop('disabled', true);
                }
                else {
                    btnAgregarArticulo.disabled= false
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
    
    function agregarArticulo() {
        var fmamantenimiento = document.getElementById("formAgregarArticulo");
        var isValidfm = fmamantenimiento.reportValidity();
                if (isValidfm) {
                    if(cantidad.max <= 0)
                        alert('No hay suficientes unidades para este artículo')

                    else
                        if (idArticulo.value == '' || idArticulo === null || !idArticulo || !idArticulo.value)
                            alert("Este artículo no esta disponible o no existe")

                        else {

                            const tabla = $('#tablaArticulos').DataTable();
                            const nuevoId = Number(document.getElementById("id").value);
                            const nuevaCantidad = Number(document.getElementById("cantidadArt").value);

                            // Buscar en todas las filas (incluyendo páginas no visibles)
                            let filaExistente = null;
                            tabla.rows().every(function (index) {
                                const filaData = this.data();
                                if (filaData.id === nuevoId) {
                                    filaExistente = this;
                                    return false; // Detener la iteración
                                }
                            });

                            if (!filaExistente) {
                                // Agregar nuevo artículo
                                const nuevoArticulo = {
                                    id: nuevoId,
                                    nombre: document.getElementById("nombre").value,
                                    tipo: $('#tipo option:selected').data('abrev'), //document.getElementById("tipo").value,
                                    cantidad: nuevaCantidad,
                                    precio: Number(document.getElementById("precio").value),
                                    genero: $('#genero option:selected').text(),
                                    boton: "<button class='btn btn-danger my-0 mx-1 btn-eliminar'><i class='fas fa-trash'></i></button>"
                                };

                                datos.push(nuevoArticulo);
                                tabla.row.add(nuevoArticulo).draw(false);
                                total += (Number(document.getElementById("precio").value)* nuevaCantidad);
                                document.querySelectorAll("#formAgregarArticulo input").forEach(input => input.value = "");
                                document.querySelectorAll("#formAgregarArticulo select").forEach(select => {
                                    select.selectedIndex = 0; // selecciona la primera opción
                                });
                            } else {
                                // Actualizar cantidad en fila existente
                                const datosActualizados = filaExistente.data();
                                

                                if (parseInt(datosActualizados.cantidad + nuevaCantidad) > parseInt(cantidad.max)) {
                                    alert(
                                        `Has alcanzado la cantidad máxima permitida para este artículo.\n` +
                                        `➤ Cantidad agregada: ${datosActualizados.cantidad}\n` +
                                        `➤ Cantidad por agregar: ${nuevaCantidad}\n\n` +
                                        `➤ Cantidad total: ${datosActualizados.cantidad + nuevaCantidad}\n` +
                                        `➤ Máximo permitido: ${cantidad.max}\n` +
                                        `No es posible agregar estas unidades al pedido.`
                                    );
                                }

                                else {
                                    datosActualizados.cantidad += nuevaCantidad;
                                    // Actualizar ambas fuentes de datos
                                    filaExistente.data(datosActualizados);

                                    // Actualizar el array original
                                    const indexOriginal = datos.findIndex(item => item.id === nuevoId);
                                    if (indexOriginal !== -1) {
                                        datos[indexOriginal].cantidad = datosActualizados.cantidad;
                                    }

                                    tabla.draw(false); // Redibujar manteniendo paginación/orden
                                    total += (Number(document.getElementById("precio").value)* nuevaCantidad);
                                    document.querySelectorAll("#formAgregarArticulo input").forEach(input => input.value = "");
                                    document.querySelectorAll("#formAgregarArticulo select").forEach(select => {
                                        select.selectedIndex = 0; // selecciona la primera opción
                                    });
                                }
                            }
                                ocultarMostrarTabla();
                                $('#costoTotalVenta').text(total)
                        }
                }
    }

    function ocultarMostrarTabla(){
            if (datos.length === 0) {
                document.getElementById('emptyState').classList.remove('d-none');
                document.getElementById('contenedorTabla').classList.add('d-none');
            }

            else {
                document.getElementById('emptyState').classList.add('d-none');
                document.getElementById('contenedorTabla').classList.remove('d-none');
            }
    }

    //REGISTRO DE UNA SALIDA POR ENTREGA DE UNIFORME 
    function validarSalida(){ 
          if(datos.length <1)
                alert('No se pueden realizar salidas sin artículos, favor de agregar por lo menos uno') 
        
          else 
            if(!isEmpleado)
                alert('El número de nómina no es valido');
        
         else
                descuentosModal.show(); 
    }


    function registrarSalida(){

        if(!(document.getElementById('cantidadDescuentos')).checkValidity())
                document.getElementById('cantidadDescuentos').reportValidity();

        else {
         //console.log(JSON.stringify(datos));
                //console.log(empleado.value);
                let formDataArt = new FormData;
                formDataArt.append('opcion', 4);
                formDataArt.append('tipoSalida', 2);
                formDataArt.append('idUsuario', 94); //CAMBIAR POR EL VALOR DE LA SESSION
                formDataArt.append('idEmpleado', empleado.value);
                formDataArt.append('articulosSalida',JSON.stringify(datos))
                formDataArt.append('pagoTotal', total)
                formDataArt.append('numDescuentos', Number($('#cantidadDescuentos').val()))
                formDataArt.append('tipoNomina', tipoNomina)

                //console.log('total:'+total+' Numero de descuentos'+Number($('#cantidadDescuentos').val())+'Tipo de nomina'+tipoNomina)

                //numDescuentos = $('#cantidadDescuentos').val();
                fetch("./api/salidas.php", {
                    method: "POST",
                    body: formDataArt,
                })
                    .then((response) => response.json())
                    .then((data) => {
                        alert(data.response)
                        datos= [];
                        empleado.value= '';
                        nombreEmpleado.textContent ="";
                        isEmpleado = false;
                        total = 0;
                        $('#costoTotalVenta').text(total);
                        actualizarVista();
                        ocultarMostrarTabla();
                        $('#cantidadDescuentos').val('')
                         descuentosModal.hide();
                        console.log(data)
                    })
                    .catch((error) => {
                        console.log(error);
                    })
        }
    }
actualizarVista();


/*FUNCIONES PARA LA VALIDACION Y CREACION DE LAS FIRMAS */
  /* Variables de Configuracion */
        var idCanvas = 'canvas';
        var idForm = 'formCanvas';
        var inputImagen = 'imagen';
        var estiloDelCursor = 'crosshair';
        var colorDelTrazo = '#000000';
        var colorDeFondo = '#ffffff';
        var grosorDelTrazo = 2;

        /* Variables necesarias */
        var contexto = null;
        var valX = 0;
        var valY = 0;
        var flag = false;
        var imagen = document.getElementById(inputImagen);
        //var anchoCanvas =document.getElementById(idCanvas).offsetWidth;
        //var altoCanvas = document.getElementById(idCanvas).offsetHeight;
        var pizarraCanvas = document.getElementById(idCanvas);
        IniciarDibujo();
        ajustarCanvas();

        /* Esperamos el evento load */
        window.addEventListener('load', IniciarDibujo, false);

        window.addEventListener('resize', () => {
            ajustarCanvas(pizarraCanvas);
        });


        function IniciarDibujo() {
            /* Creamos la pizarra */
            pizarraCanvas.style.cursor = estiloDelCursor;
            contexto = pizarraCanvas.getContext('2d');
            //contexto.fillStyle = colorDeFondo;
            //contexto.fillRect(0, 0, anchoCanvas, altoCanvas);
            contexto.strokeStyle = colorDelTrazo;
            contexto.lineWidth = grosorDelTrazo;
            contexto.lineJoin = 'round';
            contexto.lineCap = 'round';
            /* Capturamos los diferentes eventos */
            pizarraCanvas.addEventListener('mousedown', MouseDown, false); // Click pc
            pizarraCanvas.addEventListener('mouseup', MouseUp, false); // fin click pc
            pizarraCanvas.addEventListener('mousemove', MouseMove, false); // arrastrar pc

            pizarraCanvas.addEventListener('touchstart', TouchStart, false); // tocar pantalla tactil
            pizarraCanvas.addEventListener('touchmove', TouchMove, false); // arrastras pantalla tactil
            pizarraCanvas.addEventListener('touchend', TouchEnd, false); // fin tocar pantalla dentro de la pizarra
            pizarraCanvas.addEventListener('touchleave', TouchEnd, false); // fin tocar pantalla fuera de la pizarra
        }

        function MouseDown(e) {
            flag = true;
            contexto.beginPath();
            valX = e.pageX - posicionX(pizarraCanvas);
            valY = e.pageY - posicionY(pizarraCanvas);
            contexto.moveTo(valX, valY);
        }

        function MouseUp(e) {
            contexto.closePath();
            flag = false;
        }

        function MouseMove(e) {
            if (flag) {
                contexto.beginPath();
                contexto.moveTo(valX, valY);
                valX = e.pageX - posicionX(pizarraCanvas);
                valY = e.pageY - posicionY(pizarraCanvas);
                contexto.lineTo(valX, valY);
                contexto.closePath();
                contexto.stroke();
            }
        }

        function TouchMove(e) {
            e.preventDefault();
            if (e.targetTouches.length == 1) {
                var touch = e.targetTouches[0];
                MouseMove(touch);
            }
        }

        function TouchStart(e) {
            if (e.targetTouches.length == 1) {
                var touch = e.targetTouches[0];
                MouseDown(touch);
            }
        }

        function TouchEnd(e) {
            if (e.targetTouches.length == 1) {
                var touch = e.targetTouches[0];
                MouseUp(touch);
            }
        }

        function posicionY(obj) {
            var valor = obj.offsetTop;
            if (obj.offsetParent) valor += posicionY(obj.offsetParent);
            return valor;
        }

        function posicionX(obj) {
            var valor = obj.offsetLeft;
            if (obj.offsetParent) valor += posicionX(obj.offsetParent);
            return valor;
        }

        /* Limpiar pizarra */
        function LimpiarTrazado() {
            document.getElementById('preview').src = '';
            let estilo = getComputedStyle(canvas);
            let ancho = parseInt(estilo.width, 10);
            let alto = parseInt(estilo.height, 10);
            contexto = document.getElementById('canvas').getContext('2d');
            contexto.clearRect(0, 0, ancho, alto);

            //contexto.fillStyle = colorDeFondo;
            //contexto.fillRect(0, 0, anchoCanvas, altoCanvas);
        }

        /* Enviar el trazado */
        function GuardarTrazado() {
                const canvas = document.getElementById('canvas');

                 if (isCanvasEmpty(canvas)) {
                        alert("El canvas está vacío");
                    } 

                else {
                        alert("El canvas tiene contenido");
                    }

                const image = canvas.toDataURL('imagenes/png'); // También puedes usar 'image/jpeg'

                //SE TRANFORMA A BLOB LA IMAGEN GENERADA
                const imageBlob = dataURLtoBlob(image);
                
                const formData = new FormData();
                formData.append('image', imageBlob, 'firma.png'); // 'image' será la clave en PHP
                formData.append('opcion', 1);

                fetch('./api/salidas.php', { //CAMBIAR ESTA RUTA A LA CARPETA DE LAS FIRMAS
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(result => {
                    console.log('Respuesta del servidor:', result);
                })
                .catch(error => {
                    console.error('Error al enviar la imagen:', error);
                    document.getElementById('preview').src = '';
                });

             
                //Mostrar la imagen como vista previa
                document.getElementById('preview').src = image;

                // Opción: descargar la imagen automáticamente
                //const link = document.createElement('a');
                //link.download = 'firma.png';
                //link.href = image;
                //link.click(); 
              
        }

        //Funcion para tranformar a blob la imagen canvas y enviar como archivo en un fromData
        function dataURLtoBlob(dataURL) {
            const parts = dataURL.split(';base64,');
            const contentType = parts[0].split(':')[1];
            const byteCharacters = atob(parts[1]);
            const byteArrays = [];

            for (let i = 0; i < byteCharacters.length; i++) {
                byteArrays.push(byteCharacters.charCodeAt(i));
            }

            const byteArray = new Uint8Array(byteArrays);
            return new Blob([byteArray], { type: contentType });
        }

        //Función para verificar el llenado del canvas
        function isCanvasEmpty(canvas) {
            const ctx = canvas.getContext('2d');
            const pixels = ctx.getImageData(0, 0, canvas.width, canvas.height).data;

            for (let i = 0; i < pixels.length; i += 4) {
                if (pixels[i] !== 0 || pixels[i + 1] !== 0 || pixels[i + 2] !== 0 || pixels[i + 3] !== 0) {
                    return false;
                }
            }

            return true;
        }

        function ajustarCanvas(){
            let canvas = document.getElementById('canvas')
            const estilo = getComputedStyle(canvas);
            const ancho = parseInt(estilo.width, 10);
            const alto = parseInt(estilo.height, 10);

            // Establece el tamaño interno en píxeles reales
            canvas.width = ancho;
            canvas.height = alto;
        }

/*FIN DE LAS FUNCIONES PARA LA VALIDACION Y CREACION DE LAS FIRMAS*/