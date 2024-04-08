
<?php

require_once '../Settings/conect.php';

// Verificar si se ha enviado un ID válido para editar
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Obtener el ID del elemento a editar
    $id = $_GET['id'];

    // Obtener los datos del formulario
    $title = $_POST['titulo'];
    $topics = $_POST['tema'];
    $information = $_POST['informacion'];

    // Verificar si se ha cargado una nueva imagen
    if (!empty($_FILES['imagen']['tmp_name'])) {
        // Preparar la consulta SQL para obtener el nombre del archivo de la imagen actual
        $stmt_select_image = $pdo->prepare("SELECT related_image FROM noticias WHERE id=?");
        $stmt_select_image->execute([$id]);
        $old_image_name = $stmt_select_image->fetchColumn();

        // Eliminar la imagen anterior
        unlink("imgs/" . $old_image_name);

        // Mover la nueva imagen a la carpeta de destino
        move_uploaded_file($_FILES['imagen']['tmp_name'], "imgs/" . $old_image_name);
    }

    // Preparar la consulta SQL para actualizar los datos
    $stmt = $pdo->prepare("UPDATE noticias SET title=?, topics=?, information=? WHERE id=?");

    // Ejecutar la consulta con los valores proporcionados
    $result = $stmt->execute([$title, $topics, $information, $id]);

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
