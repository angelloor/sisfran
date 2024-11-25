<?php
// Verifica si se subió un archivo
if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/'; // Carpeta para guardar archivos

    // Crea la carpeta si no existe
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Generar el nuevo nombre del archivo
    $fechaActual = date('Ymd'); // Formato: 20241120
    $numeroAleatorio = rand(10000, 99999); // Número aleatorio de 5 dígitos
    $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Extensión del archivo
    $nuevoNombre = "documentacion_{$fechaActual}_{$numeroAleatorio}.{$extension}";

    $uploadFile = $uploadDir . $nuevoNombre;

    // Mueve el archivo subido al servidor
    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
        echo $uploadFile;
    } else {
        echo "Error al mover el archivo.";
    }
} else {
    echo "Error al subir el archivo.";
}
