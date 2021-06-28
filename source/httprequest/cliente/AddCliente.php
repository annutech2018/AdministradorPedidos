<?php
include '../../query/LogDao.php';

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
$query = "INSERT INTO tbl_cliente(cliente_rut, cliente_nombre, cliente_giro,"
        . " cliente_mail,cliente_telefono,cliente_direccion,"
        . " cliente_comuna,cliente_ciudad)"
        . " VALUES ('$rut','$nombre','$giro','$mail','$telefono','$direccion','$comuna','$ciudad')";
if (mysqli_query($conn->conn,$query)) {
    $id = mysqli_insert_id($conn->conn);
    LogDao::insertarLog("CLIENTE AGREGADO CON EL RUT: ".$rut, 7);
    echo "{\"mensaje\":\"Cliente agregado\"}";
} else {
    echo "{\"error\":\"".mysqli_error($conn->conn)."\"}";
}