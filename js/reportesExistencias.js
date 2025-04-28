
    // Estado inicial
    let state = {filterVisible: false};

    var btngenerarReporte = document.getElementById('btngenerarReporte');

    btngenerarReporte.addEventListener('click', generarReporte);

    function setupFilters() {
        // Manejar checkboxes
        /*
        document.querySelectorAll('[id^="ftr"]').forEach(checkbox => {
            checkbox.addEventListener('change', (e) => {
                const targetId = e.target.id.replace('ftr', 'val').replace('os', 'o');
                document.getElementById(targetId).disabled = e.target.checked;
            });
        }); */

        $('[id^="ftr"]').on('change', function() {
            const targetId = this.id.replace('ftr', 'val').replace('os', 'o');
            if (this.checked) $('#' + targetId).val('0');
            $('#' + targetId).prop('disabled', this.checked);

            //console.log(this.checked); 
            //console.log($('#' + targetId + 'option:selected').text())
        });
    }

    function setupToggleFilter() {
        document.getElementById('toggleFilter').addEventListener('click', () => {
            state.filterVisible = !state.filterVisible;
            const filterSection = document.getElementById('filterSection');
            filterSection.classList.toggle('visible');
            document.getElementById('toggleFilter').innerHTML = state.filterVisible 
                ? '<i class="fas fa-times"></i>'
                : '<i class="fas fa-sliders-h"></i>';
        });
    }

    function generarReporte() {
        /* Construir query
        const query = new URLSearchParams({
            tipoReporte: document.querySelector('input[name="rbnExistencia"]:checked').value,
            categoria: document.getElementById('ftrCategorias').checked ? '' : document.getElementById('valCategoria').value,
            genero: document.getElementById('ftrGeneros').checked ? '' : document.getElementById('valGenero').value,
            estado: document.getElementById('ftrEstados').checked ? '' : document.getElementById('valEstado').value,
            ordenTipo: document.getElementById('valTipoOrden').value,
            ordenAscDesc: document.getElementById('valAscDescOrden').value
        });

        // Simular llamada API
        console.log('Query:', query.toString());
        const mockData = [
            {id_articulo: 1, nombre: 'Artículo 1', stock_min: 5, stock_max: 20, cantidad: 15},
            {id_articulo: 2, nombre: 'Artículo 2', stock_min: 3, stock_max: 15, cantidad: 1},
            {id_articulo: 3, nombre: 'Artículo 3', stock_min: 5, stock_max: 20, cantidad: 0},
            {id_articulo: 4, nombre: 'Artículo 4', stock_min: 10, stock_max: 30, cantidad: 19},
            {id_articulo: 5, nombre: 'Artículo 5', stock_min: 15, stock_max: 35, cantidad: 27},
            {id_articulo: 6, nombre: 'Artículo 6', stock_min: 15, stock_max: 20, cantidad: 15},
            {id_articulo: 7, nombre: 'Artículo 7', stock_min: 5, stock_max: 19, cantidad: 1},
            {id_articulo: 8, nombre: 'Artículo 8', stock_min: 4, stock_max: 10, cantidad: 9},
            {id_articulo: 9, nombre: 'Artículo 9', stock_min: 7, stock_max: 10, cantidad: 6},
        ]; 
        
        updateTable(mockData);
        showNotification('Busqueda finalizada', 'positive'); */
        var columnasTabla = document.getElementById("tableHeader");
        const reportType = document.querySelector('input[name="rbnExistencia"]:checked'); 
        var reporteExistencias = new FormData();
        reporteExistencias.append('opcion',3);
        reporteExistencias.append('existencia', reportType.value);

        reporteExistencias.append('categoria', document.getElementById('valCategorio').value);
        reporteExistencias.append('genero', document.getElementById('valGenero').value);
        reporteExistencias.append('estado',  document.getElementById('valEstado').value);

        fetch("./api/reportes.php", {
            method: "POST",
            body: reporteExistencias,
        }
        ).then((response) => response.json())
        .then((data) => {
                ancho = window.innerWidth - 100;
                document.getElementById('emptyState').classList.add('d-none');
                document.getElementById('reportExistencias').classList.remove('d-none');

                $('#reportExistencias').DataTable().destroy(); //Restaurar la tablas

                // Crear la configuración de las columnas para DataTables
                var columnas = Object.keys(data[0]);
                var columnasConfig = columnas.map(function (columna) { return { "data": columna }; });

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
                $('#reportExistencias').DataTable({
                    responsive: true,
                    scrollX: ancho,
                    scrollY: 320,
                    scrollCollapse: true,
                    data: data,
                    columns: columnasConfig,
                    columnDefs: [
                        {
                            targets: Array.from({ length: columnasConfig.length }, (_, i) => i),
                            className: 'text-center'
                        },
                    ],
                });
            })
        .catch((error) => { 
            console.log(error); 
            $('#reportExistencias').DataTable().clear();
            $('#reportExistencias').DataTable().destroy();
            document.getElementById('emptyState').classList.remove('d-none');
            document.getElementById('reportExistencias').classList.add('d-none');
        })
    }

    setupFilters();
    setupToggleFilter();

    generarReporte();