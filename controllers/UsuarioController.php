<?php
require_once 'config/database.php';
require_once 'models/Usuario.php';

class UsuarioController {
    private $db;
    private $usuario;
   

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->usuario = new Usuario($this->db);
    }

    public function getAll() {
        $stmt = $this->usuario->getAll();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => "200", "data" => $usuarios]);
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['identificacion'], $data['nombre'], $data['contrasena'], $data['email'], $data['fk_id_rol'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }

        $this->usuario->identificacion = $data['identificacion'];
        $this->usuario->nombre = $data['nombre'];
        $this->usuario->contrasena = password_hash($data['contrasena'], PASSWORD_DEFAULT); // Hash de contraseña
        $this->usuario->email = $data['email'];
        $this->usuario->fk_id_rol = $data['fk_id_rol'];

        if ($this->usuario->create()) {
            echo json_encode(["status" => "201", "message" => "Usuario creado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al crear"]);
        }
    }
    public function getById($identificacion) {
        $result = $this->usuario->getById($identificacion);
        echo json_encode($result);
    }

    public function patch($identificacion) {
        $data = json_decode(file_get_contents("php://input"), true);

        if ($this->usuario->patch($identificacion, $data)) {
            echo json_encode(["message" => "Usuario actualizado correctamente"]);
        } else {
            echo json_encode(["error" => "Error al actualizar el usuario"]);
        }
    }

    
    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        
        
        if (!isset($data['nombre'], $data['email'], $data['fk_id_rol'])) {
            echo json_encode(["status" => "Error", "message" => "Datos incompletos"]);
            return;
        }
        
        $this->usuario->identificacion = $id; 
        $this->usuario->nombre = $data['nombre'];
        $this->usuario->email = $data['email'];
        $this->usuario->fk_id_rol = $data['fk_id_rol'];
    
        if (!empty($data['contrasena'])) {
            $this->usuario->contrasena = password_hash($data['contrasena'], PASSWORD_DEFAULT);
        }
    
        if ($this->usuario->update()) {
            echo json_encode(["status" => "200", "message" => "Usuario actualizado"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Error al actualizar"]);
        }
    }
    
    public function delete($id) {
        $query = "DELETE FROM usuarios WHERE identificacion = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            echo json_encode(["status" => "200", "message" => "Usuario eliminado correctamente"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "No se pudo eliminar el usuario"]);
        }
    }
    
}
