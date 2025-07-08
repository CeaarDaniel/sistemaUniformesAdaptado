    // Inicializar tooltips
    //const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    //tooltipTriggerList.map(t => new bootstrap.Tooltip(t));

    var datos;
     var tabla
    var datosActuales;
    var generarPedidoBtn= document.getElementById('generarPedidoBtn');
    var btnactualizartabla = document.getElementById('btnactualizartabla');
    const confirmModal = new bootstrap.Modal(document.getElementById("confirmModal"));
    btnactualizartabla.addEventListener('click', actualizarVista);
    
    generarPedidoBtn.addEventListener('click', generarPedido);

    function actualizarVista() {
                //var ancho = window.innerWidth;
                var formData = new FormData;
                formData.append("opcion", "2");
                formData.append('startDate',  document.getElementById('startDate').value);
                formData.append('endDate',  document.getElementById('endDate').value);

                //console.log(" startr"+ document.getElementById('startDate').value+ " end" +document.getElementById('endDate').value)
            
                fetch("./api/entradas.php", {
                        method: "POST",
                        body: formData,
                    })
                    .then((response) => response.json())
                    .then((data) => {
                            datos = data.map(item => item.id_articulo);
    
                            $('#tableBody').DataTable().destroy(); //Restaurar la tablas
                            //Crear el dataTable con las nuevas configuraciones
                             tabla = $('#tableBody').DataTable({
                                responsive: true,
                                scrollX: true,
                                scrollY: 340,
                                scrollCollapse: true,
                                data: data,
                                columns: [
                                    { "data": "id_articulo" },  
                                    { "data": "cantidad" },
                                    { "data": "costo", visible:false},
                                    { "data": "nombre" },
                                    { "data": "categoria" },
                                    { "data": "talla" }, 
                                    { "data": "genero" }, 
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

    function generarPedido() {
         datosActuales = tabla.rows().data().toArray();
       if(datosActuales.length <= 0) {
            alert('¡No se puede realizar un pedido sin artículos!'); 
            
            confirmModal.hide();  
       }

       else {
            var formData = new FormData;
            formData.append("opcion", "5"); 
            formData.append('articulosPedido',JSON.stringify(datosActuales))
        
            fetch("./api/entradas.php", {
                    method: "POST",
                    body: formData,
                })
                .then((response) => response.json())
                .then((data) => { 
                        alert(data.response)
                        location.reload();
                        confirmModal.hide();
                    })
                .catch((error) => {
                    console.log(error);
                    confirmModal.hide();
                }); 
            //const confirmModal = new bootstrap.Modal(document.getElementById("confirmModal"));
            //confirmModal.hide();
       }
    }

    actualizarVista();