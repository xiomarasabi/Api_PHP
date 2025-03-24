<?php
class Usuario {
    private $connect;
    private $table = "usuarios";

    public $identificacion;
    public $nombre;
    public $contrasena;
    public $email;
    public $fk_id_rol;

    public function __construct($db) {
        $this->connect = $db;
    }

    public function getAll() {
        $query = "SELECT usuarios.*, Rol.nombre_rol FROM " . $this->table . " INNER JOIN Rol ON usuarios.fk_id_rol = Rol.id_rol";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (identificacion, nombre, contrasena, email, fk_id_rol) VALUES (:identificacion, :nombre, :contrasena, :email, :fk_id_rol)";
        $stmt = $this->connect->prepare($query);
        $this->contrasena = password_hash($this->contrasena, PASSWORD_BCRYPT); 
        $stmt->bindParam(":identificacion", $this->identificacion);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":contrasena", $this->contrasena);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":fk_id_rol", $this->fk_id_rol);
        return $stmt->execute();
    }
    public function getById($identificacion) {
        $query = "SELECT usuarios.*, Rol.nombre_rol 
                  FROM " . $this->table . " 
                  INNER JOIN Rol ON usuarios.fk_id_rol = Rol.id_rol 
                  WHERE identificacion = :identificacion LIMIT 1";

        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":identificacion", $identificacion, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function patch($identificacion, $data) {
        if (empty($data)) {
            return false;
        }

        $fields = [];
        if (isset($data['contrasena']) && !empty($data['contrasena'])) {
            $data['contrasena'] = password_hash($data['contrasena'], PASSWORD_BCRYPT);
        }

        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }

        $query = "UPDATE " . $this->table . " SET " . implode(", ", $fields) . " WHERE identificacion = :identificacion";
        $stmt = $this->connect->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->bindParam(":identificacion", $identificacion, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE usuarios SET nombre = :nombre, email = :email, fk_id_rol = :fk_id_rol " .
                 (!empty($this->contrasena) ? ", contrasena = :contrasena " : "") .
                 "WHERE identificacion = :identificacion";
        
        $stmt = $this->connect->prepare($query);
        
        $stmt->bindParam(":identificacion", $this->identificacion);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":fk_id_rol", $this->fk_id_rol);
        
        if (!empty($this->contrasena)) {
            $stmt->bindParam(":contrasena", $this->contrasena);
        }
    
        return $stmt->execute();
    }
    
public function delete($id) {
    $query = "DELETE FROM usuarios WHERE identificacion = :id";
    $stmt = $this->connect->prepare($query);
    $stmt->bindParam(":identificacion", $this->identificacion);
    return $stmt->execute();
}

    
}
?>
