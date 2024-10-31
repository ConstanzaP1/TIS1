function obtenerNotificaciones() {
    fetch('/api/obtener_notificaciones.php')
        .then(response => response.json())
        .then(notificaciones => {
            const container = document.getElementById('notificaciones-container');
            container.innerHTML = '';
            notificaciones.forEach(notificacion => {
                const elemento = document.createElement('div');
                elemento.classList.add('notificacion', notificacion.tipo);
                elemento.textContent = notificacion.mensaje;
                container.appendChild(elemento);
            });
        });
}

// Actualizar notificaciones cada 30 segundos
setInterval(obtenerNotificaciones, 30000);