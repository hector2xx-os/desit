<?php
include 'conexion.php';

$titulo = 'Reservar';
$css = 'css/reservar.css';
$paquetes = ['Básico', 'Premium', 'Boda', 'XV años', 'Corporativo'];

// Valores por defecto
$nombre = $email = $telefono = $fecha = $paquete = $mensaje = '';
$errores = [];
$exito = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = trim($_POST['nombre'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $fecha    = $_POST['fecha'] ?? '';
    $paquete  = $_POST['paquete'] ?? '';
    $mensaje  = trim($_POST['mensaje'] ?? '');

    if (strlen($nombre) < 3) {
        $errores[] = 'El nombre debe tener al menos 3 caracteres.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = 'El correo no tiene un formato válido.';
    }
    if ($telefono !== '' && !preg_match('/^[0-9 +()-]{8,20}$/', $telefono)) {
        $errores[] = 'El teléfono solo puede tener números y los símbolos + ( ) -.';
    }
    $fechaValida = DateTime::createFromFormat('Y-m-d', $fecha);
    if (!$fechaValida || $fecha < date('Y-m-d')) {
        $errores[] = 'La fecha debe ser hoy o una fecha posterior.';
    }
    if (!in_array($paquete, $paquetes, true)) {
        $errores[] = 'Selecciona un paquete válido.';
    }

    if (empty($errores)) {
        $conn = Conectar();
        $stmt = mysqli_prepare($conn,
            "INSERT INTO reservas (nombre, email, telefono, fecha, paquete, mensaje)
             VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssssss",
            $nombre, $email, $telefono, $fecha, $paquete, $mensaje);

        if (mysqli_stmt_execute($stmt)) {
            $exito = true;
            $nombre = $email = $telefono = $fecha = $paquete = $mensaje = '';
        } else {
            $errores[] = 'No se pudo guardar la reserva. Intenta de nuevo.';
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}

$scripts = '<script src="js/reservar.js"></script>';
include 'header.php';
?>

<h1 class="text-center mb-4">Reservar sesión</h1>

<?php if ($exito): ?>
    <div class="alert alert-success">Tu reservación se registró. Te contactaremos para confirmarla.</div>
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

<div id="avisoJSReserva" class="alert alert-danger d-none"></div>

<form id="formReserva" action="reservar.php" method="post" class="col-md-8 mx-auto">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" id="nombre" name="nombre" class="form-control"
               value="<?= htmlspecialchars($nombre) ?>">
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email" id="email" name="email" class="form-control"
               value="<?= htmlspecialchars($email) ?>">
    </div>

    <div class="mb-3">
        <label for="telefono" class="form-label">Teléfono (opcional)</label>
        <input type="tel" id="telefono" name="telefono" class="form-control"
               value="<?= htmlspecialchars($telefono) ?>">
    </div>

    <div class="mb-3">
        <label for="fecha" class="form-label">Fecha de la sesión</label>
        <input type="date" id="fecha" name="fecha" class="form-control"
               min="<?= date('Y-m-d') ?>" value="<?= htmlspecialchars($fecha) ?>">
    </div>

    <div class="mb-3">
        <label for="paquete" class="form-label">Paquete</label>
        <select id="paquete" name="paquete" class="form-select">
            <option value="">Selecciona un paquete</option>
            <?php foreach ($paquetes as $p): ?>
                <option value="<?= $p ?>" <?= $paquete === $p ? 'selected' : '' ?>>
                    <?= $p ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="mensaje" class="form-label">Comentarios adicionales</label>
        <textarea id="mensaje" name="mensaje" rows="4" class="form-control"><?= htmlspecialchars($mensaje) ?></textarea>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-dark">Reservar</button>
    </div>
</form>

<?php include 'footer.php'; ?>