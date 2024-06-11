<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../../assets/reusable/sesions.php';
include '../../assets/reusable/bd.php';

$user_id = $_SESSION['user_id'];

// Consulta para obtener los posts de las personas que sigues
$sql = "
    SELECT p.post_id, p.post_text, p.created_at, u.first_name, u.profile_img,
           (SELECT COUNT(*) FROM likes WHERE post_id = p.post_id) as likes_count,
           (SELECT COUNT(*) FROM likes WHERE post_id = p.post_id AND user_id = $user_id) as liked
    FROM posts p
    JOIN users u ON p.user_id = u.user_id
    WHERE p.user_id = $user_id
    ORDER BY p.created_at DESC

";


$result = $db->query($sql);

$posts = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['created_at'] = time_elapsed_string($row['created_at']);
        $posts[] = $row;
    }
}

echo json_encode($posts);

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $weeks = floor($diff->d / 7);
    $remainingDays = $diff->d % 7;

    $string = array(
        'y' => 'año',
        'm' => 'mes',
        'w' => 'semana',
        'd' => 'día',
        'h' => 'hora',
        'i' => 'minuto',
        's' => 'segundo',
    );

    $diffValues = array(
        'y' => $diff->y,
        'm' => $diff->m,
        'w' => $weeks,
        'd' => $remainingDays,
        'h' => $diff->h,
        'i' => $diff->i,
        's' => $diff->s
    );

    foreach ($string as $k => &$v) {
        if ($diffValues[$k]) {
            $v = $diffValues[$k] . ' ' . $v . ($diffValues[$k] > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? 'hace ' . implode(', ', $string) : 'justo ahora';
}

$db->close();
?>
