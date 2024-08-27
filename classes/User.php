<?php
class User {
    private $conn;
    private $table_name = "users";

    public $username;
    public $email;
    public $password;
    public $id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login() {
        $query = "SELECT user_id, password_hash FROM " . $this->table_name . " WHERE email = :email";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $password_hash = $row['password_hash'];
            $this->id = $row['user_id'];
    
            if (password_verify($this->password, $password_hash)) {
                return true;
            }
        }
    
        return false;
    }
    

    public function register() {
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);

        $query = "INSERT INTO " . $this->table_name . " (username, email, password_hash) VALUES (:username, :email, :password)";

        $stmt = $this->conn->prepare($query);

        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = $password_hash;

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);

        if ($stmt->execute()) {
            return true;
        }

        error_log('Failed to execute register query.');
        return false;
    }
}
?>
