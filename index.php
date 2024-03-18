<?php
// Inicia la sesión PHP para poder redireccionar al usuario tras el inicio de sesión exitoso
session_start();

include './assets/reusable/bd.php';

// Verifica si se envió el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signin'])) {
    $email = $_POST['email'];
    $password = $_POST['password']; // Considera hashear la contraseña

    $sql = "SELECT user_id FROM users WHERE email_address = '$email' AND password = '$password'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        // Inicio de sesión exitoso, redirecciona a master.php
        $_SESSION['user'] = $email; // Guarda el email en la sesión
        header("Location: master.php");
        exit();
    } else {
        $_SESSION['error'] = "Usuario o contraseña incorrecta";
        header('Location: index.php'); // Redireccionamiento aquí
        exit();
    }
}

// Verifica si se envió el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $validUsername = "SELECT user_id FROM users WHERE user_handle = '$username'";
    $resultUsername = $db->query($validUsername);

    $validEmail = "SELECT user_id FROM users WHERE email_address = '$email'";
    $resultEmail = $db->query($validEmail);

    if ($resultUsername->num_rows > 0 || $resultEmail->num_rows > 0) {
        if ($resultUsername->num_rows > 0) {
            $_SESSION['error'] = "Username is already in use. Try another one";
        } else {
            $_SESSION['error'] = "Email is already in use. Try another one";
        }
        // Guardar otros campos en la sesión
        $_SESSION['form_data'] = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            // No guardar 'username' si es el que tiene error
            'email' => $resultEmail->num_rows > 0 ? '' : $email,
            // No guardar 'email' si es el que tiene error
            'username' => $resultUsername->num_rows > 0 ? '' : $username,
        ];
    }
    else {
        $sql = "INSERT INTO usuarios (user_handle, email_address, first_name, last_name, password) VALUES ('$username', '$first_name', '$last_name', '$email', '$password')";
        if ($db->query($sql) === TRUE) {
            $_SESSION['success'] = "Successful registration. Sign in now.";
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
    <link rel="icon" href="./assets/images/b.svg" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/index.css">
    <title>Blym</title>
</head>

<body>
    <p class="title">BLYM</p>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form method="POST" action="index.php">
                <h1>Create Account</h1>
                <input type="text" name="first_name" placeholder="First Name" required value="<?php echo isset($_SESSION['form_data']['first_name']) ? htmlspecialchars($_SESSION['form_data']['first_name']) : ''; ?>">
                
                <input type="text" name="last_name" placeholder="Last Name" required value="<?php echo isset($_SESSION['form_data']['last_name']) ? htmlspecialchars($_SESSION['form_data']['last_name']) : ''; ?>">
                
                <input type="text" name="username" placeholder="User Name" required value="<?php echo isset($_SESSION['form_data']['username']) ? htmlspecialchars($_SESSION['form_data']['username']) : ''; ?>">
                
                <input type="email" name="email" placeholder="Email" required value="<?php echo isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : ''; ?>">

                <div style="position: relative;">
                    <input type="password" name="password" id="password" placeholder="Password" required">
                    <button type="button" onclick="togglePasswordVisibility()" style="position: absolute; right: 0; top: 0; padding: 10px; cursor: pointer;">👁️</button>
                </div>
                <button type="submit" name="signup">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in">
        <form method="POST" action="index.php">
            <h1>Sign In</h1>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
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

    <script src="./assets/js/index.js"></script>
</body>

</html>