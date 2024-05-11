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
 
// -ESTO ES PARA CAMBIAR LA FOTO DE PERFIL, QUITAR EN UN FUTURO YA QUE LO VAMOS A HACER CON PHP (AJAX)
document.querySelector('#profile-upload').addEventListener('change',() => {
    document.querySelectorAll('#my-profile-picture img').forEach(AllMyProfileImg => {
        AllMyProfileImg.src = URL.createObjectURL(document.querySelector('#profile-upload').files[0])
    })
})


// --------------------ADD POST POPUP--------------------

document.querySelector('#crate-lg').addEventListener('click', () => {
    document.querySelector('.add-post-popup').style.display = 'flex'
})

document.querySelector('#feed-pic-upload').addEventListener('change',() => {
    document.querySelector('#postImg').src = URL.createObjectURL(document.querySelector('#feed-pic-upload').files[0]);
})


// --------------------ADD STORY--------------------

document.querySelector('#add-story').addEventListener('click', () => {
    document.querySelector('.story img').src = URL.createObjectURL(document.querySelector('#add-story').files[0])
    document.querySelector('.add-story').style.display = 'none'
});


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