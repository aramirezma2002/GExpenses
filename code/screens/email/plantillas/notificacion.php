<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once '../../../vendor/autoload.php';

function enviarCorreo($location, $arrCorreos, $userEmail, $idActivitat, $fechaActual)
{
    $contador = 0;

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; //gmail SMTP server
        $mail->SMTPAuth = true;
        // ARCHIVOS DE ERROR
        // $mail->SMTPDebug = 1;
        $mail->Host = 'smtp.gmail.com'; //gmail SMTP server
        $mail->Username = 'gexpensesapp@gmail.com'; //email
        $mail->Password = 'rhuwnmunhtqnvcjj'; //16 character obtained from app password created
        $mail->Port = 465; //SMTP port
        $mail->SMTPSecure = "ssl";
        $mail->addEmbeddedImage("../../recursos/img/banner.png", "id");

            $mail->setFrom('gexpensesapp@gmail.com', 'GExpenses');

        // EMAIL DE QUEN RECIBE EL CORREO
        foreach ($arrCorreos as $email) {
            $mail->addAddress($email, 'Invitado');

            // Añadir "cc" o "bcc" 
            // $mail->addCC('email@mail.com');  
            // $mail->addBCC('user@mail.com');  

            // Variable de registre

            require "../../connections/connection.php";

            if ($pdo != null) {
                $stmtUser = $pdo->query("SELECT correu FROM usuari WHERE correu LIKE '$email'");

                $user = $stmtUser->fetch();

                if ($user != null) {
                    $body = 'mensaje.php';
                } else {
                    $body = 'registro.php';
                }
            }

            $mail->isHTML(true);

            $mail->Subject = 'Te han invitado a una actividad!';
            ob_start();
            include $body;
            
            $mail->Body = ob_get_clean();

            if ($mail->send()) {
                $contador++;
                if ($contador == count($arrCorreos)) {
                    header($location);
                }
            }
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}