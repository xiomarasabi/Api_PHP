<?php
class Sensor {
    private $connect;
    private $table = "sensores";

    public $id_sensor;
    public $nombre_sensor;
    public $tipo_sensor;
    public $unidad_medida;
    public $descripcion;
    public $medida_minima;
    public $medida_maxima;

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
        $query = "INSERT INTO " . $this->table . " (nombre_sensor, tipo_sensor, unidad_medida, descripcion, medida_minima, medida_maxima) 
                  VALUES (:nombre_sensor, :tipo_sensor, :unidad_medida, :descripcion, :medida_minima, :medida_maxima)";
        $stmt = $this->connect->prepare($query);

        $stmt->bindParam(":nombre_sensor", $this->nombre_sensor);
        $stmt->bindParam(":tipo_sensor", $this->tipo_sensor);
        $stmt->bindParam(":unidad_medida", $this->unidad_medida);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":medida_minima", $this->medida_minima);
        $stmt->bindParam(":medida_maxima", $this->medida_maxima);

        return $stmt->execute();
    }
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_sensor = :id LIMIT 1";
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

        $query = "UPDATE " . $this->table . " SET " . implode(", ", $fields) . " WHERE id_sensor = :id";
        $stmt = $this->connect->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET nombre_sensor = :nombre_sensor, tipo_sensor = :tipo_sensor, unidad_medida = :unidad_medida, 
                      descripcion = :descripcion, medida_minima = :medida_minima, medida_maxima = :medida_maxima 
                  WHERE id_sensor = :id_sensor";
        $stmt = $this->connect->prepare($query);

        $stmt->bindParam(":nombre_sensor", $this->nombre_sensor);
        $stmt->bindParam(":tipo_sensor", $this->tipo_sensor);
        $stmt->bindParam(":unidad_medida", $this->unidad_medida);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":medida_minima", $this->medida_minima);
        $stmt->bindParam(":medida_maxima", $this->medida_maxima);
        $stmt->bindParam(":id_sensor", $this->id_sensor);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_sensor = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>
