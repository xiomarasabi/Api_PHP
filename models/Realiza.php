<?php
class Realiza {
    private $connect;
    private $table = "realiza";

    public $id_realiza;
    public $fk_id_cultivo;
    public $fk_id_actividad;

    public function __construct($db) {
        $this->connect = $db;
    }

    public function getAll() {
        $query = "SELECT realiza.*, cultivo.nombre_cultivo, actividad.nombre_actividad 
                  FROM " . $this->table . " 
                  INNER JOIN cultivo ON realiza.fk_id_cultivo = cultivo.id_cultivo 
                  INNER JOIN actividad ON realiza.fk_id_actividad = actividad.id_actividad";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (fk_id_cultivo, fk_id_actividad) 
                  VALUES (:fk_id_cultivo, :fk_id_actividad)";
        
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":fk_id_cultivo", $this->fk_id_cultivo);
        $stmt->bindParam(":fk_id_actividad", $this->fk_id_actividad);

        return $stmt->execute();
    }
    public function getById($id) {
        $query = "SELECT realiza.*, cultivo.nombre_cultivo, actividad.nombre_actividad 
                  FROM " . $this->table . " 
                  INNER JOIN cultivo ON realiza.fk_id_cultivo = cultivo.id_cultivo 
                  INNER JOIN actividad ON realiza.fk_id_actividad = actividad.id_actividad
                  WHERE id_realiza = :id_realiza";

        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id_realiza", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   
    public function patch($id, $data) {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key"; 
        }

        $query = "UPDATE " . $this->table . " SET " . implode(", ", $fields) . " WHERE id_realiza = :id_realiza";
        $stmt = $this->connect->prepare($query);
        

        foreach ($data as $key => &$value) {
            $stmt->bindParam(":$key", $value);
        }

        $stmt->bindParam(":id_realiza", $id, PDO::PARAM_INT); 
        return $stmt->execute(); 
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET fk_id_cultivo = :fk_id_cultivo, 
                      fk_id_actividad = :fk_id_actividad
                  WHERE id_realiza = :id_realiza";

        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id_realiza", $this->id_realiza);
        $stmt->bindParam(":fk_id_cultivo", $this->fk_id_cultivo);
        $stmt->bindParam(":fk_id_actividad", $this->fk_id_actividad);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id_realiza = :id_realiza";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id_realiza", $this->id_realiza);
        return $stmt->execute();
    }
}
?>
