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
    
 
        <div id="contenido" class="hojaImpresion" style="font-size:13px;"><!-- Detalles de la salida -->
              <div class="row border border-dark">
                <div class="col-6 text-center border-bottom border-dark"><b>Reporte De Ventas</b></div>
                <div class="col-6 text-center border-bottom border-dark"><b>Periodo:</b> 01-05-2025 - 31-05-2025</div>

                <div class="col-4"><b>Tipo:</b> Solo venta</div>
                <div class="col-6"><b>Empleado:</b> Todos</div>

                <div class="col-4"><b>Categoria:</b> Todos</div>
                <div class="col-6"><b>Usuario:</b> Todos</div>
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