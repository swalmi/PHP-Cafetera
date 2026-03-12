<?php
class Room
{
    private $db;
    private $table = "rooms";

    public $id;
    public $name;

    public function __construct($db)
    {
        $this->db = $db;
    }

    function save()
    {
        $query = "INSERT INTO " . $this->table . " (name) VALUES (:name)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":name", $this->name);
        return $stmt->execute();
    }

    function getAll()
    {
        $query = "SELECT * FROM " . $this->table . " ORDER BY name ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function getByName($name)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE name = :name";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function delete($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>
