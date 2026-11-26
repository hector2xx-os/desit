document.addEventListener('DOMContentLoaded', function () {
    const selectPaquete = document.getElementById('paqueteCot');
    const inputHoras    = document.getElementById('horas');
    const checkAlbum    = document.getElementById('album');
    if (!selectPaquete) return;

    const precioHoraExtra = 500;
    const tasaIva = 0.16;

    // Da formato de moneda mexicana: $1,500.00
    function formato(numero) {
        return '$' + numero.toLocaleString('es-MX', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function calcular() {
        const base    = parseFloat(selectPaquete.value) || 0;
        const horas   = Math.max(0, parseInt(inputHoras.value, 10) || 0);
        const extra   = horas * precioHoraExtra;
        const album   = checkAlbum.checked ? parseFloat(checkAlbum.value) : 0;

        const subtotal = base + extra + album;
        const iva      = subtotal * tasaIva;

        document.getElementById('subtotal').textContent = formato(subtotal);
        document.getElementById('iva').textContent      = formato(iva);
        document.getElementById('total').textContent    = formato(subtotal + iva);
    }

    // Recalcula cada vez que el usuario cambia algo
    selectPaquete.addEventListener('change', calcular);
    inputHoras.addEventListener('input', calcular);
    checkAlbum.addEventListener('change', calcular);

    calcular(); // Muestra los valores iniciales
});