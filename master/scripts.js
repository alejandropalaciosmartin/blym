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


// --------------------HIGHLIGHT POST INPUT--------------------

document.querySelector('.mini-button').addEventListener('click', () => {
    const inputPost = document.querySelector('.input-post');
    inputPost.classList.add('boxshadow1');

    // -ESTO ES PARA QUITAR EL HIGHLIGHT DESPUES DE 3.5 SEGUNDOS
    setTimeout(() => {
        inputPost.classList.remove('boxshadow1');
    }, 3500);
});