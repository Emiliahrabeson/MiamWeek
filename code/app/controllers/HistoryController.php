<?php
require_once __DIR__ . '/../models/History.php';

class HistoryController {
    public function index() {
        $lundi = date('Y-m-d', strtotime('monday last week'));
        $dimanche = date('Y-m-d', strtotime('sunday last week'));
        $jours_ordre = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
        $types_repas = ['Petit-déjeuner','Déjeuner','Dîner'];

        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?page=login");
            exit();
        }
 
        $id_user = $_SESSION["id_user"];
        $nom_user = $_SESSION["email"];

        $planHistoryModel = new History();
        $planDataHistory = $planHistoryModel->getPlanHistory($id_user);


        require __DIR__ . '/../views/history/index.php';
    }
}
