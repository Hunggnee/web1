<?php
require_once __DIR__ . '/../models/UserModel.php';

class UserController {
    private $userModel;
    
    public function __construct($db) {
        $this->userModel = new UserModel($db);
    }
    
    public function showLoginForm() {
        require_once __DIR__ . '/../views/user/login.php';
    }
    
    public function login() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            $_SESSION['error'] = "Username and password are required";
            $_SESSION['form_data'] = ['username' => $username];
            header('Location: /blog/public/user/login');
            exit;
        }
        
        $user = $this->userModel->login($username, $password);
        
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['success'] = "Login successful";
            header('Location: /blog/public/blog');
        } else {
            $_SESSION['error'] = "Invalid username or password";
            $_SESSION['form_data'] = ['username' => $username];
            header('Location: /blog/public/user/login');
        }
        exit;
    }
    
    public function showRegisterForm() {
        require_once __DIR__ . '/../views/user/register.php';
    }
    
    public function register() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        $errors = [];
        
        if (empty($username)) {
            $errors[] = "Username is required";
        } elseif ($this->userModel->checkUsernameExists($username)) {
            $errors[] = "Username already exists";
        }
        
        
        if (empty($password)) {
            $errors[] = "Password is required";
        } elseif (strlen($password) < 6) {
            $errors[] = "Password must be at least 6 characters long";
        }
        
        if ($password !== $confirm_password) {
            $errors[] = "Passwords do not match";
        }
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = [
                'username' => $username
            ];
            header('Location: /blog/public/user/register');
            exit;
        }
        
        $result = $this->userModel->register($username, $password);
        
        if ($result) {
            $_SESSION['success'] = "Registration successful. Please log in.";
            header('Location: /blog/public/user/login');
        } else {
            $_SESSION['error'] = "Registration failed";
            $_SESSION['form_data'] = [
                'username' => $username
            ];
            header('Location: /blog/public/user/register');
        }
        exit;
    }
    
    public function logout() {
        session_destroy();
        header('Location: /blog/public/user/login');
        exit;
    }
    
    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "You need to be logged in to view your profile";
            header('Location: /blog/public/user/login');
            exit;
        }
        
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        require_once __DIR__ . '/../views/user/profile.php';
    }
}
?>