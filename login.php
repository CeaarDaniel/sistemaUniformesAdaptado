<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login - Sistema de Guantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        #login {
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            background: #f8f9fa;
        }
        
        .login-card {
            max-width: 450px;
            margin: 2rem auto;
            padding: 2rem;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        
        .logo {
            width: 28%;
            margin: 1rem auto;
        }
        
        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
        
        .error-banner {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            min-width: 300px;
        }
    </style>
</head>
<body>
<div id="login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="login-card card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="CamisaBeyonzSVG.svg" alt="Logo" class="logo">
                        <h3 class="card-title mb-2">INICIO DE SESIÓN</h3>
                        <h6 class="card-subtitle text-muted">Sistema de uniformes</h6>
                    </div>

                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" 
                                   class="form-control" 
                                   id="usuarioInput" 
                                   placeholder="Usuario"
                                   autocomplete="off"
                                   aria-label="Usuario">
                            <datalist id="empleadosList"></datalist>
                        </div>
                    </div>

                    <div class="mb-4 position-relative">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" 
                                   class="form-control" 
                                   id="passwordInput"
                                   placeholder="Contraseña">
                            <i class="password-toggle fas fa-eye-slash" 
                               id="togglePassword"
                               onclick="togglePasswordVisibility()"></i>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn" 
                                id="loginButton"
                                onclick="login()" style="background-color:#26a69a; color:white">
                            INICIAR SESIÓN
                        </button>
                    </div>

                    <div class="alert alert-danger mt-3 d-none" 
                         id="errorBanner" 
                         role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <span id="errorMessage"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let state = {
    empleados: [],
    selectedUser: null,
    isLoading: false
};

// Configuración inicial
document.addEventListener('DOMContentLoaded', async () => {
    await loadEmployees();
    setupUserSearch();
});

async function loadEmployees() {
    // Simular carga de empleados
    state.empleados = [
        { ID: 1, Nombre: "Juan Pérez" },
        { ID: 2, Nombre: "María García" },
        { ID: 3, Nombre: "Pedro López" }
    ];
    updateDatalist();
}

function setupUserSearch() {
    const usuarioInput = document.getElementById('usuarioInput');
    const datalist = document.getElementById('empleadosList');
    
    usuarioInput.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        const filtered = state.empleados.filter(emp => 
            emp.Nombre.toLowerCase().includes(searchTerm)
        );
        
        datalist.innerHTML = filtered.map(emp => 
            `<option value="${emp.Nombre}" data-id="${emp.ID}">`
        ).join('');
        
        // Autocompletar si hay una coincidencia exacta
        const exactMatch = filtered.find(emp => 
            emp.Nombre.toLowerCase() === searchTerm
        );
        
        if(exactMatch) {
            state.selectedUser = exactMatch;
            document.getElementById('passwordInput').focus();
        }
    });
}

function togglePasswordVisibility() {
    const passwordInput = document.getElementById('passwordInput');
    const toggleIcon = document.getElementById('togglePassword');
    
    if(passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
    }
}

async function login() {
    const loginButton = document.getElementById('loginButton');
    const errorBanner = document.getElementById('errorBanner');
    const errorMessage = document.getElementById('errorMessage');
    
    // Validación básica
    if(!state.selectedUser || !document.getElementById('passwordInput').value) {
        errorMessage.textContent = "Seleccione un usuario y escriba su contraseña";
        errorBanner.classList.remove('d-none');
        return;
    }

    // Mostrar loading
    loginButton.innerHTML = `
        <span class="spinner-border spinner-border-sm" 
              role="status" 
              aria-hidden="true"></span>
        Verificando...
    `;
    loginButton.disabled = true;

    // Simular llamada API
    setTimeout(async () => {
        // Aquí iría la llamada real al servidor
        const success = Math.random() > 0.5; // Simular éxito/fallo
        
        if(success) {
            window.location.href = '/dashboard'; // Redirección
        } else {
            errorMessage.textContent = "Credenciales incorrectas";
            errorBanner.classList.remove('d-none');
        }
        
        // Restaurar botón
        loginButton.innerHTML = "Iniciar sesión";
        loginButton.disabled = false;
    }, 700);
}

function updateDatalist() {
    const datalist = document.getElementById('empleadosList');
    datalist.innerHTML = state.empleados.map(emp => 
        `<option value="${emp.Nombre}" data-id="${emp.ID}">`
    ).join('');
}
</script>
</body>
</html>