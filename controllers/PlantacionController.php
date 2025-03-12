<?php
require_once 'config/database.php';
require_once 'models/Plantacion.php';

class PlantacionController {
    private $db;
    private $plantacion;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->plantacion = new Plantacion($this->db);
    }

    public function getAll() {
        $stmt = $this->plantacion->getAll();
        $plantaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => "200", "data" => $plantaciones]);
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!isset($data['fk_id_cultivo'], $data['fk_id_era'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->plantacion->fk_id_cultivo = $data['fk_id_cultivo'];
        $this->plantacion->fk_id_era = $data['fk_id_era'];

        if ($this->plantacion->create()) {
            echo json_encode(["status" => "201", "message" => "Plantación creada"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al crear la plantación"]);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!isset($data['fk_id_cultivo'], $data['fk_id_era'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->plantacion->id_plantacion = $id;
        $this->plantacion->fk_id_cultivo = $data['fk_id_cultivo'];
        $this->plantacion->fk_id_era = $data['fk_id_era'];

        if ($this->plantacion->update()) {
            echo json_encode(["status" => "200", "message" => "Plantación actualizada"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al actualizar la plantación"]);
        }
    }

    public function delete($id) {
        $query = "DELETE FROM plantacion WHERE id_plantacion = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(["status" => "200", "message" => "Plantación eliminada correctamente"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "No se pudo eliminar la plantación"]);
        }
    }
}
?>
