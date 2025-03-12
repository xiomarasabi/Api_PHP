<?php
require_once 'config/database.php';
require_once 'models/Eras.php';

class ErasController {
    private $db;
    private $eras;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->eras = new Eras($this->db);
    }

    public function getAll() {
        $stmt = $this->eras->getAll();
        $eras = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => "200", "data" => $eras]);
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['descripcion'], $data['fk_id_lote'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->eras->descripcion = $data['descripcion'];
        $this->eras->fk_id_lote = $data['fk_id_lote'];

        if ($this->eras->create()) {
            echo json_encode(["status" => "201", "message" => "Era creada"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al crear la era"]);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['descripcion'], $data['fk_id_lote'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->eras->id_eras = $id;
        $this->eras->descripcion = $data['descripcion'];
        $this->eras->fk_id_lote = $data['fk_id_lote'];

        if ($this->eras->update()) {
            echo json_encode(["status" => "200", "message" => "Era actualizada"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al actualizar"]);
        }
    }

    public function delete($id) {
        if ($this->eras->delete($id)) {
            echo json_encode(["status" => "200", "message" => "Era eliminada correctamente"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "No se pudo eliminar la era"]);
        }
    }
}
?>
