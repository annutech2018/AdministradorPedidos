<?php
include '../../query/LogDao.php';
include '../../cripto/Cripto.php';

header('Content-Type: application/json');
ini_set('default_charset', 'ISO-8859-1');
$id = filter_input(INPUT_POST, 'id');
$nombre = filter_input(INPUT_POST, 'nombre');
$clave = base64_encode(Cripto::encriptar(filter_input(INPUT_POST, 'clave1')));
$tipo = filter_input(INPUT_POST, 'tipo');
$conn = new Conexion();
$conn->conectar();
$qryClave = "";
if($clave != ""){
    $qryClave = ",usuario_password = '$clave' ";
}
$query = "UPDATE tbl_usuario SET usuario_nombre = '$nombre' $qryClave "
        . ",usuario_tipo = $tipo "
        . "WHERE usuario_id = '$id';";
if (mysqli_query($conn->conn,$query)) {
    $id = mysqli_insert_id($conn->conn);
    $aux = '';
    if($tipo == '0'){
        $aux = 'ADMIN';
    } else if($tipo == '1'){
        $aux = 'VENDEDOR';
    } else if($tipo == '2'){
        $aux = 'MONITOR';
    } else if($tipo == '3'){
        $aux = 'DESPACHO';
    } else if($tipo == '4'){
        $aux = 'CLIENTE';
    }
    LogDao::insertarLog("USUARIO MODIFICADO CON EL NICK: $nombre %$nombre%$clave%$aux", 17);
    echo "{\"mensaje\":\"Usuario modificado\"}";
} else {
    $error = mysqli_error($conn->conn);
    if(strpos($error,"usuario_nombre_key") == true){
        echo "{\"error\":\"El usuario $nombre ya existe\"}";
    }
    else{
        echo "{\"error\":\"$error\"}";
    }
}
