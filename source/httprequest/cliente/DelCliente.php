<?php
include '../../query/LogDao.php';
header('Content-Type: application/json');
$rut = filter_input(INPUT_POST, 'rut');
$conn = new Conexion();
$conn->conectar();
$query = "DELETE FROM tbl_cliente WHERE cliente_rut = '$rut'";
if (mysqli_query($conn->conn,$query)) {
    $id = mysqli_insert_id($conn->conn);
    LogDao::insertarLog("CLIENTE ELIMINADO CON EL RUT: $rut", 8);
    echo "{\"mensaje\":\"Cliente eliminado\"}";
} else {
    echo mysqli_error($conn->conn);
}

