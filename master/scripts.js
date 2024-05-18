// --------------------SEARCH USERS AUTOMATICAMENTE--------------------
document.addEventListener('DOMContentLoaded', function() {
  searchUsers(''); // Esto cargará todos los usuarios inicialmente

  var activeButtonId = localStorage.getItem("activeButtonId") || "btn1";
  var activeDivId = localStorage.getItem("activeDivId") || "div1";

  setActiveButton(activeButtonId);
  showDiv(activeDivId);
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




document.getElementById("btn1").addEventListener("click", function() {
  setActiveButton("btn1");
  showDiv("div1");
  saveState("btn1", "div1");
});

document.getElementById("btn2").addEventListener("click", function() {
  setActiveButton("btn2");
  showDiv("div2");
  saveState("btn2", "div2");
});

document.getElementById("btn3").addEventListener("click", function() {
  setActiveButton("btn3");
  showDiv("div3");
  saveState("btn3", "div3");
});

function setActiveButton(btnId) {
  var buttons = document.querySelectorAll("a");
  var searchInput = document.querySelector("input[type='search']");

  buttons.forEach(function(button) {
    button.classList.remove("active");
  });
  document.getElementById(btnId).classList.add("active");

  // Opcional: vaciar el input de búsqueda si piensas que podría ser necesario en algunos casos
  searchInput.value = ""; // Asegura que el input se vacíe cada vez que se cambie de vista
}

function showDiv(divId) {
  var divs = document.querySelectorAll("div[id^='div']");
  var searchBars = document.querySelectorAll('.search-bar');

  var searchInput = document.querySelector("input[type='search']");

  divs.forEach(function(div) {
    div.classList.add("hidden");
  });
  searchBars.forEach(function(searchBar) {
    searchBar.classList.add('hidden');
  });

  document.getElementById(divId).classList.remove("hidden");
  document.getElementById(`search-bar-${divId}`).classList.remove("hidden");

  // Vaciar y controlar el estado del input de búsqueda
  searchInput.value = ""; // Vacía el input al cambiar de vista

  if (divId === "div3") {
    searchInput.disabled = true; // Deshabilita el input en la vista de Stats
  } else {
    searchInput.disabled = false; // Habilita el input en otras vistas
    searchUsers(''); // Realiza una búsqueda con el input vacío para actualizar la vista
  }
}

function saveState(btnId, divId) {
  localStorage.setItem("activeButtonId", btnId);
  localStorage.setItem("activeDivId", divId);
}



// --------------------SEARCH USERS--------------------
function searchUsers(query) {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
      if (xhr.readyState == 4 && xhr.status == 200) {
          document.getElementById('div1').innerHTML = xhr.responseText;
      }
  };

  xhr.open('GET', './ajax/searchUsers.php?q=' + encodeURIComponent(query), true);
  xhr.send();
}


// --------------------DELETE USER--------------------
function deleteUser(userId) {
  if (confirm('Are you sure you want to delete this user?')) {
      var xhr = new XMLHttpRequest();
      xhr.open('POST', './ajax/deleteUser.php', true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.onload = function () {
          if (this.status == 200) {
              console.log('Response:', this.responseText);
              location.reload(); // Recargar la página para actualizar la lista de usuarios
          }
      };
      xhr.send('id=' + userId);
  }
}

// --------------------UPLOAD PROFILE PHOTO--------------------
document.getElementById('profile-upload').addEventListener('change', function() {
  var fileInput = this;
  var file = fileInput.files[0];
  if (file) {
      // Crea una URL temporal y actualiza la imagen de previsualización
      var imgUrl = URL.createObjectURL(file);
      document.querySelector('#my-profile-picture-pop-up').src = imgUrl;
  }
});

function uploadImage() {
  var fileInput = document.getElementById('profile-upload');
  var file = fileInput.files[0];
  var formData = new FormData();
  formData.append('profilePic', file);

  fetch('./ajax/uploadImg.php', {
      method: 'POST',
      body: formData,
  })
  .then(response => response.text())
  .then(data => {
      console.log(data); // Muestra la respuesta del servidor
      alert("Image uploaded successfully!");
      window.location.reload();
  })
  .catch(error => {
      console.error('Error:', error);
      alert("Failed to upload image.");
  });
}