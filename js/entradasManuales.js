
    // Fuente de datos inicial
        let datos = [];
        var  btnAgregarArticulo = document.getElementById('btnAgregarArticulo');
        var  eliminarBtn = document.getElementById('eliminarBtn');
        const table = $('#tablaArticulos').DataTable();

    btnAgregarArticulo.addEventListener('click', agregarArticulo)
    eliminarBtn.addEventListener('click', function(){
        datos= []; 
        actualizarVista();
    })
    

    function actualizarVista() {
        var ancho = window.innerWidth;

        $('#tablaArticulos').DataTable().destroy(); //Restaurar la tablas
        //Crear el dataTable con las nuevas configuraciones
        var tabla = $('#tablaArticulos').DataTable({
            responsive: true,
            scrollX: ancho-100,
            scrollY: 340,
            scrollCollapse: true,
            data: datos,
            columns: [
                { "data": "id" },
                { "data": "nombre" },
                { "data": "tipo" },
                { "data": "cantidad" },
                { "data": "precio" },
                { "data": "boton"}
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
                        var datosActuales = tabla.rows().data().toArray();
                    });
                });
            }
        });
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
            }
        }

actualizarVista();