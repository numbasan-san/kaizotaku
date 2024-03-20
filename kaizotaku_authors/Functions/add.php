
<?php

    require_once '../Settings/conect.php';
    
    // Obtener los datos del formulario
    $title = $_POST['titulo'];
    $publication_date = date('Y-m-d');
    $topics = $_POST['tema'];
    $author = 'paquita';
    $related_image = 'asadasdasd';
    $information = $_POST['informacion'];
    $search_code = 'NW_' . $topics . '_' . $publication_date;
  
    // Preparar la consulta SQL
    $stmt = $pdo->prepare("INSERT INTO noticias (title, publication_date, topics, author, related_image, information, search_code) VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Ejecutar la consulta con los valores proporcionados
    $stmt->execute([$title, $publication_date, $topics, $author, $related_image, $information, $search_code]);

    // Verificar si se insertó correctamente
    if ($stmt->rowCount() > 0) {
        echo "La entrada se ha agregado correctamente a la base de datos.";
    } else {
        echo "Error al agregar la entrada a la base de datos.";
    }

    header("Location: ../Views/add.php");

?>
