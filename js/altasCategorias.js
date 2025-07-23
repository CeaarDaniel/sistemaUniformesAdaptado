// Variables globales
let tallasAlta = [];
let mostrarAltaTallas = false;
let mostrar = false;
var btnAgregarCategoria = document.getElementById('btnAgregarCategoria');
var btnCrearCategoria = document.getElementById('btnCrearCategoria')
var tipoTalla = document.getElementById('tipoTalla');
var nombre = document.getElementById('nombre');  
var abrev = document.getElementById('abrev');
var btnChangeTalla = document.getElementById('btnChangeTalla');
var tallaLabel = document.getElementById('tallaLabel');
const modalConfirmar = new bootstrap.Modal(document.getElementById('confirmModal'));

//VALORES PARA LA ACTIVACION DEL BOTON DD CREAR CATEGORIA
let nombreB = false;
let abrevB = false;

btnAgregarCategoria.addEventListener('click', confirmarAgregarCategoria);
btnCrearCategoria.addEventListener  ('click', agregarCategoria);
nombre.addEventListener('change', validarCategoria);  
tipoTalla.addEventListener('change', mostrarTallas); 
abrev.addEventListener('change', validarAbrev);
btnChangeTalla.addEventListener('click', mostrarTallaAltas);
tallaLabel.addEventListener('keydown', function (event) {
    if (event.key === 'Enter') {
      event.preventDefault(); // Prevenimos el envío del formulario
      agregarChipTalla();
  }
});


// Función para mostrar/ocultar la sección de tallas
function mostrarTallaAltas() {
    const tallasExistente = document.getElementById('tallasExistente');
    const tallasNuevas = document.getElementById('tallasNuevas');
    mostrar = !mostrar;
    if (mostrar) { //True deve mostrar la seccion de crear tallas
        tallasExistente.style.display = 'none';
        tallasNuevas.style.display = 'block';
        mostrarAltaTallas = true;
        btnChangeTalla.textContent= 'ESCOGER TALLAS';
    } else { //False debe mostrar la seccion de seleccionar tallas
        tallasExistente.style.display = 'block';
        tallasNuevas.style.display = 'none';
        mostrarAltaTallas = false;
        tallasAlta = []; //Se reinicia/limpia el arreglo de las tallas si se cambia al modo de seleccionar talla
        btnChangeTalla.textContent= 'CREAR TALLAS';
        actualizarTallasAltaChips();
    }
}

// Función para agregar una talla
function agregarChipTalla() {
  //Se modifican las cadenas a mayusculas para que sea indistinto valores como Xsd y xSD en la busqueda del valor en el arreglo tallasAlta
  if (!tallasAlta.some(item => ((item.label).toUpperCase()).trim() === ((tallaLabel.value).toUpperCase()).trim()) ) { //Se usa tallasAlta some ya que el arreglo es un objeto de pares clave valor 
        if (tallaLabel.value.trim() !== '') { //Evalua si no esta vacio el input de la talla
          tallasAlta.push({ label: (tallaLabel.value).trim(), estado: true }); //Agregamos el valor del input sin los espacios que se hayan ingresado al final o al inicio (tallaLabel.value).trim()
          tallaLabel.value = ''; //Se limpia el input donde se agrega la talla
          actualizarTallasAltaChips();
      }
  }
    else alert('Ya existe este registro');
}

// Función para remover una talla
function removerChipTalla(label) {
    tallasAlta.splice(label, 1);
    actualizarTallasAltaChips();
}

// Función para actualizar los chips de tallas
function actualizarTallasAltaChips() { //Esta funcion actualiza la vista de las tallas despues de agregar o eliminar una talla
    const container = document.getElementById('tallasAltaChips');
    container.innerHTML = tallasAlta.map((t, index) => `
        <div class="chip px-3 py-1" style="background-color:rgb(25, 118, 210); color:white; border-radius:15px">
            ${t.label} <span class="remove-icon" data-index= ${index}>×</span>
        </div>
    `).join(''); //Se agrega el indice (index) para poder eliminar mas facil lo elemetnos del arreglo

    const removeIcons = container.querySelectorAll('.remove-icon');

    removeIcons.forEach(icon => {
        icon.addEventListener("click", function(event) {
            event.preventDefault();
            // Remover el chip correspondiente
            const label = icon.getAttribute("data-index");
            removerChipTalla(label);
        });
    });
}

// Función para confirmar la agregación de la categoría
function confirmarAgregarCategoria() {
    const nombre = document.getElementById('nombre').value;
    if (nombre.trim() === '') { //Evalua si no esta vacio el input de nombre
        alert('El nombre de la categoría no puede estar vacío.');
        return;
    }
    if (mostrarAltaTallas && tallasAlta.length === 0) { //Si se selecciona la opcion de crear tallas mostrarAltasTallas cambia a true, por lo que si es true el arreglo tallasAlta debe de tener porlomenos una talla osea un un valor en el array
        alert('Debes agregar al menos una talla.');
        return;
    }
    else if(!mostrarAltaTallas && tipoTalla.value == -1) {
      alert('Debes seleccionar una talla');
      //console.log(tipoTalla.value)
      return;
    }
    document.getElementById('nombreCategoria').textContent = nombre;
    modalConfirmar.show();
}

//Funcion para mostrar las tallas correspondientes a la categoria seleccionada
function mostrarTallas(){
    var formData = new FormData;
    var tallasChips = document.getElementById('tallasChips');
    var tipoTalla = document.getElementById('tipoTalla'); 

  formData.append("tipoTalla", tipoTalla.value);
  formData.append("opcion", "1");

  fetch("./api/altas.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      var tallas='';
      data.forEach( option => {
        tallas += ` <div class="px-3 py-1" style="background-color:rgb(25, 118, 210); color:white; border-radius:15px"> ${option['talla']} </div>`;
        })

         tallasChips.innerHTML = tallas
    })
    .catch((error) => {
      console.log(error);
    });
}

//Funcior para validar el duplicado del nombre de la categoria
function validarCategoria(){
    var nombreHelpText = document.getElementById('nombreHelpTextC');
    var formData = new FormData;
  
    formData.append("categoria", nombre.value);
    formData.append("opcion", "3");
  
    fetch("./api/altas.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.exist == '1') {
            nombreHelpText.innerHTML = '<span class="text-danger">El nombre de la categoría ya está dado de alta en el sistema</span>';
               nombreB = true;
          }
        
        else {
          nombreHelpText.innerHTML = 'Ej. Camisa Manga Larga';
             nombreB = false
        }

        $('#btnAgregarCategoria').prop('disabled', (Boolean(nombreB) || Boolean(abrevB)) ? true : false);
       // console.log(Boolean(nombreB * abrevB))
      })
      .catch((error) => {
        console.log(error);
      });
}

//Funcion para validar el duplicado del nombre abreviado
function validarAbrev(){
        var nombreHelpTextA = document.getElementById('nombreHelpTextA');        
        var formData = new FormData;

        //CONVERTIR LA AVREVIATURA A MAYÚSCULAS
        abrev.value = abrev.value.toUpperCase();
      
        formData.append("abrev", abrev.value);
        formData.append("opcion", "4");
      
        fetch("./api/altas.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.exist == '1') {
                nombreHelpTextA.innerHTML = '<span class="text-danger">La abreviatura de la categoría ya está dada de alta en el sistema</span>';
                    abrevB = true; //deshabilita el boton
              }
            
            else {
                nombreHelpTextA.innerHTML = 'Ej. CAMISA ML (visible para el nombre del artículo)';
                    abrevB = false;  //habilita el boton
            }

            $('#btnAgregarCategoria').prop('disabled', (Boolean(nombreB) || Boolean(abrevB)) ? true : false);
            //console.log(Boolean(nombreB * abrevB))
          })
          .catch((error) => {
            console.log(error);
          });
}

// Función para agregar la categoría
function agregarCategoria() {
    const nombre = document.getElementById('nombre').value;
    const abrev = document.getElementById('abrev').value;
    const tipoTalla = document.getElementById('tipoTalla').value;
    console.log(tallasAlta)
      var formData = new FormData; 
      formData.append("nombre", nombre);
      formData.append("abrev", abrev);
      formData.append("tallas", (mostrar) ? JSON.stringify(tallasAlta) : tipoTalla); //false Seleccoinar tallas TRUE )crear tallas
      formData.append("opcion", "5");

      fetch("./api/altas.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.json())
          .then((data) => {
                alert(data.response);
               location.reload();
          })
          .catch((error) => {
            console.log(error);
          });
    
    modalConfirmar.hide();
}

  