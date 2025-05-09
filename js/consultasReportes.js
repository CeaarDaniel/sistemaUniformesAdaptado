    const generarReporteBtn = document.getElementById("generarReporte");
    const tituloReporte = document.getElementById("tituloReporte");
    const ventasTotales = document.getElementById("ventasTotales");
    const numVentas = document.getElementById("numVentas");
    const ventaPromedio = document.getElementById("ventaPromedio");
    const ventasDiarias = document.getElementById("ventasDiarias");
    const ventasCategoria = document.getElementById("ventasCategoria");
    const gananciasCategoria = document.getElementById("gananciasCategoria");
    const gananciaTotal = document.getElementById("gananciaTotal");
    const categoriaCat = document.getElementById('categoriaCat');

    const grupoFecha = document.getElementById('grupoFecha')
    const anio = document.getElementById('anio') 
    const mes = document.getElementById('mes')

    $(window).on('resize', function () {
        renderizarReporte();
    });

    categoriaCat.addEventListener('change', function () {
        //history.pushState(null, '', `#/${categoriaCat.value}`);
        cargarRuta(categoriaCat.value)
    })

    function renderizarReporte() {
        // Actualizar título
        tituloReporte.textContent = "Ventas de Octubre del 2023";

        const fromDataReportes = new FormData();
        fromDataReportes.append('anio', anio.value)
        fromDataReportes.append('mes', mes.value)
        fromDataReportes.append('grupoFecha', grupoFecha.value)
        fromDataReportes.append('opcion', '7')

        /*
         // Iterar sobre los datos y crear una fila para cada artículo
                data.forEach(dato => {
                    const fila = document.createElement("tr");
                    
                    //var costo = parseFloat(parseFloat(dato.costo).toFixed(2));
                    //var costoFormateado = costo.toLocaleString('en-US');
                    fila.innerHTML =
                    `<td>${dato.id_articulo}</td>
                     <td>${dato.cantidad}</td>
                     <td>${ (dato.nombre == null) ? 'N/A' : dato.nombre}</td>
                     <td>${ (dato.precio == null) ? 'N/A' : `$ ${(parseFloat(dato.precio)).toFixed(2)}` }</td>
                     <td>${ (dato.total == null) ? 'N/A' : `$ ${(parseFloat(dato.total)).toFixed(2)}` }</td>`;
                    t.appendChild(fila);

                    total = total +  parseFloat( (dato.total == null) ? 0 : dato.total);
                }); 

                document.getElementById('totalCostoSalida').textContent = `       $ ${ parseFloat(total.toFixed(2)).toLocaleString('en-US') }`;
                new bootstrap.Modal(document.getElementById('verSalidaModal')).show();
        */


        fetch("./api/consultas.php", {
            method: "POST",
            body: fromDataReportes,
        })
        .then((response) => response.json())
        .then((data) => {                
            console.log(data.promedio.ventasTotales)
            console.log(data.ventas);
            $('#ventasTotales').text('$ ' + parseFloat(data.promedio.ventasTotales).toLocaleString('en-US', {minimumFractionDigits: 2,
                                                                                maximumFractionDigits: 2}));
            $('#numVentas').text('$ ' + parseFloat(data.promedio.numVentas).toLocaleString('en-US', {minimumFractionDigits: 2,
                                                                                maximumFractionDigits: 2}));
            $('#ventaPromedio').text('$ ' + parseFloat(data.promedio.ventasPromeio).toLocaleString('en-US', {minimumFractionDigits: 2,
                                                                                maximumFractionDigits: 2}));

            $('#ventasDiariasTabla').DataTable().destroy(); //Restaurar la tablas
            const table = $('#ventasDiariasTabla').DataTable({
                 responsive: true,
                 scrollX: (document.getElementById('tableContainer').offsetWidth),
                 scrollY: 500,
                 scrollCollapse: true,
                 data: data.ventas,
                 columns: [
                     { "data": "fecha" },  
                     { "data": "ventaTotal" },
                 ], 
                 columnDefs: [
                    {
                        targets: [0,1],
                        className: 'text-center'
                    }
                ]
                })
        })
        .catch((error) => {
            console.log(error);
        });


           fromDataReportes.append('opcion', '6')

        //TABLA DE GANANCIAS Y VENTAS POR CATEGORIA
        fetch("./api/consultas.php", {
            method: "POST",
            body: fromDataReportes,
        })
        .then((response) => response.json())
        .then((data) => {   
            $('#gananciaTotal').text("$ "+parseFloat((data[0].gananciaTotal)).toLocaleString('en-US', {minimumFractionDigits: 2,
                                                                                maximumFractionDigits: 2}));             
            const ancho = gananciasCategoria.offsetWidth;

             $('#tablaGanVenCategorias').DataTable().destroy(); //Restaurar la tablas

             //Crear el dataTable con las nuevas configuraciones
             $('#tablaGanVenCategorias').DataTable({
                 responsive: true,
                 scrollX: ancho,
                 scrollY: 500,
                 scrollCollapse: true,
                 data: data,
                 columns: [
                     { "data": "categoria" },  
                     { "data": "costoPromedio" },
                     { "data": "costoVenta" },
                     { "data": "costoCompra" },
                     { "data": "gananciaPorCategoria" }, 
                 ], 
                 columnDefs: [
                     {
                         targets: [0,1,2,3,4],
                         className: 'text-center'
                     },
                     {
                        targets:[1,2,3,4], 
                        render: function(dato, type, row) {
                            if (type === 'display' || type === 'filter') {
                                return (parseFloat(dato).toLocaleString('en-US', {minimumFractionDigits: 2,
                                                                                maximumFractionDigits: 2}));
                            }
                            return dato;  // Si no es para mostrar, devuelve la fecha tal cual
                        }
                     }
                 ],
                 
             });
            })
        .catch((error) => {
            console.log(error);
        });
        
    }

    generarReporteBtn.addEventListener("click", renderizarReporte);

    // Renderizar el reporte al cargar la página
    renderizarReporte();