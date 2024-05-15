<?php
    include '../assets/reusable/sesions.php';
    include '../assets/reusable/bd.php';

    $defaultImgPath = '../assets/images/img/user.jpg'; // Define una imagen por defecto

    $userId = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE user_id = $userId"; // Consulta para obtener la imagen del perfil
    $result = $db->query($sql);

    $row = $result->fetch_assoc();
    $img = !empty($row['profile_img']) ? './ajax/'.$row['profile_img'] : $defaultImgPath; // Usa la imagen de la DB o la por defecto

    $user_handle = $row['user_handle'];
    $first_name = $row['first_name'];

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

    <!-- =============== Swiper Slider Link =============== -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

</head>
<body>

    <!-- =============== Start Navbar =============== -->
    <nav>
    <div class="container nav-container">
        <div class="logo">
            <h3>BLYM</h3>
        </div>
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="search" placeholder="Search Users" oninput="searchUsers(this.value)">
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
                        <span><img src="../assets/images/svg/graph-up-arrow.svg" alt=""></span> <h3>Stats</h3>
                     </a>

                     <a class="menu-item">
                        <span><img src="../assets/images/svg/gear.svg" alt=""></span> <h3>Settings</h3>
                     </a>
                
                </aside>
            </div>


            <!-- =============== Main Middle Start =============== -->
            <div class="main-middle">
                <div class="middle-container">
                    <div id="div1" class="hidden users-grid"></div>
                    <div id="div2" class="hidden">SUPPORT</div>
                    <div id="div3" class="hidden">STATISTICS</div>
                </div>
            </div>

        </div>
    </main>

    <!-- =============== Start Popup Aria =============== -->
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


    



    <!-- =============== Swiper JS Link =============== -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- =============== Custom JS Link =============== -->
    <script src="./scripts.js"></script>
</body>
</html>