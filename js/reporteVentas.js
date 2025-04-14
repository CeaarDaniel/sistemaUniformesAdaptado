// Estado inicial
const state = {
    reportType: '1',
    filters: {
        startDate: '',
        endDate: '',
        category: null,
        employee: null,
        user: null
    },
    data: []
};

// Event Listeners
document.getElementById('toggleFilters').addEventListener('click', () => {
    const filters = document.getElementById('advancedFilters');
    new bootstrap.Collapse(filters).toggle();
});

document.getElementById('generateReport').addEventListener('click', async () => {
    await loadReportData();
    updateTable();
});

// Cargar datos del reporte (simulación)
async function loadReportData() {
    // Simular llamada a API
    state.data = [
        {
            id: 1,
            fecha: '2023-10-01',
            empleado: 'Juan Pérez',
            usuario: 'Admin',
            total: 1500,
            articulos: [
                { nombre: 'Producto 1', cantidad: 2 },
                { nombre: 'Producto 2', cantidad: 1 }
            ]
        }
    ];
}

// Actualizar tabla
function updateTable() {
    const tbody = document.getElementById('reportResults');
    tbody.innerHTML = '';

    state.data.forEach(item => {
        // Fila principal
        const mainRow = document.createElement('tr');
        mainRow.className = 'hover-row';
        mainRow.innerHTML = `
            <td>${item.articulos.length}</td>
            <td>${item.id}</td>
            <td>${item.fecha}</td>
            <td>${item.empleado}</td>
            <td>${item.usuario}</td>
            <td>$${item.total}</td>
        `;
        
        // Filas de detalle
        const detailRows = item.articulos.map(art => `
            <tr class="sub-row">
                <td></td>
                <td></td>
                <td>${art.cantidad} pza(s)</td>
                <td colspan="3">${art.nombre}</td>
            </tr>
        `).join('');

        tbody.appendChild(mainRow);
        tbody.insertAdjacentHTML('beforeend', detailRows);
    });

    document.getElementById('emptyState').classList.toggle('d-none', state.data.length > 0);
}


    // Configurar fechas iniciales
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('startDate').value = today;
    document.getElementById('endDate').value = today;