<?php
class Programacion {
    private $connect;
    private $table = "programacion";

    public $id_programacion;
    public $duracion;
    public $estado;
    public $fecha_programada;
    public $fk_id_asignacion_actividad;
    public $fk_id_calendario_lunar;

    public function __construct($db) {
        $this->connect = $db;
    }

    public function getAll() {
        $query = "SELECT programacion.*, asignacion_actividad.fk_id_actividad, calendario_lunar.evento 
                  FROM " . $this->table . " 
                  INNER JOIN asignacion_actividad ON programacion.fk_id_asignacion_actividad = asignacion_actividad.id_asignacion_actividad 
                  INNER JOIN calendario_lunar ON programacion.fk_id_calendario_lunar = calendario_lunar.id_calendario_lunar";

        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (duracion, estado, fecha_programada, fk_id_asignacion_actividad, fk_id_calendario_lunar) 
                  VALUES (:duracion, :estado, :fecha_programada, :fk_id_asignacion_actividad, :fk_id_calendario_lunar)";

        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":duracion", $this->duracion);
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":fecha_programada", $this->fecha_programada);
        $stmt->bindParam(":fk_id_asignacion_actividad", $this->fk_id_asignacion_actividad);
        $stmt->bindParam(":fk_id_calendario_lunar", $this->fk_id_calendario_lunar);
        
        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE programacion 
                  SET duracion = :duracion, estado = :estado, fecha_programada = :fecha_programada, 
                      fk_id_asignacion_actividad = :fk_id_asignacion_actividad, fk_id_calendario_lunar = :fk_id_calendario_lunar 
                  WHERE id_programacion = :id_programacion";

        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id_programacion", $this->id_programacion);
        $stmt->bindParam(":duracion", $this->duracion);
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":fecha_programada", $this->fecha_programada);
        $stmt->bindParam(":fk_id_asignacion_actividad", $this->fk_id_asignacion_actividad);
        $stmt->bindParam(":fk_id_calendario_lunar", $this->fk_id_calendario_lunar);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM programacion WHERE id_programacion = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>
