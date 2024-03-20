<?php

    require_once "../Layout/layout.php";
    require_once "../Helpers/utilities.php";

    $layout = new Layout(false);
    $utilities = new Utilities();

?>
<?php echo $layout->printHeader(); ?>
<div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2"></div>
    </div>
        <hr  />
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

                <div class="text-center">
                    <button type="submit" name="login" class="btn btn-primary">Iniciar sesión</button>
                </div>
            </form>
        </div>
    </div>


<br  /><br  />
<?php echo $layout->printFooter(); ?>
