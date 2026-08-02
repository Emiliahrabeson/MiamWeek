<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

class Mail {
    private function configuration() {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;

        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = (int) $_ENV['MAIL_PORT'];

        $mail->CharSet = "UTF-8";
        $mail->isHTML(true);

        return $mail;
    }

    public function sendVerificationEmail($email, $nom, $token) {
        $mail = $this->configuration();

        try {
            // expéditeur
            $mail->setFrom(
                $_ENV['MAIL_USERNAME'],
                $_ENV['MAIL_FROM_NAME']
            );

            // Destinataire
            $mail->addAddress($email, $nom);

            $link = $_ENV['APP_URL'] . "/index.php?page=verify&token=" . urlencode($token);
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
