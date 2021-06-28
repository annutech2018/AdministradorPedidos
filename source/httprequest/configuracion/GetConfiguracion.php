<?php
    include '../../conexion/Conexion.php';
    include '../../query/ConfiguracionDao.php';

    header('Content-Type: application/json');

    $ip = ConfiguracionDao::getConfiguracion("ip_servidor");
    $nombre = ConfiguracionDao::getConfiguracion("nombre_web_service");
    
    echo "{\"ip\":\"".$ip."\","
        . "\"nombre\":\"".$nombre."\""
    ."}";