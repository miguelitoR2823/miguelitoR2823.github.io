//JS PARA CONVERTIR NÚMEROS A LETRAS
document.getElementById('convertForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const number = parseInt(document.getElementById('numberInput').value);
    const result = numberToWords(number);

    // Se crea <p> para mostrar el resultado
    const resultElement = document.createElement('p');
    resultElement.textContent = result;

    // Se obtiene el contenedor de resultado y limpiar su contenido anterior
    const resultContainer = document.getElementById('result');
    resultContainer.innerHTML = '';

    // Se agrega <p> con el resultado al contenedor
    resultContainer.appendChild(resultElement);
});

//FUNCIÓN PARA CONVERTIR NÚMEROS A LETRAS
function numberToWords(num) {
    const ones = ['cero', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
    const teens = ['diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve'];
    const tens = ['veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
    const hundreds = ['cien', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'];

    if (num === 0) return ones[0];
    if (num < 10) return ones[num];
    if (num < 20) return teens[num - 10];
    if (num < 100) {
        if (num % 10 === 0) return tens[(num / 10) - 2];
        return `${tens[Math.floor(num / 10) - 2]} y ${ones[num % 10]}`;
    }
    if (num < 1000) {
        if (num % 100 === 0) return hundreds[(num / 100) - 1];
        return `${hundreds[Math.floor(num / 100) - 1]} ${numberToWords(num % 100)}`;
    }
    if (num < 1000000) {
        if (num === 1000) return 'mil';
        if (num < 2000) return `mil ${numberToWords(num % 1000)}`;
        return `${numberToWords(Math.floor(num / 1000))} mil ${num % 1000 !== 0 ? numberToWords(num % 1000) : ''}`;
    }
    return 'Número fuera de rango';
}

