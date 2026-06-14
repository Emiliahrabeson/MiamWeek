<?php
require_once __DIR__ . '/../models/Notification.php';

class NotificationController {
    public function index() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?page=login");
            exit();
        }

        $id_user = $_SESSION["id_user"];
        $nom_user = $_SESSION["email"];
        $date_aujourdhui = date('Y-m-d');

        $notification = new Notification();

        $notification->rappelEau($id_user);
        $notification->listeCourse($id_user);
        $notification->suiviPlanning($id_user);
        $notifications = $notification->getNotifications($id_user);
 

        require __DIR__ . '/../views/notification/index.php';
    }
}