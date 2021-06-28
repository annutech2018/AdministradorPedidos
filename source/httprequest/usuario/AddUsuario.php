<?php
include '../../query/LogDao.php';
include '../../cripto/Cripto.php';

session_start();
header('Content-Type: application/json');
ini_set('default_charset', 'ISO-8859-1');

$nombre = filter_input(INPUT_POST, 'nombre');
$clave = base64_encode(Cripto::encriptar(filter_input(INPUT_POST, 'clave1')));
$tipo = filter_input(INPUT_POST, 'tipo');
$usuario = $_SESSION["agente"];
$conn = new Conexion();
$conn->conectar();
$query = "INSERT INTO tbl_usuario(usuario_nombre, usuario_password, usuario_tipo,usuario_creador) VALUES"
        . " ('$nombre','$clave',$tipo,$usuario)";
if (mysqli_query($conn->conn,$query)) {
    $id = mysqli_insert_id($conn->conn);
    LogDao::insertarLog("USUARIO AGREGADO CON EL NICK: ".$nombre, 16);
    echo "{\"mensaje\":\"Usuario agregado\"}";
} else {
    $error = mysqli_error($conn->conn);
    if(strpos($error,"usuario_nombre_key") == true){
        echo "{\"error\":\"El usuario $nombre ya existe\"}";
    }
    else{
        echo "{\"error\":\"$error\"}";
    }
}