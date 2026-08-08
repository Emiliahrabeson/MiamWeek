<?php
require_once __DIR__ . '/../models/Profile.php'; 

class ProfileController {
    public function profile() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?page=login");
            exit();
        }
        $username = $_SESSION["email"];
        $prenom_user = $_SESSION["prenom"];

        $profileModel = new Profile();
        $user = $profileModel->getObjectifCalories($username);
        $allergies = $profileModel->getAllergies($username);
        $favoris = $profileModel->getFavoris($username);

        require __DIR__ . '/../views/profile/index.php';
    }


}
