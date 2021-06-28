<?php

class LogServer {

    public static function write_log($cadena,$tipo)
    {
        $arch = fopen("/home/bleachap/public_html/log/log_".date("Y-m-d").".txt", "a+"); 
        $log = "[".date("Y-m-d H:i:s.u")." ".$_SERVER['REMOTE_ADDR']." USUARIO: ".$_SESSION['agente']." - $tipo ] ".$cadena."\n";
	fwrite($arch, $log);
	fclose($arch);
    }
        
    public static function write_error_log($error)
    {
        $arch = fopen("log/log_error_".date("Y-m-d").".txt", "a+"); 
        $log = "[".date("Y-m-d H:i:s.u")." ".$_SERVER['REMOTE_ADDR']." ERROR: ".$error."\n";
	fwrite($arch, $log);
	fclose($arch);
    }
    
    public static function write_app_log($error)
    {
        $arch = fopen("log/log_app_error_".date("Y-m-d").".txt", "a+"); 
        $log = "[".date("Y-m-d H:i:s.u")." ".$_SERVER['REMOTE_ADDR']." ERROR: ".$error."\n";
	fwrite($arch, $log);
	fclose($arch);
    }
}
