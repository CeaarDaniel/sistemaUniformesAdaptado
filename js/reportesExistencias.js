
    // Estado inicial
    let state = {
        filterVisible: false,
        reporte_existencias: [],
        optCategorias: [],
        optGeneros: [],
        optEstados: []
    };

    var btngenerarReporte= document.getElementById('btngenerarReporte');
    btngenerarReporte.addEventListener('click', generarReporte);

    async function getCategorias() {
        // Simular llamada API
        state.optCategorias = [{value: 1, label: 'Categoría 1'}, {value: 2, label: 'Categoría 2'}];
        populateSelect('valCategoria', state.optCategorias);
    }

    async function getGeneros() {
        // Simular llamada API
        state.optGeneros = [{value: 1, label: 'Género 1'}, {value: 2, label: 'Género 2'}];
        populateSelect('valGenero', state.optGeneros);
    }

    async function getEstados() {
        // Simular llamada API
        state.optEstados = [{value: 1, label: 'Estado 1'}, {value: 2, label: 'Estado 2'}];
        populateSelect('valEstado', state.optEstados);
    }

    function setupFilters() {
        // Manejar checkboxes
        document.querySelectorAll('[id^="ftr"]').forEach(checkbox => {
            checkbox.addEventListener('change', (e) => {
                const targetId = e.target.id.replace('ftr', 'val').replace('os', 'o');
                document.getElementById(targetId).disabled = e.target.checked;
            });
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

    async function generarReporte() {
        // Construir query
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
        showNotification('Busqueda finalizada', 'positive');
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
            tbody.innerHTML += `
                <tr class="row-reporte">
                    <td>${item.id_articulo}</td>
                    <td>${item.nombre}</td>
                    <td>${item.stock_min}</td>
                    <td>${item.stock_max}</td>
                    <td>${item.cantidad}</td>
                </tr>
            `;
        });
        
        document.getElementById('emptyState').classList.add('d-none');
        document.getElementById('tableContent').classList.remove('d-none');
    }

    function populateSelect(selectId, options) {
        const select = document.getElementById(selectId);
        select.innerHTML = options.map(opt => 
            `<option value="${opt.value}">${opt.label}</option>`
        ).join('');
    }

    function showNotification(message, type) {
        // Implementar lógica de notificación con Bootstrap Toast
        console.log(message, type);
    }

    //await Promise.all([getCategorias(), getGeneros(), getEstados()]);
    setupFilters();
    setupToggleFilter();