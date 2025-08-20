        var empleado = document.getElementById('empleadoInput');
        var nombreEmpleado = document.getElementById('nombreEmpleado')
        var emptyState = document.getElementById('emptyState');
        let datos = []

    
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

        eliminarBtn.addEventListener('click', function(){
            datos= []; 
            empleado.value= '';
            nombreEmpleado.textContent ="";
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
                                    empleado.dataset.dataIdEmpleado = empleado.value
                                    nombreEmpleado.textContent = dataUs.nombreEmpleado;
                                }

                                else {
                                    empleado.dataset.dataIdEmpleado = false;
                                    nombreEmpleado.textContent = '';
                                }
                            })
                            .catch((error) => {
                                console.log(error);
                            })
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

                                        document.querySelectorAll("#formAgregarArticulo input").forEach(input => input.value = "");
                                        document.querySelectorAll("#formAgregarArticulo select").forEach(select => {
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

actualizarVista();
/*
    const state = {
        empleado: null,
        articulos: [],
        total: 0
    };

    document.getElementById('agregarArticuloBtn').addEventListener('click', agregarArticulo);
    document.getElementById('confirmarBtn').addEventListener('click', mostrarConfirmacion);
            document.getElementById('cancelarBtn').addEventListener('click', cancelarVenta);

        async function buscarEmpleado() {
            const numeroNomina = document.getElementById('empleadoInput').value;
            try {
                const response = await fetch(`/api/empleados/${numeroNomina}`);
                state.empleado = await response.json();
                actualizarVista();
            } catch (error) {
                mostrarAlerta('Error al buscar empleado', 'danger');
            }
        }

        function agregarArticulo() {
            const cantidad = parseInt(document.getElementById('cantidadInput').value);
            if (cantidad < 1) return mostrarAlerta('Cantidad inválida', 'warning');
            
            const nuevoArticulo = {
                id: Date.now(),
                nombre: 'Artículo de prueba',
                precio: 100,
                cantidad: cantidad,
                talla: 'M',
                categoria: 'Uniforme'
            };

            state.articulos.push(nuevoArticulo);
            actualizarVista();
        }

        function actualizarVista() {
            const tbody = document.getElementById('articulosBody');
            tbody.innerHTML = state.articulos.map(articulo => `
                <tr>
                    <td><i class="bi bi-x-circle cursor-pointer" onclick="eliminarArticulo(${articulo.id})"></i></td>
                    <td>${articulo.id}</td>
                    <td><img src="placeholder.jpg" alt="${articulo.nombre}" style="height: 70px;"></td>
                    <td>${articulo.nombre}</td>
                    <td>${articulo.categoria}</td>
                    <td>$${articulo.precio}</td>
                    <td>${articulo.talla}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-sm btn-primary" onclick="modificarCantidad(${articulo.id}, -1)">-</button>
                            <span class="mx-2">${articulo.cantidad}</span>
                            <button class="btn btn-sm btn-primary" onclick="modificarCantidad(${articulo.id}, 1)">+</button>
                        </div>
                    </td>
                </tr>
            `).join('');

            actualizarTotal();
            document.getElementById('emptyState').classList.toggle('d-none', state.articulos.length > 0);
        }

        function actualizarTotal() {
            state.total = state.articulos.reduce((acc, curr) => acc + (curr.precio * curr.cantidad), 0);
            document.getElementById('totalDisplay').textContent = `Total: $${state.total}`;
        }

        window.modificarCantidad = (id, cambio) => {
            const articulo = state.articulos.find(a => a.id === id);
            articulo.cantidad = Math.max(1, articulo.cantidad + cambio);
            actualizarVista();
        };

        window.eliminarArticulo = (id) => {
            state.articulos = state.articulos.filter(a => a.id !== id);
            actualizarVista();
        };

        function mostrarConfirmacion() {
            if (state.articulos.length === 0) return mostrarAlerta('Agrega artículos primero', 'warning');
            new bootstrap.Modal('#confirmarModal').show();
        }

        function cancelarVenta() {
            state.articulos = [];
            actualizarVista();
            mostrarAlerta('Venta cancelada', 'success');
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
    */