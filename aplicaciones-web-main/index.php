<?php
$titulo = 'Inicio';
$css = 'css/index.css';
include 'header.php';
?>

<div class="text-center py-4">
    <h1 class="display-5 fw-bold">Capturamos tus momentos más importantes</h1>
    <p class="lead text-muted">
        Bodas, XV años, retratos y eventos corporativos, con un estilo cuidado y un trato cercano.
    </p>
    <a href="cotizaciones.php" class="btn btn-dark btn-lg me-2 mb-2">Ver cotizaciones</a>
    <a href="reservar.php" class="btn btn-outline-dark btn-lg mb-2">Reservar una sesión</a>
</div>

<img src="fotos/imgtrabajo1.jpeg" class="img-fluid rounded w-100 mb-5"
     style="max-height: 400px; object-fit: cover;" alt="Trabajo destacado del estudio">

<div class="row g-4 text-center">
    <div class="col-md-4">
        <div class="card card-body h-100">
            <h2 class="h5">Bodas</h2>
            <p class="mb-0">Cobertura de tu día especial, desde la preparación hasta la fiesta.</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-body h-100">
            <h2 class="h5">XV años</h2>
            <p class="mb-0">Sesiones con estilo para celebrar a la protagonista de la noche.</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-body h-100">
            <h2 class="h5">Retratos</h2>
            <p class="mb-0">Fotografías personales y familiares, con luz natural y buen ambiente.</p>
        </div>
    </div>
</div>

<div class="text-center mt-5">
    <p class="mb-2">¿Quieres saber lo que dicen nuestros clientes?</p>
    <a href="comunidad.php" class="btn btn-link">Ver la comunidad</a>
</div>

<?php include 'footer.php'; ?>