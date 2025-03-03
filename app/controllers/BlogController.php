<?php
require_once __DIR__ . '/../models/BlogModel.php';

class BlogController {
    private $blogModel;
    
    public function __construct($db) {
        $this->blogModel = new BlogModel($db);
    }
    
    public function index() {
        $blogs = $this->blogModel->getAllBlogs();
        require_once __DIR__ . '/../views/blog/index.php';
    }
    
    public function show($id) {
        $blog = $this->blogModel->getBlogById($id);
        
        if (!$blog) {
            $_SESSION['error'] = "Blog not found";
            header('Location: /blog/public/blog');
            exit;
        }
        
        require_once __DIR__ . '/../views/blog/show.php';
    }
    
    public function create() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "You need to be logged in to create a blog";
            header('Location: /blog/public/user/login');
            exit;
        }
        
        require_once __DIR__ . '/../views/blog/create.php';
    }
    
    public function store() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "You need to be logged in to create a blog";
            header('Location: /blog/public/user/login');
            exit;
        }
        
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        
        if (empty($title) || empty($content)) {
            $_SESSION['error'] = "Title and content are required";
            $_SESSION['form_data'] = $_POST;
            header('Location: /blog/public/blog/create');
            exit;
        }
        
        $result = $this->blogModel->createBlog($_SESSION['user_id'], $title, $content);
        
        if ($result) {
            $_SESSION['success'] = "Blog created successfully";
            header('Location: /blog/public/blog');
        } else {
            $_SESSION['error'] = "Failed to create blog";
            $_SESSION['form_data'] = $_POST;
            header('Location: /blog/public/blog/create');
        }
        exit;
    }
    
    public function edit($id) {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "You need to be logged in to edit a blog";
            header('Location: /blog/public/user/login');
            exit;
        }
        
        $blog = $this->blogModel->getBlogById($id);
        
        if (!$blog) {
            $_SESSION['error'] = "Blog not found";
            header('Location: /blog/public/blog');
            exit;
        }
        
        if ($blog['user_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = "You can only edit your own blogs";
            header('Location: /blog/public/blog');
            exit;
        }
        
        require_once __DIR__ . '/../views/blog/edit.php';
    }
    
    public function update($id) {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "You need to be logged in to update a blog";
            header('Location: /blog/public/user/login');
            exit;
        }
        
        $blog = $this->blogModel->getBlogById($id);
        
        if (!$blog) {
            $_SESSION['error'] = "Blog not found";
            header('Location: /blog/public/blog');
            exit;
        }
        
        if ($blog['user_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = "You can only update your own blogs";
            header('Location: /blog/public/blog');
            exit;
        }
        
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        
        if (empty($title) || empty($content)) {
            $_SESSION['error'] = "Title and content are required";
            $_SESSION['form_data'] = $_POST;
            header('Location: /blog/public/blog/edit/' . $id);
            exit;
        }
        
        $result = $this->blogModel->updateBlog($id, $title, $content);
        
        if ($result) {
            $_SESSION['success'] = "Blog updated successfully";
            header('Location: /blog/public/blog/show/' . $id);
        } else {
            $_SESSION['error'] = "Failed to update blog";
            $_SESSION['form_data'] = $_POST;
            header('Location: /blog/public/blog/edit/' . $id);
        }
        exit;
    }
    
    public function delete($id) {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "You need to be logged in to delete a blog";
            header('Location: /blog/public/user/login');
            exit;
        }
        
        $blog = $this->blogModel->getBlogById($id);
        
        if (!$blog) {
            $_SESSION['error'] = "Blog not found";
            header('Location: /blog/public/blog');
            exit;
        }
        
        if ($blog['user_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = "You can only delete your own blogs";
            header('Location: /blog/public/blog');
            exit;
        }
        
        $result = $this->blogModel->deleteBlog($id);
        
        if ($result) {
            $_SESSION['success'] = "Blog deleted successfully";
        } else {
            $_SESSION['error'] = "Failed to delete blog";
        }
        
        header('Location: /blog/public/blog');
        exit;
    }
    
    public function myBlogs() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "You need to be logged in to view your blogs";
            header('Location: /blog/public/user/login');
            exit;
        }
        
        $blogs = $this->blogModel->getBlogsByUserId($_SESSION['user_id']);
        require_once __DIR__ . '/../views/blog/my_blogs.php';
    }
}
?>