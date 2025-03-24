<?php
class Actividad {
    private $connect;
    private $table = "actividad";

    public $descripcion;
    public $id_actividad;
    public $nombre_actividad;

    public function __construct($db) {
        $this->connect = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_actividad = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (descripcion, nombre_actividad) VALUES (:descripcion, :nombre_actividad)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":nombre_actividad", $this->nombre_actividad);
        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table . " SET descripcion = :descripcion, nombre_actividad = :nombre_actividad WHERE id_actividad = :id_actividad";
        
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id_actividad", $this->id_actividad, PDO::PARAM_INT);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":nombre_actividad", $this->nombre_actividad);
        
        return $stmt->execute();
    }
    
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_actividad = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>