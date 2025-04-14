    const generarReporteBtn = document.getElementById("generarReporte");
    const tituloReporte = document.getElementById("tituloReporte");
    const ventasTotales = document.getElementById("ventasTotales");
    const numVentas = document.getElementById("numVentas");
    const ventaPromedio = document.getElementById("ventaPromedio");
    const ventasDiarias = document.getElementById("ventasDiarias");
    const ventasCategoria = document.getElementById("ventasCategoria");
    const gananciasCategoria = document.getElementById("gananciasCategoria");
    const gananciaTotal = document.getElementById("gananciaTotal");

    // Datos de ejemplo
    const reporteVentas = {
        ventasTotales: {
            venta_total: 10000.00,
            num_ventas: 50,
            promedio_ventas: 200.00
        },
        ventasDiarias: [
            { dia: 1, mes: 10, anio: 2023, venta_total: 500.00 },
            { dia: 2, mes: 10, anio: 2023, venta_total: 600.00 }
        ],
        ventasCategoria: [
            { categoria: "Uniforme", total_venta: 4000.00 },
            { categoria: "Calzado", total_venta: 3000.00 }
        ],
        gananciasCategoria: [
            { categoria: "Uniforme", total_venta: 2000.00 },
            { categoria: "Calzado", total_venta: 1500.00 }
        ],
        ganancias: {
            ganancia: 5000.00
        }
    };

    function renderizarReporte() {
        // Actualizar título
        tituloReporte.textContent = "Ventas de Octubre del 2023";

        // Actualizar ventas generales
        ventasTotales.textContent = `$${reporteVentas.ventasTotales.venta_total.toFixed(2)}`;
        numVentas.textContent = reporteVentas.ventasTotales.num_ventas;
        ventaPromedio.textContent = `$${reporteVentas.ventasTotales.promedio_ventas.toFixed(2)}`;

        // Actualizar ventas diarias
        ventasDiarias.innerHTML = reporteVentas.ventasDiarias.map(v => `
            <div class="row justify-between">
                <div class="col-3 table-subtitle">${v.dia}/${v.mes}/${v.anio}</div>
                <div class="col-3 table-content">$${v.venta_total.toFixed(2)}</div>
            </div>
        `).join("");

        // Actualizar ventas por categoría
        ventasCategoria.innerHTML = reporteVentas.ventasCategoria.map(vc => `
            <div class="row justify-between">
                <div class="col-5 table-subtitle">${vc.categoria}</div>
                <div class="col-3 table-content">$${vc.total_venta.toFixed(2)}</div>
            </div>
        `).join("");

        // Actualizar ganancias por categoría
        gananciasCategoria.innerHTML = reporteVentas.gananciasCategoria.map(gc => `
            <div class="row justify-between">
                <div class="col-5 table-subtitle">${gc.categoria}</div>
                <div class="col-3 table-content">$${gc.total_venta.toFixed(2)}</div>
            </div>
        `).join("");

        // Actualizar ganancia total
        gananciaTotal.textContent = `$${reporteVentas.ganancias.ganancia.toFixed(2)}`;
    }

    generarReporteBtn.addEventListener("click", renderizarReporte);

    // Renderizar el reporte al cargar la página
    renderizarReporte();