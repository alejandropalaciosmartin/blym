<?php
// Inicia la sesión PHP para poder redireccionar al usuario tras el inicio de sesión exitoso
session_start();

include './assets/reusable/bd.php';

// Verifica si se envió el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signin'])) {

    $email = $_POST['email'];
    $password = $_POST['password']; // TODO: Considerar hashear la contraseña

    $sql = "SELECT * FROM users WHERE email_address = '$email' AND password = '$password'"; // Comprobar si el usuario y la contraseña están en la base de datos
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    if($row['active'] == 1) {
        $_SESSION['error'] = "User is already logged in";
        header('Location: ./index.php'); // Redireccionamiento aquí para mostrar el mensaje de error
        exit();
    }
    else if ($result->num_rows > 0) { // Inicio de sesión exitoso
        $_SESSION['user_id'] = $row['user_id'];
        
        $user_id = $row['user_id'];
        $update_active_sql = "UPDATE users SET active = 1 WHERE user_id = '$user_id'";
        $db->query($update_active_sql);

        if($email == 'srjalean@gmail.com') {
            header("Location: ./master/"); // Redirecciona al usuario a la página de administrador
            exit();
        } else { 
            header("Location: ./principal_page/"); // Redirecciona al usuario a la página de usuario normal
            exit();
        }
        
    } else {
        $_SESSION['error'] = "User or password incorrect";
        header('Location: ./index.php'); // Redireccionamiento aquí para mostrar el mensaje de error
        exit();
    }
}

// Verifica si se envió el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {

    $first_name = $_POST['first_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $validUsername = "SELECT user_id FROM users WHERE user_handle = '$username'";
    $resultUsername = $db->query($validUsername);

    $validEmail = "SELECT user_id FROM users WHERE email_address = '$email'";
    $resultEmail = $db->query($validEmail);

    $resultFirstNameOneWord = False;
    $resultUsernameOneWord = False;
    $resultEmailValid = False;

    if ($resultUsername->num_rows > 0 || $resultEmail->num_rows > 0 || preg_match('/^[a-zA-Z]+$/', $first_name) === 0 || preg_match('/^[a-zA-Z]+$/', $username) === 0 || preg_match('/^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/', $email) === 0) {

        if(preg_match('/^[a-zA-Z]+$/', $first_name) === 0) {

            $_SESSION['error'] = "First name must contain only letters and one word";
            $resultFirstNameOneWord = True;

        } elseif (preg_match('/^[a-zA-Z0-9]+$/', $username) === 0 || $resultUsername->num_rows > 0 ) {

            if ($resultUsername->num_rows > 0) {
                $_SESSION['error'] = "Username is already in use. Try another one";
            } else {
                $_SESSION['error'] = "Username must contain only one word";
                $resultUsernameOneWord = True;
            } 

        } elseif ($resultEmail->num_rows > 0 || preg_match('/^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/', $email) === 0 ) {

            if ($resultEmail->num_rows > 0) {
                $_SESSION['error'] = "Email is already in use. Try another one";
            } else {
                $_SESSION['error'] = "Email is not write correctly. Try again.";
                $resultEmailValid = True;
            } 

        } else{}

        // Guardar otros campos en la sesión
        $_SESSION['form_data'] = [
            'first_name' => $resultFirstNameOneWord ? '' : ucfirst(strtolower($first_name)),
            'email' => $resultEmail->num_rows > 0 || $resultEmailValid ? '' : strtolower($email),
            'username' => $resultUsername->num_rows > 0 || $resultUsernameOneWord ? '' : $username
        ];

    } else {
        $first_name = ucfirst(strtolower($first_name));

        $sql = "INSERT INTO users (user_handle, email_address, first_name, password) VALUES ('$username', '$email', '$first_name', '$password')";

        if ($db->query($sql) === TRUE) {
            $_SESSION['success'] = "Successful registration. Sign in now.";
            $_SESSION['form_data'] = [
                'first_name' => '',
                'email' => '',
                'username' => ''
            ];
        } else {
            $_SESSION['error'] = "Registration error: " . $db->error;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="./assets/images/svg/b.svg" type="image/x-icon">
    <link rel="stylesheet" href="./index/styles.css?v=2">
    <title>Blym</title>
</head>

<body>
    <p class="title">BLYM</p>

    <div class=container id=container>
        <div class="form-container sign-up">
            <form method="POST" action="index.php">
                <h1>Create Account</h1>
                <input type="text" name="first_name" placeholder="First Name" required value="<?php echo isset($_SESSION['form_data']['first_name']) ? htmlspecialchars($_SESSION['form_data']['first_name']) : ''; ?>">
                
                <input type="text" name="username" placeholder="User Name" required value="<?php echo isset($_SESSION['form_data']['username']) ? htmlspecialchars($_SESSION['form_data']['username']) : ''; ?>">
                
                <input type="email" name="email" placeholder="Email" required value="<?php echo isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : ''; ?>">

                <div class="input-pass">
                    <input type="password" name="password" id="password_up" placeholder="Password" required">
                    <button type="button" onclick="togglePasswordVisibilitySignUp()" class="eye" id="eye_up">
                        <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                    </button>
                </div>
                <button type="submit" name="signup">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in">
        <form method="POST" action="index.php">
            <h1>Sign In</h1>
                <input type="email" name="email" placeholder="Email" required>

                <div class="input-pass">
                    <input type="password" name="password" id="password_in" placeholder="Password" required>
                    <button type="button" onclick="togglePasswordVisibilitySignIn()" class="eye" id="eye_in">
                        <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                    </button>
                </div>

                <button type="submit" name="signin">Sign In</button>
            </form>
        </div>

        <!-- En el HTML, para mostrar el mensaje de error -->
        <?php if (isset($_SESSION['error'])): ?>
            <div id="error-message"><?php echo $_SESSION['error']; ?></div>
            <?php unset($_SESSION['error']); // Importante: borrar el mensaje después de mostrarlo ?>
        <?php endif; ?>

        <!-- En el HTML, para mostrar el mensaje de que el registro ha salido bien -->
        <?php if (isset($_SESSION['success'])): ?>
            <div id="success-message"><?php echo $_SESSION['success']; ?></div>
            <?php unset($_SESSION['success']); // Importante: borrar el mensaje después de mostrarlo ?>
        <?php endif; ?>


        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="./index/scripts.js"></script>
</body>

</html>