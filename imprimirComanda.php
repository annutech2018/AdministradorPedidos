<?php
require_once "vendor/autoload.php";

include './source/util/fpdf.php';
include './source/conexion/Conexion.php';

use Picqer\Barcode\BarcodeGeneratorPNG;

$generador = new BarcodeGeneratorPNG();

$id = filter_input(INPUT_GET, "id");
$query = "SELECT * FROM tbl_pedido JOIN tbl_detalle ON pedido_id = detalle_pedido WHERE pedido_id = $id ";

$rut = "";
$nombre = "";
$direccion = "";
$comuna = "";
$productos = [];

$conn = new Conexion();
try {
    $conn->conectar();
    $result = mysqli_query($conn->conn,$query);
    while($row = mysqli_fetch_array($result)) {
        $nombre = $row["pedido_cliente_nombre"];
        $direccion = $row["pedido_cliente_direccion"];
        $comuna = $row["pedido_cliente_comuna"];
        $telefono = $row["pedido_cliente_telefono"];
        array_push($productos, $row["detalle_producto_nombre"]."%".round($row["detalle_cantidad"]));
    }
    
} catch (Exception $exc) {
    echo $exc->getTraceAsString();
}

$largo = count($productos);

$texto = $id;
$tipo = $generador::TYPE_EAN_13;
file_put_contents('image.png', $imagen = $generador->getBarcode($texto, $tipo));
$pdf = new FPDF('L','mm',[35+(3*$largo)+30,70]);
$pdf->AddPage();
$pdf->SetFont('Arial','',8);
$largo = 13 - strlen($texto);
$codigoAux = "";
for($i = 0; $i < $largo;$i++){
    $codigoAux.="0";
}
$array = str_split($id);
for($j=0;$j<strlen($id);$j++){
    $codigoAux.= $array[$j]." ";
}
$x = 5;

$pdf->SetFont('Arial','B',8);
$pdf->Text($x,5, 'Dimetro food');
$pdf->Text($x,8, "-----------------------------");
$pdf->Text($x,11, "Datos cliente");
$pdf->SetFont('Arial','',8);
$pdf->Text($x,17, "Nombre: ".utf8_decode($nombre));
$pdf->Text($x,20, utf8_decode("Dirección: ".$direccion));
$pdf->Text($x,23, "Comuna: ".utf8_decode($comuna));
$pdf->Text($x,26, utf8_decode("Teléfono: ".$telefono));
$pdf->Text($x,32, "Productos: ");
$y = 35;

for($i = 0; $i < count($productos); $i++){
    $data = explode("%",$productos[$i]);
    $pdf->Text($x,$y, "$data[0]: $data[1]");    
    $y = $y + 3;
}

$pdf->Text(5,$y+5, $codigoAux);    
$pdf->Image('image.png' , 5 ,$y+7, 25 ,18,'PNG', '');

$pdf->Output();
