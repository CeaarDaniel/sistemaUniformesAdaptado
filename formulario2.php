<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Pedido</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --pastel-purple: #d8b4fe;
            --light-purple: #e9d5ff;
            --pastel-blue: #bfdbfe;
            --light-blue: #e0f2fe;
            --dark-purple: #7e22ce;
        }
        
        body {
            background-color: #faf5ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .form-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }
        
        .form-title {
            color: var(--dark-purple);
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        
        .form-label {
            color: var(--dark-purple);
            font-weight: 500;
        }
        
        .form-control, .form-select {
            border: 1px solid var(--pastel-purple);
            border-radius: 8px;
            padding: 0.75rem;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--pastel-blue);
            box-shadow: 0 0 0 0.25rem rgba(191, 219, 254, 0.25);
        }
        
        .btn-submit {
            background-color: var(--pastel-purple);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .btn-submit:hover {
            background-color: var(--dark-purple);
            transform: translateY(-2px);
        }
        
        .discount-badge {
            background-color: var(--pastel-blue);
            color: var(--dark-purple);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            display: inline-block;
            margin-left: 10px;
        }
        
        .form-check-input:checked {
            background-color: var(--pastel-purple);
            border-color: var(--pastel-purple);
        }
        
        .form-section {
            margin-bottom: 1.5rem;
            padding: 1.5rem;
            background-color: var(--light-purple);
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        
        .form-section:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.05);
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
        <div class="form-container">
            <h2 class="form-title">Confirmación de Pedido</h2>
            
            <form>
                <!-- Sección de Fecha -->
                <div class="form-section">
                    <div class="mb-3">
                        <label for="orderDate" class="form-label">Fecha del Pedido</label>
                        <input type="date" class="form-control" id="orderDate" required>
                    </div>
                </div>
                
                <!-- Sección de Pago y Descuento -->
                <div class="form-section">
                    <div class="mb-3">
                        <label for="paymentMethod" class="form-label">Método de Pago</label>
                        <select class="form-select" id="paymentMethod" required>
                            <option selected disabled value="">Seleccione un método</option>
                            <option value="credit">Tarjeta de Crédito</option>
                            <option value="debit">Tarjeta de Débito</option>
                            <option value="transfer">Transferencia Bancaria</option>
                            <option value="cash">Efectivo</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Descuento Aplicado 
                            <span class="discount-badge">15% OFF</span>
                        </label>
                        <input type="number" class="form-control" value="15" min="0" max="100" step="5" disabled>
                        <div class="form-text text-muted">Descuento especial por temporada</div>
                    </div>
                </div>
                
                <!-- Sección de Confirmación -->
                <div class="form-section">
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="confirmOrder" required>
                        <label class="form-check-label" for="confirmOrder">Confirmo que los datos son correctos y deseo concretar el pedido</label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-submit mt-3">Finalizar Pedido</button>
            </form>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>