
<?php
    session_start();

    // Verificar si el usuario no ha iniciado sesión
    if (!isset($_SESSION['user_id'])) {
        // Si el usuario no está autenticado, redirigirlo a la página de inicio de sesión
        header("Location: ../Views/login.php");
        exit;
    } else {
        require_once "../Layout/layout.php";
        require_once "../Helpers/utilities.php";
        require_once '../Settings/conect.php';
        
        $utilities = new Utilities();
        $layout = new Layout(false, true);
    }

    // Verificar si se proporcionó un ID válido en la URL
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        // Obtener el ID del registro a editar desde la URL
        $id = $_GET['id'];

        // Obtener los detalles del registro de la base de datos utilizando el ID
        $stmt = $pdo->prepare("SELECT * FROM noticias WHERE id = ?");
        $stmt->execute([$id]);
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontró el registro
        if ($registro) {
            // Asignar los valores del registro a variables
            $titulo = $registro['title'];
            $tema = $registro['topics'];
            $informacion = $registro['information'];
            $imagen = $registro['related_image'];
            $no_id = false;
        } else {
            $no_id = true;
        }
    } else {
        echo "ID inválido.";
        exit; // Detener la ejecución si no se proporcionó un ID válido
    }
?>
<?php echo $layout->printHeader(); ?>
<div class="row">
    <div class="col-md-10"></div>
    <div class="col-md-2"></div>
</div>
    <hr />
<div class="row">
    <?php if ($no_id): ?>
        <h2>El registro no fue encontrado.</h2>
    <?php else: ?>
        <form action="../Functions/edit.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="noticia-titulo" class="form-label">Titulo:</label>
                <input name="titulo" type="text" class="form-control" id="inp_titulo" value="<?= $titulo ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="noticia-tema">Tema:</label>
                <select name="tema" class="form-select" id="cbx_tema">
                    <option value="">Elija una opción.</option>
                    <?php foreach ($utilities->temas as $id => $value) : ?>
                        <option value="<?= $id; ?>" <?= ($id == $tema) ? 'selected' : ''; ?>><?= $value; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="noticia-informacion" class="form-label">Informacion:</label>
                <textarea name="informacion" type="text" class="form-control" id="inp_informacion" required><?= $informacion ?></textarea>
            </div>
            <div class="mb-3">
                <label for="noticia-img" class="form-label">Imagen relacionada:</label>
                <input name="imagen" type="file" accept=".jpg, .png" class="form-control" id="inp_img">
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
