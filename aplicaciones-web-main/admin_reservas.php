<?php
include 'acceso_admin.php';
include 'conexion.php';

$conn = Conectar();
$resultado = mysqli_query($conn,
    "SELECT nombre, email, telefono, fecha, paquete, mensaje, creada_en
     FROM reservas
     ORDER BY fecha ASC");
$reservas = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
mysqli_close($conn);

$titulo = 'Admin · Reservas';
$css = 'css/admin_reservas.css';
include 'header.php';
?>

<h1 class="text-center mb-4">Reservas</h1>

<?php if (empty($reservas)): ?>
    <p class="text-center text-muted">Todavía no hay reservas.</p>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Fecha de sesión</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Paquete</th>
                    <th>Comentarios</th>
                    <th>Registrada</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservas as $r): ?>
                    <tr>
                        <td><?= date('d/m/Y', strtotime($r['fecha'])) ?></td>
                        <td><?= htmlspecialchars($r['nombre']) ?></td>
                        <td><?= htmlspecialchars($r['email']) ?></td>
                        <td><?= htmlspecialchars($r['telefono']) ?></td>
                        <td><?= htmlspecialchars($r['paquete']) ?></td>
                        <td><?= nl2br(htmlspecialchars($r['mensaje'])) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($r['creada_en'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>