
var filtroBusqueda =  document.querySelectorAll(".filtroBusqueda");

filtroBusqueda.forEach(filtro => {
    filtro.addEventListener("change", filtrarPorBusqueda)
  });

        function renderTable() {
            var ancho = window.innerWidth;
    
            var formData = new FormData;
            formData.append("opcion", "1");
            formData.append('tipo', $("#tipo").val())
            formData.append('anio', $("#anio").val())
            formData.append('mes', $("#mes").val())
            formData.append('busquedaEmp', $("#busquedaEmp").val())
        
            fetch("./api/consultas.php", {
                    method: "POST",
                    body: formData,
                })
                .then((response) => response.json())
                .then((data) => {
                                    $('#tablaSalidas').DataTable().destroy(); //Restaurar la tablas
                    
                                    //Crear el dataTable con las nuevas configuraciones
                                    $('#tablaSalidas').DataTable({
                                        responsive: true,
                                        scrollX: (ancho - 50),
                                        scrollY: 280,
                                        scrollCollapse: true,
                                        data: data,
                                        columns: [
                                            { "data": "id_salida" },  
                                            { "data": "fecha" },
                                            { "data": "tipo_salida" },
                                            { "data": "realizado_por" },
                                            { "data": "empleado" }, 
                                            { "data": "acciones"}
                                        ], 
                                        columnDefs: [
                                            {
                                                targets: [0,1,2,3,4,5],
                                                className: 'text-center'
                                            },
                                        ],

                                        "drawCallback": function(settings) { //Captura el evento para cuando el datatable se redibuja, por ejemplo al cambiar de pagina
                                            let btnVer = document.querySelectorAll(".btnVer");
                                            let btnImprimir = document.querySelectorAll(".btnImprimir");

                                        //Evento para el bton de ver pedidos
                                        btnVer.forEach(boton => {
                                            boton.removeEventListener("click", abrirVerSalidaModal);
                                            boton.addEventListener("click", abrirVerSalidaModal);
                                          });

                                          //Evento para el boton de imprimir pedidos
                                          btnImprimir.forEach(boton => {
                                            boton.removeEventListener("click", imprimirPedido);
                                            boton.addEventListener("click", imprimirPedido);
                                          });

                                    }
                                    });
                })
                .catch((error) => {
                console.log(error);
    
                $('#tablaSalidas').DataTable().clear();
                $('#tablaSalidas').DataTable().destroy();
                $('#tablaSalidas').DataTable();
            });
        }

        // Función para abrir el modal de ver salida
        function abrirVerSalidaModal(event) {

            const boton = event.target.closest("button"); // Accede al atributo data-id del botón que disparó el evento
            var dataId = boton.getAttribute('data-id');

            document.getElementById('salidaId').textContent = dataId;
            //document.getElementById('salidaFecha').textContent = salida.fecha;
            //document.getElementById('salidaTipo').textContent = salida.tipo_salida;
            //document.getElementById('salidaRealizadoPor').textContent = salida.nombre_usuario;
            //document.getElementById('salidaEmpleado').textContent = salida.nombre_empleado;
            //document.getElementById('salidaVale').textContent = salida.vale;
            new bootstrap.Modal(document.getElementById('verSalidaModal')).show();
        }

        // Función para filtrar por búsqueda
        function filtrarPorBusqueda() {
            //const busqueda = document.getElementById('busquedaEmp').value.toLowerCase();
            //onst tbody = document.getElementById('tablaSalidas');
            //tbody.innerHTML = salidas .filter(s => s.nombre_empleado.toLowerCase().includes(busqueda)).map(salida => {}).join('');

            alert('se han aplicado los filtros');
        }

        function imprimirPedido(){
            alert("Imprimir registro");
        }

        // Renderizar la tabla al cargar la página
        renderTable();