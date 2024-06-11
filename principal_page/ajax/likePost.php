<?php
include '../../assets/reusable/sesions.php';
include '../../assets/reusable/bd.php';

$user_id = $_SESSION['user_id'];
$post_id = $_POST['post_id'];

$sql = "INSERT INTO likes (user_id, post_id) VALUES ($user_id, $post_id)";

$result = $db->query($sql);