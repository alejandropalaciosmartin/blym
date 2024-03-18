<?php

// Variables para la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blym";

// Intenta conectar a la base de datos
$db = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}