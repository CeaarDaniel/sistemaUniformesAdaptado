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
        <!--TITULO DEL DOCUMENTO -->
          <p class="text-center" style="font-size:16px;"><b>CARTA DE ACEPTACIÓN DE DESCUENTOS</b></p>
          <p class="text-end"><b>26-05-2025</b></p>
          <p class="text-start ms-3" style="font-size:14px;">
              ATENCIÓN <br>
              BEYONZ MEXICANA, S.A. de C.V.
          </p>

        <!--PRIMER PARRAFO -->
          <p class="text-start mt-4 mb-5" style="text-indent: 2em; font-size:14px;">
              Por medio de la presente, autorizo a la empresa BEYONZ MEXICANA, S.A. DE C.V., que me descuente vía nómina la cantidad de $528.00 (pesos 00/100 M.N.) en total.
          </p>

         <!--TABLA DE DESCUENTOS --> 
          <div class="page-break-avoid">
            <div class="row mx-3 p-0" style="max-width: 716px; margin: 0 auto;">
                <div class="col-2 border border-black p-0"><div class="d-flex text-center align-items-center" style="height:100%;"><b style="font-size: 12px;"> CANTIDAD A DESCONTAR </b></div> </div>
                <div class="col-6 border-top border-bottom border-end border-black p-0"><div class="d-flex justify-content-center align-items-center" style="height:100%;"><b style="font-size: 12px;">MONTO EN LETRA</b></div></div>
                <div class="col-2 border-top border-bottom border-end border-black p-0"><div class="d-flex text-center align-items-center" style="height:100%;"><b style="font-size: 12px;">CANTIDAD DE DESCUENTOS</b></div></div>
                <div class="col-2 border-top border-bottom border-end border-black p-0"><div class="d-flex justify-content-center align-items-center" style="height:100%;"><b style="font-size: 12px;">FECHA</b></div></div>

                <div class="col-2 text-center border-start border-bottom border-end border-black p-0"><label style="font-size: 12px;">$528.00 </label></div>
                <div class="col-6 text-center border-bottom border-end border-black p-0"><label style="font-size: 12px;">QUINIENTOS VEINTIOCHO PESOS </label></div>
                <div class="col-2 text-center border-bottom border-end border-black p-0"><label style="font-size: 12px;">1 de 1</labelb></div>
                <div class="col-2 text-center border-bottom border-end border-black p-0"><label style="font-size: 12px;">26-05-2025</label></div>

                <div class="col-2 text-center border-start border-bottom border-end border-black p-0">
                  <label style="font-size: 12px;"> $528.00</label>
                </div>
                <div class="col-4">
                  <b style="font-size: 12px;">  Total adeudo </b>
                </div>
            </div>
          </div>
          
        <!--DESGLOCE DE ARTRTICULOS SOLICITADOS -->
          <div class="page-break-avoid">
            <p class="text-start mt-4" style="text-indent: 2em; font-size:14px;">
                Con estos descuentos estaré cubriendo el adeudo por concepto de compra de uniforme adicional que por
                interés personal he solicitado: 
            </p>
          </div>

          <div class="row mt-3 ms-3 page-break-avoid" style="font-size:14px;">
              <div class="col-2">Cantidad: 1</div>
              <div class="col-4">PANTALÓN-Hombre T 28</div>
              <div class="col-2">$322.00 c/u</div>
          </div>
          <div class="row mb-1 ms-3 page-break-avoid" style="font-size:14px;">
              <div class="col-2">Cantidad: 1</div>
              <div class="col-4">PLAYERA MC-Hombre T S</div>
              <div class="col-2">$206.00 c/u</div>
          </div>

          <!-- FIRMA DEL EMPLEADO -->
          <div class="page-break-avoid">
              <p class="mt-5 mb-1 p-0 mx-0" style="font-size:14px;">
                  Ratifico con mi firma lo aquí descrito. <br> <br>
                  Atentamente: 
              </p>
          </div>

          <div class="page-break-avoid signature-area ms-0">
            <div class="row mt-1">
                <div class="col-8 mt-0 p-0"> 
                    <div class="text-center">
                        <img class="my-0 p-0" src="http://localhost/sistemaUniformesAdaptado/imagenes/firmas/19-1625.png" style="height: 60px;">
                        <div class="signature-line"></div>
                        <p>FIRMA LOZA GONZALEZ OSVALDO ALEJANDRO</p>
                    </div>
                </div>
                <div class="col-4 p-0 m-0">
                    <div style="height: 40px;"></div>
                    <p>N.N.<span class="underline mx-2">&nbsp;2481&nbsp;</span></p>
                </div>
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