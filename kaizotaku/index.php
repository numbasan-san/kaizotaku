<?php
    require_once "Layout/layout.php";
    require_once "Helpers/utilities.php";
    require_once './Settings/conect.php';

    header("X-Frame-Options: DENY");
    header("X-Content-Type-Options: nosniff");
    
    $utilities = new Utilities();
    $layout = new Layout($utilities, true);
    
    // Consulta SQL para seleccionar todas las noticias
    $sql = "SELECT * FROM noticias";
    
    // Preparar y ejecutar la consulta
    $stmt = $pdo->query($sql);

?>
<?php echo $layout->printHeader(); ?>

<div class="row">
    <div class="col-md-10"></div>
    <div class="col-md-2">
    </div>
</div>
    <hr />
<div class="row">

    <?php
        // Iterar sobre los resultados y mostrar cada noticia
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
    ?>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <a href="Views/news.php?search_code=<?= htmlspecialchars($row['search_code']) ?>" class="card-text">
                        <img class="card-img" src="data:image/jpeg;base64,<?= htmlspecialchars(base64_encode($row['img_source'])); ?>" />
                            <hr />
                        <h6 class="card-title"><b><?= htmlspecialchars($row['title']) ?>.</b></h6>
                        <p class="card-text"><?= htmlspecialchars($row['publication_date']) ?></p>
                        <p class="card-text"><?= htmlspecialchars($utilities->temas[$row['topics']]) ?></p>
                    </a>
                </div>
            </div>
        </div>
    <?php endwhile ?>


</div>
<br  /><br  />
<?php echo $layout->printFooter(); ?>
