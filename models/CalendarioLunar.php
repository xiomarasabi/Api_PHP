<?php
class CalendarioLunar {
    private $connect;
    private $table = "calendario_lunar";

    public $descripcion_evento;
    public $evento;
    public $fecha;
    public $id_calendario_lunar;

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
        $query = "INSERT INTO " . $this->table . " (descripcion_evento, evento, fecha) VALUES (:descripcion_evento, :evento, :fecha)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":descripcion_evento", $this->descripcion_evento);
        $stmt->bindParam(":evento", $this->evento);
        $stmt->bindParam(":fecha", $this->fecha);
        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE calendario_lunar SET descripcion_evento = :descripcion_evento, evento = :evento, fecha = :fecha WHERE id_calendario_lunar = :id_calendario_lunar";
        
        $stmt = $this->connect->prepare($query);
        
        $stmt->bindParam(":id_calendario_lunar", $this->id_calendario_lunar, PDO::PARAM_INT);
        $stmt->bindParam(":descripcion_evento", $this->descripcion_evento);
        $stmt->bindParam(":evento", $this->evento);
        $stmt->bindParam(":fecha", $this->fecha);
        return $stmt->execute();
    }
    
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_calendario_lunar = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>