    let state = {
        reporte_salidas: [],
        optTipoSalidas: [],
        optUsuarios: [],
        currentHeaders: []
    };

    var btngenerarReporte = document.getElementById('btngenerarReporte');
    btngenerarReporte.addEventListener('click', generarReporte)

    async function getTipoSalidas() {
        // Simular carga de tipos de salida
        state.optTipoSalidas = [{value: 1, label: 'Tipo 1'}, {value: 2, label: 'Tipo 2'}];
        populateSelect('valTipoSalida', state.optTipoSalidas);
    }

    async function getEmpleados() {
        // Simular carga de usuarios
        state.optUsuarios = [
            {ID: 1, Nombre: 'Usuario 1'},
            {ID: 2, Nombre: 'Usuario 2'},
            {ID: 3, Nombre: 'Usuario 3'}
        ];
        populateSelect('valUsuario', state.optUsuarios);
    }

    function setupFilters() {
        document.querySelectorAll('[id^="ftr"]').forEach(checkbox => {
            checkbox.addEventListener('change', (e) => {
                const targetId = e.target.id.replace('ftr', 'val').replace('os', 'o');
                document.getElementById(targetId).disabled = e.target.checked;
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

    function setupReportTypeChange() {
        document.querySelectorAll('input[name="rbnSalida"]').forEach(radio => {
            radio.addEventListener('change', updateTableHeaders);
        });
    }

    function updateTableHeaders() {
        const reportType = document.querySelector('input[name="rbnSalida"]:checked').value;
        const headers = reportType === '3' 
            ? ['ID', 'Cantidad', 'Artículo'] 
            : ['Cant.', 'ID', 'Fecha', 'Empleado', 'Usuario', 'Tipo salida'];
        
        state.currentHeaders = headers;
        renderTableHeaders();
    }

    function renderTableHeaders() {
        const thead = document.getElementById('tableHeader');
        thead.innerHTML = `<tr>${state.currentHeaders.map(h => `<th>${h}</th>`).join('')}</tr>`;
    }

    async function generarReporte() {
        const queryParams = new URLSearchParams({
            primerFecha: document.getElementById('fechaDesde').value,
            segundaFecha: document.getElementById('fechaHasta').value,
            tipoReporte: document.querySelector('input[name="rbnSalida"]:checked').value,
            tipoSalida: document.getElementById('ftrTipoSalidas').checked ? '' : document.getElementById('valTipoSalida').value,
            empleado: document.getElementById('ftrEmpleados').checked ? '' : document.getElementById('iptEmpleado').value,
            usuario: document.getElementById('ftrUsuarios').checked ? '' : document.getElementById('valUsuario').value,
            ordenTipo: document.getElementById('valTipoOrden').value,
            ordenAscDesc: document.getElementById('valAscDecOrden').value
        });

        // Simular datos
        const mockData = [
            { id_salida: 1, fecha: '2023-08-01', empleado: 'Juan', usuario: 'admin', tipo_salida: 'Tipo 1', articulos: [
                { nombre: 'Artículo 1', piezas: 5 },
                { nombre: 'Artículo 2', piezas: 3 }
            ]}
        ];

        updateTable(mockData);
        showNotification('Búsqueda finalizada', 'success');
    }

    function updateTable(data) {
        const tbody = document.getElementById('reporteBody');
        tbody.innerHTML = '';
        
        if(data.length === 0) {
            document.getElementById('emptyState').classList.remove('d-none');
            document.getElementById('tableContent').classList.add('d-none');
            return;
        }

        data.forEach(item => {
            // Fila principal
            tbody.innerHTML += `
                <tr class="row-reporte">
                    ${generateMainRow(item)}
                </tr>
            `;

            // Filas de artículos
            if(item.articulos) {
                item.articulos.forEach(articulo => {
                    tbody.innerHTML += `
                        <tr class="row-articulos">
                            <td colspan="2"></td>
                            <td style="text-align: right; padding-right: 60px">${articulo.piezas}</td>
                            <td colspan="3">${articulo.nombre}</td>
                        </tr>
                    `;
                });
            }
        });

        document.getElementById('emptyState').classList.add('d-none');
        document.getElementById('tableContent').classList.remove('d-none');
    }

    function generateMainRow(item) {
        const reportType = document.querySelector('input[name="rbnSalida"]:checked').value;
        
        if(reportType === '3') {
            return `
                <td>${item.id_articulo || ''}</td>
                <td>${item.piezas || ''}</td>
                <td>${item.nombre || ''}</td>
            `;
        }
        
        return `
            <td>${item.cantidad || ''}</td>
            <td>${item.id_salida || ''}</td>
            <td>${item.fecha || ''}</td>
            <td style="font-weight: bold">${item.empleado || ''}</td>
            <td>${item.usuario || ''}</td>
            <td>${item.tipo_salida || ''}</td>
        `;
    }

    // Funciones auxiliares
    function populateSelect(selectId, options) {
        const select = document.getElementById(selectId);
        select.innerHTML = options.map(opt => 
            `<option value="${opt.value || opt.ID}">${opt.label || opt.Nombre}</option>`
        ).join('');
    }

    function showNotification(message, type) {
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type} border-0`;
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        document.body.appendChild(toast);
        new bootstrap.Toast(toast).show();
    }
    

    //await Promise.all([getTipoSalidas(), getEmpleados()]);
    setupFilters();
    setupToggleFilter();
    setupReportTypeChange();