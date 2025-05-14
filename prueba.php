<!DOCTYPE html>
<html>
<head>
    <link href="https://unpkg.com/tabulator-tables@5.4.4/dist/css/tabulator.min.css" rel="stylesheet">
</head>
<body>
    <div id="table"></div>

    <h3>Agregar Artículo:</h3>
    <input type="text" id="id" placeholder="ID">
    <input type="text" id="nombre" placeholder="Nombre">
    <input type="text" id="tipo" placeholder="Tipo">
    <input type="number" id="cantidad" placeholder="Cantidad">
    <input type="number" id="precio" placeholder="Precio">
    <button onclick="agregarArticulo()">Agregar</button>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/tabulator-tables@5.4.4/dist/js/tabulator.min.js"></script>

    <script>
        // Fuente de datos inicial
        let datos = [
            {id: 1, nombre: "Camisa", tipo: "Superior", cantidad: 5, precio: 25},
            {id: 2, nombre: "Jeans", tipo: "Pantalón", cantidad: 3, precio: 45}
        ];

        // Configurar Tabulator
        const table = new Tabulator("#table", {
            data: datos,
            layout: "fitColumns",
            columns: [
                {title: "ID", field: "id"},
                {title: "Nombre", field: "nombre"},
                {title: "Tipo", field: "tipo"},
                {title: "Cantidad", field: "cantidad"},
                {title: "Precio", field: "precio"},
                {
                    title: "Acciones",
                    formatter: "buttonCross",
                    cellClick: function(e, cell) {
                        eliminarArticulo(cell.getRow().getData().id);
                    }
                }
            ]
        });

        // Función para eliminar artículo
        function eliminarArticulo(id) {
            datos = datos.filter(item => item.id !== id);
            table.setData(datos);
        }

        // Función para agregar/actualizar artículo
        function agregarArticulo() {
            const nuevoArticulo = {
                id: Number(document.getElementById("id").value),
                nombre: document.getElementById("nombre").value,
                tipo: document.getElementById("tipo").value,
                cantidad: Number(document.getElementById("cantidad").value),
                precio: Number(document.getElementById("precio").value)
            };

            // Validar campos
            if (!Object.values(nuevoArticulo).every(Boolean)) {
                alert("Todos los campos son obligatorios!");
                return;
            }

            // Buscar si el ID ya existe
            const articuloExistente = datos.find(item => item.id === nuevoArticulo.id);

            if (articuloExistente) {
                // Si existe, sumar cantidad
                articuloExistente.cantidad += nuevoArticulo.cantidad;
            } else {
                // Si no existe, agregar nuevo
                datos.push(nuevoArticulo);
            }

            // Actualizar tabla y limpiar formulario
            table.setData(datos);
            document.querySelectorAll("input").forEach(input => input.value = "");
        }
    </script>
</body>
</html>