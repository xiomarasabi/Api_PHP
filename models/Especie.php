<?php
class Especie {
    private $connect;
    private $table = "especie";

    public $id_especie;
    public $nombre_comun;
    public $nombre_cientifico;
    public $descripcion;
    public $fk_id_tipo_cultivo;

    public function __construct($db) {
        $this->connect = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_especie = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (nombre_comun, nombre_cientifico, descripcion, fk_id_tipo_cultivo) 
                  VALUES (:nombre_comun, :nombre_cientifico, :descripcion, :fk_id_tipo_cultivo)";
        $stmt = $this->connect->prepare($query);

        $stmt->bindParam(":nombre_comun", $this->nombre_comun);
        $stmt->bindParam(":nombre_cientifico", $this->nombre_cientifico);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":fk_id_tipo_cultivo", $this->fk_id_tipo_cultivo);

        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET nombre_comun = :nombre_comun, nombre_cientifico = :nombre_cientifico, 
                      descripcion = :descripcion, fk_id_tipo_cultivo = :fk_id_tipo_cultivo 
                  WHERE id_especie = :id_especie";
        $stmt = $this->connect->prepare($query);

        $stmt->bindParam(":nombre_comun", $this->nombre_comun);
        $stmt->bindParam(":nombre_cientifico", $this->nombre_cientifico);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":fk_id_tipo_cultivo", $this->fk_id_tipo_cultivo);
        $stmt->bindParam(":id_especie", $this->id_especie);

        return $stmt->execute();
    }
    public function patch($id, $data) {
        $query = "UPDATE " . $this->table . " SET ";
        $fields = [];

        if (isset($data['nombre_comun'])) {
            $fields[] = "nombre_comun = :nombre_comun";
        }
        if (isset($data['nombre_cientifico'])) {
            $fields[] = "nombre_cientifico = :nombre_cientifico";
        }
        if (isset($data['descripcion'])) {
            $fields[] = "descripcion = :descripcion";
        }
        if (isset($data['fk_id_tipo_cultivo'])) {
            $fields[] = "fk_id_tipo_cultivo = :fk_id_tipo_cultivo";
        }

        if (empty($fields)) {
            return false;
        }

        $query .= implode(", ", $fields) . " WHERE id_especie = :id";
        $stmt = $this->connect->prepare($query);

        if (isset($data['nombre_comun'])) {
            $stmt->bindParam(":nombre_comun", $data['nombre_comun']);
        }
        if (isset($data['nombre_cientifico'])) {
            $stmt->bindParam(":nombre_cientifico", $data['nombre_cientifico']);
        }
        if (isset($data['descripcion'])) {
            $stmt->bindParam(":descripcion", $data['descripcion']);
        }
        if (isset($data['fk_id_tipo_cultivo'])) {
            $stmt->bindParam(":fk_id_tipo_cultivo", $data['fk_id_tipo_cultivo']);
        }

        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_especie = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>
