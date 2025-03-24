<?php
class Residuo {
    private $connect;
    private $table = "residuos";

    public $id_residuo;
    public $nombre;
    public $fecha;
    public $descripcion;
    public $fk_id_tipo_residuo;
    public $fk_id_cultivo;

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
        $query = "INSERT INTO " . $this->table . " (nombre, fecha, descripcion, fk_id_tipo_residuo, fk_id_cultivo) 
                  VALUES (:nombre, :fecha, :descripcion, :fk_id_tipo_residuo, :fk_id_cultivo)";
        $stmt = $this->connect->prepare($query);

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":fecha", $this->fecha);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":fk_id_tipo_residuo", $this->fk_id_tipo_residuo);
        $stmt->bindParam(":fk_id_cultivo", $this->fk_id_cultivo);

        return $stmt->execute();
    }
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_residuo = :id LIMIT 1";
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

        $query = "UPDATE " . $this->table . " SET " . implode(", ", $fields) . " WHERE id_residuo = :id";
        $stmt = $this->connect->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET nombre = :nombre, fecha = :fecha, descripcion = :descripcion, 
                      fk_id_tipo_residuo = :fk_id_tipo_residuo, fk_id_cultivo = :fk_id_cultivo 
                  WHERE id_residuo = :id_residuo";
        $stmt = $this->connect->prepare($query);

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":fecha", $this->fecha);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":fk_id_tipo_residuo", $this->fk_id_tipo_residuo);
        $stmt->bindParam(":fk_id_cultivo", $this->fk_id_cultivo);
        $stmt->bindParam(":id_residuo", $this->id_residuo);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_residuo = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>
