<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once '../controlador/controller_pedidos.php'; ?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Pedidos - Coffee Luda</title>

  <link rel="stylesheet" href="css/styles.css">

  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;

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
    }

    .logo-login {
      width: 180px;
      margin-top: -60px;
      margin-bottom: -50px;
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
    }

    input:focus {
      box-shadow: 0 0 5px white;
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
                    <strong>¡Bien Hecho!</strong> El pedido se ha <?php echo $o; ?>o exitosamente.
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

        <div class="row">
                            <div class="col-lg-12">
                                <h1 class="pageTitle wow fadeIn"  data-wow-duration="700ms" data-wow-delay="300ms">Pedidos</h1>
                                <div class="titleHR"><span></span></div>
                            </div>
                        </div>
<div class="table-responsive">

                        <table 
                            class="table table-striped table-bordered table-hover table-highlight table-checkable" 
                            data-provide="datatable" 
                            data-display-rows="10"
                            data-info="true"
                            data-search="true"
                            data-length-change="true"
                            data-paginate="true"
                            >
                            <thead>
                                <tr>
                                    <th data-filterable="true" data-sortable="true" data-direction="asc">IdProducto</th>
                                    <th data-filterable="true" data-sortable="true" data-direction="asc"><strong>Cantidad</strong></th>
                                    <th data-filterable="true" data-sortable="true" data-direction="asc"><strong>Total</strong></th>
                                    <th data-filterable="true" data-sortable="true" data-direction="asc"><strong>Fecha</strong></th>
                                    <th data-filterable="true" data-sortable="true" data-direction="asc"><strong>  </strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                               
                                $objpedidos = controller_pedidos::buscarAll();

                                if (!empty($objpedidos)) {
                                   foreach ($objpedidos as $value) {
                                ?>
                                <tr>
                                    <td><?php echo $value->getIdProducto(); ?></td>
                                    <td><?php echo $value->getCantidad(); ?></td>
                                    <td><?php echo $value->getTotal(); ?></td>
                                    <td><?php echo $value->getFecha(); ?></td>
                                    <td>
                                         <a href="Editarpedidos.php?IdPedido=<?php echo $value->getIdPedido(); ?>" ><i class="fa fa-edit ui-popover" data-toggle="tooltip" data-trigger="hover" data-placement="right"  title="Editar"></i>editar</a>
                                         <a href="../controlador/controller_pedidos.php?action=eliminar&IdPedido=<?php echo $value->getIdPedido(); ?>&IdProducto=<?php echo $value->getIdProducto(); ?>      " onclick="return confirmSubmit()"><i class="fa fa-trash-o ui-popover" data-toggle="tooltip" data-trigger="hover" data-placement="right"  title="Eliminar"></i>elminar</a>
                                    </td>
                                    
                                    
                                    
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

  </div>

  <script src="js/registro.js"></script>

</body>
</html>