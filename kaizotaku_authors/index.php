<?php

    session_start();

    // Verificar si el usuario no ha iniciado sesión
    if(!isset($_SESSION['user_id'])) {
        // Si el usuario no está autenticado, redirigirlo a la página de inicio de sesión
        header("Location: ./Views/login.php");
        exit;
    } else {
        require_once "Layout/layout.php";
        require_once "Helpers/utilities.php";
        require_once './Settings/conect.php';
    
        $utilities = new Utilities();
        $layout = new Layout(true, true);
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
        // Consulta SQL para seleccionar todas las noticias
        $sql = "SELECT * FROM noticias";
        
        // Preparar y ejecutar la consulta
        $stmt = $pdo->query($sql);

        // Iterar sobre los resultados y mostrar cada noticia
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="col-md-3">';
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<img class="card-img" src="Funciones/Fotos/' . $row['related_image'] . '"  />';
            echo '<hr />';
            echo '<h6 class="card-title"><b>' . $row['title'] . '</b></h6>';
            echo '<p class="card-text">' . $row['publication_date'] . '</p>';
            echo '<p class="card-text">' . $utilities->temas[$row['topics']] . '</p>';
            echo '<a href="./Views/edit.php?id=' . $row['id'] . '" class="btn btn-success">Editar</a>';
            echo '<a href="./Views/delete.php?id=' . $row['id'] . '" class="btn btn-danger">Eliminar</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>

    </div>
<br  /><br  />
<?php echo $layout->printFooter(); ?>
