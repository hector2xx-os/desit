<?php
$titulo = 'Trabajos previos';
$css = 'css/galeria.css';
include 'header.php';

// Lista de trabajos: arma la ruta de imgtrabajo1.jpeg a imgtrabajo8.jpeg
$trabajos = [];
for ($i = 1; $i <= 8; $i++) {
    $trabajos[] = [
        'archivo' => "fotos/imgtrabajo$i.jpeg",
        'texto'   => "Trabajo $i",
    ];
}
?>

<h1 class="text-center mb-4">Trabajos previos</h1>

<div id="carruselTrabajos" class="carousel slide" data-bs-ride="carousel">

    <!-- Puntos de navegación: uno por foto -->
    <div class="carousel-indicators">
        <?php foreach ($trabajos as $n => $t): ?>
            <button type="button" data-bs-target="#carruselTrabajos"
                    data-bs-slide-to="<?= $n ?>"
                    class="<?= $n === 0 ? 'active' : '' ?>"></button>
        <?php endforeach; ?>
    </div>

    <!-- Las diapositivas -->
    <div class="carousel-inner rounded">
        <?php foreach ($trabajos as $n => $t): ?>
            <div class="carousel-item <?= $n === 0 ? 'active' : '' ?>">
                <img src="<?= $t['archivo'] ?>" class="d-block w-100"
                style="height: 500px; object-fit: cover;"
                    alt="<?= $t['texto'] ?>">
                <div class="carousel-caption d-none d-md-block">
                    <h5><?= $t['texto'] ?></h5>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Flechas -->
    <button class="carousel-control-prev" type="button"
            data-bs-target="#carruselTrabajos" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button"
            data-bs-target="#carruselTrabajos" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        <span class="visually-hidden">Siguiente</span>
    </button>
</div>

<?php include 'footer.php'; ?>