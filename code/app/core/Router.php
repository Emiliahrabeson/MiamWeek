<?php
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/HomeController.php';

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

            case 'home':
                $controller = new HomeController();
                $controller->index();
                break;

            default:
                echo "Page introuvable";
                break;
        }
    }
}
