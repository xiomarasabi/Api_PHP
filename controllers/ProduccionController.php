<?php
require_once 'config/database.php';
require_once 'models/Produccion.php';

class ProduccionController {
    private $db;
    private $produccion;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->produccion = new Produccion($this->db);
    }

    public function getAll() {
        $stmt = $this->produccion->getAll();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => "200", "data" => $data]);
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!isset($data['fk_id_cultivo'], $data['cantidad_producida'], $data['fecha_produccion'], $data['fk_id_lote'], $data['estado'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->produccion->fk_id_cultivo = $data['fk_id_cultivo'];
        $this->produccion->cantidad_producida = $data['cantidad_producida'];
        $this->produccion->fecha_produccion = $data['fecha_produccion'];
        $this->produccion->fk_id_lote = $data['fk_id_lote'];
        $this->produccion->descripcion_produccion = $data['descripcion_produccion'] ?? null;
        $this->produccion->estado = $data['estado'];
        $this->produccion->fecha_cosecha = $data['fecha_cosecha'] ?? null;

        if ($this->produccion->create()) {
            echo json_encode(["status" => "201", "message" => "Producción registrada"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al registrar producción"]);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['fk_id_cultivo'], $data['cantidad_producida'], $data['fecha_produccion'], $data['fk_id_lote'], $data['estado'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->produccion->id_produccion = $id;
        $this->produccion->fk_id_cultivo = $data['fk_id_cultivo'];
        $this->produccion->cantidad_producida = $data['cantidad_producida'];
        $this->produccion->fecha_produccion = $data['fecha_produccion'];
        $this->produccion->fk_id_lote = $data['fk_id_lote'];
        $this->produccion->descripcion_produccion = $data['descripcion_produccion'] ?? null;
        $this->produccion->estado = $data['estado'];
        $this->produccion->fecha_cosecha = $data['fecha_cosecha'] ?? null;

        if ($this->produccion->update()) {
            echo json_encode(["status" => "200", "message" => "Producción actualizada"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al actualizar producción"]);
        }
    }

    public function delete($id) {
        $this->produccion->id_produccion = $id;

        if ($this->produccion->delete()) {
            echo json_encode(["status" => "200", "message" => "Producción eliminada"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "No se pudo eliminar la producción"]);
        }
    }
}
?>
