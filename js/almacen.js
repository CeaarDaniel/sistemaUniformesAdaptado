  var  btnactualizartabla = document.getElementById('btnactualizartabla');
  var categoriaCat = document.getElementById('categoriaCat');
  var estado = document.getElementById('estado');
  var generoCat = document.getElementById('generoCat');

  const tabla= $('#tablaArticulos').DataTable();

  categoriaCat.addEventListener('change', renderTable)
  estado.addEventListener('change', renderTable)
  generoCat.addEventListener('change', renderTable)

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
                                                filename: 'Reporte de Inventario',
                                                //Aquí es donde generas el botón personalizado
                                                text: `<button class="btn btn-success" style="background-color: #1b5e20">
                                                            <i class="fas fa-file-excel"></i> Exportar Excel
                                                        </button>`,
                                                className: 'unset' //ELIMINAMOS TODO LOS ESTILOS POR DEFECTO
                                            }, 
                                            {
                                                extend: 'pdf',
                                                className: 'unset',
                                                text: '<button class="btn btn-danger" style="color: white;" ><i class="fas fa-file-pdf"></i> Exportar PDF</button>',
                                                title: 'Reporte de Inventario',
                                                filename: 'Reporte de Inventario',
                                                customize: function(doc) {
                                                    doc.content[1].margin = [0, 10, 0, 10]; // Márgenes del contenido
                                                }
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
                                                                                                <input type="text" class="form-control" id="nombre" value="${data.nombre}" readonly style="background-color:#3f51b521">
                                                                                                <small id="nombreHelpText" class="form-text text-muted ms-3">El nombre no se puede modificar</small>
                                                                                            </div>

                                                                                            <!-- Categoría -->
                                                                                            <div class="mb-3">
                                                                                                <label for="categoria" class="form-label">Categoría</label>
                                                                                                <input class="form-select" id="categoria" value="${data.categoria}" readonly style="background-color:#3f51b521; max-width:300px;">
                                                                                                <small id="nombreHelpText" class="form-text text-muted ms-3">La categoría no se puede modificar</small>
                                                                                            </div>

                                                                                            <!-- Talla -->
                                                                                            <div class="mb-3">
                                                                                                <label for="talla" class="form-label">Talla</label>
                                                                                                <input class="form-select" id="talla" value="${data.talla}" readonly style="background-color:#3f51b521">
                                                                                                <small id="nombreHelpText" class="form-text text-muted ms-3">La talla no se puede modificar</small>
                                                                                            </div>

                                                                                            <!-- Género -->
                                                                                            <div class="mb-3">
                                                                                                <label for="genero" class="form-label">Género</label>
                                                                                                <input class="form-select" id="genero" value="${data.genero}" readonly style="background-color:#3f51b521">
                                                                                                <small id="nombreHelpText" class="form-text text-muted ms-3">El género no se puede modificar</small>
                                                                                            </div>
                                                                                        </div>

                                                                                        <!-- Columna 2 -->
                                                                                        <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
                                                                                            <!-- Descripción -->
                                                                                            <div class="mb-3">
                                                                                                <label for="descripcion" class="form-label">Descripción</label>
                                                                                                <textarea class="form-control" id="descripcion" rows="3" maxlength=500>${data.descripcion}</textarea>
                                                                                            </div>

                                                                                            <!-- Costo -->
                                                                                            <div class="mb-3">
                                                                                                <label for="costo" class="form-label">Costo</label>
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-text">$</span>
                                                                                                    <input min=0 type="number" class="form-control" id="costo" step="0.01" min="0" max="100000" value="${data.costo}">
                                                                                                </div>
                                                                                            </div>

                                                                                            <!-- Precio -->
                                                                                            <div class="mb-3">
                                                                                                <label for="precio" class="form-label">Precio</label>
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-text">$</span>
                                                                                                    <input min=0 type="number" class="form-control" id="precio" step="0.01" min="0" max="100000" value="${data.precio}">
                                                                                                </div>
                                                                                            </div>

                                                                                            <!-- Stock Máximo -->
                                                                                            <div class="mb-3">
                                                                                                <label for="stock_max" class="form-label">Stock máximo</label>
                                                                                                <div class="input-group">
                                                                                                    <input min=0 type="number" class="form-control" id="stock_max" step="1" min="0" max="100000" value="${data.stock_max}">
                                                                                                    <span class="input-group-text">pzas</span>
                                                                                                </div>
                                                                                            </div>

                                                                                            <!-- Stock Mínimo -->
                                                                                            <div class="mb-3">
                                                                                                <label for="stock_min" class="form-label">Stock mínimo</label>
                                                                                                <div class="input-group">
                                                                                                    <input min=0 type="number" class="form-control" id="stock_min" step="1" min="0" max="100000" value="${data.stock_max}">
                                                                                                    <span class="input-group-text">pzas</span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
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
        const respuesta = confirm(`¿Estás seguro de que deseas eliminar artículo con ID: ${idArt}`);
    }

    function refresh(){
        renderTable();
        alert('Se ha actualizado la tabla')
    }

    // Renderizar la tabla al cargar la página
renderTable();
