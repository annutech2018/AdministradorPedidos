<?php

include './Mail.php';

header('Content-Type: application/json');
    
$asunto = "";
$mensaje = "";
$id = filter_input(INPUT_POST, "id");
$mail = filter_input(INPUT_POST, "mail");

$array = array();
array_push($array, $mail);
$resp = Mail::enviarCorreo($array, 'Información de pedido', 'Pedido '.$id.' enviado verifique estado en <a href="https://www.bleachapp.cl/estado.php">https://www.bleachapp.cl/estado.php</a>');

echo $resp;