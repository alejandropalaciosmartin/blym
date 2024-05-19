<?php
include '../../assets/reusable/bd.php';
$defaultImgPath = '../assets/images/img/user.jpg';

// Obtiene el término de búsqueda desde la URL
$query = isset($_GET['q']) ? $_GET['q'] : '';


$sql = empty($query) ?
       "SELECT support.*, users.user_handle, users.first_name, users.profile_img FROM support JOIN users ON support.user_id = users.user_id ORDER BY support.created_at DESC" :
       "SELECT support.*, users.user_handle, users.first_name, users.profile_img FROM support JOIN users ON support.user_id = users.user_id WHERE users.user_handle LIKE '%$query%' OR users.first_name LIKE '%$query%' ORDER BY support.created_at DESC";


$result = $db->query($sql);


// Comprueba si hay resultados y los muestra
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $handle = htmlspecialchars($row['user_handle']);
        $timeAgo = time_elapsed_string($row['created_at']);
        $message = htmlspecialchars($row['message']);  // Añadido para mostrar el mensaje
        $imgPath = !empty($row['profile_img']) ? '../assets/usersImg/'.$row['profile_img'] : $defaultImgPath;
        
        echo "<div class='support-message'>
                <img src='$imgPath' alt='Profile image' class='profile-image'>
                <p class='user-handle'>$handle</p>
                <p class='message-text'>$message</p> 
                <p class='time-ago'>$timeAgo</p>
                
                    
                <button class='delete-btn' onclick='deleteMessage({$row['support_id']})'> 
                    <i class='fas fa-trash delete-icon'></i>
                </button>
              </div>";
    }
} else {
    echo "<div class='no-posts'>No hay mensajes de soporte</div>";
}


function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    // Calculamos las semanas y ajustamos los días
    $weeks = floor($diff->d / 7);
    $remainingDays = $diff->d % 7; // Días restantes después de extraer las semanas

    $string = array(
        'y' => 'año',
        'm' => 'mes',
        'w' => 'semana',
        'd' => 'día',
        'h' => 'hora',
        'i' => 'minuto',
        's' => 'segundo',
    );

    // Asignamos los valores a las unidades de tiempo
    $diffValues = array(
        'y' => $diff->y,
        'm' => $diff->m,
        'w' => $weeks,  // Usamos la variable local para semanas
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