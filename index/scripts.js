const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');
const errorMessage = document.getElementById('error-message');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});

function togglePasswordVisibilitySignIn() {
    var passwordInput = document.getElementById('password_in');
    var passwordType = passwordInput.type === 'password' ? 'text' : 'password';
    passwordInput.type = passwordType;
}
function togglePasswordVisibilitySignUp() {
    var passwordInput = document.getElementById('password_up');
    var passwordType = passwordInput.type === 'password' ? 'text' : 'password';
    passwordInput.type = passwordType;
}