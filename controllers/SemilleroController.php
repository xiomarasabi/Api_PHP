<?php
require_once 'config/database.php';
require_once 'models/Semillero.php';

class SemilleroController {
    private $db;
    private $semillero;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->semillero = new Semillero($this->db);
    }

    public function getAll() {
        $stmt = $this->semillero->getAll();
        $semilleros = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => "200", "data" => $semilleros]);
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['nombre_semilla'], $data['fecha_siembra'], $data['fecha_estimada'], $data['cantidad'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->semillero->nombre_semilla = $data['nombre_semilla'];
        $this->semillero->fecha_siembra = $data['fecha_siembra'];
        $this->semillero->fecha_estimada = $data['fecha_estimada'];
        $this->semillero->cantidad = $data['cantidad'];

        if ($this->semillero->create()) {
            echo json_encode(["status" => "201", "message" => "Semillero creado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al crear"]);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
    
        if (!isset($data['nombre_semilla'], $data['fecha_siembra'], $data['fecha_estimada'], $data['cantidad'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }
    
        $this->semillero->id_semillero = $id;
        $this->semillero->nombre_semilla = $data['nombre_semilla'];
        $this->semillero->fecha_siembra = $data['fecha_siembra'];
        $this->semillero->fecha_estimada = $data['fecha_estimada'];
        $this->semillero->cantidad = $data['cantidad'];
    
        if ($this->semillero->update()) {
            echo json_encode(["status" => "200", "message" => "Semillero actualizado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al actualizar"]);
        }
    }

    public function delete($id) {
        $query = "DELETE FROM semilleros WHERE id_semillero = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            echo json_encode(["status" => "200", "message" => "Semillero eliminado correctamente"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "No se pudo eliminar el semillero"]);
        }
    }
}
?>
