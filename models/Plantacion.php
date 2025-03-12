<?php
class Plantacion {
    private $connect;
    private $table = "plantacion";

    public $id_plantacion;
    public $fk_id_cultivo;
    public $fk_id_era;

    public function __construct($db) {
        $this->connect = $db;
    }

    public function getAll() {
        $query = "SELECT plantacion.*, cultivo.nombre_cultivo, eras.descripcion 
                  FROM " . $this->table . " 
                  INNER JOIN cultivo ON plantacion.fk_id_cultivo = cultivo.id_cultivo 
                  INNER JOIN eras ON plantacion.fk_id_era = eras.id_eras";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (fk_id_cultivo, fk_id_era) 
                  VALUES (:fk_id_cultivo, :fk_id_era)";
        
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":fk_id_cultivo", $this->fk_id_cultivo);
        $stmt->bindParam(":fk_id_era", $this->fk_id_era);

        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET fk_id_cultivo = :fk_id_cultivo, 
                      fk_id_era = :fk_id_era
                  WHERE id_plantacion = :id_plantacion";

        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id_plantacion", $this->id_plantacion);
        $stmt->bindParam(":fk_id_cultivo", $this->fk_id_cultivo);
        $stmt->bindParam(":fk_id_era", $this->fk_id_era);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id_plantacion = :id_plantacion";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id_plantacion", $this->id_plantacion);
        return $stmt->execute();
    }
}
?>
