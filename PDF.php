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
   
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!--html2PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
            font-family:  sans-serif;
            color:rgb(0, 0, 0);
        }
        body {
            background-color: #f5f5f5;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container {
            max-width: 816px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .controls {
            margin: 20px 0;
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
        .text-center {
            text-align: center;
        }
        .text-end {
            text-align: right;
        }
        .text-start {
            text-align: left;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -5px;
        }
        .col-2 {
            flex: 0 0 16.666%;
            padding: 0 5px;
        }
        .col-4 {
            flex: 0 0 33.333%;
            padding: 0 5px;
        }
        .col-6 {
            flex: 0 0 50%;
            padding: 0 5px;
        }
        .col-8 {
            flex: 0 0 66.666%;
            padding: 0 5px;
        }
        .mt-3 {
            margin-top: 1rem;
        }
        .mb-1 {
            margin-bottom: 0.25rem;
        }
        .signature-area {
            margin-top: 30px;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin: 0px auto;
            width: 80%;
        }
        .border-table {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            margin-bottom: 5px;
        }
        .border-label {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            min-height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }
        .underline {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="controls">
        <button id="downloadBtn">Descargar PDF</button>
    </div>
    
    <div id="contenido" class="container" >
        <p class="text-center" style="font-size:16px;"><b>CARTA DE ACEPTACIÓN DE DESCUENTOS</b></p>
        <p class="text-end"><b>26-05-2025</b></p>
        <p class="text-start ms-3" style="font-size:14px;">
            ATENCIÓN <br>
            BEYONZ MEXICANA, S.A. de C.V.
        </p>

        <p class="text-start mt-4 mb-5" style="text-indent: 2em; font-size:14px;">
            Por medio de la presente, autorizo a la empresa BEYONZ MEXICANA, S.A. DE C.V., que me descuente vía nómina la cantidad de $528.00 (pesos 00/100 M.N.) en total.
        </p>



        <div class="row mx-3 p-0" style="max-width: 716px; margin: 0 auto;">
            <div class="col-2 text-center border border-black p-0"><b style="font-size: 12px;"> CANTIDAD A DESCONTAR </b></div>
            <div class="col-6 text-center border-top border-bottom border-end border-black p-0"><b style="font-size: 12px;">MONTO EN LETRA</b></div>
            <div class="col-2 text-center border-top border-bottom border-end border-black p-0"><b style="font-size: 12px;">CANTIDAD DE DESCUENTOS</b></div>
            <div class="col-2 text-center border-top border-bottom border-end border-black p-0"><b style="font-size: 12px;">FECHA</b></div>

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
        
        <p class="text-start mt-4" style="text-indent: 2em; font-size:14px;">
            Con estos descuentos estaré cubriendo el adeudo por concepto de compra de uniforme adicional que por
            interés personal he solicitado: 
        </p>

        <div class="row mt-3 ms-3" style="font-size:14px;">
            <div class="col-2">Cantidad: 1</div>
            <div class="col-4">PANTALÓN-Hombre T 28</div>
            <div class="col-2">$322.00 c/u</div>
        </div>
        <div class="row mb-1 ms-3" style="font-size:14px;">
            <div class="col-2">Cantidad: 1</div>
            <div class="col-4">PLAYERA MC-Hombre T S</div>
            <div class="col-2">$206.00 c/u</div>
        </div>

        <p class="mt-5 mb-1 p-0 mx-0" style="font-size:14px;">
            Ratifico con mi firma lo aquí descrito. <br> <br>
            Atentamente: 
        </p>

        <div class="row mt-1 signature-area">
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

    <script>
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
    </script>
</body>
</html>

<!-- 
<!DOCTYPE html>
<html lang="en">
<head>

  <title>Sistema Uniformes</title>
    <meta charset="utf-8">
    <meta name="description" content="A Quasar Framework app">
    <meta name="format-detection" content="telephone=no">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="viewport" content="user-scalable=no,initial-scale=1.0,maximum-scale=1,minimum-scale=1,width=device-width">

    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> ->
    <link rel="icon" type="image/ico" href="logo_b.png">
    <link rel="icon" type="image/ico" href="logo_b.png">
    
    <!-- Bootstrap CSS ->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome (para íconos) ->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
   
    <!-- Bootstrap Icons ->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Estilos personalizados ->
    <link rel="icon" type="image/ico" href="logo_b.png">
    <link href="./style.css" rel="stylesheet">

    <!--Libreria Jquery ->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!--Data table ->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    
    <!-- DataTables Select ->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.7.0/css/select.dataTables.min.css">
    <script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
     <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
</head>
<body>
    <div id="contenido" style="max-width: 816px;">
          <p class="text-center"><b>CARTA DE ACEPTACIÓN DE DESCUENTOS</b></p>
          <p class="text-end"><b> 26-05-2025 </b></p>
          <p class="text-start">
            ATENCIÓN <br>
            BEYONZ MEXICANA, S.A. de C.V.
          </p>

          <p clas="text-start" style="text-indent: 2em;">
                Por medio de la presente, autorizo a la empresa BEYONZ MEXICANA, S.A. DE C.V., que me descuente vía
            nómina la cantidad de $528.00 (pesos 00/100 M.N.) en total.
          </p>

          <div class="row" style="max-width: 716px;">
            <div class="col-2 text-center"><b style="font-size: 12px;"> CANTIDAD A DESCONTAR </b></div>
            <div class="col-6 text-center"><b style="font-size: 12px;">MONTO EN LETRA</b></div>
            <div class="col-2 text-center"><b style="font-size: 12px;">CANTIDAD DE DESCUENTOS</b></div>
            <div class="col-2 text-center"><b style="font-size: 12px;">FECHA</b></div>

            <div class="col-2 text-center"><label style="font-size: 12px;">$528.00 </label></div>
            <div class="col-6 text-center"><label style="font-size: 12px;">QUINIENTOS VEINTIOCHO PESOS </label></div>
            <div class="col-2 text-center"><label style="font-size: 12px;">1 de 1</labelb></div>
            <div class="col-2 text-center"><label style="font-size: 12px;">26-05-2025</label></div>

            <div class="col-2 text-center">
              <label style="font-size: 12px;"> $528.00</label>
            </div>
            <div class="col-4">
              <b style="font-size: 12px;">  Total adeudo </b>
            </div>
          </div>


          <p class="text-start mt-3" style="text-indent: 2em;">
            Con estos descuentos estaré cubriendo el adeudo por concepto de compra de uniforme adicional que por
            interés personal he solicitado: 
          </p>

          <div class="row mt-3">
            <div class="col-2"> Cantidad: 1 </div>
            <div class="col-4"> PANTALÓN-Hombre T 28</div>
            <div class="col-2"> $322.00 c/u</div>
          </div>
          <div class="row mb-1">
            <div class="col-2">Cantidad: 1</div>
            <div class="col-4">PLAYERA MC-Hombre T S</div>
            <div class="col-2">$206.00 c/u</div>
          </div>

          <p class="mt-3">
            Ratifico con mi firma lo aquí descrito. <br>
            Atentamente: 
          </p>

          <div class="row">
              <div class="col-8"> 
                <div class="text-center">
                  <img src="http://localhost/sistemaUniformesAdaptado/imagenes/firmas/19-1625.png" style="width 150px; height:50px;"> 
                  <br>
                  <hr class="px-5 mx-5 my-0 py-0">
                    FIRMA LOZA GONZALEZ OSVALDO ALEJANDRO
                </div>
              </div>
              <div class="col-4">
                <label style="height:50px;"> </label>
                  N.N.<label  class="mx-2" style="text-decoration: underline;"> 2481 </label>
              </div>
            </div>
    </div>


      <div class="container">
          <button id="generatePdfBtn" class="btn btn-success">Generar PDF</button>
    </div>

    <button onclick="generarPDF()">Descargar PDF</button>

    <div id="contenido2" style="font-family: Arial; font-size: 12px;">
        <p style="text-align: center; font-weight: bold;">CARTA DE ACEPTACIÓN DE DESCUENTOS</p>
        <p style="text-align: right; font-weight: bold;">26-05-2025</p>
        <p class="text-start">
          ATENCIÓN <br>
          BEYONZ MEXICANA, S.A. de C.V.
        </p>

        <p clas="text-start" style="text-indent: 2em;">
              Por medio de la presente, autorizo a la empresa BEYONZ MEXICANA, S.A. DE C.V., que me descuente vía
          nómina la cantidad de $528.00 (pesos 00/100 M.N.) en total.
        </p>

         <div class="row" style="display: flex; margin-top: 10px;">
          <div class="col-2 text-center"><b style="font-size: 12px;"> CANTIDAD A DESCONTAR </b></div>
          <div class="col-6 text-center"><b style="font-size: 12px;">MONTO EN LETRA</b></div>
          <div class="col-2 text-center"><b style="font-size: 12px;">CANTIDAD DE DESCUENTOS</b></div>
          <div class="col-2 text-center"><b style="font-size: 12px;">FECHA</b></div>

          <div class="col-2 text-center"><label style="font-size: 12px;">$528.00 </label></div>
          <div class="col-6 text-center"><label style="font-size: 12px;">QUINIENTOS VEINTIOCHO PESOS </label></div>
          <div class="col-2 text-center"><label style="font-size: 12px;">1 de 1</labelb></div>
          <div class="col-2 text-center"><label style="font-size: 12px;">26-05-2025</label></div>

          <div class="col-2 text-center">
            <label style="font-size: 12px;"> $528.00</label>
          </div>
          <div class="col-4">
            <b style="font-size: 12px;">  Total adeudo </b>
          </div>
        </div>


        <p class="text-start mt-3" style="text-indent: 2em;">
          Con estos descuentos estaré cubriendo el adeudo por concepto de compra de uniforme adicional que por
          interés personal he solicitado: 
        </p>

        <div class="row mt-3">
          <div class="col-2"> Cantidad: 1 </div>
          <div class="col-4"> PANTALÓN-Hombre T 28</div>
          <div class="col-2"> $322.00 c/u</div>
        </div>
        <div class="row mb-1">
          <div class="col-2">Cantidad: 1</div>
          <div class="col-4">PLAYERA MC-Hombre T S</div>
          <div class="col-2">$206.00 c/u</div>
        </div>

        <p class="mt-3">
          Ratifico con mi firma lo aquí descrito. <br>
          Atentamente: 
        </p>

        <div class="row">
            <div class="col-8"> 
              <div class="text-center">
                <img src="http://localhost/sistemaUniformesAdaptado/imagenes/firmas/19-1625.png" style="width 150px; height:50px;"> 
                <br>
                <hr class="px-5 mx-5 my-0 py-0">
                  FIRMA LOZA GONZALEZ OSVALDO ALEJANDRO
              </div>
            </div>
            <div class="col-4">
              <label style="height:50px;"> </label>
                N.N.<label  class="mx-2" style="text-decoration: underline;"> 2481 </label>
            </div>
        </div>
    </div>

<script>
  function generarPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({
      orientation: "portrait",
      unit: "mm",
      format: "letter"
    });

    const element = document.getElementById("contenido2");
    const margin = 10; // mm
    const maxWidth = 216 - 2 * margin; // Ancho útil carta
    
    doc.html(element, {
      callback: (doc) => doc.save("documento.pdf"),
      x: margin,
      y: margin,
      width: maxWidth,
      windowWidth: 816,
      html2canvas: {
        scale: 0,
        useCORS: true
      }, 
      width: 190
    });
  }

    document.getElementById("generatePdfBtn").addEventListener("click", () => {
            const { jsPDF } = window.jspdf;

            // Initialize a new jsPDF instance
              const doc = new jsPDF({
                orientation: 'portrait',
                unit: 'pt',      // points, 72pt = 1 inch
                format: 'letter' // 'letter' = 612 x 792 pt
              });


                // ----- Section 1: Heading & Custom Font -----
              doc.setFont("helvetica", "bold"); // font face, style
              doc.setFontSize(22);
              doc.text("My Awesome PDF Report", 40, 60);
              
              doc.setFontSize(12);
              doc.setFont("helvetica", "normal");
              doc.setTextColor(50, 50, 50);
              doc.text("This PDF was generated using only jsPDF, demonstrating multiple features and sections.", 40, 90);
              
              // ----- Section 2: Table (Using jsPDF's autoTable Plugin Alternative) -----
              // Note: If you want to create a table without plugins, we'll do a simplified approach.
              // For fully featured tables, you'd use 'jspdf-autotable' plugin, but here’s a basic approach using text() for demonstration.
              
              const tableData = [
                ["Name", "Age", "Email"],
                ["Alice", "25", "alice@example.com"],
                ["Bob", "30", "bob@example.com"],
                ["Charlie", "28", "charlie@example.com"],
              ];
              
              // Starting position for the table
              let startX = 40;
              let startY = 120;
              let rowHeight = 20;
              
              doc.setFont("helvetica", "bold");
              for (let rowIndex = 0; rowIndex < tableData.length; rowIndex++) {
                const row = tableData[rowIndex];
                
                // Reset X position for each row
                let currentX = startX;
                
                // If it's the header row, maybe set a background or different style
                if (rowIndex === 0) {
                  doc.setTextColor(255, 255, 255); // white text
                  // Draw a rectangle for header background
                  doc.setFillColor(40, 40, 40);    // dark gray
                  doc.rect(startX - 5, startY - 15, 350, rowHeight, 'F'); // x, y, width, height, style
                } else {
                  doc.setTextColor(0, 0, 0); // revert to black text
                }
                
                // Print each cell
                row.forEach(cell => {
                  doc.text(cell.toString(), currentX, startY);
                  currentX += 100; // move horizontally for next cell
                });
                
                startY += rowHeight;
              }
              
              // ----- Section 3: Move to a New Page for More Content -----
              doc.addPage();
              
              doc.setFont("helvetica", "bold");
              doc.setFontSize(16);
              doc.setTextColor(60, 60, 180);
              doc.text("Additional Section on a New Page", 40, 60);
              
              doc.setFont("helvetica", "normal");
              doc.setFontSize(12);
              doc.setTextColor(0, 0, 0);
              doc.text("We can include more paragraphs, images, or further data here.", 40, 90);
              doc.text("Using multiple pages ensures your PDF remains organized and readable.", 40, 110);
              
              // Example second table or content
              doc.setFont("helvetica", "italic");
              doc.text("End of Report", 40, 160);
              doc.text("Hello World", 10, 190); 

            //GUARDAR EL PDF
            //doc.save("document.pdf"); //Nombre con el que se guarda el archivo

            //PERZONALIZAR TEXTO
            doc.setFontSize(18);
            doc.setFont("times", "italic");
            doc.setTextColor(50, 50, 150);
            doc.text("Custom PDF Title", 20, 30);


            const contenido = document.getElementById("contenido");

              doc.html(contenido, {
                callback: function (doc) {
                    //Agregar paginas 
                  //doc.addPage();
                  doc.text("Texto adicional después del HTML", 10, 100);
                  doc.save("documento.pdf");  
                },
                x: 10,
                y: 10, 
                width: 190, // en mm (210 mm ancho A4 menos márgenes)
          
              });

            //ABRIR EN OTRA VENTANA EL PDF
            const blob = doc.output('blob');
            const blobUrl = URL.createObjectURL(blob);
    window.open(blobUrl, '_blank'); 
  })



    //https://www.liderempresarial.com/guia-asistentes-microsoft-community-days/
  </script>
</body>
</html>
-->
