const state = {
    empleado: null,
    vale: '',
    articulos: [],
    currentArticulo: null
};


    document.getElementById('agregarBtn').addEventListener('click', agregarArticulo);
    document.getElementById('confirmarBtn').addEventListener('click', () => {
        new bootstrap.Modal('#confirmModal').show();
    });
    document.getElementById('confirmAction').addEventListener('click', confirmarReposicion);
    document.getElementById('cancelarBtn').addEventListener('click', cancelarOperacion);


async function agregarArticulo() {
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
        id: Date.now(),
        genero: -1,
        talla: -1
    };

    state.articulos.push(nuevoArticulo);
    actualizarTabla();
}

function actualizarTabla() {
    const tbody = document.getElementById('articulosBody');
    tbody.innerHTML = state.articulos.map(articulo => `
        <tr data-id="${articulo.id}">
            <td><i class="bi bi-x-circle cursor-pointer" onclick="eliminarArticulo(${articulo.id})"></i></td>
            <td>${articulo.id}</td>
            <td><img src="${articulo.imagen}" class="article-img" alt="${articulo.nombre}"></td>
            <td>${articulo.nombre}</td>
            <td>
                <select class="form-select ${validarGenero(articulo)}" 
                        onchange="actualizarGenero(${articulo.id}, this.value)">
                    ${articulo.generos.map(g => `<option value="${g.value}">${g.label}</option>`).join('')}
                </select>
            </td>
            <td>
                <select class="form-select ${validarTalla(articulo)}" 
                        onchange="actualizarTalla(${articulo.id}, this.value)">
                    ${articulo.tallas.map(t => `<option value="${t.value}">${t.label}</option>`).join('')}
                </select>
            </td>
            <td>
                <div class="d-flex align-items-center">
                    <button class="btn btn-sm btn-primary" onclick="modificarCantidad(${articulo.id}, -1)">-</button>
                    <span class="mx-2">${articulo.cantidad}</span>
                    <button class="btn btn-sm btn-primary" onclick="modificarCantidad(${articulo.id}, 1)">+</button>
                </div>
            </td>
        </tr>
    `).join('');

    document.getElementById('emptyState').classList.toggle('d-none', state.articulos.length > 0);
}

window.actualizarGenero = (id, genero) => {
    const articulo = state.articulos.find(a => a.id === id);
    articulo.genero = genero;
    validarArticulo(articulo);
};

window.actualizarTalla = (id, talla) => {
    const articulo = state.articulos.find(a => a.id === id);
    articulo.talla = talla;
    validarArticulo(articulo);
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

async function confirmarReposicion() {
    if(state.articulos.length === 0) {
        mostrarAlerta('Agrega artículos primero', 'warning');
        return;
    }

    try {
        const response = await fetch('/api/reposiciones', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                empleado: state.empleado,
                articulos: state.articulos,
                vale: state.vale
            })
        });

        if(response.ok) {
            mostrarAlerta('Reposición registrada exitosamente', 'success');
            resetearFormulario();
        }
    } catch (error) {
        mostrarAlerta('Error al registrar reposición', 'danger');
    }
}

function cancelarOperacion() {
    if(confirm('¿Estás seguro de cancelar la operación?')) {
        resetearFormulario();
    }
}

function resetearFormulario() {
    state.articulos = [];
    state.empleado = null;
    state.vale = '';
    actualizarTabla();
    document.getElementById('empleadoInput').value = '';
    document.getElementById('valeInput').value = '';
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