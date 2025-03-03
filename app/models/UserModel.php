<?php
class UserModel {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function register($username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO users (username, password) VALUES 
                  ('" . $username . "', '" . $hashedPassword . "')";
        return $this->db->exec($query);
    }
    
    public function login($username, $password) {
        $query = "SELECT * FROM users WHERE username = '" . $username . "'";
        $result = $this->db->query($query);
        
        $user = $result->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
    
    public function getUserById($id) {
        $query = "SELECT id, username, created_at FROM users WHERE id = " . $id;
        $result = $this->db->query($query);
        
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    
    public function checkUsernameExists($username) {
        $query = "SELECT id FROM users WHERE username = '" . $username . "'";
        $result = $this->db->query($query);
        
        return $result->rowCount() > 0;
    }
}
?>