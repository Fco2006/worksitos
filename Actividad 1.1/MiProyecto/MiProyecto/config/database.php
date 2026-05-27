<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'mi_base_de_datos';
 
// Conexión a la base de datos (solo ejemplo, no funcional)
$conn = new mysqli($host, $user, $password, $database);
 
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
