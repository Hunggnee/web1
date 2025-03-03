<?php
require_once __DIR__ . '/../config/database.php';

function route($uri) {
    global $db;

    // Remove "public/" from the URL (important fix!)
    $uri = str_replace('public/', '', trim($uri, '/'));

    // Split into controller/action/param
    $uriParts = explode('/', $uri, 3);

    $controllerName = isset($uriParts[0]) ? $uriParts[0] : 'blog';
    $action = isset($uriParts[1]) ? $uriParts[1] : 'index';
    $param = isset($uriParts[2]) ? $uriParts[2] : null;

    // Controller mapping
    $controllers = [
        'blog' => 'BlogController',
        'user' => 'UserController'
    ];

    if (!isset($controllers[$controllerName])) {
        die("Error: Controller '$controllerName' not found.");
    }

    $controllerClass = $controllers[$controllerName];
    $controllerPath = __DIR__ . '/../app/controllers/' . $controllerClass . '.php';

    if (!file_exists($controllerPath)) {
        die("Error: Controller file '$controllerClass.php' not found.");
    }

    require_once $controllerPath;

    if (!class_exists($controllerClass)) {
        die("Error: Controller class '$controllerClass' not found.");
    }

    $controllerInstance = new $controllerClass($db);

    // Define valid methods
    $methods = [
        'index' => 'index',
        'show' => 'show',
        'create' => 'create',
        'store' => 'store',
        'edit' => 'edit',
        'update' => 'update',
        'delete' => 'delete',
        'myblogs' => 'myBlogs',
        'login' => 'showLoginForm',
        'register' => 'showRegisterForm',
        'profile' => 'profile',
        'logout' => 'logout'
    ];

    if (!isset($methods[$action]) || !method_exists($controllerInstance, $methods[$action])) {
        die("Error: Method '$action' not found in controller '$controllerClass'.");
    }

    $method = $methods[$action];

    if ($param !== null) {
        $controllerInstance->$method($param);
    } else {
        $controllerInstance->$method();
    }
}
