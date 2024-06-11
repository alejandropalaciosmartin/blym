const container = document.getElementById('container')
const registerBtn = document.getElementById('register')
const loginBtn = document.getElementById('login')

registerBtn.addEventListener('click', () => {
    container.classList.add("active")
})

loginBtn.addEventListener('click', () => {
    container.classList.remove("active")
})

// -- CHANGE EYE MODE AND INPUT TYPE (SIGN-IN FORM)
function togglePasswordVisibilitySignIn() {
    var passwordInput = document.getElementById('password_in')
    var firstEyeIcon = document.querySelector('#eye_in i')
    var isPasswordVisible = passwordInput.type === 'password'

    if (isPasswordVisible) {
        passwordInput.type = 'text'
        firstEyeIcon.classList.remove('fa-eye')
        firstEyeIcon.classList.add('fa-eye-slash')
    } else {
        passwordInput.type = 'password'
        firstEyeIcon.classList.remove('fa-eye-slash')
        firstEyeIcon.classList.add('fa-eye')
    }
}

// -- CHANGE EYE MODE AND INPUT TYPE (SIGN-UP FORM)
function togglePasswordVisibilitySignUp() {
    var passwordInput = document.getElementById('password_up')
    var secondEyeIcon = document.querySelector('#eye_up i')
    var isPasswordVisible = passwordInput.type === 'password'

    if (isPasswordVisible) {
        passwordInput.type = 'text'
        secondEyeIcon.classList.remove('fa-eye')
        secondEyeIcon.classList.add('fa-eye-slash')
    } else {
        passwordInput.type = 'password'
        secondEyeIcon.classList.remove('fa-eye-slash')
        secondEyeIcon.classList.add('fa-eye')
    }
}