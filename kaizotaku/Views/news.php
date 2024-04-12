<?php
    require_once "../Layout/layout.php";
    require_once "../Helpers/utilities.php";
    require_once '../Settings/conect.php';
    
    header("X-Frame-Options: DENY");
    header("X-Content-Type-Options: nosniff");
    // header("Content-Security-Policy: default-src 'self'; script-src 'self' https://cdn.jsdelivr.net; style-src 'self' https://cdn.jsdelivr.net; font-src 'self' https://cdn.jsdelivr.net; img-src 'self'; frame-src 'self'; child-src 'none';");

    // Verificar si se proporcionó un search_code válsearch_codeo en la URL
    if (isset($_GET['search_code']) && !empty($_GET['search_code'])) {
        // Obtener el search_code del registro a editar desde la URL
        $search_code = $_GET['search_code'];

        // Obtener los detalles del registro de la base de datos utilizando el search_code
        $stmt = $pdo->prepare("SELECT * FROM noticias WHERE search_code = ?");
        $stmt->execute([$search_code]);
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontró el registro
        if (!$registro) {
            echo "El registro no fue encontrado.";
            exit; // Detener la ejecución si no se encontró el registro
        }
    } else {
        echo "search_code inválido.";
        exit; // Detener la ejecución si no se proporcionó un search_code válsearch_codeo
    }
    $utilities = new Utilities();
    $layout = new Layout($utilities, false, true, $registro['title'] . " - Kaizotaku");
?>
<?php echo $layout->printHeader(); ?>
<div class="row">
    <div class="col-md-10"></div>
    <div class="col-md-2"></div>
</div>
<hr />
<div class="row">
    <div class="row">
        <div class="col-md-7">
            <h2 class="card-text"><b><?= $registro['title'] ?>.</b></h2>
            <p class="card-text"><?= $utilities->temas[$registro['topics']] ?></p>
                <hr  />
            <p class="card-text"><?= $registro['information'] ?></p>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">                    
                    <img class="card-img" src="data:image/jpeg;base64,<?= htmlspecialchars(base64_encode($registro['img_source'])); ?>" />
                        <hr  />
                    <p class="card-text"><?= $registro['author'] ?>. <?= $registro['publication_date'] ?></p> <!-- Un agregado que se me ocurrió para que el usuario sepa cuando la propuesta fue hecha. -->
                </div>
            </div>
        </div>
    </div>
</div>

<br /><br />
<?php echo $layout->printFooter(); ?>
