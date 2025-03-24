<?php
require_once 'config/database.php';
require_once 'models/Genera.php';

class GeneraController {
    private $db;
    private $genera;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->genera = new Genera($this->db);
    }

    public function getAll() {
        $stmt = $this->genera->getAll();
        $genera = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => "200", "data" => $genera]);
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['fk_id_cultivo'], $data['fk_id_produccion'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->genera->fk_id_cultivo = $data['fk_id_cultivo'];
        $this->genera->fk_id_produccion = $data['fk_id_produccion'];

        if ($this->genera->create()) {
            echo json_encode(["status" => "201", "message" => "Registro creado en genera"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al crear registro"]);
        }
    }
    public function getById($id) {
        $stmt = $this->genera->getById($id);
        $genera = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($genera) {
            echo json_encode(["status" => "200", "data" => $genera]);
        } else {
            echo json_encode(["status" => "Error", "message" => "No se encontró el registro"]);
        }
    }
    
    public function patch($id) {
        $data = json_decode(file_get_contents("php://input"), true);
    
        if ($this->genera->patch($id, $data)) {
            echo json_encode(["status" => "200", "message" => "Registro actualizado parcialmente"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al actualizar parcialmente"]);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
    
        if (!isset($data['fk_id_cultivo'], $data['fk_id_produccion'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }
    
        $this->genera->id_genera = $id;
        $this->genera->fk_id_cultivo = $data['fk_id_cultivo'];
        $this->genera->fk_id_produccion = $data['fk_id_produccion'];
    
        if ($this->genera->update()) {
            echo json_encode(["status" => "200", "message" => "Registro actualizado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al actualizar"]);
        }
    }    

    public function delete($id) {
        $query = "DELETE FROM genera WHERE id_genera = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            echo json_encode(["status" => "200", "message" => "Registro eliminado correctamente"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "No se pudo eliminar el registro"]);
        }
    }
}
?>
