<?php
require_once 'config/database.php';
require_once 'models/Insumos.php';

class InsumosController {
    private $db;
    private $insumos;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->insumos = new Insumos($this->db);
    }

    public function getAll() {
        $stmt = $this->insumos->getAll();
        $insumos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => "200", "data" => $insumos]);
    }
    public function getById($id) {
        $insumo = $this->insumos->getById($id);
        if ($insumo) {
            echo json_encode(["status" => "200", "data" => $insumo]);
        } else {
            echo json_encode(["status" => "404", "message" => "Insumo no encontrado"]);
        }
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['cantidad']) || !isset($data['nombre']) || !isset($data['precio_unidad']) || !isset($data['tipo']) || !isset($data['unidad_medida']))  {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->insumos->cantidad = $data['cantidad'];
        $this->insumos->nombre = $data['nombre'];
        $this->insumos->precio_unidad = $data['precio_unidad'];
        $this->insumos->tipo = $data['tipo'];
        $this->insumos->unidad_medida = $data['unidad_medida'];

        if ($this->insumos->create()) {
            echo json_encode(["status" => "201", "message" => "Insumo creado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al crear"]);
        }

    }
    public function patch($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($this->insumos->patch($id, $data)) {
            echo json_encode(["status" => "200", "message" => "Insumo actualizado parcialmente"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al actualizar parcialmente"]);
        }
    }
    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['cantidad']) || !isset($data['nombre']) || !isset($data['precio_unidad']) || !isset($data['tipo']) || !isset($data['unidad_medida']))  {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->insumos->cantidad = $data['cantidad'];
        $this->insumos->nombre = $data['nombre'];
        $this->insumos->precio_unidad = $data['precio_unidad'];
        $this->insumos->tipo = $data['tipo'];
        $this->insumos->unidad_medida = $data['unidad_medida'];

        if ($this->insumos->create()) {
            echo json_encode(["status" => "201", "message" => "Insumo actualizado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al actualizar"]);
        }

    }

    public function delete($id) {
        $query = "DELETE FROM insumos WHERE id_insumo = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            echo json_encode(["status" => "200", "message" => "Insumo eliminado correctamente"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "No se pudo eliminar el insumo"]);
        }
    }
}