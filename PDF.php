<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Carta de Descuento</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome (para íconos) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
   


    <!--html2PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
            font-family:  sans-serif;
            color:rgb(0, 0, 0);
        }

        /* Estilos para evitar cortes de página */
        .page-break-avoid {
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        .page-break-before {
            page-break-before: always;
            break-before: page;
        }
        
        .keep-together {
            display: block;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        /*Estilos de la pagina*/
        body {
            background-color: #f5f5f5;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .hojaImpresion {
            max-width: 816px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            font-family:  sans-serif;
            color:rgb(0, 0, 0);
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
              
        .signature-area {
            margin-top: 30px;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin: 0px auto;
            width: 80%;
        }
        .underline {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="controls">
        <button class="my-2" id="downloadBtn">Descargar PDF</button>
    </div>
    
    <div id="contenido" class="hojaImpresion">
             <p class="text-center" style="font-size:15px;"> 
            <b>SALIDA - UNIFORMES</b>
        </p>
  
        <!-- Detalles de la salida -->
        <div class="mx-5 d-flex justify-content-between">
            <img src="./imagenes/beyonz.jpg" style="max: width 150px; max-height:50px;">
            <table>
                <tbody>
                    <tr>
                        <td class="text-center p-0 border-top border-start border-end border-dark" style="width:100%"><b>&nbsp; NUM SALIDA&nbsp;</b></td>
                    </tr>
                    <tr>
                        <td class="text-center p-0 border border-dark" style="width:100%"># 2</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Detalles del pedido -->
        <div class="row mt-5">
            <div class="my-0 col-4"><b>Fecha de elaboración:</b></div>
            <div class="my-0 col-auto"><label class="mx-0 px-0 text-uppercase">2021-05-18 09:44</label></div>
        </div>

        <div class="row my-0">
            <div class="my-0 col-4"><b>Realizado por:</b></div>
            <div class="my-0 col-auto"><label>RAUL TORRES SANDOVAL</label></div>
        </div>

        <div class="row my-0">
            <div class="my-0 col-4"><b>Entregado a:</b></div>
            <div class="my-0 col-auto text-uppercase"><label>2357-JUAREZ RODRIGUEZ YADIRA VANESSA</label></div>
            </div>
            
            <!-- TIPO DE SALIDA -->
            <div class="row mt-0">
            <div class="my-0 col-4"><b>Tipo de salida:</b></div>
            <div class="my-0 col-auto text-uppercase"><label>Venta de uniforme</label></div>
            </div>

            <!-- VALE -->
            <div class="row mt-1"></div>

            <hr class="my-4" style="height: 5px; background: linear-gradient(90deg,rgba(9, 11, 122, 1) 33%, rgba(133, 133, 133, 1) 0%); opacity: 1; border:none;">

            <!--TABLA DE PRODUCTOS -->
            <p class="text-center fs-7"><b> ARTICULOS </b></p>
            <div style="max-height: 400px;">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Clave</th>
                            <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Cantidad</th>
                            <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Artículo</th>
                            <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Precio Unitario</th>
                            <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Total</th>
                        </tr>
                    </thead>
                    <tbody style="font-size:12px">
                        <tr class="page-break-avoid">
                            <td>14</td>
                            <td>1</td>
                            <td>PLAYERA MC-Hombre T S</td>
                            <td>$ 140.00</td>
                            <td>$ 140.00</td>
                        </tr>
                        <tr class="page-break-avoid">
                            <td>14</td>
                            <td>1</td>
                            <td>PLAYERA MC-Hombre T S</td>
                            <td>$ 140.00</td>
                            <td>$ 140.00</td>
                        </tr>
                        <tr class="page-break-avoid">
                            <td>14</td>
                            <td>1</td>
                            <td>PLAYERA MC-Hombre T S</td>
                            <td>$ 140.00</td>
                            <td>$ 140.00</td>
                        </tr>
                        <tr class="page-break-avoid">
                            <td>14</td>
                            <td>1</td>
                            <td>PLAYERA MC-Hombre T S</td>
                            <td>$ 140.00</td>
                            <td>$ 140.00</td>
                        </tr>
                        <tr class="page-break-avoid">
                            <td>14</td>
                            <td>1</td>
                            <td>PLAYERA MC-Hombre T S</td>
                            <td>$ 140.00</td>
                            <td>$ 140.00</td>
                        </tr>
                        <tr class="page-break-avoid">
                            <td>14</td>
                            <td>1</td>
                            <td>PLAYERA MC-Hombre T S</td>
                            <td>$ 140.00</td>
                            <td>$ 140.00</td>
                        </tr>
                    </tbody>
                </table>

                <div class="mx-3 d-flex justify-content-end" style="font-size:13px">
                    <b>Total:</b> &nbsp; &nbsp; <label>       $ 140</label>
                </div>
            </div>
    </div>

    <script>
        document.getElementById('downloadBtn').addEventListener('click', function() {
            const element = document.getElementById('contenido');
            
            // Configuración optimizada para tamaño carta
            const opt = {
                margin: [10, 13, 10, 13], // márgenes: [top, right, bottom, left]
                filename: 'carta_descuento.pdf',
                image: { 
                    type: 'jpeg', 
                    quality: 1 
                },
                html2canvas: { 
                    scale: 5, // Escala óptima para calidad y rendimiento
                    useCORS: true,
                    letterRendering: true,
                    logging: false
                },
                jsPDF: { 
                    unit: 'mm', 
                    format: 'letter', 
                    orientation: 'portrait' 
                },
                // Configuración avanzada para saltos de página
                pagebreak: { 
                    mode: ['avoid-all', 'css'], 
                    before: '.page-break-before',
                    avoid: '.page-break-avoid'
                }
            };

            // Generar PDF y abrir en nueva pestaña
            html2pdf().set(opt).from(element).outputPdf('blob')
                .then(function(blob) {
                    const blobUrl = URL.createObjectURL(blob);
                    window.open(blobUrl, '_blank');
                })
                .catch(function(error) {
                  console.log(error)
                });
        });

      /*
        document.getElementById('downloadBtn').addEventListener('click', function() {
            const element = document.getElementById('contenido');
            
            // Configuración para tamaño carta (216x279 mm)
            const opt = {
                margin: [10, 15],
                filename: 'carta_descuento.pdf',
                image: { type: 'jpeg', quality: 1 },
                html2canvas: { 
                    scale: 5,
                    useCORS: true,
                    letterRendering: true
                },
                jsPDF: { 
                    unit: 'mm', 
                    format: 'letter', 
                    orientation: 'portrait' 
                }
            };

           // html2pdf().set(opt).from(element).save();

            html2pdf().set(opt).from(element).outputPdf('blob').then(function (blob) {
              const blobUrl = URL.createObjectURL(blob);
              window.open(blobUrl, '_blank'); // Abre el PDF en una nueva pestaña
            });
        }); 
      */
    </script>
</body>
</html>