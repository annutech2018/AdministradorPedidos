<?php
include '../log/LogServer.php';
include '../../query/LogDao.php';

header('Content-Type: application/json');
ini_set('default_charset', 'ISO-8859-1');
$fecha = DateTime::createFromFormat('d/m/Y H:i', filter_input(INPUT_POST, 'fecha'))->format('Y/m/d H:i:s');
$cliente = addslashes(filter_input(INPUT_POST, 'cliente'));
$descuento = filter_input(INPUT_POST, 'descuento');
$total = filter_input(INPUT_POST, 'total');
$clienteNombre = addslashes(filter_input(INPUT_POST, 'nombre'));
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

if($_SESSION["tipo"] == "3"){
    exit();
}

$query = "INSERT INTO tbl_pedido(pedido_total,pedido_descuento, pedido_cliente,pedido_cliente_nombre,pedido_cliente_direccion,pedido_cliente_comuna,pedido_cliente_telefono,pedido_cliente_mail,"
        . " pedido_usuario,pedido_fecha,pedido_estado,pedido_ig,pedido_observacion,pedido_despachado,pedido_fecha_creacion,pedido_adjunto_pago,pedido_adjunto_despacho,pedido_envio_adicional)"
        . " VALUES ('$total','$descuento','$cliente','$clienteNombre','$direccion','$comuna','$telefono','$mail','$usuario','$fecha',0,'$ig','$observacion','$despachado',NOW(),'','','$adicional')";
if (mysqli_query($conn->conn,$query)) {
    $id = mysqli_insert_id($conn->conn);
    echo "{\"mensaje\":\"".$id."\"}";
}
else{
    $error = mysqli_error($conn->conn);
    LogServer::write_log("QUERY: ".$query." -  ERROR: ".$error, 0);
    echo "{\"error\":\"Error: ".$error."\"}";
}