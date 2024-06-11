<?php

// --- CREDENCIALES BASE DE DATOS EN HOSTINGER ---
// Variables para la conexión a la base de datos
// $servername = "localhost";
// $username = "u484611186_admin";
// $password = "]T2#ab*k0";
// $dbname = "u484611186_blym";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blym";

$db = new mysqli($servername, $username, $password, $dbname);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}