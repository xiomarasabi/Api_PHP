<?php
class Herramienta {
    private $connect;
    private $table = "herramientas";

    public $id_herramienta;
    public $nombre_h;
    public $fecha_prestamo;
    public $estado;

    public function __construct($db) {
        $this->connect = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (nombre_h, fecha_prestamo, estado) 
                  VALUES (:nombre_h, :fecha_prestamo, :estado)";

        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":nombre_h", $this->nombre_h);
        $stmt->bindParam(":fecha_prestamo", $this->fecha_prestamo);
        $stmt->bindParam(":estado", $this->estado);

        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET nombre_h = :nombre_herramienta, fecha_prestamo = :fecha_prestamo, estado = :estado 
                  WHERE id_herramienta = :id_herramienta";

        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id_herramienta", $this->id_herramienta, PDO::PARAM_INT);
        $stmt->bindParam(":nombre_herramienta", $this->nombre_h);
        $stmt->bindParam(":fecha_prestamo", $this->fecha_prestamo);
        $stmt->bindParam(":estado", $this->estado);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_herramienta = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id_herramienta", $this->id_herramienta, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
