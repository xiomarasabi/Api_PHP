<?php
class Utiliza {
    private $connect;
    private $table = "utiliza";

    public $id_utiliza;
    public $fk_id_asignacion_actividad;
    public $fk_id_insumo;

    public function __construct($db) {
        $this->connect = $db;
    }

    public function getAll() {
        $query = "SELECT utiliza.*, insumos.nombre, insumos.tipo, insumos.precio_unidad, insumos.cantidad, insumos.unidad_medida 
                  FROM " . $this->table . " 
                  INNER JOIN insumos ON utiliza.fk_id_insumo = insumos.id_insumo";
        
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (fk_id_asignacion_actividad, fk_id_insumo) 
                  VALUES (:fk_id_asignacion_actividad, :fk_id_insumo)";

        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":fk_id_asignacion_actividad", $this->fk_id_asignacion_actividad);
        $stmt->bindParam(":fk_id_insumo", $this->fk_id_insumo);

        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET fk_id_asignacion_actividad = :fk_id_asignacion_actividad, fk_id_insumo = :fk_id_insumo 
                  WHERE id_utiliza = :id_utiliza";

        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":fk_id_asignacion_actividad", $this->fk_id_asignacion_actividad);
        $stmt->bindParam(":fk_id_insumo", $this->fk_id_insumo);
        $stmt->bindParam(":id_utiliza", $this->id_utiliza);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_utiliza = :id";

        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }
}
?>
