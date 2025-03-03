<?php
class BlogModel {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function getAllBlogs() {
        $query = "SELECT blogs.*, users.username 
                  FROM blogs 
                  JOIN users ON blogs.user_id = users.id 
                  ORDER BY blogs.created_at DESC";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getBlogById($id) {
        $query = "SELECT blogs.*, users.username 
                  FROM blogs 
                  JOIN users ON blogs.user_id = users.id 
                  WHERE blogs.id = " . $id;
        $result = $this->db->query($query);
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getBlogsByUserId($userId) {
        $query = "SELECT * FROM blogs WHERE user_id = " . $userId . " ORDER BY created_at DESC";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function createBlog($userId, $title, $content) {
        $query = "INSERT INTO blogs (user_id, title, content) VALUES 
                  (" . $userId . ", '" . $title . "', '" . $content . "')";
        return $this->db->exec($query);
    }
    
    public function updateBlog($id, $title, $content) {
        $query = "UPDATE blogs SET title = '" . $title . "', content = '" . $content . "' WHERE id = " . $id;
        return $this->db->exec($query);
    }
    
    public function deleteBlog($id) {
        $query = "DELETE FROM blogs WHERE id = " . $id;
        return $this->db->exec($query);
    }
}
?>