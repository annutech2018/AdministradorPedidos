<?php
include '../../conexion/Conexion.php';

$codigo = filter_input(INPUT_POST, 'codigo');
$entrada = filter_input(INPUT_POST, 'entrada')==""?"0":filter_input(INPUT_POST, 'entrada');
$salida = filter_input(INPUT_POST, 'salida')==""?"0":filter_input(INPUT_POST, 'salida');
$conn = new Conexion();
$conn->conectar();
$query = "INSERT INTO tbl_inventario(inventario_producto,inventario_entrada,inventario_salida) VALUES ('$codigo',$entrada,$salida);";
if (mysqli_query($conn->conn,$query)) {
    $id = mysqli_insert_id($conn->conn);
} else {
    echo mysqli_error($conn->conn);
}