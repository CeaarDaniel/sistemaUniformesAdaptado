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

        document.getElementById('cancelarPedidoModal').dataset.id = dataId;
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
        alert('Imprimr pedido: '+dataId);
    }

    // Renderizar la tabla al cargar la página
    renderTable();
