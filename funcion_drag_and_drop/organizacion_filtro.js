function updateFilterOrder() {
    const filters = Array.from(filterContainer.children).map((item) => item.textContent.trim());
    
    fetch('organizacion_filtro.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ filters })
    })
    .then(response => response.json())
    .then(data => console.log('Orden guardado:', data))
    .catch(error => console.error('Error:', error));
}
