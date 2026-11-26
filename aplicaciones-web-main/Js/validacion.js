document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formContacto');
    const aviso = document.getElementById('avisoJS');
    if (!form) return;

    form.addEventListener('submit', function (evento) {
        const nombre  = form.nombre.value.trim();
        const correo  = form.correo.value.trim();
        const mensaje = form.mensaje.value.trim();
        const errores = [];

        if (nombre.length < 3) {
            errores.push('El nombre debe tener al menos 3 caracteres.');
        }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo)) {
            errores.push('El correo no tiene un formato válido.');
        }
        if (mensaje.length < 10) {
            errores.push('El mensaje debe tener al menos 10 caracteres.');
        }

        if (errores.length > 0) {
            evento.preventDefault();          // Evita que el formulario se envíe
            aviso.textContent = errores.join(' ');
            aviso.classList.remove('d-none');  // Muestra el aviso
        }
    });
});