<?php 
session_start();
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
include('./api/conexion.php'); 


if (isset($_SESSION['loggedin'])) {
  
    if (!headers_sent())
    { 
        header('Location: ./');   
    }

   else
       {  
       echo '<script type="text/javascript">';
       echo 'window.location.href="login.php";';
       echo '</script>';
       echo '<noscript>';
       echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
       echo '</noscript>';
   }
} 

$usuarios = $conn->prepare("select rs.id_usuario, d.Nombre from uni_roles_sesion AS rs inner join DIRECTORIO_0 as d ON rs.id_usuario = d.ID"); 
$usuarios->execute();
?>

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
                            <select class="form-control" id="usuarioInput" placeholder="Usuario" autocomplete="off">
                                <option class="text-left" value="" selected> --- USUARIO ---</option>
                                    <?php 
                                        while ($usuario = $usuarios->fetch(PDO::FETCH_ASSOC)) 
                                            echo '<option value="'.$usuario['id_usuario'].'">'.$usuario['Nombre'].'</option>';
                                    ?>
                            </select>
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

    function login() {
        const loginButton = document.getElementById('loginButton');
        const errorBanner = document.getElementById('errorBanner');
        const errorMessage = document.getElementById('errorMessage');
        let password = document.getElementById('passwordInput')
        let empleado = document.getElementById('usuarioInput')
        let formDataArt = new FormData;
        formDataArt.append('opcion', 1);
        
        // Validación básica
        if( !empleado.value || !password.value) {
            errorMessage.textContent = "Seleccione un usuario y escriba su contraseña";
            errorBanner.classList.remove('d-none');
            return;
        }

        else {
                //Ocultar mensaje de error
                errorBanner.classList.add('d-none');
                // Mostrar loading
                loginButton.innerHTML = `
                    <span class="spinner-border spinner-border-sm" 
                        role="status" 
                        aria-hidden="true"></span>
                    Verificando...
                `;
                loginButton.disabled = true;  
                formDataArt.append('empleado', empleado.value);
                formDataArt.append('password', password.value);
                    setTimeout(() => {
                        fetch("./api/login.php", {
                                method: "POST",
                                body: formDataArt,
                            })
                            .then((response) => response.json())
                            .then((data) => {
                                    if(data.success) {
                                        location.href = './'; // Redirección
                                        // Restaurar botón
                                        loginButton.innerHTML = "Iniciar sesión";
                                        loginButton.disabled = false;
                                    } 
                                    else {
                                        errorMessage.textContent = "Credenciales incorrectas";
                                        errorBanner.classList.remove('d-none');
                                        // Restaurar botón
                                        loginButton.innerHTML = "Iniciar sesión";
                                        loginButton.disabled = false;
                                    }

                                    //console.log(data);
                                })
                        .catch((error) => {
                                //console.log(error);
                                errorMessage.textContent = error;
                                errorBanner.classList.remove('d-none');
                                loginButton.innerHTML = "Iniciar sesión";
                                loginButton.disabled = false;
                        })
                    }, 400);
        }
    }
</script>
</body>
</html>