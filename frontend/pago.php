<?php
session_start();

// Solo usuarios logueados pueden pagar
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php?error=no_autenticado");
    exit();
}

$email = $_SESSION['email'] ?? 'Cliente';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pago - Coffee Luda</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f5f0e8; margin: 0; }
        .pago-wrapper {
            max-width: 900px; margin: 40px auto; padding: 0 20px;
            display: grid; grid-template-columns: 1fr 1fr; gap: 30px;
        }
        @media (max-width: 780px) {
            .pago-wrapper { grid-template-columns: 1fr; }
        }
        .card {
            background: white; border-radius: 12px; padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        .card h3 {
            margin-top: 0; color: #be7b7b; border-bottom: 2px solid #f0e0e0;
            padding-bottom: 10px;
        }
        .item-resumen {
            display: flex; justify-content: space-between;
            padding: 10px 0; border-bottom: 1px dashed #e0e0e0;
        }
        .item-resumen:last-child { border-bottom: none; }
        .total-row {
            display: flex; justify-content: space-between;
            margin-top: 15px; padding-top: 15px; border-top: 2px solid #be7b7b;
            font-size: 1.3em; font-weight: bold; color: #333;
        }
        label { display: block; margin-top: 15px; font-weight: bold; color: #444; }
        input, select {
            width: 100%; padding: 10px; margin-top: 5px; box-sizing: border-box;
            border: 1px solid #ccc; border-radius: 6px; font-size: 1em;
        }
        input:focus, select:focus { border-color: #be7b7b; outline: none; }
        .row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .metodo-pago {
            display: flex; gap: 10px; margin-top: 10px;
        }
        .metodo-pago label {
            flex: 1; padding: 12px; border: 2px solid #ddd; border-radius: 8px;
            text-align: center; cursor: pointer; margin-top: 0; font-weight: normal;
            transition: all 0.2s;
        }
        .metodo-pago label:has(input:checked) {
            border-color: #be7b7b; background: #fdf5f5; font-weight: bold;
        }
        .metodo-pago input { display: none; }
        .btn-confirmar {
            width: 100%; padding: 14px; background: #5cb85c; color: white;
            border: none; border-radius: 8px; font-size: 1.1em; font-weight: bold;
            cursor: pointer; margin-top: 20px;
        }
        .btn-confirmar:hover { background: #4aa04a; }
        .btn-confirmar:disabled { background: #ccc; cursor: not-allowed; }
        .btn-volver {
            display: inline-block; color: #666; text-decoration: none;
            margin-bottom: 15px; font-size: 0.9em;
        }
        .aviso-demo {
            background: #fff3cd; color: #856404; padding: 10px;
            border-radius: 6px; margin-top: 15px; font-size: 0.85em; text-align: center;
        }
        #campos-tarjeta { display: none; margin-top: 15px; }
        .navbar { background: #be7b7b; padding: 20px 30px; color: white; }
        .navbar a { color: white; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="carrito.php">← Volver al carrito</a>
    </nav>

    <div class="pago-wrapper">

        <!-- Resumen del pedido -->
        <div class="card">
            <h3>🧾 Resumen del pedido</h3>
            <div id="resumen-items">
                <!-- Se llena con JS -->
            </div>
            <div class="total-row">
                <span>Total a pagar</span>
                <span id="resumen-total">$0</span>
            </div>
            <p style="margin-top: 20px; font-size: 0.9em; color: #666;">
                Comprando como: <strong><?php echo htmlspecialchars($email); ?></strong>
            </p>
        </div>

        <!-- Formulario de pago -->
        <div class="card">
            <h3>💳 Método de pago</h3>

            <div class="metodo-pago">
                <label>
                    <input type="radio" name="metodo" value="tarjeta" checked>
                    💳 Tarjeta
                </label>
                <label>
                    <input type="radio" name="metodo" value="efectivo">
                    💵 Efectivo
                </label>
            </div>

            <!-- Campos de tarjeta (se muestran solo si se elige tarjeta) -->
            <div id="campos-tarjeta">
                <label>Titular de la tarjeta</label>
                <input type="text" id="titular" placeholder="Como aparece en la tarjeta">

                <label>Número de tarjeta</label>
                <input type="text" id="numero" placeholder="1234 5678 9012 3456" maxlength="19">

                <div class="row-2">
                    <div>
                        <label>Vencimiento</label>
                        <input type="text" id="vencimiento" placeholder="MM/AA" maxlength="5">
                    </div>
                    <div>
                        <label>CVV</label>
                        <input type="text" id="cvv" placeholder="123" maxlength="4">
                    </div>
                </div>
            </div>

            <div id="mensaje-efectivo" style="display:none; padding: 15px; background: #e8f4e8; border-radius: 6px; margin-top: 15px;">
                💵 Pagarás en efectivo al momento de retirar tu pedido en la cafetería.
            </div>

            <button type="button" class="btn-confirmar" id="btn-confirmar" onclick="confirmarPago()">
                Confirmar pago
            </button>

            <div class="aviso-demo">
                ⚠️ Entorno de práctica: los datos de tarjeta son simulados y no se envían a ningún procesador real.
            </div>
        </div>

    </div>

    <script src="js/pago.js"></script>
</body>
</html>