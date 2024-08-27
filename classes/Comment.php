<?php
class Comment {
    private $conn;
    private $table_name = "comments";

    public $id;
    public $task_id;
    public $user_id;
    public $comment_text;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    function create() {
        $query = "INSERT INTO " . $this->table_name . " SET task_id=:task_id, user_id=:user_id, comment_text=:comment_text";
        $stmt = $this->conn->prepare($query);

        $this->task_id = htmlspecialchars(strip_tags($this->task_id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->comment_text = htmlspecialchars(strip_tags($this->comment_text));

        $stmt->bindParam(':task_id', $this->task_id);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':comment_text', $this->comment_text);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE task_id = :task_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':task_id', $this->task_id);
        $stmt->execute();
        return $stmt;
    }
}
?>
