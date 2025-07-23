
    // Fuente de datos inicial
        let datos = [];
        var tabla;
        var  btnAgregarArticulo = document.getElementById('btnAgregarArticulo');
        var  eliminarBtn = document.getElementById('eliminarBtn');
        var categoria = document.getElementById('tipo') //Select de Categoria
        var selectTalla = document.getElementById('talla');
        var selectGenero = document.getElementById('genero'); 
        var idArticulo = document.getElementById('id');
        var nombre = document.getElementById('nombre');
        var precio = document.getElementById('precio');
        var cantidad = document.getElementById('cantidadArt');
        var generarPedidoBtn = document.getElementById('generarPedidoBtn');
        const confirmModal = new bootstrap.Modal(document.getElementById("confirmarEntradaModal"));

       // const table = $('#tablaArticulos').DataTable();

    btnAgregarArticulo.addEventListener('click', agregarArticulo)

    eliminarBtn.addEventListener('click', function(){
        datos= []; 
        actualizarVista();
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

    selectTalla.addEventListener('change', actualizarArticulo);
    selectGenero.addEventListener('change', actualizarArticulo);
    generarPedidoBtn.addEventListener('click', generarPedido)
    

    function actualizarVista() {
        var ancho = window.innerWidth;

        $('#tablaArticulos').DataTable().destroy();
        //Crear el dataTable con las nuevas configuraciones
            tabla = $('#tablaArticulos').DataTable({
            responsive: true,
            scrollX: ancho-100,
            scrollY: 340,
            scrollCollapse: true,
            data: datos,
            columns: [
                { "data": "id" },
                { "data": "nombre" },
                { "data": "talla" },
                { "data": "genero" },
                { "data": "cantidad" },
                { "data": "costo" },
                { "data": "boton"},
                { "data": "id_articulo", visible:false}
            ], 
            columnDefs :  [ 
                {
                    targets: [0,1,2,3,4,5],
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
                        fila.remove().draw();

                        // Luego de eliminar una fila o cuando lo necesites
                        //var datosActuales = tabla.rows().data().toArray();
                    });
                });
            }
        });
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

                //console.log("Tallas: ", data.tallas);
                //console.log("Generos: ", data.generos);

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

                if(data.articulo === null) {
                    $('#btnAgregarArticulo').prop('disabled', true);
                    //console.log(data.articulo)
                    $('#nombre').val('')
                    $('#nombre').attr('placeholder', 'Artículo no valido');
                }
                else {
                    btnAgregarArticulo.disabled= false
                    nombre.value = data.articulo.nombre;
                    precio.value= data.articulo.costo;
                    //cantidad.max = data.articulo.cantidad;
                    cantidad.min = 1;
                    $('#id').val(data.articulo.id_articulo);
                }

            })
            .catch((error) => {
                console.log(error);
            })
    }


    //Problema al ingresar id con 0 y al reordenar la pagina
    /*
        function agregarArticulo() {
            var tabla = $('#tablaArticulos').DataTable();
            var nuevoId = Number(document.getElementById("id").value);
            var nuevaCantidad = Number(document.getElementById("cantidadArt").value);

            // Obtener todos los datos de la tabla como objetos
            var filas = tabla.rows().data().toArray();
            var indice = filas.findIndex(function (fila) {
                return fila.id === nuevoId;
            });

            console.log("indice"+ indice)

            if(indice < 0) {
                // No existe, lo agregamos como nuevo
                var nuevoArticulo = {
                    id: Number(document.getElementById("id").value),
                    nombre: document.getElementById("nombre").value,
                    tipo: document.getElementById("tipo").value,
                    cantidad: Number(document.getElementById("cantidadArt").value),
                    precio: Number(document.getElementById("precio").value),
                    boton: "<button class='btn btn-danger my-0 mx-1 btn-eliminar'><i class='fas fa-trash'></i></button>"
                };

                datos.push(nuevoArticulo);
                tabla.row.add(nuevoArticulo).draw(false); //.draw(false) Redibuja la tabla manteniendo la página actual (muy útil en tablas paginadas).
                document.querySelectorAll("input").forEach(input => input.value = "");

                console.log("Entro "+ nuevoArticulo);
            }

            else {
                // Obtener la fila completa
                var datosFila = tabla.row(indice).data();

                console.log("No entro indice: "+indice)

                // Modificar solo el valor deseado

                console.log("Cantidad actual"+ datosFila.cantidad)
                console.log("Cantidad agregada"+ nuevaCantidad)
                datosFila.cantidad = parseInt(datosFila.cantidad) + nuevaCantidad ;

                // Aplicar los nuevos datos a la fila
                tabla.row(indice).data(datosFila).draw(false);
            }

            console.log('indice 2',indice)
            console.log("Filas actuales:",tabla.rows().data().toArray())
            console.log("Filas anteriores: ",filas)
            console.log("Fila modificada ",  tabla.rows(indice).data().toArray());
            } 
    */

    function agregarArticulo() {
        var fmamantenimiento = document.getElementById("formAgregarArticulo");
        var isValidfm = fmamantenimiento.reportValidity();
                if (isValidfm) {
                    //if(cantidad.max <= 0)
                        //alert('No hay suficientes unidades para este artículo')

                    //else
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
                                    tipo: document.getElementById("tipo").value,
                                    cantidad: nuevaCantidad,
                                    costo: Number(document.getElementById("precio").value),
                                    talla: $('#talla option:selected').text(),
                                    genero: $('#genero option:selected').text(),
                                    boton: "<button class='btn btn-danger my-0 mx-1 btn-eliminar'><i class='fas fa-trash'></i></button>",
                                    id_articulo: nuevoId
                                };

                                datos.push(nuevoArticulo);
                                tabla.row.add(nuevoArticulo).draw(false);
                                document.querySelectorAll("input").forEach(input => input.value = "");
                                document.querySelectorAll("select").forEach(select => {
                                    select.selectedIndex = 0; // selecciona la primera opción
                                });
                            } else {
                                // Actualizar cantidad en fila existente
                                const datosActualizados = filaExistente.data();
                                    datosActualizados.cantidad += nuevaCantidad;
                                    // Actualizar ambas fuentes de datos
                                    filaExistente.data(datosActualizados);

                                    // Actualizar el array original
                                    const indexOriginal = datos.findIndex(item => item.id === nuevoId);
                                    if (indexOriginal !== -1) {
                                        datos[indexOriginal].cantidad = datosActualizados.cantidad;
                                    }

                                    tabla.draw(false); // Redibujar manteniendo paginación/orden

                                    document.querySelectorAll("input").forEach(input => input.value = "");
                                    document.querySelectorAll("select").forEach(select => {
                                        select.selectedIndex = 0; // selecciona la primera opción
                                    });
                            }
                        }
                }
    }

    function generarPedido(){
        articulosPedido = tabla.rows().data().toArray();
        if(articulosPedido.length <= 0) {
                alert('¡No se puede realizar un pedido sin artículos!'); 
                confirmModal.hide();  
        }

        else { //console.log(articulosPedido) 
                var formData = new FormData;
                formData.append("opcion", "5"); 
                formData.append('articulosPedido',JSON.stringify(articulosPedido))
                fetch("./api/entradas.php", {
                        method: "POST",
                        body: formData,
                    })
                    .then((response) => response.json())
                    .then((data) => { 
                            console.log(data)
                            alert(data.response)
                            confirmModal.hide();
                            location.reload();
                        })
                    .catch((error) => {
                        console.log(error);
                        confirmModal.hide();
                    });
                //const confirmModal = new bootstrap.Modal(document.getElementById("confirmModal"));
                //confirmModal.hide();
        }
    }

actualizarVista();