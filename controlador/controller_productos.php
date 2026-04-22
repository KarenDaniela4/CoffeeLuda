<?php
require_once(__DIR__ . '/../modelo/productos.php');


if (!empty($_GET['action'])) {
    controller_productos::main($_GET['action']);
    $action = $_GET['action'];
}
class controller_productos {
    static function main($action) {
        if ($action == "crear") {
            controller_productos::crear();
        } else if ($action == "editar") {
            controller_productos::editar();
        } else if ($action == "buscarID") {
            controller_productos::buscarID(1);
        } else if ($action == "eliminar") {
            controller_productos::eliminar();
        }
         else if ($action == "validacion") {
            controller_productos::validacion();
        }
       
    }
    static public function crear() {
        try {
                $arrayproductos = array();
                $arrayproductos['IdProducto'] = $_POST['IdProducto'];
                $arrayproductos['Producto'] = $_POST['Producto'];
                $arrayproductos['Precio'] = $_POST['Precio'];
                $productos = new productos($arrayproductos);
                $productos->insertar();
                echo"<script languaje='javascript'>window.location='../frontend/RegistrarProducto.php?respuesta=correcto&o=cread'</script>;";
                }
               catch (Exception $e) {
              echo $e->getMessage();
             }
    }
    static public function editar() {
        try {
            $arrayproductos = array();            
            $arrayproductos['IdProducto'] = $_POST['IdProducto'];
                $arrayproductos['Producto'] = $_POST['Producto'];
                $arrayproductos['Precio'] = $_POST['Precio'];
                var_dump($arrayproductos);
                $productos = new productos($arrayproductos);
                $productos->editar();
          echo"<script languaje='javascript'>window.location='../frontend/productosform.php?respuesta=correcto&o=modificad'</script>;";
        } catch (Exception $e) {
            echo"<script languaje='javascript'>window.location='../frontend/productosform.php?respuesta=error&o=modificad'</script>;";
        }
    }
    static public function buscarID($id) {
        try {
            return productos::buscarForId($id);
        } catch (Exception $e) {
            echo"<script languaje='javascript'>window.location='../buscar.php?respuesta=error&o=encontrad'</script>;";
        }
    }
    static public function buscarAll() {
        try {
            return productos::getAll();
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
            $arrayproductos = array();
            $arrayproductos['IdProducto'] = $_GET['IdProducto'];
            //var_dump($arrayproductos);
            $productos = new productos($arrayproductos);
            $productos->eliminar();
           echo"<script languaje='javascript'>window.location='../frontend/productos.php?respuesta=correcto&o=eliminar'</script>;";
        } catch (Exception $e) {
            echo"<script languaje='javascript'>window.location='../frontend/productos.php?respuesta=error&o=eliminar'</script>;";
        }
    }
    
    

    
    
}