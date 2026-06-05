<?php
require_once __DIR__ . '/../models/Profile.php'; 

class ProfileController {
    public function profile() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?page=login");
            exit();
        }
        $username = $_SESSION["email"];

        $profileModel = new Profile();
        $user = $profileModel->getObjectifCalories($username);
        $allergies = $profileModel->getAllergies($username);
        $favoris = $profileModel->getFavoris($username);

        require __DIR__ . '/../views/profile/index.php';
    }

    public function deleteAllergie() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?page=login");
            exit();
        }

        if (isset($_GET['id'])) {
            $id_user = $_SESSION['id_user'];
            $id_ingredient = $_GET['id'];

            $profileModel = new Profile();

            $profileModel->deleteAllergie($id_user,$id_ingredient);
        }

        header("Location: index.php?page=profile");
        exit();
    }

    public function deleteFavori() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?page=login");
            exit();
        }

        $email = $_SESSION['email'];
        $id_recette = $_GET['id'];
        $profileModel = new Profile();

        $profileModel->deleteFavori($email,$id_recette);

        header("Location: index.php?page=profile");
        exit();

    }

}

