<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../Mail/Mail.php';

class UserController {
    public function login() {
        $error = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            if (!empty($email) && !empty($password)) {
                $userModel = new User();
 
                $user = $userModel->findByEmail($email);

                if ($user && password_verify($password, $user['password'])) {
                    if (!$user['is_verified']) {
                        $error = "Veuillez confirmer votre adresse e-mail pour vous connecter.";
                    } 
                    else {
                        $_SESSION['id_user'] = $user['id_user'];
                        $_SESSION['email'] = $user['email'];
                        $_SESSION['prenom'] = $user['prenom'];

                        header("Location: index.php?page=home");
                        exit();
                    }
                }
                else {
                    $error = "Email ou mot de passe incorrect.";
                }
                
            }

            else {
                $error = "veuillez remplir tous les champs";
            }
        }

        require __DIR__ . '/../views/user/login.php';
    }

    public function register () {
        // session_start();
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

                        $token = bin2hex(random_bytes(32));
                        $userModel->create($name,$prenom,$email,$hashedPassword);
                        $userModel->saveVerificationToken($email,$token);

                        $mail = new Mail();

                        if ($mail->sendVerificationEmail($email, $name, $token)) {
                            $_SESSION['success'] = " Consultez votre boîte mail pour confirmer votre compte.";

                            header("Location: index.php?page=login");
                            exit();
                        }
                        else{
                            $error = "Le compte a été créé mais l'e-mail n'a pas pu être envoyé.";
                        }

                        
                    }
                    header("Location: index.php?page=login");
                        exit();
                }
                

            }
            else {
                $error = "Veuillez remplir tous les champs.";
            }
        }
        
        require __DIR__ . '/../views/user/register.php';

    }

    public function verify() {
        if (!isset($_GET['token'])) {
            die("Token manquant.");
        }
        $token = $_GET['token'];

        $userModel = new User();
        $user = $userModel->findByToken($token);

        if (!$user) {
            die("Lien invalide.");
        }

        $userModel->verifyAccount($user['id_user']);

        header("Location: index.php?page=login&verified=1");
        exit();
    }

    public function logout() {
        $_SESSION = [];
        session_destroy();

        header("Location: index.php?page=login");
        exit();
    }

}
