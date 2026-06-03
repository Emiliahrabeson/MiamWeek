<?php
require_once __DIR__ . '/../controllers/UserController.php';

class Router {
    public static function route () {
        $page = $_GET['page'] ?? 'login';

        switch ($page) {
            case 'login' : 
                $controller = new UserController();
                $controller->login();
                break;

            case 'register':
                $controller = new UserController();
                $controller->register();
                break;

            default:
                echo "Page introuvable";
                break;
        }
    }
}
