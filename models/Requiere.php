<?php
class Requiere {
    private $connect;
    private $table = "requiere";

    public $id_requiere;
    public $fk_id_asignacion_actividad;
    public $fk_id_herramienta;

    public function __construct($db) {
        $this->connect = $db;
    }

    public function getAll() {
        $query = "SELECT r.*, h.nombre_h 
                  FROM " . $this->table . " r
                  INNER JOIN herramientas h ON r.fk_id_herramienta = h.id_herramienta";
        
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (fk_id_asignacion_actividad, fk_id_herramienta) 
                  VALUES (:fk_id_asignacion_actividad, :fk_id_herramienta)";

        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":fk_id_asignacion_actividad", $this->fk_id_asignacion_actividad);
        $stmt->bindParam(":fk_id_herramienta", $this->fk_id_herramienta);

        return $stmt->execute();
    }
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_requiere = :id ";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function patch($id, $data) {
        if (empty($data)) {
            return false;
        }
    
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }
    
        $query = "UPDATE " . $this->table . " SET " . implode(", ", $fields) . " WHERE id_requiere = :id";
        $stmt = $this->connect->prepare($query);
    
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
    
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET fk_id_asignacion_actividad = :fk_id_asignacion_actividad, fk_id_herramienta = :fk_id_herramienta 
                  WHERE id_requiere = :id_requiere";

        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":fk_id_asignacion_actividad", $this->fk_id_asignacion_actividad);
        $stmt->bindParam(":fk_id_herramienta", $this->fk_id_herramienta);
        $stmt->bindParam(":id_requiere", $this->id_requiere);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_requiere = :id";

        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }
}
?>



