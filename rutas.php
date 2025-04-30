<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>SPA con JS</title>
</head>
<body>
  <nav>
    <button href="inicio" onclick="navegar('inicio')">Inicio</button>
    <button href="acerca" onclick="navegar('acerca')">Acerca</button>
    <button href="contacto" onclick="navegar('contacto')">Contacto</button>
  </nav>

  <div id="contenido"></div>

  <script>

    /*
      const updateView = (route) => {
        const content = document.getElementById('content'); // Donde se mostrará el contenido
        switch (route) {
          case '#home':
            content.innerHTML = '<h1>Home</h1><p>Contenido de la página principal.</p>';
            break;
          case '#about':
            content.innerHTML = '<h1>Acerca de</h1><p>Contenido de la página "Acerca de".</p>';
            break;
          default:
            content.innerHTML = '<h1>Error</h1><p>Página no encontrada.</p>';
            break;
        }
      };

      // Inicializar la vista al cargar la página
      updateView(window.location.hash);

      // Manejar cambios en la URL
      window.addEventListener('hashchange', () => {
        updateView(window.location.hash);
      });

      // Crear enlaces navegables
      document.getElementById('homeLink').addEventListener('click', () => {
        window.location.hash = 'home';
      });

      document.getElementById('aboutLink').addEventListener('click', () => {
        window.location.hash = 'about';
      });
    */  

    /*
      const navEntries = performance.getEntriesByType("navigation");
      if (navEntries.length > 0 && navEntries[0].type === "reload") {
        console.log("La página fue recargada (reload)");
      } 
    */


  //Funcion para obtener la pagina actual
    function obtenerSeccionActual() {
      //const rutaActual = location.pathname.replace(/^\/+/, ""); // elimina la barra inicial
      const hash = location.hash.split('/'); // Ej: "#/paginaActual" window.location.hash.split('/');
      return hash[hash.length - 1];  // "paginaActual"
    }

    // Función que carga contenido y cambia la URL
    function navegar(pagina) {
        const seccionActual = obtenerSeccionActual();

            if (seccionActual === pagina) 
                return;
            

      // Cambiar la URL (sin recargar)
      history.pushState({ seccionActual }, "", `/sistemaUniformesAdaptado/#/${pagina}`);
      
      window.dispatchEvent(new HashChangeEvent('hashchange'));

      // Cargar el contenido según la ruta
      cargarContenido(pagina);
    }

    // Función para mostrar contenido dinámico
    function cargarContenido(pagina) {
      const contenido = document.getElementById("contenido");
      console.log("Ruta actual history:" + nuevaSeccion)
      
      switch (pagina) {
        case "inicio":
          contenido.innerHTML = "<h1>Página de Inicio</h1><p>Bienvenido a nuestra SPA.</p>";
          break;
        case "acerca":
          contenido.innerHTML = "<h1>Acerca de</h1><p>Esta es la sección acerca de nosotros.</p>";
          break;
        case "contacto":
          contenido.innerHTML = "<h1>Contacto</h1><p>Contáctanos al correo info@ejemplo.com</p>";
          break;
        default:
          contenido.innerHTML = "<h1>404</h1><p>Página no encontrada.</p>";
          break;
      }
    }

    // Detectar el botón "atrás" o "adelante" del navegador
    
    window.addEventListener("popstate", (event) => {
       const nuevaSeccion = obtenerSeccionActual();
      cargarContenido(nuevaSeccion)
    });

    // Cargar la página correcta al cargar la SPA
    window.addEventListener("DOMContentLoaded", () => {
      //const ruta = location.pathname.slice(1) || "inicio";
      const seccion = obtenerSeccionActual();
      cargarContenido(seccion);
    });


    window.addEventListener('hashchange', () => {
      const nuevaSeccion = obtenerSeccionActual();
      cargarContenido(nuevaSeccion)
      // Aquí puedes cargar el contenido correspondiente
    });

  </script>
</body>
</html>