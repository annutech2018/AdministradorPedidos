<?php
include '../../query/DashboardDao.php';

header('Content-Type: application/json');
$dashboardDao = new DashboardDao();
$pedidos = $dashboardDao->getPedidosNuevos();
$normal = 0;
$rappi = 0;
$pedidosYa = 0;

echo "[";
for($i = 0; $i < count($pedidos); $i++){
    echo "{\"id\":\"".$pedidos[$i]->getId()."\","
        . "\"cliente\":\"".$pedidos[$i]->getCliente()."\","
        . "\"tipo\":\"".$pedidos[$i]->getTipo()."\","
        . "\"estado\":\"".$pedidos[$i]->getEstado()."\"}";
    if (($i+1) != count($pedidos))
    {
        echo ",";
    }
}
echo "]";