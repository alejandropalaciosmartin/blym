<?php
include '../../assets/reusable/sesions.php';
include '../../assets/reusable/bd.php';

if (isset($_POST['post_text'])) {
    $post_text = $_POST['post_text'];
    $user_id = $_SESSION['user_id'];

    // Insertar el post en la base de datos
    $sql = "INSERT INTO posts (user_id, post_text) VALUES ('$user_id', '$post_text')";
    $result = $db->query($sql);

    if ($result) {
        echo "Post guardado exitosamente";
    } else {
        echo "Error: " . $db->error;
    }
} else {
    echo "No se recibió ningún texto de post.";
}