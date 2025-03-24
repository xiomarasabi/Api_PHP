<?php
require_once 'config/database.php';
require_once 'models/TipoCultivo.php';

class TipoCultivoController {
    private $db;
    private $tipoCultivo;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->tipoCultivo = new TipoCultivo($this->db);
    }

    public function getAll() {
        $stmt = $this->tipoCultivo->getAll();
        $tiposCultivo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => "200", "data" => $tiposCultivo]);
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['nombre'], $data['descripcion'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->tipoCultivo->nombre = $data['nombre'];
        $this->tipoCultivo->descripcion = $data['descripcion'];

        if ($this->tipoCultivo->create()) {
            echo json_encode(["status" => "201", "message" => "Tipo de cultivo creado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al crear el tipo de cultivo"]);
        }
    }
    public function getById($id) {
        $result = $this->tipoCultivo->getById($id);
        echo json_encode($result);
    }

    public function patch($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        if ($this->tipoCultivo->patch($id, $data)) {
            echo json_encode(["message" => "Tipo de cultivo actualizado correctamente"]);
        } else {
            echo json_encode(["error" => "Error al actualizar el tipo de cultivo"]);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['nombre'], $data['descripcion'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->tipoCultivo->id_tipo_cultivo = $id;
        $this->tipoCultivo->nombre = $data['nombre'];
        $this->tipoCultivo->descripcion = $data['descripcion'];

        if ($this->tipoCultivo->update()) {
            echo json_encode(["status" => "200", "message" => "Tipo de cultivo actualizado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al actualizar"]);
        }
    }

    public function delete($id) {
        if ($this->tipoCultivo->delete($id)) {
            echo json_encode(["status" => "200", "message" => "Tipo de cultivo eliminado correctamente"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "No se pudo eliminar el tipo de cultivo"]);
        }
    }
}
?>
