var impresionInventario = document.getElementById('impresionInventario');
var tabla = ``;
var filtroEmpleado = ''

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
         
// Configurar jsPDF
const { jsPDF } = window.jspdf;

// Función para formatear fechas
const formatter = {
    fecha: function(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('es-MX');
    },
    currency: function(value) {
        return new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(value);
    }
};

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

            $('#reportResults').DataTable().clear();
            $('#reportResults').DataTable().destroy(); //Restaurar la tablas

            // Crear la configuración de las columnas para DataTables
            var columnas = Object.keys(data[0]);
            var columnasConfig = columnas.map(function (columna) { return { "data": columna } });

            console.log(columnasConfig)

            //Restear las columnas de la tabla
            while (columnasTabla.firstChild) 
                columnasTabla.removeChild(columnasTabla.firstChild);
                    

            //Agregar las nuevas columnas a la tabla
            columnas.forEach(columna => {
                const fila = document.createElement("th");
                fila.textContent = columna.replaceAll("_", " ").toUpperCase();
                columnasTabla.appendChild(fila);
            });

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

            columnasConfig= '';

        })
        .catch((error) => {
            console.log(error);
            $('#reportResults').DataTable().clear();
            $('#reportResults').DataTable().destroy();
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
                // Obtener datos del reporte
                const reportData = data;
                
                // Crear instancia de jsPDF
                let doc = new jsPDF("p", "cm", "letter");
                const pageHeight = doc.internal.pageSize.getHeight();
                
                // Configuración inicial
                doc.setLineWidth(0.01);
                doc.setFont("helvetica", "bold");
                doc.setFontSize(11);
                
                // Encabezado del reporte
                doc.rect(2, 2, 17.5, 2);
                doc.line(2, 2.5, 19.5, 2.5);
                
                doc.text("Reporte De Ventas", 3, 2.4);
                doc.text("Periodo: ", 12, 2.4);
                
                doc.setFont("helvetica", "normal");
                doc.text(`${(startDate.value == '' || endDate.value == '') ? 'Todos' : ` ${startDate.value} - ${endDate.value}` }`, 13.8, 2.4);
                
                doc.setFont("helvetica", "bold");
                doc.text("Tipo: ", 2.5, 3);
                doc.setFont("helvetica", "normal");
                doc.text(`${(reportType.value == '1') ? 'Solo venta' : 'Solo articulos'}`, 3.6, 3);
                
                doc.setFont("helvetica", "bold");
                doc.text("Categoria: ", 2.5, 3.7);
                doc.setFont("helvetica", "normal");
                doc.text(`${ (categorySelect.value) == 0 ?  'Todos' :  $('#categorySelect option:selected').text()}`, 4.5, 3.7);
                
                doc.setFont("helvetica", "bold");
                doc.text("Empleado: ", 9, 3);
                doc.setFont("helvetica", "normal");
                doc.text(`${filtroEmpleado}`, 11.1, 3);
                
                doc.setFont("helvetica", "bold");
                doc.text("Usuario: ", 9, 3.7);
                doc.setFont("helvetica", "normal");
                doc.text(`${ (userSelect.value) == 0 ? 'Todos' : $('#userSelect option:selected').text()}`, 10.7, 3.7);
                
                // Cabecera de la tabla
                doc.setFillColor(30, 61, 144);
                doc.rect(2, 4.45, 17.5, 0.7, "F");
                
                doc.setFontSize(9);
                doc.setFont("helvetica", "bold");
                doc.setTextColor(255, 255, 255);
                
                let salto = 4.9;
                
                if (reportType.value === "1") {
                    doc.text("Cant.", 2.3, salto);
                    doc.text("Fecha", 5.6, salto);
                    doc.text("Empleado", 11, salto);
                    doc.text("Total", 17, salto);
                    
                    doc.setFont("helvetica", "normal");
                    doc.setTextColor(0, 0, 0);
                    
                    salto += 0.7;
                    
                    for (const v of reportData) {
                        if (salto > pageHeight - 1.5) {
                            doc.addPage();
                            doc.setFont("helvetica", "normal");
                            doc.setTextColor(0, 0, 0);
                            doc.setLineWidth(0.01);
                            salto = 2; // Reiniciar posición en nueva página
                        }
                        
                        doc.text(v.id_venta + "", 2.4, salto);
                        doc.text(v.fecha, 4.4, salto);
                        doc.text(v.EMPLEADO, 8.6, salto);
                        doc.text(formatter.currency(v.pago_total), 18.2, salto, "right");
                        
                        doc.setLineWidth(0.01);
                        doc.line(2, salto + 0.2, 19.4, salto + 0.2);
                        salto += 0.7;
                    }
                } 
                
                else if (reportType.value === "2") {
                    doc.text("ID", 2.3, salto);
                    doc.text("Cant.", 4, salto);
                    doc.text("Artículo", 7.5, salto);
                    
                    doc.setFont("helvetica", "normal");
                    doc.setTextColor(0, 0, 0);
                    
                    salto += 0.7;
                    
                    for (const va of reportData) {
                        if (salto > pageHeight - 1.5) {
                            doc.addPage();
                            doc.setFont("helvetica", "normal");
                            doc.setTextColor(0, 0, 0);
                            doc.setLineWidth(0.01);
                            salto = 2;
                        }
                        
                        doc.text(va.id_articulo + "", 2.4, salto);
                        doc.text(va.cantidad + "", 4.4, salto);
                        doc.text(va.nombre, 6.5, salto);
                        doc.setLineWidth(0.01);
                        doc.line(2, salto + 0.2, 19.4, salto + 0.2);
                        salto += 0.7;
                    }
                }
                
                // Abrir el PDF en una nueva ventana
                window.open(doc.output('bloburl'), '_blank');
                
                // Actualizar previsualización
                actualizarPrevisualizacion(reportData);
    }).catch((error) => {
        console.log(error);
    });
}