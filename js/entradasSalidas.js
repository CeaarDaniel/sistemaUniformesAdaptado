
    // Inicializar tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(t => new bootstrap.Tooltip(t));
    
    let state = {
        fecha: {
            from: new Date().toISOString().split('T')[0],
            to: new Date().toISOString().split('T')[0]
        },
        entradaConsecutivo: '',
        pedido: []
    };

    // Elementos del DOM
    const elementos = {
        numPedido: document.getElementById('numPedido'),
        fechaDesde: document.getElementById('fechaDesde'),
        fechaHasta: document.getElementById('fechaHasta'),
        confirmModal: new bootstrap.Modal('#confirmModal'),
        generarPedidoBtn: document.getElementById('generarPedidoBtn')
    };

    // Event Listeners
    elementos.fechaDesde.addEventListener('change', actualizarFecha);
    elementos.fechaHasta.addEventListener('change', actualizarFecha);
    elementos.generarPedidoBtn.addEventListener('click', () => elementos.confirmModal.show());
    document.getElementById('confirmarBtn').addEventListener('click', generarPedido);

    // Funciones principales
    async function inicializar() {
        actualizarVista();
    }

    async function buscarArticulos() {
        // Simular llamada a la API
        state.pedido = [
            { id_articulo: 1, cantidad: 5, nombre: 'Camisa', abrev: 'CAM', talla: 'M' }
        ]; // Reemplazar con datos reales
    }

    function eliminarArticulo(id) {
        state.pedido = state.pedido.filter(item => item.id_articulo !== id);
        actualizarVista();
    }

    function actualizarVista() {
        var ancho = window.innerWidth;
                var formData = new FormData;
                formData.append("opcion", "2");
            
                fetch("./api/entradas.php", {
                        method: "POST",
                        body: formData,
                    })
                    .then((response) => response.json())
                    .then((data) => {
                            $('#tableBody').DataTable().destroy(); //Restaurar la tablas
                            //Crear el dataTable con las nuevas configuraciones
                            $('#tableBody').DataTable({
                                responsive: true,
                                scrollX: (380),
                                scrollY: 340,
                                scrollCollapse: true,
                                data: data,
                                columns: [
                                    { "data": "id_articulo" },  
                                    { "data": "cantidad" },
                                    { "data": "boton" },
                                ], 
                                "render": function(data, type, row) {
    return `<button class="btn-eliminar" data-id="${row.id_articulo}">Eliminar</button>`;
},
                                columnDefs: [
                                    {
                                        targets: [0,1,2],
                                        className: 'text-center'
                                    },
                                ],
                                "drawCallback": function(settings) {
                                    // Delegación de eventos para mejor performance
                                    $('#tableBody').on('click', '.btn-eliminar', function() {
                                        eliminarRegistro(this);
                                    });
                                }
                            });
        })
        .catch((error) => {
        console.log(error);

        $('#tableBody').DataTable().clear();
        $('#tableBody').DataTable().destroy();
        $('#tableBody').DataTable();
    });
}

function eliminarRegistro(boton) {
    const table = $('#tableBody').DataTable();
    const row = $(boton).closest('tr');
    const rowData = table.row(row).data();
    
    // Eliminar de DataTable y del array de datos
    table.row(row).remove();
    
    // Actualizar el array original
    const index = data.findIndex(item => item.id_articulo === rowData.id_articulo);
    if (index !== -1) {
        data.splice(index, 1);
    }
    
    table.draw(); // Redibujar tabla
}



    async function generarPedido() {
        if (state.pedido.length === 0) {
            mostrarAlerta('¡No se puede realizar un pedido sin artículos!', 'danger');
            return;
        }
        
        // Simular envío a la API
        console.log('Pedido generado:', state.pedido);
        elementos.confirmModal.hide();
        mostrarAlerta('Pedido generado correctamente!', 'success');
        window.location.href = '/uniformes/entradas';
    }

    function mostrarAlerta(mensaje, tipo) {
        const alerta = document.createElement('div');
        alerta.className = `alert alert-${tipo} alert-dismissible fade show fixed-top m-3`;
        alerta.innerHTML = `
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.prepend(alerta);
    }

    function actualizarFecha() {
        state.fecha.from = elementos.fechaDesde.value;
        state.fecha.to = elementos.fechaHasta.value;
        buscarArticulos();
        actualizarVista();
    }

    // Inicializar
    elementos.fechaDesde.value = state.fecha.from;
    elementos.fechaHasta.value = state.fecha.to;
    inicializar();