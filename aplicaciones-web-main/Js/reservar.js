document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formReserva');
    const aviso = document.getElementById('avisoJSReserva');
    if (!form) return;

    form.addEventListener('submit', function (evento) {
        const nombre  = form.nombre.value.trim();
        const email   = form.email.value.trim();
        const fecha   = form.fecha.value;
        const paquete = form.paquete.value;
        const hoy     = new Date().toISOString().slice(0, 10); // formato AAAA-MM-DD
        const errores = [];

        if (nombre.length < 3) {
            errores.push('El nombre debe tener al menos 3 caracteres.');
        }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            errores.push('El correo no tiene un formato válido.');
        }
        if (!fecha || fecha < hoy) {
            errores.push('La fecha debe ser hoy o una fecha posterior.');
        }
        if (paquete === '') {
            errores.push('Selecciona un paquete.');
        }

        if (errores.length > 0) {
            evento.preventDefault();
            aviso.textContent = errores.join(' ');
            aviso.classList.remove('d-none');
        }
    });
});