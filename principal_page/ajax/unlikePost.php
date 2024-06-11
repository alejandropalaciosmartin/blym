<?php
include '../../assets/reusable/sesions.php';
include '../../assets/reusable/bd.php';

$user_id = $_SESSION['user_id'];
$post_id = $_POST['post_id'];

$sql = "DELETE FROM likes WHERE user_id = $user_id AND post_id = $post_id";
    
$result = $db->query($sql);