<?php
class Rol {
    private $connect;
    private $table = "Rol";

    public $id_rol;
    public $nombre_rol;
    public $fecha_creacion;

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
        $query = "INSERT INTO " . $this->table . " (nombre_rol, fecha_creacion) VALUES (:nombre_rol, :fecha_creacion)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":nombre_rol", $this->nombre_rol);
        $stmt->bindParam(":fecha_creacion", $this->fecha_creacion);
        return $stmt->execute();
    }
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_rol = :id ";
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

        $query = "UPDATE " . $this->table . " SET " . implode(", ", $fields) . " WHERE id_rol = :id";
        $stmt = $this->connect->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE Rol SET nombre_rol = :nombre_rol, fecha_creacion = :fecha_creacion WHERE id_rol = :id_rol";
        
        $stmt = $this->connect->prepare($query);
        
        $stmt->bindParam(":id_rol", $this->id_rol, PDO::PARAM_INT);
        $stmt->bindParam(":nombre_rol", $this->nombre_rol);
        $stmt->bindParam(":fecha_creacion", $this->fecha_creacion);
        
        return $stmt->execute();
    }
    
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_rol = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>
