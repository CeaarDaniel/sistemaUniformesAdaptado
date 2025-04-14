const state = {
    empleado: null,
    articulos: [],
    total: 0
};


    document.getElementById('agregarArticuloBtn').addEventListener('click', agregarArticulo);
    document.getElementById('confirmarBtn').addEventListener('click', mostrarConfirmacion);
    document.getElementById('cancelarBtn').addEventListener('click', cancelarVenta);

async function buscarEmpleado() {
    const numeroNomina = document.getElementById('empleadoInput').value;
    try {
        const response = await fetch(`/api/empleados/${numeroNomina}`);
        state.empleado = await response.json();
        actualizarVista();
    } catch (error) {
        mostrarAlerta('Error al buscar empleado', 'danger');
    }
}

function agregarArticulo() {
    const cantidad = parseInt(document.getElementById('cantidadInput').value);
    if (cantidad < 1) return mostrarAlerta('Cantidad inválida', 'warning');
    
    const nuevoArticulo = {
        id: Date.now(),
        nombre: 'Artículo de prueba',
        precio: 100,
        cantidad: cantidad,
        talla: 'M',
        categoria: 'Uniforme'
    };

    state.articulos.push(nuevoArticulo);
    actualizarVista();
}

function actualizarVista() {
    const tbody = document.getElementById('articulosBody');
    tbody.innerHTML = state.articulos.map(articulo => `
        <tr>
            <td><i class="bi bi-x-circle cursor-pointer" onclick="eliminarArticulo(${articulo.id})"></i></td>
            <td>${articulo.id}</td>
            <td><img src="placeholder.jpg" alt="${articulo.nombre}" style="height: 70px;"></td>
            <td>${articulo.nombre}</td>
            <td>${articulo.categoria}</td>
            <td>$${articulo.precio}</td>
            <td>${articulo.talla}</td>
            <td>
                <div class="d-flex align-items-center">
                    <button class="btn btn-sm btn-primary" onclick="modificarCantidad(${articulo.id}, -1)">-</button>
                    <span class="mx-2">${articulo.cantidad}</span>
                    <button class="btn btn-sm btn-primary" onclick="modificarCantidad(${articulo.id}, 1)">+</button>
                </div>
            </td>
        </tr>
    `).join('');

    actualizarTotal();
    document.getElementById('emptyState').classList.toggle('d-none', state.articulos.length > 0);
}

function actualizarTotal() {
    state.total = state.articulos.reduce((acc, curr) => acc + (curr.precio * curr.cantidad), 0);
    document.getElementById('totalDisplay').textContent = `Total: $${state.total}`;
}

window.modificarCantidad = (id, cambio) => {
    const articulo = state.articulos.find(a => a.id === id);
    articulo.cantidad = Math.max(1, articulo.cantidad + cambio);
    actualizarVista();
};

window.eliminarArticulo = (id) => {
    state.articulos = state.articulos.filter(a => a.id !== id);
    actualizarVista();
};

function mostrarConfirmacion() {
    if (state.articulos.length === 0) return mostrarAlerta('Agrega artículos primero', 'warning');
    new bootstrap.Modal('#confirmarModal').show();
}

function cancelarVenta() {
    state.articulos = [];
    actualizarVista();
    mostrarAlerta('Venta cancelada', 'success');
}

function mostrarAlerta(mensaje, tipo) {
    const alerta = document.createElement('div');
    alerta.className = `alert alert-${tipo} alert-dismissible fade show fixed-alert`;
    alerta.innerHTML = `
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alerta);
    setTimeout(() => alerta.remove(), 3000);
}