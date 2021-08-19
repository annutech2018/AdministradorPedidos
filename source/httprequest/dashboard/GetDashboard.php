<?php
include '../../query/DashboardDao.php';

header('Content-Type: application/json');
$dashboardDao = new DashboardDao();
$pedidos = $dashboardDao->getPedidos();
$normal = 0;
$rappi = 0;
$pedidosYa = 0;

for($i = 0; $i < count($pedidos); $i++){
    $aux = $pedidos[$i];
    if($aux->getItem() == '0'){
        $normal = $aux->getCantidad();
    } else if($aux->getItem() == '1'){
        $pedidosYa = $aux->getCantidad();
    } else if($aux->getItem() == '2'){
        $rappi = $aux->getCantidad();
    }
}
echo "{\"normal\":\"".$normal."\","
    . "\"rappi\":\"".$rappi."\","
    . "\"pedidos_ya\":\"".$pedidosYa."\"}";