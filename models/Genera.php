<?php
class Genera {
    private $connect;
    private $table = "genera";

    public $id_genera;
    public $fk_id_cultivo;
    public $fk_id_produccion;

    public function __construct($db) {
        $this->connect = $db;
    }

    public function getAll() {
        $query = "SELECT genera.*, cultivo.nombre_cultivo, produccion.descripcion_produccion 
                  FROM " . $this->table . " 
                  INNER JOIN cultivo ON genera.fk_id_cultivo = cultivo.id_cultivo
                  INNER JOIN produccion ON genera.fk_id_produccion = produccion.id_produccion";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (fk_id_cultivo, fk_id_produccion) 
                  VALUES (:fk_id_cultivo, :fk_id_produccion)";

        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":fk_id_cultivo", $this->fk_id_cultivo, PDO::PARAM_INT);
        $stmt->bindParam(":fk_id_produccion", $this->fk_id_produccion, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET fk_id_cultivo = :fk_id_cultivo, fk_id_produccion = :fk_id_produccion
                  WHERE id_genera = :id_genera";

        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id_genera", $this->id_genera, PDO::PARAM_INT);
        $stmt->bindParam(":fk_id_cultivo", $this->fk_id_cultivo, PDO::PARAM_INT);
        $stmt->bindParam(":fk_id_produccion", $this->fk_id_produccion, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_genera = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
