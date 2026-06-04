<?php
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/HomeController.php';
require_once __DIR__ . '/../controllers/RecetteController.php';
require_once __DIR__ . '/../controllers/IngredientController.php';

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
            
            case 'recette':
                $controller = new RecetteController();
                $controller->recette();
                break;
            
            case 'ingredient':
                $controller = new IngredientController();
                $controller->ingredient();
                break;

            default:
                echo "Page introuvable";
                break;
        }
    }
}
