
<?php

    require_once '../Settings/conect.php';

    // Verificar si se ha enviado un ID válido para editar
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        // Obtener el ID del elemento a editar
        $id = $_GET['id'];

        // Obtener los datos del formulario
        $title = $_POST['titulo'];
        $publication_date = date('Y-m-d');
        $topics = $_POST['tema'];
        $information = $_POST['informacion'];
        $search_code = 'NW_' . $topics . '_' . $publication_date;

        // Preparar la consulta SQL para actualizar los datos
        $stmt = $pdo->prepare("UPDATE noticias SET title=?, publication_date=?, topics=?, information=?, search_code=? WHERE id=?");

        // Ejecutar la consulta con los valores proporcionados
        $result = $stmt->execute([$title, $publication_date, $topics, $information, $search_code, $id]);

        // Verificar si se actualizó correctamente
        if ($result) {
            echo "La entrada se ha actualizado correctamente en la base de datos.";
        } else {
            echo "Error al actualizar la entrada en la base de datos.";
        }

        header("Location: ../index.php");
    } else {
        // No se proporcionó un ID válido
        echo "ID inválido para editar.";
    }

?>
