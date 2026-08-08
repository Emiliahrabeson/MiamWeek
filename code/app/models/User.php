<?php
require_once __DIR__ . '/../core/Model.php';

class User extends Model {
    public function findByEmail($email) {
        $sql = "SELECT * FROM Users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "email" => $email
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
 
    public function create($nom,$prenom, $email, $password) {
        $sql = "
            INSERT INTO Users
            (nom, prenom, email, password)
            VALUES
            (:nom, :prenom, :email, :password)
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            "nom" => $nom,
            "prenom" => $prenom,
            "email" => $email,
            "password" => $password
        ]);
    }

    
    public function emailExists($email) {
        $stmt = $this->pdo->prepare(
            "SELECT id_user FROM Users WHERE email = :email"
        );

        $stmt->execute([
            "email" => $email
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function saveVerificationToken($email, $token) {
        $stmt = $this->pdo->prepare(
            "UPDATE Users
            SET verification_token = :token
            WHERE email = :email"
        );

        return $stmt->execute([
            'token' => $token,
            'email' => $email
        ]);
        
    }

    public function findByToken($token){
        $stmt = $this->pdo->prepare(
            "SELECT * FROM Users
            WHERE verification_token = :token;"
        );

        $stmt->execute([
            'token' => $token
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function verifyAccount($id_user) {
        $stmt = $this->pdo->prepare(
            "UPDATE Users
            SET is_verified = 1,
                verification_token = NULL
            WHERE id_user = :id_user"
        );

        return $stmt->execute([
            'id_user' => $id_user
        ]);
    }

}

