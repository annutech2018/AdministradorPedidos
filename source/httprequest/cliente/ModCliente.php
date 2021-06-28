<?php
include '../../query/LogDao.php';
include_once '../../conexion/Conexion.php';

header('Content-Type: application/json');

$rut = filter_input(INPUT_POST, 'rut');
$nombre = filter_input(INPUT_POST, 'nombre');
$giro = filter_input(INPUT_POST, 'giro');
$mail = filter_input(INPUT_POST, 'mail');
$telefono = filter_input(INPUT_POST, 'telefono');
$direccion = filter_input(INPUT_POST, 'direccion');
$comuna = filter_input(INPUT_POST, 'comuna');
$ciudad = filter_input(INPUT_POST, 'ciudad');

$conn = new Conexion();
$conn->conectar();

$query = "UPDATE tbl_cliente SET cliente_nombre = '$nombre', cliente_giro = '$giro',"
        . " cliente_mail = '$mail', cliente_telefono = '$telefono', cliente_direccion = '$direccion',"
        . " cliente_comuna = '$comuna', cliente_ciudad = '$ciudad' WHERE cliente_rut = '$rut';";
if (mysqli_query($conn->conn,$query)) {
    $id = mysqli_insert_id($conn->conn);
    LogDao::insertarLog("CLIENTE MODIFICADO CON EL RUT: $rut%$nombre%$giro%$mail%$direccion%$comuna%$ciudad%$telefono", 11);
    echo "{\"mensaje\":\"Cliente modificado\"}";
} else {
    echo "{\"error\":\"".mysqli_error($conn->conn)."\"}";
}

