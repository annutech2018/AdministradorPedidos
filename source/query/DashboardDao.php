<?php
include '../../conexion/Conexion.php';
include '../../dominio/Data.php';

class DashboardDao {

    public function getPedidos()
    {
        $array = array();
        $date = getdate();
        $mes = $date['mon'] < 10 ? "0".$date['mon'] : $date['mon'];
        $anio = $date['year'];
        $fecha = $anio."-".$mes."-01";
        try {
            $query = "SELECT pedido_estado,count(*) as pedido_total FROM tbl_pedido WHERE pedido_fecha >= '$fecha' GROUP BY pedido_estado ORDER BY pedido_estado"; 
            $conexion = new Conexion();
            $conexion->conectar();
            $result = mysqli_query($conexion->conn,$query); 
            while($row = mysqli_fetch_array($result)) {
                $data = new Data();
                $data->setItem($row['pedido_estado']);
                $data->setCantidad($row['pedido_total']);
                array_push($array, $data);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $array;
    }
    
}
