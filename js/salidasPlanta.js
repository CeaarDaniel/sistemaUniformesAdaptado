    const state = {
        empleado: null,
        vale: '',
        articulos: [],
        tipoEntrega: '',
        nota: ''
    };

    // Elementos del DOM
    const elementos = {
        empleadoInput: document.getElementById('empleadoInput'),
        valeInput: document.getElementById('valeInput'),
        articulosTableBody: document.getElementById('articulosTableBody'),
        emptyState: document.getElementById('emptyState')
    };

    // Event Listeners
    elementos.empleadoInput.addEventListener('keyup', buscarEmpleado);
    elementos.valeInput.addEventListener('keyup', cargarArticulos);
    document.getElementById('confirmarBtn').addEventListener('click', validarSalida);
    document.getElementById('cancelarBtn').addEventListener('click', mostrarModalCancelacion);

    // Funciones principales
    async function buscarEmpleado(e) {
        if (e.key !== 'Enter') return;
        
        const numeroNomina = elementos.empleadoInput.value;
        try {
            const response = await fetch(`/api/empleados/${numeroNomina}`);
            const data = await response.json();
            
            if (!data) {
                mostrarAlerta('Empleado no encontrado', 'danger');
                return;
            }
            
            state.empleado = data;
            elementos.valeInput.focus();
        } catch (error) {
            mostrarAlerta('Error al buscar empleado', 'danger');
        }
    }

    async function cargarArticulos(e) {
        if (e.key !== 'Enter') return;
        
        try {
            const response = await fetch(`/api/vale/${elementos.valeInput.value}`);
            const valeInfo = await response.json();
            
            if (!valeInfo) {
                mostrarAlerta('Vale no válido', 'warning');
                return;
            }
            
            state.articulos = await Promise.all(valeInfo.articulos.map(async articulo => {
                const detalles = await obtenerDetallesArticulo(articulo.id_categoria);
                return {
                    ...articulo,
                    ...detalles,
                    cantidad: 1,
                    genero: -1,
                    talla: -1
                };
            }));
            
            actualizarTabla();
        } catch (error) {
            mostrarAlerta('Error al cargar artículos', 'danger');
        }
    }

    async function obtenerDetallesArticulo(idCategoria) {
        const [generos, tallas] = await Promise.all([
            fetch(`/api/generos/${idCategoria}`).then(res => res.json()),
            fetch(`/api/tallas/${idCategoria}`).then(res => res.json())
        ]);
        
        return {
            generos: generos.map(g => ({ label: g.nombre, value: g.id })),
            tallas: tallas.map(t => ({ label: t.nombre, value: t.id }))
        };
    }

    function actualizarTabla() {
        elementos.articulosTableBody.innerHTML = state.articulos.map(articulo => `
            <tr data-id="${articulo.id}">
                <td><i class="bi bi-x-circle cursor-pointer" onclick="eliminarArticulo(${articulo.id})"></i></td>
                <td>${articulo.id === '-' ? '<i class="bi bi-x-lg text-danger"></i>' : '<i class="bi bi-check-lg text-success"></i>'}</td>
                <td>${articulo.id}</td>
                <td><img src="/assets/uniformes/${articulo.id_categoria}.jpg" alt="${articulo.nombre}" style="height: 70px;"></td>
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

        elementos.emptyState.classList.toggle('d-none', state.articulos.length > 0);
    }

    // Funciones auxiliares
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

    async function validarArticulo(articulo) {
        if (articulo.genero === -1 || articulo.talla === -1) {
            articulo.id = '-';
            return;
        }

        try {
            const response = await fetch(`/api/articulos?categoria=${articulo.id_categoria}&genero=${articulo.genero}&talla=${articulo.talla}`);
            const data = await response.json();
            articulo.id = data.id;
            actualizarTabla();
        } catch (error) {
            mostrarAlerta('Error al validar artículo', 'danger');
        }
    }

    window.modificarCantidad = async (id, modificador) => {
        const articulo = state.articulos.find(a => a.id === id);
        const nuevaCantidad = articulo.cantidad + modificador;

        try {
            const response = await fetch(`/api/existencias/${id}`);
            const existencia = await response.json();
            
            if (nuevaCantidad > existencia.cantidad) {
                mostrarAlerta('No hay suficiente stock', 'warning');
                return;
            }
            
            articulo.cantidad = Math.max(1, nuevaCantidad);
            actualizarTabla();
        } catch (error) {
            mostrarAlerta('Error al modificar cantidad', 'danger');
        }
    };

    window.eliminarArticulo = (id) => {
        state.articulos = state.articulos.filter(a => a.id !== id);
        actualizarTabla();
    };

    function validarGenero(articulo) {
        return articulo.genero === -1 ? 'border-red' : 'border-green';
    }

    function validarTalla(articulo) {
        return articulo.talla === -1 ? 'border-red' : 'border-green';
    }

    async function validarSalida() {
        const errores = state.articulos.filter(a => a.id === '-');
        if (errores.length > 0) {
            mostrarAlerta('Completa todos los artículos', 'warning');
            return;
        }

        new bootstrap.Modal('#confirmarModal').show();
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