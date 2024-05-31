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
                <h3>Social <span>Book</span></h3>
            </div>
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="search" placeholder="Search For Creators">
            </div>
            <div class="add-post">
                <label for="add-post" class="btn btn-primary mini-button">Add Post</label>
                <div class="profile-picture" id="my-profile-picture">
                    <img src="<?php echo $img; ?>" alt="">
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
                        <img src="<?php echo $img; ?>" alt="">
                    </div>
                    <div class="profile-name">
                        <h4>John Doe</h4>
                        <p class="text-gry">@thebegjoker</p>
                    </div>
                </a>

                <!-- =============== Start Aside Bar =============== -->
                <aside>
                    <a class="menu-item active">
                        <span><img src="../assets/images/svg/house-door.svg" alt=""></span> <h3>Home</h3>
                     </a>


                     <a class="menu-item">
                        <span><img src="../assets/images/svg/bell.svg" alt=""></span>
                        <h3>Notification</h3>
                     </a>

                     <a class="menu-item">
                        <span><img src="../assets/images/svg/chat-left-dots.svg" alt=""></span> 
                        <h3>Support</h3>
                     </a>

                     <a class="menu-item">
                        <span><img src="../assets/images/svg/bookmarks.svg" alt=""></span> <h3>Book Marks</h3>
                     </a>

                     <a class="menu-item">
                        <span><img src="../assets/images/svg/gear.svg" alt=""></span> <h3>Settings</h3>
                     </a>
                
                     <!-- =============== Add Post Button =============== -->
                     <label for="add-post" class="btn btn-primary btn-lg" id="crate-lg">Create A Post</label>
                </aside>
            </div>


            <!-- =============== Main Middle Start =============== -->
            <div class="main-middle">
                <div class="middle-container">
                    <!-- .............Start Stories............. -->
                    <div class="stories">
                        <div class="stories-wrapper swiper mySwiper">
                            <div class="swiper-wrapper">
                                <div class="story swiper-slide" onclick="uploadStoryImg()">
                                    <img src="" alt="">
                                    <div class="profile-picture" id="my-profile-picture">
                                        <img src="<?php echo $img; ?>" alt="">
                                    </div>
                                    <label for="add-story" class="add-story">
                                        <i class="fa fa-add" id="upload"></i>
                                        <p>Add Your <br> Story</p>
                                    </label>
                                    <input type="file" accept="image/jpg, image/jpeg, image/png" id="add-story">
                                </div>

                                <?php
                                    while ($story = $get_stories_result->fetch_assoc()) {
                                        $profile_img = $story['profile_img'] ? '../assets/usersImg/' . htmlspecialchars($story['profile_img']) : '../assets/images/img/user.jpg';
                                        
                                        echo '<div class="story swiper-slide">
                                                <img src="' . htmlspecialchars($story['src']) . '" alt="">
                                                <div class="profile-picture">
                                                    <img src="' . $profile_img . '" alt="">
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
                    <form class="add-post input-post">
                        <div class="profile-picture" id="my-profile-picture">
                            <img src="<?php echo $img; ?>" alt="">
                        </div>
                        <input type="text" placeholder="Type something" id="add-post">
                        <input type="submit" value="post" class="btn btn-primary">
                    </form>

                    <!-- .............Feed Aria Start............. -->
                    <div class="feeds">
                        <div class="feed">
                            <!-- ....Feed Top.... -->
                            <div class="feed-top">
                                <div class="user">
                                    <div class="profile-picture">
                                        <img src="../assets/images/img/user.jpg" alt="">
                                    </div>
                                    <div class="info">
                                        <h3>Paco</h3>
                                        <div class="time text-gry">
                                            <small> PAKISTAN, <span>1 hour ago</span> </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="edit">
                                    <img src="../assets/images/svg/three-dots.svg" alt="">
                                    <ul class="edit-menu">
                                        <li><i class="fa fa-pen"></i>Edit</li>
                                        <li><i class="fa fa-trash"></i>Delete</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- ....Feed Img.... -->
                            <div class="feed-img">
                                <img src="../assets/images/img/user.jpg" alt="">
                            </div>

                            <!-- ....Feed Action Aria.... -->
                            <div class="action-button">
                                <div class="interaction-button">
                                    <span><i class="fas fa-heart"></i></span>
                                    <span><i class="fas fa-comment-dots"></i></span>
                                    <span><i class="fas fa-link"></i></span>
                                </div>
                                <div class="bookmark">
                                    <i class="fas fa-bookmark"></i>
                                </div>
                            </div>

                            <!-- ....Liked By.... -->
                            <div class="liked-by">
                                <span><img src="../assets/images/img/user.jpg" alt=""></span>
                                <span><img src="../assets/images/img/user.jpg" alt=""></span>
                                <span><img src="../assets/images/img/user.jpg" alt=""></span>
                                <p><b>Jhon Williams</b>and <b>77 comments other</b></p>
                            </div>

                            <!-- ....Caption.... -->
                            <div class="caption">
                                <div class="title">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi, sequi.</div>
                                <p><b>Lana White</b> Lorem ipsum dolor, sit amet consectetur adipisicing elit. <span class="hars-tag">#lifestyle</span></p>
                            </div>

                            <!-- ....Comments.... -->
                            <div class="comments text-gry">
                                View all comments
                            </div>

                        </div>
                        <div class="feed">
                            <!-- ....Feed Top.... -->
                            <div class="feed-top">
                                <div class="user">
                                    <div class="profile-picture">
                                        <img src="../assets/images/img/user.jpg" alt="">
                                    </div>
                                    <div class="info">
                                        <h3>Paco</h3>
                                        <div class="time text-gry">
                                            <small> PAKISTAN, <span>1 hour ago</span> </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="edit">
                                    <img src="../assets/images/svg/three-dots.svg" alt="">
                                    <ul class="edit-menu">
                                        <li><i class="fa fa-pen"></i>Edit</li>
                                        <li><i class="fa fa-trash"></i>Delete</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- ....Feed Img.... -->
                            <div class="feed-img">
                                <img src="../assets/images/img/user.jpg" alt="">
                            </div>

                            <!-- ....Feed Action Aria.... -->
                            <div class="action-button">
                                <div class="interaction-button">
                                    <span><i class="fas fa-heart"></i></span>
                                    <span><i class="fas fa-comment-dots"></i></span>
                                    <span><i class="fas fa-link"></i></span>
                                </div>
                                <div class="bookmark">
                                    <i class="fas fa-bookmark"></i>
                                </div>
                            </div>

                            <!-- ....Liked By.... -->
                            <div class="liked-by">
                                <span><img src="../assets/images/img/user.jpg" alt=""></span>
                                <span><img src="../assets/images/img/user.jpg" alt=""></span>
                                <span><img src="../assets/images/img/user.jpg" alt=""></span>
                                <p><b>Jhon Williams</b>and <b>77 comments other</b></p>
                            </div>

                            <!-- ....Caption.... -->
                            <div class="caption">
                                <div class="title">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi, sequi.</div>
                                <p><b>Lana White</b> Lorem ipsum dolor, sit amet consectetur adipisicing elit. <span class="hars-tag">#lifestyle</span></p>
                            </div>

                            <!-- ....Comments.... -->
                            <div class="comments text-gry">
                                View all comments
                            </div>

                        </div>
                        <div class="feed">
                            <!-- ....Feed Top.... -->
                            <div class="feed-top">
                                <div class="user">
                                    <div class="profile-picture">
                                        <img src="../assets/images/img/user.jpg" alt="">
                                    </div>
                                    <div class="info">
                                        <h3>Paco</h3>
                                        <div class="time text-gry">
                                            <small> PAKISTAN, <span>1 hour ago</span> </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="edit">
                                    <img src="../assets/images/svg/three-dots.svg" alt="">
                                    <ul class="edit-menu">
                                        <li><i class="fa fa-pen"></i>Edit</li>
                                        <li><i class="fa fa-trash"></i>Delete</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- ....Feed Img.... -->
                            <div class="feed-img">
                                <img src="../assets/images/img/user.jpg" alt="">
                            </div>

                            <!-- ....Feed Action Aria.... -->
                            <div class="action-button">
                                <div class="interaction-button">
                                    <span><i class="fas fa-heart"></i></span>
                                    <span><i class="fas fa-comment-dots"></i></span>
                                    <span><i class="fas fa-link"></i></span>
                                </div>
                                <div class="bookmark">
                                    <i class="fas fa-bookmark"></i>
                                </div>
                            </div>

                            <!-- ....Liked By.... -->
                            <div class="liked-by">
                                <span><img src="../assets/images/img/user.jpg" alt=""></span>
                                <span><img src="../assets/images/img/user.jpg" alt=""></span>
                                <span><img src="../assets/images/img/user.jpg" alt=""></span>
                                <p><b>Jhon Williams</b>and <b>77 comments other</b></p>
                            </div>

                            <!-- ....Caption.... -->
                            <div class="caption">
                                <p><b>Lana White</b> Lorem ipsum dolor, sit amet consectetur adipisicing elit. <span class="hars-tag">#lifestyle</span></p>
                            </div>

                            <!-- ....Comments.... -->
                            <div class="comments text-gry">
                                View all comments
                            </div>

                        </div>
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


    <!-- =============== Swiper JS Link =============== -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- =============== Custom JS Link =============== -->
    <script src="./scripts.js?v=2"></script>

</body>
</html>