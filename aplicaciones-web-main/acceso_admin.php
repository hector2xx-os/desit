<?php
session_start();

// Si no es admin, lo mandamos al login antes de mostrar nada
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit();
}