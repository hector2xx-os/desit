<?php
$titulo = 'Cotizaciones';
$css = 'css/cotizaciones.css';

// Única fuente de los precios del sitio
$paquetes = [
    ['nombre' => 'Básico',      'precio' => 1500, 'descripcion' => '1 hora de sesión y 10 fotos digitales.'],
    ['nombre' => 'Premium',     'precio' => 3000, 'descripcion' => '3 horas de sesión y 30 fotos digitales.'],
    ['nombre' => 'Boda',        'precio' => 8000, 'descripcion' => '6 horas de cobertura y 300 fotos editadas.'],
    ['nombre' => 'XV años',     'precio' => 6000, 'descripcion' => '4 horas de sesión y 150 fotos editadas.'],
    ['nombre' => 'Corporativo', 'precio' => 4500, 'descripcion' => '3 horas de evento y 100 fotos editadas.'],
];

$scripts = '<script src="js/cotizaciones.js"></script>';
include 'header.php';
?>

<h1 class="text-center mb-4">Paquetes y cotizaciones</h1>

<!-- Tarjetas de paquetes -->
<div class="row g-4 mb-5">
    <?php foreach ($paquetes as $p): ?>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h2 class="h4"><?= htmlspecialchars($p['nombre']) ?></h2>
                    <p class="text-muted"><?= htmlspecialchars($p['descripcion']) ?></p>
                    <p class="fs-4 fw-bold">$<?= number_format($p['precio'], 2) ?></p>
                    <a href="reservar.php" class="btn btn-outline-dark btn-sm">Reservar</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Calculadora -->
<h2 class="h4 text-center mb-3">Calcula tu cotización</h2>
<div class="card card-body col-md-6 mx-auto">

    <div class="mb-3">
        <label for="paqueteCot" class="form-label">Paquete</label>
        <select id="paqueteCot" class="form-select">
            <option value="0">Selecciona un paquete</option>
            <?php foreach ($paquetes as $p): ?>
                <option value="<?= $p['precio'] ?>"><?= htmlspecialchars($p['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="horas" class="form-label">Horas extra (cada una $500)</label>
        <input type="number" id="horas" class="form-control" min="0" max="10" value="0">
    </div>

    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="album" value="1200">
        <label class="form-check-label" for="album">Álbum impreso (+$1,200)</label>
    </div>

    <div class="border-top pt-3">
        <p class="mb-1">Subtotal: <span id="subtotal">$0.00</span></p>
        <p class="mb-1">IVA (16%): <span id="iva">$0.00</span></p>
        <p class="fs-5 fw-bold mb-0">Total: <span id="total">$0.00</span></p>
    </div>
</div>

<?php include 'footer.php'; ?>