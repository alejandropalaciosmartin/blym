<?php
include '../../assets/reusable/bd.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);  // Asegurarse de que el ID es un número entero

    $sql = "DELETE FROM support WHERE support_id = $id";
    $result = $db->query($sql);
}
?>