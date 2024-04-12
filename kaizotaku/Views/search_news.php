<?php
    require_once "../Layout/layout.php";
    require_once "../Helpers/utilities.php";
    require_once '../Settings/conect.php';

    header("X-Frame-Options: DENY");
    header("X-Content-Type-Options: nosniff");

    $utilities = new Utilities();

    // Verificar si el valor del parámetro $_GET['tema'] es válido
    $tema = htmlspecialchars(isset($_GET['tema'])) ? htmlspecialchars($_GET['tema']) : '';

    // Lista de temas válidos
    $temas_validos = array_keys($utilities->temas);

    // Verificar si el tema recibido está en la lista de temas válidos
    if (!in_array($tema, $temas_validos)) {
        // Redirigir al index si el tema no es válido
        header("Location: ../index.php");
        exit; // Detener la ejecución del script después de la redirección
    }

    // Crear una instancia del layout con el tema seguro
    $layout = new Layout($utilities, false, true, htmlspecialchars($utilities->temas[$tema]) . " - Kaizotaku");

    // Consulta SQL parametrizada para seleccionar todas las noticias
    $sql = "SELECT * FROM noticias WHERE topics = :tema";

    // Preparar la consulta
    $stmt = $pdo->prepare($sql);

    // Vincular el parámetro del tema
    $stmt->bindParam(':tema', $tema, PDO::PARAM_STR);

    // Ejecutar la consulta
    $stmt->execute();
?>
<?php echo $layout->printHeader(); ?>
    <div class="row">
        <div class="col-md-10">
            <h2><?= htmlspecialchars($utilities->temas[$tema]) ?></h2>
        </div>
        <div class="col-md-2">
        </div>
    </div>
    <hr />
    <div class="row">
        <?php
        // Iterar sobre los resultados y mostrar cada noticia
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
        ?>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <a href="news.php?search_code=<?= htmlspecialchars($row['search_code']) ?>" class="card-link">
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
    <br /><br />
<?php echo $layout->printFooter(); ?>
