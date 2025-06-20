    const generarPedidoBtn = document.getElementById("generarPedidoBtn");
    const confirmarPedidoBtn = document.getElementById("confirmarPedidoBtn");
    var seleccionadosGlobal = [];
    const checkPadre = document.getElementById("checkPadre");
    let datos;

        // Evento para abrir el modal de confirmación de generar pedido
        generarPedidoBtn.addEventListener("click", () => {
            const confirmModal = new bootstrap.Modal(document.getElementById("confirmModal"));
            confirmModal.show();

            const table = $('#tablaArticulos').DataTable();
            var allRows = table.rows().nodes();

            // Arreglo para guardar los datos filtrados
            var datosFiltrados = [];

            // Iterar sobre los nodos de las filas
            $(allRows).each(function (index, rowNode) {
                // Buscar el checkbox en la primera celda de la fila
                var checkbox = $(rowNode).find('td:eq(0) input[type="checkbox"]');

                const dataId = checkbox.data('id');

                if (seleccionadosGlobal.includes(dataId)) {
                    checkbox.prop('checked', true);
                } else {
                    checkbox.prop('checked', false);
                }

                // Si el checkbox está marcado, obtener los datos de esa fila
                if (checkbox.prop('checked')) {
                    var rowData = table.row(rowNode).data();
                    datosFiltrados.push(rowData);
                }
            });

            // Mostrar los datos filtrados
            console.log(datosFiltrados);
        });

    // Evento para confirmar la generación del pedido
    confirmarPedidoBtn.addEventListener("click", () => {
        // Lógica para generar el pedido
        alert("Pedido generado");
        const confirmModal = new bootstrap.Modal(document.getElementById("confirmModal"));
        confirmModal.hide();
    });

    checkPadre.addEventListener('change', function(){
        if (checkPadre.checked) {
                seleccionadosGlobal = datos
                $('#tablaArticulos input[type="checkbox"]').prop('checked', true);
                }

        else {
                seleccionadosGlobal = [];
                $('#tablaArticulos input[type="checkbox"]').prop('checked', false);
        }

    })

    // Delegación de eventos para checkboxes dinámicos
    $('#tablaArticulos tbody').on('change', 'input[type="checkbox"]', function() {
        const id = $(this).data('id');
        const index = seleccionadosGlobal.indexOf(id);
        
        //AGREGA EL ELEMENTO
        if(this.checked && index === -1) {
            seleccionadosGlobal.push(id);
        } 
        //ELIMINA EL ELEMENTO
        else if(!this.checked && index > -1) {
            seleccionadosGlobal.splice(index, 1);
        }

        checkPadre.checked = (seleccionadosGlobal <=0 ) ? false : true;
    });

    // Función para renderizar los artículos en la tabla
    function renderizarArticulos() {
        var ancho = window.innerWidth;

        var formData = new FormData;
        formData.append("opcion", "1");
    
        fetch("./api/entradas.php", {
                method: "POST",
                body: formData,
            })
            .then((response) => response.json())
            .then((data) => { 
                              datos = data.map(item => Number(item.id_articulo));
                              

                                $('#tablaArticulos').DataTable().destroy(); //Restaurar la tablas
                
                                //Crear el dataTable con las nuevas configuraciones
                                $('#tablaArticulos').DataTable({
                                    responsive: true,
                                    scrollX: (ancho - 50),
                                    scrollY: 350,
                                    scrollCollapse: true,
                                    data: data,
                                    pageLength: 100,
                                    columns: [
                                        { 
                                            "data": "check",
                                            "orderable": false
                                        },
                                        { "data": "id_articulo" },
                                        { "data": "cantidad" },
                                        { "data": "nombre" },
                                        { "data": "talla" },
                                        { "data": "genero" },
                                        { "data": "categoria" },
                                    ],
                                    columnDefs: [
                                        {
                                            targets: [0, 1, 2, 3, 4, 5, 6], // Actualizar índices de columnas
                                            className: 'text-center'
                                        },
                                    ],
                                     createdRow: function(row, data , dataIndex) {
                                            // Marcar checkbox si está en seleccionadosGlobal
                                             $(row).attr('data-id', dataIndex);
                                             const $checkbox = $('input[type="checkbox"]', row);
                                            const dataId = $checkbox.data('id');
                                            
                                            if(seleccionadosGlobal.includes(dataId)) {
                                                $checkbox.prop('checked', true);
                                            }

                                      
                                        //Se muestra en rojo el texto de la fila para identificar si el articulo ya ha sido cargado en algun otro pedido
                                        if(data.en_pedido == 1) 
                                            $(row).css('color', 'red'); // Cambia color del texto
                                           
                                        },
                                        /* Este es necesario para marcar los check sin generar el pedido*/
                                        /*Si no se usa se guardan los datos y se agregan al row pero no se dibujan por lo que aparecen como no marcados hasta que se genera el pedido*/
                                        drawCallback: function(settings) {
                                            // Recorre todas las filas visibles actualmente
                                            $('#tablaArticulos tbody tr').each(function () {
                                            const $row = $(this);
                                            const $checkbox = $row.find('input[type="checkbox"]');
                                            const dataId = $checkbox.data('id');

                                            if (seleccionadosGlobal.includes(dataId)) {
                                                $checkbox.prop('checked', true);
                                            } else {
                                                $checkbox.prop('checked', false);
                                            }
                                            });

                                        } 
                                });
                            })
                        .catch((error) => {
                            console.log(error);

                            $('#tablaArticulos').DataTable().clear();
                            $('#tablaArticulos').DataTable().destroy();
                            $('#tablaArticulos').DataTable();
                        });
    }

    // Función para obtener los ID seleccionados
    function obtenerSeleccionados() {
        return seleccionadosGlobal;
    }


    function setChek(){
         const table = $('#tablaArticulos').DataTable();
            table.rows().every(function() {
            var data = this.data();

            // Si ese ID está en los seleccionados globales
            if (seleccionadosGlobal.includes(data.id)) {
                data.check = true;
            } else {
                data.check = false;
            }

        });
    }

    // Renderizar los artículos y el número de pedido al cargar la página
    renderizarArticulos();