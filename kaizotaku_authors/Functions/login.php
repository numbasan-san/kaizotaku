<?php
    session_start();
    header("X-Frame-Options: DENY");
    header("X-Content-Type-Options: nosniff");
    header("Content-Security-Policy: default-src 'self'; script-src 'self' https://cdn.jsdelivr.net; style-src 'self' https://cdn.jsdelivr.net; font-src 'self' https://cdn.jsdelivr.net; img-src 'self'; frame-src 'self'; child-src 'none';");

    require_once '../Settings/conect.php';

    // Verificar si el usuario ya ha iniciado sesión
    if(isset($_SESSION['user_id'])) {
        // Si el usuario ya está autenticado, redirigirlo a la página de inicio
        header("Location: ../Views/login.php");
        exit;
    } else {

        // Verificar si se envió el formulario de inicio de sesión
        if(isset($_POST['login'])) {
            // Obtener los datos ingresados por el usuario
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Realizar la autenticación del usuario
            $stmt = $pdo->prepare("SELECT * FROM autores WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar si se encontró un usuario con el correo proporcionado
            if($user) {
                // Verificar si la cuenta está bloqueada
                if($user['blocked'] == true) {
                    $error = "Cuenta bloqueada. Contacte al administrador.";
                } else {
                    // Verificar la contraseña utilizando password_verify()
                    if(password_verify($password, $user['password'])) {
                        // Restablecer el contador de intentos fallidos
                        $stmt_reset_attempts = $pdo->prepare("UPDATE autores SET failed_attempts = 0 WHERE id = :user_id");
                        $stmt_reset_attempts->bindParam(':user_id', $user['id']);
                        $stmt_reset_attempts->execute();

                        // Guardar el ID y el nombre del usuario en la sesión
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['user_name'] = $user['name'];

                        // Redirigir al usuario a la página de inicio
                        header("Location: ../index.php");
                        exit;
                    } else {
                        // Incrementar el contador de intentos fallidos
                        $new_attempts = $user['failed_attempts'] + 1;
                        $stmt_increment_attempts = $pdo->prepare("UPDATE autores SET failed_attempts = :attempts WHERE id = :user_id");
                        $stmt_increment_attempts->bindParam(':attempts', $new_attempts);
                        $stmt_increment_attempts->bindParam(':user_id', $user['id']);
                        $stmt_increment_attempts->execute();

                        // Si el contador alcanza un cierto límite, bloquear la cuenta
                        if($new_attempts >= 5) {
                            $stmt_block_account = $pdo->prepare("UPDATE autores SET blocked = true WHERE id = :user_id");
                            $stmt_block_account->bindParam(':user_id', $user['id']);
                            $stmt_block_account->execute();
                            echo "Intentos permitidos excedidos. Cuenta bloqueada.";
                        } else {
                            echo "Credenciales inválidas. Por favor, intenta nuevamente.";
                            header("Location: ../index.php");
                            exit;
                        }
                    }
                }
            } else {
                echo "Credenciales inválidas. Por favor, intenta nuevamente.";
                header("Location: ../index.php");
                exit;
            }
        }
}
    header("Location: ../Views/login.php");
?>
