<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$titulo = $titulo ?? 'Estudio Fotográfico';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $titulo ?> | Estudio Fotográfico</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= htmlspecialchars($css ?? 'css/index.css') ?>" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Estudio Fotográfico</a>
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="nosotros.php">Quiénes somos</a></li>
                <li class="nav-item"><a class="nav-link" href="galeria.php">Trabajos</a></li>
                <li class="nav-item"><a class="nav-link" href="cotizaciones.php">Cotizaciones</a></li>
                <li class="nav-item"><a class="nav-link" href="reservar.php">Reservar</a></li>
                <li class="nav-item"><a class="nav-link" href="comunidad.php">Comunidad</a></li>
                <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
                <li class="nav-item"><a class="nav-link" href="terminos.php">Términos</a></li>

                <?php if (isset($_SESSION['usuario'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Cerrar sesión (<?= htmlspecialchars($_SESSION['usuario']) ?>)</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="registro.php">Crear cuenta</a></li>
                <?php endif; ?>

                <?php if (($_SESSION['rol'] ?? '') === 'admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="admin_testimonios.php">Testimonios</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_reservas.php">Reservas</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container principal">