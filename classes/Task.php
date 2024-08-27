<?php
class Task {
    private $conn;
    private $table_name = "tasks";

    public $id;
    public $project_id;
    public $task_name;
    public $description;
    public $status;
    public $due_date;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    function create() {
        $query = "INSERT INTO " . $this->table_name . " SET task_name=:task_name, description=:description, project_id=:project_id, status=:status, due_date=:due_date";
        $stmt = $this->conn->prepare($query);

        $this->task_name = htmlspecialchars(strip_tags($this->task_name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->due_date = htmlspecialchars(strip_tags($this->due_date));
        $this->project_id = htmlspecialchars(strip_tags($this->project_id));

        $stmt->bindParam(':task_name', $this->task_name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':due_date', $this->due_date);
        $stmt->bindParam(':project_id', $this->project_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE project_id = :project_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':project_id', $this->project_id);
        $stmt->execute();
        return $stmt;
    }

    function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE task_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->task_name = $row['task_name'];
        $this->description = $row['description'];
        $this->status = $row['status'];
        $this->due_date = $row['due_date'];
        $this->created_at = $row['created_at'];
        $this->updated_at = $row['updated_at'];
    }

    function update() {
        $query = "UPDATE " . $this->table_name . "
                  SET task_name = :task_name, description = :description, status = :status, due_date = :due_date
                  WHERE task_id = :id";

        $stmt = $this->conn->prepare($query);

        $this->task_name = htmlspecialchars(strip_tags($this->task_name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->due_date = htmlspecialchars(strip_tags($this->due_date));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':task_name', $this->task_name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':due_date', $this->due_date);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE task_id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
