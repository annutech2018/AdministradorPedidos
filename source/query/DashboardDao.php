<?php
include '../../conexion/Conexion.php';
include '../../dominio/Data.php';
include '../../dominio/Pedido.php';

class DashboardDao {

    public function getPedidos()
    {
        $array = array();
        $date = getdate();
        $mes = $date['mon'] < 10 ? "0".$date['mon'] : $date['mon'];
        $anio = $date['year'];
        $fecha = $anio."-".$mes."-01";
        try {
            $query = "SELECT pedido_tipo,count(*) as pedido_total FROM tbl_pedido WHERE pedido_estado = 1 AND pedido_fecha >= '$fecha' GROUP BY pedido_tipo ORDER BY pedido_tipo"; 
            $conexion = new Conexion();
            $conexion->conectar();
            $result = mysqli_query($conexion->conn,$query); 
            while($row = mysqli_fetch_array($result)) {
                $data = new Data();
                $data->setItem($row['pedido_tipo']);
                $data->setCantidad($row['pedido_total']);
                array_push($array, $data);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $array;
    }
    
    public function getPedidosNuevos()
    {
        $array = array();
        try {
            $query = "SELECT * FROM tbl_pedido WHERE pedido_estado = 0 ORDER BY pedido_id DESC"; 
            $conexion = new Conexion();
            $conexion->conectar();
            $result = mysqli_query($conexion->conn,$query); 
            while($row = mysqli_fetch_array($result)) {
                $pedido = new Pedido();
                $pedido->setId($row['pedido_id']);
                $pedido->setCliente($row['pedido_cliente_nombre']);
                $pedido->setTipo($row['pedido_tipo']);
                $pedido->setEstado($row['pedido_estado']);
                array_push($array, $pedido);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $array;
    }
    
}
