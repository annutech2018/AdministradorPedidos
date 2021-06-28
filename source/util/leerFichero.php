<?php
include '../conexion/Conexion.php';
include '../query/ConfiguracionDao.php';
header('Content-Type: application/json');
$archivo = $_REQUEST['archivo'];
$ruta = ConfiguracionDao::getConfiguracion('ruta_folios');
$reqFolio = $ruta."".$archivo;
$folios = simplexml_load_file($reqFolio);
echo "{\"folio_rut\":\"".$folios->CAF->DA->RE."\","
    . "\"folio_rs\":\"".$folios->CAF->DA->RS."\","
    . "\"folio_tipo\":\"".$folios->CAF->DA->TD."\","
    . "\"folio_desde\":\"".$folios->CAF->DA->RNG->D."\","
    . "\"folio_hasta\":\"".$folios->CAF->DA->RNG->H."\","
    . "\"folio_fecha\":\"".$folios->CAF->DA->FA."\"}";