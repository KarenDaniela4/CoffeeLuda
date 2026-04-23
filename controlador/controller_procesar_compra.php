<?php
// Inicio de sesión para identificar al usuario que realiza la compra
session_start();
// Definición del tipo de contenido como JSON para comunicación con el Frontend
header('Content-Type: application/json');

// Requerimiento del modelo de pedidos para realizar la persistencia
require_once(__DIR__ . '/../modelo/pedidos.php');

// Captura de los datos enviados mediante una petición Fetch/AJAX (flujo JSON)
$json = file_get_contents('php://input');
$datosRecibidos = json_decode($json, true);

// Validación de existencia de productos en el carrito
if (!empty($datosRecibidos['carrito'])) {
    
    // Verificación de seguridad: El usuario debe estar autenticado
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
    
    // Verificación de seguridad: El usuario debe estar autenticado
    foreach ($datosRecibidos['carrito'] as $item) {
        $arrayPedido = array(
            'Cantidad'   => $item['cantidad'],
            'Fecha'      => $fechaActual,
            'IdProducto' => $item['id'],
            'Total'      => $item['precio'] * $item['cantidad'],
            'id_usuario' => $idLogueado
        );

        // Instancia del modelo y ejecución del método de inserción
        $pedido = new pedidos($arrayPedido);
        
        if (!$pedido->insertar()) {
            $huboError = true;
        }
    }

    // Respuesta final al Frontend según el resultado del proceso
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