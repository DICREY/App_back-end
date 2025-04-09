<?php
// Configuración de conexión
$host = "localhost";
$user = "root";
$password = "";
$database = "app_vet";
$port = 3306;

// Crear conexión
$connection = new mysqli($host, $user, $password, $database, $port);

// Verificar conexión
if ($connection->connect_error) {
    die("Error de conexión: " . $connection->connect_error);
}

?>