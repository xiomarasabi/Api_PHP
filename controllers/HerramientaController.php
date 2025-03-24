<?php
require_once 'config/database.php';
require_once 'models/Herramienta.php';

class HerramientaController {
    private $db;
    private $herramienta;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->herramienta = new Herramienta($this->db);
    }

    public function getAll() {
        $stmt = $this->herramienta->getAll();
        $herramientas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => "200", "data" => $herramientas]);
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['nombre_h'], $data['fecha_prestamo'], $data['estado'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->herramienta->nombre_h = $data['nombre_h'];
        $this->herramienta->fecha_prestamo = $data['fecha_prestamo'];
        $this->herramienta->estado = $data['estado'];

        if ($this->herramienta->create()) {
            echo json_encode(["status" => "201", "message" => "Herramienta creada"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al crear"]);
        }
    }
    public function getById($id) {
        $stmt = $this->herramienta->getById($id);
        $herramienta = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($herramienta) {
            echo json_encode(["status" => "200", "data" => $herramienta]);
        } else {
            echo json_encode(["status" => "Error", "message" => "No se encontró la herramienta"]);
        }
    }
    
    public function patch($id) {
        $data = json_decode(file_get_contents("php://input"), true);
    
        if ($this->herramienta->patch($id, $data)) {
            echo json_encode(["status" => "200", "message" => "Herramienta actualizada parcialmente"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al actualizar parcialmente"]);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['nombre_h'], $data['fecha_prestamo'], $data['estado'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->herramienta->id_herramienta = $id;
        $this->herramienta->nombre_h = $data['nombre_h'];
        $this->herramienta->fecha_prestamo = $data['fecha_prestamo'];
        $this->herramienta->estado = $data['estado'];

        if ($this->herramienta->update()) {
            echo json_encode(["status" => "200", "message" => "Herramienta actualizada"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al actualizar"]);
        }
    }

    public function delete($id) {
        $query = "DELETE FROM herramientas WHERE id_herramienta = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(["status" => "200", "message" => "Herramienta eliminada correctamente"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "No se pudo eliminar la herramienta"]);
        }
    }
}
?>
