<?php
include '../../assets/reusable/sesions.php';
include '../../assets/reusable/bd.php';
$userId = $_SESSION['user_id'];

if (isset($_FILES['profilePic'])) {
    $fileName = $_FILES['profilePic']['name'];
    $fileTmpName = $_FILES['profilePic']['tmp_name'];
    $fileError = $_FILES['profilePic']['error'];

    if ($fileError === 0) {
        // Preparar el nombre del archivo nuevo
        $newFileName = $userId . "-" . $fileName;
        $fileDestination = 'uploads/' . $newFileName;

        // Crear carpeta si no existe
        if (!file_exists('uploads')) {
            mkdir('uploads', 0777, true);
        }

        // Eliminar el archivo anterior si existe
        foreach (glob("uploads/{$userId}-*") as $oldFile) {
            if (is_file($oldFile)) {
                unlink($oldFile); // Elimina el archivo
            }
        }

        // Mover el archivo subido a la carpeta de destino
        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            $filePath = $fileDestination;

            // Actualizar la base de datos con la nueva ruta de imagen
            $sql = "UPDATE users SET profile_img = '$filePath' WHERE user_id = $userId";
            $result = $db->query($sql);
            if ($result) {
                echo "Imagen actualizada correctamente.";
            } else {
                echo "Error al actualizar la imagen en la base de datos: " . $db->error;
            }

        } else {
            echo "Hubo un error al guardar el archivo.";
        }
    } else {
        echo "Error al subir el archivo: " . $fileError;
    }
}
?>
