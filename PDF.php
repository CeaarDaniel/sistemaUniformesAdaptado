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
                                                        <div class="mx-5 d-flex justify-content-between">
                                                            <img src="./imagenes/beyonz.jpg" style="max: width 150px; max-height:50px;">
                                                        </div>

                                                        <p class="text-center" style="font-size:20px;"><b> Reporte de Inventario </b></p>

                                                        <p class="text-start mb-0" style="font-size:15px"> <b>Categoría:</b> Todos</p>
                                                         <hr class="mt-0 mb-1" style="height: 5px; background: linear-gradient(90deg,rgba(9, 11, 122, 1) 33%, rgba(133, 133, 133, 1) 0%); opacity: 1; border:none;">
                                                                    

                                                        <p class="text-center m-0 p-0" style="font-size:16px;"><b>ARTÍCULOS</b></p>
                                                         <table class="table mt-1" style="font-size:12px;">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Clave</th>
                                                                    <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Nombre</th>
                                                                    <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Cantidad</th>
                                                                    <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Costo uni.</th>
                                                                    <th class="text-center m-0" style="background-color: rgb(13, 71, 161); color:white">Precio</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody style="font-size:12px">
                                                            <tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 1</td>
                                        <td class="py-1 my-1"> PLAYERA ML-Hombre T XS</td>
                                        <td class="py-1 my-1"> 3</td>
                                        <td class="py-1 my-1">$ 243.00</td>
                                        <td class="py-1 my-1">$ 243.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 2</td>
                                        <td class="py-1 my-1"> PLAYERA ML-Hombre T S</td>
                                        <td class="py-1 my-1"> 22</td>
                                        <td class="py-1 my-1">$ 243.00</td>
                                        <td class="py-1 my-1">$ 243.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 3</td>
                                        <td class="py-1 my-1"> PLAYERA ML-Hombre T M</td>
                                        <td class="py-1 my-1"> 11</td>
                                        <td class="py-1 my-1">$ 243.00</td>
                                        <td class="py-1 my-1">$ 243.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 4</td>
                                        <td class="py-1 my-1"> PLAYERA ML-Hombre T L</td>
                                        <td class="py-1 my-1"> 16</td>
                                        <td class="py-1 my-1">$ 243.00</td>
                                        <td class="py-1 my-1">$ 243.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 5</td>
                                        <td class="py-1 my-1"> PLAYERA ML-Hombre T XL</td>
                                        <td class="py-1 my-1"> 21</td>
                                        <td class="py-1 my-1">$ 243.00</td>
                                        <td class="py-1 my-1">$ 243.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 6</td>
                                        <td class="py-1 my-1"> PLAYERA ML-Hombre T 2XL</td>
                                        <td class="py-1 my-1"> 18</td>
                                        <td class="py-1 my-1">$ 243.00</td>
                                        <td class="py-1 my-1">$ 243.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 7</td>
                                        <td class="py-1 my-1"> PLAYERA ML-Mujer T XS</td>
                                        <td class="py-1 my-1"> 0</td>
                                        <td class="py-1 my-1">$ 243.00</td>
                                        <td class="py-1 my-1">$ 243.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 8</td>
                                        <td class="py-1 my-1"> PLAYERA ML-Mujer T S</td>
                                        <td class="py-1 my-1"> 22</td>
                                        <td class="py-1 my-1">$ 243.00</td>
                                        <td class="py-1 my-1">$ 243.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 9</td>
                                        <td class="py-1 my-1"> PLAYERA ML-Mujer T M</td>
                                        <td class="py-1 my-1"> 19</td>
                                        <td class="py-1 my-1">$ 243.00</td>
                                        <td class="py-1 my-1">$ 243.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 10</td>
                                        <td class="py-1 my-1"> PLAYERA ML-Mujer T L</td>
                                        <td class="py-1 my-1"> 16</td>
                                        <td class="py-1 my-1">$ 243.00</td>
                                        <td class="py-1 my-1">$ 243.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 11</td>
                                        <td class="py-1 my-1"> PLAYERA ML-Mujer T XL</td>
                                        <td class="py-1 my-1"> 17</td>
                                        <td class="py-1 my-1">$ 243.00</td>
                                        <td class="py-1 my-1">$ 243.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 12</td>
                                        <td class="py-1 my-1"> PLAYERA ML-Mujer T 2XL</td>
                                        <td class="py-1 my-1"> 22</td>
                                        <td class="py-1 my-1">$ 243.00</td>
                                        <td class="py-1 my-1">$ 243.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 13</td>
                                        <td class="py-1 my-1"> PLAYERA MC-Hombre T XS</td>
                                        <td class="py-1 my-1"> 3</td>
                                        <td class="py-1 my-1">$ 206.00</td>
                                        <td class="py-1 my-1">$ 206.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 14</td>
                                        <td class="py-1 my-1"> PLAYERA MC-Hombre T S</td>
                                        <td class="py-1 my-1"> 21</td>
                                        <td class="py-1 my-1">$ 206.00</td>
                                        <td class="py-1 my-1">$ 206.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 15</td>
                                        <td class="py-1 my-1"> PLAYERA MC-Hombre T M</td>
                                        <td class="py-1 my-1"> 9</td>
                                        <td class="py-1 my-1">$ 206.00</td>
                                        <td class="py-1 my-1">$ 206.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 16</td>
                                        <td class="py-1 my-1"> PLAYERA MC-Hombre T L</td>
                                        <td class="py-1 my-1"> 12</td>
                                        <td class="py-1 my-1">$ 206.00</td>
                                        <td class="py-1 my-1">$ 206.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 17</td>
                                        <td class="py-1 my-1"> PLAYERA MC-Hombre T XL</td>
                                        <td class="py-1 my-1"> 16</td>
                                        <td class="py-1 my-1">$ 206.00</td>
                                        <td class="py-1 my-1">$ 206.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 18</td>
                                        <td class="py-1 my-1"> PLAYERA MC-Hombre T 2XL</td>
                                        <td class="py-1 my-1"> 14</td>
                                        <td class="py-1 my-1">$ 206.00</td>
                                        <td class="py-1 my-1">$ 206.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 19</td>
                                        <td class="py-1 my-1"> PLAYERA MC-Mujer T XS</td>
                                        <td class="py-1 my-1"> 9</td>
                                        <td class="py-1 my-1">$ 206.00</td>
                                        <td class="py-1 my-1">$ 206.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 20</td>
                                        <td class="py-1 my-1"> PLAYERA MC-Mujer T S</td>
                                        <td class="py-1 my-1"> 13</td>
                                        <td class="py-1 my-1">$ 206.00</td>
                                        <td class="py-1 my-1">$ 206.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 21</td>
                                        <td class="py-1 my-1"> PLAYERA MC-Mujer T M</td>
                                        <td class="py-1 my-1"> 25</td>
                                        <td class="py-1 my-1">$ 206.00</td>
                                        <td class="py-1 my-1">$ 206.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 22</td>
                                        <td class="py-1 my-1"> PLAYERA MC-Mujer T L</td>
                                        <td class="py-1 my-1"> 15</td>
                                        <td class="py-1 my-1">$ 206.00</td>
                                        <td class="py-1 my-1">$ 206.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 23</td>
                                        <td class="py-1 my-1"> PLAYERA MC-Mujer T XL</td>
                                        <td class="py-1 my-1"> 17</td>
                                        <td class="py-1 my-1">$ 206.00</td>
                                        <td class="py-1 my-1">$ 206.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 24</td>
                                        <td class="py-1 my-1"> PLAYERA MC-Mujer T 2XL</td>
                                        <td class="py-1 my-1"> 25</td>
                                        <td class="py-1 my-1">$ 206.00</td>
                                        <td class="py-1 my-1">$ 206.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 25</td>
                                        <td class="py-1 my-1"> CAMISA ML-Hombre T XS</td>
                                        <td class="py-1 my-1"> 5</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 26</td>
                                        <td class="py-1 my-1"> CAMISA ML-Hombre T S</td>
                                        <td class="py-1 my-1"> 10</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 27</td>
                                        <td class="py-1 my-1"> CAMISA ML-Hombre T M</td>
                                        <td class="py-1 my-1"> 13</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 28</td>
                                        <td class="py-1 my-1"> CAMISA ML-Hombre T L</td>
                                        <td class="py-1 my-1"> 23</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 29</td>
                                        <td class="py-1 my-1"> CAMISA ML-Hombre T XL</td>
                                        <td class="py-1 my-1"> 20</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 30</td>
                                        <td class="py-1 my-1"> CAMISA ML-Hombre T 2XL</td>
                                        <td class="py-1 my-1"> 8</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 31</td>
                                        <td class="py-1 my-1"> CAMISA ML-Mujer T XS</td>
                                        <td class="py-1 my-1"> 4</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 32</td>
                                        <td class="py-1 my-1"> CAMISA ML-Mujer T S</td>
                                        <td class="py-1 my-1"> 2</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 33</td>
                                        <td class="py-1 my-1"> CAMISA ML-Mujer T M</td>
                                        <td class="py-1 my-1"> 23</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 34</td>
                                        <td class="py-1 my-1"> CAMISA ML-Mujer T L</td>
                                        <td class="py-1 my-1"> 15</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 35</td>
                                        <td class="py-1 my-1"> CAMISA ML-Mujer T XL</td>
                                        <td class="py-1 my-1"> 13</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 36</td>
                                        <td class="py-1 my-1"> CAMISA ML-Mujer T 2XL</td>
                                        <td class="py-1 my-1"> 9</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 37</td>
                                        <td class="py-1 my-1"> CAMISA MC-Hombre T XS</td>
                                        <td class="py-1 my-1"> 14</td>
                                        <td class="py-1 my-1">$ 334.00</td>
                                        <td class="py-1 my-1">$ 334.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 38</td>
                                        <td class="py-1 my-1"> CAMISA MC-Hombre T S</td>
                                        <td class="py-1 my-1"> 25</td>
                                        <td class="py-1 my-1">$ 334.00</td>
                                        <td class="py-1 my-1">$ 334.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 39</td>
                                        <td class="py-1 my-1"> CAMISA MC-Hombre T M</td>
                                        <td class="py-1 my-1"> 10</td>
                                        <td class="py-1 my-1">$ 334.00</td>
                                        <td class="py-1 my-1">$ 334.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 40</td>
                                        <td class="py-1 my-1"> CAMISA MC-Hombre T L</td>
                                        <td class="py-1 my-1"> 20</td>
                                        <td class="py-1 my-1">$ 334.00</td>
                                        <td class="py-1 my-1">$ 334.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 41</td>
                                        <td class="py-1 my-1"> CAMISA MC-Hombre T XL</td>
                                        <td class="py-1 my-1"> 26</td>
                                        <td class="py-1 my-1">$ 334.00</td>
                                        <td class="py-1 my-1">$ 334.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 42</td>
                                        <td class="py-1 my-1"> CAMISA MC-Hombre T 2XL</td>
                                        <td class="py-1 my-1"> 6</td>
                                        <td class="py-1 my-1">$ 334.00</td>
                                        <td class="py-1 my-1">$ 334.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 43</td>
                                        <td class="py-1 my-1"> CAMISA MC-Mujer T XS</td>
                                        <td class="py-1 my-1"> 4</td>
                                        <td class="py-1 my-1">$ 334.00</td>
                                        <td class="py-1 my-1">$ 334.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 44</td>
                                        <td class="py-1 my-1"> CAMISA MC-Mujer T S</td>
                                        <td class="py-1 my-1"> 11</td>
                                        <td class="py-1 my-1">$ 334.00</td>
                                        <td class="py-1 my-1">$ 334.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 45</td>
                                        <td class="py-1 my-1"> CAMISA MC-Mujer T M</td>
                                        <td class="py-1 my-1"> 12</td>
                                        <td class="py-1 my-1">$ 334.00</td>
                                        <td class="py-1 my-1">$ 334.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 46</td>
                                        <td class="py-1 my-1"> CAMISA MC-Mujer T L</td>
                                        <td class="py-1 my-1"> 13</td>
                                        <td class="py-1 my-1">$ 334.00</td>
                                        <td class="py-1 my-1">$ 334.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 47</td>
                                        <td class="py-1 my-1"> CAMISA MC-Mujer T XL</td>
                                        <td class="py-1 my-1"> 7</td>
                                        <td class="py-1 my-1">$ 334.00</td>
                                        <td class="py-1 my-1">$ 334.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 48</td>
                                        <td class="py-1 my-1"> CAMISA MC-Mujer T 2XL</td>
                                        <td class="py-1 my-1"> 9</td>
                                        <td class="py-1 my-1">$ 334.00</td>
                                        <td class="py-1 my-1">$ 334.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 49</td>
                                        <td class="py-1 my-1"> CHAMARRA-T XS</td>
                                        <td class="py-1 my-1"> 0</td>
                                        <td class="py-1 my-1">$ 508.00</td>
                                        <td class="py-1 my-1">$ 508.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 50</td>
                                        <td class="py-1 my-1"> CHAMARRA-T S</td>
                                        <td class="py-1 my-1"> 8</td>
                                        <td class="py-1 my-1">$ 508.00</td>
                                        <td class="py-1 my-1">$ 508.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 51</td>
                                        <td class="py-1 my-1"> CHAMARRA-T M</td>
                                        <td class="py-1 my-1"> 1</td>
                                        <td class="py-1 my-1">$ 508.00</td>
                                        <td class="py-1 my-1">$ 508.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 52</td>
                                        <td class="py-1 my-1"> CHAMARRA-T L</td>
                                        <td class="py-1 my-1"> 0</td>
                                        <td class="py-1 my-1">$ 508.00</td>
                                        <td class="py-1 my-1">$ 508.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 53</td>
                                        <td class="py-1 my-1"> CHAMARRA-T XL</td>
                                        <td class="py-1 my-1"> 9</td>
                                        <td class="py-1 my-1">$ 508.00</td>
                                        <td class="py-1 my-1">$ 508.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 54</td>
                                        <td class="py-1 my-1"> CHAMARRA-T 2XL</td>
                                        <td class="py-1 my-1"> 9</td>
                                        <td class="py-1 my-1">$ 508.00</td>
                                        <td class="py-1 my-1">$ 508.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 55</td>
                                        <td class="py-1 my-1"> PANTALÓN-Hombre T 26</td>
                                        <td class="py-1 my-1"> 4</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 56</td>
                                        <td class="py-1 my-1"> PANTALÓN-Hombre T 28</td>
                                        <td class="py-1 my-1"> 18</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 57</td>
                                        <td class="py-1 my-1"> PANTALÓN-Hombre T 30</td>
                                        <td class="py-1 my-1"> 24</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 58</td>
                                        <td class="py-1 my-1"> PANTALÓN-Hombre T 32</td>
                                        <td class="py-1 my-1"> 10</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 59</td>
                                        <td class="py-1 my-1"> PANTALÓN-Hombre T 34</td>
                                        <td class="py-1 my-1"> 20</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 60</td>
                                        <td class="py-1 my-1"> PANTALÓN-Hombre T 36</td>
                                        <td class="py-1 my-1"> 22</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 61</td>
                                        <td class="py-1 my-1"> PANTALÓN-Hombre T 38</td>
                                        <td class="py-1 my-1"> 9</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 62</td>
                                        <td class="py-1 my-1"> PANTALÓN-Hombre T 40</td>
                                        <td class="py-1 my-1"> 9</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 63</td>
                                        <td class="py-1 my-1"> PANTALÓN-Hombre T 42</td>
                                        <td class="py-1 my-1"> 10</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 64</td>
                                        <td class="py-1 my-1"> PANTALÓN-Mujer T 26</td>
                                        <td class="py-1 my-1"> 11</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 65</td>
                                        <td class="py-1 my-1"> PANTALÓN-Mujer T 28</td>
                                        <td class="py-1 my-1"> 16</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 66</td>
                                        <td class="py-1 my-1"> PANTALÓN-Mujer T 30</td>
                                        <td class="py-1 my-1"> 24</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 67</td>
                                        <td class="py-1 my-1"> PANTALÓN-Mujer T 32</td>
                                        <td class="py-1 my-1"> 19</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 68</td>
                                        <td class="py-1 my-1"> PANTALÓN-Mujer T 34</td>
                                        <td class="py-1 my-1"> 19</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 69</td>
                                        <td class="py-1 my-1"> PANTALÓN-Mujer T 36</td>
                                        <td class="py-1 my-1"> 21</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 70</td>
                                        <td class="py-1 my-1"> PANTALÓN-Mujer T 38</td>
                                        <td class="py-1 my-1"> 13</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 71</td>
                                        <td class="py-1 my-1"> PANTALÓN-Mujer T 40</td>
                                        <td class="py-1 my-1"> 11</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 72</td>
                                        <td class="py-1 my-1"> PANTALÓN-Mujer T 42</td>
                                        <td class="py-1 my-1"> 2</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                        <td class="py-1 my-1">$ 322.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 73</td>
                                        <td class="py-1 my-1"> ZAPATOS-T 21.5</td>
                                        <td class="py-1 my-1"> 4</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 74</td>
                                        <td class="py-1 my-1"> ZAPATOS-T 22</td>
                                        <td class="py-1 my-1"> 4</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 75</td>
                                        <td class="py-1 my-1"> ZAPATOS-T 22.5</td>
                                        <td class="py-1 my-1"> 0</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 76</td>
                                        <td class="py-1 my-1"> ZAPATOS-T 23</td>
                                        <td class="py-1 my-1"> 10</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 77</td>
                                        <td class="py-1 my-1"> ZAPATOS-T 23.5</td>
                                        <td class="py-1 my-1"> 0</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 78</td>
                                        <td class="py-1 my-1"> ZAPATOS-T 24</td>
                                        <td class="py-1 my-1"> 5</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 79</td>
                                        <td class="py-1 my-1"> ZAPATOS-T 24.5</td>
                                        <td class="py-1 my-1"> 0</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 80</td>
                                        <td class="py-1 my-1"> ZAPATOS-T 25</td>
                                        <td class="py-1 my-1"> 12</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 81</td>
                                        <td class="py-1 my-1"> ZAPATOS-T 25.5</td>
                                        <td class="py-1 my-1"> 0</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 82</td>
                                        <td class="py-1 my-1"> ZAPATOS-T 26</td>
                                        <td class="py-1 my-1"> 16</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 83</td>
                                        <td class="py-1 my-1"> ZAPATOS-T 26.5</td>
                                        <td class="py-1 my-1"> 0</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 84</td>
                                        <td class="py-1 my-1"> ZAPATOS-T 27</td>
                                        <td class="py-1 my-1"> 1</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 85</td>
                                        <td class="py-1 my-1"> ZAPATOS-T 27.5</td>
                                        <td class="py-1 my-1"> 0</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 86</td>
                                        <td class="py-1 my-1"> ZAPATOS-T 28</td>
                                        <td class="py-1 my-1"> 7</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 87</td>
                                        <td class="py-1 my-1"> ZAPATOS-T 28.5</td>
                                        <td class="py-1 my-1"> 0</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 88</td>
                                        <td class="py-1 my-1"> ZAPATOS-T 29</td>
                                        <td class="py-1 my-1"> 13</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 89</td>
                                        <td class="py-1 my-1"> ZAPATOS-T 29.5</td>
                                        <td class="py-1 my-1"> 1</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 90</td>
                                        <td class="py-1 my-1"> ZAPATOS-T 30</td>
                                        <td class="py-1 my-1"> 7</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 91</td>
                                        <td class="py-1 my-1"> ZAPATOS-T 30.5</td>
                                        <td class="py-1 my-1"> 3</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                        <td class="py-1 my-1">$ 450.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 92</td>
                                        <td class="py-1 my-1"> GORRA-T Azul Marino</td>
                                        <td class="py-1 my-1"> 46</td>
                                        <td class="py-1 my-1">$ 79.00</td>
                                        <td class="py-1 my-1">$ 79.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 93</td>
                                        <td class="py-1 my-1"> GORRA-T Amarillo</td>
                                        <td class="py-1 my-1"> 50</td>
                                        <td class="py-1 my-1">$ 79.00</td>
                                        <td class="py-1 my-1">$ 79.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 94</td>
                                        <td class="py-1 my-1"> GORRA-T Verde</td>
                                        <td class="py-1 my-1"> 25</td>
                                        <td class="py-1 my-1">$ 79.00</td>
                                        <td class="py-1 my-1">$ 79.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 95</td>
                                        <td class="py-1 my-1"> GORRA-T Morada</td>
                                        <td class="py-1 my-1"> 1</td>
                                        <td class="py-1 my-1">$ 79.00</td>
                                        <td class="py-1 my-1">$ 79.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 96</td>
                                        <td class="py-1 my-1"> GORRA-T Azul Director</td>
                                        <td class="py-1 my-1"> 11</td>
                                        <td class="py-1 my-1">$ 79.00</td>
                                        <td class="py-1 my-1">$ 79.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 97</td>
                                        <td class="py-1 my-1"> LENTES-T N/A</td>
                                        <td class="py-1 my-1"> 58</td>
                                        <td class="py-1 my-1">$ 35.00</td>
                                        <td class="py-1 my-1">$ 35.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 194</td>
                                        <td class="py-1 my-1"> GORRA-T Gris</td>
                                        <td class="py-1 my-1"> 18</td>
                                        <td class="py-1 my-1">$ 79.00</td>
                                        <td class="py-1 my-1">$ 79.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 195</td>
                                        <td class="py-1 my-1"> CHALECO ENT-T UNI</td>
                                        <td class="py-1 my-1"> 32</td>
                                        <td class="py-1 my-1">$ 254.00</td>
                                        <td class="py-1 my-1">$ 254.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 197</td>
                                        <td class="py-1 my-1"> GUANTE ANTICORTE-T 6</td>
                                        <td class="py-1 my-1"> 300</td>
                                        <td class="py-1 my-1">$ 82.00</td>
                                        <td class="py-1 my-1">$ 82.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 198</td>
                                        <td class="py-1 my-1"> GUANTE ANTICORTE-T 7</td>
                                        <td class="py-1 my-1"> 31</td>
                                        <td class="py-1 my-1">$ 82.00</td>
                                        <td class="py-1 my-1">$ 82.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 199</td>
                                        <td class="py-1 my-1"> GUANTE ANTICORTE-T 8</td>
                                        <td class="py-1 my-1"> 67</td>
                                        <td class="py-1 my-1">$ 82.00</td>
                                        <td class="py-1 my-1">$ 82.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 200</td>
                                        <td class="py-1 my-1"> GUANTE ANTICORTE-T 9</td>
                                        <td class="py-1 my-1"> 68</td>
                                        <td class="py-1 my-1">$ 82.00</td>
                                        <td class="py-1 my-1">$ 82.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 201</td>
                                        <td class="py-1 my-1"> GUANTE ANTICORTE-T 10</td>
                                        <td class="py-1 my-1"> 176</td>
                                        <td class="py-1 my-1">$ 82.00</td>
                                        <td class="py-1 my-1">$ 82.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 202</td>
                                        <td class="py-1 my-1"> GUANTE CARRNAZA-T 6</td>
                                        <td class="py-1 my-1"> 12</td>
                                        <td class="py-1 my-1">$ .00</td>
                                        <td class="py-1 my-1">$ .00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 203</td>
                                        <td class="py-1 my-1"> GUANTE CARRNAZA-T 8</td>
                                        <td class="py-1 my-1"> 12</td>
                                        <td class="py-1 my-1">$ .00</td>
                                        <td class="py-1 my-1">$ .00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 204</td>
                                        <td class="py-1 my-1"> GUANTE CARRNAZA-T 9</td>
                                        <td class="py-1 my-1"> 12</td>
                                        <td class="py-1 my-1">$ .00</td>
                                        <td class="py-1 my-1">$ .00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 205</td>
                                        <td class="py-1 my-1"> GUANTE CARRNAZA-T 10</td>
                                        <td class="py-1 my-1"> 12</td>
                                        <td class="py-1 my-1">$ .00</td>
                                        <td class="py-1 my-1">$ .00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 206</td>
                                        <td class="py-1 my-1"> GUANTE CARRNAZA-T 7</td>
                                        <td class="py-1 my-1"> 12</td>
                                        <td class="py-1 my-1">$ .00</td>
                                        <td class="py-1 my-1">$ .00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 207</td>
                                        <td class="py-1 my-1"> GUANTES NITRILO-T S</td>
                                        <td class="py-1 my-1"> 13</td>
                                        <td class="py-1 my-1">$ 250.00</td>
                                        <td class="py-1 my-1">$ 250.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 208</td>
                                        <td class="py-1 my-1"> GUANTES NITRILO-T M</td>
                                        <td class="py-1 my-1"> 91</td>
                                        <td class="py-1 my-1">$ 250.00</td>
                                        <td class="py-1 my-1">$ 250.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 209</td>
                                        <td class="py-1 my-1"> GUANTES NITRILO-T L</td>
                                        <td class="py-1 my-1"> 19</td>
                                        <td class="py-1 my-1">$ 250.00</td>
                                        <td class="py-1 my-1">$ 250.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 210</td>
                                        <td class="py-1 my-1"> GUANTE PUNTOS PVC-T 6</td>
                                        <td class="py-1 my-1"> 12</td>
                                        <td class="py-1 my-1">$ .00</td>
                                        <td class="py-1 my-1">$ .00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 211</td>
                                        <td class="py-1 my-1"> GUANTE PUNTOS PVC-T 7</td>
                                        <td class="py-1 my-1"> 12</td>
                                        <td class="py-1 my-1">$ .00</td>
                                        <td class="py-1 my-1">$ .00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 212</td>
                                        <td class="py-1 my-1"> GUANTE PUNTOS PVC-T 8</td>
                                        <td class="py-1 my-1"> 12</td>
                                        <td class="py-1 my-1">$ .00</td>
                                        <td class="py-1 my-1">$ .00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 213</td>
                                        <td class="py-1 my-1"> GUANTE PUNTOS PVC-T 9</td>
                                        <td class="py-1 my-1"> 12</td>
                                        <td class="py-1 my-1">$ .00</td>
                                        <td class="py-1 my-1">$ .00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 214</td>
                                        <td class="py-1 my-1"> GUANTE PUNTOS PVC-T 10</td>
                                        <td class="py-1 my-1"> 12</td>
                                        <td class="py-1 my-1">$ .00</td>
                                        <td class="py-1 my-1">$ .00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 215</td>
                                        <td class="py-1 my-1"> GUANTE SOLVEX-T 6</td>
                                        <td class="py-1 my-1"> 200</td>
                                        <td class="py-1 my-1">$ 31.00</td>
                                        <td class="py-1 my-1">$ 31.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 216</td>
                                        <td class="py-1 my-1"> GUANTE SOLVEX-T 7</td>
                                        <td class="py-1 my-1"> 140</td>
                                        <td class="py-1 my-1">$ 31.00</td>
                                        <td class="py-1 my-1">$ 31.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 217</td>
                                        <td class="py-1 my-1"> GUANTE SOLVEX-T 8</td>
                                        <td class="py-1 my-1"> 107</td>
                                        <td class="py-1 my-1">$ 31.00</td>
                                        <td class="py-1 my-1">$ 31.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 218</td>
                                        <td class="py-1 my-1"> GUANTE SOLVEX-T 9</td>
                                        <td class="py-1 my-1"> 79</td>
                                        <td class="py-1 my-1">$ 31.00</td>
                                        <td class="py-1 my-1">$ 31.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 219</td>
                                        <td class="py-1 my-1"> GUANTE SOLVEX-T 10</td>
                                        <td class="py-1 my-1"> 200</td>
                                        <td class="py-1 my-1">$ 31.00</td>
                                        <td class="py-1 my-1">$ 31.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 220</td>
                                        <td class="py-1 my-1"> GUANTE INSPECCION-T 6</td>
                                        <td class="py-1 my-1"> 117</td>
                                        <td class="py-1 my-1">$ .00</td>
                                        <td class="py-1 my-1">$ .00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 221</td>
                                        <td class="py-1 my-1"> GUANTE INSPECCION-T 7</td>
                                        <td class="py-1 my-1"> 348</td>
                                        <td class="py-1 my-1">$ .00</td>
                                        <td class="py-1 my-1">$ .00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 222</td>
                                        <td class="py-1 my-1"> GUANTE INSPECCION-T 8</td>
                                        <td class="py-1 my-1"> 126</td>
                                        <td class="py-1 my-1">$ .00</td>
                                        <td class="py-1 my-1">$ .00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 223</td>
                                        <td class="py-1 my-1"> GUANTE INSPECCION-T 9</td>
                                        <td class="py-1 my-1"> 762</td>
                                        <td class="py-1 my-1">$ .00</td>
                                        <td class="py-1 my-1">$ .00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 224</td>
                                        <td class="py-1 my-1"> GUANTE INSPECCION-T 10</td>
                                        <td class="py-1 my-1"> 1000</td>
                                        <td class="py-1 my-1">$ .00</td>
                                        <td class="py-1 my-1">$ .00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 225</td>
                                        <td class="py-1 my-1"> CHALECO-T XS</td>
                                        <td class="py-1 my-1"> 1</td>
                                        <td class="py-1 my-1">$ 254.00</td>
                                        <td class="py-1 my-1">$ 254.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 226</td>
                                        <td class="py-1 my-1"> CHALECO-T S</td>
                                        <td class="py-1 my-1"> 0</td>
                                        <td class="py-1 my-1">$ 254.00</td>
                                        <td class="py-1 my-1">$ 254.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 227</td>
                                        <td class="py-1 my-1"> CHALECO-T M</td>
                                        <td class="py-1 my-1"> 3</td>
                                        <td class="py-1 my-1">$ 254.00</td>
                                        <td class="py-1 my-1">$ 254.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 228</td>
                                        <td class="py-1 my-1"> CHALECO-T L</td>
                                        <td class="py-1 my-1"> 0</td>
                                        <td class="py-1 my-1">$ 254.00</td>
                                        <td class="py-1 my-1">$ 254.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 229</td>
                                        <td class="py-1 my-1"> CHALECO-T XL</td>
                                        <td class="py-1 my-1"> 1</td>
                                        <td class="py-1 my-1">$ 254.00</td>
                                        <td class="py-1 my-1">$ 254.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 230</td>
                                        <td class="py-1 my-1"> CHALECO-T 2XL</td>
                                        <td class="py-1 my-1"> 0</td>
                                        <td class="py-1 my-1">$ 254.00</td>
                                        <td class="py-1 my-1">$ 254.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 231</td>
                                        <td class="py-1 my-1"> SUDA-T XS</td>
                                        <td class="py-1 my-1"> 0</td>
                                        <td class="py-1 my-1">$ 126.00</td>
                                        <td class="py-1 my-1">$ 126.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 232</td>
                                        <td class="py-1 my-1"> SUDA-T S</td>
                                        <td class="py-1 my-1"> 32</td>
                                        <td class="py-1 my-1">$ 126.00</td>
                                        <td class="py-1 my-1">$ 126.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 233</td>
                                        <td class="py-1 my-1"> SUDA-T M</td>
                                        <td class="py-1 my-1"> 18</td>
                                        <td class="py-1 my-1">$ 126.00</td>
                                        <td class="py-1 my-1">$ 126.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 234</td>
                                        <td class="py-1 my-1"> SUDA-T L</td>
                                        <td class="py-1 my-1"> 19</td>
                                        <td class="py-1 my-1">$ 126.00</td>
                                        <td class="py-1 my-1">$ 126.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 235</td>
                                        <td class="py-1 my-1"> SUDA-T XL</td>
                                        <td class="py-1 my-1"> 10</td>
                                        <td class="py-1 my-1">$ 126.00</td>
                                        <td class="py-1 my-1">$ 126.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 236</td>
                                        <td class="py-1 my-1"> SUDA-T 2XL</td>
                                        <td class="py-1 my-1"> 0</td>
                                        <td class="py-1 my-1">$ 126.00</td>
                                        <td class="py-1 my-1">$ 126.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 237</td>
                                        <td class="py-1 my-1"> CHAMARRA ROMPE-T XS</td>
                                        <td class="py-1 my-1"> 0</td>
                                        <td class="py-1 my-1">$ 266.00</td>
                                        <td class="py-1 my-1">$ 266.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 238</td>
                                        <td class="py-1 my-1"> CHAMARRA ROMPE-T S</td>
                                        <td class="py-1 my-1"> 0</td>
                                        <td class="py-1 my-1">$ 266.00</td>
                                        <td class="py-1 my-1">$ 266.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 239</td>
                                        <td class="py-1 my-1"> CHAMARRA ROMPE-T M</td>
                                        <td class="py-1 my-1"> 2</td>
                                        <td class="py-1 my-1">$ 266.00</td>
                                        <td class="py-1 my-1">$ 266.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 240</td>
                                        <td class="py-1 my-1"> CHAMARRA ROMPE-T L</td>
                                        <td class="py-1 my-1"> 3</td>
                                        <td class="py-1 my-1">$ 266.00</td>
                                        <td class="py-1 my-1">$ 266.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 241</td>
                                        <td class="py-1 my-1"> CHAMARRA ROMPE-T XL</td>
                                        <td class="py-1 my-1"> 11</td>
                                        <td class="py-1 my-1">$ 266.00</td>
                                        <td class="py-1 my-1">$ 266.00</td>
                                    </tr><tr class="page-break-avoid py-0 my-0">
                                        <td class="py-1 my-1"> 242</td>
                                        <td class="py-1 my-1"> CHAMARRA ROMPE-T 2XL</td>
                                        <td class="py-1 my-1"> 1</td>
                                        <td class="py-1 my-1">$ 266.00</td>
                                        <td class="py-1 my-1">$ 266.00</td>
                                    </tr>
                                                            </tbody>
                                                        </table>
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