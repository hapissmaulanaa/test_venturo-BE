<!-- public/login.html -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Styling sesuai kebutuhan */
    </style>
</head>
<body>
    <h1>Login</h1>

    <form id="loginForm">
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>

    <div id="message"></div>

    <script>
        const loginForm = document.getElementById('loginForm');
        const messageDiv = document.getElementById('message');

        loginForm.addEventListener('submit', async function(event) {
            event.preventDefault();

            const formData = new FormData(loginForm);
            const data = {
                email: formData.get('email'),
                password: formData.get('password')
            };

            try {
                const response = await fetch('/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                });

                const responseData = await response.json();
                if (response.ok) {
                    messageDiv.textContent = 'Login successful';
                    // Redirect to dashboard or any other page on successful login
                    // Example: window.location.href = '/dashboard.html';
                } else {
                    messageDiv.textContent = responseData.message || 'Login failed';
                }
            } catch (error) {
                console.error('Error:', error);
                messageDiv.textContent = 'An error occurred. Please try again later.';
            }
        });
    </script>
</body>
</html>
