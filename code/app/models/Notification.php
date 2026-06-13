<?php
require_once __DIR__ . "/../core/Model.php";

class Notification extends Model {
    public function createNotification ($id_user,$type_notification,$message){
        $stmt = $this->pdo->prepare("
            INSERT INTO Notification (id_user,type_notification,message,date_envoi)
            VALUES (?,?,?);
        ");

        $stmt->execute([$id_user,$type_notification,$message,$date_envoi]);
    }


    public function rappelEau ($id_user)
     {$maintenant = new DateTime();
        $verify = $this->pdo->prepare(
            "SELECT COUNT(*)
            FROM Notification
            WHERE id_user = :id_user
            AND type_notification = 'RAPPEL_EAU'
            AND DATE(date_creation) = CURDATE();"
        );
        $verify->execute(['id_user' => $id_user]);
        $count = $verify->fetchColumn();

        if ($count == 0) {
            createNotification(
                $id_user,
                'RAPPEL_EAU',
                "N'oubliez pas de boire suffisamment d'eau aujourd'hui.",
                $maintenant->format('Y-m-d H:i:s')
            );

        }
        
    }

    public function listeCourse ($id_user) {
        $maintenant = new DateTime();
        $maintenant->modify('+5 minutes');

        $verify = $this->pdo->prepare(
            "SELECT COUNT(*)
            FROM Notification
            WHERE id_user = :id_user
            AND type_notification = 'LISTE_COURSE'
            AND DATE(date_creation) = CURDATE();"
        );
        $verify->execute(['id_user' => $id_user]);
        $count = $verify->fetchColumn();

        if ($count == 0) {
            createNotification(
                $id_user,
                'LISTE_COURSE',
                'Pensez à compléter tous les ingrédients de votre liste de courses.',
                $maintenant->format('Y-m-d H:i:s')
            );
        }
        
    }


    public function suiviPlanning ($id_user) {
        $maintenant = new DateTime();
        $maintenant->modify('+10 minutes');

        $verify = $this->pdo->prepare(
            "SELECT COUNT(*)
            FROM Notification
            WHERE id_user = :id_user
            AND type_notification = 'SUIVI_PLANNING'
            AND DATE(date_creation) = CURDATE();"
        );
        $verify->execute(['id_user' => $id_user]);
        $count = $verify->fetchColumn();

        if ($count == 0) {
            createNotification(
                $id_user,
                'SUIVI_PLANNING',
                "N'oubliez pas de bien suivre votre planning pour atteindre votre objectif.",
                $maintenant->format('Y-m-d H:i:s')
            );
        }
        
    }

    public function mdpModifier ($id_user) {
        createNotification(
            $id_user,
            'MDP_MODIFIE',
            'Votre mot de passe a été modifié avec succès.'
        );
    }

    public function reinitialiserMdp ($id_user) {
        createNotification(
            $id_user,
            'REINITIALISATION_MDP',
            'Consultez votre adresse e-mail pour réinitialiser votre mot de passe.'
        );
    }

    public function getNotifications($id_user) {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM Notification
            WHERE id_user = ?
            AND date_envoi <= NOW()
            ORDER BY date_envoi DESC
        ");

        $stmt->execute([$id_user]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    


}
