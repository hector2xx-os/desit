<?php
include 'acceso_admin.php';
include 'conexion.php';

$conn = Conectar();

// Procesar la acción del botón (aprobar o rechazar)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id     = (int) ($_POST['id'] ?? 0);
    $accion = $_POST['accion'] ?? '';

    if ($id > 0 && $accion === 'aprobar') {
        $stmt = mysqli_prepare($conn,
            "UPDATE testimonios SET estado = 'aprobado' WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

    } elseif ($id > 0 && $accion === 'rechazar') {
        // Buscamos la foto para borrar el archivo también
        $stmt = mysqli_prepare($conn, "SELECT foto FROM testimonios WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $fila = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        mysqli_stmt_close($stmt);

        $stmt = mysqli_prepare($conn, "DELETE FROM testimonios WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if ($fila) {
            @unlink($fila['foto']); // @ oculta el aviso si el archivo ya no existe
        }
    }

    mysqli_close($conn);
    header('Location: admin_testimonios.php');
    exit();
}

// Testimonios pendientes, del más antiguo al más reciente
$resultado = mysqli_query($conn,
    "SELECT t.id, t.texto, t.tipo_evento, t.foto, t.creado_en, u.usuario
     FROM testimonios t
     INNER JOIN usuarios u ON u.id = t.usuario_id
     WHERE t.estado = 'pendiente'
     ORDER BY t.creado_en ASC");
$pendientes = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
mysqli_close($conn);

$titulo = 'Admin · Testimonios';
$css = 'css/admin_testimonios.css';
include 'header.php';
?>

<h1 class="text-center mb-4">Testimonios pendientes</h1>

<?php if (empty($pendientes)): ?>
    <p class="text-center text-muted">No hay testimonios pendientes de revisar.</p>
<?php else: ?>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Usuario</th>
                    <th>Evento</th>
                    <th>Testimonio</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pendientes as $t): ?>
                    <tr>
                        <td><img src="<?= htmlspecialchars($t['foto']) ?>" width="100" class="rounded"></td>
                        <td><?= htmlspecialchars($t['usuario']) ?></td>
                        <td><?= htmlspecialchars($t['tipo_evento']) ?></td>
                        <td><?= nl2br(htmlspecialchars($t['texto'])) ?></td>
                        <td><?= date('d/m/Y', strtotime($t['creado_en'])) ?></td>
                        <td>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="id" value="<?= $t['id'] ?>">
                                <button type="submit" name="accion" value="aprobar"
                                        class="btn btn-success btn-sm">Aprobar</button>
                                <button type="submit" name="accion" value="rechazar"
                                        class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('¿Rechazar este testimonio?')">Rechazar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>