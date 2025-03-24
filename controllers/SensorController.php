<?php
require_once 'config/database.php';
require_once 'models/Sensor.php';

class SensorController {
    private $db;
    private $sensor;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->sensor = new Sensor($this->db);
    }

    public function getAll() {
        $stmt = $this->sensor->getAll();
        $sensores = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => "200", "data" => $sensores]);
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['nombre_sensor'], $data['tipo_sensor'], $data['unidad_medida'], $data['descripcion'], $data['medida_minima'], $data['medida_maxima'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->sensor->nombre_sensor = $data['nombre_sensor'];
        $this->sensor->tipo_sensor = $data['tipo_sensor'];
        $this->sensor->unidad_medida = $data['unidad_medida'];
        $this->sensor->descripcion = $data['descripcion'];
        $this->sensor->medida_minima = $data['medida_minima'];
        $this->sensor->medida_maxima = $data['medida_maxima'];

        if ($this->sensor->create()) {
            echo json_encode(["status" => "201", "message" => "Sensor creado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al crear"]);
        }
    }
    public function getById($id) {
        $result = $this->sensor->getById($id);
        echo json_encode($result);
    }

    public function patch($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        if ($this->sensor->patch($id, $data)) {
            echo json_encode(["message" => "Sensor actualizado correctamente"]);
        } else {
            echo json_encode(["error" => "Error al actualizar el sensor"]);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['nombre_sensor'], $data['tipo_sensor'], $data['unidad_medida'], $data['descripcion'], $data['medida_minima'], $data['medida_maxima'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->sensor->id_sensor = $id;
        $this->sensor->nombre_sensor = $data['nombre_sensor'];
        $this->sensor->tipo_sensor = $data['tipo_sensor'];
        $this->sensor->unidad_medida = $data['unidad_medida'];
        $this->sensor->descripcion = $data['descripcion'];
        $this->sensor->medida_minima = $data['medida_minima'];
        $this->sensor->medida_maxima = $data['medida_maxima'];

        if ($this->sensor->update()) {
            echo json_encode(["status" => "200", "message" => "Sensor actualizado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al actualizar"]);
        }
    }

    public function delete($id) {
        if ($this->sensor->delete($id)) {
            echo json_encode(["status" => "200", "message" => "Sensor eliminado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al eliminar"]);
        }
    }
}
?>
