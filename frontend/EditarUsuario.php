<?php
session_start();

// Solo administradores
if (!isset($_SESSION['idrol']) || $_SESSION['idrol'] != 1) {
    header("Location: menu.php?error=sin_permisos");
    exit();
}

require_once('../modelo/usuarios.php');

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: gestion_usuarios.php?respuesta=error&o=editado");
    exit();
}

// Cargamos los datos actuales del usuario
$usuario = usuarios::getById($id);

if (!$usuario) {
    header("Location: gestion_usuarios.php?respuesta=error&o=editado");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario - Coffee Luda</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f5f0e8; }
        .form-card {
            max-width: 480px; margin: 40px auto; background: white;
            padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .form-card h2 { text-align: center; color: #be7b7b; }
        .form-card label { display: block; margin-top: 15px; font-weight: bold; color: #333; }
        .form-card input, .form-card select {
            width: 100%; padding: 10px; margin-top: 5px;
            border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box;
        }
        .form-card input[readonly] { background: #f0f0f0; color: #666; }
        .acciones { margin-top: 25px; display: flex; gap: 10px; }
        .acciones button, .acciones a {
            flex: 1; padding: 10px; border: none; border-radius: 6px;
            text-align: center; text-decoration: none; font-weight: bold; cursor: pointer;
        }
        .btn-guardar { background: #5cb85c; color: white; }
        .btn-cancelar { background: #ccc; color: #333; }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="gestion_usuarios.php">← Volver a Gestión de Usuarios</a>
    </nav>

    <div class="form-card">
        <h2>✏️ Editar Usuario</h2>

        <form method="POST" action="../controlador/controller_usuarios.php?action=editar">

            <label>ID (no editable)</label>
            <input type="text" name="id" value="<?php echo htmlspecialchars($usuario['id']); ?>" readonly>

            <label>Nombre</label>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>

            <label>Apellido</label>
            <input type="text" name="apellido" value="<?php echo htmlspecialchars($usuario['apellido']); ?>" required>

            <label>Teléfono</label>
            <input type="text" name="telefono" value="<?php echo htmlspecialchars($usuario['telefono']); ?>">

            <label>Correo electrónico</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>

            <label>Rol</label>
            <select name="id_rol" required>
                <option value="1" <?php echo ($usuario['id_rol'] == 1) ? 'selected' : ''; ?>>Administrador</option>
                <option value="2" <?php echo ($usuario['id_rol'] == 2) ? 'selected' : ''; ?>>Cliente</option>
            </select>

            <div class="acciones">
                <a href="gestion_usuarios.php" class="btn-cancelar">Cancelar</a>
                <button type="submit" class="btn-guardar">Guardar cambios</button>
            </div>
        </form>
    </div>
</body>
</html>