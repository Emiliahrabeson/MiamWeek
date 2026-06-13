<?php
require_once __DIR__ . "/../core/Model.php";

class Notification {
    public function createNotification ($id_user,$type_notification,$message){
        $stmt = $this->pdo->prepare("
            INSERT INTO Notification (id_user,type_notification,message)
            VALUES (?,?,?);
        ");

        $stmt->execute([$id_user,$type_notification,$message]);
    }

    public function objectifAtteint () {
        creerNotification(
            $id_user,
            'OBJECTIF_ATTEINT',
            'Félicitations, Vous avez atteint votre objectif calorique du jour.'
        );
    }

    public function rappelEau () {
        creerNotification(
            $id_user,
            'RAPPEL_EAU',
            "N'oubliez pas de boire suffisamment d'eau aujourd'hui."
        );
    }

    public function listeCourse () {
        creerNotification(
            $id_user,
            'LISTE_COURSE',
            'Pensez à compléter tous les ingrédients de votre liste de courses.'
        );
    }


    public function suiviPlanning () {
        creerNotification(
            $id_user,
            'SUIVI_PLANNING',
            "N'oubliez pas de bien suivre votre planning pour atteindre votre objectif."
        );
    }

    public function mdpModifier () {
        creerNotification(
            $id_user,
            'MDP_MODIFIE',
            'Votre mot de passe a été modifié avec succès.'
        );
    }

    public function reinitialiserMdp () {
        creerNotification(
            $id_user,
            'REINITIALISATION_MDP',
            'Consultez votre adresse e-mail pour réinitialiser votre mot de passe.'
        );
    }


}
