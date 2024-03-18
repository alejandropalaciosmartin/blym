<?php
// Inicia la sesión PHP para poder redireccionar al usuario tras el inicio de sesión exitoso
session_start();

include './reusable/bd.php';

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
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Considera hashear la contraseña

    $sql = "INSERT INTO usuarios (name, email, password) VALUES ('$name', '$email', '$password')";
    if ($db->query($sql) === TRUE) {
        $success = "Registro exitoso. Ahora puedes iniciar sesión.";
    } else {
        $error = "Error al registrar: " . $db->error;
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
                <input type="text" name="name" placeholder="Name" required autofocus>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
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