<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
include('./conexion.php'); 


$opcion = $_POST['opcion'];

    //Obtener los datos de los articulos con los valores asociados en las demas tablas
    if ($opcion == '1'){
        $usuario = isset($_POST['empleado']) ? $_POST['empleado'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;
                                

        $sql="SELECT rs.id_usuario, d.Nombre, d.passwrd, rs.id_rol FROM uni_roles_sesion AS rs 
                        inner join DIRECTORIO_0 as d ON rs.id_usuario = d.ID
                    WHERE rs.id_usuario = :empleado and d.passwrd = :passw";

        $stmt = $conn->prepare($sql);
        $stmt->bindparam(':empleado', $usuario);
        $stmt->bindparam(':passw', $password);
        
         $stmt->execute();


        if($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
                $response = array('success' => true);
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['idUsuario'] = $fila['id_usuario']; 
                $_SESSION['nombreUsuario'] = $fila['Nombre'];
                $_SESSION['rolUsuario'] = $fila['id_rol'];
        }

        else 
            $response = array('error'=> $stmt->errorInfo()[2], 
                              'success' => false
                            );

           
        echo json_encode($response);
    }

    //Obtener los datos de los articulos con los valores asociados en las demas tablas
    if ($opcion == '2'){
        session_start();
        session_destroy();
    }
?>