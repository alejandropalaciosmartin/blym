document.addEventListener("DOMContentLoaded", function() {
    var storyImg = document.getElementById('story-img')
    var addStoryLabel = document.getElementsByClassName('add-story')[0]

    if (storyImg.getAttribute('src') !== '') {
        addStoryLabel.style.display = 'none'
    } else {
        addStoryLabel.style.display = 'flex'
    }

    

    fetchPosts()
})

// -------------------- FETCH POSTS --------------------
function fetchPosts() {
    fetch('./ajax/fetchPosts.php')
        .then(response => response.json())
        .then(data => {
            const feedContainer = document.querySelector('.feeds')
            feedContainer.innerHTML = ''

            data.forEach(post => {
                const postElement = document.createElement('div')
                postElement.className = 'feed'
                postElement.innerHTML = `
                    <div class="feed-top">
                        <div class="user">
                            <div class="profile-picture">
                                <img src="../assets/usersImg/${post.profile_img}" alt="" class="user-image">
                            </div>
                            <div class="info">
                                <h3>${post.first_name}</h3>
                                <div class="time text-gry">
                                    <small>${post.created_at}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="feed-middle">
                        <p>${post.post_text}</p>
                    </div>
                    <div class="liked-by">
                        <span>
                            <i class="fas fa-heart ${post.liked != 0 ? 'liked' : ''}" data-post-id="${post.post_id}"></i>
                        </span>
                        <p><b>${post.likes_count}</b> likes</p>
                    </div>
                `
                feedContainer.appendChild(postElement)
            })

            document.querySelectorAll('.fa-heart').forEach(heart => {
                heart.addEventListener('click', () => {
                    const postId = heart.getAttribute('data-post-id')
                    if (heart.classList.contains('liked')) {
                        unlikePost(postId, heart)
                    } else {
                        likePost(postId, heart)
                    }
                })
            })
        })
        .catch(error => {
            console.error('Error:', error)
        })
}





// --------------------SWIPER STORY--------------------

let swiper = new Swiper('.mySwiper', {
    slidesPerView: 6, // Número de slides por defecto para pantallas mayores a 600px
    spaceBetween: 5,  // Espacio entre slides

    // Configuración de los breakpoints
    breakpoints: {
        0: {
            slidesPerView: 4,
            spaceBetween: 5
        },
        730: {
            slidesPerView: 5,
            spaceBetween: 7
        },
        1024: {
            slidesPerView: 6,
            spaceBetween: 5
        }
    }
});



// --------------------WINDOW SCROLL--------------------
// -ESTO ES PARA CERRAR EL POPUP DE PERFIL CUANDO SE HACE SCROLL
window.addEventListener('scroll', () => {
    document.querySelector('.profile-popup').style.display = 'none'
})



// --------------------PROFILE POPUP--------------------

document.querySelectorAll('#my-profile-picture').forEach( AllProfile => {
    AllProfile.addEventListener('click', () => {
        document.querySelector('.profile-popup').style.display = 'flex'
    })
})

document.querySelectorAll('.close').forEach( AllCloser => {
    AllCloser.addEventListener('click', () => {
        document.querySelector('.profile-popup').style.display = 'none'
        document.querySelector('.add-post-popup').style.display = 'none'
    })
})
 
// --------------------UPLOAD PROFILE PHOTO--------------------
document.getElementById('profile-upload').addEventListener('change', function() {
    var fileInput = this
    var file = fileInput.files[0]
    if (file) {
        var imgUrl = URL.createObjectURL(file);
        document.querySelector('#my-profile-picture-pop-up').src = imgUrl
    }
  })
  
  function uploadImage() {
    var fileInput = document.getElementById('profile-upload')
    var file = fileInput.files[0]
    var formData = new FormData()
    formData.append('profilePic', file)
  
    fetch('./ajax/uploadImg.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(data => {
        window.location.reload()
    })
    .catch(error => {
        console.error('Error:', error)
        alert("Failed to upload image.")
    })
  }


// --------------------UPLOAD STORIES IMAGES--------------------
function uploadStoryImg() {
    var fileInput = document.getElementById('add-story')
    var file = fileInput.files[0]
    var formData = new FormData()
    formData.append('storyImg', file)

    fileInput.disabled = true

    fetch('./ajax/uploadStoryImg.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(data => {
        window.location.reload()
    })
    .catch(error => {
        console.error('Error:', error)
        alert("Failed to upload image.")
    })
    .finally(() => {
        fileInput.disabled = false
        fileInput.value = ""
    })
}


// --------------------HIGHLIGHT POST INPUT--------------------

document.querySelector('.mini-button').addEventListener('click', () => {
    const inputPost = document.querySelector('.input-post')
    inputPost.classList.add('boxshadow1')

    // Desplazarse hasta el elemento
    inputPost.scrollIntoView({ behavior: 'auto', block: 'center' })

    // -ESTO ES PARA QUITAR EL HIGHLIGHT DESPUES DE 3.5 SEGUNDOS
    setTimeout(() => {
        inputPost.classList.remove('boxshadow1')
    }, 3500)
})


// --------------------LIKE BUTTON--------------------

document.querySelectorAll('.action-button span:first-child i').forEach(liked => {
    liked.addEventListener('click', () => {
        liked.classList.toggle('liked')
    })
})

// --------------------SUPPORT POPUP--------------------
function openSupportPopup() {
    document.getElementById('supportPopup').style.display = 'flex'
}

function closeSupportPopup() {
    document.getElementById('supportPopup').style.display = 'none'
}

function sendSupportMessage() {
    var message = document.getElementById('supportMessage').value

    if (message.trim() === "") {
        alert("Please enter a message before sending.")
        return
    }

    var formData = new FormData()
    formData.append('message', message)

    fetch('./ajax/sendSupportMessage.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(data => {
        alert("Message sent successfully.")
        closeSupportPopup()
    })
    .catch(error => {
        console.error('Error:', error)
        alert("Failed to send message.")
    })
}


// --------------------USERS POPUP--------------------
let allUsers = []
let followedUsers = []
let activeView = 'all'

function openUserListPopup() {
    document.getElementById('userListPopup').style.display = 'flex'
    showAllUsers();
}

function closeUserListPopup(popupId) {
    var popup = document.getElementById(popupId)
    if (popup) {
        popup.style.display = 'none'
        if (popupId === 'userListPopup') {
            location.reload()
        }
    }
}

function showAllUsers() {
    fetch('./ajax/getAllUsers.php')
    .then(response => response.json())
    .then(data => {
        allUsers = data;
        renderUserList(allUsers)
        setActiveView('all')
    })
    .catch(error => {
        console.error('Error:', error)
        alert("Failed to load users.")
    })
}

function showFollowedUsers() {
    fetch('./ajax/getFollowedUsers.php')
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            renderUserList([], data.message)
        } else {
            followedUsers = data;
            renderUserList(followedUsers)
        }
        setActiveView('followed')
    })
    .catch(error => {
        console.error('Error:', error)
        alert("Failed to load followed users.")
    })
}

function renderUserList(users, message = null) {
    const userListContent = document.getElementById('userListContent')
    userListContent.innerHTML = ''

    if (message) {
        const messageItem = document.createElement('div')
        messageItem.className = 'message-item'
        messageItem.textContent = message
        userListContent.appendChild(messageItem)
        return
    }

    if (users.length === 0) {
        const notFoundItem = document.createElement('div')
        notFoundItem.className = 'message-item'
        notFoundItem.textContent = 'User not found'
        userListContent.appendChild(notFoundItem)
        return
    }

    users.forEach(user => {
        const userItem = document.createElement('div')
        userItem.className = 'user-item'

        const followButtonText = user.is_following == 1 ? 'Unfollow' : 'Follow'
        const followButtonClass = user.is_following == 1 ? 'btn btn-primary' : 'btn btn-secondary'

        userItem.innerHTML = `
            <img src="${user.profile_img}" alt="${user.user_handle}">
            <div class="user-info">
                <h4>${user.first_name}</h4>
                <p>@${user.user_handle}</p>
            </div>
            <button class="${followButtonClass}" onclick="toggleFollow(${user.id}, ${user.is_following})">${followButtonText}</button>
        `

        userListContent.appendChild(userItem)
    })
}

function filterUserList() {
    const searchTerm = document.getElementById('userSearchInput').value.toLowerCase()
    let filteredUsers = []

    if (activeView === 'all') {
        filteredUsers = allUsers.filter(user => 
            user.user_handle.toLowerCase().includes(searchTerm) || 
            user.first_name.toLowerCase().includes(searchTerm)
        )
    } else if (activeView === 'followed') {
        filteredUsers = followedUsers.filter(user => 
            user.user_handle.toLowerCase().includes(searchTerm) || 
            user.first_name.toLowerCase().includes(searchTerm)
        )
    }

    renderUserList(filteredUsers)
}

document.getElementById('userSearchInput').addEventListener('input', filterUserList)

function toggleFollow(userId, isFollowing) {
    const action = isFollowing ? 'unfollow' : 'follow';

    fetch(`./ajax/${action}User.php?userId=${userId}`, {
        method: 'GET',
    })
    .then(response => response.text())
    .then(data => {
        if (activeView === 'all') {
            showAllUsers();
        } else if (activeView === 'followed') {
            showFollowedUsers()
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert(`Failed to ${action} user.`)
    })
}

function setActiveView(view) {
    document.getElementById('userSearchInput').value = ''
    activeView = view

    if (view === 'all') {
        document.getElementById('followedUsersBtn').classList.remove('btn-primary')
        document.getElementById('followedUsersBtn').classList.remove('btn-secondary')
        document.getElementById('allUsersBtn').classList.add('btn-primary')
        
    } else if (view === 'followed') {
        document.getElementById('allUsersBtn').classList.remove('btn-primary')
        document.getElementById('allUsersBtn').classList.add('btn-secondary')
        document.getElementById('followedUsersBtn').classList.add('btn-primary')
    }
}


// --------------------SUBMIT POST--------------------
function submitPost(event) {
    event.preventDefault()
    var form = document.querySelector('.input-post')
    if (!form) {
        console.error("Formulario no encontrado")
        return
    }

    var formData = new FormData(form);

    fetch('./ajax/submitPost.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        window.location.reload()
    })
    .catch(error => {
        console.error('Error:', error)
    })
}

// -------------------- DIV 1/2/3 FUNCTIONALITY (DINAMIC MENU) --------------------
document.getElementById("btn1").addEventListener("click", function() {
    setActiveButton("btn1")
    showDiv("div1")
})
document.getElementById("btn2").addEventListener("click", function() {
    setActiveButton("btn2")
    showDiv("div2")
})
function setActiveButton(btnId) {
    var buttons = document.querySelectorAll("a");
    var searchInput = document.querySelector("input[type='search']")
  
    buttons.forEach(function(button) {
      button.classList.remove("active")
})
    document.getElementById(btnId).classList.add("active")
  
    searchInput.value = ""
}
  
// --------------------SHOW DIV--------------------
function showDiv(divId) {
    var divs = document.querySelectorAll("div[id^='div']")
    var searchBars = document.querySelectorAll('.search-bar')

    divs.forEach(function(div) {
        div.classList.add("hidden")
    })
    searchBars.forEach(function(searchBar) {
        searchBar.classList.add('hidden')
    })

    var selectedDiv = document.getElementById(divId)
    if (selectedDiv) {
        selectedDiv.classList.remove("hidden")
    }

    var searchBar = document.querySelector(`#search-bar-${divId}`)
    if (searchBar) {
        searchBar.classList.remove("hidden")
        document.querySelector(`#search-bar-${divId} input[type="search"]`).value = ""
    }

    if (divId === "div1") {
        fetchPosts()
    } else if (divId === "div2") {
        fetchMyPosts()
    }
}


// -------------------- FETCH MY POSTS --------------------
function fetchMyPosts() {
    fetch('./ajax/fetchMyPosts.php')
        .then(response => response.json())
        .then(data => {
            const feedContainer = document.querySelector('.my-feeds')
            feedContainer.innerHTML = ''

            data.forEach(post => {
                const postElement = document.createElement('div')
                postElement.className = 'feed'
                postElement.innerHTML = `
                    <div class="feed-top">
                        <div class="user">
                            <div class="profile-picture">
                                <img src="../assets/usersImg/${post.profile_img}" alt="" class="user-image">
                            </div>
                            <div class="info">
                                <h3>${post.first_name}</h3>
                                <div class="time text-gry">
                                    <small>${post.created_at}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="feed-middle">
                        <p>${post.post_text}</p>
                    </div>
                    <div class="liked-by">
                        <span>
                            <i class="fas fa-heart ${post.liked != 0 ? 'liked' : ''}" data-post-id="${post.post_id}"></i>
                        </span>
                        <p><b>${post.likes_count}</b> likes</p>
                    </div>
                `
                feedContainer.appendChild(postElement)
            })

            document.querySelectorAll('.fa-heart').forEach(heart => {
                heart.addEventListener('click', () => {
                    const postId = heart.getAttribute('data-post-id')
                    if (heart.classList.contains('liked')) {
                        unlikePost(postId, heart)
                    } else {
                        likePost(postId, heart)
                    }
                })
            })
        })
        .catch(error => {
            console.error('Error:', error)
        })
}


function likePost(postId, heartElement) {
    fetch('./ajax/likePost.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `post_id=${postId}`
    })
    .then(data => {
            heartElement.classList.add('liked')
            const likesCountElement = heartElement.parentElement.nextElementSibling.querySelector('b')
            likesCountElement.textContent = parseInt(likesCountElement.textContent) + 1
    })
    .catch(error => {
        console.error('Error:', error)
    })
}

function unlikePost(postId, heartElement) {
    fetch('./ajax/unlikePost.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `post_id=${postId}`
    })
    .then(data => {
        heartElement.classList.remove('liked')
        const likesCountElement = heartElement.parentElement.nextElementSibling.querySelector('b')
        likesCountElement.textContent = parseInt(likesCountElement.textContent) - 1
    })
    .catch(error => {
        console.error('Error:', error)
    })
}