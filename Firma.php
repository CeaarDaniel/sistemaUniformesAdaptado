<?php
include_once "../../BD_Conexion.php";
include_once("Funciones.php");

$ID = $_GET['ID'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <style>
        .error {
            color: #FF0000;
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Firma Trabajadro | Evaluaciones de Desempeño</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

</head>
<!--
`body` tag options:
  * sidebar-collapse
  * sidebar-mini
-->

<body class="hold-transition sidebar-collapse">
    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header  -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">Firma de Evaluacion Nivel 5</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <section class="content">
                <form class="formulario" action="guardar-firma-nivel8?ID=<?php echo $ID ?>" method="post" autocomplete="off" enctype="multipart/form-data" id="formCanvas">
                    <div class="card ">
                        <div class="card-body text-center">
                            <canvas id='canvas' width="700" height="280" style='border: 1px solid #CCC;'>
                                <p>Tu navegador no soporta canvas</p>
                            </canvas>
                            <!-- creamos el form para el envio -->
                            <div>
                                <input type='' name='imagen' id='imagen' hidden />
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button type='button' class="btn btn-danger" onclick='LimpiarTrazado()'><i class='fa fa-trash'></i> Borrar</button>
                            <button type='button' class="btn btn-success" onclick='GuardarTrazado()'><i class='fas fa-file-signature'></i> Firmar</button>
                        </div>
                    </div>
                </form>
            </section>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->

            <!-- Main Footer -->

        </div>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>

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
            imagen.value = document.getElementById(idCanvas).toDataURL('image/png');
            var form = document.forms[idForm];
            if (form) {
                form.submit();
            } else {
                console.error("El formulario no se encontró en el DOM.");
            }
        }
    </script>

</body>

</html>