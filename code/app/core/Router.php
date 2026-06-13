<?php
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/HomeController.php';
require_once __DIR__ . '/../controllers/RecetteController.php';
require_once __DIR__ . '/../controllers/IngredientController.php';
require_once __DIR__ . '/../controllers/ProfileController.php';
require_once __DIR__ . '/../controllers/Modifier_profileController.php';
require_once __DIR__ . '/../controllers/Modifier_repasController.php';
require_once __DIR__ . '/../controllers/DashboardController.php';
require_once __DIR__ . '/../controllers/CourseController.php';
require_once __DIR__ . '/../controllers/NotificationController.php';

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

            case 'profile':
                $controller = new ProfileController();
                $controller->profile();
                break;
            
            case 'deleteAllergie':
                $controller = new ProfileController();
                $controller->deleteAllergie();
                break;

            case 'deleteFavori':
                $controller = new ProfileController();
                $controller->deleteFavori();
                break;

            case 'modifier_profile':
                $controller = new Modifier_profileController();
                $controller->modifier();
                break;
            
            case 'modifier_repas':
                $controller = new Modifier_repasController();
                $controller->index();
                break;

            case 'logout':
                $controller = new UserController();
                $controller->logout();
                break;

            case 'dashboard':
                $controller = new DashboardController();
                $controller->index();
                break;

            case 'course':
                $controller = new CourseController();
                $controller->index();
                break;

            case 'notification':
                $controller = new NotificationController();
                $controller->index();
                break;

            default:
                echo "Page introuvable";
                break;
        }
    }
}
