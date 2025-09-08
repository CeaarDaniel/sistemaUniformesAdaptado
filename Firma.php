<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Firma Trabajadro | Evaluaciones de Desempeño</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <style>
            @media (max-width: 700px) {
                canvas{
                    width:80%; 
                    height:40vw;
                }
            }

            @media (min-width: 701px ) {
                 canvas{
                    width: 650px;
                    height: 280px;
                 }
            }
    </style>
</head>

<body>
    <div class="wrapper" style="px-1">
        <form class="formulario" action="guardar-firma-nivel8?ID=<?php echo $ID ?>" method="post" autocomplete="off" enctype="multipart/form-data" id="formCanvas">
                <div class="card-body text-center">
                    <canvas id='canvas' style='border: 1px solid #CCC;'>
                        <p>Tu navegador no soporta canvas</p>
                    </canvas>
                </div>

                <div class="text-center">
                    <img id="preview" alt="Vista previa de la firma" />
                </div>

                <div class="text-center p-2" style="width:100%">
                    <button type='button' class="btn btn-danger" onclick='LimpiarTrazado()'><i class='fa fa-trash'></i> Borrar</button>
                    <button type='button' class="btn btn-success" onclick='GuardarTrazado()'><i class='fas fa-file-signature'></i> Firmar</button>
                </div>
        </form>
    </div>
    <!-- ./wrapper -->

    <!-- Page specific script -->
    <script type="text/javascript">
        /* Variables de Configuracion */
            var idCanvas = 'canvas';
            var idForm = 'formCanvas';
            var inputImagen = 'imagen';
            var estiloDelCursor = 'crosshair';
            var colorDelTrazo = '#000000';
            var colorDeFondo = '#ffffff';
            var grosorDelTrazo = 10;

        /* Variables necesarias */
        var contexto = null;
        var valX = 0;
        var valY = 0;
        var flag = false;
        var imagen = document.getElementById(inputImagen);
        //var anchoCanvas =document.getElementById(idCanvas).offsetWidth;
        //var altoCanvas = document.getElementById(idCanvas).offsetHeight;
        var pizarraCanvas = document.getElementById(idCanvas);
        ajustarCanvas();

        /* Esperamos el evento load */
        window.addEventListener('load', IniciarDibujo, false);

        window.addEventListener('resize', () => {
            ajustarCanvas(pizarraCanvas);
        });


        function IniciarDibujo() {
            /* Creamos la pizarra */
            pizarraCanvas.style.cursor = estiloDelCursor;
            contexto = pizarraCanvas.getContext('2d');
            //contexto.fillStyle = colorDeFondo;
            //contexto.fillRect(0, 0, anchoCanvas, altoCanvas);
            contexto.strokeStyle = colorDelTrazo;
            contexto.lineWidth = grosorDelTrazo;
            contexto.lineJoin = 'round';
            contexto.lineCap = 'round';
            /* Capturamos los diferentes eventos */
            pizarraCanvas.addEventListener('mousedown', MouseDown, false); // Click pc
            pizarraCanvas.addEventListener('mouseup', MouseUp, false); // fin click pc
            pizarraCanvas.addEventListener('mousemove', MouseMove, false); // arrastrar pc

            pizarraCanvas.addEventListener('touchstart', TouchStart, false); // tocar pantalla tactil
            pizarraCanvas.addEventListener('touchmove', TouchMove, false); // arrastras pantalla tactil
            pizarraCanvas.addEventListener('touchend', TouchEnd, false); // fin tocar pantalla dentro de la pizarra
            pizarraCanvas.addEventListener('touchleave', TouchEnd, false); // fin tocar pantalla fuera de la pizarra
        }

        function MouseDown(e) {
            flag = true;
            contexto.beginPath();
            valX = e.pageX - posicionX(pizarraCanvas);
            valY = e.pageY - posicionY(pizarraCanvas);
            contexto.moveTo(valX, valY);
        }

        function MouseUp(e) {
            contexto.closePath();
            flag = false;
        }

        function MouseMove(e) {
            if (flag) {
                contexto.beginPath();
                contexto.moveTo(valX, valY);
                valX = e.pageX - posicionX(pizarraCanvas);
                valY = e.pageY - posicionY(pizarraCanvas);
                contexto.lineTo(valX, valY);
                contexto.closePath();
                contexto.stroke();
            }
        }

        function TouchMove(e) {
            e.preventDefault();
            if (e.targetTouches.length == 1) {
                var touch = e.targetTouches[0];
                MouseMove(touch);
            }
        }

        function TouchStart(e) {
            if (e.targetTouches.length == 1) {
                var touch = e.targetTouches[0];
                MouseDown(touch);
            }
        }

        function TouchEnd(e) {
            if (e.targetTouches.length == 1) {
                var touch = e.targetTouches[0];
                MouseUp(touch);
            }
        }

        function posicionY(obj) {
            var valor = obj.offsetTop;
            if (obj.offsetParent) valor += posicionY(obj.offsetParent);
            return valor;
        }

        function posicionX(obj) {
            var valor = obj.offsetLeft;
            if (obj.offsetParent) valor += posicionX(obj.offsetParent);
            return valor;
        }

        /* Limpiar pizarra */
        function LimpiarTrazado() {
            document.getElementById('preview').src = '';
            let estilo = getComputedStyle(canvas);
            let ancho = parseInt(estilo.width, 10);
            let alto = parseInt(estilo.height, 10);
            contexto = document.getElementById('canvas').getContext('2d');
            contexto.clearRect(0, 0, ancho, alto);

            //contexto.fillStyle = colorDeFondo;
            //contexto.fillRect(0, 0, anchoCanvas, altoCanvas);
        }

        /* Enviar el trazado */
        function GuardarTrazado() {
                const canvas = document.getElementById('canvas');

                 if (isCanvasEmpty(canvas)) {
                        alert("El canvas está vacío");
                    } 

                else {
                        alert("El canvas tiene contenido");
                    }

                const image = canvas.toDataURL('imagenes/png'); // También puedes usar 'image/jpeg'

                //SE TRANFORMA A BLOB LA IMAGEN GENERADA
                const imageBlob = dataURLtoBlob(image);
                
                const formData = new FormData();
                formData.append('image', imageBlob, 'firma.png'); // 'image' será la clave en PHP
                formData.append('opcion', 1);

                fetch('./api/salidas.php', { //CAMBIAR ESTA RUTA A LA CARPETA DE LAS FIRMAS
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(result => {
                    console.log('Respuesta del servidor:', result);
                })
                .catch(error => {
                    console.error('Error al enviar la imagen:', error);
                    document.getElementById('preview').src = '';
                });

             
                //Mostrar la imagen como vista previa
                document.getElementById('preview').src = image;

                // Opción: descargar la imagen automáticamente
                //const link = document.createElement('a');
                //link.download = 'firma.png';
                //link.href = image;
                //link.click(); 
              
        }

        //Funcion para tranformar a blob la imagen canvas y enviar como archivo en un fromData
        function dataURLtoBlob(dataURL) {
            const parts = dataURL.split(';base64,');
            const contentType = parts[0].split(':')[1];
            const byteCharacters = atob(parts[1]);
            const byteArrays = [];

            for (let i = 0; i < byteCharacters.length; i++) {
                byteArrays.push(byteCharacters.charCodeAt(i));
            }

            const byteArray = new Uint8Array(byteArrays);
            return new Blob([byteArray], { type: contentType });
        }

        // Puedes usar esta función para verificar
        function isCanvasEmpty(canvas) {
            const ctx = canvas.getContext('2d');
            const pixels = ctx.getImageData(0, 0, canvas.width, canvas.height).data;

            for (let i = 0; i < pixels.length; i += 4) {
                if (pixels[i] !== 0 || pixels[i + 1] !== 0 || pixels[i + 2] !== 0 || pixels[i + 3] !== 0) {
                    return false;
                }
            }

            return true;
        }

        function ajustarCanvas(){
            let canvas = document.getElementById('canvas')
            const estilo = getComputedStyle(canvas);
            const ancho = parseInt(estilo.width, 10);
            const alto = parseInt(estilo.height, 10);

            // Establece el tamaño interno en píxeles reales
            canvas.width = ancho;
            canvas.height = alto;
        }
    </script>
</body>
</html>