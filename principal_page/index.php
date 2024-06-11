<?php
include '../assets/reusable/sesions.php';
include '../assets/reusable/bd.php';

// --- PROFILE DATA ---
$userId = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE user_id = $userId";
$result = $db->query($sql);
$row = $result->fetch_assoc();

$img = !empty($row['profile_img']) ? '../assets/usersImg/'.$row['profile_img'] : '../assets/images/img/user.jpg';
$user_handle = $row['user_handle'];
$first_name = $row['first_name'];


// --- STORIES ---
$get_stories_sql = "SELECT stories.src, users.user_handle, users.profile_img
        FROM stories
        JOIN users ON stories.user_id = users.user_id
        JOIN followers ON users.user_id = followers.following_id
        WHERE followers.follower_id = $userId";

$get_stories_result = $db->query($get_stories_sql);

$my_stories_sql = "SELECT src FROM stories WHERE user_id = $userId";
$my_stories_result = $db->query($my_stories_sql);
$story_row = $my_stories_result->fetch_assoc();

if ($story_row) {
    $my_story_src = '../assets/storiesImg/' . $story_row['src'];
} else {
    $my_story_src = '';
}




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
    <link rel="stylesheet" href="./styles.css">

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
            <div class="add-post">
                <label for="add-post" class="btn btn-primary mini-button">Add Post</label>
                <div class="profile-picture" id="my-profile-picture">
                    <img src="<?php echo $img; ?>" class="user-image" alt="">
                </div>
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
                        <img src="<?php echo $img; ?>" class="user-image" alt="">
                    </div>
                    <div class="profile-name">
                        <h4><?php echo $first_name; ?></h4>
                        <p class="text-gry">@<?php echo $user_handle; ?></p>
                    </div>
                </a>

                <!-- =============== Start Aside Bar =============== -->
                <aside>
                    <a class="menu-item active" id="btn1">
                        <span><img src="../assets/images/svg/house-door.svg" alt=""></span> <h3>Home</h3>
                     </a>


                     <a class="menu-item" onclick="openUserListPopup()">
                        <span><img src="../assets/images/svg/user.svg" alt=""></span>
                        <h3>Users</h3>
                     </a>

                     <a class="menu-item" onclick="openSupportPopup()">
                        <span><img src="../assets/images/svg/question.svg" alt=""></span> 
                        <h3>Support</h3>
                     </a>

                     <a class="menu-item" id="btn2">
                        <span><img src="../assets/images/svg/chat-left-dots.svg" alt=""></span> <h3>My Posts</h3>
                     </a>
                
                </aside>
            </div>


            <!-- =============== Main Middle Start =============== -->
            <div class="main-middle">
                <div class="middle-container">

                    <!-- .............Start Stories............. -->
                    <div class="stories">
                        <div class="stories-wrapper swiper mySwiper">
                            <div class="swiper-wrapper">
                                <div class="story swiper-slide">
                                    <img id="story-img" src="<?php echo $my_story_src ?>" alt="">
                                    <div class="profile-picture" id="my-profile-picture">
                                        <img src="<?php echo $img; ?>" class="user-image" alt="">
                                    </div>
                                    <label for="add-story" class="add-story" id="upload">
                                        <i class="fa fa-add"></i>
                                        <p>Add Your <br> Story</p>
                                    </label>
                                    <input type="file" accept="image/jpg, image/jpeg, image/png" id="add-story" style="display:none" onchange="uploadStoryImg()">
                                </div>

                                <?php
                                    while ($story = $get_stories_result->fetch_assoc()) {
                                        $profile_img = $story['profile_img'] ? '../assets/usersImg/' . htmlspecialchars($story['profile_img']) : '../assets/images/img/user.jpg';
                                        
                                        echo '<div class="story swiper-slide">
                                                <img src="../assets/storiesImg/' . htmlspecialchars($story['src']) . '" alt="">
                                                <div class="profile-picture">
                                                    <img src="' . $profile_img . '" alt="" class="user-image">
                                                </div>
                                                <small><i class="fa fa-add"></i></small>
                                                <p>' . htmlspecialchars($story['user_handle']) . '</p>
                                              </div>';
                                    }
                                ?>
                            </div>

                        </div>
                    </div>

                    <!-- .............Post Input............. -->
                    <form class="add-post input-post" onsubmit="submitPost(event)" enctype="multipart/form-data">
                        <div class="profile-picture" id="my-profile-picture">
                            <img src="<?php echo $img; ?>" class="user-image" alt="">
                        </div>
                        <textarea name="post_text" placeholder="Type something" id="add-post" maxlength="500"></textarea>
                        <input type="submit" value="Post" class="btn btn-primary">
                    </form>

                    <!-- .............Feed Aria Start............. -->
                    <div id="div1" class="">
                        <div class="feeds"></div>
                    </div>
                    <div id="div2" class="hidden">
                        <div class="my-feeds"></div>
                    </div>
                    
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
                    <img src="<?php echo $img; ?>" class="user-image" alt="Profile Picture" id="my-profile-picture-pop-up">
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

    <!-- =============== Start Add Post-Popup =============== -->
    <div class="popup add-post-popup">
        <div>
            <form class="popup-box add-post-popup">
                <h1>Add New Post</h1>
                <div class="row post-title">
                    <label>Title</label>
                    <input type="text" id="add-post" placeholder="What's on your mind ?">
                </div>
                <div class="row post-img">
                    <img src="" alt="" id="postImg">
                    <label for="feed-pic-upload" class="feed-upload-button">
                        <span><i class="fa fa-add"></i></span> 
                        Profile Picture
                    </label>
                    <input type="file" accept="image/jpg, image/jpeg, image/png" id="feed-pic-upload">
                    <input type="submit" class="btn btn-lg btn-primary" value="Add Post">
                </div>
            </form>
            <span class="close"><i class="fa fa-close"></i></span>
        </div>
    </div>

    <div class="popup support-popup" id="supportPopup">
        <div>
            <div class="popup-box support-popup-box">
                <h1>Support</h1>
                <textarea id="supportMessage" placeholder="Type your message here..." rows="10" style="width: 100%;"></textarea>
                <button class="btn btn-primary btn-lg" onclick="sendSupportMessage()">Send Message</button>
            </div>
            <span class="close" onclick="closeSupportPopup()"><i class="fa fa-close"></i></span>
        </div>
    </div>

    <div class="popup user-list-popup" id="userListPopup">
        <div>
            <div class="popup-box user-list-popup-box">
                <div class="header">
                    <button id="allUsersBtn" class="btn btn-primary" onclick="showAllUsers()">All Users</button>
                    <button id="followedUsersBtn" class="btn btn-secondary" onclick="showFollowedUsers()">Followed Users</button>
                    
                </div>
                <div class="search-bar">
                    <input type="search" id="userSearchInput" onkeyup="filterUserList()" placeholder="Search for users..." class="search-input">
                </div>
                <div id="userListContent" class="user-list-content">
                    <!-- Aquí se cargará la lista de usuarios -->
                </div>
            </div>
            <span class="close" onclick="closeUserListPopup('userListPopup')"><i class="fa fa-close"></i></span>
        </div>
    </div>


    <!-- =============== Swiper JS Link =============== -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- =============== Custom JS Link =============== -->
    <script src="./scripts.js?v=2"></script>

</body>
</html>