    var btngenerarReporte = document.getElementById('btngenerarReporte');
    btngenerarReporte.addEventListener('click', updateTable)


    function setupFilters() {
        document.querySelectorAll('[id^="ftr"]').forEach(checkbox => {
            checkbox.addEventListener('change', (e) => {
                const targetId = e.target.id.replace('ftr', 'val').replace('os', 'o');
                document.getElementById(targetId).disabled = e.target.checked;

                if(e.target.checked)
                    document.getElementById(targetId).value='';
            });
        });
    }

    function setupToggleFilter() {
        document.getElementById('toggleFilter').addEventListener('click', () => {
            const filterSection = document.getElementById('filterSection');
            filterSection.classList.toggle('visible');
            document.getElementById('toggleFilter').innerHTML = filterSection.classList.contains('visible') 
                ? '<i class="fas fa-times"></i>'
                : '<i class="fas fa-sliders-h"></i>';
        });
    }


    function updateTable() {
        var reportType = document.querySelector('input[name="rbnSalida"]:checked');
        var columnasTabla = document.getElementById("tableHeader");
        
        var formDataFiltros = new FormData;
        formDataFiltros.append('opcion', 4);
        formDataFiltros.append('reportType', reportType.value);

        formDataFiltros.append('valTipoSalido', document.getElementById('valTipoSalido').value);
        formDataFiltros.append('valEmpleado', document.getElementById('valEmpleado').value);
        formDataFiltros.append('valUsuario',  document.getElementById('valUsuario').value);

        formDataFiltros.append('startDate',  document.getElementById('startDate').value);
        formDataFiltros.append('endDate',  document.getElementById('endDate').value);

        fetch("./api/reportes.php", {
            method: "POST",
            body: formDataFiltros,
        })
            .then((response) => response.json())
            .then((data) => {
    
                ancho= window.innerWidth - 100;
                document.getElementById('emptyState').classList.add('d-none');
                document.getElementById('reporteTable').classList.remove('d-none');
    
                $('#reporteTable').DataTable().clear();
                $('#reporteTable').DataTable().destroy();
                // Crear la configuración de las columnas para DataTables
                var columnas = Object.keys(data[0]);
                var columnasConfig = columnas.map(function (columna) { return { "data": columna }; });
    
                //Restear las columnas de la tabla
                while (columnasTabla.firstChild) 
                    columnasTabla.removeChild(columnasTabla.firstChild);
    
                //$('#reporteTable thead tr:nth-child(2)').remove(); //Se elimina la fila clonada (2)
                        
    
                //Agregar las nuevas columnas a la tabla
                columnas.forEach(columna => {
                    const fila = document.createElement("th");
                    fila.textContent = columna.replaceAll("_", " ").toUpperCase();
                    columnasTabla.appendChild(fila);
                });
    
                //Crear el dataTable con las nuevas configuraciones
                $('#reporteTable').DataTable({
                    responsive: true,
                    scrollX: ancho,
                    scrollY: 400,
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

                        $('#reporteTable').off('click', 'tr');
    
                        //SOLO PARA LA TABLA DE VENTAS
                        if (reportType.value == '1') {
                            // Asignar el evento a las celdas de la tabla
                            $('#reporteTable').on('click', 'tr', function() {
                                var ID= $(this).find('td').eq(0).text();
                                var fecha= $(this).find('td').eq(1).text();
                                var empleado= $(this).find('td').eq(2).text();
                                var usuario= $(this).find('td').eq(3).text();
                                var tipoSalidaM= $(this).find('td').eq(4).text();
    
                                detallVenta(ID, fecha, empleado, usuario, tipoSalidaM);
                            })
                        }
                    }
                });
            })
            .catch((error) => {
                console.log(error);
                $('#reporteTable').DataTable().clear();
                $('#reporteTable').DataTable().destroy();
                document.getElementById('emptyState').classList.remove('d-none');
                document.getElementById('reporteTable').classList.add('d-none');
            }
        )
    }


    function  detallVenta(ID, fecha, empleado, usuario, tipoSalida) {   

        $('#modalfecha').text(fecha)
        $('#modalusuario').text(usuario);
        $('#modalEmpleado').text(empleado);
        $('#modaltipoSalida').text(tipoSalida);

    const fromDataArticulos = new FormData();
    fromDataArticulos.append('opcion', 5);
    fromDataArticulos.append('idSalida', ID);

    fetch("./api/reportes.php", {
        method: "POST",
        body: fromDataArticulos,
    }
    ).then((response) => response.json())
    .then((data) => {
        let t= document.getElementById('tableDetalleSalida');

        t.innerHTML = '';

        if(data.length <= 0) t.innerHTML='<tr><td><b class="text-center" style="width:100%">ESTA SALIDA NO CUENTA CON ARTICULOS<td></tr></b>'

        else {
                // Iterar sobre los datos y crear una fila para cada artículo
                data.forEach(dato => {
                    const fila = document.createElement("tr");
                    fila.innerHTML =
                    `<td>${dato.id_salida}</td>
                    <td>${dato.id_articulo}</td>
                    <td>${dato.nombre}</td>
                    <td>${dato.cantidad}</td>
                    <td>${ (dato.precio == null) ? '' : dato.precio}</td>`;
                    t.appendChild(fila);
                }); 
            } 
        })
    .catch((error) => { console.log(error); })

        new bootstrap.Modal(document.getElementById('modalDetalleSalida')).show();
    }


    /* Funciones auxiliares
    function populateSelect(selectId, options) {
        const select = document.getElementById(selectId);
        select.innerHTML = options.map(opt => 
            `<option value="${opt.value || opt.ID}">${opt.label || opt.Nombre}</option>`
        ).join('');
    } */

    updateTable();
    setupFilters();
    setupToggleFilter();