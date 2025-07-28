var anio = document.getElementById('anio');
var mes = document.getElementById('mes');
var estatus = document.getElementById('status');

anio.addEventListener('change', renderTable)
mes.addEventListener('change', renderTable)
estatus.addEventListener('change', renderTable)
// Función para renderizar la tabla
    function renderTable() {
        var ancho = window.innerWidth;

        var formData = new FormData;
        formData.append("opcion", "1");
        formData.append('anio', anio.value)
        formData.append('mes', mes.value)
        formData.append('status', estatus.value)
    
        fetch("./api/pedidos.php", {
                method: "POST",
                body: formData,
            })
            .then((response) => response.json())
            .then((data) => {
                                $('#tablaPedidos').DataTable().destroy(); //Restaurar la tablas
                
                                //Crear el dataTable con las nuevas configuraciones
                                $('#tablaPedidos').DataTable({
                                    responsive: true,
                                    scrollX: (ancho - 50),
                                    scrollY: 350,
                                    scrollCollapse: true,
                                    data: data,
                                    columns: [
                                        { "data": "id_pedido" },  
                                        { "data": "num_pedido" },
                                        { "data": "fecha_creacion" },
                                        { "data": "pedido_estado" },
                                        { "data": "nombre" }, 
                                        { "data": "acciones" }, 
                                    ], 
                                    columnDefs: [
                                        {
                                            targets: 2,  // Indica el índice de la columna (por ejemplo, la primera columna)
                                            render: function(dato, type, row) {
                                                if (type === 'display' || type === 'filter') {

                                                  let fechaHora = dato;
                                                  let partes = fechaHora.split(" "); // Divide la cadena en fecha y hora
                                                  let fecha = partes[0]; // Obtiene la parte de la fecha
                                                  let hora = partes[1].split(":").slice(0, 2).join(":"); // Obtiene la parte de la hora sin segundos y milisegundos
                                                  return fecha+' '+hora;  // Formato DD/MM/YYYY HH:mm
                                              }
                                              return dato;  // Si no es para mostrar, devuelve la fecha tal cual
                                                  
                                                //return data;  // Si no es 'display', devuelve los datos tal cual
                                            } 
                                        },
                                        {
                                            targets : [0,1,3,,4,5],
                                            className: 'text-center'
                                        }
                                    ], 
                                    "drawCallback": function(settings) { //Captura el evento para cuando el datatable se redibuja, por ejemplo al cambiar de pagina
                                        let btnVer = document.querySelectorAll(".btnVer");
                                        let btnImprimir = document.querySelectorAll(".btnImprimir");
                                        let btnConcretar = document.querySelectorAll(".btnConcretar");
                                        let btnCancelar = document.querySelectorAll(".btnCancelar"); 
                                        let btnConfirmar = document.querySelectorAll(".btnConfirmar"); 

                                        //Evento para el bton de ver pedidos
                                        btnVer.forEach(boton => {
                                            boton.removeEventListener("click", abrirVerPedidoModal);
                                            boton.addEventListener("click", abrirVerPedidoModal);
                                          });

                                          //Evento para el boton de imprimir pedidos
                                          btnImprimir.forEach(boton => {
                                            boton.removeEventListener("click", imprimirPedido);
                                            boton.addEventListener("click", imprimirPedido);
                                          });

                                        //Evento para el boton de Concretar pedidos
                                        btnConcretar.forEach(boton => {
                                            boton.removeEventListener("click", abrirConcretarPedidoModal);
                                            boton.addEventListener("click", abrirConcretarPedidoModal);
                                          });

                                        //Evento para el boton de Cancelar pedidos
                                        btnCancelar.forEach(boton => {
                                            boton.removeEventListener("click", abrirCancelarPedidoModal);
                                            boton.addEventListener("click", abrirCancelarPedidoModal);
                                          });

                                        //Evento para imprimir el pedido cuando aun esta en transito
                                        btnConfirmar.forEach(boton => {
                                            boton.removeEventListener("click", imprimirPedido);
                                            boton.addEventListener("click", imprimirPedido);
                                          });
                                    }
                                });
            })
            .catch((error) => {
            console.log(error);

            $('#tablaPedidos').DataTable().clear();
            $('#tablaPedidos').DataTable().destroy();
            $('#tablaPedidos').DataTable();
        });
        /*
        ${pedido.pedido_estado === "Pendiente" ? `
                        <button class="btn btn-danger btn-action" onclick="abrirCancelarPedidoModal(${pedido.id_pedido})">
                            <i class="fas fa-times"></i>
                        </button>
                    ` : ''}
                    ${pedido.pedido_estado === "En proceso" ? `
                        <button class="btn btn-success btn-action" onclick="abrirConcretarPedidoModal(${pedido.id_pedido})">
                            <i class="fas fa-check"></i>
                        </button>
                    ` : ''}
        */
    }

    // Función para abrir el modal de ver pedido
    function abrirVerPedidoModal(event) {
        const boton = event.target.closest("button"); // Accede al atributo data-id del botón que disparó el evento
        var dataId = boton.getAttribute('data-id');
        var numPedido = boton.getAttribute('data-numPedido');
        var fechaCreacion = boton.getAttribute('data-fechaCreacion'); 
        var estado = boton.getAttribute('data-estado'); 
        var nombre = boton.getAttribute('data-nombre'); //quien lo realizo
        let totalPedido= 0;

        var formData = new FormData;
        formData.append("opcion", "2");
        formData.append("id_pedido", dataId);

        //Creacion de la tabla del modal
        fetch("./api/pedidos.php", {
            method: "POST",
            body: formData,
        })
        .then((response) => response.json())
        .then((data) => {
                //MOSTRAR EL VALOR DE LA FECHA EN FORMATO DE 12 hr
                document.getElementById('modalVerfechaCreacion').textContent= (new Date (fechaCreacion)).toLocaleString('es-ES', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true  // Usar el formato de 24 horas
                }).replace(',', '');
                document.getElementById('modalVerNombre').textContent= nombre;
                document.getElementById('modalVerEstado').textContent= estado;
                document.getElementById('modalVernumPedido').textContent = numPedido;
                let t= document.getElementById('tbodyDetallePedido');

                t.innerHTML = '';

                // Iterar sobre los datos y crear una fila para cada artículo
                data.forEach(dato => {
                    const fila = document.createElement("tr");
                    
                    //var costo = parseFloat(parseFloat(dato.costo).toFixed(2));
                    //var costoFormateado = costo.toLocaleString('en-US');
                    fila.innerHTML =
                    `<td>${dato.clave}</td>
                     <td>${dato.Articulo}</td>
                     <td>${dato.Cantidad}</td>
                     <td>$ ${(parseFloat(dato.costo)).toFixed(2)}</td>
                     <td>$ ${(parseFloat(dato.total)).toFixed(2)}</td>`;
                     t.appendChild(fila);

                     totalPedido = totalPedido +  parseFloat(dato.total);
                  }); 

                  document.getElementById('totalCostoPedido').textContent = `       $ ${ parseFloat(totalPedido.toFixed(2)).toLocaleString('en-US') }`;
                  new bootstrap.Modal(document.getElementById('verPedidoModal')).show();
    })
        .catch((error) => {
        console.log(error);
    });
    }

    // Función para abrir el modal de cancelar pedido
    function abrirCancelarPedidoModal(event) {
        const boton = event.target.closest("button"); // Accede al atributo data-id del botón que disparó el evento
        var dataId = boton.getAttribute('data-id');

        //document.getElementById('cancelarPedidoModal').dataset.id = dataId;
        new bootstrap.Modal(document.getElementById('cancelarPedidoModal')).show();
    }

    // Función para abrir el modal de concretar pedido
    function abrirConcretarPedidoModal(event) {
        const boton = event.target.closest("button"); // Accede al atributo data-id del botón que disparó el evento
        var dataId = boton.getAttribute('data-id');  
        document.getElementById('concretarPedidoModal').dataset.id = dataId;
        new bootstrap.Modal(document.getElementById('concretarPedidoModal')).show();
    }

    // Función para buscar pedidos
    function buscarPedidos() {
        const busqueda = document.getElementById('busqueda').value;
        alert(`Buscar pedidos con: ${busqueda}`);
        renderTable();
    }

    function imprimirPedido(event){
         const boton = event.target.closest("button"); // Accede al atributo data-id del botón que disparó el evento
        var dataId = boton.getAttribute('data-id');
        var numPedido = boton.getAttribute('data-numPedido');
        var fechaCreacion = boton.getAttribute('data-fechaCreacion'); 
        var estado = boton.getAttribute('data-estado'); 
        var nombre = boton.getAttribute('data-nombre'); //quien lo realizo
        var status = boton.getAttribute('data-status'); 
        let totalPedido= 0;

        var formData = new FormData;
        formData.append("opcion", "2");
        formData.append("id_pedido", dataId);

        //EL PEDIDO PASA A ESTAR EN TRANSITO AL IMPRIMIRLO 
        if(status && status == 1) {
             var formDataUpdate = new FormData();
             formDataUpdate.append('id_pedido', dataId)
             formDataUpdate.append('status', 2)
             formDataUpdate.append("opcion", 3);
        
             fetch("./api/pedidos.php", {
                method: "POST",
                body: formDataUpdate,
             }).then((response) => response.json())
                .then((dataU) => {
                        if(dataU.modificado) 
                                console.log("OK")
                        else 
                            console.log(dataU)
                })
                .catch((error) => {
                    console.log(error);
                });
        }

        //Creacion de la tabla del modal
        fetch("./api/pedidos.php", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                //MOSTRAR EL VALOR DE LA FECHA EN FORMATO DE 12 hr
                let fechaP = (new Date(fechaCreacion)).toLocaleString('es-ES', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true  // Usar el formato de 24 horas
                }).replace(',', '');

                let tabla = ``;

                // Iterar sobre los datos y crear una fila para cada artículo
                data.forEach(dato => {
                    tabla = tabla +
                        `<tr class="page-break-avoid">
                                <td class="my-1 page-break-avoid">${dato.clave}</td>
                                <td class="my-1 page-break-avoid">${dato.Cantidad}</td>
                                <td class="my-1 page-break-avoid">${dato.Articulo}</td>
                                <td class="my-1 page-break-avoid">$ ${(parseFloat(dato.costo)).toFixed(2)}</td>
                                <td class="my-1 page-break-avoid">$ ${(parseFloat(dato.total)).toFixed(2)}</td> 
                            </tr>`;
                    totalPedido = totalPedido + parseFloat(dato.total);
                });

                `       $ ${parseFloat(totalPedido.toFixed(2)).toLocaleString('en-US')}`;


                impresionInventario.innerHTML = `<!-- Detalles de pedido -->
                                                        <p class="text-center" style="font-size:17px; page-break-avoid"><b> PEDIDO - UNIFORMES </b></p>
                                                        
                                                        <div class="mx-5 d-flex justify-content-between page-break-avoid">
                                                            <img src="./imagenes/beyonz.jpg" style="max: width 150px; max-height:50px;">
                                                            <table class="page-break-avoid">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-center p-0 border-top border-start border-end border-dark" style="width:100%"><b>&nbsp; NUM SALIDA&nbsp;</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-center p-0 border border-dark" style="width:100%"> ${numPedido}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                         <!-- Detalles del pedido -->
                                                        <div class="row mt-5 page-break-avoid ">
                                                            <div class="my-0 col-4"><b>Fecha de elaboración:</b></div>
                                                            <div class="my-0 col-auto"><label class="mx-0 px-0 text-uppercase"> ${fechaP}</label></div>
                                                        </div>

                                                        <div class="row my-0 page-break-avoid">
                                                            <div class="my-0 col-4"><b>Realizado por:</b></div>
                                                            <div class="my-0 col-auto"><label>${nombre}</label></div>
                                                        </div>

                                                       <div class="row my-0 page-break-avoid">
                                                            <div class="my-0 col-4"><b>Estado:</b></div>
                                                            <div class="my-0 col-auto"><label> ${estado}</label></div>
                                                        </div>

                                            <hr class="mt-0 mb-1" style="height: 5px; background: linear-gradient(90deg,rgba(9, 11, 122, 1) 33%, rgba(133, 133, 133, 1) 0%); opacity: 1; border:none;">
                                                                    

                                                        <p class="page-break-avoid text-center my-4" style="font-size:16px;"><b>ARTÍCULOS</b></p>
                                                         <table class="page-break-avoid table mt-1" style="font-size:12px;">
                                                            <thead class="page-break-avoid">
                                                                <tr>
                                                                    <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Clave</th>
                                                                    <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Cantidad</th>
                                                                    <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Artículo</th>
                                                                    <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Precio unitario</th>
                                                                    <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="page-break-avoid" style="font-size:12px">
                                                                ${tabla}
                                                            </tbody>
                                                        </table>`;

                const opt = {
                    margin: [8, 13, 10, 13], // márgenes: [top, right, bottom, left]
                    filename: 'salida_' + 2357 + '_entrega de uniforme por vale.pdf',
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
                    .then(function (blob) {
                        const blobUrl = URL.createObjectURL(blob);
                        window.open(blobUrl, '_blank');
                        //impresionDetalleSalida.innerHTML= '';
                    })
                    .catch(function (error) {
                        console.log(error)
                    });

            }).catch((error) => {
                console.log(error);
            });
    }


    function cancelarPedido() {
        var formDataUpdate = new FormData();
        formDataUpdate.append('id_pedido', dataId)
        formDataUpdate.append('status', 3)
        formDataUpdate.append("opcion", 3);

        fetch("./api/pedidos.php", {
            method: "POST",
            body: formDataUpdate,
        }).then((response) => response.json())
            .then((dataU) => {
                if (dataU.modificado)
                    console.log("OK")
                else
                    console.log(dataU)
            })
            .catch((error) => {
                console.log(error);
            });
    }

    // Renderizar la tabla al cargar la página
    renderTable();