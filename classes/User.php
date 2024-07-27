<?php
class User {
    private $conn;
    private $table = 'users';

    public $id;
    public $username;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register() {
        $sql = "INSERT INTO $this->table (username, password) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ss', $this->username, $this->password);
        return $stmt->execute();
    }

    public function login() {
        $sql = "SELECT id, password FROM $this->table WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $this->username);
        $stmt->execute();
        $stmt->bind_result($this->id, $hashed_password);
        $stmt->fetch();
        if (password_verify($this->password, $hashed_password)) {
            return true;
        }
        return false;
    }
}
?>
