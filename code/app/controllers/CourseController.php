<?php
require_once __DIR__ . '/../models/Course.php';

class CourseController {
    public function index() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?page=login");
            exit();
        }

        $id_user = $_SESSION["id_user"];
        $nom_user = $_SESSION["email"];

        $course = new Course();
        $id_plan = $course->getPlanSemaine($id_user);
        if (!$id_plan) {
            die("Aucun plan sélectionné");
        }
        $id_liste = $course->createListe($id_plan,$id_user);
        $liste = $course->getListe( $id_liste);

        require __DIR__ . '/../views/courses/index.php';

    }
}
