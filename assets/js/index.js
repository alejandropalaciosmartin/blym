const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});

function togglePasswordVisibility() {
    var passwordInput = document.getElementById('password');
    var passwordType = passwordInput.type === 'password' ? 'text' : 'password';
    passwordInput.type = passwordType;
}
