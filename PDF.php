<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .card-header {
            background-color: #1e3d8c;
            color: white;
        }
        .form-label {
            font-weight: 500;
        }
        .report-container {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .btn-print {
            background-color: #1e3d8c;
            color: white;
        }
        .btn-print:hover {
            background-color: #0d2a6d;
        }
        .section-title {
            border-bottom: 2px solid #1e3d8c;
            padding-bottom: 8px;
            color: #1e3d8c;
            margin-top: 20px;
        }
        .form-control:focus {
            border-color: #1e3d8c;
            box-shadow: 0 0 0 0.25rem rgba(30, 61, 140, 0.25);
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header py-3">
                        <h2 class="h4 mb-0"><i class="bi bi-graph-up me-2"></i>Reporte de Ventas</h2>
                    </div>
                    <div class="card-body">
                        <!-- Filtros del reporte -->
                        <div class="mb-4">
                            <h3 class="section-title">Filtros</h3>
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Tipo de Reporte</label>
                                    <select id="reportType" class="form-select">
                                        <option value="1">Ventas por ticket</option>
                                        <option value="2">Ventas detalladas</option>
                                        <option value="3">Artículos vendidos</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Categoría</label>
                                    <select id="categorySelect" class="form-select">
                                        <option value="todas">Todas las categorías</option>
                                        <option value="electronica">Electrónica</option>
                                        <option value="ropa">Ropa</option>
                                        <option value="alimentos">Alimentos</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Empleado</label>
                                    <input type="text" id="employeeInput" class="form-control" placeholder="Buscar empleado...">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Usuario</label>
                                    <select id="userSelect" class="form-select">
                                        <option value="admin">Administrador</option>
                                        <option value="ventas">Personal de ventas</option>
                                        <option value="caja">Cajero</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Fecha Inicio</label>
                                    <input type="date" id="startDate" class="form-control" value="2025-06-01">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Fecha Fin</label>
                                    <input type="date" id="endDate" class="form-control" value="2025-06-10">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Ordenar por</label>
                                    <select id="orderBy" class="form-select">
                                        <option value="fecha">Fecha</option>
                                        <option value="total">Total</option>
                                        <option value="empleado">Empleado</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Orden</label>
                                    <select id="orderDirection" class="form-select">
                                        <option value="asc">Ascendente</option>
                                        <option value="desc">Descendente</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Botón para generar PDF -->
                        <div class="d-flex justify-content-center mb-4">
                            <button id="btnGenerarPDF" class="btn btn-lg btn-print">
                                <i class="bi bi-printer me-2"></i>Generar Reporte PDF
                            </button>
                        </div>
                        
                        <!-- Previsualización del reporte -->
                        <div class="report-container">
                            <h3 class="section-title">Previsualización del Reporte</h3>
                            <div id="reportPreview" class="mt-3">
                                <p class="text-center text-muted">Selecciona los filtros y haz clic en "Generar Reporte PDF" para ver una previsualización</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    
    <script>
        // Esperar a que el DOM esté listo
        document.addEventListener('DOMContentLoaded', function() {
            // Referencias a elementos del DOM
            const btnGenerarPDF = document.getElementById('btnGenerarPDF');
            const reportPreview = document.getElementById('reportPreview');
            
            // Configurar jsPDF
            const { jsPDF } = window.jspdf;
            
            // Función para formatear fechas
            const formatter = {
                fecha: function(dateString) {
                    const date = new Date(dateString);
                    return date.toLocaleDateString('es-MX');
                },
                currency: function(value) {
                    return new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(value);
                }
            };
            
            // Función para obtener los datos del reporte
            function obtenerDatosReporte() {
                // En una implementación real, esto haría una llamada fetch al servidor
                // Para este ejemplo, generaremos datos de muestra
                
                const reportType = document.getElementById('reportType').value;
                const startDate = document.getElementById('startDate').value;
                const endDate = document.getElementById('endDate').value;
                
                // Construir etiquetas para el PDF
                const lblPeriodo = `${formatter.fecha(startDate)} a ${formatter.fecha(endDate)}`;
                const lblTipoReporte = document.getElementById('reportType').options[document.getElementById('reportType').selectedIndex].text;
                const lblCategoria = document.getElementById('categorySelect').options[document.getElementById('categorySelect').selectedIndex].text;
                const lblEmpleado = document.getElementById('employeeInput').value || 'Todos';
                const lblUsuario = document.getElementById('userSelect').options[document.getElementById('userSelect').selectedIndex].text;
                const lblOrdenarPor = document.getElementById('orderBy').options[document.getElementById('orderBy').selectedIndex].text;
                const lblOrden = document.getElementById('orderDirection').value === 'asc' ? 'Ascendente' : 'Descendente';
                
                // Generar datos de ventas según el tipo de reporte
                let ventas = [];
                
                if (reportType === '1' || reportType === '2') {
                    // Datos para reporte de ventas
                    ventas = [
                        {
                            cantidad: 5,
                            fecha: '2025-06-01',
                            empleado: '1088-JUAREZ RODRIGUEZ YADIRA VANESSA',
                            pago_total: 1250.50,
                            articulos: [
                                { piezas: 2, nombre: 'Laptop HP' },
                                { piezas: 1, nombre: 'Mouse inalámbrico' },
                                { piezas: 2, nombre: 'Cargador USB-C' }
                            ]
                        },
                        {
                            cantidad: 3,
                            fecha: '2025-06-03',
                            empleado: '807-BENITEZ GONZALEZ ROSA MARIA',
                            pago_total: 850.75,
                            articulos: [
                                { piezas: 1, nombre: 'Tablet Samsung' },
                                { piezas: 2, nombre: 'Funda para tablet' }
                            ]
                        },
                        {
                            cantidad: 7,
                            fecha: '2025-06-05',
                            empleado: '1165-VALDES ORTIZ ANA VALERIA',
                            pago_total: 2100.25,
                            articulos: [
                                { piezas: 3, nombre: 'Smartphone Xiaomi' },
                                { piezas: 2, nombre: 'Auriculares Bluetooth' },
                                { piezas: 2, nombre: 'Power Bank' }
                            ]
                        }
                    ];
                } 
                else if (reportType === '3') {
                    // Datos para reporte de artículos vendidos
                    ventas = [
                        { id_articulo: 1001, piezas: 15, nombre: 'Laptop HP' },
                        { id_articulo: 1002, piezas: 32, nombre: 'Mouse inalámbrico' },
                        { id_articulo: 1003, piezas: 28, nombre: 'Cargador USB-C' },
                        { id_articulo: 1004, piezas: 12, nombre: 'Tablet Samsung' },
                        { id_articulo: 1005, piezas: 45, nombre: 'Funda para tablet' }
                    ];
                }
                
                return {
                    ventas,
                    tipoReporte: reportType,
                    lblPeriodo,
                    lblTipoReporte,
                    lblCategoria,
                    lblEmpleado,
                    lblUsuario,
                    lblOrdenarPor,
                    lblOrden
                };
            }
            
            // Función para generar el PDF
            function generarPDF() {
                // Obtener datos del reporte
                const reportData = obtenerDatosReporte();
                
                // Crear instancia de jsPDF
                let doc = new jsPDF("p", "cm", "letter");
                const pageHeight = doc.internal.pageSize.getHeight();
                
                // Configuración inicial
                doc.setLineWidth(0.01);
                doc.setFont("helvetica", "bold");
                doc.setFontSize(11);
                
                // Encabezado del reporte
                doc.rect(2, 2, 17.5, 2);
                doc.line(2, 2.5, 19.5, 2.5);
                
                doc.text("Reporte De Ventas", 3, 2.4);
                doc.text("Periodo: ", 12, 2.4);
                
                doc.setFont("helvetica", "normal");
                doc.text(reportData.lblPeriodo, 13.8, 2.4);
                
                doc.setFont("helvetica", "bold");
                doc.text("Tipo: ", 2.5, 3);
                doc.setFont("helvetica", "normal");
                doc.text(reportData.lblTipoReporte, 3.6, 3);
                
                doc.setFont("helvetica", "bold");
                doc.text("Categoria: ", 2.5, 3.7);
                doc.setFont("helvetica", "normal");
                doc.text(reportData.lblCategoria, 4.5, 3.7);
                
                doc.setFont("helvetica", "bold");
                doc.text("Empleado: ", 9, 3);
                doc.setFont("helvetica", "normal");
                doc.text(reportData.lblEmpleado, 11.1, 3);
                
                doc.setFont("helvetica", "bold");
                doc.text("Usuario: ", 9, 3.7);
                doc.setFont("helvetica", "normal");
                doc.text(reportData.lblUsuario, 10.7, 3.7);
                
                // Cabecera de la tabla
                doc.setFillColor(30, 61, 144);
                doc.rect(2, 4.45, 17.5, 0.7, "F");
                
                doc.setFontSize(9);
                doc.setFont("helvetica", "bold");
                doc.setTextColor(255, 255, 255);
                
                let salto = 4.9;
                
                if (reportData.tipoReporte === "1" || reportData.tipoReporte === "2") {
                    doc.text("Cant.", 2.3, salto);
                    doc.text("Fecha", 5.6, salto);
                    doc.text("Empleado", 11, salto);
                    doc.text("Total", 17, salto);
                    
                    doc.setFont("helvetica", "normal");
                    doc.setTextColor(0, 0, 0);
                    
                    salto += 0.7;
                    
                    for (const v of reportData.ventas) {
                        if (salto > pageHeight - 1.5) {
                            doc.addPage();
                            doc.setFont("helvetica", "normal");
                            doc.setTextColor(0, 0, 0);
                            doc.setLineWidth(0.01);
                            salto = 2; // Reiniciar posición en nueva página
                        }
                        
                        doc.text(v.cantidad + "", 2.4, salto);
                        doc.text(formatter.fecha(v.fecha), 4.4, salto);
                        doc.text(v.empleado, 8.6, salto);
                        doc.text(formatter.currency(v.pago_total), 18.2, salto, "right");
                        
                        if (reportData.tipoReporte === "2") {
                            for (const a of v.articulos) {
                                salto += 0.7;
                                if (salto > pageHeight - 2) {
                                    doc.addPage();
                                    doc.setFont("helvetica", "normal");
                                    doc.setTextColor(0, 0, 0);
                                    doc.setLineWidth(0.01);
                                    salto = 2;
                                }
                                doc.text(a.piezas + " pza(s)", 4.4, salto);
                                doc.text(a.nombre, 8.6, salto);
                            }
                        }
                        
                        doc.setLineWidth(0.01);
                        doc.line(2, salto + 0.2, 19.4, salto + 0.2);
                        salto += 0.7;
                    }
                } 
                
                else if (reportData.tipoReporte === "3") {
                    doc.text("ID", 2.3, salto);
                    doc.text("Cant.", 4, salto);
                    doc.text("Artículo", 7.5, salto);
                    
                    doc.setFont("helvetica", "normal");
                    doc.setTextColor(0, 0, 0);
                    
                    salto += 0.7;
                    
                    for (const va of reportData.ventas) {
                        if (salto > pageHeight - 1.5) {
                            doc.addPage();
                            doc.setFont("helvetica", "normal");
                            doc.setTextColor(0, 0, 0);
                            doc.setLineWidth(0.01);
                            salto = 2;
                        }
                        
                        doc.text(va.id_articulo + "", 2.4, salto);
                        doc.text(va.piezas + "", 4.4, salto);
                        doc.text(va.nombre, 6.5, salto);
                        doc.setLineWidth(0.01);
                        doc.line(2, salto + 0.2, 19.4, salto + 0.2);
                        salto += 0.7;
                    }
                }
                
                // Pie de página
                    //const fechaGeneracion = new Date();
                    //doc.setFontSize(8);
                    //doc.setTextColor(100);
                    //doc.text(`Generado el: ${fechaGeneracion.toLocaleString()}`, 2, pageHeight - 1);
                    //doc.text(`Página ${doc.internal.getNumberOfPages()}`, 18, pageHeight - 1, null, null, "right");
                
                // Abrir el PDF en una nueva ventana
                window.open(doc.output('bloburl'), '_blank');
                
                // Actualizar previsualización
                actualizarPrevisualizacion(reportData);
            }
            
            // Función para actualizar la previsualización
            function actualizarPrevisualizacion(reportData) {
                let html = `
                    <div class="card">
                        <div class="card-header bg-primary text-white py-2">
                            <h4 class="h6 mb-0">Reporte De Ventas</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <div>
                                    <strong>Periodo:</strong> ${reportData.lblPeriodo}
                                </div>
                                <div>
                                    <strong>Tipo:</strong> ${reportData.lblTipoReporte}
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <strong>Categoría:</strong> ${reportData.lblCategoria}
                                </div>
                                <div>
                                    <strong>Empleado:</strong> ${reportData.lblEmpleado}
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <strong>Usuario:</strong> ${reportData.lblUsuario}
                                </div>
                                <div>
                                    <strong>Orden:</strong> ${reportData.lblOrdenarPor} (${reportData.lblOrden})
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="table-dark">
                `;
                
                if (reportData.tipoReporte === "1" || reportData.tipoReporte === "2") {
                    html += `
                        <tr>
                            <th width="10%">Cant.</th>
                            <th width="20%">Fecha</th>
                            <th width="40%">Empleado</th>
                            <th width="30%" class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    `;
                    
                    for (const v of reportData.ventas) {
                        html += `
                            <tr>
                                <td>${v.cantidad}</td>
                                <td>${formatter.fecha(v.fecha)}</td>
                                <td>${v.empleado}</td>
                                <td class="text-end">${formatter.currency(v.pago_total)}</td>
                            </tr>
                        `;
                        
                        if (reportData.tipoReporte === "2" && v.articulos && v.articulos.length > 0) {
                            for (const a of v.articulos) {
                                html += `
                                    <tr class="table-light">
                                        <td></td>
                                        <td colspan="2">${a.piezas} pza(s) - ${a.nombre}</td>
                                        <td></td>
                                    </tr>
                                `;
                            }
                        }
                    }
                } else if (reportData.tipoReporte === "3") {
                    html += `
                        <tr>
                            <th width="15%">ID</th>
                            <th width="20%">Cant.</th>
                            <th width="65%">Artículo</th>
                        </tr>
                    </thead>
                    <tbody>
                    `;
                    
                    for (const va of reportData.ventas) {
                        html += `
                            <tr>
                                <td>${va.id_articulo}</td>
                                <td>${va.piezas}</td>
                                <td>${va.nombre}</td>
                            </tr>
                        `;
                    }
                }
                
                html += `
                    </tbody>
                </table>
            </div>
        </div>
    </div>`;
                
                reportPreview.innerHTML = html;
            }
            
            // Evento para el botón de generar PDF
            btnGenerarPDF.addEventListener('click', generarPDF);
            
            // Actualizar previsualización al cambiar filtros
            const filtros = document.querySelectorAll('#reportType, #categorySelect, #employeeInput, #userSelect, #startDate, #endDate, #orderBy, #orderDirection');
            filtros.forEach(filtro => {
                filtro.addEventListener('change', function() {
                    const reportData = obtenerDatosReporte();
                    actualizarPrevisualizacion(reportData);
                });
            });
            
            // Inicializar previsualización
            const reportData = obtenerDatosReporte();
            actualizarPrevisualizacion(reportData);
        });
    </script>
</body>
</html>