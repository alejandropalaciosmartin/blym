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





// Establecer el primer botón como activo por defecto
document.getElementById("btn1").classList.add("active");
document.getElementById("div1").classList.remove("hidden");

document.getElementById("btn1").addEventListener("click", function() {
  setActiveButton("btn1");
  showDiv("div1");
});

document.getElementById("btn2").addEventListener("click", function() {
  setActiveButton("btn2");
  showDiv("div2");
});

document.getElementById("btn3").addEventListener("click", function() {
  setActiveButton("btn3");
  showDiv("div3");
});

function setActiveButton(btnId) {
  var buttons = document.querySelectorAll("a");
  buttons.forEach(function(button) {
    button.classList.remove("active");
  });
  document.getElementById(btnId).classList.add("active");
}

function showDiv(divId) {
  var divs = document.querySelectorAll("div[id^='div']");
  divs.forEach(function(div) {
    div.classList.add("hidden");
  });
  document.getElementById(divId).classList.remove("hidden");
}