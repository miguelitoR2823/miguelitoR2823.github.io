const products = [
    {
        nombre: "Blazer",
        precio: 9,
        categoria: "Casacas",
        imagen: "images/Casacas_Productos_blazer.png"
    },
    {
        nombre: "Publicitaria",
        precio: 8,
        categoria: "Casacas",
        imagen: "images/Casacas_Productos_publi.png"
    }
];

function renderProducts(products) {
    const productContainer = document.getElementById('product-container');
    productContainer.innerHTML = '';
    products.forEach(product => {
        const card = document.createElement('div');
        card.classList.add('card-2');
        card.innerHTML = `
            <img src="${product.imagen}" alt="" class="card-2-image">
            <h1 class="card-2-title">${product.nombre}</h1>
            <h2 class="card-2-price">
                <div class="card-2-price-item">Precio:</div>
                <div class="card-2-price-item">S/. ${product.precio}</div>
            </h2>
        `;
        productContainer.appendChild(card);
    });
}

function filterByCategory() {
    const categoryFilter = document.getElementById('categoryFilter');
    const selectedCategory = categoryFilter.value;
    const filteredProducts = products.filter(product => product.categoria === selectedCategory);
    renderProducts(filteredProducts);
}

function sortProductsByPrice(order) {
    const sortedProducts = [...products];
    if (order === 'asc') {
        sortedProducts.sort((a, b) => a.precio - b.precio);
    } else if (order === 'desc') {
        sortedProducts.sort((a, b) => b.precio - a.precio);
    }
    renderProducts(sortedProducts);
}

function searchProducts() {
    const searchQuery = document.getElementById('searchQuery').value.toLowerCase();
    const filteredProducts = products.filter(product => product.nombre.toLowerCase().includes(searchQuery));
    renderProducts(filteredProducts);
}

renderProducts(products);