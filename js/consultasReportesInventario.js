     //LAS FUNCIONES DE ESTE CODIGO AUN NO FUNCIONAN
        const categoriaSelect = document.getElementById("categoria");
        const generarReporteBtn = document.getElementById("generarReporte");
        const tablaInventario = document.getElementById("tablaInventario");


        const categoriaCat = document.getElementById('categoriaCat');

        categoriaCat.addEventListener('change', function () {
            //history.pushState(null, '', `#/${categoriaCat.value}`);
            cargarRuta(categoriaCat.value)
        })

        function renderizarInventario() {
            const fromDataReportes = new FormData();
            fromDataReportes.append('opcion', '8')
            fromDataReportes.append('categoria', categoriaSelect.value)
            var ancho = document.getElementById('tableContainer').offsetWidth;

            fetch("./api/consultas.php", {
                method: "POST",
                body: fromDataReportes,
            })
                .then((response) => response.json())
                .then((data) => {

                    //$('#ventasTotales').text('$ ' + parseFloat(data.promedio.ventasTotales).toLocaleString('en-US', {minimumFractionDigits: 2,
                    //maximumFractionDigits: 2}));

                    $('#tablaInventario').DataTable().destroy(); //Restaurar la tablas
                    const table = $('#tablaInventario').DataTable({
                        responsive: true,
                        scrollX: ancho- 20,
                        scrollY: 500,
                        scrollCollapse: true,
                        data: data,
                        columns: [
                            { "data": "id_articulo" },
                            { "data": "nombre" },
                            { "data": "costo" },
                            { "data": "precio" },
                            { "data": "cantidad" },
                            { "data": "stock_min" },
                            { "data": "stock_max" },
                        ],
                        columnDefs: [
                            {
                                targets: [0, 1, 2, 3, 4, 5, 6],
                                className: 'text-center'
                            }
                        ]
                    })
                })
        .catch((error) => {
            console.log(error);
        });
        }

        generarReporteBtn.addEventListener("click", renderizarInventario);

        // Renderizar el inventario al cargar la página
       renderizarInventario();