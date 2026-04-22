<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../modelo/pedidos.php');

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../frontend/login.php");
    exit;
}

$idLogueado = $_SESSION['id_usuario'];

$misPedidos = pedidos::buscarPorUsuario($idLogueado);
?>