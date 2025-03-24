<?php
require_once 'config/database.php';
require_once 'models/Lote.php';

class LoteController {
    private $db;
    private $lote;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->lote = new Lote($this->db);
    }

    public function getAll() {
        $stmt = $this->lote->getAll();
        $lotes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => "200", "data" => $lotes]);
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['dimension'], $data['nombre_lote'], $data['fk_id_ubicacion'], $data['estado'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->lote->dimension = $data['dimension'];
        $this->lote->nombre_lote = $data['nombre_lote'];
        $this->lote->fk_id_ubicacion = $data['fk_id_ubicacion'];
        $this->lote->estado = $data['estado'];

        if ($this->lote->create()) {
            echo json_encode(["status" => "201", "message" => "Lote creado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al crear el lote"]);
        }
    }
    public function getById($id) {
        $lote = $this->lote->getById($id);
        if ($lote) {
            echo json_encode(["status" => "200", "data" => $lote]);
        } else {
            echo json_encode(["status" => "404", "message" => "Lote no encontrado"]);
        }
    }

    public function patch($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data || empty($data)) {
            echo json_encode(["status" => "400", "message" => "Datos incompletos"]);
            return;
        }

        if ($this->lote->patch($id, $data)) {
            echo json_encode(["status" => "200", "message" => "Lote actualizado correctamente"]);
        } else {
            echo json_encode(["status" => "500", "message" => "Error al actualizar el lote"]);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['dimension'], $data['nombre_lote'], $data['fk_id_ubicacion'], $data['estado'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->lote->id_lote = $id;
        $this->lote->dimension = $data['dimension'];
        $this->lote->nombre_lote = $data['nombre_lote'];
        $this->lote->fk_id_ubicacion = $data['fk_id_ubicacion'];
        $this->lote->estado = $data['estado'];

        if ($this->lote->update()) {
            echo json_encode(["status" => "200", "message" => "Lote actualizado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al actualizar"]);
        }
    }

    public function delete($id) {
        if ($this->lote->delete($id)) {
            echo json_encode(["status" => "200", "message" => "Lote eliminado correctamente"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "No se pudo eliminar el lote"]);
        }
    }
}
?>
