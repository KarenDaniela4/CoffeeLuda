<?php
session_start();

// Seguridad: solo administradores (rol 1) pueden entrar aquí
if (!isset($_SESSION['idrol']) || $_SESSION['idrol'] != 1) {
    header("Location: menu.php?error=sin_permisos");
    exit();
}

require_once('../modelo/usuarios.php');

// Cargamos los usuarios desde la BD
$tmp = new usuarios();
$listaUsuarios = $tmp->getRows("SELECT id, nombre, apellido, email, id_rol FROM usuarios");
$tmp->Disconnect();

// Mensaje de respuesta tras editar / eliminar
$mensaje = '';
$tipoMensaje = '';
if (isset($_GET['respuesta'])) {
    $operacion = $_GET['o'] ?? '';
    if ($_GET['respuesta'] == 'correcto') {
        $tipoMensaje = 'ok';
        $mensaje = $operacion == 'editado' ? '✅ Usuario editado correctamente.' : '✅ Usuario eliminado correctamente.';
    } else {
        $tipoMensaje = 'error';
        if ($operacion == 'autoeliminar') {
            $mensaje = '⚠️ No puedes eliminar tu propia cuenta de administrador.';
        } else {
            $mensaje = '❌ Ocurrió un error al procesar la operación.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios - Coffee Luda</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .aviso { padding: 10px 15px; margin: 15px 0; border-radius: 6px; text-align: center; }
        .aviso.ok { background: #d4edda; color: #155724; }
        .aviso.error { background: #f8d7da; color: #721c24; }
        .btn-edit, .btn-delete {
            display: inline-block; padding: 6px 10px; margin: 0 2px;
            text-decoration: none; border-radius: 5px; font-size: 1em;
        }
        .btn-edit { background: #f0ad4e; }
        .btn-delete { background: #d9534f; }
        .badge { padding: 4px 10px; border-radius: 12px; font-size: 0.85em; color: white; }
        .badge.admin { background: #2c3e50; }
        .badge.cliente { background: #be7b7b; }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="menu.php">Volver al Menú</a>
        <h2>👥 Gestión de Usuarios</h2>
    </nav>

    <div class="container">
        <?php if ($mensaje): ?>
            <div class="aviso <?php echo $tipoMensaje; ?>"><?php echo $mensaje; ?></div>
        <?php endif; ?>

        <table class="tabla-compras">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo Electrónico</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($listaUsuarios)): ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">No hay usuarios registrados.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($listaUsuarios as $user): ?>
                        <?php
                            $esAdmin = ($user['id_rol'] == 1);
                            $rolTexto = $esAdmin ? 'Administrador' : 'Cliente';
                            $rolClase = $esAdmin ? 'admin' : 'cliente';
                            $esMiUsuario = ($_SESSION['id_usuario'] == $user['id']);
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['nombre'] . ' ' . $user['apellido']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <span class="badge <?php echo $rolClase; ?>">
                                    <?php echo $rolTexto; ?>
                                </span>
                            </td>
                            <td>
                                <a href="EditarUsuario.php?id=<?php echo urlencode($user['id']); ?>"
                                   class="btn-edit"
                                   title="Editar">✏️</a>

                                <?php if ($esMiUsuario): ?>
                                    <span class="btn-delete" style="opacity: 0.4; cursor: not-allowed;" title="No puedes eliminarte a ti mismo">🗑️</span>
                                <?php else: ?>
                                    <a href="../controlador/controller_usuarios.php?action=eliminar&id=<?php echo urlencode($user['id']); ?>"
                                       class="btn-delete"
                                       title="Eliminar"
                                       onclick="return confirm('¿Seguro que deseas eliminar al usuario <?php echo htmlspecialchars($user['nombre'], ENT_QUOTES); ?>? Esta acción no se puede deshacer.');">🗑️</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>