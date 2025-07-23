        var empleado = document.getElementById('empleadoInput');
        var valeInput = document.getElementById('valeInput');
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

actualizarVista();


/*
    const state = {
        empleado: null,
        articulos: [],
        tipoUniforme: null
    };


        // Event Listeners
        document.getElementById('buscarEmpleadoBtn').addEventListener('click', buscarEmpleado);
        document.getElementById('confirmarBtn').addEventListener('click', () => {
            new bootstrap.Modal('#confirmModal').show();
        });
        document.getElementById('confirmarRenovacionBtn').addEventListener('click', confirmarRenovacion);
        document.getElementById('cancelarBtn').addEventListener('click', cancelarOperacion);
        
        // Eventos para selección de tipo de uniforme
        document.querySelectorAll('.uniform-type-card').forEach(card => {
            card.addEventListener('click', function() {
                state.tipoUniforme = this.dataset.tipo;
                cargarArticulosPredefinidos();
                bootstrap.Modal.getInstance('#tipoUniformeModal').hide();
            });
        });


    async function buscarEmpleado() {
        const numeroEmpleado = document.getElementById('empleadoInput').value;
        if (!numeroEmpleado) return mostrarAlerta('Ingrese un número de empleado', 'warning');
        
        try {
            // Simular llamada a API
            state.empleado = { id: 1, nombre: 'Juan Pérez' };
            new bootstrap.Modal('#tipoUniformeModal').show();
        } catch (error) {
            mostrarAlerta('Error al buscar empleado', 'danger');
        }
    }

    function cargarArticulosPredefinidos() {
        const articulosBase = state.tipoUniforme === 'operario' ? 
            [
                { id: 1, nombre: 'Playera MC', categoria: 'Playeras', talla: 'M', genero: 'M', cantidad: 1 },
                { id: 2, nombre: 'Playera ML', categoria: 'Playeras', talla: 'M', genero: 'M', cantidad: 1 },
                { id: 3, nombre: 'Pantalón', categoria: 'Pantalones', talla: '32', genero: 'M', cantidad: 2 }
            ] :
            [
                { id: 4, nombre: 'Camisa MC', categoria: 'Camisas', talla: 'L', genero: 'H', cantidad: 1 },
                { id: 5, nombre: 'Camisa ML', categoria: 'Camisas', talla: 'L', genero: 'H', cantidad: 1 },
                { id: 6, nombre: 'Pantalón', categoria: 'Pantalones', talla: '34', genero: 'H', cantidad: 2 }
            ];

        state.articulos = articulosBase.map(art => ({
            ...art,
            generos: ['M', 'F'],
            tallas: ['S', 'M', 'L', 'XL']
        }));
        
        actualizarTabla();
    }

    function actualizarTabla() {
        const tbody = document.getElementById('articulosBody');
        tbody.innerHTML = state.articulos.map(articulo => `
            <tr>
                <td><button class="btn btn-danger btn-sm" onclick="eliminarArticulo(${articulo.id})"><i class="bi bi-trash"></i></button></td>
                <td>${articulo.id}</td>
                <td><img src="uniforme.jpg" class="article-img" alt="${articulo.nombre}"></td>
                <td>${articulo.nombre}</td>
                <td>
                    <select class="form-select" onchange="actualizarGenero(${articulo.id}, this.value)">
                        ${articulo.generos.map(g => `<option ${articulo.genero === g ? 'selected' : ''}>${g}</option>`).join('')}
                    </select>
                </td>
                <td>
                    <select class="form-select" onchange="actualizarTalla(${articulo.id}, this.value)">
                        ${articulo.tallas.map(t => `<option ${articulo.talla === t ? 'selected' : ''}>${t}</option>`).join('')}
                    </select>
                </td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-sm btn-primary" onclick="modificarCantidad(${articulo.id}, -1)">-</button>
                        <span>${articulo.cantidad}</span>
                        <button class="btn btn-sm btn-primary" onclick="modificarCantidad(${articulo.id}, 1)">+</button>
                    </div>
                </td>
            </tr>
        `).join('');

        document.getElementById('emptyState').style.display = 
            state.articulos.length > 0 ? 'none' : 'block';
    }

    // Funciones globales
    window.actualizarGenero = (id, genero) => {
        const articulo = state.articulos.find(a => a.id === id);
        articulo.genero = genero;
    };

    window.actualizarTalla = (id, talla) => {
        const articulo = state.articulos.find(a => a.id === id);
        articulo.talla = talla;
    };

    window.modificarCantidad = (id, cambio) => {
        const articulo = state.articulos.find(a => a.id === id);
        articulo.cantidad = Math.max(1, articulo.cantidad + cambio);
        actualizarTabla();
    };

    window.eliminarArticulo = (id) => {
        state.articulos = state.articulos.filter(a => a.id !== id);
        actualizarTabla();
    };

    async function confirmarRenovacion() {
        if (!validarFormulario()) return;
        
        try {
            // Simular envío a API
            const response = await fetch('/api/renovaciones', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    empleado: state.empleado,
                    articulos: state.articulos,
                    fecha: new Date().toISOString()
                })
            });

            if (response.ok) {
                mostrarAlerta('Renovación registrada exitosamente', 'success');
                resetearFormulario();
            }
        } catch (error) {
            mostrarAlerta('Error al registrar renovación', 'danger');
        }
    }

    function validarFormulario() {
        if (!state.empleado) {
            mostrarAlerta('Seleccione un empleado primero', 'warning');
            return false;
        }
        if (state.articulos.length === 0) {
            mostrarAlerta('Agregue al menos un artículo', 'warning');
            return false;
        }
        return true;
    }

    function resetearFormulario() {
        state.articulos = [];
        state.empleado = null;
        document.getElementById('empleadoInput').value = '';
        actualizarTabla();
    }

    function cancelarOperacion() {
        if (confirm('¿Está seguro de cancelar la operación?')) {
            resetearFormulario();
        }
    }

    function mostrarAlerta(mensaje, tipo) {
        const alerta = document.createElement('div');
        alerta.className = `alert alert-${tipo} alert-dismissible fade show`;
        alerta.innerHTML = `
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.prepend(alerta);
        setTimeout(() => alerta.remove(), 3000);
    } 
    */