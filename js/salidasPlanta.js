        var empleado = document.getElementById('empleadoInput');
        var valeInput = document.getElementById('valeInput');
        var emptyState = document.getElementById('emptyState');
        var confirmarBtn = document.getElementById('confirmarBtn');
        var radioEntrega = document.getElementsByName('tipoEntrega');
        let datos = [];

        $("input[name='tipoEntrega']").change(function() {
            let valor = $("input[name='tipoEntrega']:checked").val(); //BECARIO OBSEQUIO

            if(valor == 0) 
                document.getElementById('empleadoInput').value= 'BECARIO';

            else 
                if( valor == 567) document.getElementById('empleadoInput').value= 'OBSEQUIO';
        });

    
    // Fuente de datos inicial
        var  btnAgregarArticulo = document.getElementById('btnAgregarArticulo');
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

    confirmarBtn.addEventListener('click', registrarSalida)

    eliminarBtn.addEventListener('click', function(){
        datos= []; 
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

    selectTalla.addEventListener('change', actualizarArticulo);
    selectGenero.addEventListener('change', actualizarArticulo);
    

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
                            fila.remove().draw();

                            // Luego de eliminar una fila o cuando lo necesites
                            datos = tabla.rows().data().toArray();
                            ocultarMostrarTabla();
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
                                    tipo: document.getElementById("tipo").value,
                                    cantidad: nuevaCantidad,
                                    precio: Number(document.getElementById("precio").value),
                                    boton: "<button class='btn btn-danger my-0 mx-1 btn-eliminar'><i class='fas fa-trash'></i></button>"
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

                                    document.querySelectorAll("input").forEach(input => input.value = "");
                                    document.querySelectorAll("select").forEach(select => {
                                        select.selectedIndex = 0; // selecciona la primera opción
                                    });
                                }
                            }
                                ocultarMostrarTabla();
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
    function registrarSalida(){ 
        //TIPO DE ENTRREGA
         let tipoEntrega = $("input[name='tipoEntrega']:checked").val(); //VECARIO OBSEQUIO
         console.log(tipoEntrega);
         datos;
    }

actualizarVista();


    /*
        function agregarArticulosVale(){
            await this.getValeInfo(this.vale);
            if (!this.vale_info) {
                this.vale = "";
                return this.$q.notify({ message: `<strong>El código del vale no existe o es incorrecto</strong>`, caption: "Hace un instante", type: "warning", html: true });
            }

            const categorias = this.vale_info.equipo;
            this.articulos = [];
            let generoValue = -1;
            let tallaValue = -1;

            for (const c of categorias) {
                await this.getCategoriaById(c.id_categoria);
                await this.getTallasXTipo(this.categoria.tipo_talla);
                await this.getGenerosByIdCategoria(c.id_categoria);

                let selTallas = JSON.parse(JSON.stringify(this.opt_tallas));
                if (selTallas.length == 1) tallaValue = selTallas[0].value;
                if (c.id_talla) tallaValue = c.id_talla;
                selTallas.unshift({ label: "-", value: -1 });

                let selGeneros = JSON.parse(JSON.stringify(this.opt_generos));
                if (selGeneros.length == 1) generoValue = selGeneros[0].value;
                selGeneros.unshift({ label: "-", value: -1 });

                let articuloTemp = { id_articulo: "-", cantidad: c.cantidad, nombre: this.categoria.abrev, categoria: this.categoria.categoria, id_categoria: c.id_categoria, tallas: selTallas, talla: tallaValue, generos: selGeneros, genero: generoValue };

                if (articuloTemp.talla == -1 || articuloTemp.genero == -1) {
                articuloTemp.id_articulo = "-";
                } else {
                await this.getArticuloByCatGenTalla({ categoria: articuloTemp.id_categoria, genero: articuloTemp.genero, talla: articuloTemp.talla, estado: 1 });
                articuloTemp.id_articulo = this.articulo.id_articulo;
                }

                this.articulos.push(articuloTemp);
                tallaValue = -1;
                generoValue = -1;
            }

            this.data = this.articulos;
            this.disabledInput = true;
            this.$q.notify({ message: `<strong>Se han cargado correctamente los artículos, seleccione el genero y las tallas correspondientes</strong>`, caption: "Hace un instante", type: "positive", html: true });
        }

        
        function agregar(){
                const categorias = vale_info.equipo;
                const articulos = [];
                let generoValue = -1;
                let tallaValue = -1;

            for (const c of categorias) {
                    const categoria = await getCategoriaById(c.id_categoria);
                    const optTallas = await getTallasXTipo(categoria.tipo_talla);
                    const optGeneros = await getGenerosByIdCategoria(c.id_categoria);

                    let selTallas = JSON.parse(JSON.stringify(optTallas));
                    if (selTallas.length === 1) tallaValue = selTallas[0].value;
                    if (c.id_talla) tallaValue = c.id_talla;
                    selTallas.unshift({ label: "-", value: -1 });

                    let selGeneros = JSON.parse(JSON.stringify(optGeneros));
                    if (selGeneros.length === 1) generoValue = selGeneros[0].value;
                    selGeneros.unshift({ label: "-", value: -1 });

                    let articuloTemp = {
                    id_articulo: "-",
                    cantidad: c.cantidad,
                    nombre: categoria.abrev,
                    categoria: categoria.categoria,
                    id_categoria: c.id_categoria,
                    tallas: selTallas,
                    talla: tallaValue,
                    generos: selGeneros,
                    genero: generoValue
                    };

                    if (articuloTemp.talla !== -1 && articuloTemp.genero !== -1) {
                        const articulo = await getArticuloByCatGenTalla({
                            categoria: articuloTemp.id_categoria,
                            genero: articuloTemp.genero,
                            talla: articuloTemp.talla,
                            estado: 1
                        });
                        articuloTemp.id_articulo = articulo?.id_articulo || "-";
                    }
            }

            articulos.push(articuloTemp);
            tallaValue = -1;
            generoValue = -1;
        }
*/