<?php

require_once(__DIR__ . '/../modelo/usuarios.php');

if (basename($_SERVER['PHP_SELF']) == 'controller_usuarios.php' && !empty($_GET['action'])) {
    controller_usuarios::main($_GET['action']);
}

class controller_usuarios {

    static function main($action) {
        if ($action == "crear") {
            controller_usuarios::crear();
        } else if ($action == "editar") {
            controller_usuarios::editar();
        } else if ($action == "buscarID") {
            controller_usuarios::buscarID(1);
        } else if ($action == "eliminar") {
            controller_usuarios::eliminar();
        } else if ($action == "validacion") {
            controller_usuarios::validacion();
        } else if ($action == "cerrar") {
            controller_usuarios::cerrars();
        } else if ($action == "registrarNuevo") {
            controller_usuarios::registrarNuevo();
        }
    }

    static public function registrarNuevo() {
        try {
            $datos = array(
                'id'              => $_POST['id'],
                'nombre'          => $_POST['nombre'],
                'apellido'        => $_POST['apellido'],
                'telefono'        => $_POST['telefono'],
                'email'           => $_POST['email'],
                'password'        => $_POST['password'],
                'confirmpassword' => $_POST['confirmpassword'],
                'pregunta'        => $_POST['pregunta'],
                'respuesta'       => $_POST['respuesta']
            );

            $usuario = new usuarios($datos);
            $usuario->insertar();

            echo "registro_exitoso";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // EDITAR USUARIO (desde el panel de administración)
    static public function editar() {
        self::verificarAdmin();
        try {
            $datos = array(
                'id'       => $_POST['id'],
                'nombre'   => $_POST['nombre'],
                'apellido' => $_POST['apellido'],
                'telefono' => $_POST['telefono'],
                'email'    => $_POST['email']
            );

            $usuario = new usuarios($datos);
            $usuario->setId_rol($_POST['id_rol']);
            $usuario->editarPorAdmin();

            header("Location: ../frontend/gestion_usuarios.php?respuesta=correcto&o=editado");
            exit();
        } catch (Exception $e) {
            header("Location: ../frontend/gestion_usuarios.php?respuesta=error&o=editado");
            exit();
        }
    }

    // ELIMINAR USUARIO (desde el panel de administración)
    static public function eliminar() {
        self::verificarAdmin();
        try {
            $idEliminar = $_GET['id'] ?? null;

            if (!$idEliminar) {
                header("Location: ../frontend/gestion_usuarios.php?respuesta=error&o=eliminado");
                exit();
            }

            // No permitir que el admin se elimine a sí mismo
            if (isset($_SESSION['id_usuario']) && $_SESSION['id_usuario'] == $idEliminar) {
                header("Location: ../frontend/gestion_usuarios.php?respuesta=error&o=autoeliminar");
                exit();
            }

            $usuario = new usuarios(array('id' => $idEliminar));
            $usuario->eliminar();

            header("Location: ../frontend/gestion_usuarios.php?respuesta=correcto&o=eliminado");
            exit();
        } catch (Exception $e) {
            header("Location: ../frontend/gestion_usuarios.php?respuesta=error&o=eliminado");
            exit();
        }
    }

    static public function traerPorId($id) {
        try {
            return usuarios::getById($id);
        } catch (Exception $e) {
            return null;
        }
    }

    static public function crear() {
        // AÚN NO SE HA CONFIGURADO
    }

    static public function buscarID($id) {
        try {
            return usuarios::buscarForId($id);
        } catch (Exception $e) {
            return null;
        }
    }

    static public function buscarAll() {
        try {
            return usuarios::getAll();
        } catch (Exception $e) {
            return array();
        }
    }

    public static function validacion() {
        try {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $email = $_POST['email'];
            $contra = $_POST['password'];

            $usuarioEncontrado = usuarios::validacion($email, $contra);

            if ($usuarioEncontrado) {
                $_SESSION['email'] = $usuarioEncontrado['email'];
                $_SESSION['idrol'] = $usuarioEncontrado['id_rol'];
                $_SESSION['id_usuario'] = $usuarioEncontrado['id'];

                header("Location: ../frontend/menu.php?respuesta=correcto");
            } else {
                header("Location: ../frontend/login.php?respuesta=error");
            }
        } catch (Exception $ex) {
            header("Location: ../frontend/login.php?respuesta=error");
        }
    }

    public static function cerrars() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        header("Location: ../frontend/index.php");
        exit();
    }

    // Helper: bloquea las acciones de administración a usuarios no-admin
    private static function verificarAdmin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['idrol']) || $_SESSION['idrol'] != 1) {
            header("Location: ../frontend/menu.php?error=sin_permisos");
            exit();
        }
    }
}