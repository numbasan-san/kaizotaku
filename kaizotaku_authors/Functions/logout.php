
<?php
    session_start();

    // Cerrar la sesión
    $_SESSION = array(); // Vaciar el array de sesión

    // Si se desea eliminar la sesión, también se puede destruir el identificador de sesión
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Finalmente, destruir la sesión
    session_destroy();
    header("Location: ../index.php");
?>
