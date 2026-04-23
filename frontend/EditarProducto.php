<?php
/**
 * VISTA: EDICIÓN DE PRODUCTOS
 * Permite a los administradores modificar la información de un café existente.
 */
session_start();

// Control de Acceso: Solo usuarios autorizados pueden entrar a esta vista
if (file_exists('../controlador/control_acceso.php')) {
    require_once '../controlador/control_acceso.php';
}

require_once '../controlador/controller_productos.php';

// Verificación de parámetro: Se requiere el ID del producto para consultar sus datos actuales
if (isset($_GET['IdProducto'])) {
    $id = $_GET['IdProducto'];
    // Invocación al controlador para obtener los datos específicos del producto
    $objProductos = controller_productos::buscarID($id);
} else {
    
    // Redirección de seguridad si se intenta entrar sin un ID válido
    header("Location: productos.php?error=sin_id");
    exit();
}
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>EditarProducto - Coffee Luda</title>

        <link rel="stylesheet" href="css/styles.css">

        <style>
            body {
                margin: 0;
                font-family: Arial, sans-serif;

                /* FONDO CON PATRÓN */
                background: url("images/bg-cafe.png");
                background-size: 300px;
                background-repeat: repeat;
                background-position: center;

                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .container {
                background: #be7b7b;
                padding: 40px;
                border-radius: 12px;
                width: 400px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.2);
                text-align: center;
                transform: translateY(120px);
                max-height: 80vh;
                overflow-y: auto;
                padding-right: 40px;
            }

            .logo-login {
                width: 200px;
                margin-left: 100px;
                margin-top: -20px;
                margin-bottom: -50px;
                transform: translateY(-340px);
            }

            h2 {
                margin-bottom: 15px;
                color: white;
            }

            input {
                width: 100%;
                padding: 10px;
                margin: 8px 0;
                border-radius: 8px;
                border: none;
                outline: none;
                transform: translateY(40px);
            }

            input:focus {
                box-shadow: 0 0 5px black;
            }

            button {
                width: 100%;
                padding: 10px;
                background: #ebb4b4;
                color: black;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                margin-top: 10px;
                transform: translateY(30px);
            }

            button:hover {
                background: #daaaaa;
            }

            .link {
                margin-top: 15px;
                display: block;
                color: white;
                text-decoration: none;
            }

            .link:hover {
                text-decoration: underline;
            }

            table  {
                padding: 60 px;
            }

            .navbar {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100px;
                background: #be7b7b;
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0 30px;
                z-index: 1000;
            }

            .navbar a {
                color: white;
                text-decoration: none;
                font-weight: bold;
            }

            .navbar a:hover {
                text-decoration: underline;
            }

            .logo-nav img {
                height: 300px;
                margin-left: -60px;
                display: flex;
                align-items: center;
                transform: translateY(-3px);
            }
        </style>
    </head>
    <section id="page" class="commonsection">
        <div>
            <?php
            if (!empty($_GET['respuesta'])) {
                $respuesta = $_GET['respuesta'];
                if (!empty($_GET['o'])) {
                    $o = $_GET['o'];
                }
                if ($respuesta == "correcto") {
                    ?>
                    <div class="alert alert-success">
                        <a class="close" data-dismiss="alert" href="" aria-hidden="true">&times;</a>
                        <strong>¡Bien Hecho!</strong> El producto se ha <?php echo $o; ?>o exitosamente.
                    </div>
                    <?php
                } else {
                    ?>    
                    <div class="alert alert-danger">
                        <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
                        <strong>¡Error!</strong> Datos Incorrectos...
                    </div> <!-- /.alert -->
                    <?php
                }
            }
            ?>

            <body>
                <nav class="navbar">
                    <div class="nav-left">
                        <a href="index.php" class="logo-nav">
                            <img src="images/logo.png" alt="Coffee Luda">
                        </a>
                    </div>

                    <div class="nav-right">
                        <a href="index.php">Inicio</a>
                    </div>
                </nav>



                <div class="container">
                    <form action="../controlador/controller_productos.php?action=editar" method="POST">

                        <?php
                        $id = $_GET['IdProducto'];
                        $objProductos = controller_productos::buscarID($id);

                        if (!empty($objProductos)) {
                            foreach ($objProductos as $value) {
                                ?>  

                                <br><!-- comment -->
                                <br><!-- comment -->


                                Producto: <?php echo $value['IdProducto']; ?>
                                <div class="col-lg-4 wow fadeIn"  data-wow-duration="700ms" data-wow-delay="300ms">
                                    <div class="contact_form">

                                        <input type="hidden" value="<?php echo $id ?>" placeholder="IdProducto" name="IdProducto" />

                                    </div>
                                </div>

                                <div class="col-lg-4 wow fadeIn"  data-wow-duration="700ms" data-wow-delay="300ms">
                                    <div class="contact_form">

                                    </div>
                                </div>

                                <?php
                            }
                        }
                        ?>

                        <div class="col-lg-4 wow fadeIn"  data-wow-duration="700ms" data-wow-delay="300ms">
                            <div class="contact_form">
                                <form action="../controlador/controller_productos.php?action=editar" method="POST">
                                    <input type="hidden" name="IdProducto" value="1"> 

                                    <input type="text" name="Producto" value="Café Latte">
                                    <input type="text" name="Precio" value="8000.00">

                                    <button type="submit" name="btnEditar">Guardar</button>
                                </form>
                            </div>
                        </div>
                    </form>


                </div>

        </div>

        <script src="js/registro.js"></script>

    </body>
</html>