
<?php

    require_once '../Settings/conect.php';

    // Verificar si se ha enviado un ID válido para eliminar
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        // Obtener el ID del elemento a eliminar
        $id = $_GET['id'];

        // Preparar la consulta SQL para eliminar el registro
        $stmt = $pdo->prepare("DELETE FROM noticias WHERE id=?");

        // Ejecutar la consulta con el ID proporcionado
        $result = $stmt->execute([$id]);

        // Verificar si se eliminó correctamente
        if ($result) {
            echo "La entrada se ha eliminado correctamente de la base de datos.";
        } else {
            echo "Error al eliminar la entrada de la base de datos.";
        }

        header("Location: ../index.php");
    } else {
        // No se proporcionó un ID válido
        echo "ID inválido para eliminar.";
    }

?>
