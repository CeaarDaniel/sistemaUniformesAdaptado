  var  btnactualizartabla = document.getElementById('btnactualizartabla');
  var categoriaCat = document.getElementById('categoriaCat');
  var estado = document.getElementById('estado');
  var generoCat = document.getElementById('generoCat');
  var btnImprimirAlmacen = document.getElementById('btnImprimirAlmacen');
  var impresionInventario = document.getElementById('impresionInventario');
  var btnEditarArticulo = document.getElementById('btnEditarArticulo');

  const tabla= $('#tablaArticulos').DataTable();

  categoriaCat.addEventListener('change', renderTable)
  estado.addEventListener('change', renderTable)
  generoCat.addEventListener('change', renderTable)
  btnImprimirAlmacen.addEventListener('click', imprimirTabla);

  //Funcion para actualizar los campos modificados
  btnEditarArticulo.addEventListener('click', function() {
     let formEditarArticulo = document.getElementById('formEditarArticulo');

    if (formEditarArticulo && formEditarArticulo.reportValidity()){
        var formData = new FormData(formEditarArticulo);
        formData.append("opcion", 4);
        fetch("./api/almacen.php", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                alert(data.response)
            })
            .catch((error) => {
                console.log(error);
            });
    }
    
  })
  if (btnactualizartabla) btnactualizartabla.addEventListener('click', refresh)

    // Funciones de manejo de eventos
    function handleEditarClick(event) {
        event.preventDefault();
        abrirEdicionModal(event);
    }

    function handleEliminarClick(event) {
        event.preventDefault();
        eliminarArticulo(event);
    }
    
    // Función para renderizar la tabla
    function renderTable() {
        var ancho = window.innerWidth;

        var formData = new FormData;
        formData.append("opcion", "1");
        formData.append('categoriaCat', categoriaCat.value)
        formData.append('estado', estado.value)
        formData.append('generoCat', generoCat.value)
    
        fetch("./api/almacen.php", {
                method: "POST",
                body: formData,
            })
            .then((response) => response.json())
            .then((data) => {
                                $('#tablaArticulos').DataTable().destroy(); //Restaurar la tablas
                
                                //Crear el dataTable con las nuevas configuraciones
                                $('#tablaArticulos').DataTable({
                                    responsive: true,
                                    scrollX: (ancho - 50),
                                    scrollY: 280,
                                    scrollCollapse: true,
                                    data: data,
                                    columns: [
                                        { "data": "id_articulo" },  
                                        { "data": "nombre" },
                                        { "data": "talla" },
                                        { "data": "genero" },
                                        { "data": "cantFisica" }, 
                                        { "data": "cantTran" }, 
                                        { "data": "total" }, 
                                        { "data": "costo" }, 
                                        { "data": "precio" },
                                        { "data": "stock_max" },
                                        { "data": "stock_min" },
                                        { "data": "acciones" }
                                    ], 
                                    columnDefs: [
                                        {
                                            targets: [0,1,2,3,4,5,6,7,8,9,10,11],
                                            className: 'text-center'
                                        }
                                    ],
                                    layout: {
                                        topEnd: {
                                            buttons: [{
                                                //Botón para Excel
                                                extend: 'excel',
                                                title: 'Reporte de Inventario',
                                                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]}, // Excluye la última columna (la de los botones)
                                                filename: 'Reporte de Inventario',
                                                //Aquí es donde generas el botón personalizado
                                                text: `<button class="btn btn-success" style="background-color: #1b5e20">
                                                            <i class="fas fa-file-excel"></i> Exportar Excel
                                                        </button>`,
                                                className: 'unset' //ELIMINAMOS TODO LOS ESTILOS POR DEFECTO
                                            },
                                        ]
                                        }
                                    }, 
                                    "drawCallback": function(settings) { //Captura el evento para cuando el datatable se redibuja, por ejemplo al cambiar de pagina
                                        let botonesEditar = document.querySelectorAll(".btn-editar");
                                        let botonesEliminar = document.querySelectorAll(".btn-eliminar");

                                        botonesEliminar.forEach(boton => {
                                            boton.removeEventListener("click", handleEliminarClick);
                                            boton.addEventListener("click", handleEliminarClick);
                                          });

                                        botonesEditar.forEach(botonEdit => {
                                            botonEdit.removeEventListener("click", handleEditarClick);
                                            botonEdit.addEventListener("click", handleEditarClick);
                                        });
                                    },
                                });
            })
            .catch((error) => {
            console.log(error);

            $('#tablaArticulos').DataTable().clear();
            $('#tablaArticulos').DataTable().destroy();
            $('#tablaArticulos').DataTable();
        });
    }

    // Función para abrir el modal de edición
    function abrirEdicionModal(event) {
        const boton = event.target.closest("button"); // Accede al atributo data-id del botón que disparó el evento
        var dataId = boton.getAttribute('data-id');
        var myModal = new bootstrap.Modal(document.getElementById('modalModificar'));
        var formDataArticulos = new FormData;

        formDataArticulos.append("opcion", "2");
        formDataArticulos.append("id_articulo", dataId);
    
        fetch("./api/almacen.php", {
                method: "POST",
                body: formDataArticulos,
            })
            .then((response) => response.json())
            .then((data) => {
                document.getElementById('modalModificarArticulo').innerHTML = `<form id="formEditarArticulo" class="my-0">
                                                                                    <div class="row">
                                                                                        <!-- Columna 1 -->
                                                                                        <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
                                                                                            <!-- Nombre -->
                                                                                            <div class="mb-3">
                                                                                                <label for="nombre" class="form-label">Nombre</label>
                                                                                                <input type="text" class="form-control" id="nombre" name="nombre" value="${data.nombre}" readonly style="background-color:#3f51b521">
                                                                                                <small id="nombreHelpText" class="form-text text-muted ms-3">El nombre no se puede modificar</small>
                                                                                            </div>

                                                                                            <!-- Categoría -->
                                                                                            <div class="mb-3">
                                                                                                <label for="categoria" class="form-label">Categoría</label>
                                                                                                <input class="form-select" id="categoria" name="categoria" value="${data.categoria}" readonly style="background-color:#3f51b521; max-width:300px;">
                                                                                                <small id="nombreHelpText" class="form-text text-muted ms-3">La categoría no se puede modificar</small>
                                                                                            </div>

                                                                                            <!-- Talla -->
                                                                                            <div class="mb-3">
                                                                                                <label for="talla" class="form-label">Talla</label>
                                                                                                <input class="form-select" id="talla" name="talla" value="${data.talla}" readonly style="background-color:#3f51b521">
                                                                                                <small id="nombreHelpText" class="form-text text-muted ms-3">La talla no se puede modificar</small>
                                                                                            </div>

                                                                                            <!-- Género -->
                                                                                            <div class="mb-3">
                                                                                                <label for="genero" class="form-label">Género</label>
                                                                                                <input class="form-select" id="genero" name="genero" value="${data.genero}" readonly style="background-color:#3f51b521">
                                                                                                <small id="nombreHelpText" class="form-text text-muted ms-3">El género no se puede modificar</small>
                                                                                            </div>
                                                                                        </div>

                                                                                        <!-- Columna 2 -->
                                                                                        <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
                                                                                            <!-- Descripción -->
                                                                                            <div class="mb-3">
                                                                                                <label for="descripcion" class="form-label">Descripción</label>
                                                                                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" maxlength=500>${data.descripcion}</textarea>
                                                                                            </div>

                                                                                            <!-- Costo -->
                                                                                            <div class="mb-3">
                                                                                                <label for="costo" class="form-label">Costo</label>
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-text">$</span>
                                                                                                    <input min=0 type="number" class="form-control" id="costo" name="costo" step="0.01" min="0" max="100000" value="${data.costo}">
                                                                                                </div>
                                                                                            </div>

                                                                                            <!-- Precio -->
                                                                                            <div class="mb-3">
                                                                                                <label for="precio" class="form-label">Precio</label>
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-text">$</span>
                                                                                                    <input min=0 type="number" class="form-control" id="precio" name="precio" step="0.01" min="0" max="100000" value="${data.precio}">
                                                                                                </div>
                                                                                            </div>

                                                                                            <!-- Stock Máximo -->
                                                                                            <div class="mb-3">
                                                                                                <label for="stock_max" class="form-label">Stock máximo</label>
                                                                                                <div class="input-group">
                                                                                                    <input min=0 type="number" class="form-control" id="stock_max" name="stock_max" step="1" min="0" max="100000" value="${data.stock_max}">
                                                                                                    <span class="input-group-text">pzas</span>
                                                                                                </div>
                                                                                            </div>

                                                                                            <!-- Stock Mínimo -->
                                                                                            <div class="mb-3">
                                                                                                <label for="stock_min" class="form-label">Stock mínimo</label>
                                                                                                <div class="input-group">
                                                                                                    <input min=0 type="number" class="form-control" id="stock_min" name="stock_min" step="1" min="0" max="100000" value="${data.stock_min}">
                                                                                                    <span class="input-group-text">pzas</span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <input type="hidden" id="id_articulo" name="id_articulo"  value="${data.id_articulo}">
                                                                                    </div>
                                                                                </form>`;
                    myModal.show();
            })
            .catch((error) => {
            console.log(error);
        });
    }

    // Función para eliminar un artículo
    function eliminarArticulo(event) {
        const boton = event.target.closest("button"); // Accede al atributo data-id del botón que disparó el evento
        var idArt = boton.getAttribute('data-id');
        const respuesta = confirm(`¿Estás seguro de que deseas eliminar este artículo ${idArt}`);

        if(respuesta){
            var formData = new FormData();
            formData.append("opcion", 5);
            formData.append("id_articulo", idArt)
            fetch("./api/almacen.php", {
                method: "POST",
                body: formData,
            })
                .then((response) => response.json())
                .then((data) => {
                    alert(data.response)
                    renderTable();
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }

    function refresh(){
        renderTable();
        alert('Se ha actualizado la tabla')
    }

    function imprimirTabla(){
        var formData = new FormData;
        formData.append("opcion", "1");
        formData.append('categoriaCat', categoriaCat.value)
        formData.append('estado', estado.value)
        formData.append('generoCat', generoCat.value)
    
        fetch("./api/almacen.php", {
                method: "POST",
                body: formData,
            })
            .then((response) => response.json())
            .then((data) => {
                let tabla= ``;
                console.log(data);

                data.forEach((dato) => {
                    tabla = tabla + `<tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> ${dato.id_articulo}</td>
                                        <td class="py-1 my-1"> ${dato.nombre}</td>
                                        <td class="py-1 my-1"> ${dato.cantFisica}</td>
                                        <td class="py-1 my-1">$ ${dato.costo}</td>
                                        <td class="py-1 my-1">$ ${dato.precio}</td>
                                    </tr>` 
                });

                    impresionInventario.innerHTML = `<!-- Detalles de la salida -->
                                                        <div class="mx-5 d-flex justify-content-between">
                                                            <img src="./imagenes/beyonz.jpg" style="max: width 150px; max-height:50px;">
                                                        </div>

                                                        <p class="text-center" style="font-size:20px;"><b> Reporte de Inventario </b></p>

                                                        <p class="text-start mb-0" style="font-size:15px"> <b>Categoría:</b> ${ $('#categoriaCat option:selected').text() }</p>
                                                         <hr class="mt-0 mb-1" 
                                                             style="height: 5px; background: linear-gradient(90deg,rgba(9, 11, 122, 1) 33%, rgba(133, 133, 133, 1) 0%); opacity: 1; border:none;">
                                                                    

                                                        <p class="text-center m-0 p-0" style="font-size:16px;"><b>ARTÍCULOS</b></p>
                                                         <table class="table mt-1" style="font-size:12px;">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Clave</th>
                                                                    <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Nombre</th>
                                                                    <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Cantidad</th>
                                                                    <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Costo uni.</th>
                                                                    <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Precio</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody style="font-size:12px">
                                                                ${tabla}
                                                            </tbody>
                                                        </table>`;
                    const opt = {
                        margin: [8, 13, 10, 13], // márgenes: [top, right, bottom, left]
                        filename: 'salida_'+2357+'_entrega de uniforme por vale.pdf',
                        image: { 
                            type: 'jpeg', 
                            quality: 0.98
                        },
                        html2canvas: { 
                            scale: 3, // Escala óptima para calidad y rendimiento
                            useCORS: true,
                            letterRendering: true,
                            logging: false
                        },
                        jsPDF: { 
                            unit: 'mm', 
                            format: 'letter', 
                            orientation: 'portrait' 
                        },
                        // Configuración avanzada para saltos de página
                        pagebreak: { 
                            mode: ['avoid-all', 'css'], 
                            before: '.page-break-before',
                            avoid: '.page-break-avoid'
                        }
                    };

                    // Generar PDF y abrir en nueva pestaña
                    html2pdf().set(opt).from(impresionInventario).outputPdf('blob')
                        .then(function(blob) {
                            const blobUrl = URL.createObjectURL(blob);
                            window.open(blobUrl, '_blank');
                            //impresionDetalleSalida.innerHTML= '';
                        })
                        .catch(function(error) {
                            console.log(error)
                        });
            })
            .catch((error) => {
            console.log(error);
        });
    }

    // Renderizar la tabla al cargar la página
renderTable();