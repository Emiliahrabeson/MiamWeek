<?php
require_once __DIR__ . '/../models/Dashboard.php';
require_once __DIR__ . '/../models/PlanRepas.php';

class HomeController {
    public function index() {
        
        $lundi = date('Y-m-d', strtotime('monday this week'));
        $dimanche = date('Y-m-d', strtotime('sunday this week'));
        $jours_ordre = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
        $types_repas = ['Petit-déjeuner','Déjeuner','Dîner'];

        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?page=login");
            exit();
        }
 
        $id_user = $_SESSION["id_user"];
        $nom_user = $_SESSION["email"];

        $dashb = new Dashboard();
        $stats = $dashb->getStats();
         [$nb_recettes,$nb_ingredients,$nb_repas,$nb_plans] = $stats;

        $planModel = new PlanRepas();
        $planData = $planModel->getPlanSemaine($id_user);

        require __DIR__ . '/../views/home/index.php';
    }
}
