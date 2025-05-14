
    // Inicializar tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(t => new bootstrap.Tooltip(t));

    var datos;
    var generarPedidoBtn= document.getElementById('generarPedidoBtn');

    generarPedidoBtn.addEventListener('click', actualizarVista)

    // Funciones principales
    async function inicializar() {
        actualizarVista();
    }

    function actualizarVista() {
        var ancho = window.innerWidth;
                var formData = new FormData;
                formData.append("opcion", "2");
                formData.append('startDate',  document.getElementById('startDate').value);
                formData.append('endDate',  document.getElementById('endDate').value);

                console.log(" startr"+ document.getElementById('startDate').value+ " end" +document.getElementById('endDate').value)
            
                fetch("./api/entradas.php", {
                        method: "POST",
                        body: formData,
                    })
                    .then((response) => response.json())
                    .then((data) => {

                            datos = data.map(item => item.id_articulo);
                            console.log(datos)
                            $('#tableBody').DataTable().destroy(); //Restaurar la tablas
                            //Crear el dataTable con las nuevas configuraciones
                             var tabla = $('#tableBody').DataTable({
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

                                    var api = this.api();
                                     // Delegar evento a los botones de eliminar en la página actual
                                    api.rows({ page: 'current' }).nodes().each(function(row, index) {
                                        $(row).find('.btn-eliminar').off('click').on('click', function(e) {
                                            e.stopPropagation(); // evita que se dispare otro evento en la fila

                                            var fila = tabla.row($(this).closest('tr'));

                                            // Eliminar del arreglo datos
                                            var valbus= fila.data().id_articulo
                                            const index = datos.indexOf(valbus);
    

                                            //ELIMINA EL ELEMENTO
                                                if( index > -1) {
                                                datos.splice(index, 1);
                                            }

                                            fila.remove().draw(false);

                                            console.log(datos);

                                            // Luego de eliminar una fila o cuando lo necesites
                                                var datosActuales = tabla.rows().data().toArray();

                                                console.log("Datos actuales en el DataTable:", datosActuales);

                                        });
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



    async function generarPedido() {
        if (state.pedido.length === 0) {
            mostrarAlerta('¡No se puede realizar un pedido sin artículos!', 'danger');
            return;
        }
        
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


    inicializar();