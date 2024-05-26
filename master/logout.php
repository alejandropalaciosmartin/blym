<?php
session_start();
require '../assets/reusable/bd.php';

$user_id = $_SESSION['user_id'];
$update_active_sql = "UPDATE users SET active = 0 WHERE user_id = '$user_id'";
$db->query($update_active_sql);


$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

header("Location: ../");
exit();
?>
