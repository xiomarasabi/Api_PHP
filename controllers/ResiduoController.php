<?php
require_once 'config/database.php';
require_once 'models/Residuo.php';

class ResiduoController {
    private $db;
    private $residuo;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->residuo = new Residuo($this->db);
    }

    public function getAll() {
        $stmt = $this->residuo->getAll();
        $residuos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => "200", "data" => $residuos]);
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['nombre'], $data['fecha'], $data['descripcion'], $data['fk_id_tipo_residuo'], $data['fk_id_cultivo'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->residuo->nombre = $data['nombre'];
        $this->residuo->fecha = $data['fecha'];
        $this->residuo->descripcion = $data['descripcion'];
        $this->residuo->fk_id_tipo_residuo = $data['fk_id_tipo_residuo'];
        $this->residuo->fk_id_cultivo = $data['fk_id_cultivo'];

        if ($this->residuo->create()) {
            echo json_encode(["status" => "201", "message" => "Residuo creado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al crear"]);
        }
    }
    public function getById($id) {
        $result = $this->residuo->getById($id);
        echo json_encode($result);
    }

    public function patch($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        if ($this->residuo->patch($id, $data)) {
            echo json_encode(["message" => "Registro actualizado correctamente"]);
        } else {
            echo json_encode(["error" => "Error al actualizar el registro"]);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['nombre'], $data['fecha'], $data['descripcion'], $data['fk_id_tipo_residuo'], $data['fk_id_cultivo'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->residuo->id_residuo = $id;
        $this->residuo->nombre = $data['nombre'];
        $this->residuo->fecha = $data['fecha'];
        $this->residuo->descripcion = $data['descripcion'];
        $this->residuo->fk_id_tipo_residuo = $data['fk_id_tipo_residuo'];
        $this->residuo->fk_id_cultivo = $data['fk_id_cultivo'];

        if ($this->residuo->update()) {
            echo json_encode(["status" => "200", "message" => "Residuo actualizado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al actualizar"]);
        }
    }

    public function delete($id) {
        if ($this->residuo->delete($id)) {
            echo json_encode(["status" => "200", "message" => "Residuo eliminado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al eliminar"]);
        }
    }
}
?>
