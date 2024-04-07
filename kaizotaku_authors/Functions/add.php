<?php

require_once '../Settings/conect.php';

// Verifica si el método de solicitud es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Array para almacenar nombres de campos vacíos
    $missingFields = [];

    // Función para validar los campos requeridos
    function validateRequired($field) {
        if (empty($_POST[$field])) {
            return $field;
        }
        return null;
    }

    // Validación de campos requeridos
    $missingFields[] = validateRequired("titulo");
    $missingFields[] = validateRequired("tema");
    $missingFields[] = validateRequired("informacion");
    if (empty($_FILES["imagen"]["name"])) {
        $missingFields[] = "imagen";
    }

    // Filtra los campos vacíos
    $missingFields = array_filter($missingFields);
    if (!empty($missingFields)) {
        $errorFields = implode(",", $missingFields); // Convertir el array a una cadena separada por comas
        header("Location: ../Views/add.php?error=$errorFields"); // Redirigir con los campos faltantes en la URL
        exit; // Detener la ejecución del script
    }

    // Si no hay errores, proceder con la adición a la base de datos
    $title = $_POST['titulo'];
    $publication_date = date('Ymd');
    $date_code = date('YmdHis'); // Obtener fecha y hora actual en formato de 24 horas con segundos
    $topics = $_POST['tema'];
    $author = 'paquita'; // Puedes cambiar este valor según el autor real
    $information = $_POST['informacion'];
    $search_code = 'NW_' . $topics . '_' . $date_code;

    // Generar el nombre de la imagen
    $img_name = $_FILES["imagen"]["name"];
    $img_extension = pathinfo($img_name, PATHINFO_EXTENSION);
    $img_name_generated = $author . '_' . $search_code . '.' . $img_extension;

    // Obtener la ruta absoluta de la carpeta de destino
    $current_directory = dirname(__FILE__); // Ruta actual del archivo
    $destiny_path = $current_directory . "/imgs/";

    // Verificar si la carpeta de destino existe
    if (!file_exists($destiny_path)) {
        mkdir($destiny_path, 0777, true); // Crea la carpeta si no existe
    }

    // Mover la imagen a la carpeta de destino con el nuevo nombre
    $temp_img = $_FILES["imagen"]["tmp_name"];
    move_uploaded_file($temp_img, $destiny_path . $img_name_generated);

    // Preparar la consulta SQL
    $stmt = $pdo->prepare("INSERT INTO noticias (title, publication_date, topics, author, related_image, information, search_code) VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Ejecutar la consulta con los valores proporcionados
    $stmt->execute([$title, $publication_date, $topics, $author, $img_name_generated, $information, $search_code]);

    // Verificar si se insertó correctamente
    if ($stmt->rowCount() > 0) {
        echo "La entrada se ha agregado correctamente a la base de datos.";
    } else {
        echo "Error al agregar la entrada a la base de datos.";
    }

    // Redireccionar al usuario de vuelta al formulario
    header("Location: ../Views/add.php");
}
?>
