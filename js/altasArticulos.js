  // Función para actualizar el nombre del artículo
  function modificarNombre() {
    const categoria = (document.getElementById('categoria').options[document.getElementById('categoria').selectedIndex]).getAttribute('data-abrev');
    const talla = document.getElementById('talla').options[document.getElementById('talla').selectedIndex].text;
    const genero = document.getElementById('genero').options[document.getElementById('genero').selectedIndex].text;
    const estado = document.getElementById('estado').options[document.getElementById('estado').selectedIndex].text;

    const nombre = `${categoria}-${genero==='No aplica' ? '' : `${genero} `}T ${talla} ${estado === 'Usado' ? '(usado)' : ''}`;
    document.getElementById('nombre').value = nombre; //Se cambia el valor del input nombre
    document.getElementById('nombreArticulo').textContent = nombre; //Se cambia el valor del nombreArticulo mostrado en el modal de confirmación

    //Si el uiforme es usado se bloquean los inputs 
    if (document.getElementById('estado').value == '2')
          {

            document.getElementById('stock_max').value = 0
            $('#stock_max').prop('readonly', true);

            document.getElementById('stock_min').value = 0
            $('#stock_min').prop('readonly', true);

            document.getElementById('costo').value = 0
            $('#costo').prop('readonly', true);

            document.getElementById('precio').value = 0
            $('#precio').prop('readonly', true);
          }

          else {
            $('#stock_max').prop('readonly', false);
            $('#stock_min').prop('readonly', false);
            $('#costo').prop('readonly', false);
            $('#precio').prop('readonly', false);
          }

      validarNombre();
}

//Funcion para actualizar los valores de select de talla
function modificarTalla(){
  var categoria = document.getElementById('categoria');  
  var tipoTalla = (categoria.options[categoria.selectedIndex]).getAttribute('data-tipoTalla'); 
  

  var formData = new FormData;

  formData.append("tipoTalla", tipoTalla);
  formData.append("opcion", "1");

  fetch("./api/altas.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      var optionTallas='';

      data.forEach( option => {
          optionTallas+= `<option value ="${option['id_talla']}"> ${option['talla']} </option> `;
         })

         document.getElementById('talla').innerHTML = optionTallas;
         //Se llama la funcion modificarNombre para que al cambiar de categoria se actualice en el nombre la talla que coresponde a la categoria
         modificarNombre(); //De no hacer esto se actualiza el nombre pero se queda con la talla de la cateogira anterior 
    })
    .catch((error) => {
      console.log(error);
    });
}
// Función para guardar el artículo
function guardarArticulo() {
    alert('Artículo guardado correctamente');
    // Aquí puedes agregar la lógica para enviar los datos al servidor
}

//Funcion palidar el duplicado del nombre del articulo
function validarNombre(){
  var nombre = document.getElementById('nombre');  
  var nombreHelpText = document.getElementById('nombreHelpText');
  var formData = new FormData;

  formData.append("nombre", nombre.value);
  formData.append("opcion", "2");

  fetch("./api/altas.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.exist == '1') {
          nombreHelpText.innerHTML = '<span class="text-danger">El artículo ya está dado de alta en el sistema</span>';
          $('#btnCrearArticulo').prop('disabled', true);
        }
      
      else {
        nombreHelpText.innerHTML = 'El nombre se genera automáticamente';
        $('#btnCrearArticulo').prop('disabled', false);
      }
    })
    .catch((error) => {
      console.log(error);
    });
}

// Event listeners para actualizar el nombre
document.getElementById('categoria').addEventListener('change', modificarNombre);
document.getElementById('talla').addEventListener('change', modificarNombre);
document.getElementById('genero').addEventListener('change', modificarNombre);
document.getElementById('estado').addEventListener('change', modificarNombre);

document.getElementById('categoria').addEventListener('change', modificarTalla);
document.getElementById('nombre').addEventListener('change', validarNombre);
modificarTalla();

setTimeout(modificarNombre, 1000)