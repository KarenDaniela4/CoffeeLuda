<?php

require_once('../modelo/conexion.php');

class usuarios extends conexion {

    private $id;
    private $nombre;
    private $apellido;
    private $telefono;
    private $email;
    private $password;
    private $confirmpassword;
    private $pregunta;
    private $respuesta;
    private $id_rol;

    public function getId_rol() {
        return $this->id_rol;
    }

    public function setId_rol($id_rol): void {
        $this->id_rol = $id_rol;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getConfirmPassword() {
        return $this->confirmpassword;
    }

    public function getPregunta() {
        return $this->pregunta;
    }

    public function getRespuesta() {
        return $this->respuesta;
    }

    public function setId($Id): void {
        $this->id = $Id;
    }

    public function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido): void {
        $this->apellido = $apellido;
    }

    public function setTelefono($telefono): void {
        $this->telefono = $telefono;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }

    public function setPassword($password): void {
        $this->password = $password;
    }

    public function setConfirmPassword($confirmpassword): void {
        $this->confirmpassword = $confirmpassword;
    }

    public function setPregunta($pregunta): void {
        $this->pregunta = $pregunta;
    }

    public function setRespuesta($respuesta): void {
        $this->respuesta = $respuesta;
    }

    // CONSTRUCTOR
    public function __construct($data = array()) {
        parent::__construct();
        if (!empty($data)) {
            $this->id = $data['id'] ?? null;
            $this->nombre = $data['nombre'] ?? null;
            $this->apellido = $data['apellido'] ?? null;
            $this->telefono = $data['telefono'] ?? null;
            $this->email = $data['email'] ?? null;
            $this->password = $data['password'] ?? null;
            $this->confirmpassword = $data['confirmpassword'] ?? null;
            $this->pregunta = $data['pregunta'] ?? null;
            $this->respuesta = $data['respuesta'] ?? null;
        }
    }

    function __destruct() {
        $this->Disconnect();
    }

    // CREATE (INSERTAR)
    public function insertar() {
        $sql = "INSERT INTO usuarios(id, nombre, apellido, telefono, email, password, confirmpassword, pregunta, respuesta, id_rol) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $this->insertRow($sql, array(
            $this->id,
            $this->nombre,
            $this->apellido,
            $this->telefono,
            $this->email,
            $this->password,
            $this->confirmpassword,
            $this->pregunta,
            $this->respuesta,
            2 // Este 2 asigna automáticamente el rol de "Cliente"
        ));
    }

    // READ (OBTENER TODOS)
    public static function getAll() {
        $tmp = new usuarios();
        $rows = $tmp->getRows("SELECT * FROM usuarios");
        $tmp->Disconnect();

        $objetos = [];

        foreach ($rows as $row) {
            $objetos[] = new usuarios($row);
        }

        return $objetos;
    }

    // READ (POR ID)
    public static function getById($id) {
        $tmp = new usuarios();
        $dato = $tmp->getRow("SELECT * FROM usuarios WHERE id = ?", array($id));
        $tmp->Disconnect();
        return $dato;
    }

    // UPDATE (EDITAR)
    public function editar() {
        $sql = "UPDATE usuarios SET nombre = ?, apellido = ?, telefono = ?, email = ?, password = ?, confirmpassword = ?, pregunta = ?, respuesta = ? WHERE Id = ?";
        $this->updateRow($sql, array(
            $this->nombre,
            $this->apellido,
            $this->telefono,
            $this->email,
            $this->password,
            $this->confirmpassword,
            $this->pregunta,
            $this->respuesta,
            $this->id
        ));
    }

    // UPDATE PARA ADMINISTRADOR (no modifica la contraseña)
    public function editarPorAdmin() {
        $sql = "UPDATE usuarios SET nombre = ?, apellido = ?, telefono = ?, email = ?, password = ?, confirmpassword = ?, pregunta = ?, respuesta = ? WHERE Id = ?";
        $this->updateRow($sql, array(
            $this->nombre,
            $this->apellido,
            $this->telefono,
            $this->email,
            $this->password,
            $this->confirmpassword,
            $this->pregunta,
            $this->respuesta,
            $this->id
        ));
    }

    // DELETE (ELIMINAR)
    public function eliminar() {
        $sql = "DELETE FROM usuarios WHERE Id = ?";
        $this->updateRow($sql, array($this->id));
    }

    #[\Override]
    protected static function buscar($query) {

    }

    #[\Override]
    protected static function buscarForId($id) {

    }

    #[\Override]
    protected static function selectAll() {

    }

    public static function validacion($email, $password) {
        $tmp = new usuarios();
        $sql = "SELECT * FROM usuarios WHERE email = ? AND password = ?";
        $dato = $tmp->getRow($sql, array($email, $password));
        $tmp->Disconnect();

        return $dato;
    }
}

?>