<?php
class Venta {
    private $connect;
    private $table = "venta";

    public $id_venta;
    public $fk_id_produccion;
    public $cantidad;
    public $precio_unitario;
    public $total_venta;
    public $fecha_venta;

    public function __construct($db) {
        $this->connect = $db;
    }

    public function getAll() {
        $query = "SELECT venta.*, produccion.descripcion_produccion 
                  FROM " . $this->table . " 
                  INNER JOIN produccion ON venta.fk_id_produccion = produccion.id_produccion";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (fk_id_produccion, cantidad, precio_unitario, total_venta, fecha_venta) 
                  VALUES (:fk_id_produccion, :cantidad, :precio_unitario, :total_venta, :fecha_venta)";

        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":fk_id_produccion", $this->fk_id_produccion, PDO::PARAM_INT);
        $stmt->bindParam(":cantidad", $this->cantidad, PDO::PARAM_INT);
        $stmt->bindParam(":precio_unitario", $this->precio_unitario, PDO::PARAM_INT);
        $stmt->bindParam(":total_venta", $this->total_venta, PDO::PARAM_INT);
        $stmt->bindParam(":fecha_venta", $this->fecha_venta);

        return $stmt->execute();
    }
    public function getById($id_venta) {
        $query = "SELECT venta.*, produccion.descripcion_produccion 
                  FROM " . $this->table . " 
                  INNER JOIN produccion ON venta.fk_id_produccion = produccion.id_produccion
                  WHERE venta.id_venta = :id_venta LIMIT 1";

        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id_venta", $id_venta, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function patch($id_venta, $data) {
        if (empty($data)) {
            return false;
        }

        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }

        $query = "UPDATE " . $this->table . " SET " . implode(", ", $fields) . " WHERE id_venta = :id_venta";
        $stmt = $this->connect->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->bindParam(":id_venta", $id_venta, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET cantidad = :cantidad, precio_unitario = :precio_unitario, total_venta = :total_venta, fecha_venta = :fecha_venta 
                  WHERE id_venta = :id_venta";

        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id_venta", $this->id_venta, PDO::PARAM_INT);
        $stmt->bindParam(":cantidad", $this->cantidad, PDO::PARAM_INT);
        $stmt->bindParam(":precio_unitario", $this->precio_unitario, PDO::PARAM_INT);
        $stmt->bindParam(":total_venta", $this->total_venta, PDO::PARAM_INT);
        $stmt->bindParam(":fecha_venta", $this->fecha_venta);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_venta = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
