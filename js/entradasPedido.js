    const entradaConsecutivo = document.getElementById("entradaConsecutivo");
    const generarPedidoBtn = document.getElementById("generarPedidoBtn");
    const eliminarSeleccionadosBtn = document.getElementById("eliminarSeleccionadosBtn");
    const confirmarEliminarBtn = document.getElementById("confirmarEliminarBtn");
    const confirmarPedidoBtn = document.getElementById("confirmarPedidoBtn");
    const tablaArticulos = document.getElementById("tablaArticulos");
    //const tablaArticulos = document.getElementById("tablaArticulos").getElementsByTagName("tbody")[0];

    // Datos de ejemplo
    const articulos = [
        { id: 1, cantidad: 10, nombre: "PLAYERA ML-Hombre T XS", categoria: "Playera", talla: "XS", genero: "Hombre" },
        { id: 2, cantidad: 5, nombre: "PLAYERA ML-Hombre T S", categoria: "Playera", talla: "S", genero: "Hombre" },
        { id: 3, cantidad: 8, nombre: "PLAYERA ML-Hombre T M", categoria: "Playera", talla: "M", genero: "Hombre" },
        { id: 4, cantidad: 12, nombre: "PLAYERA ML-Hombre T L", categoria: "Playera", talla: "L", genero: "Hombre" },
        { id: 5, cantidad: 7, nombre: "PLAYERA ML-Hombre T XL", categoria: "Playera", talla: "XL", genero: "Hombre" }
    ];

    // Función para renderizar los artículos en la tabla
    function renderizarArticulos() {
        tablaArticulos.innerHTML = "";
        articulos.forEach(articulo => {
            const fila = document.createElement("tr");
            fila.innerHTML = `
                <td>${articulo.id}</td>
                <td>${articulo.cantidad}</td>
                <td>${articulo.nombre}</td>
                <td>${articulo.categoria}</td>
                <td>${articulo.talla}</td>
                <td>${articulo.genero}</td>
            `;
            tablaArticulos.appendChild(fila);
        });
    }

    // Función para generar el número de pedido
    function generarNumeroPedido() {
        const fecha = new Date();
        const mes = String(fecha.getMonth() + 1).padStart(2, "0");
        const consecutivo = String(1).padStart(3, "0"); // Aquí deberías obtener el consecutivo real
        entradaConsecutivo.textContent = `${fecha.getFullYear()}/${mes}/${consecutivo}`;
    }

    // Evento para abrir el modal de confirmación de eliminar
    eliminarSeleccionadosBtn.addEventListener("click", () => {
        const modalConfirm = new bootstrap.Modal(document.getElementById("modalConfirm"));
        modalConfirm.show();
    });

    // Evento para confirmar la eliminación de artículos
    confirmarEliminarBtn.addEventListener("click", () => {
        // Lógica para eliminar los artículos seleccionados
        alert("Artículos eliminados");
        const modalConfirm = new bootstrap.Modal(document.getElementById("modalConfirm"));
        modalConfirm.hide();
    });

    // Evento para abrir el modal de confirmación de generar pedido
    generarPedidoBtn.addEventListener("click", () => {
        const confirmModal = new bootstrap.Modal(document.getElementById("confirmModal"));
        confirmModal.show();
    });

    // Evento para confirmar la generación del pedido
    confirmarPedidoBtn.addEventListener("click", () => {
        // Lógica para generar el pedido
        alert("Pedido generado");
        const confirmModal = new bootstrap.Modal(document.getElementById("confirmModal"));
        confirmModal.hide();
    });

    // Renderizar los artículos y el número de pedido al cargar la página
    renderizarArticulos();
    generarNumeroPedido();