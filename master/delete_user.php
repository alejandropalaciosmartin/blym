<?php

session_start();
include '../assets/reusable/bd.php';

$id = $_POST['id'];

$sql = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Usuario eliminado correctamente.";
} else {
    echo "Error al eliminar el usuario.";
}

$conn->close();
?>
