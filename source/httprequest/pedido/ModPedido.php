<?php
include '../../query/LogDao.php';
header('Content-Type: application/json');
ini_set('default_charset', 'ISO-8859-1');
$id = filter_input(INPUT_POST, 'id');
$fecha = DateTime::createFromFormat('d/m/Y H:i', filter_input(INPUT_POST, 'fecha'))->format('Y/m/d H:i:s');
$cliente = addslashes(filter_input(INPUT_POST, 'cliente'));
$descuento = filter_input(INPUT_POST, 'descuento');
$total = filter_input(INPUT_POST, 'total');
$nombre = addslashes(filter_input(INPUT_POST, 'nombre'));
$direccion = addslashes(filter_input(INPUT_POST, 'direccion'));
$comuna = addslashes(filter_input(INPUT_POST, 'comuna'));
$telefono = addslashes(filter_input(INPUT_POST, 'telefono'));
$mail = addslashes(filter_input(INPUT_POST, 'mail'));
$ig = addslashes(filter_input(INPUT_POST, 'ig'));
$observacion = addslashes(filter_input(INPUT_POST, 'observacion'));
$despachado = filter_input(INPUT_POST, 'despachado');
$adicional = filter_input(INPUT_POST, 'adicional');
session_start();
$usuario = $_SESSION["agente"];
$conn = new Conexion();
$conn->conectar();
echo "1";
if($_SESSION["tipo"] == "3"){
    exit();
}
echo "2";
$query = "UPDATE tbl_pedido SET pedido_total = '$total',pedido_descuento = '$descuento', pedido_cliente = '$cliente',pedido_cliente_nombre = '$nombre',"
        . "pedido_cliente_direccion = '$direccion',pedido_cliente_comuna = '$comuna',pedido_cliente_telefono = '$telefono',"
        . "pedido_cliente_mail = '$mail',pedido_usuario = '$usuario',pedido_fecha = '$fecha',pedido_ig = '$ig',pedido_observacion = '$observacion',pedido_despachado = '$despachado',pedido_envio_adicional = '$adicional' WHERE pedido_id = '$id'";
if (mysqli_query($conn->conn,$query)) {
    echo "{\"mensaje\":\"1\"}";
}
else{
    echo "{\"error\":\"Error: ".mysqli_error($conn->conn)."\"}";
}