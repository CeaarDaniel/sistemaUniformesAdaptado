const state = {
    empleado: null,
    articulos: [],
    currentArticulo: null
};


    document.getElementById('agregarBtn').addEventListener('click', agregarArticulo);
    document.getElementById('confirmarBtn').addEventListener('click', () => {
        new bootstrap.Modal('#confirmModal').show();
    });
    document.getElementById('confirmAction').addEventListener('click', generarSalida);

async function buscarEmpleado(event) {
    if(event.key !== 'Enter') return;
    
    const numeroNomina = document.getElementById('empleadoInput').value;
    try {
        const response = await fetch(`/api/empleados/${numeroNomina}`);
        state.empleado = await response.json();
        mostrarAlerta('Empleado encontrado', 'success');
    } catch (error) {
        mostrarAlerta('Empleado no encontrado', 'danger');
    }
}

function agregarArticulo() {
    const cantidad = parseInt(document.getElementById('cantidadInput').value);
    
    if(!state.currentArticulo) {
        mostrarAlerta('Selecciona un artículo primero', 'warning');
        return;
    }
    
    if(cantidad < 1) {
        mostrarAlerta('Cantidad inválida', 'warning');
        return;
    }

    const nuevoArticulo = {
        ...state.currentArticulo,
        cantidad,
        id: Date.now()
    };

    state.articulos.push(nuevoArticulo);
    actualizarTabla();
}

function actualizarTabla() {
    const tbody = document.getElementById('articulosBody');
    tbody.innerHTML = state.articulos.map(articulo => `
        <tr>
            <td><i class="bi bi-x-circle cursor-pointer" onclick="eliminarArticulo(${articulo.id})"></i></td>
            <td>${articulo.id}</td>
            <td><img src="${articulo.imagen}" class="article-img" alt="${articulo.nombre}"></td>
            <td>${articulo.nombre}</td>
            <td>${articulo.categoria}</td>
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

    document.getElementById('emptyState').style.display = 
        state.articulos.length > 0 ? 'none' : 'block';
}

window.modificarCantidad = (id, cambio) => {
    const articulo = state.articulos.find(a => a.id === id);
    articulo.cantidad = Math.max(1, articulo.cantidad + cambio);
    actualizarTabla();
};

window.eliminarArticulo = (id) => {
    state.articulos = state.articulos.filter(a => a.id !== id);
    actualizarTabla();
};

async function generarSalida() {
    if(state.articulos.length === 0) {
        mostrarAlerta('Agrega artículos primero', 'warning');
        return;
    }

    try {
        const payload = {
            empleado: state.empleado,
            articulos: state.articulos,
            fecha: new Date().toISOString()
        };

        const response = await fetch('/api/salidas', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        });

        if(response.ok) {
            mostrarAlerta('Salida registrada correctamente', 'success');
            state.articulos = [];
            actualizarTabla();
        }
    } catch (error) {
        mostrarAlerta('Error al registrar salida', 'danger');
    }
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