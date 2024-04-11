<?php

    require_once "../Layout/layout.php";
    require_once "../Helpers/utilities.php";
    require_once '../Settings/conect.php';

    $utilities = new Utilities();
    $layout = new Layout($utilities, false, true, $utilities->temas[$_GET["tema"]] . " - Kaizotaku");
    
    // Consulta SQL para seleccionar todas las noticias
    $sql = "SELECT * FROM noticias WHERE topics = " . $_GET["tema"];
    
    // Preparar y ejecutar la consulta
    $stmt = $pdo->query($sql);


?>
<?php echo $layout->printHeader (); ?>
    <div class="row">
        <div class="col-md-10">
            <h2><?= $utilities->temas[$_GET['tema']] ?></h2>
        </div>
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
                        <a href="news.php?search_code=<?= $row['search_code'] ?>" class="card-link">
                            <img class="card-img" src="<?= "../../kaizotaku_authors/Functions/imgs/" . $row['related_image']; ?>"  />
                                <hr />
                            <h6 class="card-title"><b><?= $row['title'] ?>.</b></h6>
                            <p class="card-text"><?= $row['publication_date'] ?></p>
                            <p class="card-text"><?= $utilities->temas[$row['topics']] ?></p>
                        </a>
                    </div>
                </div>
            </div>
        <?php endwhile ?>


    </div>
<br  /><br  />
<?php echo $layout->printFooter (); ?>