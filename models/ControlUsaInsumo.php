<?php
class ControlUsaInsumo {
    private $connect;
    private $table = "control_usa_insumo";

    public $id_control_usa_insumo;
    public $fk_id_insumo;
    public $fk_id_control_fitosanitario;
    public $cantidad;

    public function __construct($db) {
        $this->connect = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_control_usa_insumo = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (fk_id_insumo, fk_id_control_fitosanitario, cantidad) 
                  VALUES (:fk_id_insumo, :fk_id_control_fitosanitario, :cantidad)";
        $stmt = $this->connect->prepare($query);

        $stmt->bindParam(":fk_id_insumo", $this->fk_id_insumo);
        $stmt->bindParam(":fk_id_control_fitosanitario", $this->fk_id_control_fitosanitario);
        $stmt->bindParam(":cantidad", $this->cantidad);

        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET fk_id_insumo = :fk_id_insumo, 
                      fk_id_control_fitosanitario = :fk_id_control_fitosanitario, 
                      cantidad = :cantidad
                  WHERE id_control_usa_insumo = :id_control_usa_insumo";
        $stmt = $this->connect->prepare($query);

        $stmt->bindParam(":fk_id_insumo", $this->fk_id_insumo);
        $stmt->bindParam(":fk_id_control_fitosanitario", $this->fk_id_control_fitosanitario);
        $stmt->bindParam(":cantidad", $this->cantidad);
        $stmt->bindParam(":id_control_usa_insumo", $this->id_control_usa_insumo);

        return $stmt->execute();
    }
    public function patch($id, $data) {
        $setClause = [];
        $params = [];

        foreach ($data as $key => $value) {
            $setClause[] = "$key = :$key";
            $params[":$key"] = $value;
        }

        if (empty($setClause)) {
            return false;
        }

        $query = "UPDATE " . $this->table . " SET " . implode(", ", $setClause) . " WHERE id_calendario_lunar = :id";
        $stmt = $this->connect->prepare($query);
        $params[":id"] = $id;

        return $stmt->execute($params);
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_control_usa_insumo = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>
