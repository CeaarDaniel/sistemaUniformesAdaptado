     //LAS FUNCIONES DE ESTE CODIGO AUN NO FUNCIONAN
        const categoriaSelect = document.getElementById("categoria");
        const generarReporteBtn = document.getElementById("generarReporte");
        const tablaInventario = document.getElementById("tablaInventario");


        const categoriaCat = document.getElementById('categoriaCat');

        categoriaCat.addEventListener('change', function () {
            //history.pushState(null, '', `#/${categoriaCat.value}`);
            cargarRuta(categoriaCat.value)
        })

        // Datos de ejemplo
        const inventario = [
            { id: 1, nombre: "PLAYERA ML-Hombre T XS", costo: 243.00, precioVenta: 243.00, existencia: 3, stockMin: 10, stockMax: 6 },
            { id: 2, nombre: "PLAYERA ML-Hombre T S", costo: 243.00, precioVenta: 243.00, existencia: 22, stockMin: 30, stockMax: 20 },
            { id: 3, nombre: "PLAYERA ML-Hombre T M", costo: 243.00, precioVenta: 243.00, existencia: 13, stockMin: 30, stockMax: 20 },
            { id: 4, nombre: "PLAYERA ML-Hombre T L", costo: 243.00, precioVenta: 243.00, existencia: 17, stockMin: 30, stockMax: 20 },
            { id: 5, nombre: "PLAYERA ML-Hombre T XL", costo: 243.00, precioVenta: 243.00, existencia: 22, stockMin: 20, stockMax: 16 },
            { id: 6, nombre: "PLAYERA ML-Hombre T 2XL", costo: 243.00, precioVenta: 243.00, existencia: 18, stockMin: 20, stockMax: 16 },
            { id: 7, nombre: "PLAYERA ML-Mujer T XS", costo: 243.00, precioVenta: 243.00, existencia: 0, stockMin: 20, stockMax: 10 },
            { id: 8, nombre: "PLAYERA ML-Mujer T S", costo: 243.00, precioVenta: 243.00, existencia: 23, stockMin: 30, stockMax: 20 },
            { id: 9, nombre: "PLAYERA ML-Mujer T M", costo: 243.00, precioVenta: 243.00, existencia: 19, stockMin: 30, stockMax: 20 },
            { id: 10, nombre: "PLAYERA ML-Mujer T L", costo: 243.00, precioVenta: 243.00, existencia: 16, stockMin: 30, stockMax: 20 },
            { id: 11, nombre: "PLAYERA ML-Mujer T XL", costo: 243.00, precioVenta: 243.00, existencia: 17, stockMin: 20, stockMax: 16 },
            { id: 12, nombre: "PLAYERA ML-Mujer T 2XL", costo: 243.00, precioVenta: 243.00, existencia: 22, stockMin: 20, stockMax: 16 }
        ];

        function renderizarInventario() {
            tablaInventario.innerHTML = "";
            inventario.forEach(item => {
                const fila = document.createElement("tr");
                fila.innerHTML = `
                    <td>${item.id}</td>
                    <td>${item.nombre}</td>
                    <td>$${item.costo.toFixed(2)}</td>
                    <td>$${item.precioVenta.toFixed(2)}</td>
                    <td>${item.existencia}</td>
                    <td>${item.stockMin}</td>
                    <td>${item.stockMax}</td>
                `;
                tablaInventario.appendChild(fila);
            });
        }

        generarReporteBtn.addEventListener("click", renderizarInventario);

        // Renderizar el inventario al cargar la página
       renderizarInventario();