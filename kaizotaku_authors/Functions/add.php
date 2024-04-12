<?php
    session_start();
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
        $author = $_SESSION['user_name']; // Obtener el nombre de usuario de la sesión
        $information = $_POST['informacion'];
        $search_code = 'NW_' . $topics . '_' . $date_code;

        // Generar el nombre de la imagen
        $img_name = $_FILES["imagen"]["name"];
        $img_extension = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_name_generated = $author . '_' . $search_code . '.' . $img_extension;

        // Obtener la ruta absoluta de la carpeta de destino
        $current_directory = dirname(__FILE__); // Ruta actual del archivo
        $destiny_path = $current_directory . "/imgs/news_img/";

        // Verificar si la carpeta de destino existe
        if (!file_exists($destiny_path)) {
            mkdir($destiny_path, 0777, true); // Crea la carpeta si no existe
        }

        // Mover la imagen a la carpeta de destino con el nuevo nombre
        $temp_img = $_FILES["imagen"]["tmp_name"];
        move_uploaded_file($temp_img, $destiny_path . $img_name_generated);

        // Preparar la consulta SQL para insertar la noticia
        $stmt_insert_noticia = $pdo->prepare("INSERT INTO noticias (title, publication_date, topics, author, related_image, information, search_code) VALUES (?, ?, ?, ?, ?, ?, ?)");

        // Ejecutar la consulta para insertar la noticia
        $stmt_insert_noticia->execute([$title, $publication_date, $topics, $author, $img_name_generated, $information, $search_code]);

        // Verificar si se insertó correctamente la noticia
        if ($stmt_insert_noticia->rowCount() > 0) {
            echo "La entrada se ha agregado correctamente a la base de datos.";
        } else {
            echo "Error al agregar la entrada a la base de datos.";
        }

        // Recuperar el valor actual de la columna published_news_history para el usuario actual
        $stmt_get_published_news_history = $pdo->prepare("SELECT published_news_history FROM autores WHERE id = ?");
        $stmt_get_published_news_history->execute([$_SESSION['user_id']]);
        $current_published_news_history = $stmt_get_published_news_history->fetchColumn();

        // Agregar el nuevo código de búsqueda al valor actual de published_news_history
        $updated_published_news_history = ($search_code == NULL) ? $current_published_news_history : $search_code . "," . $current_published_news_history;

        // Actualizar la columna published_news_history en la base de datos con el nuevo valor
        $stmt_update_published_news_history = $pdo->prepare("UPDATE autores SET published_news_history = ? WHERE id = ?");
        $stmt_update_published_news_history->execute([$updated_published_news_history, $_SESSION['user_id']]);

        // Verificar si se actualizó correctamente published_news_history
        if ($stmt_update_published_news_history->rowCount() > 0) {
            echo "El código de búsqueda se ha agregado correctamente a la tabla autores.";
        } else {
            echo "Error al agregar el código de búsqueda a la tabla autores.";
        }

        // Redireccionar al usuario de vuelta al formulario
        header("Location: ../Views/add.php");
    }
?>
