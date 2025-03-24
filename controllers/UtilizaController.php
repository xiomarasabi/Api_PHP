<?php
require_once 'config/database.php';
require_once 'models/Utiliza.php';

class UtilizaController {
    private $db;
    private $utiliza;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->utiliza = new Utiliza($this->db);
    }

    public function getAll() {
        $stmt = $this->utiliza->getAll();
        $utiliza = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => "200", "data" => $utiliza]);
    }

    public function create() {
        $input = json_decode(file_get_contents("php://input"), true);
        
        if (!isset($input['fk_id_asignacion_actividad']) || !isset($input['fk_id_insumo'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            return;
        }

        $this->utiliza->fk_id_asignacion_actividad = $input['fk_id_asignacion_actividad'];
        $this->utiliza->fk_id_insumo = $input['fk_id_insumo'];

        if ($this->utiliza->create()) {
            echo json_encode(["message" => "Registro creado exitosamente"]);
        } else {
            echo json_encode(["message" => "Error al crear el registro"]);
        }
    }
    public function getById($id_utiliza) {
        $result = $this->utiliza->getById($id_utiliza);
        echo json_encode($result);
    }

    public function patch($id_utiliza) {
        $data = json_decode(file_get_contents("php://input"), true);

        if ($this->utiliza->patch($id_utiliza, $data)) {
            echo json_encode(["message" => "Registro actualizado correctamente"]);
        } else {
            echo json_encode(["error" => "Error al actualizar el registro"]);
        }
    }

    
    public function update($id) {
        $input = json_decode(file_get_contents("php://input"), true);
        
        if (!isset($input['fk_id_asignacion_actividad']) || !isset($input['fk_id_insumo'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            return;
        }

        $this->utiliza->id_utiliza = $id;
        $this->utiliza->fk_id_asignacion_actividad = $input['fk_id_asignacion_actividad'];
        $this->utiliza->fk_id_insumo = $input['fk_id_insumo'];

        if ($this->utiliza->update()) {
            echo json_encode(["message" => "Registro actualizado exitosamente"]);
        } else {
            echo json_encode(["message" => "Error al actualizar el registro"]);
        }
    }

    
    public function delete($id) {
        if ($this->utiliza->delete($id)) {
            echo json_encode(["message" => "Registro eliminado exitosamente"]);
        } else {
            echo json_encode(["message" => "Error al eliminar el registro"]);
        }
    }
}
?>
