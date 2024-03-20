<?php
    session_start();

    require_once '../Settings/conect.php';

    // Verificar si el usuario ya ha iniciado sesión
    if(isset($_SESSION['user_id'])) {
        // Si el usuario ya está autenticado, redirigirlo a la página de inicio
        header("Location: ../index.php");
        exit;
    }

    // Verificar si se envió el formulario de inicio de sesión
    if(isset($_POST['login'])) {
        // Obtener los datos ingresados por el usuario
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Realizar la autenticación del usuario
        $stmt = $pdo->prepare("SELECT * FROM autores WHERE email = :email AND password = :password");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        // Verificar si se encontró un usuario con las credenciales proporcionadas
        if($stmt->rowCount() > 0) {
            // Si la autenticación es exitosa, guardar el ID del usuario en la sesión
            $_SESSION['user_id'] = $stmt->fetch(PDO::FETCH_ASSOC)['id'];

            // Redirigir al usuario a la página de inicio
            header("Location: ../index.php");
            exit;
        } else {
            // Si la autenticación falla, mostrar un mensaje de error
            $error = "Credenciales inválidas. Por favor, intenta nuevamente.";
            header("Location: ../index.php");
        }
    }
?>