<?php
//include '../util/validarPeticion.php';
include '../../conexion/Conexion.php';
include '../../dominio/Log.php';
//include './LogQuery.php';

class LogDao {
    
//    public function getLogs($resumen,$usuario,$ip,$desde,$hasta){
//        try {
//            $logs = array();
//            $query = "SELECT * FROM tbl_log LEFT JOIN tbl_usuario ON log_usuario = usuario_id WHERE 1=1 ";
//            if($resumen != ''){
//                $query .= " AND log_resumen ILIKE '%".$resumen."%'";
//            } if($usuario != ''){
//                $query .= " AND usuario_nombre ILIKE '%".$usuario."%'";                   
//            } if($ip != ''){
//                $query .= " AND log_ip ILIKE '".$ip."%'";
//            } if($desde != '' && $hasta != ''){
//                $query .= " AND log_fecha BETWEEN '".$desde."' AND '".$desde."'";
//            }
//            $conn = Conexion::conectar();
//            $result = pg_query($conn,$query); 
//            while($row = pg_fetch_array($result)) {
//                $log = new Log();
//                $log->setId($row["log_id"]);
//                $log->setResumen($row["log_resumen"]);
//                $log->setUsuario($row["usuario_nombre"]);
//                $log->setFecha($row["log_fecha"]);
//                $log->setIp($row["log_ip"]);
//                $log->setTipo($row["log_tipo"]);
//                array_push($logs, $log);
//            }
//        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
//        }
//        return $logs;
//    }
    
    public static function insertarLog($resumen,$tipo){
        $equipo = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $ip = $_SERVER['REMOTE_ADDR'];
        try {
            $conn = new Conexion();
            $conn->conectar();
            $query = "INSERT INTO tbl_log (log_resumen, log_usuario, log_fecha,"
                    . "log_nombre_equipo,log_ip,log_tipo) VALUES "
                    . "('" . $resumen . "','',CURRENT_TIMESTAMP,'$equipo','$ip',".$tipo .");";
            if(mysqli_query($conn->conn,$query)){
                
            }
            else{
                mysqli_errno($conn->conn);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }


    
}
