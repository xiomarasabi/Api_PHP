<?php
require_once 'config/database.php';
require_once 'models/Ubicacion.php';

class UbicacionController {
    private $db;
    private $ubicacion;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->ubicacion = new Ubicacion($this->db);
    }

    public function getAll() {
        $stmt = $this->ubicacion->getAll();
        $ubicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => "200", "data" => $ubicaciones]);
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['latitud'], $data['longitud'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->ubicacion->latitud = $data['latitud'];
        $this->ubicacion->longitud = $data['longitud'];

        if ($this->ubicacion->create()) {
            echo json_encode(["status" => "201", "message" => "Ubicación creada"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al crear la ubicación"]);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['latitud'], $data['longitud'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->ubicacion->id_ubicacion = $id;
        $this->ubicacion->latitud = $data['latitud'];
        $this->ubicacion->longitud = $data['longitud'];

        if ($this->ubicacion->update()) {
            echo json_encode(["status" => "200", "message" => "Ubicación actualizada"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al actualizar"]);
        }
    }

    public function delete($id) {
        if ($this->ubicacion->delete($id)) {
            echo json_encode(["status" => "200", "message" => "Ubicación eliminada correctamente"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "No se pudo eliminar la ubicación"]);
        }
    }
}
?>
