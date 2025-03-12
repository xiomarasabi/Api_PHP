<?php
require_once 'config/database.php';
require_once 'models/Programacion.php';

class ProgramacionController {
    private $db;
    private $programacion;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->programacion = new Programacion($this->db);
    }

    public function getAll() {
        $stmt = $this->programacion->getAll();
        $programaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => "200", "data" => $programaciones]);
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['duracion'], $data['estado'], $data['fecha_programada'], $data['fk_id_asignacion_actividad'], $data['fk_id_calendario_lunar'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->programacion->duracion = $data['duracion'];
        $this->programacion->estado = $data['estado'];
        $this->programacion->fecha_programada = $data['fecha_programada'];
        $this->programacion->fk_id_asignacion_actividad = $data['fk_id_asignacion_actividad'];
        $this->programacion->fk_id_calendario_lunar = $data['fk_id_calendario_lunar'];

        if ($this->programacion->create()) {
            echo json_encode(["status" => "201", "message" => "Programación creada correctamente"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al crear la programación"]);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['duracion'], $data['estado'], $data['fecha_programada'], $data['fk_id_asignacion_actividad'], $data['fk_id_calendario_lunar'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->programacion->id_programacion = $id;
        $this->programacion->duracion = $data['duracion'];
        $this->programacion->estado = $data['estado'];
        $this->programacion->fecha_programada = $data['fecha_programada'];
        $this->programacion->fk_id_asignacion_actividad = $data['fk_id_asignacion_actividad'];
        $this->programacion->fk_id_calendario_lunar = $data['fk_id_calendario_lunar'];

        if ($this->programacion->update()) {
            echo json_encode(["status" => "200", "message" => "Programación actualizada correctamente"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al actualizar la programación"]);
        }
    }

    public function delete($id) {
        if ($this->programacion->delete($id)) {
            echo json_encode(["status" => "200", "message" => "Programación eliminada correctamente"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al eliminar la programación"]);
        }
    }
}
?>
