<?php 

require_once('../modelo/conexion.php');

class productos extends conexion {

    private $IdProducto;
    private $Producto;
    private $Precio;
    
    public function getIdProducto() {
        return $this->IdProducto;
    }
    
    public function getProducto() {
        return $this->Producto;
    }
    
    public function getPrecio() {
        return $this->Precio;
    }

    public function setIdProducto($IdProducto): void {
        $this->IdProducto = $IdProducto;
    }

    public function Producto($Producto): void {
        $this->Producto = $Producto;
    }

    public function Precio($Precio): void {
        $this->Precio = $Precio;
    }

        
    // CONSTRUCTOR
    public function __construct($data = array()) {
    parent::__construct();
    if (!empty($data)) {
        $this->IdProducto = $data['IdProducto'] ?? null;
        $this->Producto   = $data['Producto'] ?? null;
        $this->Precio      = $data['Precio'] ?? null;
    }
}

    function __destruct() {
        $this->Disconnect();
    }

    // CREATE (INSERTAR)
    public function insertar() {
        $sql = "INSERT INTO productos(IdProducto, Producto, Precio) VALUES (?, ?, ?)";
        $this->insertRow($sql, array(
            $this->IdProducto,
            $this->Producto,
            $this->Precio,
    ));
    }

    // READ (OBTENER TODOS)
    public static function getAll() {
    $tmp = new productos();
    $rows = $tmp->getRows("SELECT * FROM productos");
    $tmp->Disconnect();

    $objetos = [];

    foreach ($rows as $row) {
        $objetos[] = new productos($row);
    }

    return $objetos;
    }

    // READ (POR ID)
    public static function getById($id) {
        $tmp = new productos();
        $dato = $tmp->getRow("SELECT * FROM productos WHERE IdProducto = ?", array($id));
        $tmp->Disconnect();
        return $dato;
    }

    // UPDATE (EDITAR)
    public function editar() {
        $sql = "UPDATE productos SET Producto = ?, Precio = ? WHERE IdProducto = ?";
        $this->updateRow($sql, array(
            $this->Producto,
            $this->Precio,
            $this->IdProducto,
        ));
    }

    // DELETE (ELIMINAR)
    public function eliminar() {
        $sql = "DELETE FROM productos WHERE IdProducto = ?";
        $this->updateRow($sql, array($this->IdProducto));
    }

    #[\Override]
    protected static function buscar($query) {
        
    }

    #[\Override]
    public static function buscarForId($id) {
        $tmp = new productos();
        $dato = $tmp->getRows("SELECT * FROM productos WHERE IdProducto = ?", array($id));
        $tmp->Disconnect();
        return $dato;
        
    }

    #[\Override]
    protected static function selectAll() {
        
    }
}
?>