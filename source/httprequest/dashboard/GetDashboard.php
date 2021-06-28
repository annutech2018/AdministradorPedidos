<?php
include '../../query/DashboardDao.php';

header('Content-Type: application/json');
$dashboardDao = new DashboardDao();
$pedidos = $dashboardDao->getPedidos();
$creado = 0;
$aceptado = 0;
$despachado = 0;
$entregado = 0;
for($i = 0; $i < count($pedidos); $i++){
    $aux = $pedidos[$i];
    if($aux->getItem() == '0'){
        $creado = $aux->getCantidad();
    } else if($aux->getItem() == '1'){
        $aceptado = $aux->getCantidad();
    } else if($aux->getItem() == '2'){
        $despachado = $aux->getCantidad();
    } else if($aux->getItem() == '3'){
        $entregado = $aux->getCantidad();
    }
}
echo "{\"creado\":\"".$creado."\","
    . "\"aceptado\":\"".$aceptado."\","
    . "\"despachado\":\"".$despachado."\","
    . "\"entregado\":\"".$entregado."\"}";