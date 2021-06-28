<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of funciones
 *
 * @author HP
 */
class Funciones {
    
    
    public static function formatoFecha($fecha)
    {
                       
        $newDate = date("d-m-Y H:i", strtotime($fecha));  
        //echo "La FECHA ERA ASI: $fecha Y AHORA ES ASI ".$newDate. "";  
        
        return $newDate;
         
    }
    
    
    public static function formatoResumen($resumen,$tipo)
    {
        $arrayResumen = explode('%',$resumen);
        $contenidoImp="";
        $arrayText;
        if($tipo == '11'){
            $arrayText = array ("Código: ", "Nombre: " ,"Apellido: "," E-mail: ");
        }
        if($tipo == '14'){
            $arrayText = array ("Código: ", "Nombre: " ,"Descripcion: "," Precio Venta: ");
        }
        if($tipo == '17'){
            $arrayText = array ("Nombre: ", "Clave: " ,"Saldo: "," Tipo: ");
        }
        if($tipo == '24'){
            $arrayText = array ("Nombre: " ,"Descripción : ");
        }
        
        if ($tipo == '11' || $tipo =='14' || $tipo=='17'|| $tipo=='24' ) 
        {
            for($i=0; $i<count($arrayText); $i++)
            {
                if ($i>0) {
                    $contenidoImp .= '  '.$arrayText[$i].'   '.$arrayResumen[$i].' ';
                    echo "<br>";
                }
                else {
                    $contenidoImp .= '    '.$arrayResumen[$i].' ';
                }
            }
            return $contenidoImp;
        }
        else 
        {
            return $resumen;
        }
        
    }
    
    
    public static function archivoTexto($file)
    {
        $file = fopen("archivo.txt", "a")
        or die("Problema al crear archivo");

        fwrite($file, "Esta es una prueba bro ");
        fwrite($file, "\n");
        fclose($file);
        
        return $file;
        
        
        //$file = fopen("arcchivo.txt", "r")
        //or die("Problema al abrir arichivo");
        //while (!feof($file))
        //{
        //    $leer = fgetc($file);
        //    $imprimir = nl2br($leer);
        //    echo $imprimir;
        //}
    }
    
    public static function aplicarDescuentoFix($precio) {
        $final = $precio;
        $precioEntero = explode(".", $final)[0];
        $aux = substr($precioEntero, -1);
        echo "aux ".$aux;
        if ($aux > 0 && $aux <= 5){
            $final = $precioEntero - $aux;
        }
        else if ($aux >= 6) {
            $aux2 = 10 - $aux;
            $precio = $precioEntero + $aux2;
            $final = $precio;
        }
        return $final;
    }

}