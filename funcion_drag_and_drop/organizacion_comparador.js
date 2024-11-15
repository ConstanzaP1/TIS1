function allowDrop(event) {
    event.preventDefault();
}

function drag(event) {
    event.dataTransfer.setData("text", event.target.dataset.id);
}

function drop(event) {
    event.preventDefault();
    const productId = event.dataTransfer.getData("text");
    const productElement = document.querySelector(`.product-item[data-id="${productId}"]`).cloneNode(true);
    productElement.removeAttribute("draggable");

    // Limpiar el contenido de la caja de comparación antes de agregar el nuevo producto
    event.target.innerHTML = "";
    event.target.appendChild(productElement);

    // Puedes agregar más código aquí para mostrar especificaciones adicionales
}
