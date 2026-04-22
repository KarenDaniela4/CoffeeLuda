<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Login - Coffee Luda</title>


        <style>
            body {
                margin: 0;
                font-family: Arial, sans-serif;
                background: linear-gradient(135deg, #ebb4b4);
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .login-container {
                background: #be7b7b;
                padding: 40px;
                border-radius: 12px;
                width: 300px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.2);
                text-align: center;
            }

            h2 {
                margin-bottom: 20px;
                color: white;
            }

            input {
                width: 100%;
                padding: 10px;
                margin: 10px 0;
                border-radius: 8px;
                border: 1px solid #ccc;
                outline: none;
            }

            input:focus {
                border-color: #ffffff;
            }

            button {
                width: 100%;
                padding: 10px;
                background: #ebb4b4;
                color: black;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                margin-top: 10px;
            }

            button:hover {
                background: #daaaaa;
            }

            .error {
                color: red;
                margin-top: 10px;
                font-size: 14px;
            }

            .link {
                margin-top: 15px;
                display: block;
                color: black;
                text-decoration: none;
            }

            .link:hover {
                text-decoration: underline;
            }

            .navbar {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 70px;
                background: #be7b7b;
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0 30px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.2);
                z-index: 1000;
            }

            .navbar a {
                color: white;
                text-decoration: none;
                font-weight: bold;
            }

            .navbar a:hover {
                text-decoration: underline;
            }

            .logo-nav img {
                height: 300px;
                margin-left: -60px;
                display: flex;
                align-items: center;
                transform: translateY(-4px);
            }

        </style>
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>
        <nav class="navbar">
            <div class="nav-left">
                <a href="index.php" class="logo-nav">
                    <img src="images/logo.png" alt="Coffee Luda">
                </a>
            </div>

            <div class="nav-right">
                <a href="index.php">Inicio</a>
            </div>
        </nav>
        <form class="form account-form" method="POST" action="../controlador/controller_usuarios.php?action=validacion">

            <div class="login-container">
                <h2>☕ Coffee Luda</h2>

                <input type="email"  value=""  name="email" placeholder="Correo electrónico">
                <input type="password"   value="password" name="password" placeholder="Contraseña">

                <button type="submit">Entrar</button>

                <p id="error" class="error"></p>

                <a href="registro.php" class="link">¿No tienes cuenta? Regístrate</a>
            </div>
        </form>
        <script src="js/login.js"></script>

    </body>
</html>