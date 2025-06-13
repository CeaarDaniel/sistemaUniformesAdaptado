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
</head>

<body class="hold-transition sidebar-collapse">
    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
            <section class="content">
                <form class="formulario" action="guardar-firma-nivel8?ID=<?php echo $ID ?>" method="post" autocomplete="off" enctype="multipart/form-data" id="formCanvas">
                    <div class="card ">
                        <div class="card-body text-center">
                            <canvas id='canvas' width="700" height="280" style='border: 1px solid #CCC;'>
                                <p>Tu navegador no soporta canvas</p>
                            </canvas>
                            <div>
                                <img id="preview" alt="Vista previa de la firma" />
                            </div>
                        </div>
                            <button type='button' class="btn btn-danger" onclick='LimpiarTrazado()'><i class='fa fa-trash'></i> Borrar</button>
                            <button type='button' class="btn btn-success" onclick='GuardarTrazado()'><i class='fas fa-file-signature'></i> Firmar</button>
                    </div>
                </form>
            </section>
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
                const image = canvas.toDataURL('image/png'); // También puedes usar 'image/jpeg'
                
                // Mostrar la imagen como vista previa
                document.getElementById('preview').src = image;

                // Opción: descargar la imagen automáticamente
                const link = document.createElement('a');
                link.download = 'firma.png';
                link.href = image;
                link.click();
        }
    </script>
</body>
</html>