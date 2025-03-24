<?php
class Ubicacion {
    private $connect;
    private $table = "ubicacion";

    public $id_ubicacion;
    public $latitud;
    public $longitud;

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
        $query = "INSERT INTO " . $this->table . " (latitud, longitud) VALUES (:latitud, :longitud)";
        $stmt = $this->connect->prepare($query);

        $stmt->bindParam(":latitud", $this->latitud);
        $stmt->bindParam(":longitud", $this->longitud);

        return $stmt->execute();
    }
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_ubicacion = :id LIMIT 1";
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

        $query = "UPDATE " . $this->table . " SET " . implode(", ", $fields) . " WHERE id_ubicacion = :id";
        $stmt = $this->connect->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table . " SET latitud = :latitud, longitud = :longitud WHERE id_ubicacion = :id_ubicacion";
        $stmt = $this->connect->prepare($query);

        $stmt->bindParam(":latitud", $this->latitud);
        $stmt->bindParam(":longitud", $this->longitud);
        $stmt->bindParam(":id_ubicacion", $this->id_ubicacion);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_ubicacion = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }
}
?>
