<?php
require_once 'config/database.php';
require_once 'models/Realiza.php';

class RealizaController {
    private $db;
    private $realiza;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->realiza = new Realiza($this->db);
    }

    public function getAll() {
        $stmt = $this->realiza->getAll();
        $realiza = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => "200", "data" => $realiza]);
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!isset($data['fk_id_cultivo'], $data['fk_id_actividad'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->realiza->fk_id_cultivo = $data['fk_id_cultivo'];
        $this->realiza->fk_id_actividad = $data['fk_id_actividad'];

        if ($this->realiza->create()) {
            echo json_encode(["status" => "201", "message" => "Relación creada"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al crear la relación"]);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!isset($data['fk_id_cultivo'], $data['fk_id_actividad'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->realiza->id_realiza = $id;
        $this->realiza->fk_id_cultivo = $data['fk_id_cultivo'];
        $this->realiza->fk_id_actividad = $data['fk_id_actividad'];

        if ($this->realiza->update()) {
            echo json_encode(["status" => "200", "message" => "Relación actualizada"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al actualizar la relación"]);
        }
    }

    public function delete($id) {
        $query = "DELETE FROM realiza WHERE id_realiza = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(["status" => "200", "message" => "Relación eliminada correctamente"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "No se pudo eliminar la relación"]);
        }
    }
}
?>
