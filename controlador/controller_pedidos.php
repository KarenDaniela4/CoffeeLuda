<?php
require_once(__DIR__ . '/../modelo/pedidos.php');


if (!empty($_GET['action'])) {
    controller_pedidos::main($_GET['action']);
    $action = $_GET['action'];
}
class controller_pedidos {
    static function main($action) {
        if ($action == "crear") {
            controller_pedidos::crear();
        } else if ($action == "editar") {
            controller_pedidos::editar();
        } else if ($action == "buscarID") {
            controller_pedidos::buscarID(1);
        } else if ($action == "eliminar") {
            controller_pedidos::eliminar();
        }
         else if ($action == "validacion") {
            controller_pedidos::validacion();
        }
       
    }
    static public function crear() {
        try {
                $arraypedidos = array();
                $arraypedidos['IdProducto'] = $_POST['IdProducto'];
                $arraypedidos['Cantidad'] = $_POST['Cantidad'];
                $arraypedidos['Total'] = $_POST['Total'];
                $arraypedidos['Fecha'] = $_POST['Fecha'];
                $arrayusuarios['IdPedido'] = $_POST['IdPedido'];
                $pedidos = new pedidos($arraypedidos);
                $pedidos->insertar();
                echo"<script languaje='javascript'>window.location='../vista/Registropedidos.php?respuesta=correcto&o=cread'</script>;";
                }
               catch (Exception $e) {
              echo $e->getMessage();
             }
    }
    static public function editar() {
        try {
            $arraypedidos = array();            
            $arraypedidos['Cantidad'] = $_POST['Cantidad'];
            $arraypedidos['Total'] = $_POST['Total'];
            $arraypedidos['Fecha'] = $_POST['Fecha'];
            $arraypedidos['IdProducto'] = $_POST['IdProducto'];
            $arraypedidos['IdPedido'] = $_POST['IdPedido'];
              
              $pedidos = new pedidos($arraypedidos);
              $pedidos->editar();
          echo"<script languaje='javascript'>window.location='../frontend/pedidosform.php?respuesta=correcto&o=modificad'</script>;";
        } catch (Exception $e) {
            echo"<script languaje='javascript'>window.location='../frontend/pedidosform.php?respuesta=error&o=modificad'</script>;";
        }
    }
    static public function buscarID($id) {
        try {
            return pedidos::buscarForId($id);
        } catch (Exception $e) {
            echo"<script languaje='javascript'>window.location='../buscar.php?respuesta=error&o=encontrad'</script>;";
        }
    }
    static public function buscarAll() {
        try {
            return pedidos::getAll();
        } catch (Exception $e) {
            echo"<script languaje='javascript'>window.location='../views/verElementos.php?respuesta=error&o=encontrad'</script>;";
        }
    }
    public function buscar($campo, $parametro) {
        try {
            return elmento::getAll();
        } catch (Exception $e) {
            echo"<script languaje='javascript'>window.location='../buscar.php?respuesta=error&o=encontrad'</script>;";
        }
    }
    static public function eliminar() {
        try {
            $arraypedidos = array();
            $arraypedidos['IdPedido'] = $_GET['IdPedido'];
            $arraypedidos['IdProducto'] = $_GET['IdProducto'];
       // var_dump($arraypedidos);
           $pedidos = new pedidos($arraypedidos);
            $pedidos->eliminar();
        echo"<script languaje='javascript'>window.location='../frontend/pedidosform.php?respuesta=correcto&o=eliminar'</script>;";
        } catch (Exception $e) {
            echo"<script languaje='javascript'>window.location='../frontend/pedidosform.php?respuesta=error&o=eliminar'</script>;";
        }
    }
    
    

    
    
}