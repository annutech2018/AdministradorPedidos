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


$texto = $id;
$tipo = $generador::TYPE_EAN_13;
file_put_contents('image.png', $imagen = $generador->getBarcode($texto, $tipo));
$pdf = new FPDF('L','mm',[100,100]);
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

$pdf->Text($x,5, 'Dimetro food');
$pdf->Text($x,8, utf8_decode($nombre));
$pdf->Text($x,11, utf8_decode($direccion));
$pdf->Text($x,14, utf8_decode($comuna));
$pdf->Text($x,17, $telefono);
$pdf->Text($x,22, "Productos: ");
$y = 17;

if(count($productos) == 1){
    $data = explode("%",$productos[0]);
    $pdf->Text($x,$y, "$data[0]: $data[1]");    
} else if(count($productos) == 2){
    $data = explode("%",$productos[0]);
    $pdf->Text($x,$y, "$data[0]: $data[1]");   
    $data2 = explode("%",$productos[1]);
    $pdf->Text($x,$y+3, "$data2[0]: $data2[1]");   
} else if(count($productos) == 3){
    $data = explode("%",$productos[0]);
    $pdf->Text($x,$y, "$data[0]: $data[1]");  
    $data2 = explode("%",$productos[1]);
    $pdf->Text($x,$y+3, "$data2[0]: $data2[1]"); 
    $data3 = explode("%",$productos[2]);
    $pdf->Text($x,$y+6, "$data3[0]: $data3[1]"); 
} else if(count($productos) >= 4){
    $data = explode("%",$productos[0]);
    $pdf->Text($x,$y, "$data[0]: $data[1]");  
    $data2 = explode("%",$productos[1]);
    $pdf->Text($x,$y+3, "$data2[0]: $data2[1]"); 
    $data3 = explode("%",$productos[2]);
    $pdf->Text($x,$y+6, "$data3[0]: $data3[1]"); 
    $x1 = 32;
    $y1 = 3;
    $pdf->AddPage();
    $pdf->Text(5,2, $codigoAux);  
    $pdf->Image('image.png' , 5 ,3, 25 ,28,'PNG', '');
    for($i = 3;$i < count($productos);$i++){
        $y1 += 3;
        $data = explode("%",$productos[$i]);
        $pdf->Text($x1,$y1, "$data[0]: $data[1]");
    }
}

$pdf->Text(5,79, $codigoAux);    
$pdf->Image('image.png' , 5 ,80, 25 ,18,'PNG', '');

$pdf->Output();
