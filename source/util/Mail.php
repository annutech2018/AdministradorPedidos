<?php

include 'phpmailer/PHPMailer.php';

class Mail {
    
    public static function enviarCorreo($mails,$asunto,$mensaje){
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        //$mail->Port = 25;
        $mail->SMTPAuth = true;
        $mail->Username = 'despachos.bleach@gmail.com';
        $mail->Password = '1234Abcd';
        $mail->setFrom('despachos.bleach@gmail.com', 'Despachos Bleach');
        for($i = 0 ; $i < count($mails); $i++){
            $mail->addAddress($mails[$i], '');
        }
        $mail->Subject = $asunto;
        $mail->msgHTML($mensaje);
        if (!$mail->send()) {
        return "{\"mensaje\":" . "$mail->ErrorInfo}\"";
        } else {
            return "{\"mensaje\":\"ok\"}";
        }
    }
}
