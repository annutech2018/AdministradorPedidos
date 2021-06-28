/* global google */

var MENU_VISIBLE = false;
var TIPO_USUARIO;

$(document).ready(function(){
    $("#menu").load("menu.php", function( response, status, xhr ) {
        agregarclase($("#principal"),"menu-activo");
        
        $(".opcion-menu").mouseover(function (){
            if(!MENU_VISIBLE)
            {
                abrirTooltip("tooltip_"+$(this).attr("id"));
            }
        });
        
        $(".opcion-menu").mouseout(function (){
            cerrarTooltip("tooltip_"+$(this).attr("id"));
        });
    
    });    
    $("#contenido-central").load("home.php");
    getUsuario();
    getConfiguracion();
//    getfecha();
//    setInterval(function(){getfecha();},5000);
    
    $("#menu-telefono").click(function(){
        if($("#menu-telefono").attr('src') === 'img/menu.svg')
        {
            cambiarPropiedad($("#menu"),"display","block");
            $("#menu-telefono").attr("src","img/cancelar.svg");
        }
        else
        {
            cambiarPropiedad($("#menu"),"display","none");
            $("#menu-telefono").attr("src","img/menu.svg");
        }
    });
    
    $("#btn_menu").click(function () {
        //abrirMenu();
    });
    
    $("#enlace-salir").click(function() {
        salir();
    });
    
});

function getConfiguracion()
{
    var url = "source/httprequest/configuracion/GetConfiguracion.php";
    var success = function(response)
    {
        IP_SERVIDOR = response.ip;
        NOMBRE_WS = response.nombre;
    };
    getRequest(url,success,false);
}
