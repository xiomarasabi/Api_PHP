<?php
class Eras {
    private $connect;
    private $table = "eras";

    public $id_eras;
    public $descripcion;
    public $fk_id_lote;

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
        $query = "INSERT INTO " . $this->table . " (descripcion, fk_id_lote) 
                  VALUES (:descripcion, :fk_id_lote)";
        $stmt = $this->connect->prepare($query);

        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":fk_id_lote", $this->fk_id_lote);

        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET descripcion = :descripcion, fk_id_lote = :fk_id_lote 
                  WHERE id_eras = :id_eras";
        $stmt = $this->connect->prepare($query);

        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":fk_id_lote", $this->fk_id_lote);
        $stmt->bindParam(":id_eras", $this->id_eras);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_eras = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }
}
?>
