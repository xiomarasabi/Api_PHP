<?php
require_once 'config/database.php';
require_once 'models/Rol.php';

class RolController {
    private $db;
    private $rol;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->rol = new Rol($this->db);
    }
    public function getAll() {
        $stmt = $this->rol->getAll();
        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => "200", "data" => $roles]);
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['nombre_rol']) || !isset($data['fecha_creacion'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->rol->nombre_rol = $data['nombre_rol'];
        $this->rol->fecha_creacion = $data['fecha_creacion'];

        if ($this->rol->create()) {
            echo json_encode(["status" => "201", "message" => "Rol creado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al crear"]);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
    
        if (!isset($data['nombre_rol'], $data['fecha_creacion'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }
    
        $this->rol->id_rol = $id;
        $this->rol->nombre_rol = $data['nombre_rol'];
        $this->rol->fecha_creacion = $data['fecha_creacion'];
    
        if ($this->rol->update()) {
            echo json_encode(["status" => "200", "message" => "Rol actualizado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al actualizar"]);
        }
    }    

    public function delete($id) {
        $query = "DELETE FROM rol WHERE id_rol = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            echo json_encode(["status" => "200", "message" => "rol eliminado correctamente"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "No se pudo eliminar el rol"]);
        }
    }

}
?>
