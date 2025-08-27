        var empleado = document.getElementById('empleadoInput');
        var nombreEmpleado = document.getElementById('nombreEmpleado')
        const btnConfirmarVale = document.getElementById('btnConfirmarVale');
        var valeInput = document.getElementById('valeInput');
        var emptyState = document.getElementById('emptyState');
        var confirmarBtn = document.getElementById('confirmarBtn');
        var radioEntrega = document.getElementsByName('tipoEntrega');
        var talbaBarcodePRueba = document.getElementById('talbaBarcodePRueba');
        
        const valeModal = new bootstrap.Modal(document.getElementById("seleccionarValeArticuloModal"));
        
        let datos = [];

        $("input[name='tipoEntrega']").change(function() {
            let valor = $("input[name='tipoEntrega']:checked").val(); //BECARIO OBSEQUIO

            if(valor === '0') {
                empleado.value= 'BECARIO';
                nombreEmpleado.textContent ="";
                empleado.dataset.dataIdEmpleado = '0';
                empleado.disabled = true
            }

            else 
                if(valor == 567) { 
                    empleado.value= 'OBSEQUIO';
                    nombreEmpleado.textContent ="";
                    empleado.dataset.dataIdEmpleado = '567';
                    empleado.disabled = true;
                }

            else 
                if(valor ===''){
                    empleado.value= '';
                    nombreEmpleado.textContent ="";
                    empleado.dataset.dataIdEmpleado = '';
                    empleado.disabled = false;
                }
        });

        //OBTENER LOS GENEROS Y CATEGORIAS CORRESPONDIENTES AL BARCODE
        valeInput.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                    var formDataGet = new FormData;
                    formDataGet.append('opcion', 2);
                    formDataGet.append('barcode', this.value);

                    fetch("./api/salidas.php", {
                        method: "POST",
                        body: formDataGet,
                    })
                        .then((response) => response.json())
                        .then((data) => {
                                if(data.error)
                                        alert("El código del vale no existe o es incorrecto")

                                else {
                                cargarTabla(data.uniforme);
                                valeModal.show();
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                        })
            }
        });

        empleado.addEventListener('change', function(){
                if(!Number(empleado.value)) {
                    empleado.dataset.dataIdEmpleado = false;
                    nombreEmpleado.textContent ="";
                    //console.log('not num');
                }

                else { 
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
                }
        })

    
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
        empleado.disabled = false;
        empleado.value= '';
        empleado.dataset.dataIdEmpleado = '';
        valeInput.disabled = false
        valeInput.value = '';
        nombreEmpleado.textContent ="";
        $('input[type="radio"][name="tipoEntrega"][value=""]').prop('checked', true);
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
    btnConfirmarVale.addEventListener('click', agregarArticuloVale) 

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

                //onsole.log("Tallas: ", data.tallas);
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
                                    precio:  $('#genero option:selected').text(), //Number(document.getElementById("precio").value),
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
                                valeInput.disabled = true;
                                valeInput.value = '';
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
          if(datos.length <1)
                alert('No se pueden realizar salidas sin artículos, favor de agregar por lo menos uno') 
        
          else 
            if( (empleado.dataset.dataIdEmpleado !== '0' && empleado.dataset.dataIdEmpleado !== '567') 
                        && 
                (empleado.dataset.dataIdEmpleado == 'false' || empleado.dataset.dataIdEmpleado == false  ||  empleado.dataset.dataIdEmpleado == null))
                    { alert('El número de nómina no es valido') }
        else
            {
                console.log(JSON.stringify(datos));
                console.log(empleado.value);
                let formDataArt = new FormData;
                formDataArt.append('opcion', 4);
                formDataArt.append('tipoSalida', 1);
                formDataArt.append('idUsuario', 94); //CAMBIAR POR EL VALOR DE LA SESSION
                formDataArt.append('idEmpleado', 
                        (empleado.dataset.dataIdEmpleado == 0 || empleado.dataset.dataIdEmpleado == 567) 
                                    ? empleado.dataset.dataIdEmpleado : empleado.value);
                formDataArt.append('nota', document.getElementById('nota').value);
                formDataArt.append('vale', (valeInput.value).toUpperCase()); 
                formDataArt.append('articulosSalida',JSON.stringify(datos))

                fetch("./api/salidas.php", {
                    method: "POST",
                    body: formDataArt,
                })
                    .then((response) => response.json())
                    .then((data) => {
                        alert(data.response)
                         console.log(data)
                          datos= []; 
                            actualizarVista();
                            ocultarMostrarTabla();
                            empleado.disabled = false;
                            empleado.value= '';
                            empleado.dataset.dataIdEmpleado = '';
                            valeInput.disabled = false
                            valeInput.value = '';
                            nombreEmpleado.textContent ="";
                            $('input[type="radio"][name="tipoEntrega"][value=""]').prop('checked', true);
                    })
                    .catch((error) => {
                        console.log(error);
                    })
        }

        //console.log('Valor de dataID:'+empleado.dataset.dataIdEmpleado+' Tipo de dato: '+ typeof(empleado.dataset.dataIdEmpleado));
    }

    //FUNCION PARA CARGAR LOS DATOS DE LA TABLA DE VALES
    function cargarTabla(data) {
            const tbody = document.querySelector('#talbaBarcodePrueba tbody');
            tbody.innerHTML = '';

            data.forEach(item => {
                const row = document.createElement('tr');

                 var formDataGet = new FormData;
                    formDataGet.append('opcion', 3);
                    formDataGet.append('categoria', item.id_categoria);

                    fetch("./api/entradas.php", {
                        method: "POST",
                        body: formDataGet,
                    })
                    .then((response) => response.json())
                    .then((catGen) => {

                        //BOTON DE REOMOVE
                         const  tdRemove= document.createElement('td');
                            let btnRemove = document.createElement('button');
                                btnRemove.classList.add('btnRemove', 'btn');
                                btnRemove.style.color = 'rgb(193, 0, 21)';
                                btnRemove.innerHTML = '<i class="fas fa-trash"></i>';
                                tdRemove.appendChild(btnRemove);

                        //COLUMNA ID
                            let idArticulo = document.createElement('td');
                                 idArticulo.classList.add('idArticulo');
                                 idArticulo.textContent = ''

                        //LABEL CATEGORIA
                            const labelCategoria = document.createElement('td');
                                labelCategoria.classList.add('labelCategoria')
                                labelCategoria.dataset.idCategoria = item.id_categoria;
                                labelCategoria.textContent =  catGen.categoria.abrev;
                     
                        //SELECT DE GENERO
                            const tdGenero = document.createElement('td');
                            tdGenero.classList.add('mx-2')
                            const selectGenero = document.createElement('select');
                            selectGenero.classList.add('selectGenero', 'form-select', 'text-center');
                            //selectCategoria.classList.add('categoria-select');
                            //selectCategoria.dataset.id = item.id;

                            const option = document.createElement('option');
                            option.value = '';
                            option.textContent = ' Genero ';
                            selectGenero.appendChild(option);

                            catGen.generos.forEach(genero => {
                                    const option = document.createElement('option');
                                    option.value = genero.id_genero;
                                    option.textContent = genero.genero;
                                    selectGenero.appendChild(option);
                                })

                            tdGenero.appendChild(selectGenero);

                        //SELECT DE TALLA
                            const tdTalla = document.createElement('td');
                            tdTalla.classList.add('mr-2', 'ml-2')
                            const selectTalla = document.createElement('select');
                            selectTalla.classList.add('selectTalla', 'form-select', 'text-center');

                            const optionTalla = document.createElement('option');
                            optionTalla.value = '';
                            optionTalla.textContent = ' Talla ';
                            selectTalla.appendChild(optionTalla);

                            catGen.tallas.forEach(talla => {
                                    const optionTalla = document.createElement('option');
                                    optionTalla.value = talla.id_talla;
                                    optionTalla.textContent = talla.talla;

                                    (item.id_talla == talla.id_talla) ? optionTalla.selected = true : null;
                                    selectTalla.appendChild(optionTalla);
                                })

                            tdTalla.appendChild(selectTalla)
                            
                        
                        //INPUT CANTIDAD
                            const tdCantidad = document.createElement('td');
                            tdCantidad.classList.add('mx-2')
                            const inputCantidad = document.createElement('input');
                            inputCantidad.classList.add('inputCantidad', 'form-control', 'text-center');
                            inputCantidad.style.maxWidth = '150px'
                            inputCantidad.type= 'number'
                            inputCantidad.min = '1';
                            inputCantidad.max = '2';
                            inputCantidad.disabled = true;

                            //inputCantidad.classList.add('genero-select');
                            //inputCantidad.dataset.id = item.id;

                            inputCantidad.value = item.cantidad
                            tdCantidad.appendChild(inputCantidad);

                        // Ensamblar fila
                            row.appendChild(tdRemove)
                            row.appendChild(idArticulo)
                            row.appendChild(labelCategoria);
                            row.appendChild(tdGenero);
                            row.appendChild(tdTalla);
                            row.appendChild(tdCantidad);

                            tbody.appendChild(row);

                        selectGenero.addEventListener('change', getArticuloVale)
                        selectTalla.addEventListener('change', getArticuloVale)
                        inputCantidad.addEventListener('change', validarCantidad)
                        btnRemove.addEventListener('click', eliminarFila)

                    })
                    .catch((error) => {
                        console.log(error);
                    })
            });
    }

    //OBTENER DATOS DE UN ARTICULO PARA LA TABLA DE VALES
    function getArticuloVale(event){
            const fila = event.target.closest('tr');
            const categoria = fila.querySelector('.labelCategoria').dataset.idCategoria
            const genero = fila.querySelector('.selectGenero').value;
            const talla = fila.querySelector('.selectTalla').value;
            let inputCantidad = fila.querySelector('.inputCantidad')
            
             let formDataVale = new FormData;
                formDataVale.append('opcion', 4);
                formDataVale.append('categoria', categoria);
                formDataVale.append('genero', genero);
                formDataVale.append('talla',talla);
                //cantidad.value ="" 
                    fetch("./api/entradas.php", {
                        method: "POST",
                        body: formDataVale,
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            if(data.articulo == null) {
                                fila.cells[1].textContent = ''
                                inputCantidad.disabled = true
                                fila.cells[1].dataset.idArticuloModal = ''; 
                            }

                            else {
                                fila.cells[1].textContent = data.articulo.nombre;
                                fila.cells[1].dataset.idArticuloModal = data.articulo.id_articulo; 
                                inputCantidad.max = data.articulo.cantidad;
                                inputCantidad.disabled = false
                            }
                            
                            validarCantidad(event);
                    })
            .catch((error) => {
                console.log(error);
            }) 
    }

    function validarCantidad(event){
        const fila = event.target.closest('tr');
        let inputCantidad = fila.querySelector('.inputCantidad')

            if (inputCantidad.max > inputCantidad.min && inputCantidad.checkValidity()) {
                // Buscar el elemento hermano siguiente (el div que contiene el mensaje de error) y eliminarlo si existe
                var mensajeError = inputCantidad.nextElementSibling;
                if (mensajeError) {
                    mensajeError.remove();
                    inputCantidad.classList.remove('invalido');
                }
            }

        else
            if(!inputCantidad.classList.contains('invalido')){
                inputCantidad.classList.add('invalido');
                var mensajeError = document.createElement('div');
                mensajeError.innerHTML = "<p class='text-danger m-0 p-0' style='font-size:12px'><b>*STOCK INSUFICIENTE</b></p>";
                inputCantidad.insertAdjacentElement("afterend", mensajeError)
            }

        //console.log(inputCantidad.validationMessage);
    }

    function eliminarFila(event){
        const fila = event.target.closest('tr');
        $(fila).remove();

        const filas = document.querySelectorAll('#talbaBarcodePrueba tbody tr');

        if(filas.length <= 0)  
            valeModal.hide();
    }

    function agregarArticuloVale(){
        let invalido = document.querySelectorAll('.invalido')
        let articulos = document.querySelectorAll('.idArticulo')

        let articulosCont = Array.from(articulos).every(label => {
            return label.textContent.trim() !== '';
        });


        if(invalido.length > 0 || !articulosCont || articulos.length<1) 
            alert('Debe completar los campos correctamente para poder agregar el articulo');


        else {
            const filas = document.querySelectorAll('#talbaBarcodePrueba tbody tr');

            filas.forEach(fila => {
                let artNuevo = {
                    id: Number(fila.cells[1].dataset.idArticuloModal),
                    nombre: fila.querySelector('.idArticulo').textContent,
                    tipo: fila.querySelector('.labelCategoria').textContent,
                    cantidad: Number(fila.querySelector('.inputCantidad').value),
                    precio: fila.querySelector('.selectGenero').options[fila.querySelector('.selectGenero').selectedIndex].text,
                    boton: "<button class='btn btn-danger my-0 mx-1 btn-eliminar'><i class='fas fa-trash'></i></button>"
                };
                
                datos.push(artNuevo);
                const tabla = $('#tablaArticulos').DataTable();
                tabla.row.add(artNuevo).draw(false);
                ocultarMostrarTabla();
                 valeModal.hide();
                 valeInput.disabled = true
                //tabla.draw(false)
            });
        }
    }

    actualizarVista();