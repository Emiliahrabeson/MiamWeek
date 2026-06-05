<?php

require_once __DIR__ . '/../models/Modifier_profile.php';

class Modifier_profileController {

    public function modifier() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?page=login");
            exit();
        }
        $email = $_SESSION['email'];

        $model = new ModifierProfile();
        $user = $model->getUser($email);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['calories'])) {
                $model->updateCalories(
                    $user['id_user'],
                    $_POST['calories']
                );
            }

            if (!empty($_POST['allergie'])) {
                $model->addAllergie(
                    $user['id_user'],
                    $_POST['allergie']
                );
            }

            header("Location: index.php?page=modifier_profile");
            exit();
        }
        $favoris = $model->getFavoris($email);

        require __DIR__ . '/../views/modifier_profile/index.php';
    }
}
