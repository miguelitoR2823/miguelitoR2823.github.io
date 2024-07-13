const productos = [
    { 
        nombre: "Polos 30/1",
        precio: 4.8,
        categoria: "Polos Publicitarios",
        imagen: "images/PolosPublicitarios_Productos_polos301.png"
    },
    { 
        nombre: "Polos 20/1",
        precio: 5.5,
        categoria: "Polos Publicitarios",
        imagen: "images/PolosPublicitarios_Productos_polos201.png"
    },
    { 
        nombre: "Polos Polycotton",
        precio: 4.5,
        categoria: "Polos Publicitarios",
        imagen: "images/PolosPublicitarios_Productos_poloscotton.png"
    }
];

function filterProductsByCategory(products, category) {
    return products.filter(product => product.categoria === category);
}

function sortProductsByPrice(products, order = 'asc') {
    return products.sort((a, b) => {
        if (order === 'asc') {
            return a.precio - b.precio;
        } else {
            return b.precio - a.precio;
        }
    });
}

function searchProductsByName(products, query) {
    return products.filter(product => product.nombre.toLowerCase().includes(query.toLowerCase()));
}
