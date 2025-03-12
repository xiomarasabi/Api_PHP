<?php
class TipoResiduo {
    private $connect;
    private $table = "tipo_residuos";

    public $id_tipo_residuo;
    public $nombre_residuo;
    public $descripcion;

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
        $query = "INSERT INTO " . $this->table . " (nombre_residuo, descripcion) VALUES (:nombre_residuo, :descripcion)";
        $stmt = $this->connect->prepare($query);

        $stmt->bindParam(":nombre_residuo", $this->nombre_residuo);
        $stmt->bindParam(":descripcion", $this->descripcion);

        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table . " SET nombre_residuo = :nombre_residuo, descripcion = :descripcion WHERE id_tipo_residuo = :id_tipo_residuo";
        $stmt = $this->connect->prepare($query);

        $stmt->bindParam(":nombre_residuo", $this->nombre_residuo);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":id_tipo_residuo", $this->id_tipo_residuo);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_tipo_residuo = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>
