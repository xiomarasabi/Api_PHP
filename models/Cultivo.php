<?php
class Cultivo {
    private $connect;
    private $table = "cultivo";

    public $id_cultivo;
    public $fecha_plantacion;
    public $nombre_cultivo;
    public $descripcion;
    public $fk_id_especie;
    public $fk_id_semillero;

    public function __construct($db) {
        $this->connect = $db;
    }

    public function getAll() {
        $query = "SELECT cultivo.*, especie.nombre_comun AS especie_nombre_comun, semilleros.nombre_semilla 
                  FROM " . $this->table . " 
                  INNER JOIN especie ON cultivo.fk_id_especie = especie.id_especie 
                  INNER JOIN semilleros ON cultivo.fk_id_semillero = semilleros.id_semillero";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_cultivo = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (fecha_plantacion, nombre_cultivo, descripcion, fk_id_especie, fk_id_semillero) 
                  VALUES (:fecha_plantacion, :nombre_cultivo, :descripcion, :fk_id_especie, :fk_id_semillero)";
        
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":fecha_plantacion", $this->fecha_plantacion);
        $stmt->bindParam(":nombre_cultivo", $this->nombre_cultivo);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":fk_id_especie", $this->fk_id_especie);
        $stmt->bindParam(":fk_id_semillero", $this->fk_id_semillero);

        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET fecha_plantacion = :fecha_plantacion, 
                      nombre_cultivo = :nombre_cultivo, 
                      descripcion = :descripcion, 
                      fk_id_especie = :fk_id_especie, 
                      fk_id_semillero = :fk_id_semillero
                  WHERE id_cultivo = :id_cultivo";

        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id_cultivo", $this->id_cultivo);
        $stmt->bindParam(":fecha_plantacion", $this->fecha_plantacion);
        $stmt->bindParam(":nombre_cultivo", $this->nombre_cultivo);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":fk_id_especie", $this->fk_id_especie);
        $stmt->bindParam(":fk_id_semillero", $this->fk_id_semillero);

        return $stmt->execute();
    }
    public function patch($id, $data) {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }

        $query = "UPDATE " . $this->table . " SET " . implode(", ", $fields) . " WHERE id_cultivo = :id";
        $stmt = $this->connect->prepare($query);

        foreach ($data as $key => &$value) {
            $stmt->bindParam(":$key", $value);
        }
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id_cultivo = :id_cultivo";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id_cultivo", $this->id_cultivo);
        return $stmt->execute();
    }
}
?>
