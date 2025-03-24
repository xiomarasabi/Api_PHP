<?php
class Desarrollan {
    private $connect;
    private $table = "desarrollan";

    public $id_desarrollan;
    public $fk_id_cultivo;
    public $fk_id_pea;

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
        $query = "SELECT * FROM " . $this->table . " WHERE id_desarrollan = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (fk_id_cultivo, fk_id_pea) VALUES (:fk_id_cultivo, :fk_id_pea)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":fk_id_cultivo", $this->fk_id_cultivo, PDO::PARAM_INT);
        $stmt->bindParam(":fk_id_pea", $this->fk_id_pea, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table . " SET fk_id_cultivo = :fk_id_cultivo, fk_id_pea = :fk_id_pea WHERE id_desarrollan = :id_desarrollan";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id_desarrollan", $this->id_desarrollan, PDO::PARAM_INT);
        $stmt->bindParam(":fk_id_cultivo", $this->fk_id_cultivo, PDO::PARAM_INT);
        $stmt->bindParam(":fk_id_pea", $this->fk_id_pea, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function patch($id, $data) {
        $setClause = [];
        $params = [":id_desarrollan" => $id];

        if (isset($data['fk_id_cultivo'])) {
            $setClause[] = "fk_id_cultivo = :fk_id_cultivo";
            $params[":fk_id_cultivo"] = $data['fk_id_cultivo'];
        }
        if (isset($data['fk_id_pea'])) {
            $setClause[] = "fk_id_pea = :fk_id_pea";
            $params[":fk_id_pea"] = $data['fk_id_pea'];
        }

        if (empty($setClause)) {
            return false;
        }

        $query = "UPDATE " . $this->table . " SET " . implode(", ", $setClause) . " WHERE id_desarrollan = :id_desarrollan";
        $stmt = $this->connect->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id_desarrollan = :id_desarrollan";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id_desarrollan", $this->id_desarrollan, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
