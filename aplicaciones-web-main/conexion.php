<?php
function Conectar() {
    $conn = mysqli_connect('localhost', 'root', '', 'estudio_fotografico');
    if (!$conn) {
        die('Error de conexión: ' . mysqli_connect_error());
    }
    mysqli_set_charset($conn, 'utf8mb4');
    return $conn;
}