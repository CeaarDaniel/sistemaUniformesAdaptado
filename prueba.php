<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Artículos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --pastel-purple: #e2d4f7;
            --lavender: #d8c2f0;
            --periwinkle: #c1d2f2;
            --dark-purple: #6a1b9a;
            --soft-blue: #aec6f9;
        }

        body {
            background: linear-gradient(135deg, #f8f5ff 0%, #f2f7ff 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            max-width: 800px;
            margin: 2rem auto;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        h3 {
            color: var(--dark-purple);
            border-bottom: 2px solid var(--pastel-purple);
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .form-label {
            color: var(--dark-purple);
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-control {
            border: 2px solid var(--pastel-purple);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--soft-blue);
            box-shadow: 0 0 0 3px rgba(174, 198, 249, 0.25);
        }

        .btn-custom {
            background: linear-gradient(45deg, var(--dark-purple), var(--soft-blue));
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 1rem;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(106, 27, 154, 0.2);
        }

        .input-group {
            margin-bottom: 1.2rem;
        }

        .bi-icon {
            color: var(--dark-purple);
            font-size: 1.2rem;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236a1b9a' stroke-width='2'%3e%3cpath d='M6 9l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1em;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <form action="">
                <h3><i class="bi bi-box-seam"></i> Agregar Artículo</h3>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <label class="form-label">
                                <i class="bi bi-key-fill bi-icon"></i>
                                ID
                            </label>
                            <input type="text" id="id" class="form-control" placeholder="ID" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="input-group">
                            <label class="form-label">
                                <i class="bi bi-tag-fill bi-icon"></i>
                                Nombre
                            </label>
                            <input type="text" id="nombre" class="form-control" placeholder="Nombre" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="input-group">
                            <label class="form-label">
                                <i class="bi bi-123 bi-icon"></i>
                                Cantidad
                            </label>
                            <input type="number" id="cantidadArt" class="form-control" placeholder="Cantidad" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="input-group">
                            <label class="form-label">
                                <i class="bi bi-grid-fill bi-icon"></i>
                                Categoría
                            </label>
                            <input type="text" id="tipo" class="form-control" placeholder="Categoría" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="input-group">
                            <label class="form-label">
                                <i class="bi bi-rulers bi-icon"></i>
                                Talla
                            </label>
                            <input type="text" class="form-control" placeholder="Talla" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="input-group">
                            <label class="form-label">
                                <i class="bi bi-gender-ambiguous bi-icon"></i>
                                Género
                            </label>
                            <select class="form-control" id="genero" required>
                                <option value="" disabled selected>Seleccione género</option>
                                <option value="hombre">Hombre</option>
                                <option value="mujer">Mujer</option>
                                <option value="unisex">Unisex</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="input-group">
                            <label class="form-label">
                                <i class="bi bi-currency-exchange bi-icon"></i>
                                Precio
                            </label>
                            <input type="number" id="precio" class="form-control" placeholder="Precio" step="0.01" required>
                        </div>
                    </div>

                    <div class="col-12">
                        <button id="btnAgregarArticulo" class="btn btn-custom" type="button">
                            <i class="bi bi-plus-circle"></i> Agregar Artículo
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>