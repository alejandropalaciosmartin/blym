<?php
include '../../assets/reusable/bd.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);  // Asegurarse de que el ID es un número entero

    $queries = [
        "DELETE FROM followers WHERE follower_id = $id OR following_id = $id",
        "DELETE FROM posts WHERE user_id = $id",
        "DELETE FROM stories WHERE user_id = $id",
        "DELETE FROM support WHERE user_id = $id",
        "DELETE FROM users WHERE user_id = $id"
    ];

    foreach ($queries as $query) {
        $result = $db->query($query);
    }

    
}