//Inputs pertenecientes a los check de la seccion de filtros
var  categorySelect = document.getElementById('categorySelect');
var  employeeInput = document.getElementById('employeeInput');
var  userSelect = document.getElementById('userSelect');
var btnReporteVentas = document.getElementById('btnReporteVentas');


//Inputs de los filtros de las fechas
var startDate =  document.getElementById('startDate');
var endDate = document.getElementById('endDate');


//Check box de la seccion de filtros
var allCategories = document.getElementById('allCategories')
var allEmployees = document.getElementById('allEmployees')
var allUsers = document.getElementById('allUsers');

// Configurar fechas iniciales
const today = new Date().toISOString().split('T')[0];
// startDate.value = today //si quiero dar el valor de la fecha actual;
//endDate.value =  today;


function enableInput (){  
    //Verificar si el chek de Categoria esta seleccionado
    if(allCategories.checked) {
        categorySelect.disabled = true;
        categorySelect.value = '0'
    }

    else 
        categorySelect.disabled = false;
    
    //Verificar el chek de Empleados
    if(allEmployees.checked) {
        employeeInput.disabled = true;
        employeeInput.value = ''
    }

    else 
        employeeInput.disabled = false;

    //Verificar el chek de Usuarios
    if(allUsers.checked){
        userSelect.disabled = true;
        userSelect.value= '0'
    }

    else 
        userSelect.disabled = false;
}

// Event Listeners
document.getElementById('toggleFilters').addEventListener('click', () => {
    const filters = document.getElementById('advancedFilters');
    new bootstrap.Collapse(filters).toggle();
});

document.getElementById('generateReport').addEventListener('click', async () => {
    updateTable();
});

allCategories.addEventListener('change', enableInput)
allEmployees.addEventListener('change', enableInput)
allUsers.addEventListener('change', enableInput)
btnReporteVentas.addEventListener('click', imprimirReporteVenta)

// Actualizar tabla
function updateTable() {
    const reportType = document.querySelector('input[name="reportType"]:checked'); //Articulo o Venta
    var columnasTabla = document.getElementById("tableHeader");
    var formDataFiltros = new FormData;
    formDataFiltros.append('opcion', 1);
    formDataFiltros.append('reportType', reportType.value);

    formDataFiltros.append('categorySelect', categorySelect.value);
    formDataFiltros.append('employeeInput', employeeInput.value);
    formDataFiltros.append('userSelect', userSelect.value);
    formDataFiltros.append('startDate', startDate.value);
    formDataFiltros.append('endDate', endDate.value);

    fetch("./api/reportes.php", {
        method: "POST",
        body: formDataFiltros,
    })
        .then((response) => response.json())
        .then((data) => {

            ancho= window.innerWidth - 50;
            document.getElementById('emptyState').classList.add('d-none');
            document.getElementById('reportResults').classList.remove('d-none');

            $('#reportResults').DataTable().destroy(); //Restaurar la tablas

            // Crear la configuración de las columnas para DataTables
            var columnas = Object.keys(data[0]);
            var columnasConfig = columnas.map(function (columna) { return { "data": columna }; });

            //Restear las columnas de la tabla
            while (columnasTabla.firstChild) 
                columnasTabla.removeChild(columnasTabla.firstChild);

            //$('#reportResults thead tr:nth-child(2)').remove(); //Se elimina la fila clonada (2)
                    

            //Agregar las nuevas columnas a la tabla
            columnas.forEach(columna => {
                const fila = document.createElement("th");
                fila.textContent = columna.replaceAll("_", " ").toUpperCase();
                columnasTabla.appendChild(fila);
            });

            /*
            $('#reportResults thead tr').clone().appendTo('#reportResults thead');
            $('#reportResults thead tr:eq(1) th').each(function (i) {
                var title = $(this).text(); //es el nombre de la columna
                $(this).html( '<input class="p-0 m-0" type="text" style="width:100%" placeholder="'+title+'" />' );                      
                $( 'input', this ).on( 'keyup change', function () {
                    if ( $('#reportResults').DataTable().column(i).search() !== this.value)
                        $('#reportResults').DataTable().column(i).search( this.value).draw();
                });
            }); */

            //Crear el dataTable con las nuevas configuraciones
            $('#reportResults').DataTable({
                responsive: true,
                scrollX: ancho,
                scrollY: 280,
                scrollCollapse: true,
                data: data,
                columns: columnasConfig, 
                columnDefs: [
                    {
                        targets: Array.from({ length: columnasConfig.length }, (_, i) => i),
                        className: 'text-center'
                    },
                ],
                "initComplete": function(settings, json) {

                    $('#reportResults').off('click', 'tr');

                    //SOLO PARA LA TABLA DE VENTAS
                    if (reportType.value == '1') {
                        // Asignar el evento a las celdas de la tabla
                        $('#reportResults').on('click', 'tr', function() {
                            var ID= $(this).find('td').eq(0).text();
                            var fecha= $(this).find('td').eq(1).text();
                            var empleado= $(this).find('td').eq(2).text();
                            var usuario= $(this).find('td').eq(3).text();
                            var pagoTotal= $(this).find('td').eq(4).text();

                            detallVenta(ID, fecha, empleado, usuario, pagoTotal);
                        })
                    }
                }
            });
        })
        .catch((error) => {
            console.log(error);
            $('#tableReportes').DataTable().clear();
            $('#tableReportes').DataTable().destroy();
            document.getElementById('emptyState').classList.remove('d-none');
            document.getElementById('reportResults').classList.add('d-none');
        }
    )
}

//CARGA DE LA TABLA CON LOS VALORES PREDETERMINADOS
updateTable();

function detallVenta (id, fecha, empleado, usuario, pagoTotal){
    document.getElementById('modalfecha').textContent =  (new Date (fecha)).toLocaleString('es-ES', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        hour12: true  // Usar el formato de 24 horas
    }).replace(',', ''); //FECHA DE ELABORACION
    document.getElementById('modalusuario').textContent = `${usuario}` //USUARIO
    document.getElementById('modalEmpleado').textContent = `${empleado}` ;
    document.getElementById('modalPagoTotal').textContent = `$ ${pagoTotal}` ;

    const fromDataArticulos = new FormData();
    fromDataArticulos.append('opcion', 2);
    fromDataArticulos.append('idVenta', id);

    fetch("./api/reportes.php", {
        method: "POST",
        body: fromDataArticulos,
    }
    ).then((response) => response.json())
    .then((data) => {
        let t= document.getElementById('tableDetallVenta');

        t.innerHTML = '';

        // Iterar sobre los datos y crear una fila para cada artículo
        data.forEach(dato => {
            const fila = document.createElement("tr");
            
            fila.innerHTML =
            `<td>${dato.id_venta}</td>
            <td>${dato.id_articulo}</td>
            <td>${dato.nombre}</td>
            <td>${dato.cantidad}</td>
            <td>${dato.precio}</td>
            <td>${dato.costo}</td>`;
             t.appendChild(fila);
          }); 
        })
    .catch((error) => { console.log(error); })

    //document.getElementById('modalBodyDetalleVenta').innerHTML;
    new bootstrap.Modal(document.getElementById('modalDetalleVenta')).show();
}

function imprimirReporteVenta (){

    const reportType = document.querySelector('input[name="reportType"]:checked'); //Articulo o Venta
    var formDataFiltros = new FormData;
    formDataFiltros.append('opcion', 1);
    formDataFiltros.append('reportType', reportType.value);

    formDataFiltros.append('categorySelect', categorySelect.value);
    formDataFiltros.append('employeeInput', employeeInput.value);
    formDataFiltros.append('userSelect', userSelect.value);
    formDataFiltros.append('startDate', startDate.value);
    formDataFiltros.append('endDate', endDate.value);

    fetch("./api/reportes.php", {
        method: "POST",
        body: formDataFiltros,
    })
        .then((response) => response.json())
        .then((data) => {
            let tabla = ``;
              // Iterar sobre los datos y crear una fila para cada artículo

             let filtroEmpleado = (employeeInput.value == '' || employeeInput.value == '0') ? 'Todos' : employeeInput.value+"-"+data[0].EMPLEADO
                data.forEach(dato => {
                     tabla = tabla +  
                            `<tr class="page-break-avoid">
                                <td class="my-1 page-break-avoid">${dato.id_venta}</td>
                                <td class="my-1 page-break-avoid">${dato.fecha}</td>
                                <td class="my-1 page-break-avoid">${dato.EMPLEADO}</td>
                                <td class="my-1 page-break-avoid">$ ${(parseFloat(dato.pago_total)).toFixed(2)}</td>
                            </tr>`;
                  });

                    impresionInventario.innerHTML = `<div id="contenido" class="hojaImpresion" style="font-size:13px;"><!-- Detalles de la salida -->
                                                            <div class="row border border-dark">
                                                                <div class="col-6 text-center border-bottom border-dark my-1"><b>Reporte De Ventas</b></div>
                                                                <div class="col-6 text-center border-bottom border-dark my-1"><b>Periodo:</b> ${(startDate.value == '' || endDate.value == '') ? 'Todos' : ` ${startDate.value} - ${endDate.value}` }</div>

                                                                <div class="col-4 my-1"><b>Tipo:</b> ${(reportType.value == '1') ? 'Solo venta' : 'Solo articulos'}</div>
                                                                <div class="col-8 my-1"><b>Empleado:</b> ${filtroEmpleado}</div>

                                                                <div class="col-4 my-1"><b>Categoria:</b> ${ (categorySelect.value) == 0 ?  'Todos' :  $('#categorySelect option:selected').text()}</div>
                                                                <div class="col-8 my-1"><b>Usuario:</b> ${ (userSelect.value) == 0 ? 'Todos' : $('#userSelect option:selected').text()}</div>
                                                            </div>
                                                        </div>

                                                        <p class="page-break-avoid text-center my-4" style="font-size:16px;"><b>ARTÍCULOS</b></p>
                                                         <table class="page-break-avoid table mt-1" style="font-size:12px;">
                                                            <thead class="page-break-avoid">
                                                                <tr>
                                                                    <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Cant.</th>
                                                                    <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Fecha</th>
                                                                    <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Empleado</th>
                                                                    <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="page-break-avoid" style="font-size:12px">
                                                                ${tabla}
                                                            </tbody>
                                                        </table>`;

                    const opt = {
                        margin: [8, 13, 10, 13], // márgenes: [top, right, bottom, left]
                        filename: 'salida_'+2357+'_entrega de uniforme por vale.pdf',
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
                    html2pdf().set(opt).from(impresionInventario).outputPdf('blob')
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
}