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
  var buttons = document.querySelectorAll("button");
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


function searchUser() {
    let searchTerm = document.getElementById('searchUser').value;
    fetch(`fetch_users.php?search=${searchTerm}`)
        .then(response => response.text())
        .then(data => {
            document.getElementById('userList').innerHTML = data;
        });
}

function deleteUser(userId) {
    if(confirm('¿Estás seguro de eliminar este usuario?')) {
        fetch(`delete_user.php?id=${userId}`, { method: 'POST' })
            .then(response => response.text())
            .then(data => {
                alert(data);
                searchUser(); // Actualizar la lista después de eliminar
            });
    }
}