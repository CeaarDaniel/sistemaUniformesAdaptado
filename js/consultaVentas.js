
        document.getElementById('anio').addEventListener('change', renderizarVentas)
        document.getElementById('mes').addEventListener('change', renderizarVentas)
        const cartaDescuentos = document.getElementById("contenido");

        function renderizarVentas() {
                var ancho = window.innerWidth;
                var formData = new FormData;
                formData.append("opcion", "3");
                formData.append('mes', document.getElementById('mes').value)
                formData.append('anio', document.getElementById('anio').value)
            
                fetch("./api/consultas.php", {
                        method: "POST",
                        body: formData,
                    })
                    .then((response) => response.json())
                    .then((data) => {
                                        $('#tablaVentas').DataTable().destroy(); //Restaurar la tablas
                                        $('#totalVentas').text( parseFloat(data[0].total).toLocaleString('en-US', {minimumFractionDigits: 2,
                                                                                                                   maximumFractionDigits: 2}));

                                        //Crear el dataTable con las nuevas configuraciones
                                        $('#tablaVentas').DataTable({
                                            responsive: true,
                                            scrollX: true,
                                            scrollY: true,
                                            scrollCollapse: true,
                                            data: data,
                                            columns: [
                                                { "data": "id_venta" },  
                                                { "data": "fecha" },
                                                { "data": "empleado" },
                                                { "data": "pago_total" },
                                                { "data": "num_descuentos" }, 
                                                { "data": "aplicados"},
                                                { "data": "concretar"},
                                                { "data": "firma"}

                                            ], 
                                            columnDefs: [
                                                {
                                                    targets: [0,1,2,3,4,5,6],
                                                    className: 'text-center'
                                                },
                                                {
                                                    targets: [1],
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
                                                }
                                            ],

                                            "drawCallback": function(settings) { //Captura el evento para cuando el datatable se redibuja, por ejemplo al cambiar de pagina
                                                                let btnFirma = document.querySelectorAll(".btnFirma");
                                                                let btnConcretar = document.querySelectorAll(".btnConcretar");

                                                            //Evento para el bton de ver pedidos
                                                            btnFirma.forEach(boton => {
                                                                boton.removeEventListener("click", verFirma);
                                                                boton.addEventListener("click", verFirma);
                                                            });

                                                            //Evento para el bton de ver pedidos
                                                            btnConcretar.forEach(boton => {
                                                                boton.removeEventListener("click", detalleVenta);
                                                                boton.addEventListener("click", detalleVenta);
                                                            });
                                                        }
                                        });
                    })
                    .catch((error) => {
                    console.log(error);
        
                    $('#tablaVentas').DataTable().clear();
                    $('#tablaVentas').DataTable().destroy();
                    $('#tablaVentas').DataTable();
                });
        }

        function detalleVenta(event){
            const boton = event.target.closest("button"); // Accede al atributo data-id del botón que disparó el evento
            var id = boton.getAttribute('data-id'); //Id de la venta
            var empleado = boton.getAttribute('data-empleado');
            var fecha = boton.getAttribute('data-fecha'); 
            var descuentos = boton.getAttribute('data-descuentos'); 
            var costo = boton.getAttribute('data-costo');

            document.getElementById('ventaId').textContent= id;
            document.getElementById('ventaEmpleado').textContent= empleado;
            document.getElementById('ventaFecha').textContent =  fecha;
            document.getElementById('ventaCosto').textContent= costo;
            document.getElementById('ventaDescuentos').textContent= descuentos;


            var formData = new FormData;
            formData.append("opcion", "4");
            formData.append("id_venta", id);

            //Creacion de la tabla del modal
            fetch("./api/consultas.php", {
                method: "POST",
                body: formData,
            })
            .then((response) => response.json())
            .then((data) => {                
                let descuentosModal= document.getElementById('descuentosModal');

                descuentosModal.innerHTML= '';
    
    
                 data.forEach(dato => {
                    const descuento = document.createElement("div");

                        if(dato.check_valor != null && dato.check_valor != '') {
                                let checked =  (dato.check_valor == '1') ? 'checked' : '';
                                let disabled =  (dato.check_valor == '1') ? 'disabled' : '';
                                let color = (dato.check_valor == '1') ? 'background: rgb(240, 239, 165);' : '';
                                descuento.innerHTML = `<div class="animated-border">
                                                            <div class="row py-4 form-section" style="${color}">
                                                                <div class="col-2">
                                                                    <div class="form-check">
                                                                        <label class="textlabelVentas">Concretar </label>
                                                                        <div class="d-flex flex-wrap justify-content-end" style="width:100%">
                                                                            <input class="form-check-input" type="checkbox" data-id="${dato.check_nombre}" id="${dato.check_nombre}" ${checked} ${disabled}>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-5">
                                                                        <label class="textlabelVentas">💸 Descuento </label>
                                                                        <input type="number" class="form-control" value="${dato.descuento}" disabled>
                                                                </div>
                                                                <div class="col-5">
                                                                    <!-- Sección Fecha -->
                                                                        <label class="textlabelVentas">📅 Fecha</label>
                                                                        <input id="fecha${dato.check_nombre}" type="datetime-local" class="form-control" value="${dato.fechaC}" ${disabled}>
                                                                </div>
                                                            </div>
                                                        </div>`;
                            }

                  
                        if(dato.check_valor == null && dato.check_nombre == 'check_1'){
                            descuentosModal.innerHTML =`<div class="py-4 form-section">
                                                            <div class="form-check text-center">
                                                                <label class="textlabelVentas">SI REGISTRO DE DESCUENTO</label>
                                                            </div>
                                                        </div>`;
                                    return '';
                        }
        
                        descuentosModal.appendChild(descuento); 
                })


                var checks = document.querySelectorAll('.form-check-input');

                        checks.forEach(checkbox => {
                            checkbox.addEventListener('change', function () {
                                const id_check = this.getAttribute('data-id'); // o this.dataset.id
                                const isChecked = this.checked;
                                concretarDescuento(id,id_check, isChecked)
                                
                                
                                // Aquí puedes hacer lo que necesites
                            });
                        });
    
    
                new bootstrap.Modal(document.getElementById('detalleVentadaModal')).show();
            }).catch((error) => {
                console.log(error);
            });
        }

        function concretarDescuento(id_venta,id_check, isChecked){

            if(isChecked)
            {
                var opcion = confirm("¿Está seguro de concretar este descuento? No se podrá realizar cambios mas adelante");

                if(opcion) {

                    var formData = new FormData;
                    var fecha= document.getElementById(`fecha${id_check}`).value
                    formData.append("opcion", "5");
                    formData.append("id_venta", id_venta);
                    formData.append("fecha", fecha);
                    formData.append("check", id_check)
                    //Creacion de la tabla del modal
                    fetch("./api/consultas.php", {
                        method: "POST",
                        body: formData,
                    })
                    .then((response) => response.json())
                    .then((data) => {           
                        
                        if(data.ok){
                            alert("SE HA ECHO EL REGISTRO DEL DESCUENTO CON FECHA "+fecha+ " en la venta "+id_venta+ "En el check "+ id_check);
                            bootstrap.Modal.getInstance(document.getElementById('detalleVentadaModal')).hide();
                        }

                        else console.log(data.error)
                       
                    }).catch((error) => {
                        console.log(error);
                    });
                }

                else {
                    document.getElementById(id_check).checked = false;
                }
            }
        }


        async function verFirma(event) {
             const boton = event.target.closest("button"); // Accede al atributo data-id del botón que disparó el evento
            var id = boton.getAttribute('data-id'); //ID  de salida
            var firma = boton.getAttribute('data-firma');

             var fecha = boton.getAttribute("data-fecha")
             var empleado = boton.getAttribute("data-empleado")
             var costo = boton.getAttribute("data-costo")
             var NN = boton.getAttribute("data-NN");
             var costoTexto = boton.getAttribute("data-costoTexto")

             var formData = new FormData;
             formData.append("opcion", "9");
             formData.append("id_venta", id)
            
                fetch("./api/consultas.php", {
                        method: "POST",
                        body: formData,
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        let articulosventa = "";   
                        data.forEach( (articulo) => {
                            articulosventa = articulosventa + `<div class="row mb-1 ms-3 page-break-avoid" style="font-size:14px;">
                                                                    <div class="col-2">Cantidad: ${articulo.cantidad}</div>
                                                                    <div class="col-4">${articulo.nombre}</div>
                                                                    <div class="col-2">$ ${articulo.precio} c/u</div>
                                                                </div>`
                            });

                        var conteniod = `<!--TITULO DEL DOCUMENTO -->
                            <p class="text-center" style="font-size:16px;"><b>CARTA DE ACEPTACIÓN DE DESCUENTOS</b></p>
                            <p class="text-end"><b>${(new Date(fecha)).toLocaleDateString("es-MX")}</b></p>
                            <p class="text-start ms-3" style="font-size:14px;">
                                ATENCIÓN <br>
                                BEYONZ MEXICANA, S.A. de C.V.
                            </p>

                            <!--PRIMER PARRAFO -->
                            <p class="text-start mt-4 mb-5" style="text-indent: 2em; font-size:14px;">
                                Por medio de la presente, autorizo a la empresa BEYONZ MEXICANA, S.A. DE C.V., que me descuente vía nómina la cantidad de $ ${costo} (pesos 00/100 M.N.) en total.
                            </p>

                            <!--TABLA DE DESCUENTOS --> 
                            <div class="page-break-avoid">
                                <div class="row mx-3 p-0" style="max-width: 716px; margin: 0 auto;">
                                    <div class="col-2 border border-black p-0"><div class="d-flex text-center align-items-center" style="height:100%;"><b style="font-size: 12px;"> CANTIDAD A DESCONTAR </b></div> </div>
                                    <div class="col-6 border-top border-bottom border-end border-black p-0"><div class="d-flex justify-content-center align-items-center" style="height:100%;"><b style="font-size: 12px;">MONTO EN LETRA</b></div></div>
                                    <div class="col-2 border-top border-bottom border-end border-black p-0"><div class="d-flex text-center align-items-center" style="height:100%;"><b style="font-size: 12px;">CANTIDAD DE DESCUENTOS</b></div></div>
                                    <div class="col-2 border-top border-bottom border-end border-black p-0"><div class="d-flex justify-content-center align-items-center" style="height:100%;"><b style="font-size: 12px;">FECHA</b></div></div>

                                    <div class="col-2 text-center border-start border-bottom border-end border-black p-0"><label style="font-size: 12px;"> $ ${costo} </label></div>
                                    <div class="col-6 text-center border-bottom border-end border-black p-0"><label style="font-size: 12px;"> ${costoTexto} </label></div>
                                    <div class="col-2 text-center border-bottom border-end border-black p-0"><label style="font-size: 12px;">1 de 1</labelb></div>
                                    <div class="col-2 text-center border-bottom border-end border-black p-0"><label style="font-size: 12px;">${(new Date(fecha)).toLocaleDateString("es-MX")}</label></div>

                                    <div class="col-2 text-center border-start border-bottom border-end border-black p-0">
                                        <label style="font-size: 12px;"><b> $ ${costo} </b></label>
                                        </div>
                                        <div class="col-4">
                                        <b style="font-size: 12px;"> Total adeudo </b>
                                    </div>
                                </div>
                            </div>
                            
                            <!--DESGLOCE DE ARTRTICULOS SOLICITADOS -->
                            <div class="page-break-avoid">
                                <p class="text-start mt-4" style="text-indent: 2em; font-size:14px;">
                                    Con estos descuentos estaré cubriendo el adeudo por concepto de compra de uniforme adicional que por
                                    interés personal he solicitado: 
                                </p>
                            </div>

                            ${articulosventa}

                            <!-- FIRMA DEL EMPLEADO -->
                            <div class="page-break-avoid">
                                <p class="mt-5 mb-1 p-0 mx-0" style="font-size:14px;">
                                    Ratifico con mi firma lo aquí descrito. <br> <br>
                                    Atentamente: 
                                </p>
                            </div>

                            <div class="page-break-avoid signature-area ms-0">
                                <div class="row mt-1">
                                    <div class="col-8 mt-0 p-0"> 
                                        <div class="text-center">
                                            <img class="my-0 p-0" src="imagenes/firmas/${firma}" style="height: 60px;">
                                            <div class="signature-line"></div>
                                            <p>${empleado}</p>
                                        </div>
                                    </div>
                                    <div class="col-4 p-0 m-0">
                                        <div style="height: 40px;"></div>
                                        <p class="my-0 py-0">N.N.<span class="text-decoration-underline mx-2 my-0 py-0">&nbsp;${NN}&nbsp;</span></p>
                                    </div>
                                </div>
                            </div>`; 
             
                        cartaDescuentos.innerHTML = conteniod;
                        // Configuración optimizada para tamaño carta
                        const opt = {
                            margin: [8, 13, 10, 13], // márgenes: [top, right, bottom, left]
                            filename: 'carta_descuento.pdf',
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
                        html2pdf().set(opt).from(cartaDescuentos).outputPdf('blob')
                            .then(function(blob) {
                                const blobUrl = URL.createObjectURL(blob);
                                window.open(blobUrl, '_blank');
                                cartaDescuentos.innerHTML= '';
                            })
                            .catch(function(error) {
                            console.log(error)
                            });

                    }).catch((error) => {
                    console.log(error); 
                })
        }

   renderizarVentas(); 