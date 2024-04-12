<?php
    session_start();
    header("X-Frame-Options: DENY");
    header("X-Content-Type-Options: nosniff");
    // header("Content-Security-Policy: default-src 'self'; script-src 'self' https://cdn.jsdelivr.net; style-src 'self' https://cdn.jsdelivr.net; font-src 'self' https://cdn.jsdelivr.net; img-src 'self'; frame-src 'self'; child-src 'none';");

    // Verificar si el usuario no ha iniciado sesión
    if (!isset($_SESSION['user_id'])) {
        // Si el usuario no está autenticado, redirigirlo a la página de inicio de sesión
        header("Location: ./Views/login.php");
        exit;
    } else {
        require_once "Layout/layout.php";
        require_once "Helpers/utilities.php";
        require_once './Settings/conect.php';

        // Generar un token CSRF único y guardarlo en la sesión del usuario
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        // Obtener la foto de perfil
        $user_id = $_SESSION['user_id'];
        $stmt = $pdo->prepare("SELECT profile_photo FROM autores WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Obtener la URL de la foto de perfil del usuario
        $user_photo_url = $user['profile_photo'];

        // Crear una instancia del layout con la URL de la foto de perfil del usuario como parámetro
        $layout = new Layout(true, true, true, 'Kaizotaku Authors', $user_photo_url);

        // Obtener el historial de noticias del usuario
        $stmt_history = $pdo->prepare("SELECT published_news_history FROM autores WHERE id = :user_id");
        $stmt_history->bindParam(':user_id', $user_id);
        $stmt_history->execute();
        $user_history = $stmt_history->fetchAll(PDO::FETCH_COLUMN);

        // Alistar los elementos para el filtrado
        $element = $user_history[0];
        $user_history_array = explode(',', $element);

        // Construir la consulta SQL para seleccionar las noticias del historial del usuario
        $sql = "SELECT * FROM noticias WHERE search_code IN (" . implode(",", array_fill(0, count($user_history_array), "?")) . ")";
        $stmt_news = $pdo->prepare($sql);
        $stmt_news->execute($user_history_array);

        $utilities = new Utilities();
    }
?>
<?= $layout->printHeader(); ?>

<div class="row">
    <div class="col-md-10"></div>
    <div class="col-md-2">
        <form action="./Views/add.php" method="post">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
            <button type="submit" class="btn btn-primary">Publicar Noticia</button>
        </form>
    </div>
</div>
<hr />
<div class="row">
    <p>HISTORIAL DE PUBLICACIONES</p>

    <?php
    // Iterar sobre los resultados y mostrar cada noticia
    while ($row = $stmt_news->fetch(PDO::FETCH_ASSOC)) :
    ?>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <img class="card-img" src="data:image/jpeg;base64,<?= base64_encode($row['img_source']); ?>" />
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
<?= $layout->printFooter(); ?>
