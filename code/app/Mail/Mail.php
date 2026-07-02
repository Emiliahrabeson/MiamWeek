<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

class Mail {
    private function configuration() {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;

        $mail->Username = "emiliahrabeson@gmail.com";

        $mail->Password = "vjwakoisbckrfsag";

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->CharSet = "UTF-8";
        $mail->isHTML(true);

        return $mail;
    }

    public function sendVerificationEmail($email, $nom, $token) {
        try {
            $mail = $this->configuration();

            // expéditeur
            $mail->setFrom(
                "emiliahrabeson@gmail.com",
                "Miam-week"
            );

            // Destinataire
            $mail->addAddress($email, $nom);

            $link = "http://localhost:8000/index.php?page=verify&token=" . urlencode($token);
            $mail->Subject = "Confirmation de votre compte";

            // HTML
            $mail->Body = "
                <h2>Bonjour {$nom},</h2>

                <p>Merci de vous être inscrit sur <strong>Miam-week</strong>.</p>

                <p>
                    Cliquez sur le bouton ci-dessous pour confirmer votre compte.
                </p>

                <p>
                    <a href='{$link}'
                       style='
                           background:#28a745;
                           color:white;
                           padding:12px 20px;
                           text-decoration:none;
                           border-radius:5px;
                           display:inline-block;
                       '>
                       Confirmer mon compte
                    </a>
                </p>

                <p>
                    Si vous n'êtes pas à l'origine de cette inscription,
                    ignorez simplement cet e-mail.
                </p>

            ";

            // texte
            $mail->AltBody =
                "Bonjour {$nom}\n\n" .
                "Confirmez votre compte avec ce lien :\n" .
                $link;

            $mail->send();

            return true;

        } catch (Exception $e) {

            error_log($mail->ErrorInfo);

            return false;
        }
    }


}

    