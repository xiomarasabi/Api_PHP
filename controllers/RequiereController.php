<?php
require_once 'config/database.php';
require_once 'models/Requiere.php';

class RequiereController {
    private $db;
    private $requiere;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->requiere = new Requiere($this->db);
    }

    public function getAll() {
        $stmt = $this->requiere->getAll();
        $requieres = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => "200", "data" => $requieres]);
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['fk_id_asignacion_actividad'], $data['fk_id_herramienta'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }
        $this->requiere->fk_id_asignacion_actividad = $data['fk_id_asignacion_actividad'];
        $this->requiere->fk_id_herramienta = $data['fk_id_herramienta'];

        if ($this->requiere->create()) {
            echo json_encode(["status" => "201", "message" => "Requiere registrado correctamente"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al registrar"]);
        }
    }
    public function getById($id) {
        $result = $this->requiere->getById($id); 
        if ($result) {
            echo json_encode(["success" => true, "data" => $result]); 
        } else {
            echo json_encode(["success" => false, "message" => "Registro no encontrado"]);
        }
    }

    public function patch($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        if ($this->requiere->patch($id, $data)) {
            echo json_encode(["message" => "Registro actualizado correctamente"]);
        } else {
            echo json_encode(["error" => "Error al actualizar el registro"]);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['fk_id_asignacion_actividad'], $data['fk_id_herramienta'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->requiere->id_requiere = $id;
        $this->requiere->fk_id_asignacion_actividad = $data['fk_id_asignacion_actividad'];
        $this->requiere->fk_id_herramienta = $data['fk_id_herramienta'];

        if ($this->requiere->update()) {
            echo json_encode(["status" => "200", "message" => "Requiere actualizado correctamente"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al actualizar"]);
        }
    }

    public function delete($id) {
        if ($this->requiere->delete($id)) {
            echo json_encode(["status" => "200", "message" => "Requiere eliminado correctamente"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "No se pudo eliminar"]);
        }
    }
}
?>

