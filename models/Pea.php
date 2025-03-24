<?php
class Pea {
    private $connect;
    private $table = "PEA";

    public $id_pea;
    public $nombre;
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
        $query = "INSERT INTO " . $this->table . " (nombre, descripcion) VALUES (:nombre, :descripcion)";
        $stmt = $this->connect->prepare($query);

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":descripcion", $this->descripcion);

        return $stmt->execute();
    }
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_pea = :id LIMIT 1";
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

        $query = "UPDATE " . $this->table . " SET " . implode(", ", $fields) . " WHERE id_pea = :id";
        $stmt = $this->connect->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table . " SET nombre = :nombre, descripcion = :descripcion WHERE id_pea = :id_pea";
        $stmt = $this->connect->prepare($query);

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":id_pea", $this->id_pea);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_pea = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }
}
?>

