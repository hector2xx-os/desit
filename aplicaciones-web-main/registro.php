<?php
session_start();

// Si ya tiene sesión, no necesita registrarse
if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

include 'conexion.php';

$errores = [];
$usuario = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario  = trim($_POST['usuario'] ?? '');
    $clave    = $_POST['contrasena'] ?? '';
    $confirma = $_POST['confirmar'] ?? '';

    if (!preg_match('/^[A-Za-z0-9_]{4,20}$/', $usuario)) {
        $errores[] = 'El usuario debe tener de 4 a 20 letras, números o guion bajo.';
    }
    if (strlen($clave) < 8) {
        $errores[] = 'La contraseña debe tener al menos 8 caracteres.';
    }
    if ($clave !== $confirma) {
        $errores[] = 'Las contraseñas no coinciden.';
    }

    if (empty($errores)) {
        $conn = Conectar();

        // ¿Ya existe ese usuario?
        $stmt = mysqli_prepare($conn, "SELECT id FROM usuarios WHERE usuario = ?");
        mysqli_stmt_bind_param($stmt, "s", $usuario);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $existe = mysqli_stmt_num_rows($stmt) > 0;
        mysqli_stmt_close($stmt);

        if ($existe) {
            $errores[] = 'Ese nombre de usuario ya está en uso.';
        } else {
            $hash = password_hash($clave, PASSWORD_DEFAULT);

            // El rol se fija aquí como 'cliente'; nunca viene del formulario
            $stmt = mysqli_prepare($conn,
                "INSERT INTO usuarios (usuario, password_hash, rol) VALUES (?, ?, 'cliente')");
            mysqli_stmt_bind_param($stmt, "ss", $usuario, $hash);
            mysqli_stmt_execute($stmt);
            $nuevoId = mysqli_insert_id($conn);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);

            // Entra directo a su cuenta
            session_regenerate_id(true);
            $_SESSION['id']      = $nuevoId;
            $_SESSION['usuario'] = $usuario;
            $_SESSION['rol']     = 'cliente';

            header('Location: index.php');
            exit();
        }
        mysqli_close($conn);
    }
}

$titulo = 'Crear cuenta';
$css = 'css/registro.css';
include 'header.php';
?>

<h1 class="text-center mb-4">Crear cuenta</h1>

<?php if (!empty($errores)): ?>
    <div class="alert alert-danger col-md-6 mx-auto">
        <ul class="mb-0">
            <?php foreach ($errores as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="registro.php" method="post" class="col-md-6 mx-auto">
    <div class="mb-3">
        <label for="usuario" class="form-label">Nombre de usuario</label>
        <input type="text" id="usuario" name="usuario" class="form-control"
               value="<?= htmlspecialchars($usuario) ?>" required>
        <div class="form-text">De 4 a 20 letras, números o guion bajo.</div>
    </div>

    <div class="mb-3">
        <label for="contrasena" class="form-label">Contraseña</label>
        <input type="password" id="contrasena" name="contrasena" class="form-control"
               minlength="8" required>
        <div class="form-text">Mínimo 8 caracteres.</div>
    </div>

    <div class="mb-3">
        <label for="confirmar" class="form-label">Confirmar contraseña</label>
        <input type="password" id="confirmar" name="confirmar" class="form-control" required>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-dark">Crear cuenta</button>
    </div>
</form>

<?php include 'footer.php'; ?>