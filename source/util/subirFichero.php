<?php
include '../conexion/Conexion.php';
include '../query/ConfiguracionDao.php';
require_once "../util/SimpleXLSX.php";

session_start();
if($_SESSION["tipo"] == "3"){
    exit();
}
$archivo = 'comprobante';
$id = filter_input(INPUT_GET, "nombre");
$ext = filter_input(INPUT_GET, "ext");
$tipo = filter_input(INPUT_GET, "tipo");
$upload_max_size = ini_get('upload_max_filesize');
$ruta = "$ext/";
$fichero_subido = $ruta.$id."_".$_FILES[$archivo]['name'];
echo $fichero_subido;
if (move_uploaded_file($_FILES[$archivo]['tmp_name'], $fichero_subido)) {
    echo "Successfully uploaded";
    if($ext == 'xls'){
        if ($xlsx = SimpleXLSX::parse("../util/$fichero_subido")) {
            $sheets=$xlsx->sheetNames(); 
            foreach($sheets as $index => $name){
                foreach ( $xlsx->rows($index) as $r => $row ) {
                    if(trim($row[0]) == 'Número de pedido'){
                        continue;
                    } else if(trim($row[0]) == 'Marca temporal'){
                        continue;
                    }
                    if(trim($row[0]) == ''){
                        continue;
                    }
                    if($tipo == 0){
                        $idAux = $row[0];
                        $estado = 0;
                        $fecha = $row[2];
                        $observacion = addslashes($row[3]);
                        $email = addslashes($row[11]);
                        $telefono = $row[12];
                        $nombre = addslashes($row[13]);
                        $apellido = addslashes($row[14]);
                        $direccion = addslashes($row[15]);
                        $comuna = addslashes($row[16]);
                        $total = $row[21];
                        $nombreProducto = addslashes($row[29]);
                        $cantidadProducto = $row[30];
                        $precioProducto = $row[31];
                        $codigo = "";
                        $conn = new Conexion();
                        $query = "SELECT producto_id FROM tbl_producto WHERE producto_nombre = '$nombreProducto'";
                        $conn->conectar();
                        $result = mysqli_query($conn->conn,$query); 
                        while($row = mysqli_fetch_array($result)) {
                            $codigo = $row["producto_id"];
                        }
                    } else if($tipo == 1){
                        $fecha = $row[0];
                        $prod = preg_split ("/\,/", $row[1]);
                        $nombre = trim(addslashes($row[2]));
                        $rut = $row[3];
                        $direccion = addslashes($row[4]);
                        $comuna = addslashes($row[5]);
                        $telefono = $row[6];
                        $ig = addslashes($row[7]);
                        $observacion = addslashes($row[8]);
                        $email = addslashes($row[9]);
                        $cantidad = $row[12]==""?"1":$row[12];
                    }
                    
                    
                    $usuario = $_SESSION["agente"];
                    $conn = new Conexion();
                    $conn->conectar();

                    $existe = 0;
                    $date = getdate();
                    $dia = $date['mday'] < 10 ? "0".$date['mday'] : $date['mday'];
                    $mes = $date['mon'] < 10 ? "0".$date['mon'] : $date['mon'];
                    $anio = $date['year'];
                    $hoy = $anio."-".$mes."-".$dia;
                    $fechaPedido = date_create($fecha);
                    if($tipo == 0){
                        $query = "SELECT pedido_id FROM tbl_pedido WHERE pedido_cliente_nombre = '$nombre $apellido' AND DATE_FORMAT(pedido_fecha,'%Y-%m-%d') = '".date_format($fechaPedido,"Y-m-d")."' ";
                    } else {
                        $query = "SELECT pedido_id FROM tbl_pedido WHERE pedido_cliente_nombre = '$nombre' AND DATE_FORMAT(pedido_fecha,'%Y-%m-%d') = '".date_format($fechaPedido,"Y-m-d")."' ";
                    }
                    $result = mysqli_query($conn->conn,$query) or die(mysqli_error($conn->conn)); 
                    while($row = mysqli_fetch_array($result)) {
                        $existe = $row["pedido_id"];        
                    }
                    if($existe == 0){
                        if($tipo == 0){
                            $query = "INSERT INTO tbl_pedido(pedido_id_aux,pedido_total,pedido_descuento, pedido_cliente,pedido_cliente_nombre,pedido_cliente_direccion,pedido_cliente_comuna,pedido_cliente_telefono,pedido_cliente_mail,"
                            . " pedido_usuario,pedido_despachado,pedido_fecha,pedido_estado,pedido_ig,pedido_observacion,pedido_fecha_creacion,pedido_adjunto_pago,pedido_adjunto_despacho)"
                            . " VALUES ('$idAux','$total','0','','$nombre $apellido','$direccion','$comuna','$telefono','$email','$usuario','','$fecha',0,'','$observacion',NOW(),'','')";
                        } else{
                            $total = 0;
                            for($i = 0; $i < count($prod);$i++){
                                $aux = explode("$", $prod[$i]);
                                $precioProducto = str_replace('.','',$aux[1]);
                                $total+=$precioProducto*$cantidad;
                            }
                            $query = "INSERT INTO tbl_pedido(pedido_total,pedido_descuento, pedido_cliente,pedido_cliente_nombre,pedido_cliente_direccion,pedido_cliente_comuna,pedido_cliente_telefono,pedido_cliente_mail,"
                            . " pedido_usuario,pedido_despachado,pedido_fecha,pedido_estado,pedido_ig,pedido_observacion,pedido_fecha_creacion,pedido_adjunto_pago,pedido_adjunto_despacho)"
                            . " VALUES ('$total','0','$rut','$nombre','$direccion','$comuna','$telefono','$email','$usuario','','$fecha',0,'$ig','$observacion',NOW(),'','')";
                        }
                        if (mysqli_query($conn->conn,$query) or die(mysqli_error($conn->conn))) {
                            $id = mysqli_insert_id($conn->conn);
                            if($tipo == 0){
                                $precio = $precioProducto / 1.19;
                                $precioIva = $precio * 0.19;
                                $query = "INSERT INTO tbl_detalle (detalle_producto,detalle_producto_nombre,detalle_producto_precio,"
                                    . "detalle_producto_precio_iva,detalle_cantidad,detalle_pedido)"
                                    . " VALUES ('$codigo','$nombreProducto','$precio','$precioIva','$cantidadProducto','$id');";
                                if(mysqli_query($conn->conn,$query) or die(mysqli_error($conn->conn))){
                                    $query = "INSERT INTO tbl_inventario (inventario_producto,inventario_salida)"
                                        . " VALUES ('$codigo','$cantidadProducto');";
                                    mysqli_query($conn->conn,$query) or die(mysqli_error($conn->conn));
                                }
                            } else {
                                for($i = 0; $i < count($prod);$i++){
                                    $aux = explode("$", $prod[$i]);
                                    $nombreProducto = addslashes($aux[0]);
                                    $codigo = "";
                                    $conn = new Conexion();
                                    $query = "SELECT producto_id FROM tbl_producto WHERE producto_nombre = '$nombreProducto'";
                                    $conn->conectar();
                                    $result = mysqli_query($conn->conn,$query); 
                                    while($row = mysqli_fetch_array($result)) {
                                        $codigo = $row["producto_id"];
                                    }
                                    $precioProducto = str_replace('.','',$aux[1]);
                                    $precio = $precioProducto / 1.19;
                                    $precioIva = $precio * 0.19;
                                    $query = "INSERT INTO tbl_detalle (detalle_producto,detalle_producto_nombre,detalle_producto_precio,"
                                        . "detalle_producto_precio_iva,detalle_cantidad,detalle_pedido)"
                                        . " VALUES ('$codigo','$nombreProducto','$precio','$precioIva','$cantidad','$id');";
                                    if(mysqli_query($conn->conn,$query) or die(mysqli_error($conn->conn))){
                                        $query = "INSERT INTO tbl_inventario (inventario_producto,inventario_salida)"
                                        . " VALUES ('$codigo','$cantidad');";
                                        mysqli_query($conn->conn,$query) or die(mysqli_error($conn->conn));
                                    }
                                    
                                }
                            }
                        }
                    }
                    else{
                        if($tipo == 0){
                            $query = "UPDATE tbl_pedido SET pedido_total = pedido_total + $total WHERE pedido_id = $existe";
                            mysqli_query($conn->conn,$query);
                            $precio = $precioProducto / 1.19;
                            $precioIva = $precio * 0.19;
                            $query = "INSERT INTO tbl_detalle (detalle_producto,detalle_producto_nombre,detalle_producto_precio,"
                                . "detalle_producto_precio_iva,detalle_cantidad,detalle_pedido)"
                                . " VALUES ('$codigo','$nombreProducto','$precio','$precioIva','$cantidadProducto','$existe');";
                            if(mysqli_query($conn->conn,$query) or die(mysqli_error($conn->conn))){
                                $query = "INSERT INTO tbl_inventario (inventario_producto,inventario_salida)"
                                    . " VALUES ('$codigo','$cantidadProducto');";
                                mysqli_query($conn->conn,$query) or die(mysqli_error($conn->conn));
                            }
                        } else{
                            $total = 0;
                            for($i = 0; $i < count($prod);$i++){
                                $aux = explode("$", $prod[$i]);
                                $precioProducto = str_replace('.','',$aux[1]);
                                $total+=$precioProducto*$cantidad;
                            }
                            $query = "UPDATE tbl_pedido SET pedido_total = pedido_total + $total WHERE pedido_id = $existe";
                            mysqli_query($conn->conn,$query);
                            for($i = 0; $i < count($prod);$i++){
                                $aux = explode("$", $prod[$i]);
                                $nombreProducto = addslashes($aux[0]);
                                $precioProducto = str_replace('.','',$aux[1]);
                                $precio = $precioProducto / 1.19;
                                $precioIva = $precio * 0.19;
                                $codigo = "";
                                $conn = new Conexion();
                                $query = "SELECT producto_id FROM tbl_producto WHERE producto_nombre = '$nombreProducto'";
                                $conn->conectar();
                                $result = mysqli_query($conn->conn,$query); 
                                while($row = mysqli_fetch_array($result)) {
                                    $codigo = $row["producto_id"];
                                }
                                $query = "INSERT INTO tbl_detalle (detalle_producto,detalle_producto_nombre,detalle_producto_precio,"
                                    . "detalle_producto_precio_iva,detalle_cantidad,detalle_pedido)"
                                    . " VALUES ('$codigo','$nombreProducto','$precio','$precioIva','$cantidad','$existe');";
                                if(mysqli_query($conn->conn,$query) or die(mysqli_error($conn->conn))){
                                    $query = "INSERT INTO tbl_inventario (inventario_producto,inventario_salida)"
                                    . " VALUES ('$codigo','$cantidad');";
                                    mysqli_query($conn->conn,$query) or die(mysqli_error($conn->conn));
                                }
                            }
                        }
                    }
                }
            }
        } else {
            echo SimpleXLSX::parseError();
        }
    }
}
else
{
    echo "Not uploaded because of error #".$_FILES[$archivo]["error"];
}