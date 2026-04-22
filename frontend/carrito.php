<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Carrito</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<nav class="navbar">
            <div class="nav-left">
        
        <div class="nav-right">
                <a href="menu.php">Menú</a>
            </div>
        </nav>

<section class="container">
  <h2>🛒Carrito de compras</h2>
  <div id="carrito" class="carrito-container"></div>
  <h2 id="total"></h2>
  <div class="acciones-carrito">
  <button class="btn-vaciar" onclick="vaciar()">🗑 Vaciar carrito</button>
  <button class="btn-comprar" onclick="comprar()">💳 Comprar</button>
</div>
</section>

<script src="js/carrito.js"></script>

</body>
</html>