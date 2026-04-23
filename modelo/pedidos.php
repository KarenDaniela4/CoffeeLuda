<?php 
// Requerimiento de la clase base de conexión para heredar sus métodos PDO
require_once('../modelo/conexion.php');

/**
 * Clase Pedidos: Representa la entidad en la base de datos
 * Hereda de la clase 'conexion' para realizar operaciones CRUD
 */
class pedidos extends conexion {

    // Atributos privados (Encapsulamiento)
    private $IdProducto;
    private $Cantidad;
    private $Total;
    private $Fecha;
    private $IdPedido;
    private $id_usuario;
    
    public function getIdProducto() {
        return $this->IdProducto;
    }

    public function getCantidad() {
        return $this->Cantidad;
    }

    public function getTotal() {
        return $this->Total;
    }

    public function getFecha() {
        return $this->Fecha;
    }
    
    public function getIdPedido() {
        return $this->IdPedido;
    }
    
    public function getId_Usuario() {
        return $this->id_usuario;
    }

    public function setIdProducto($IdProducto): void {
        $this->IdProducto = $IdProducto;
    }

    public function setCantidad($Cantidad): void {
        $this->Cantidad = $Cantidad;
    }

    public function setTotal($Total): void {
        $this->Total = $Total;
    }

    public function setFecha($Fecha): void {
        $this->Fecha = $Fecha;
    }
    
    public function setIdPedido($IdPedido): void {
        $this->IdPedido = $IdPedido;
    }
    
    public function setId_Usuario($id_usuario): void {
        $this->id_usuario = $id_usuario;
    }

        
    /**
     * Constructor de la clase
     * Inicializa el objeto con un array de datos o valores nulos
     */
    public function __construct($data = array()) {
    parent::__construct(); // Llama al constructor de 'conexion' para activar PDO
    if (!empty($data)) {
        $this->Cantidad   = $data['Cantidad'] ?? null;
        $this->Total      = $data['Total'] ?? null;
        $this->Fecha      = $data['Fecha'] ?? null;
        $this->IdProducto = $data['IdProducto'] ?? null;
        $this->IdPedido = $data['IdPedido'] ?? null;
        $this->id_usuario = $data['id_usuario'] ?? null;
    }
}

    // Destructor: Asegura el cierre de la conexión al terminar el script
    function __destruct() {
        $this->Disconnect();
    }

    /**
     * OPERACIÓN CREATE: Inserta un nuevo pedido en la tabla
     */
    public function insertar() {
        $sql = "INSERT INTO pedidos(IdProducto, Cantidad, Total, Fecha, IdPedido, id_usuario) VALUES (?, ?, ?, ?, ?, ?)";
        $this->insertRow($sql, array(
            $this->IdProducto,
            $this->Cantidad,
            $this->Total,
            $this->Fecha,
            $this->IdPedido,
            $this->id_usuario
    ));
        return true;
    }

    // READ (OBTENER TODOS)
    public static function getAll() {
    $tmp = new pedidos();
    $rows = $tmp->getRows("SELECT * FROM pedidos");
    $tmp->Disconnect();

    $objetos = [];

    foreach ($rows as $row) {
        $objetos[] = new pedidos($row);
    }

    return $objetos;
    }

    // READ (POR ID)
    public static function getById($id) {
        $tmp = new pedidos();
        $dato = $tmp->getRow("SELECT * FROM pedidos WHERE IdPedido = ?", array($id));
        $tmp->Disconnect();
        return $dato;
    }

      public static function getByIdpedido() {
        $tmp = new pedidos();
        $dato = $tmp->getRow("SELECT IdPedido FROM pedidos ORDER BY IdPedido DESC LIMIT 1 ");
        $tmp->Disconnect();
        return $dato;
    }
    
    /**
     * OPERACIÓN UPDATE: Modifica los datos de un pedido existente
     */
    public function editar() {
        $sql = "UPDATE pedidos SET Cantidad = ?, Total = ?, Fecha = ? id_usuario = ?  WHERE IdProducto = ? AND IdPedido = ?";
        $this->updateRow($sql, array(
            
            $this->Cantidad,
            $this->Total,
            $this->Fecha,
            $this->id_usuario,
            $this->IdProducto,
            $this->IdPedido
        ));
    }

    /**
     * OPERACIÓN DELETE: Elimina un registro basándose en su ID compuesto
     */
    public function eliminar() {
        $sql = "DELETE FROM pedidos WHERE IdPedido = ? and IdProducto = ?";
        $this->updateRow($sql, array(
            $this->IdPedido,
            $this->IdProducto    
                ));
    }
    
    /**
     * OPERACIÓN READ: Obtiene el historial de compras de un usuario específico
     * Implementa un INNER JOIN para traer los nombres de los productos
     */
    static public function buscarPorUsuario($id) {
    $sql = "SELECT p.*, pr.Producto AS nombre_producto 
            FROM pedidos p 
            INNER JOIN productos pr ON p.IdProducto = pr.IdProducto 
            WHERE p.id_usuario = ? 
            ORDER BY p.Fecha DESC";
    
    $obj = new self(); 
    return $obj->getRows($sql, array($id));
}

    #[\Override]
    protected static function buscar($query) {
        
    }

    #[\Override]
    public static function buscarForId($id) {
        $tmp = new pedidos();
        $dato = $tmp->getRows("SELECT * FROM pedidos WHERE IdPedido = ?", array($id));
        $tmp->Disconnect();
        return $dato;
        
    }

    #[\Override]
    protected static function selectAll() {
        
    }
}
?>