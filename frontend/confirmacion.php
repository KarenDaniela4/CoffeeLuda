<?php
session_start();

// Solo usuarios logueados
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php?error=no_autenticado");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>¡Pedido confirmado! - Coffee Luda</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f5f0e8; margin: 0; }
        .confirmacion-card {
            max-width: 500px; margin: 60px auto; background: white;
            border-radius: 16px; padding: 40px 30px; text-align: center;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        }
        .check-circle {
            width: 80px; height: 80px; background: #5cb85c;
            border-radius: 50%; margin: 0 auto 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 48px; color: white;
        }
        h1 { color: #333; margin-bottom: 10px; }
        .sub { color: #666; margin-bottom: 25px; }
        .detalles {
            text-align: left; background: #faf6f0; padding: 20px;
            border-radius: 10px; margin: 25px 0;
        }
        .detalles-row {
            display: flex; justify-content: space-between;
            padding: 6px 0; font-size: 0.95em;
        }
        .detalles-row.total {
            border-top: 2px solid #be7b7b; margin-top: 8px; padding-top: 10px;
            font-weight: bold; font-size: 1.1em;
        }
        .botones {
            display: flex; gap: 10px; margin-top: 20px;
        }
        .btn {
            flex: 1; padding: 12px; text-decoration: none;
            border-radius: 8px; font-weight: bold; text-align: center;
        }
        .btn-primario { background: #be7b7b; color: white; }
        .btn-secundario { background: #f0e0e0; color: #333; }
        .sin-compra {
            color: #666; padding: 30px; text-align: center;
        }
    </style>
</head>
<body>
    <div class="confirmacion-card">
        <div id="contenido">
            <!-- Se rellena con JS -->
        </div>
    </div>

    <script>
        const ultimaCompra = JSON.parse(sessionStorage.getItem("ultimaCompra"));
        const contenido = document.getElementById("contenido");

        if (!ultimaCompra) {
            contenido.innerHTML = `
                <h1>Sin compra reciente</h1>
                <p class="sub">No encontramos información de una compra reciente.</p>
                <div class="botones">
                    <a href="menu.php" class="btn btn-primario">Ir al menú</a>
                </div>
            `;
        } else {
            const metodoTexto = ultimaCompra.metodo === "tarjeta"
                ? "💳 Tarjeta"
                : "💵 Efectivo al retirar";

            let itemsHtml = "";
            ultimaCompra.items.forEach(item => {
                itemsHtml += `
                    <div class="detalles-row">
                        <span>${item.nombre} × ${item.cantidad}</span>
                        <span>$${item.subtotal.toLocaleString()}</span>
                    </div>
                `;
            });

            contenido.innerHTML = `
                <div class="check-circle">✓</div>
                <h1>¡Pedido confirmado!</h1>
                <p class="sub">Gracias por tu compra en Coffee Luda ☕</p>

                <div class="detalles">
                    ${itemsHtml}
                    <div class="detalles-row total">
                        <span>Total pagado</span>
                        <span>$${ultimaCompra.total.toLocaleString()}</span>
                    </div>
                    <div class="detalles-row" style="margin-top: 10px; color: #666;">
                        <span>Método de pago</span>
                        <span>${metodoTexto}</span>
                    </div>
                    <div class="detalles-row" style="color: #666;">
                        <span>Fecha</span>
                        <span>${ultimaCompra.fecha}</span>
                    </div>
                </div>

                <div class="botones">
                    <a href="menu.php" class="btn btn-secundario">Seguir comprando</a>
                    <a href="mis_compras.php" class="btn btn-primario">Ver mis compras</a>
                </div>
            `;
            
            setTimeout(() => sessionStorage.removeItem("ultimaCompra"), 500);
        }
    </script>
</body>
</html>