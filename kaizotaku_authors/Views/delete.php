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
        if (!$registro) {
            echo "El registro no fue encontrado.";
            exit; // Detener la ejecución si no se encontró el registro
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
    
    <form action="../Functions/edit.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="noticia-titulo" class="form-label">Titulo:</label>
            <input name="titulo" type="text" class="form-control" id="inp_titulo" value="<?= $registro['title'] ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label" for="noticia-tema">Tema:</label>
            <input name="tema" type="text" class="form-control" id="inp_tema" value="<?= $utilities->temas[$registro['topics']] ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="noticia-informacion" class="form-label">Informacion:</label>
            <iframe name="informacion" class="form-control" id="inp_informacion" frameborder="0" scrolling="auto" srcdoc="<?= htmlspecialchars($registro['information']) ?>" readonly></iframe>
        </div>
        <div class="mb-3">
            <label for="noticia-img" class="form-label">Imagen relacionada:</label>
            <input name="imagen" type="file" accept=".jpg, .png" class="form-control" id="inp_img" readonly>
        </div>
        <div class="modal-footer">
            <a href="../index.php" class="btn btn-secondary">Regresar</a>
            <a href="../Functions/delete.php?id=<?= $id ?>" class="btn btn-danger">Eliminar</a>
        </div>
    </form>
</div>

<br /><br />
<?php echo $layout->printFooter(); ?>
