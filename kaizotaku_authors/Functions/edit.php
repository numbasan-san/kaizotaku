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

    // Inicializar variables para la nueva imagen
    $new_img_name = null;
    $new_img_data = null;

    // Verificar si se ha cargado una nueva imagen
    if (!empty($_FILES['imagen']['tmp_name'])) {
        // Obtener la extensión de la imagen actual
        $stmt_select_image = $pdo->prepare("SELECT related_image_name FROM noticias WHERE id=?");
        $stmt_select_image->execute([$id]);
        $old_image_name = $stmt_select_image->fetchColumn();
        $old_img_extension = pathinfo($old_image_name, PATHINFO_EXTENSION);

        // Generar el nombre de la nueva imagen con la misma extensión que la imagen actual
        $new_img_name = pathinfo($old_image_name, PATHINFO_FILENAME) . '.' . $old_img_extension;

        // Obtener los datos binarios de la nueva imagen
        $new_img_data = file_get_contents($_FILES["imagen"]["tmp_name"]);
    }

    // Verificar si se cargó una nueva imagen antes de actualizar
    if ($new_img_name !== null && $new_img_data !== null) {
        // Preparar la consulta SQL para actualizar los datos incluyendo la nueva imagen
        $stmt = $pdo->prepare("UPDATE noticias SET title=?, topics=?, information=?, related_image_name=?, img_source=? WHERE id=?");

        // Ejecutar la consulta con los valores proporcionados
        $result = $stmt->execute([$title, $topics, $information, $new_img_name, $new_img_data, $id]);
    } else {
        // Preparar la consulta SQL para actualizar los datos excluyendo la nueva imagen
        $stmt = $pdo->prepare("UPDATE noticias SET title=?, topics=?, information=? WHERE id=?");

        // Ejecutar la consulta con los valores proporcionados
        $result = $stmt->execute([$title, $topics, $information, $id]);
    }

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
