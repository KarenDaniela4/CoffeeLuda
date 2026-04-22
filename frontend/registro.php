<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro - Coffee Luda</title>

  <link rel="stylesheet" href="css/styles.css">

  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;

      background: url("images/bg-cafe.png");
      background-size: 300px;
      background-repeat: repeat;
      background-position: center;

      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container {
      background: #be7b7b;
      padding: 40px;
      transform: translateY(100px);
      border-radius: 12px;
      width: 320px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
      text-align: center;
    }

    .logo-login {
      width: 180px;
      margin-top: -60px;
      margin-bottom: -50px;
    }

    h2 {
      margin-bottom: 15px;
      color: white;
    }

    input {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border-radius: 8px;
      border: none;
      outline: none;
    }

    input:focus {
      box-shadow: 0 0 5px white;
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

    .link {
      margin-top: 15px;
      display: block;
      color: white;
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
                height: 100px;
                background: #be7b7b;
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0 30px;
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
                transform: translateY(-3px);
            }
  </style>
</head>

<body>
    <nav class="navbar">
            <div class="nav-left">
                <a href="index.php" class="logo-nav">
                    <img src="images/logo.png" alt="Coffee Luda">
                </a>
            </div>
        
        <div class="nav-right">
                <a href="menu.php">Menú</a>
            </div>
        </nav>

  <div class="container">

    <img src="images/logo.png" class="logo-login" alt="Coffee Luda">

    <h2>Crear cuenta</h2>

    <input type="text" id="id" placeholder="Id">
    <input type="text" id="nombre" placeholder="Nombre">
    <input type="text" id="apellido" placeholder="Apellido">
    <input type="text" id="telefono" placeholder="Teléfono">
    <input type="email" id="email" placeholder="Correo electrónico">
    <input type="password" id="password" placeholder="Contraseña">
    <input type="confirmpassword" id="confirmPassword" placeholder="Confirmar contraseña">
    <input type="pregunta" id="pregunta" placeholder="Pregunta">
    <input type="respuesta" id="respuesta" placeholder="Respuesta">
    <input type='hidden' name='id_rol' value ='2'>
    
    <button type="button" onclick="registro()">Registrarse</button>

    <p id="mensaje"></p>

    <a href="login.php" class="link">¿Ya tienes cuenta? Inicia sesión</a>

  </div>

  <script src="js/registro.js"></script>

</body>
</html>