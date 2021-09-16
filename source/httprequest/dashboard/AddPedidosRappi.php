<?php
include '../../query/LogDao.php';

$conexion = new Conexion();
$conexion->conectar();

$token = '';
$query = "SELECT token_valor FROM tbl_token WHERE token_tipo = 1"; 

$result = mysqli_query($conexion->conn,$query); 
while($row = mysqli_fetch_array($result)) {
    $token = trim($row["token_valor"]);
}

$handle = curl_init();
 
$url = "https://microservices.dev.rappi.com/api/v2/restaurants-integrations-public-api/orders";
 
// Set the url
curl_setopt($handle, CURLOPT_URL, $url);
// Set the result output to be a string.
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

curl_setopt($handle, CURLOPT_HTTPHEADER, array(
    'User-Agent: Mozilla/5.0',
    'Content-Type: application/json',
    'Accept: application/json',
    'x-authorization: bearer '.$token
    ));
 
$output = curl_exec($handle);
 
curl_close($handle);
$json = json_decode($output,true);

if(isset($json["message"])){
    echo "existe";
    
    $handle = curl_init();
 
    $url = "https://rests-integrations-dev.auth0.com/oauth/token";

    curl_setopt($handle, CURLOPT_URL, $url);
    $payload = json_encode( array( "client_id"=> "Uy1M32XTRFendX6WJVKxbMyioj8WcrFm",
                                    "client_secret"=> "BojZUSsRle_I3O7D8RUzJeGzxmQTmN2AuW8YgI6N2AlkFXp43v0VNCl5jlbZq7w5",
                                    "audience"=>"https://services.rappi.cl/api/v2/restaurants-integrations-public-api",
                                    "grant_type"=>"client_credentials") );
    curl_setopt( $handle, CURLOPT_POSTFIELDS, $payload );
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_HTTPHEADER, array(
        'User-Agent: Mozilla/5.0',
        'Content-Type: application/json',
        'Accept: application/json'
    ));
    
    $output = curl_exec($handle);
 
    curl_close($handle);
    $token = json_decode($output,true)["access_token"];
    $query = "UPDATE tbl_token SET token_valor = '$token' WHERE token_tipo = 1";
    if (mysqli_query($conexion->conn,$query)) {
        echo "token actualizado";
    } else{
        echo "error al actualizar token";
    }
    exit();
    
} else {
    "no";
}

foreach ($json as $data) {
    $pedido = $data["order_detail"];
    $pedidoId = $pedido["order_id"];
    $total = $pedido["totals"]["total_order"];
    $rutCliente = $pedido["billing_information"]["document_number"];
    $nombreCliente = $pedido["billing_information"]["name"];
    $direccionCliente = $pedido["billing_information"]["address"];
    $telefonoCliente = $pedido["billing_information"]["phone"];
    $correoCliente = $pedido["billing_information"]["email"];
    $fecha = $pedido["created_at"];
   echo $fecha;
    $query = "INSERT INTO tbl_pedido (pedido_id_aux,pedido_total,pedido_cliente_nombre,"
            . "pedido_cliente_direccion,pedido_cliente_comuna,pedido_cliente_telefono,pedido_cliente_mail,pedido_estado,pedido_fecha,pedido_tipo)"
            . " VALUES ('$pedidoId','$total','$rutCliente','$nombreCliente','$direccionCliente','$telefonoCliente'"
            . ",'$correoCliente','0','$fecha','1')"; 
    if (mysqli_query($conexion->conn,$query)) {
        $idPedidoAgregado = mysqli_insert_id($conexion->conn);
        LogDao::insertarLog("PEDIDO RAPPI AGREGADO: ".$pedidoId, 100);
        
            for($i = 0 ; $i < count($pedido["items"]); $i++){
                $sku = $pedido["items"][$i]["sku"];
                $id = $pedido["items"][$i]["id"];
                $nombreProducto = $pedido["items"][$i]["name"];
                $precio = $pedido["items"][$i]["unit_price_with_discount"];
                $precioSinDescuento = $pedido["items"][$i]["unit_price_without_discount"];
                $porcentajeDesc = $pedido["items"][$i]["percentage_discount"]; 
                $cantidad = $pedido["items"][$i]["quantity"];

                $query = "INSERT INTO tbl_detalle (detalle_producto,detalle_producto_nombre,detalle_producto_precio,"
                    . " detalle_cliente_descuento ,detalle_cantidad,detalle_pedido)"
                    . " VALUES ('$sku','$nombreProducto','$precio','$porcentajeDesc','$cantidad','$idPedidoAgregado')"; 
                if (mysqli_query($conexion->conn,$query)) {
                    $id = mysqli_insert_id($conexion->conn);
                    echo "{\"mensaje\":\"ok\"}";
                } else{
                    echo "{\"mensaje\":\"error\"}";
                }



            }
        
        echo "{\"mensaje\":\"ok\"}";
    } else{
        echo "{\"mensaje\":\"error\"}";
    }
    
}

