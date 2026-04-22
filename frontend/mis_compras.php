<?php
require_once('../controlador/controller_mis_compras.php');
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Mis Compras - Coffee Luda</title>
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>
        <nav class="navbar">
            <a href="menu.php">Volver al Menú</a>
            <h2>☕ Mis Pedidos</h2>
        </nav>

        <div class="container">
            <?php if (empty($misPedidos)): ?>
                <p>Aún no has realizado ninguna compra. ¡Ve por un café!</p>
            <?php else: ?>
                <table class="tabla-compras">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($misPedidos)): ?>
                            <?php foreach ($misPedidos as $pedido): ?>
                                <tr>
                                    <td><?php echo $pedido['Fecha']; ?></td>
                                    <td><?php echo $pedido['nombre_producto']; ?></td>
                                    <td><?php echo $pedido['Cantidad']; ?></td>
                                    <td>$<?php echo number_format($pedido['Total'], 0); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align: center;">No tienes compras registradas todavía.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </body>
</html>