var año = document.getElementById('anio');
var mes = document.getElementById('mes');
var estatus = document.getElementById('status');

año.addEventListener('change', renderTable)
mes.addEventListener('change', renderTable)
estatus.addEventListener('change', renderTable)
// Función para renderizar la tabla
    function renderTable() {
        var ancho = window.innerWidth;

        var formData = new FormData;
        formData.append("opcion", "1");
        formData.append('anio', año.value)
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

                                        //Evento para el bton de ver pedidos
                                        btnVer.forEach(boton => {
                                            boton.removeEventListener("click", abrirVerPedidoModal);
                                            boton.addEventListener("click", abrirVerPedidoModal);
                                          });

                                          //Evento para el boton de imprimir pedidos
                                          btnImprimir.forEach(boton => {
                                            boton.removeEventListener("click", abrirVerPedidoModal);
                                            boton.addEventListener("click", abrirVerPedidoModal);
                                          });

                                          //Evento para el bton de canvelar pedido
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
        document.getElementById('pedidoId').textContent = dataId;
        document.getElementById('pedidoNum').textContent = dataId;
        document.getElementById('pedidoFecha').textContent = dataId;
        document.getElementById('pedidoEstado').textContent = dataId;
        document.getElementById('pedidoRealizadoPor').textContent = dataId;
        new bootstrap.Modal(document.getElementById('verPedidoModal')).show();
    }

    // Función para abrir el modal de cancelar pedido
    function abrirCancelarPedidoModal(event) {
        const boton = event.target.closest("button"); // Accede al atributo data-id del botón que disparó el evento
        var dataId = boton.getAttribute('data-id');

        document.getElementById('cancelarPedidoModal').dataset.id = dataId;
        new bootstrap.Modal(document.getElementById('cancelarPedidoModal')).show();
    }

    // Función para cancelar un pedido
    function cancelarPedido() {
        const id = document.getElementById('cancelarPedidoModal').dataset.id;
        alert(`Cancelar pedido con ID: ${id}`);
        new bootstrap.Modal(document.getElementById('cancelarPedidoModal')).hide();
    }

    // Función para abrir el modal de concretar pedido
    function abrirConcretarPedidoModal(id) {
        document.getElementById('concretarPedidoModal').dataset.id = id;
        new bootstrap.Modal(document.getElementById('concretarPedidoModal')).show();
    }

    // Función para concretar un pedido
    function concretarPedido() {
        const id = document.getElementById('concretarPedidoModal').dataset.id;
        alert(`Concretar pedido con ID: ${id}`);
        new bootstrap.Modal(document.getElementById('concretarPedidoModal')).hide();
    }

    // Función para aplicar filtros

    // Función para buscar pedidos
    function buscarPedidos() {
        const busqueda = document.getElementById('busqueda').value;
        alert(`Buscar pedidos con: ${busqueda}`);
        renderTable();
    }

    // Renderizar la tabla al cargar la página
    renderTable();
