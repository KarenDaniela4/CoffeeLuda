<?php
session_start();
header('Content-Type: application/json');

require_once(__DIR__ . '/../modelo/pedidos.php');

$json = file_get_contents('php://input');
$datosRecibidos = json_decode($json, true);

if (!empty($datosRecibidos['carrito'])) {
    
    if (!isset($_SESSION['id_usuario'])) {
        echo json_encode([
            "status" => "error", 
            "mensaje" => "Debes iniciar sesión para realizar la compra."
        ]);
        exit;
    }

    $idLogueado = $_SESSION['id_usuario'];
    $fechaActual = date("Y-m-d H:i:s");
    $huboError = false;

    foreach ($datosRecibidos['carrito'] as $item) {
        $arrayPedido = array(
            'Cantidad'   => $item['cantidad'],
            'Fecha'      => $fechaActual,
            'IdProducto' => $item['id'],
            'Total'      => $item['precio'] * $item['cantidad'],
            'id_usuario' => $idLogueado
        );

        $pedido = new pedidos($arrayPedido);
        
        if (!$pedido->insertar()) {
            $huboError = true;
        }
    }

    if (!$huboError) {
        echo json_encode([
            "status" => "ok", 
            "mensaje" => "¡Pedido registrado con éxito en Coffee Luda!"
        ]);
    } else {
        echo json_encode([
            "status" => "error", 
            "mensaje" => "Ocurrió un error al guardar algunos productos."
        ]);
    }

} else {
    echo json_encode([
        "status" => "error", 
        "mensaje" => "El carrito parece estar vacío."
    ]);
}
?>