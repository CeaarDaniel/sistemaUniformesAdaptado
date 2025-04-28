//Inputs pertenecientes a los check de la seccion de filtros
var  categorySelect = document.getElementById('categorySelect');
var  employeeInput = document.getElementById('employeeInput');
var  userSelect = document.getElementById('userSelect');


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
        categorySelect.value = ''
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
        userSelect.value= ''
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