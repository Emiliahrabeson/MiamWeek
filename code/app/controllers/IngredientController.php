<?php
require_once __DIR__ . '/../models/Ingredient.php';
 
class IngredientController {

    public function ingredient() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?page=login");
            exit();
        }

        $nom_user = $_SESSION['email'];
        $ingredientModel = new Ingredient();
        $erreur_api = '';

        if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
            $search = trim($_POST['search']);
            $resultat = $ingredientModel->search($search);

            $ingredients = $resultat['ingredients'];
            $erreur_api = $resultat['erreur_api'];

        } else {
            $ingredients = $ingredientModel->getAll();
        }

        require __DIR__ . '/../views/ingredient/index.php';
    }
}

