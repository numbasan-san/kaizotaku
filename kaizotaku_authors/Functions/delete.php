<?php

require_once '../Settings/conect.php';

// Verificar si se ha enviado un ID válido para eliminar
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Obtener el ID del elemento a eliminar
    $id = $_GET['id'];

    // Preparar la consulta SQL para obtener el nombre del archivo de imagen relacionado
    $stmt = $pdo->prepare("SELECT related_image FROM noticias WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $related_image = $row['related_image'];

    // Ejecutar la consulta con el ID proporcionado
    $result = $stmt->execute([$id]);

    // Verificar si se eliminó correctamente
    if ($result) {
        // Eliminar la imagen de la carpeta
        $file_path = "imgs/" . $related_image;
        if (file_exists($file_path)) {
            unlink($file_path); // Eliminar el archivo de imagen
        }

        // Preparar la consulta SQL para eliminar el registro
        $stmt_delete = $pdo->prepare("DELETE FROM noticias WHERE id=?");
        $result_delete = $stmt_delete->execute([$id]);

        if ($result_delete) {
            echo "La entrada se ha eliminado correctamente de la base de datos.";
            // Redireccionar al usuario a la página principal
            header("Location: ../index.php");
            exit; // Detener la ejecución del script después de redirigir
        } else {
            echo "Error al eliminar la entrada de la base de datos.";
        }
    } else {
        echo "Error al eliminar la entrada de la base de datos.";
    }
} else {
    // No se proporcionó un ID válido
    echo "ID inválido para eliminar.";
}

?>
