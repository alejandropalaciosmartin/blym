<?php
include '../../assets/reusable/bd.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $stmt = $db->prepare("DELETE FROM support WHERE support_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}