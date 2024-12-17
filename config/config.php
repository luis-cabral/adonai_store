<?php
// Conexión a la base de datos
$host = "localhost";
$user = "adonaiStore";
$password = "postgres";
$dbname = "adonai_store_schema";
$pepper = 'c1isvFdxMDdmjOlvxpecFw';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>