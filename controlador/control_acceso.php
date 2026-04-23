<?php
/**
 * SISTEMA DE CONTROL DE ACCESO - COFFEE LUDA
 * Este archivo gestiona la seguridad de las rutas administrativas.
 */

// Verifica el estado de la sesión para evitar errores de duplicidad al iniciar el script
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * FUNCIÓN DE VALIDACIÓN DE ROL (Middleware de Seguridad)
 * Restringe el acceso a páginas específicas únicamente a usuarios con privilegios de administrador.
 */
function validarAdmin() {
    // Verificación de integridad: Comprueba si la variable de sesión 'idrol' existe
    // y si corresponde al valor definido para Administradores (en este caso, 1).
    if (!isset($_SESSION['idrol']) || $_SESSION['idrol'] != 1) {
        // REDIRECCIÓN DE SEGURIDAD: Expulsa al usuario al menú principal 
        // si intenta acceder a una ruta protegida sin permisos.
        header("Location: menu.php?error=acceso_denegado");
        // Finaliza la ejecución del script inmediatamente para prevenir la carga de contenido sensible
        exit();
    }
}
?>