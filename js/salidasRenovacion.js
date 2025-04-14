
const state = {
    empleado: null,
    articulos: [],
    tipoUniforme: null
};


    // Event Listeners
    document.getElementById('buscarEmpleadoBtn').addEventListener('click', buscarEmpleado);
    document.getElementById('confirmarBtn').addEventListener('click', () => {
        new bootstrap.Modal('#confirmModal').show();
    });
    document.getElementById('confirmarRenovacionBtn').addEventListener('click', confirmarRenovacion);
    document.getElementById('cancelarBtn').addEventListener('click', cancelarOperacion);
    
    // Eventos para selección de tipo de uniforme
    document.querySelectorAll('.uniform-type-card').forEach(card => {
        card.addEventListener('click', function() {
            state.tipoUniforme = this.dataset.tipo;
            cargarArticulosPredefinidos();
            bootstrap.Modal.getInstance('#tipoUniformeModal').hide();
        });
    });


async function buscarEmpleado() {
    const numeroEmpleado = document.getElementById('empleadoInput').value;
    if (!numeroEmpleado) return mostrarAlerta('Ingrese un número de empleado', 'warning');
    
    try {
        // Simular llamada a API
        state.empleado = { id: 1, nombre: 'Juan Pérez' };
        new bootstrap.Modal('#tipoUniformeModal').show();
    } catch (error) {
        mostrarAlerta('Error al buscar empleado', 'danger');
    }
}

function cargarArticulosPredefinidos() {
    const articulosBase = state.tipoUniforme === 'operario' ? 
        [
            { id: 1, nombre: 'Playera MC', categoria: 'Playeras', talla: 'M', genero: 'M', cantidad: 1 },
            { id: 2, nombre: 'Playera ML', categoria: 'Playeras', talla: 'M', genero: 'M', cantidad: 1 },
            { id: 3, nombre: 'Pantalón', categoria: 'Pantalones', talla: '32', genero: 'M', cantidad: 2 }
        ] :
        [
            { id: 4, nombre: 'Camisa MC', categoria: 'Camisas', talla: 'L', genero: 'H', cantidad: 1 },
            { id: 5, nombre: 'Camisa ML', categoria: 'Camisas', talla: 'L', genero: 'H', cantidad: 1 },
            { id: 6, nombre: 'Pantalón', categoria: 'Pantalones', talla: '34', genero: 'H', cantidad: 2 }
        ];

    state.articulos = articulosBase.map(art => ({
        ...art,
        generos: ['M', 'F'],
        tallas: ['S', 'M', 'L', 'XL']
    }));
    
    actualizarTabla();
}

function actualizarTabla() {
    const tbody = document.getElementById('articulosBody');
    tbody.innerHTML = state.articulos.map(articulo => `
        <tr>
            <td><button class="btn btn-danger btn-sm" onclick="eliminarArticulo(${articulo.id})"><i class="bi bi-trash"></i></button></td>
            <td>${articulo.id}</td>
            <td><img src="uniforme.jpg" class="article-img" alt="${articulo.nombre}"></td>
            <td>${articulo.nombre}</td>
            <td>
                <select class="form-select" onchange="actualizarGenero(${articulo.id}, this.value)">
                    ${articulo.generos.map(g => `<option ${articulo.genero === g ? 'selected' : ''}>${g}</option>`).join('')}
                </select>
            </td>
            <td>
                <select class="form-select" onchange="actualizarTalla(${articulo.id}, this.value)">
                    ${articulo.tallas.map(t => `<option ${articulo.talla === t ? 'selected' : ''}>${t}</option>`).join('')}
                </select>
            </td>
            <td>
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-sm btn-primary" onclick="modificarCantidad(${articulo.id}, -1)">-</button>
                    <span>${articulo.cantidad}</span>
                    <button class="btn btn-sm btn-primary" onclick="modificarCantidad(${articulo.id}, 1)">+</button>
                </div>
            </td>
        </tr>
    `).join('');

    document.getElementById('emptyState').style.display = 
        state.articulos.length > 0 ? 'none' : 'block';
}

// Funciones globales
window.actualizarGenero = (id, genero) => {
    const articulo = state.articulos.find(a => a.id === id);
    articulo.genero = genero;
};

window.actualizarTalla = (id, talla) => {
    const articulo = state.articulos.find(a => a.id === id);
    articulo.talla = talla;
};

window.modificarCantidad = (id, cambio) => {
    const articulo = state.articulos.find(a => a.id === id);
    articulo.cantidad = Math.max(1, articulo.cantidad + cambio);
    actualizarTabla();
};

window.eliminarArticulo = (id) => {
    state.articulos = state.articulos.filter(a => a.id !== id);
    actualizarTabla();
};

async function confirmarRenovacion() {
    if (!validarFormulario()) return;
    
    try {
        // Simular envío a API
        const response = await fetch('/api/renovaciones', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                empleado: state.empleado,
                articulos: state.articulos,
                fecha: new Date().toISOString()
            })
        });

        if (response.ok) {
            mostrarAlerta('Renovación registrada exitosamente', 'success');
            resetearFormulario();
        }
    } catch (error) {
        mostrarAlerta('Error al registrar renovación', 'danger');
    }
}

function validarFormulario() {
    if (!state.empleado) {
        mostrarAlerta('Seleccione un empleado primero', 'warning');
        return false;
    }
    if (state.articulos.length === 0) {
        mostrarAlerta('Agregue al menos un artículo', 'warning');
        return false;
    }
    return true;
}

function resetearFormulario() {
    state.articulos = [];
    state.empleado = null;
    document.getElementById('empleadoInput').value = '';
    actualizarTabla();
}

function cancelarOperacion() {
    if (confirm('¿Está seguro de cancelar la operación?')) {
        resetearFormulario();
    }
}

function mostrarAlerta(mensaje, tipo) {
    const alerta = document.createElement('div');
    alerta.className = `alert alert-${tipo} alert-dismissible fade show`;
    alerta.innerHTML = `
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.prepend(alerta);
    setTimeout(() => alerta.remove(), 3000);
}