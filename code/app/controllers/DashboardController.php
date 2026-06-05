<?php
require_once __DIR__ . '/../models/Dashboard.php';

class DashboardController {
    public function index() {
        if(!isset($_SESSION['id_user'])) {
            header('Location: login');
            exit;
        }
        $id_user = $_SESSION['id_user'];
        $username = $_SESSION["email"];

        $dashboard = new Dashboard();
        $user = $dashboard->getObjectifCalories($username);
        $caloriesSemaine = $dashboard->getCaloriesSemaine($id_user);
        $objectif = $dashboard->getObjectifCalorique($id_user);

        $allergies = $dashboard->getAllergies($username);
        $favoris = $dashboard->getFavoris($username);

        require __DIR__ . '/../views/dashboard/index.php';
    }

}
