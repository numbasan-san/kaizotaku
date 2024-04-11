
<?php
    session_start();
    require_once "../Layout/layout.php";
    require_once "../Helpers/utilities.php";

    $layout = new Layout(false, false, true, 'Login - Kaizotaku Authors');
    $utilities = new Utilities();
    
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    header("Content-Security-Policy: default-src 'self'; script-src 'self' https://cdn.jsdelivr.net; style-src 'self' https://cdn.jsdelivr.net; font-src 'self' https://cdn.jsdelivr.net; img-src 'self'; frame-src 'self'; child-src 'none';");
    header("X-Frame-Options: DENY");

?>
<?php echo $layout->printHeader(); ?>
<div class="row">
    <div class="col-md-10"></div>
    <div class="col-md-2"></div>
</div>
<hr />
<div class="row">
    <div class="col-md-6 offset-md-3">
        <form action="../Functions/login.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="text" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <!-- Agregar campo oculto para el token CSRF -->
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

            <div class="text-center">
                <button type="submit" name="login" class="btn btn-primary">Iniciar sesión</button>
            </div>
        </form>
    </div>
</div>
<br /><br />
<?php echo $layout->printFooter(); ?>
