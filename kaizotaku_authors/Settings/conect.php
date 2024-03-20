
<?php

    $db_host = 'localhost';
    $db_user = 'root';
    $db_pssw = '';
    $db_name = 'kaizotaku_data_base';

    try {
        // Crear una instancia de la clase PDO para establecer la conexión
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pssw);
    
        // Configurar el modo de error para que lance excepciones en caso de error
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // Manejar errores de conexión
        echo "Error de conexión: " . $e->getMessage();
        die(); // Detener la ejecución en caso de error de conexión
    }
    
?>
