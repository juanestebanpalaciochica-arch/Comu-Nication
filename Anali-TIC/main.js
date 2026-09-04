loginForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    try {
        const response = await fetch('login.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, password })
        });

        const rawText = await response.text();
        console.log('Respuesta del servidor:', rawText); // Ver respuesta cruda en consola

        const data = JSON.parse(rawText);

        if (data.success) {
            // Éxito al iniciar sesión
            loginView.classList.add('hidden');
            dashboardView.classList.remove('hidden');
        } else {
            alert(`Error del servidor: ${data.message || data.error_type}`);
        }
    } catch (error) {
        console.error('Error detallado:', error);
        alert('Ocurrió un error al procesar la solicitud. Revisa la consola del navegador (F12).');
    }
});