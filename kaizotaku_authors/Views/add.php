<?php

    session_start();

    // Verificar si el usuario no ha iniciado sesión
    if(!isset($_SESSION['user_id'])) {
        // Si el usuario no está autenticado, redirigirlo a la página de inicio de sesión
        header("Location: ../Views/login.php");
        exit;
    } else {
        require_once "../Layout/layout.php";
        require_once "../Helpers/utilities.php";
    
        $utilities = new Utilities();
        $layout = new Layout(false, true);
    }

?>
<?php echo $layout->printHeader(); ?>
<div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2"></div>
    </div>
        <hr  />
    <div class="row">
        <form action="../Functions/add.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="noticia-titulo" class="form-label">Titulo:</label>
                <input name="titulo" type="text" class="form-control" id="inp_titulo" require>
            </div>
            <div class="mb-3">
                <label class="form-label" for="noticia-tema">Tema:</label>
                <select name="tema" class="form-select" id="cbx_tema">
                    <option value="">Elija una opción.</option>
                    <?php foreach ( $utilities->temas as $id => $value ) : ?>
                        <option value="<?= $id; ?>"><?= $value; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="noticia-informacion" class="form-label">Informacion:</label>
                <textarea name="informacion" type="text" class="form-control" id="inp_informacion" require></textarea>
            </div>
            <div class="mb-3">
                <label for="noticia-img" class="form-label">Imagen:</label>
                <input name="imagen" type="file" accept=".jpg, .png" class="form-control" id="inp_img" require>
            </div>
            <div class="modal-footer">
                <a href="../index.php" class="btn btn-secondary">Regresar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script>
    <script src="../Helpers/script.js"></script>

<br  /><br  />
<?php echo $layout->printFooter(); ?>