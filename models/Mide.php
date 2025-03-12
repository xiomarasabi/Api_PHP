<?php
class Mide {
    private $connect;
    private $table = "mide";

    public $id_mide;
    public $fk_id_sensor;
    public $fk_id_era;

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
        $query = "INSERT INTO " . $this->table . " (fk_id_sensor, fk_id_era) VALUES (:fk_id_sensor, :fk_id_era)";
        $stmt = $this->connect->prepare($query);

        $stmt->bindParam(":fk_id_sensor", $this->fk_id_sensor);
        $stmt->bindParam(":fk_id_era", $this->fk_id_era);

        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table . " SET fk_id_sensor = :fk_id_sensor, fk_id_era = :fk_id_era WHERE id_mide = :id_mide";
        $stmt = $this->connect->prepare($query);

        $stmt->bindParam(":fk_id_sensor", $this->fk_id_sensor);
        $stmt->bindParam(":fk_id_era", $this->fk_id_era);
        $stmt->bindParam(":id_mide", $this->id_mide);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_mide = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>
