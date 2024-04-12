<?php

$texto_original = "shinratumadreowozu";

// Encriptar el texto
$texto_encriptado = password_hash($texto_original, PASSWORD_DEFAULT);

echo "Texto original: " . $texto_original . "<br>";
echo "Texto encriptado: " . $texto_encriptado;
?>