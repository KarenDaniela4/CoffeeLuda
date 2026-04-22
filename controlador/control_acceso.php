<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function validarAdmin() {
    if (!isset($_SESSION['idrol']) || $_SESSION['idrol'] != 1) {
        header("Location: menu.php?error=acceso_denegado");
        exit();
    }
}
?>