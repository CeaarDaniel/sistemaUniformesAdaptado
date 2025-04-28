<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla con Detalles Expandibles</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        
        h1 {
            color: #333;
            text-align: center;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        
        /* Estilos para la tabla */
        #miTabla {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        #miTabla th {
            background-color: #f2f2f2;
            padding: 10px;
            text-align: left;
        }
        
        #miTabla td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        
        /* Estilos para las filas */
        tr.main-row:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }
        
        tr.expanded {
            background-color: #e7f4ff !important;
        }
        
        /* Estilos para la fila de detalles */
        tr.details-row {
            background-color: #f9f9f9;
        }
        
        tr.details-row td {
            padding: 15px;
        }
        
        .details-content {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .detail-item {
            flex: 1 1 200px;
            min-width: 200px;
        }
        
        .detail-item h4 {
            margin-top: 0;
            color: #444;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        
        .btn-ver {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }
        
        .btn-ver:hover {
            background-color: #45a049;
        }

        .bg-color{ 
            padding-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Inventario de Productos</h1>
        <table id="miTabla" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Talla</th>
                    <th>Género</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Los datos se cargarán con JavaScript -->
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
            // Datos de ejemplo
            const datos = [
                {
                    id: 1,
                    nombre: "Camiseta deportiva",
                    talla: "M",
                    genero: "Unisex",
                    stock: 45,
                    detalles: {
                        descripcion: "Camiseta de algodón para deporte",
                        color: "Azul marino",
                        material: "100% algodón",
                        proveedor: "Textiles S.A.",
                        costo: 15.99,
                        precio: 29.99,
                        fecha_ingreso: "2023-05-15"
                    }
                },
                {
                    id: 2,
                    nombre: "Pantalón jeans",
                    talla: "32",
                    genero: "Hombre",
                    stock: 28,
                    detalles: {
                        descripcion: "Jeans clásico ajustado",
                        color: "Azul oscuro",
                        material: "98% algodón, 2% elastano",
                        proveedor: "Denim Co.",
                        costo: 22.50,
                        precio: 49.99,
                        fecha_ingreso: "2023-06-10"
                    }
                },
                {
                    id: 3,
                    nombre: "Zapatos running",
                    talla: "42",
                    genero: "Mujer",
                    stock: 15,
                    detalles: {
                        descripcion: "Zapatillas para running con amortiguación",
                        color: "Negro/Rosa",
                        material: "Malla transpirable + suela de goma",
                        proveedor: "SportFoot Inc.",
                        costo: 35.75,
                        precio: 79.99,
                        fecha_ingreso: "2023-07-05"
                    }
                },
                {
                    id: 4,
                    nombre: "Zapatos running",
                    talla: "42",
                    genero: "Mujer",
                    stock: 15,
                    detalles: {
                        descripcion: "Zapatillas para running con amortiguación",
                        color: "Negro/Rosa",
                        material: "Malla transpirable + suela de goma",
                        proveedor: "SportFoot Inc.",
                        costo: 35.75,
                        precio: 79.99,
                        fecha_ingreso: "2023-07-05"
                    }
                },
                {
                    id: 5,
                    nombre: "Zapatos running",
                    talla: "42",
                    genero: "Mujer",
                    stock: 15,
                    detalles: {
                        descripcion: "Zapatillas para running con amortiguación",
                        color: "Negro/Rosa",
                        material: "Malla transpirable + suela de goma",
                        proveedor: "SportFoot Inc.",
                        costo: 35.75,
                        precio: 79.99,
                        fecha_ingreso: "2023-07-05"
                    }
                },
                {
                    id: 6,
                    nombre: "Zapatos running",
                    talla: "42",
                    genero: "Mujer",
                    stock: 15,
                    detalles: {
                        descripcion: "Zapatillas para running con amortiguación",
                        color: "Negro/Rosa",
                        material: "Malla transpirable + suela de goma",
                        proveedor: "SportFoot Inc.",
                        costo: 35.75,
                        precio: 79.99,
                        fecha_ingreso: "2023-07-05"
                    }
                },
                {
                    id: 7,
                    nombre: "Zapatos running",
                    talla: "42",
                    genero: "Mujer",
                    stock: 15,
                    detalles: {
                        descripcion: "Zapatillas para running con amortiguación",
                        color: "Negro/Rosa",
                        material: "Malla transpirable + suela de goma",
                        proveedor: "SportFoot Inc.",
                        costo: 35.75,
                        precio: 79.99,
                        fecha_ingreso: "2023-07-05"
                    }
                },
                {
                    id: 8,
                    nombre: "Zapatos running",
                    talla: "42",
                    genero: "Mujer",
                    stock: 15,
                    detalles: {
                        descripcion: "Zapatillas para running con amortiguación",
                        color: "Negro/Rosa",
                        material: "Malla transpirable + suela de goma",
                        proveedor: "SportFoot Inc.",
                        costo: 35.75,
                        precio: 79.99,
                        fecha_ingreso: "2023-07-05"
                    }
                },
                {
                    id: 9,
                    nombre: "Zapatos running",
                    talla: "42",
                    genero: "Mujer",
                    stock: 15,
                    detalles: {
                        descripcion: "Zapatillas para running con amortiguación",
                        color: "Negro/Rosa",
                        material: "Malla transpirable + suela de goma",
                        proveedor: "SportFoot Inc.",
                        costo: 35.75,
                        precio: 79.99,
                        fecha_ingreso: "2023-07-05"
                    }
                },
                {
                    id: 10,
                    nombre: "Zapatos running",
                    talla: "42",
                    genero: "Mujer",
                    stock: 15,
                    detalles: {
                        descripcion: "Zapatillas para running con amortiguación",
                        color: "Negro/Rosa",
                        material: "Malla transpirable + suela de goma",
                        proveedor: "SportFoot Inc.",
                        costo: 35.75,
                        precio: 79.99,
                        fecha_ingreso: "2023-07-05"
                    }
                },
                {
                    id: 11,
                    nombre: "Zapatos running",
                    talla: "42",
                    genero: "Mujer",
                    stock: 15,
                    detalles: {
                        descripcion: "Zapatillas para running con amortiguación",
                        color: "Negro/Rosa",
                        material: "Malla transpirable + suela de goma",
                        proveedor: "SportFoot Inc.",
                        costo: 35.75,
                        precio: 79.99,
                        fecha_ingreso: "2023-07-05"
                    }
                },
                {
                    id: 12,
                    nombre: "Zapatos running",
                    talla: "42",
                    genero: "Mujer",
                    stock: 15,
                    detalles: {
                        descripcion: "Zapatillas para running con amortiguación",
                        color: "Negro/Rosa",
                        material: "Malla transpirable + suela de goma",
                        proveedor: "SportFoot Inc.",
                        costo: 35.75,
                        precio: 79.99,
                        fecha_ingreso: "2023-07-05"
                    }
                }
            ];

            // Inicializar DataTable
            const table = $('#miTabla').DataTable({
                data: datos,
                columns: [
                    { data: 'id' },
                    { data: 'nombre' },
                    { data: 'talla' },
                    { data: 'genero' },
                    { 
                        data: 'stock',
                        render: function(data, type, row) {
                            if (type === 'display') {
                                if (data < 10) {
                                    return `<span style="color:red; font-weight:bold;">${data} (Bajo stock)</span>`;
                                } else if (data > 30) {
                                    return `<span style="color:green;">${data}</span>`;
                                }
                            }
                            return data;
                        }
                    },
                    { 
                        data: null,
                        render: function(data, type, row) {
                            return '<button class="btn-ver">Ver detalles</button>';
                        },
                        orderable: false
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    // Agregar clase para identificar filas principales
                    $(row).addClass('main-row');
                    
                    // Agregar atributo para identificar la fila
                    $(row).attr('data-id', data.id);
                }
            });

            // Manejar clic en fila principal
            $('#miTabla tbody').on('click', 'tr.main-row', function(e) {
                // Evitar que se active cuando se hace clic en el botón
                if ($(e.target).is('button')) return;
                
                toggleDetails($(this));
            });

            table.on('click', 'tbody tr', function() {
                // Mantener referencia a la página actual
                var currentPage = table.page();

                if (!$(this).hasClass('detalle')) { //Verificar si existe la clase 

                    table.rows('.detalle').remove().draw();
                    //alert("Datos de la fila:"+ $(this).text()+ ' Indice de la fila presionada: '+ table.row(this).index());

                    var nuevaFila =  {
                        id: table.row(this).index()+1,
                        nombre: "VALOR DE PRUEBA",
                        talla: "NA",
                        genero: "NA",
                        stock: 45,
                        detalles: {
                            descripcion: "NA",
                            color: "ANA",
                            material: "NA",
                            proveedor: "NA",
                            costo: 15.99,
                            precio: 29.99,
                            fecha_ingreso: "NA"
                        }
                    };
                    // Inserta la fila temporalmente al final
                    var nueva = table.row.add(nuevaFila).draw();

                    // Moverla a la posición deseada (por ejemplo, posición 2)
                    var indexDestino = (table.row(this).index());
                    var rowNode = nueva.node();

                    $(rowNode).insertAfter(table.row(indexDestino).node());
                    $(rowNode).addClass('detalle bg-color'); //Agregar la clase a la fila agregada
                    // $(rowNode).insertBefore(table.row(indexDestino).node());

                    table.page(currentPage).draw(false);
                }

                else {
                    table.rows('.detalle').remove().draw();
                    table.page(currentPage).draw(false);
                }
            })

            /*
                table.on('click', 'tbody tr', function() {
                                // Mantener referencia a la página actual
                                var currentPage = table.page();

                            if (!$(this).hasClass('detalle')) { //Verificar si existe la clase detalle

                                    // Eliminar filas de detalle existentes sin redibujar
                                        var detailRows = table.rows('.detalle').indexes();
                                        table.rows(detailRows).remove();

                                //table.rows('.detalle').remove().draw();
                                //alert("Datos de la fila:"+ $(this).text()+ ' Indice de la fila presionada: '+ table.row(this).index());

                                var nuevaFila =  {
                                    id: table.row(this).index()+1,
                                    nombre: "VALOR DE PRUEBA",
                                    talla: "NA",
                                    genero: "NA",
                                    stock: 43,
                                    detalles: {
                                        descripcion: "NA",
                                        color: "ANA",
                                        material: "NA",
                                        proveedor: "NA",
                                        costo: 15.99,
                                        precio: 29.99,
                                        fecha_ingreso: "NA"
                                    }
                                };
                                // Inserta la fila temporalmente al final
                            // var nueva = table.row.add(nuevaFila).draw();

                                // Insertar la fila sin redibujar
                                var nueva = table.row.add(nuevaFila).node();

                                // Moverla a la posición deseada (por ejemplo, posición 2)
                                var indexDestino = (table.row(this).index());
                                //var rowNode = nueva.node();

                                $(nueva).insertAfter(table.row(indexDestino).node());
                                $(nueva).addClass('detalle bg-color'); //Agregar la clase a la fila agregada
                                // $(rowNode).insertBefore(table.row(indexDestino).node());

                                table.page(currentPage).draw(false);
                            }

                            else {
                                table.rows('.detalle').remove().draw();
                                table.page(currentPage).draw(false);
                            }
                });
            */
    </script>
</body>
</html>