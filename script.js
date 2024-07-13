document.addEventListener('DOMContentLoaded', function() {
    const users = [
        { username: 'user1', password: 'pass1' },
        { username: 'user2', password: 'pass2' },
        { username: 'Nicson', password: 'U22220909' }
    ];

    let attempts = 3;

    const loginForm = document.getElementById('loginForm');
    const messageDiv = document.getElementById('message');

    loginForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        const user = users.find(u => u.username === username && u.password === password);

        if (user) {
            messageDiv.style.color = 'green';
            messageDiv.textContent = 'Login exitoso. Redirigiendo...';
            setTimeout(() => {
                window.location.href = "intranet.html";
            }, 1000); // Da tiempo para mostrar el mensaje antes de redirigir
        } else {
            attempts--;
            if (attempts > 0) {
                messageDiv.style.color = 'red';
                messageDiv.textContent = `Usuario o contraseña incorrectos. Te quedan ${attempts} intentos.`;
            } else {
                messageDiv.style.color = 'red';
                messageDiv.textContent = 'Has agotado todos los intentos. Cerrando la página...';
                setTimeout(() => {
                    window.location.href = "https://www.google.com"; //Redirigir a otra página: "GOOGLE.COM"
                }, 2000);
            }
        }
    });
});

document.getElementById('contactForm').addEventListener('submit', function(event) {
    event.preventDefault();

    let errorMessages = '';

    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const subject = document.getElementById('subject').value;
    const message = document.getElementById('message').value.trim();

    if (name === '') {
        errorMessages += 'El nombre es obligatorio.<br>';
    }

    if (email === '') {
        errorMessages += 'El correo electrónico es obligatorio.<br>';
    } else if (!validateEmail(email)) {
        errorMessages += 'El correo electrónico no es válido.<br>';
    }

    if (subject === '') {
        errorMessages += 'Debe seleccionar un asunto.<br>';
    }

    if (message === '') {
        errorMessages += 'El mensaje es obligatorio.<br>';
    }

    const errorContainer = document.getElementById('errorMessages');
    if (errorMessages !== '') {
        errorContainer.innerHTML = errorMessages;
    } else {
        errorContainer.innerHTML = 'Formulario enviado con éxito.';
        
    }
});

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}


document.getElementById('convertForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const number = parseInt(document.getElementById('numberInput').value);
    const result = numberToWords(number);
    document.getElementById('result').innerText = result;
});

