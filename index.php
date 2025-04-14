<!DOCTYPE html>
<html dir="ltr" lang="es">
<head>
    <title>Sistema Uniformes</title>
    <meta charset="utf-8">
    <meta name="description" content="A Quasar Framework app">
    <meta name="format-detection" content="telephone=no">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="viewport" content="user-scalable=no,initial-scale=1,maximum-scale=1,minimum-scale=1,width=device-width">
   
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <link rel="icon" type="image/ico" href="logo_b.png">
    <link rel="icon" type="image/ico" href="logo_b.png">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome (para íconos) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
   
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Estilos personalizados -->
    <link rel="icon" type="image/ico" href="logo_b.png">
    <link href="./style.css" rel="stylesheet">

    <!--Libreria Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!--Data table -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>

    <!-- 
    <link href="css/vendor.df1fcf64.css" rel="stylesheet">
    <link href="css/app.0ed4cc44.css" rel="stylesheet">
    
        <link rel="stylesheet" type="text/css" href="css/20.03feb41f.css">
        <link rel="stylesheet" type="text/css" href="css/chunk-common.5c332fd6.css">
        <link rel="stylesheet" type="text/css" href="css/9.c78d85dd.css">
        <link rel="stylesheet" type="text/css" href="css/16.1081afea.css"> 
    -->
</head>
<body style="background-color: #f7f7f7">
    <div id="q-app" >


        <?php include('navBar.php') ?>

            <!-- Contenido principal -->
            <div id="mainContent" class="q-page-container padding-header">
                <div id="dashboard">
                    <?php include('dashboard.php') ?>
                </div>
            </div>
    </div>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <!-- Libreria Jquery! -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.print.min.js"></script>

    <script>
        //Funcion para la navegacion entre ventanas
      

        function navegar(pagina, id, pagsus) {
            var contenido = document.getElementById(pagsus);
            var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        window.scroll(0, 0);
                        contenido.innerHTML = this.responseText;
                        
                        // Eliminar el script anterior si existe
                        var oldScript = document.getElementById('jsDinamico');
                        if (oldScript) oldScript.remove();

                        // Verificar si el archivo JS existe antes de cargarlo
                        var scriptUrl = `./js/${pagina}.js`;
                        fetch(scriptUrl, { method: 'HEAD' })
                            .then(response => {
                                if (response.ok) {
                                    // Cargar el script envuelto en un IIFE
                                    return fetch(scriptUrl);
                                } else {
                                    //throw new Error('El archivo JS no existe');
                                    console.log(`Script no encontrado: ${scriptUrl}`);
                                }
                            })
                            .then(response => response.text())
                            .then(scriptText => {
                                var script = document.createElement('script');
                                script.id = 'jsDinamico';
                                // Envolver el script en una función autoejecutable
                                script.textContent = `(function() { ${scriptText} })();`;
                                document.body.appendChild(script);
                                renderTable();
                            })
                            .catch(error => {
                                console.log(`Script no encontrado: ${scriptUrl}`);
                            });
                    }
                };
                xhttp.open('POST', pagina + '.php', true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send('id=' + id);
        }

        /*
            function navegar(pagina, id, pagsus) {
            var contenido = document.getElementById(pagsus);
            //var animacion = document.querySelector("#"+pagsus);

            //animacion.classList.toggle("ocultar-prestamos"); //agrega la opacidad en 0 al cambiar de pagina


            var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            window.scroll(0, 0);
                            // Esperar un breve tiempo antes de cambiar el contenido para visualizar la transicion
                            //setTimeout(function() {
                                contenido.innerHTML = this.responseText;
                                //animacion.classList.toggle("ocultar-prestamos"); //cambia la opacidad en 1  al cambiar de pagina
                            //}.bind(this), 400);  //tiempo del setTime

                            if(document.getElementById('jsDinamico')) 
                                document.getElementById('jsDinamico').remove();
                                
                                var script = document.createElement('script');
                                script.id = 'jsDinamico';
                                script.src = './js/'+pagina+'.js';
                                script.type = 'text/javascript';
                                document.body.appendChild(script);
                        }
                    };


                xhttp.open('POST', pagina + '.php', true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send('id='+id);
            }  
        */


    </script>
</body>
</html>