
    // Inicializar tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(t => new bootstrap.Tooltip(t));
    
    let state = {
        fecha: {
            from: new Date().toISOString().split('T')[0],
            to: new Date().toISOString().split('T')[0]
        },
        entradaConsecutivo: '',
        pedido: []
    };

    // Elementos del DOM
    const elementos = {
        numPedido: document.getElementById('numPedido'),
        tableBody: document.getElementById('tableBody'),
        fechaDesde: document.getElementById('fechaDesde'),
        fechaHasta: document.getElementById('fechaHasta'),
        confirmModal: new bootstrap.Modal('#confirmModal'),
        generarPedidoBtn: document.getElementById('generarPedidoBtn')
    };

    // Event Listeners
    elementos.fechaDesde.addEventListener('change', actualizarFecha);
    elementos.fechaHasta.addEventListener('change', actualizarFecha);
    elementos.generarPedidoBtn.addEventListener('click', () => elementos.confirmModal.show());
    document.getElementById('confirmarBtn').addEventListener('click', generarPedido);

    // Funciones principales
    async function inicializar() {
        await obtenerConsecutivo();
        await buscarArticulos();
        actualizarVista();
    }

    async function obtenerConsecutivo() {
        const fecha = new Date();
        // Simular llamada a la API
        const consecutivo = '001'; // Reemplazar con llamada real
        state.entradaConsecutivo = `${fecha.getFullYear()}/${String(fecha.getMonth() + 1).padStart(2, '0')}/${consecutivo.padStart(3, '0')}`;
    }

    async function buscarArticulos() {
        // Simular llamada a la API
        state.pedido = [
            { id_articulo: 1, cantidad: 5, nombre: 'Camisa', abrev: 'CAM', talla: 'M' }
        ]; // Reemplazar con datos reales
    }

    function eliminarArticulo(id) {
        state.pedido = state.pedido.filter(item => item.id_articulo !== id);
        actualizarVista();
    }

    function actualizarVista() {
        elementos.numPedido.textContent = `NUM PEDIDO: ${state.entradaConsecutivo}`;
        
        // Actualizar tabla
        elementos.tableBody.innerHTML = state.pedido.map(item => `
            <tr>
                <td class="text-center">${item.id_articulo}</td>
                <td class="text-center">${item.cantidad}</td>
                <td>${item.nombre}</td>
                <td class="text-center">${item.abrev}</td>
                <td class="text-center">${item.talla}</td>
                <td class="text-center">
                    <button class="btn btn-danger btn-sm deleteBtn" data-id="${item.id_articulo}">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `).join('');

        // Agregar eventos a botones de eliminar
        document.querySelectorAll('.deleteBtn').forEach(btn => {
            btn.addEventListener('click', () => eliminarArticulo(parseInt(btn.dataset.id)));
    })
}

    async function generarPedido() {
        if (state.pedido.length === 0) {
            mostrarAlerta('¡No se puede realizar un pedido sin artículos!', 'danger');
            return;
        }
        
        // Simular envío a la API
        console.log('Pedido generado:', state.pedido);
        elementos.confirmModal.hide();
        mostrarAlerta('Pedido generado correctamente!', 'success');
        window.location.href = '/uniformes/entradas';
    }

    function mostrarAlerta(mensaje, tipo) {
        const alerta = document.createElement('div');
        alerta.className = `alert alert-${tipo} alert-dismissible fade show fixed-top m-3`;
        alerta.innerHTML = `
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.prepend(alerta);
    }

    function actualizarFecha() {
        state.fecha.from = elementos.fechaDesde.value;
        state.fecha.to = elementos.fechaHasta.value;
        buscarArticulos();
        actualizarVista();
    }

    // Inicializar
    elementos.fechaDesde.value = state.fecha.from;
    elementos.fechaHasta.value = state.fecha.to;
    inicializar();