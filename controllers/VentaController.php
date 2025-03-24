<?php
require_once 'config/database.php';
require_once 'models/Venta.php';

class VentaController {
    private $db;
    private $venta;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->venta = new Venta($this->db);
    }

    public function getAll() {
        $stmt = $this->venta->getAll();
        $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => "200", "data" => $ventas]);
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['fk_id_produccion'], $data['cantidad'], $data['precio_unitario'], $data['fecha_venta'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->venta->fk_id_produccion = $data['fk_id_produccion'];
        $this->venta->cantidad = $data['cantidad'];
        $this->venta->precio_unitario = $data['precio_unitario'];
        $this->venta->total_venta = $this->venta->cantidad * $this->venta->precio_unitario;
        $this->venta->fecha_venta = $data['fecha_venta'];

        if ($this->venta->create()) {
            echo json_encode(["status" => "201", "message" => "Venta registrada"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al registrar venta"]);
        }
    }
    public function getById($id_venta) {
        $result = $this->venta->getById($id_venta);
        echo json_encode($result);
    }

    public function patch($id_venta) {
        $data = json_decode(file_get_contents("php://input"), true);

        if ($this->venta->patch($id_venta, $data)) {
            echo json_encode(["message" => "Registro actualizado correctamente"]);
        } else {
            echo json_encode(["error" => "Error al actualizar el registro"]);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
    
        if (!isset($data['cantidad'], $data['precio_unitario'], $data['fecha_venta'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }
    
        $this->venta->id_venta = $id;
        $this->venta->cantidad = $data['cantidad'];
        $this->venta->precio_unitario = $data['precio_unitario'];
        $this->venta->total_venta = $this->venta->cantidad * $this->venta->precio_unitario;
        $this->venta->fecha_venta = $data['fecha_venta'];
    
        if ($this->venta->update()) {
            echo json_encode(["status" => "200", "message" => "Venta actualizada"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al actualizar venta"]);
        }
    }    

    public function delete($id) {
        $query = "DELETE FROM venta WHERE id_venta = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            echo json_encode(["status" => "200", "message" => "Venta eliminada correctamente"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "No se pudo eliminar la venta"]);
        }
    }
}
?>
