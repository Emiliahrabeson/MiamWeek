<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    public function login() {
        session_start();
        $error = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            if (!empty($email) && !empty($password)) {
                $userModel = new User();

                $user = $userModel->findByEmail($email);

                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['id_user'] = $user['id_user'];
                    $_SESSION['email'] = $user['email'];

                    header("Location: index.php?page=home");
                    exit();
                }
                $error = "email ou mot de passe incorrect";
            }

            else {
                $error = "veuillez remplir tous les champs";
            }
        }

        require __DIR__ . '/../views/user/login.php';
    }

    public function register () {
        session_start();
        $error = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = trim($_POST["name"]);
            $prenom = trim($_POST["prenom"]);
            $email = trim($_POST["email"]);
            $password = $_POST["password"];
            $confirm = $_POST["confirm_password"];


            if (!empty($name) && !empty($email) && !empty($password) && !empty($confirm)) {

                if ($password !== $confirm) {
                    $error = "mot de passe incorrect";
                } 
                else {
                    $userModel = new User();
                    if ($userModel->emailExists($email)) {
                        $error = "Cet email est déjà utilisé.";
                    } 
                    else {
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                        $userModel->create($name,$prenom,$email,$hashedPassword);

                        header("Location: index.php?page=login");
                        exit();
                    }
                }

            }
            else {
                $error = "Veuillez remplir tous les champs.";
            }
        }
        
        require __DIR__ . '/../views/user/register.php';

    }

    public function logout() {
        $_SESSION = [];
        session_destroy();

        header("Location: index.php?page=login");
        exit();
    }

}
