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
                <h3>BLYM</span></h3>
            </div>
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="search" placeholder="Search For Creators">
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
                        <img src="../assets/images/img/user.jpg" alt="">
                    </div>
                    <div class="profile-name">
                        <h4>John Doe</h4>
                        <p class="text-gry">@thebegjoker</p>
                    </div>
                </a>

                <!-- =============== Start Aside Bar =============== -->
                <aside>
                     <a class="menu-item" id="btn1">
                        <span><img src="../assets/images/svg/bell.svg" alt=""></span>
                        <h3>Users</h3>
                     </a>

                     <a class="menu-item" id="btn2">
                        <span><img src="../assets/images/svg/chat-left-dots.svg" alt=""></span>
                        <h3>Posts</h3>
                     </a>

                     <a class="menu-item" id="btn3">
                        <span><img src="../assets/images/svg/bookmarks.svg" alt=""></span> <h3>Stats</h3>
                     </a>

                     <a class="menu-item">
                        <span><img src="../assets/images/svg/gear.svg" alt=""></span> <h3>Settings</h3>
                     </a>
                
                </aside>
            </div>


            <!-- =============== Main Middle Start =============== -->
            <div class="main-middle">
                <div class="middle-container">
                    <div id="div1" class="hidden">USERS</div>
                    <div id="div2" class="hidden">POSTS</div>
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
                <h1>Beg Joker</h1>
                <p>@thebegjoker</p>
                <div id="my-profile-picture">
                    <img src="../assets/images/img/user.jpg" alt="">
                </div>
                <label for="profile-upload" class="btn btn-primary btn-lg">Update Profile Picture</label>
                <input type="file" accept="image/jpg, image/jpeg, image/png" id="profile-upload">
                <button class="btn btn-lg btn-primary">Log Out</button>
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
    <script src="./scripts.js"></script>

</body>
</html>