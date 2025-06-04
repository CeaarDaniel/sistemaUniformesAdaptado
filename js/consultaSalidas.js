
var filtroBusqueda =  document.querySelectorAll(".filtroBusqueda");
var impresionDetalleSalida = document.getElementById("impresionDetalleSalida");

filtroBusqueda.forEach(filtro => {
    filtro.addEventListener("change", renderTable)
  });

        function renderTable() {
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
                                        scrollX: true,
                                        scrollY: true,
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
            var salidaIdTipo = boton.getAttribute('data-salidaIdTipo');
            var salidaFecha = boton.getAttribute('data-salidaFecha');
            var salidaRealizadoPor = boton.getAttribute('data-salidaRealizadoPor');
            var salidaEmpleado = boton.getAttribute('data-salidaEmpleado');
            var salidaVale = boton.getAttribute('data-salidaVale');
            var tipoVale = boton.getAttribute('data-tipoVale'); 

            let total= 0;

            document.getElementById('salidaId').textContent = `# ${Id}`;
            document.getElementById('salidaFecha').textContent = salidaFecha;
            document.getElementById('salidaTipo').textContent = salidaTipo;
            document.getElementById('salidaRealizadoPor').textContent = salidaRealizadoPor;
            document.getElementById('salidaEmpleado').textContent = salidaEmpleado;
            (salidaIdTipo == 1) ? document.getElementById('columVale').innerHTML = `<div class="my-1 col-3"><b>Vale:</b></div>
                                                                                        <div class="my-1 col-auto text-uppercase">
                                                                                            <label id="salidaVale"> ${salidaVale}</label>
                                                                                        </div>` 
                                                                                    : document.getElementById('columVale').innerHTML = ``;

            (salidaIdTipo == 1) ? document.getElementById('columTipoVale').innerHTML = `<div class="my-1 col-3"><b>Tipo de vale:</b></div>
                                                                                                    <div class="my-1 col-auto text-uppercase">
                                                                                                        <label id="tipoVale"> ${tipoVale}</label>
                                                                                                    </div>` 
                                                                        : document.getElementById('columTipoVale').innerHTML = ``;
 

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
                             <td>${ (dato.nombre == null) ? '-' : dato.nombre}</td>
                             <td>${ (dato.precio == null || salidaIdTipo != 2) ? '-' : `$ ${(parseFloat(dato.precio)).toFixed(2)}` }</td>
                             <td>${ (dato.total == null || salidaIdTipo != 2) ? '-' : `$ ${(parseFloat(dato.total)).toFixed(2)}` }</td>`;
                            t.appendChild(fila);

                            if(dato.total != null) total = total + parseFloat(dato.total);
                        });

                        document.getElementById('totalCostoSalida').textContent = `       ${ (salidaIdTipo != 2) ? '-' : '$ '+parseFloat(total.toFixed(2)).toLocaleString('en-US') }`;
                        new bootstrap.Modal(document.getElementById('verSalidaModal')).show();
            }).catch((error) => {
                console.log(error);
            });
        }

        function imprimirPedido(event){
            const boton = event.target.closest("button"); // Accede al atributo data-id del botón que disparó el evento
            var Id = boton.getAttribute('data-id');
            var salidaTipo = boton.getAttribute('data-salidaTipo');
            var salidaIdTipo = boton.getAttribute('data-salidaIdTipo');
            var salidaFecha = boton.getAttribute('data-salidaFecha');
            var salidaRealizadoPor = boton.getAttribute('data-salidaRealizadoPor');
            var salidaEmpleado = boton.getAttribute('data-salidaEmpleado');
            var salidaVale = boton.getAttribute('data-salidaVale');
            var NN = boton.getAttribute('data-NN');


            let columnaVale = (salidaIdTipo == 1) ? `<div class="my-0 col-4"><b>Vale:</b></div>
                                    <div class="my-0 col-auto text-uppercase">
                                        <label id="salidaVale"> ${salidaVale}</label>
                                    </div>` 
                                : ``;
                
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
                        let tabla = ``;
                        let total= 0;
                        console.log(data);

                        // Iterar sobre los datos y crear una fila para cada artículo
                        data.forEach(dato => {
                                tabla= tabla + `<tr class="page-break-avoid">
                                                    <td>${dato.id_articulo}</td>
                                                    <td>${ (dato.cantidad == null) ? '-' : dato.cantidad }</td>
                                                    <td>${ (dato.nombre == null) ? '-' : dato.nombre}</td>
                                                    <td>${ (dato.precio == null || salidaIdTipo != 2) ? '-' : `$ ${(parseFloat(dato.precio)).toFixed(2)}` }</td>
                                                    <td>${ (dato.total == null || salidaIdTipo != 2) ? '-' : `$ ${(parseFloat(dato.total)).toFixed(2)}` }</td>
                                                </tr>`;

                            if(dato.total != null) total = total + parseFloat(dato.total);
                        });

                         var contenidoDetalle = `<p class="text-center" style="font-size:15px;"> 
                                                    <b>SALIDA - UNIFORMES</b>
                                                </p>
                                        
                                                <!-- Detalles de la salida -->
                                                <div class="mx-5 d-flex justify-content-between">
                                                    <img src="./imagenes/beyonz.jpg" style="max: width 150px; max-height:50px;">
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td class="text-center p-0 border-top border-start border-end border-dark" style="width:100%"><b>&nbsp; NUM SALIDA&nbsp;</b></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-center p-0 border border-dark" style="width:100%"># ${Id}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <!-- Detalles del pedido -->
                                                <div class="row mt-5">
                                                    <div class="my-0 col-4"><b>Fecha de elaboración:</b></div>
                                                    <div class="my-0 col-auto"><label class="mx-0 px-0 text-uppercase"> ${salidaFecha}</label></div>
                                                </div>

                                                <div class="row my-0">
                                                    <div class="my-0 col-4"><b>Realizado por:</b></div>
                                                    <div class="my-0 col-auto"><label>${salidaRealizadoPor}</label></div>
                                                </div>

                                                <div class="row my-0">
                                                    <div class="my-0 col-4"><b>Entregado a:</b></div>
                                                    <div class="my-0 col-auto text-uppercase"><label>${NN}-${salidaEmpleado}</label></div>
                                                    </div>
                                                    
                                                    <!-- TIPO DE SALIDA -->
                                                    <div class="row mt-0">
                                                    <div class="my-0 col-4"><b>Tipo de salida:</b></div>
                                                    <div class="my-0 col-auto text-uppercase"><label>${salidaTipo}</label></div>
                                                    </div>

                                                    <!-- VALE -->
                                                    <div class="row mt-0"> ${columnaVale}</div>

                                                    <hr class="my-4" style="height: 5px; background: linear-gradient(90deg,rgba(9, 11, 122, 1) 33%, rgba(133, 133, 133, 1) 0%); opacity: 1; border:none;">

                                                    <!--TABLA DE PRODUCTOS -->
                                                    <p class="text-center fs-7"><b> ARTICULOS </b></p>
                                                    <div style="max-height: 400px;">
                                                    <table id="tablaSalidas" class="table table-striped" style="width:100%;">
                                                        <thead class="sticky-header">
                                                            <tr>
                                                                <tr>
                                                                    <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Clave</th>
                                                                    <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Cantidad</th>
                                                                    <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Articulo</th>
                                                                    <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Precio unitario</th>
                                                                    <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Total</th>
                                                                </tr>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- Filas de la tabla se llenarán dinámicamente -->
                                                            ${tabla}
                                                        </tbody>
                                                    </table>

                                                        <div class="mx-3 d-flex justify-content-end" style="font-size:13px">
                                                            <b>Total:</b> &nbsp; &nbsp; <label>      ${ (salidaIdTipo != 2) ? '-' : '$ '+parseFloat(total.toFixed(2)).toLocaleString('en-US') }</label>
                                                        </div>
                                                    </div>`;
                        impresionDetalleSalida.innerHTML = contenidoDetalle;

                        // Configuración optimizada para tamaño carta
                        const opt = {
                            margin: [8, 13, 10, 13], // márgenes: [top, right, bottom, left]
                            filename: 'salida_'+Id+'_entrega de uniforme por vale.pdf',
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
                        html2pdf().set(opt).from(impresionDetalleSalida).outputPdf('blob')
                            .then(function(blob) {
                                const blobUrl = URL.createObjectURL(blob);
                                window.open(blobUrl, '_blank');
                                //impresionDetalleSalida.innerHTML= '';
                            })
                            .catch(function(error) {
                                console.log(error)
                            });

            }).catch((error) => {
                console.log(error);
            });

    
            /*
            (salidaIdTipo == 1) ?  `<div class="my-1 col-3"><b>Vale:</b></div>
                                        <div class="my-1 col-auto text-uppercase">
                                            <label id="salidaVale"> ${salidaVale}</label>
                                        </div>`  : ``;

            (salidaIdTipo == 1) ? `<div class="my-1 col-3"><b>Tipo de vale:</b></div>
                                        <div class="my-1 col-auto text-uppercase">
                                            <label id="tipoVale"> ${tipoVale}</label>
                                        </div>` 
                                : ``; */
        }

        // Renderizar la tabla al cargar la página
        renderTable();