<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService implements IMailService
{
    
    public static function sendTicket(User $user, array $tickets)
    {
        $success = false;
        $to = $user->getEmail();
        $subject = "Your Match Tickets - BuyMatch";
        $count = count($tickets);

        try {
            $mail = self::getMailer();

            $mail->addAddress($user->getEmail());
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = "<p>[" . date('Y-m-d H:i:s') . "] EMAIL TO $to: $subject. Attached $count tickets.</p>";

            $mail->send();
            $success = true;
        } catch (Exception $e) {
            Logger::log("Mail Error: " . ($mail->ErrorInfo ?? $e->getMessage()), "ERROR");
        }

        self::logTicket($user, $tickets);

        return $success;
    }

    private static function getMailer()
    {
        $mail = new PHPMailer(true);

        // SMTP settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mta131276@gmail.com';
        $mail->Password   = 'uxfekukvilevxjtt'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Default sender
        $mail->setFrom('mta131276@gmail.com', 'BuyMatch');

        return $mail;
    }

    private static function logTicket(User $user, array $tickets)
    {
        $to = $user->getEmail();
        $subject = "Your Match Tickets - BuyMatch";
        $count = count($tickets);


        $logMessage = "[" . date('Y-m-d H:i:s') . "] EMAIL TO $to: $subject. Attached $count tickets.\n";
        file_put_contents(BASE_PATH . '/logs/emails.log', $logMessage, FILE_APPEND);

        return true;
    }
}
