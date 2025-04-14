        const mesSelect = document.getElementById("mes");
        const anioSelect = document.getElementById("anio");
        const ordenSelect = document.getElementById("orden");
        const totalVentas = document.getElementById("totalVentas");
        const tablaVentas = document.getElementById("tablaVentas");

        //const tablaVentas = document.getElementById("tablaVentas").getElementsByTagName("tbody")[0];

        // Datos de ejemplo
        const ventas = [
            {
                id: 2411,
                fecha: "06/03/2025 08:51:20 AM",
                empleado: "1109-HERNANDEZ CARDONA VICTOR EDUARDO",
                costoTotal: 79.00,
                descuentos: [
                    { monto: 19.75, fecha: "06/03/2025" },
                    { monto: 19.75, fecha: "06/03/2025" },
                    { monto: 19.75, fecha: "06/03/2025" },
                    { monto: 19.75, fecha: "06/03/2025" }
                ],
                totalDescuento: 0.00
            }
        ];

        function renderizarVentas() {
            tablaVentas.innerHTML = "";
            ventas.forEach(venta => {
                const fila = document.createElement("tr");
                fila.innerHTML = `
                    <td>${venta.id}</td>
                    <td>${venta.fecha}</td>
                    <td><b>${venta.empleado}</b></td>
                    <td>$${venta.costoTotal.toFixed(2)}</td>
                    ${venta.descuentos.map(desc => `
                        <td class="desc-1">
                            <input type="checkbox">
                        </td>
                        <td class="desc-1" style="font-weight: bold;">$${desc.monto.toFixed(2)}</td>
                        <td class="desc-1">
                            <input type="text" value="${desc.fecha}" disabled>
                        </td>
                    `).join("")}
                    <td><b>$${venta.totalDescuento.toFixed(2)}</b></td>
                    <td>
                        <button class="btn btn-sm btn-primary">
                            <i class="fas fa-signature"></i>
                        </button>
                    </td>
                `;
                tablaVentas.appendChild(fila);
            });
        }

   //  renderizarVentas(); 