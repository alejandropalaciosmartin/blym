<?php

session_start();
include '../assets/reusable/bd.php';

$search = $_GET['search'] ?? '';

$sql = "SELECT * FROM users WHERE user_handle LIKE ?";
$stmt = $db->prepare($sql);
$searchTerm = '%' . $search . '%';
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="../assets/images/b.svg" type="image/x-icon">
    <link rel="stylesheet" href="styles.css">
    <title>Blym</title>
</head>
<body>
    <header>
        <button id="btn1">USERS</button>
        <button id="btn2">POSTS</button>
        <button id="btn3">STATS</button>
    </header>
    <main>
        <div id="div1" class="hidden">
            <input type="text" id="searchUser" placeholder="Buscar usuario..."  onkeyup="searchUser()">
            <div id="userList"> <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<div>' . htmlspecialchars($row["user_handle"]) . ' 
                            // TODO: Add delete button
                        </div>';
                    }
                } else {
                    echo "No hay usuarios.";
                }
            ?> </div>
        </div>
        <div id="div2" class="hidden">POSTS</div>
        <div id="div3" class="hidden">STATISTICS</div>
    </main>
  
    <script src="scripts.js"></script>
</body>
</html>