<?php
class Notificacion {
    private $connect;
    private $table = "notificacion";

    public $id_notificacion;
    public $fk_id_programacion;
    public $mensaje;
    public $titulo;

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
        $query = "INSERT INTO " . $this->table . " (fk_id_programacion, mensaje, titulo) VALUES (:fk_id_programacion, :mensaje, :titulo)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":fk_id_programacion", $this->fk_id_programacion, PDO::PARAM_INT);
        $stmt->bindParam(":mensaje", $this->mensaje);
        $stmt->bindParam(":titulo", $this->titulo);
        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table . " SET fk_id_programacion = :fk_id_programacion, mensaje = :mensaje, titulo = :titulo WHERE id_notificacion = :id_notificacion";
        
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id_notificacion", $this->id_notificacion, PDO::PARAM_INT);
        $stmt->bindParam(":fk_id_programacion", $this->fk_id_programacion, PDO::PARAM_INT);
        $stmt->bindParam(":mensaje", $this->mensaje);
        $stmt->bindParam(":titulo", $this->titulo);
        
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_notificacion = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
