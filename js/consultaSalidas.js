        // Datos de ejemplo (simulados)
        const salidas = [
            { id_salida: 1, fecha: "2023-10-01", tipo_salida: "Tipo 1", nombre_usuario: "Usuario 1", nombre_empleado: "Empleado 1", vale: "VALE-001" },
            { id_salida: 2, fecha: "2023-10-02", tipo_salida: "Tipo 2", nombre_usuario: "Usuario 2", nombre_empleado: "Empleado 2", vale: "VALE-002" },
        ];

        // Función para renderizar la tabla
        function renderTable() {
            const tbody = document.getElementById('tablaSalidas');
            tbody.innerHTML = salidas.map(salida => `
                <tr>
                    <td>${salida.id_salida}</td>
                    <td>${salida.fecha}</td>
                    <td><strong>${salida.tipo_salida}</strong></td>
                    <td>${salida.nombre_usuario}</td>
                    <td>${salida.nombre_empleado}</td>
                    <td>${salida.vale}</td>
                    <td>
                        <button class="btn btn-primary btn-action" onclick="abrirVerSalidaModal(${salida.id_salida})">
                            <i class="fas fa-eye"></i> Ver
                        </button>
                        <button class="btn btn-info btn-action" onclick="irACambios(${salida.id_salida})">
                            <i class="fas fa-exchange-alt"></i> Cambios
                        </button>
                    </td>
                </tr>
            `).join('');
        }

        // Función para abrir el modal de ver salida
        function abrirVerSalidaModal(id) {
            const salida = salidas.find(s => s.id_salida === id);
            document.getElementById('salidaId').textContent = salida.id_salida;
            document.getElementById('salidaFecha').textContent = salida.fecha;
            document.getElementById('salidaTipo').textContent = salida.tipo_salida;
            document.getElementById('salidaRealizadoPor').textContent = salida.nombre_usuario;
            document.getElementById('salidaEmpleado').textContent = salida.nombre_empleado;
            document.getElementById('salidaVale').textContent = salida.vale;
            new bootstrap.Modal(document.getElementById('verSalidaModal')).show();
        }

        // Función para ir a la página de cambios
        function irACambios(id_salida) {
            alert(`Ir a cambios de la salida con ID: ${id_salida}`);
        }

        // Función para aplicar filtros
        function fechaOnChange() {
            const tipo = document.getElementById('tipo').value;
            const mes = document.getElementById('mes').value;
            const anio = document.getElementById('anio').value;
            alert(`Filtrar por: Tipo=${tipo}, Mes=${mes}, Año=${anio}`);
            renderTable();
        }

        // Función para filtrar por búsqueda
        function filtrarPorBusqueda() {
            const busqueda = document.getElementById('busquedaEmp').value.toLowerCase();
            const tbody = document.getElementById('tablaSalidas');
            tbody.innerHTML = salidas
                .filter(s => s.nombre_empleado.toLowerCase().includes(busqueda))
                .map(salida => `
                    <tr>
                        <td>${salida.id_salida}</td>
                        <td>${salida.fecha}</td>
                        <td><strong>${salida.tipo_salida}</strong></td>
                        <td>${salida.nombre_usuario}</td>
                        <td>${salida.nombre_empleado}</td>
                        <td>${salida.vale}</td>
                        <td>
                            <button class="btn btn-primary btn-action" onclick="abrirVerSalidaModal(${salida.id_salida})">
                                <i class="fas fa-eye"></i> Ver
                            </button>
                            <button class="btn btn-info btn-action" onclick="navegar('cambios','0','mainContent')">
                                <i class="fas fa-exchange-alt"></i> Cambios
                            </button>
                        </td>
                    </tr>
                `).join('');
        }

        // Renderizar la tabla al cargar la página
        renderTable();