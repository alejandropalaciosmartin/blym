<?php
    include '../assets/reusable/sesions.php';
    include '../assets/reusable/bd.php';

    $userId = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE user_id = $userId";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    
    $img = !empty($row['profile_img']) ? '../assets/usersImg/'.$row['profile_img'] : '../assets/images/img/user.jpg';
    $user_handle = $row['user_handle'];
    $first_name = $row['first_name'];


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
    
    
    // --- DATOS DIV 3 ---
    $sql_total_users = "SELECT COUNT(*) as total_users FROM users";
    $sql_total_posts = "SELECT COUNT(*) as total_posts FROM posts";
    $sql_active_users = "SELECT COUNT(*) as active_users FROM users WHERE active = 1";
    $sql_total_support_messages = "SELECT COUNT(*) as total_support_messages FROM support";

    $result_total_users = $db->query($sql_total_users);
    $result_total_posts = $db->query($sql_total_posts);
    $result_active_users = $db->query($sql_active_users);
    $result_total_support_messages = $db->query($sql_total_support_messages);

    $total_users = $result_total_users->fetch_assoc()['total_users'];
    $total_posts = $result_total_posts->fetch_assoc()['total_posts'];
    $active_users = $result_active_users->fetch_assoc()['active_users'];
    $total_support_messages = $result_total_support_messages->fetch_assoc()['total_support_messages'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blym</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="../assets/images/svg/b.svg" type="image/x-icon">

    <!-- =============== CUSTOM CSS LINK =============== -->
    <link rel="stylesheet" href="./styles.css?v=2">

    <!-- =============== Font Awesome Link =============== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>
<body>

    <!-- =============== Start Navbar =============== -->
    <nav>
        <div class="container nav-container">
            <div class="logo">
                <h3>BLYM</h3>
            </div>
            <div class="search-bar" id="search-bar-div1">
                <i class="fas fa-search"></i>
                <input type="search" placeholder="Search Users" oninput="searchUsers(this.value)">
            </div>
            <div class="search-bar hidden" id="search-bar-div2">
                <i class="fas fa-search"></i>
                <input type="search" placeholder="Search Posts" oninput="searchSupportMessages(this.value)">
            </div>

            <div class="profile-picture-nav" id="my-profile-picture">
                <img src="<?php echo $img; ?>" alt="Profile Image">
            </div>
        </div>
    </nav>

    <!-- =============== Start Main Section =============== -->
    <main>
        <div class="container main-container">

            <!-- =============== Main Left Start =============== -->
            <div class="main-left">

                <!-- =============== Profile Section =============== -->
                <a class="profile">
                    <div class="profile-picture" id="my-profile-picture">
                        <img src="<?php echo $img; ?>" alt="">
                    </div>
                    <div class="profile-name">
                        <h4><?php echo $first_name; ?></h4>
                        <p class="text-gry">@<?php echo $user_handle; ?></p>
                    </div>
                </a>

                <!-- =============== Start Aside Bar =============== -->
                <aside>
                     <a class="menu-item" id="btn1">
                        <span><img src="../assets/images/svg/user.svg" alt=""></span>
                        <h3>Users</h3>
                     </a>

                     <a class="menu-item" id="btn2">
                        <span><img src="../assets/images/svg/chat-left-dots.svg" alt=""></span>
                        <h3>Support</h3>
                     </a>

                     <a class="menu-item" id="btn3">
                        <span><img src="../assets/images/svg/graph-up-arrow.svg" alt=""></span> 
                        <h3>Stats</h3>
                     </a>
                </aside>
            </div>


            <!-- =============== Main Middle Start =============== -->
            <div class="main-middle">
                <div class="middle-container">
                    <div id="div1" class="hidden users-grid"></div>
                    <div id="div2" class="hidden"></div>
                    <div id="div3" class="hidden">
                        <div class="stats-container">
                            <div class="stat-box">
                                <div class="stat-title">Total de usuarios</div>
                                <div class="stat-content">
                                    <div class="stat-icon total-users"></div>
                                    <p class="stat-value"><?php echo $total_users; ?></p>
                                </div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-title">Total de posts</div>
                                <div class="stat-content">
                                    <div class="stat-icon total-posts"></div>
                                    <p class="stat-value"><?php echo $total_posts; ?></p>
                                </div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-title">Total de mensajes de soporte</div>
                                <div class="stat-content">
                                    <div class="stat-icon support-messages"></div>
                                    <p class="stat-value"><?php echo $total_support_messages; ?></p>
                                </div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-title">Usuarios activos</div>
                                <div class="stat-content">
                                    <div class="stat-icon active-users"></div>
                                    <p class="stat-value"><?php echo $active_users; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- =============== Start Profile-Popup =============== -->
    <div class="popup profile-popup">
        <div>
            <div class="popup-box profile-popup-box">
                <h1><?php echo $first_name; ?></h1>
                <p>@<?php echo $user_handle; ?></p>
                <div id="my-profile-picture">
                    <img src="<?php echo $img; ?>" alt="Profile Picture" id="my-profile-picture-pop-up">
                </div>
                <form id="uploadForm" enctype="multipart/form-data" class="form-inline">
                    <label for="profile-upload" class="btn btn-primary btn-lg">
                        <i class="fa fa-upload"></i>
                    </label>
                    <input type="file" accept="image/jpg, image/jpeg, image/png" id="profile-upload" name="profilePic">
                    <button type="button" class="btn btn-lg btn-primary" onclick="uploadImage()">Save Changes</button>
                </form>
                <button class="btn btn-lg btn-primary" onclick="window.location.href='logout.php'">Log Out</button>
            </div>
            <span class="close"><i class="fa fa-close"></i></span>
        </div>
    </div>

    <!-- =============== Custom JS Link =============== -->
    <script src="./scripts.js"></script>
</body>
</html>