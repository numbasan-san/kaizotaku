
<?php
    // session_start();
    header("X-Frame-Options: DENY");
    header("X-Content-Type-Options: nosniff");
    // header("Content-Security-Policy: default-src 'self'; script-src 'self' https://cdn.jsdelivr.net; style-src 'self' https://cdn.jsdelivr.net; font-src 'self' https://cdn.jsdelivr.net; img-src 'self'; frame-src 'self'; child-src 'none';");

    // Verificar si el usuario no ha iniciado sesión
    if (!isset($_SESSION['user_id'])) {
        // Si el usuario no está autenticado, redirigirlo a la página de inicio de sesión
        header("Location: ../Views/login.php");
        exit;
    } else {
        require_once "../Layout/layout.php";
        require_once "../Helpers/utilities.php";
        require_once '../Settings/conect.php';

        $user_id = $_SESSION['user_id'];
        $stmt = $pdo->prepare("SELECT profile_photo FROM autores WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Obtener la URL de la foto de perfil del usuario
        $user_photo_url = $user['profile_photo'];

        // Crear una instancia del layout con la URL de la foto de perfil del usuario como parámetro
        $layout = new Layout(false, true, true, 'Kaizotaku Authors', $user_photo_url);
        
        $utilities = new Utilities();
    }

    // Verificar si se proporcionó un ID válido en la URL
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        // Obtener el ID del registro a editar desde la URL
        $id = $_GET['id'];

        // Obtener los detalles del registro de la base de datos utilizando el ID
        $stmt = $pdo->prepare("SELECT * FROM noticias WHERE id = ?");
        $stmt->execute([$id]);
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);

    } else {
        echo "ID inválido.";
        exit; // Detener la ejecución si no se proporcionó un ID válido
    }
?>
<?php echo $layout->printHeader(); ?>
<div class="row">
    <div class="col-md-10"><h2>Editar Noticia</h2></div>
    <div class="col-md-2"></div>
</div>
    <hr />
<div class="row">
    <?php if (!$registro): ?>
        <h2>Registro no encontrado.</h2>
    <?php else: ?>
        <form action="../Functions/edit.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
            <input name="titulo" type="hidden" class="form-control" id="inp_titulo" value="<?= $registro['search_code']; ?>" required>
            <div class="mb-3">
                <label for="noticia-titulo" class="form-label">Titulo:</label>
                <input name="titulo" type="text" class="form-control" id="inp_titulo" value="<?= $registro['title']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="noticia-tema">Tema:</label>
                <select name="tema" class="form-select" id="cbx_tema">
                    <option value="">Elija una opción.</option>
                    <?php foreach ($utilities->temas as $id => $value) : ?>
                        <option value="<?= $id; ?>" <?= ($id == $registro['topics']) ? 'selected' : ''; ?>><?= $value; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="noticia-informacion" class="form-label">Informacion:</label>
                <textarea name="informacion" type="text" class="form-control" id="inp_informacion" required><?= $registro['information'] ?></textarea>
            </div>
            <div class="mb-3">
                <label for="noticia-img" class="form-label">Imagen relacionada:</label>
                <input name="imagen" type='file' class="form-control" id="inp_img">
            </div>
            <div class="mb-3">
                <label for="noticia-img" class="form-label">Imagen actual:</label>
                <img class="card-img" />
                <img class="form-label" style="width: 25%; height: 75%;" src="data:image/jpeg;base64,<?= base64_encode($registro['img_source']); ?>"  />
            </div>
            <div class="modal-footer">
                <a href="../index.php" class="btn btn-secondary">Regresar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    <?php endif; ?>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script>
<script src="../Helpers/script.js"></script>

<br /><br />
<?php echo $layout->printFooter(); ?>
