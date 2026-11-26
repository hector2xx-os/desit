<?php
$titulo = 'Contáctanos';
$css = 'css/contacto.css';

// Valores por defecto
$nombre  = '';
$correo  = '';
$mensaje = '';
$errores = [];
$enviado = false;

// Solo validamos cuando el formulario se envía (método POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre  = trim($_POST['nombre'] ?? '');
    $correo  = trim($_POST['correo'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');

    if (strlen($nombre) < 3) {
        $errores[] = 'El nombre debe tener al menos 3 caracteres.';
    }
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = 'El correo no tiene un formato válido.';
    }
    if (strlen($mensaje) < 10) {
        $errores[] = 'El mensaje debe tener al menos 10 caracteres.';
    }

    if (empty($errores)) {
        // Por ahora solo confirmamos. Más adelante podemos guardarlo en la base de datos.
        $enviado = true;
        $nombre = $correo = $mensaje = '';
    }
}

$scripts = '<script src="js/validacion.js"></script>';
include 'header.php';
?>

<h1 class="text-center mb-4">Contáctanos</h1>

<?php if ($enviado): ?>
    <div class="alert alert-success">Gracias por escribirnos. Te responderemos pronto.</div>
<?php endif; ?>

<?php if (!empty($errores)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errores as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Aviso que muestra JavaScript antes de enviar -->
<div id="avisoJS" class="alert alert-danger d-none"></div>

<form id="formContacto" action="contacto.php" method="post" class="col-md-8 mx-auto">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" id="nombre" name="nombre" class="form-control"
               value="<?= htmlspecialchars($nombre) ?>">
    </div>

    <div class="mb-3">
        <label for="correo" class="form-label">Correo electrónico</label>
        <input type="email" id="correo" name="correo" class="form-control"
               value="<?= htmlspecialchars($correo) ?>">
    </div>

    <div class="mb-3">
        <label for="mensaje" class="form-label">Mensaje</label>
        <textarea id="mensaje" name="mensaje" rows="5" class="form-control"><?= htmlspecialchars($mensaje) ?></textarea>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-dark">Enviar</button>
    </div>
</form>

<?php include 'footer.php'; ?>