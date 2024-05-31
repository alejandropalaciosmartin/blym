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
  }




// --------------------ADD POST POPUP--------------------

document.querySelector('#crate-lg').addEventListener('click', () => {
    document.querySelector('.add-post-popup').style.display = 'flex'
})

document.querySelector('#feed-pic-upload').addEventListener('change',() => {
    document.querySelector('#postImg').src = URL.createObjectURL(document.querySelector('#feed-pic-upload').files[0]);
})


// --------------------ADD STORY--------------------

// document.querySelector('#add-story').addEventListener('click', () => {
//     document.querySelector('.story img').src = URL.createObjectURL(document.querySelector('#add-story').files[0])
//     document.querySelector('.add-story').style.display = 'none'
// });


// --------------------HIGHLIGHT POST INPUT--------------------

document.querySelector('.mini-button').addEventListener('click', () => {
    const inputPost = document.querySelector('.input-post');
    inputPost.classList.add('boxshadow1');

    // -ESTO ES PARA QUITAR EL HIGHLIGHT DESPUES DE 3.5 SEGUNDOS
    setTimeout(() => {
        inputPost.classList.remove('boxshadow1');
    }, 3500);
});


// --------------------LIKE BUTTON--------------------

document.querySelectorAll('.action-button span:first-child i').forEach(liked => {
    liked.addEventListener('click', () => {
        liked.classList.toggle('liked')
    })
})