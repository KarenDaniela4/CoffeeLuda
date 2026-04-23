<?php
session_start();
include '../controlador/controller_usuarios.php';

// El menú es público: si no hay sesión, rol y email quedan en null
$rol = $_SESSION['idrol'] ?? null;
$email = $_SESSION['email'] ?? 'Invitado';
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Menú - Coffee Luda</title>
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    </head>
    <body>

        <header class="navbar">
            <div class="logo">
                <img src="images/logo.png" alt="Coffee Luda">
            </div>
            <nav>
                <a href="index.php">Inicio</a>

                <?php if ($rol === null): ?>
                    <!-- Visitante sin sesión -->
                    <a href="carrito.php">Carrito 🛒</a>
                    <a href="login.php">Iniciar Sesión</a>
                    <a href="registro.php">Registro</a>
                <?php elseif ($rol == 1): ?>
                    <!-- Administrador -->
                    <a href="RegistrarProducto.php">Registrar Productos</a>
                    <a href="productosform.php">Gestionar Productos</a>
                    <a href="gestion_usuarios.php">Usuarios</a>
                <?php else: ?>
                    <!-- Cliente logueado -->
                    <a href="carrito.php">Carrito 🛒</a>
                    <a href="mis_compras.php" class="nav-link">Mis Compras</a>
                <?php endif; ?>

                <?php if ($rol !== null): ?>
                    <a href="../controlador/controller_usuarios.php?action=cerrar" 
                        onclick="return confirm('¿Estás seguro de que quieres salir?')" 
                        style="cursor: pointer; color: white; background-color: #c0392b; padding: 8px 15px; border-radius: 5px; text-decoration: none;">
                        Cerrar Sesión
                    </a>
                    <div id="auth" style="margin-left: 15px; font-size: 0.8em; color: #555;">
                        👤 <?php echo $email; ?>
                    </div>
                <?php endif; ?>
            </nav>
        </header>

        <section class="container">
            <div style="text-align: center; margin-bottom: 30px;">
                <h2>Bienvenido a Coffee Luda</h2>
                <?php if ($rol !== null): ?>
                    <p>Has ingresado como: <strong><?php echo ($rol == 1) ? "Administrador" : "Cliente"; ?></strong></p>
                <?php else: ?>
                    <p>Explora nuestro menú. <a href="login.php">Inicia sesión</a> o <a href="registro.php">regístrate</a> para poder comprar.</p>
                <?php endif; ?>
            </div>

            <h2>Nuestro Menú</h2>
            <div id="productos" class="grid">
            </div>
        </section>
        <script src="js/app.js"></script>

    </body>
</html>