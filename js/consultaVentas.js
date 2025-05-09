
        document.getElementById('anio').addEventListener('change', renderizarVentas)
        document.getElementById('mes').addEventListener('change', renderizarVentas)

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
                                            scrollX: (ancho - 50),
                                            scrollY: 340,
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
            var id = boton.getAttribute('data-id');
            var firma = boton.getAttribute('data-firma');

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            const fecha = '05-05-2025';
            const empresa = 'BEYONZ MEXICANA, S.A. de C.V.';
            const empleado = 'DELGADO ESCAMILLA CERVANDO';
            const numeroEmpleado = 'N.N. 203';
            const monto = '$79.00';
            const montoLetra = 'SETENTA Y NUEVE PESOS';
            const descripcion = 'Cantidad: 1 GORRA-T Gris $79.00 c/u';

            let y = 20;
            doc.setFontSize(12);
            doc.setFont("helvetica", "bold");
            doc.text('CARTA DE ACEPTACIÓN DE DESCUENTOS', 105, y, { align: 'center' });
            doc.text(fecha, 20, y); y += 10;
            doc.setFont("helvetica", "normal");

            
            doc.text('ATENCIÓN', 20, y); y += 8;
            doc.text(empresa, 20, y); y += 10;

            doc.text(`Por medio de la presente, autorizo a la empresa ${empresa},`, 20, y); y += 7;
            doc.text(`que me descuente vía nómina la cantidad de ${monto} (pesos 00/100 M.N.) en total.`, 20, y); y += 10;

            doc.setFont(undefined, 'bold');
            doc.text('CANTIDAD A     MONTO EN LETRA     CANTIDAD DE     FECHA', 20, y); y += 7;
            doc.setFont(undefined, 'normal');
            doc.text(`${monto}     ${montoLetra}     1 de 1           ${fecha}`, 20, y); y += 10;

            doc.setFont(undefined, 'bold');
            doc.text(`${monto}     Total adeudo`, 20, y); y += 10;
            doc.setFont(undefined, 'normal');

            doc.text('Con estos descuentos estaré cubriendo el adeudo por concepto de compra de uniforme adicional que por', 20, y); y += 7;
            doc.text('interés personal he solicitado:', 20, y); y += 7;
            doc.text(descripcion, 20, y); y += 15;

            doc.text('Ratifico con mi firma lo aquí descrito.', 20, y); y += 20;

            doc.text('Atentamente:', 20, y); y += 10;
            doc.text(empleado, 20, y); y += 7;
            doc.text(numeroEmpleado, 20, y); y += 10;

            // Cargar imagen de firma (debe estar en la misma ruta del servidor o accesible)
            const firmaUrl = 'http://localhost/sistemaUniformesAdaptado/imagenes/firmas/'+firma;
            const img = new Image();
            img.crossOrigin = "Anonymous";
            img.src = firmaUrl;

            img.onload = function () {
                doc.addImage(img, 'PNG', 20, y, 50, 20); // (imagen, formato, x, y, ancho, alto)
                y += 25;

                doc.text('_________________________', 20, y); y += 7;
                doc.text('Firma', 40, y);

                // Mostrar el PDF en nueva pestaña
                const blob = doc.output('blob');
                const blobUrl = URL.createObjectURL(blob);
                window.open(blobUrl, '_blank');
            };

            img.onerror = function () {
                alert('No se pudo cargar la imagen de la firma.');
            };
        }

   renderizarVentas(); 