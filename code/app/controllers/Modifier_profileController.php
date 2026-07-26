<?php

require_once __DIR__ . '/../models/Modifier_profile.php';

class Modifier_profileController {

    public function modifier() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?page=login");
            exit();
        }

        $email = $_SESSION['email'];
        $error = "";
        $success = "";

        $model = new ModifierProfile();
        $user  = $model->getUser($email);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            if ($action === 'update_profile') {             
                if (!empty($_POST['calories'])) {           // ajouter obj calorique
                    $model->updateCalories($user['id_user'], $_POST['calories']);
                }
                if (!empty($_POST['allergie'])) {           // ajout allergie
                    $model->addAllergie($user['id_user'], $_POST['allergie']);
                }
                header("Location: index.php?page=modifier_profile");
                exit();
            }

            if ($action === 'change_password') {
                $old_password = $_POST['old_password'] ?? '';
                $new_password = $_POST['new_password'] ?? '';
                $confirm_password = $_POST['confirm_password'] ?? '';

                if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
                    $error = "Veuillez remplir tous les champs.";

                } 
                elseif ($new_password !== $confirm_password) {
                    $error = "Les nouveaux mots de passe ne correspondent pas.";

                } 
                elseif (!password_verify($old_password, $user['password'])) {
                    $error = "Ancien mot de passe incorrect.";

                } 
                else {
                    $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
                    $model->modify_password($user['email'], $hashedPassword);
                    $success = "Mot de passe modifié avec succès.";
                }
            }
        }

    $favoris   = $model->getFavoris($email);
    $allergies = $model->getAllergies($email);

    require __DIR__ . '/../views/modifier_profile/index.php';
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
