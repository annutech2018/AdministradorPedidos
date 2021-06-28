<?php
include '../../query/LogDao.php';

header('Content-Type: application/json');
ini_set('default_charset', 'ISO-8859-1');

$id = filter_input(INPUT_POST, 'id');
$conn = new Conexion();
$conn->conectar();
$query = "DELETE FROM tbl_usuario WHERE usuario_id = $id AND usuario_nombre != 'admin'";
if (mysqli_query($conn->conn,$query)) {
    $aux = mysqli_insert_id($conn->conn);
    LogDao::insertarLog("USUARIO ELIMINADO CON EL ID: ".$aux, 18);
    echo "{\"mensaje\":\"Usuario eliminado\"}";
} else {
    echo "{\"error\":\"".mysqli_error($conn->conn)."\"}";
}

