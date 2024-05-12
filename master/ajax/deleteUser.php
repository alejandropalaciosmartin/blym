<?php
include '../../assets/reusable/bd.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);  // Asegurarse de que el ID es un número entero


    $sql = "DELETE FROM followers WHERE follower_id = $id OR following_id = $id";
    $result = $db->query($sql);

    $sql = "DELETE FROM posts WHERE user_id = $id";
    $result = $db->query($sql);

    $sql = "DELETE FROM stories WHERE user_id = $id";
    $result = $db->query($sql);

    $sql = "DELETE FROM users WHERE user_id = $id";
    $result = $db->query($sql);
}
?>