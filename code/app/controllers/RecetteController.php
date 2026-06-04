<?php
require_once __DIR__ . '/../models/Recette.php';

class RecetteController {
    public function recette () {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?page=login");
            exit();
        }

        $id_user = $_SESSION['id_user'];
        $nom_user = $_SESSION["email"];

        $rec = new Recette ();

        $suggestions = $rec->getSuggestions();

        if (isset($_GET['favori'])) {
            $rec->addFavori(
                $id_user,
                $_GET['favori']
            );
            header("Location: index.php?page=recette");
            exit();
        }

        $res = [];
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
            $search = trim($_POST['search']);

            if (!empty($search)) {
                $res = $rec->search($search);
            }
        }
         require __DIR__ . '/../views/recette/index.php';
    
    }
}

