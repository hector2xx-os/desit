<?php
session_start();
include 'conexion.php';

$tipos = ['Boda', 'XV años', 'Retrato', 'Corporativo', 'Otro'];
$error = '';
$conn = Conectar();

// Procesar un testimonio nuevo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo  = $_POST['tipo_evento'] ?? '';
    $texto = trim($_POST['texto'] ?? '');
    $foto  = $_FILES['foto'] ?? null;

    if (!isset($_SESSION['id'])) {
        $error = 'Debes iniciar sesión para enviar un testimonio.';
    } elseif (!in_array($tipo, $tipos, true)) {
        $error = 'Selecciona un tipo de evento válido.';
    } elseif (strlen($texto) < 20 || strlen($texto) > 500) {
        $error = 'El testimonio debe tener entre 20 y 500 caracteres.';
    } elseif (!$foto || $foto['error'] !== UPLOAD_ERR_OK) {
        $error = 'Debes subir una foto.';
    } elseif ($foto['size'] > 2 * 1024 * 1024) {
        $error = 'La foto no puede pesar más de 2 MB.';
    } else {
        // Revisar que el archivo sea realmente una imagen JPG o PNG
        $info = getimagesize($foto['tmp_name']);
        $extensiones = ['image/jpeg' => 'jpg', 'image/png' => 'png'];

        if ($info === false || !isset($extensiones[$info['mime']])) {
            $error = 'La foto debe ser JPG o PNG.';
        } else {
            // Nombre aleatorio: no usamos el nombre original que trae el archivo
            $nombreArchivo = bin2hex(random_bytes(8)) . '.' . $extensiones[$info['mime']];
            $destino = 'fotos/comunidad/' . $nombreArchivo;

            if (move_uploaded_file($foto['tmp_name'], $destino)) {
                $stmt = mysqli_prepare($conn,
                    "INSERT INTO testimonios (usuario_id, tipo_evento, texto, foto)
                     VALUES (?, ?, ?, ?)");
                mysqli_stmt_bind_param($stmt, "isss",
                    $_SESSION['id'], $tipo, $texto, $destino);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                mysqli_close($conn);

                header('Location: comunidad.php?ok=1');
                exit();
            }
            $error = 'No se pudo guardar la foto. Intenta de nuevo.';
        }
    }
}

// Solo mostramos los testimonios aprobados por el admin
$resultado = mysqli_query($conn,
    "SELECT t.texto, t.tipo_evento, t.foto, u.usuario
     FROM testimonios t
     INNER JOIN usuarios u ON u.id = t.usuario_id
     WHERE t.estado = 'aprobado'
     ORDER BY t.creado_en DESC");
$testimonios = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
mysqli_close($conn);

$titulo = 'Comunidad';
$css = 'css/comunidad.css';
include 'header.php';
?>

<h1 class="text-center mb-2">Comunidad</h1>
<p class="text-center text-muted mb-4">Momentos y recomendaciones de nuestros clientes.</p>

<?php if (isset($_GET['ok'])): ?>
    <div class="alert alert-success col-md-8 mx-auto">
        Gracias por compartir tu testimonio. Lo publicaremos cuando sea aprobado.
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-danger col-md-8 mx-auto"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['usuario'])): ?>
    <!-- enctype es obligatorio para poder subir archivos -->
    <form action="comunidad.php" method="post" enctype="multipart/form-data"
          class="card card-body col-md-8 mx-auto mb-5">
        <h2 class="h5">Comparte tu experiencia</h2>

        <div class="mb-3">
            <label for="tipo_evento" class="form-label">Tipo de evento</label>
            <select id="tipo_evento" name="tipo_evento" class="form-select" required>
                <option value="">Selecciona uno</option>
                <?php foreach ($tipos as $t): ?>
                    <option value="<?= $t ?>"><?= $t ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="texto" class="form-label">Tu testimonio</label>
            <textarea id="texto" name="texto" rows="3" class="form-control"
                      maxlength="500" required></textarea>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto de tu evento (JPG o PNG, máximo 2 MB)</label>
            <input type="file" id="foto" name="foto" class="form-control"
                   accept="image/jpeg,image/png" required>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-dark">Enviar testimonio</button>
        </div>
    </form>
<?php else: ?>
    <p class="text-center mb-5">
        Para compartir tu experiencia, <a href="login.php">inicia sesión</a>.
    </p>
<?php endif; ?>

<?php if (empty($testimonios)): ?>
    <p class="text-center text-muted">Pronto verás aquí los testimonios de nuestros clientes.</p>
<?php endif; ?>

<div class="row g-4">
    <?php foreach ($testimonios as $t): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <img src="<?= htmlspecialchars($t['foto']) ?>" class="card-img-top"
                     style="height: 250px; object-fit: cover;"
                     alt="Evento de <?= htmlspecialchars($t['tipo_evento']) ?>">
                <div class="card-body">
                    <span class="badge bg-dark mb-2"><?= htmlspecialchars($t['tipo_evento']) ?></span>
                    <p class="card-text"><?= nl2br(htmlspecialchars($t['texto'])) ?></p>
                </div>
                <div class="card-footer text-muted small">
                    — <?= htmlspecialchars($t['usuario']) ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include 'footer.php'; ?>