<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Si no hay sesión de user_id, redirigir al login
    header('Location: ../index.php');
    exit();
}
?>