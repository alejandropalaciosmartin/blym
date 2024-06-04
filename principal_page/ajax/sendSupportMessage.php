<?php
include '../../assets/reusable/sesions.php';
include '../../assets/reusable/bd.php';

if (isset($_POST['message'])) {
    $message = $_POST['message'];
    $userId = $_SESSION['user_id'];

    // Aquí puedes insertar el mensaje en la base de datos o enviarlo por email
    $sql = "INSERT INTO support (user_id, message) VALUES ('$userId', '$message')";
    $result = $db->query($sql);

    if ($result) {
        echo "Message sent successfully.";
    } else {
        echo "Failed to send message: " . $db->error;
    }
} else {
    echo "No message received.";
}
?>
