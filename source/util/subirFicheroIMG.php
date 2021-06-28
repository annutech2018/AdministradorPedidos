<?php
$archivo = $_REQUEST["archivo"];
$fichero_subido = 'img/productos/'.$archivo;
$fichero_local = "./".$archivo;

if (move_uploaded_file($_FILES["imagen"]['tmp_name'], $fichero_subido)) {
    
}
else
{
    echo "Not uploaded because of error #".$_FILES["imagen"]["error"];
}



