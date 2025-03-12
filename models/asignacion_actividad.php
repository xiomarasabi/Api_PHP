<?php
class AsignacionActividad {
    private $connect;
    private $table = "asignacion_actividad";

    public $fecha;
    public $fk_identificacion;
    public $fk_id_actividad;
    public $id_asignacion_actividad;

    public function __construct($db) {
        $this->connect = $db;
    }

    public function getAll() {
        $query = "SELECT asignacion_actividad.*, Usuarios.nombre, actividad.nombre_actividad FROM " . $this->table . " INNER JOIN usuarios ON asignacion_actividad.fk_identificacion = usuarios.identificacion INNER JOIN actividad ON asignacion_actividad.fk_id_actividad = actividad.id_actividad"; 
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (fecha, fk_identificacion, fk_id_actividad) VALUES (:fecha, :fk_identificacion, :fk_id_actividad)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":fecha", $this->fecha);
        $stmt->bindParam(":fk_identificacion", $this->fk_identificacion);
        $stmt->bindParam(":fk_id_actividad", $this->fk_id_actividad);
        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE asignacion_actividad SET fecha = :fecha, fk_identificacion = :fk_identificacion, fk_id_actividad = :fk_id_actividad " . "WHERE id_asignacion_actividad = :id_asignacion_actividad";
        
        $stmt = $this->connect->prepare($query);
        
        $stmt->bindParam(":fecha", $this->fecha);
        $stmt->bindParam(":fk_identificacion", $this->fk_identificacion);
        $stmt->bindParam(":fk_id_actividad", $this->fk_id_actividad);
        $stmt->bindParam(":id_asignacion_actividad", $this->id_asignacion_actividad); 

        return $stmt->execute();
    }
    
    public function delete($id) {
        $query = "DELETE FROM asignacion_actividad WHERE id_asignacion_actividad = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
}

    
}
?>