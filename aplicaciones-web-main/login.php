<?php
session_start();

// Si ya inició sesión, lo mandamos al inicio
if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

include 'conexion.php';

$error = '';
$usuario = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $clave   = $_POST['contrasena'] ?? '';

    // 1. Buscar al usuario con consulta preparada
    $conn = Conectar();
    $stmt = mysqli_prepare($conn,
        "SELECT usuario, password_hash, rol FROM usuarios WHERE usuario = ?");
    mysqli_stmt_bind_param($stmt, "s", $usuario);
    mysqli_stmt_execute($stmt);
    $fila = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // 2. Comparar la contraseña con el hash guardado
    if ($fila && password_verify($clave, $fila['password_hash'])) {
        session_regenerate_id(true);           // Nuevo ID de sesión por seguridad
        $_SESSION['usuario'] = $fila['usuario'];
        $_SESSION['rol']     = $fila['rol'];
        header('Location: index.php');
        exit();
    }

    // Mensaje genérico: no decimos si fue el usuario o la contraseña
    $error = 'Usuario o contraseña incorrectos.';
}

$titulo = 'Login';
$css = 'css/login.css';
include 'header.php';
?>

<h1 class="text-center mb-4">Iniciar sesión</h1>

<?php if ($error): ?>
    <div class="alert alert-danger col-md-6 mx-auto"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form action="login.php" method="post" class="col-md-6 mx-auto">
    <div class="mb-3">
        <label for="usuario" class="form-label">Nombre de usuario</label>
        <input type="text" id="usuario" name="usuario" class="form-control"
               value="<?= htmlspecialchars($usuario) ?>" required>
    </div>

    <div class="mb-3">
        <label for="contrasena" class="form-label">Contraseña</label>
        <input type="password" id="contrasena" name="contrasena" class="form-control" required>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-dark">Entrar</button>
    </div>
</form>

<p class="text-center mt-3">¿No tienes cuenta? <a href="registro.php">Créala aquí</a></p>

<?php include 'footer.php'; ?>