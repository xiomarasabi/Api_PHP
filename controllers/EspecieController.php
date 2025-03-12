<?php
require_once 'config/database.php';
require_once 'models/Especie.php';

class EspecieController {
    private $db;
    private $especie;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->especie = new Especie($this->db);
    }

    public function getAll() {
        $stmt = $this->especie->getAll();
        $especies = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => "200", "data" => $especies]);
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['nombre_comun'], $data['nombre_cientifico'], $data['descripcion'], $data['fk_id_tipo_cultivo'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->especie->nombre_comun = $data['nombre_comun'];
        $this->especie->nombre_cientifico = $data['nombre_cientifico'];
        $this->especie->descripcion = $data['descripcion'];
        $this->especie->fk_id_tipo_cultivo = $data['fk_id_tipo_cultivo'];

        if ($this->especie->create()) {
            echo json_encode(["status" => "201", "message" => "Especie creada"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al crear"]);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['nombre_comun'], $data['nombre_cientifico'], $data['descripcion'], $data['fk_id_tipo_cultivo'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->especie->id_especie = $id;
        $this->especie->nombre_comun = $data['nombre_comun'];
        $this->especie->nombre_cientifico = $data['nombre_cientifico'];
        $this->especie->descripcion = $data['descripcion'];
        $this->especie->fk_id_tipo_cultivo = $data['fk_id_tipo_cultivo'];

        if ($this->especie->update()) {
            echo json_encode(["status" => "200", "message" => "Especie actualizada"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al actualizar"]);
        }
    }

    public function delete($id) {
        if ($this->especie->delete($id)) {
            echo json_encode(["status" => "200", "message" => "Especie eliminada"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al eliminar"]);
        }
    }
}
?>
