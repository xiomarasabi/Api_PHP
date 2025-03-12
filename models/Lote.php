<?php
class Lote {
    private $connect;
    private $table = "lote";

    public $id_lote;
    public $dimension;
    public $nombre_lote;
    public $fk_id_ubicacion;
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
        $query = "INSERT INTO " . $this->table . " (dimension, nombre_lote, fk_id_ubicacion, estado) 
                  VALUES (:dimension, :nombre_lote, :fk_id_ubicacion, :estado)";
        $stmt = $this->connect->prepare($query);

        $stmt->bindParam(":dimension", $this->dimension);
        $stmt->bindParam(":nombre_lote", $this->nombre_lote);
        $stmt->bindParam(":fk_id_ubicacion", $this->fk_id_ubicacion);
        $stmt->bindParam(":estado", $this->estado);

        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET dimension = :dimension, nombre_lote = :nombre_lote, fk_id_ubicacion = :fk_id_ubicacion, estado = :estado 
                  WHERE id_lote = :id_lote";
        $stmt = $this->connect->prepare($query);

        $stmt->bindParam(":dimension", $this->dimension);
        $stmt->bindParam(":nombre_lote", $this->nombre_lote);
        $stmt->bindParam(":fk_id_ubicacion", $this->fk_id_ubicacion);
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":id_lote", $this->id_lote);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_lote = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }
}
?>
