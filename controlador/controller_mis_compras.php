<?php
// Control de sesión: Verifica si no existe una sesión activa para iniciarla
// Esto permite acceder a la superglobal $_SESSION y validar el estado del usuario
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Requerimiento del modelo de pedidos para interactuar con la base de datos
require_once(__DIR__ . '/../modelo/pedidos.php');

// MIDDLEWARE DE AUTENTICACIÓN: Si el usuario no tiene una sesión activa, 
// se redirige al login para proteger la privacidad de los datos.
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../frontend/login.php");
    exit;
}

/** * LÓGICA DE CONSULTA PERSONALIZADA
 * Se captura el ID único del usuario desde la sesión para filtrar la base de datos
 */
$idLogueado = $_SESSION['id_usuario'];

/**
 * Invocación del método estático del modelo 'pedidos'.
 * Retorna un array con el historial de compras exclusivo del usuario logueado.
 * Implementa la seguridad a nivel de datos (Data-level security).
 */
$misPedidos = pedidos::buscarPorUsuario($idLogueado);
?>