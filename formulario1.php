<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Pedido Elegante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --lavender: #e6e6fa;
            --periwinkle: #c3cde6;
            --pastel-blue: #a7c5eb;
            --soft-purple: #c8a2c8;
            --dark-purple: #6a1b9a;
        }

        body {
            background: linear-gradient(135deg, #f0f4ff 0%, #fdf2ff 100%);
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }

        .form-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            max-width: 600px;
            margin: 3rem auto;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .form-title {
            color: var(--dark-purple);
            font-weight: 600;
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2rem;
            letter-spacing: -0.5px;
        }

        .form-label {
            color: var(--dark-purple);
            font-weight: 500;
            margin-bottom: 0.8rem;
            display: block;
            font-size: 0.95rem;
        }

        .form-control {
            border: 2px solid var(--periwinkle);
            border-radius: 12px;
            padding: 0.9rem 1.2rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-control:focus {
            border-color: var(--pastel-blue);
            box-shadow: 0 0 0 3px rgba(167, 197, 235, 0.25);
            background: white;
        }

        .discount-badge {
            background: linear-gradient(45deg, var(--soft-purple), var(--pastel-blue));
            color: white;
            padding: 0.4rem 1.2rem;
            border-radius: 8px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-left: 1rem;
        }

        .form-check-input {
            width: 1.3em;
            height: 1.3em;
            border: 2px solid var(--periwinkle);
        }

        .form-check-input:checked {
            background-color: var(--soft-purple);
            border-color: var(--soft-purple);
        }

        .submit-btn {
            background: linear-gradient(45deg, var(--soft-purple), var(--pastel-blue));
            border: none;
            padding: 1rem 2rem;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(200, 162, 200, 0.3);
        }

        .form-section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            border-radius: 15px;
            background: rgba(230, 230, 250, 0.15);
            position: relative;
            overflow: hidden;
        }

        .form-section::after {
            content: '';
            position: absolute;
            top: -50px;
            right: -30px;
            width: 100px;
            height: 100px;
            background: rgba(167, 197, 235, 0.1);
            border-radius: 30% 70% 67% 33% / 30% 30% 70% 70%;
        }

        .animated-border {
            position: relative;
        }

        .animated-border::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--soft-purple);
            transition: width 0.3s ease;
        }

        .animated-border:hover::before {
            width: 100%;
        }

        .decoration-element {
            position: absolute;
            width: 100px;
            height: 100px;
            background-color: var(--pastel-blue);
            opacity: 0.3;
            border-radius: 50%;
            z-index: -1;
        }

        .decoration-1 {
            top: 10%;
            left: 5%;
        }

        .decoration-2 {
            bottom: 10%;
            right: 5%;
        }
    </style>
</head>
<body>

<div class="decoration-element decoration-1"></div>
<div class="decoration-element decoration-2"></div>
    <div class="container">
        <div class="form-card">
            <h1 class="form-title">💜 Confirmar Pedido</h1>

            <form>
                <!-- Sección Fecha -->
                <div class="form-section animated-border">
                    <label class="form-label">📅 Fecha de entrega</label>
                    <input type="date" class="form-control" required>
                </div>

                <!-- Sección Descuento -->
                <div class="form-section animated-border">
                    <div class="d-flex align-items-center mb-3">
                        <label class="form-label">💸 Descuento aplicado</label>
                        <span class="discount-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tag" viewBox="0 0 16 16">
                                <path d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0"/>
                                <path d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1m0 5.586 7 7L13.586 9l-7-7H2z"/>
                            </svg>
                            25% OFF
                        </span>
                    </div>
                    <input type="number" class="form-control" value="25" min="0" max="100" step="5" disabled>
                    <small class="text-muted mt-2 d-block">* Descuento válido hasta fin de mes</small>
                </div>

                <!-- Confirmación -->
                <div class="form-section animated-border">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="confirmCheck" required>
                        <label class="form-check-label" for="confirmCheck">
                            ✅ Confirmo que toda la información es correcta y acepto los términos del servicio
                        </label>
                    </div>
                </div>

                <button type="submit" class="submit-btn mt-4">
                    🚀 Finalizar Compra
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>