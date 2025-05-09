
var filtroBusqueda =  document.querySelectorAll(".filtroBusqueda");

filtroBusqueda.forEach(filtro => {
    filtro.addEventListener("change", renderTable)
  });

        function renderTable() {
            var ancho = window.innerWidth;
            var formData = new FormData;
            formData.append("opcion", "1");
            formData.append('tipo', $("#tipo").val())
            formData.append('anio', $("#anio").val())
            formData.append('mes', $("#mes").val())
            formData.append('busquedaEmp', $("#busquedaEmp").val())

            formData.append("opcion", "1");
        
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
            var Id = boton.getAttribute('data-id');
            var salidaTipo = boton.getAttribute('data-salidaTipo');
            var salidaFecha = boton.getAttribute('data-salidaFecha');
            var salidaRealizadoPor = boton.getAttribute('data-salidaRealizadoPor');
            var salidaEmpleado = boton.getAttribute('data-salidaEmpleado');
            var total= 0;

            document.getElementById('salidaId').textContent = `# ${Id}`;
            document.getElementById('salidaFecha').textContent = salidaFecha;
            document.getElementById('salidaTipo').textContent = salidaTipo;
            document.getElementById('salidaRealizadoPor').textContent = salidaRealizadoPor;
            document.getElementById('salidaEmpleado').textContent = salidaEmpleado;
 

            var formData = new FormData;
            formData.append("opcion", "2");
            formData.append("id_salida", Id);

            //Creacion de la tabla del modal
            fetch("./api/consultas.php", {
                method: "POST",
                body: formData,
            })
            .then((response) => response.json())
            .then((data) => {                
                        let t= document.getElementById('tbodyDetallePedido');

                        t.innerHTML = '';

                        // Iterar sobre los datos y crear una fila para cada artículo
                        data.forEach(dato => {
                            const fila = document.createElement("tr");
                            
                            //var costo = parseFloat(parseFloat(dato.costo).toFixed(2));
                            //var costoFormateado = costo.toLocaleString('en-US');
                            fila.innerHTML =
                            `<td>${dato.id_articulo}</td>
                             <td>${dato.cantidad}</td>
                             <td>${ (dato.nombre == null) ? 'N/A' : dato.nombre}</td>
                             <td>${ (dato.precio == null) ? 'N/A' : `$ ${(parseFloat(dato.precio)).toFixed(2)}` }</td>
                             <td>${ (dato.total == null) ? 'N/A' : `$ ${(parseFloat(dato.total)).toFixed(2)}` }</td>`;
                            t.appendChild(fila);

                            total = total +  parseFloat( (dato.total == null) ? 0 : dato.total);
                        }); 

                        document.getElementById('totalCostoSalida').textContent = `       $ ${ parseFloat(total.toFixed(2)).toLocaleString('en-US') }`;
                        new bootstrap.Modal(document.getElementById('verSalidaModal')).show();
            }).catch((error) => {
                console.log(error);
            });
        }

        function imprimirPedido(){
            alert("Imprimir registro");
        }

        // Renderizar la tabla al cargar la página
        renderTable();