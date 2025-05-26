 var tabla= $('#tableArticulos').DataTable();

 // Función para renderizar la tabla
    function renderTable() {
        var ancho = window.innerWidth;

        var formData = new FormData;
        formData.append("opcion", "3");
    
        fetch("./api/almacen.php", {
                method: "POST",
                body: formData,
            })
            .then((response) => response.json())
            .then((data) => {
                                $('#tableArticulos').DataTable().destroy(); //Restaurar la tablas
                
                                //Crear el dataTable con las nuevas configuraciones
                                 $('#tableArticulos').DataTable({
                                    responsive: true,
                                    scrollX: '100%',
                                    scrollY: 370,
                                    scrollCollapse: true,
                                    data: data,
                                    columns: [
                                        { "data": "id_articulo" },  
                                        { "data": "nombre" },
                                        { "data": "clave_comercial" },
                                        { "data": "descripcion" },
                                        { "data": "precio" }, 
                                        { "data": "costo" }, 
                                        { "data": "stock_min" },
                                        { "data": "stock_max" },
                                        { "data": "cantidad" }
                                    ],
                                    columnDefs: [
                                        {
                                            targets: [2,3,4,5,6,7,8], // Índice de la columna que quieres modificar (empieza desde 0)
                                            className: 'editColum' // Puedes aplicar una clase CSS
                                        },
                                        {
                                            targets:[0,1,2,3,4,5,6,7,8],
                                            className: 'text-center'
                                        }
                                    ],
                                    "initComplete": function(settings, json) {
                                        // Asignar el evento a las celdas de la tabla
                                        tabla.on('click', 'td', function() {
                                            var cell= $(this); //OBTENER LOS VALORES DEL ELEMENTO PRESIONADO
                                            var cellValue = $(this).text() //GUARDAMOS EL CONTENIDO DEL ELEMENTO
                                            var columnIndex = cell.index();
                                            var columnasPermitidas = [2, 3, 4, 5, 6, 7, 8]; // Índices de las columnas que pueden editarse
                                            
                                            //Id del articulo modificado
                                            var valorColumna0 = cell.closest('tr').find('td').eq(0).text();
                                            var campoModificado = "";

                                            if (columnasPermitidas.includes(columnIndex)) {

                                                switch (columnIndex){
                                                    case 2:  
                                                            //Evaluar que no exista el input, si no reiniciara los valroes de la celda al presionar clic sobre el input
                                                            if (cell.find('input').length === 0) {
                                                                //Creamos el input
                                                                var input = $('<input>', {
                                                                    type: 'text',
                                                                    value: cellValue,
                                                                    maxlength: "20",
                                                                    style:"max-width: 100px;",
                                                                    class: 'm-0 p-0' // Puedes añadir clases para el estilo
                                                                });
                                                            }
                                                            campoModificado= "clave_comercial";
                                                        break;
                                                    
                                                    case 3:
                                                            //Evaluar que no exista el input, si no reiniciara los valroes de la celda al presionar clic sobre el input
                                                            if (cell.find('input').length === 0) {
                                                                //Creamos el input
                                                                var input = $('<input>', {
                                                                    type: 'text',
                                                                    value: cellValue,
                                                                    maxlength: "100",
                                                                    style:"width:100%;",
                                                                    class: 'm-0 p-0' // Puedes añadir clases para el estilo
                                                                });
                                                            }
                                                            campoModificado= "descripcion";
                                                    break;

                                                    case 4: case 5:
                                                         //Evaluar que no exista el input, si no reiniciara los valroes de la celda al presionar click sobre el input
                                                         if (cell.find('input').length === 0) {
                                                            //Creamos el input
                                                            var input = $('<input>', {
                                                                type: 'number',
                                                                value: cellValue,
                                                                min: 0,
                                                                step : 0.01,
                                                                style:"max-width: 100px;",
                                                                class: 'm-0 p-0' // Puedes añadir clases para el estilo
                                                            });
                                                        }
                                                        campoModificado= (columnIndex == 4) ? "precio" : "costo";
                                                    break;
                                                    case 6: case 7: case 8:
                                                         //Evaluar que no exista el input, si no reiniciara los valroes de la celda al presionar click sobre el input
                                                         if (cell.find('input').length === 0) {
                                                            //Creamos el input
                                                            var input = $('<input>', {
                                                                type: 'number',
                                                                value: cellValue,
                                                                min: 0,
                                                                step : 1,
                                                                style:"max-width: 100px;",
                                                                class: 'm-0 p-0' // Puedes añadir clases para el estilo
                                                            });
                                                        }

                                                        campoModificado = (columnIndex == 6) ? "stock_min" : `${(columnIndex == 7) ? "stock_max" : "cantidad"}`;
                                                    break;
                                                }
                                                
                                                cell.html(input); //Modificamos el contenido del html es com un inner.Html

                                                // Establecer el foco en el input para que el usuario pueda editar
                                                input.focus();

                                                // Cuando el usuario termine de editar y presione Enter o pierda el foco
                                                input.on('blur', function() {
                                                    var newValue = input.val(); // Obtener el valor actualizado
                                                    //console.log(columnIndex); indice de la colimna cero

                                                    if(newValue == '' || newValue == null || newValue.trim() === "" || newValue === cellValue) 
                                                            cell.html(cellValue);

                                                    else 
                                                        if( (columnIndex == 4  || columnIndex == 5  || columnIndex == 6 || columnIndex == 7  || columnIndex == 8) && Number(newValue) < 0)
                                                            cell.html(cellValue);
                                                            
                                                    else 
                                                        {
                                                            var actualizar = confirm("Esta seguro que desea modificar este campo?");
                                                            if (actualizar) {
                                                                //El valor del precio y el costo solo debe contener 2 decimales
                                                                    if(columnIndex == 4 || columnIndex == 5)  newValue =  Number(newValue).toFixed(2)

                                                                    else 
                                                                        //Los valoes de costo stock min y stock max, no deben de contener decimales por lo que se truncan
                                                                        if(columnIndex == 6 || columnIndex == 7 || columnIndex == 8)
                                                                             newValue = Math.trunc(Number(newValue)); 
                                                                            //Math.round(Number(newValue));

                                                                    cell.html(newValue); // Reemplazar el input por el nuevo valor
                                                                    console.log(campoModificado+":"+newValue) 
                                                                }
                                                            else
                                                                cell.html(cellValue);
                                                        }
                                                });

                                                //escuchar el evento 'Enter' para confirmar la edición
                                                input.on('keypress', function(event) {
                                                    if (event.which === 13) { // Tecla Enter
                                                        var newValue = input.val(); // Obtener el valor actualizado
                                                         if(newValue == '' || newValue == null || newValue.trim() === "" || newValue === cellValue)
                                                                  cell.html(cellValue);

                                                        else 
                                                           {
                                                                var actualizar = confirm("Esta seguro que desea modificar este campo?");

                                                                if (actualizar)
                                                                    cell.html(newValue); // Reemplazar el input por el nuevo valor

                                                                else
                                                                    cell.html(cellValue);
                                                            }
                                                    } 
                                                })   
                                            }                                            
                                        });
                
                                    }
                                });
            })
            .catch((error) => {
            console.log(error);

            $('#tablaArticulos').DataTable().clear();
            $('#tablaArticulos').DataTable().destroy();
            $('#tablaArticulos').DataTable();
        });
    }

    renderTable();