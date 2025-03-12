<?php
require_once 'config/database.php';
require_once 'models/CalendarioLunar.php';

class CalendarioLunarController {
    private $db;
    private $calendario_lunar;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->calendario_lunar = new CalendarioLunar($this->db);
    }

    public function getAll() {
        $stmt = $this->calendario_lunar->getAll();
        $calendario_lunar = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => "200", "data" => $calendario_lunar]);
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['descripcion_evento']) || !isset($data['evento']) || !isset($data['fecha'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->calendario_lunar->descripcion_evento = $data['descripcion_evento'];
        $this->calendario_lunar->evento = $data['evento'];
        $this->calendario_lunar->fecha = $data['fecha'];

        if ($this->calendario_lunar->create()) {
            echo json_encode(["status" => "201", "message" => "Calendario Lunar creado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al crear"]);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
    
        if (!isset($data['descripcion_evento']) || !isset($data['evento']) || !isset($data['fecha'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }
    
        $this->calendario_lunar->descripcion_evento = $data['descripcion_evento'];
        $this->calendario_lunar->evento = $data['evento'];
        $this->calendario_lunar->fecha = $data['fecha'];
    
        if ($this->calendario_lunar->update()) {
            echo json_encode(["status" => "200", "message" => "Calendario lunar actualizado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al actualizar"]);
        }
    }    

    public function delete($id) {
        $query = "DELETE FROM calendario_lunar WHERE id_calendario_lunar = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            echo json_encode(["status" => "200", "message" => "Calendario lunar eliminado correctamente"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "No se pudo eliminar el calendario lunar"]);
        }
    }

}
?>