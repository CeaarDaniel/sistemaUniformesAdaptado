<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<canvas id="canvas" width="300" height="150" style="border:1px solid black;"></canvas>
<button onclick="verificarCanvas()">Verificar si está vacío</button>

<script>


        var idCanvas = 'canvas';
        var idForm = 'formCanvas';
        var inputImagen = 'imagen';
        var estiloDelCursor = 'crosshair';
        var colorDelTrazo = '#000000';
        var colorDeFondo = '#ffffff';
        var grosorDelTrazo = 2;

        /* Variables necesarias */
        var contexto = null;
        var valX = 0;
        var valY = 0;
        var flag = false;
        var imagen = document.getElementById(inputImagen);
        var anchoCanvas = document.getElementById(idCanvas).offsetWidth;
        var altoCanvas = document.getElementById(idCanvas).offsetHeight;
        var pizarraCanvas = document.getElementById(idCanvas);

        /* Esperamos el evento load */
        window.addEventListener('load', IniciarDibujo, false);

        function IniciarDibujo() {
            /* Creamos la pizarra */
            pizarraCanvas.style.cursor = estiloDelCursor;
            contexto = pizarraCanvas.getContext('2d');
            contexto.fillStyle = colorDeFondo;
            contexto.fillRect(0, 0, anchoCanvas, altoCanvas);
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
            contexto = document.getElementById(idCanvas).getContext('2d');
            contexto.fillStyle = colorDeFondo;
            contexto.fillRect(0, 0, anchoCanvas, altoCanvas);
        }

        /* Enviar el trazado */
        function GuardarTrazado() {
                const canvas = document.getElementById('canvas');
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
                });

             /* 
                Mostrar la imagen como vista previa
                document.getElementById('preview').src = image;

                // Opción: descargar la imagen automáticamente
                const link = document.createElement('a');
                link.download = 'firma.png';
                link.href = image;
                link.click(); 
              */
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
        
  function verificarCanvas() {
    const canvas = document.getElementById('canvas');
    if (isCanvasEmpty(canvas)) {
      alert("El canvas está vacío");
    } else {
      alert("El canvas tiene contenido");
    }
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
</script>

</body>
</html>