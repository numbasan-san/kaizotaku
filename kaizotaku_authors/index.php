<?php
    session_start();
    header("X-Frame-Options: DENY");
    header("X-Content-Type-Options: nosniff");

    // Verificar si el usuario no ha iniciado sesión
    if (!isset($_SESSION['user_id'])) {
        // Si el usuario no está autenticado, redirigirlo a la página de inicio de sesión
        header("Location: ./Views/login.php");
        exit;
    } else {

        require_once "Layout/layout.php";
        require_once "Helpers/utilities.php";
        require_once './Settings/conect.php';
    
        $utilities = new Utilities();
        $layout = new Layout(true, true, true, 'Kaizotaku Authors');
        
        // Consulta SQL para seleccionar todas las noticias
        $sql = "SELECT * FROM noticias";
        
        // Preparar y ejecutar la consulta
        $stmt = $pdo->query($sql);

    }
?>
<?php echo $layout->printHeader(); ?>

<div class="row">
    <div class="col-md-10"></div>
    <div class="col-md-2">
        <a href="./Views/add.php" rel="noopener noreferrer" class="btn btn-primary">Publicar Noticia</a>
    </div>
</div>
<hr />
<div class="row">
    <p>HISTORIAL DE PUBLICACIONES</p>

    <?php
        // Iterar sobre los resultados y mostrar cada noticia
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
    ?>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <img class="card-img" src="<?= "Functions/imgs/" . $row['related_image']; ?>"  />
                    <hr />
                    <h6 class="card-title"><b><?= $row['title'] ?>.</b></h6>
                    <p class="card-text"><?= $row['publication_date'] ?></p>
                    <p class="card-text"><?= $row['search_code'] ?></p>
                    <p class="card-text"><?= $utilities->temas[$row['topics']] ?></p>
                    <a href="./Views/edit.php?id=<?= $row['id'] ?>" class="btn btn-success">Editar</a>
                    <a href="./Views/delete.php?id=<?= $row['id'] ?>" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
    <?php endwhile ?>
</div>
<br /><br />
<?php echo $layout->printFooter(); ?>
