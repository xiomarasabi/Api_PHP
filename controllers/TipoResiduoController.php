<?php
require_once 'config/database.php';
require_once 'models/TipoResiduo.php';

class TipoResiduoController {
    private $db;
    private $tipoResiduo;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->tipoResiduo = new TipoResiduo($this->db);
    }

    public function getAll() {
        $stmt = $this->tipoResiduo->getAll();
        $tipoResiduos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => "200", "data" => $tipoResiduos]);
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['nombre_residuo'], $data['descripcion'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->tipoResiduo->nombre_residuo = $data['nombre_residuo'];
        $this->tipoResiduo->descripcion = $data['descripcion'];

        if ($this->tipoResiduo->create()) {
            echo json_encode(["status" => "201", "message" => "Tipo de residuo creado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al crear"]);
        }
    }
    public function getById($id) {
        $result = $this->tipoResiduo->getById($id);
        echo json_encode($result);
    }

    public function patch($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        if ($this->tipoResiduo->patch($id, $data)) {
            echo json_encode(["message" => "Tipo de residuo actualizado correctamente"]);
        } else {
            echo json_encode(["error" => "Error al actualizar el tipo de residuo"]);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['nombre_residuo'], $data['descripcion'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->tipoResiduo->id_tipo_residuo = $id;
        $this->tipoResiduo->nombre_residuo = $data['nombre_residuo'];
        $this->tipoResiduo->descripcion = $data['descripcion'];

        if ($this->tipoResiduo->update()) {
            echo json_encode(["status" => "200", "message" => "Tipo de residuo actualizado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al actualizar"]);
        }
    }

    public function delete($id) {
        if ($this->tipoResiduo->delete($id)) {
            echo json_encode(["status" => "200", "message" => "Tipo de residuo eliminado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al eliminar"]);
        }
    }
}
?>
