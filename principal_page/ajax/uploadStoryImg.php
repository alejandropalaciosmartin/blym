<?php
include '../../assets/reusable/sesions.php';
include '../../assets/reusable/bd.php';
$userId = $_SESSION['user_id'];

if (isset($_FILES['storyImg'])) {
    $fileName = $_FILES['storyImg']['name'];
    $fileTmpName = $_FILES['storyImg']['tmp_name'];
    $fileError = $_FILES['storyImg']['error'];

    if ($fileError === 0) {
        // Preparar el nombre del archivo nuevo
        $newFileName = $userId . "-" . $fileName;
        $fileDestination = '../../assets/storiesImg/' . $newFileName;

        // Crear carpeta si no existe
        if (!file_exists('../../assets/storiesImg')) {
            mkdir('../../assets/storiesImg', 0777, true);
        }

        // Eliminar el archivo anterior si existe
        foreach (glob("../../assets/storiesImg/{$userId}-*") as $oldFile) {
            if (is_file($oldFile)) {
                unlink($oldFile); // Elimina el archivo
            }
        }

        // Mover el archivo subido a la carpeta de destino
        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            // Insertar la nueva imagen en la base de datos
            $sql = "INSERT INTO stories (src, user_id) VALUES ('$newFileName', $userId)";
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
