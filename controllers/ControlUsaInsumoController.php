<?php
require_once 'config/database.php';
require_once 'models/ControlUsaInsumo.php';

class ControlUsaInsumoController {
    private $db;
    private $controlUsaInsumo;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->controlUsaInsumo = new ControlUsaInsumo($this->db);
    }

    public function getAll() {
        $stmt = $this->controlUsaInsumo->getAll();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => "200", "data" => $data]);
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['fk_id_insumo'], $data['fk_id_control_fitosanitario'], $data['cantidad'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->controlUsaInsumo->fk_id_insumo = $data['fk_id_insumo'];
        $this->controlUsaInsumo->fk_id_control_fitosanitario = $data['fk_id_control_fitosanitario'];
        $this->controlUsaInsumo->cantidad = $data['cantidad'];

        if ($this->controlUsaInsumo->create()) {
            echo json_encode(["status" => "201", "message" => "Registro creado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al crear"]);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['fk_id_insumo'], $data['fk_id_control_fitosanitario'], $data['cantidad'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->controlUsaInsumo->id_control_usa_insumo = $id;
        $this->controlUsaInsumo->fk_id_insumo = $data['fk_id_insumo'];
        $this->controlUsaInsumo->fk_id_control_fitosanitario = $data['fk_id_control_fitosanitario'];
        $this->controlUsaInsumo->cantidad = $data['cantidad'];

        if ($this->controlUsaInsumo->update()) {
            echo json_encode(["status" => "200", "message" => "Registro actualizado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al actualizar"]);
        }
    }

    public function delete($id) {
        if ($this->controlUsaInsumo->delete($id)) {
            echo json_encode(["status" => "200", "message" => "Registro eliminado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al eliminar"]);
        }
    }
}
?>
