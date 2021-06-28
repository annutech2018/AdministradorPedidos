/* global bordeAzul, bordeBlanco, bordeRojo, urlBase, alertify, KEY */
$(document).ready(function(){
    darFoco($("#usuario"));
    cambiarPropiedad($("#usuario"),"border-bottom",bordeAzul);    
    $("#usuario").click(function(){
        cambiarFocoCamposLogin($(this),$("#password")); 
    });
    $("#usuario").keypress(function(e){
        if(isTeclaEnter(e)){
            darFoco($("#password"));
            cambiarFocoCamposLogin($("#password"),$("#usuario"));
        }
    });
    $("#usuario").focus(function(e){
        cambiarFocoCamposLogin($("#usuario"),$("#password"));
    });
    $("#password").click(function(){
        cambiarFocoCamposLogin($(this),$("#usuario")); 
    });
    $("#password").keypress(function(e){
        if(isTeclaEnter(e)){
            login();
        }
    });
    $("#password").focus(function(e){
        cambiarFocoCamposLogin($("#password"),$("#usuario"));
    });
    $("#entrar").click(function(){
        login();
    });
});

function cambiarFocoCamposLogin(campoActual,campoAnterior)
{
    cambiarPropiedad(campoActual,"border-bottom",bordeAzul); 
    cambiarPropiedad(campoAnterior,"border-bottom",bordeBlanco); 
}

function login(){
    var usuario = $("#usuario").val();
    var password = btoa($("#password").val());
    //var password = $("#password").val();
    if(usuario === '' || password === '')
    {
        alertify.error("Ingrese usuario y contraseña");
        if(usuario === '')
        {
            cambiarPropiedad($("#usuario"),"border-bottom",bordeRojo); 
        }
        if(password === '')
        {
            cambiarPropiedad($("#password"),"border-bottom",bordeRojo);    
        }   
        return;
    }
    var url = urlBase + "/usuario/Login.php";
    var params = { usuario: usuario, password : (password)};
    var success = function(response){
        if(response.usuario_id === 0)
        {
            cambiarPropiedad($("#loader"),"visibility","hidden");
            alertify.error("Usuario y/o contraseña no coinciden");
        }
        else if(parseInt(response.usuario_id) > 0)
        {
            if(response.usuario_tipo === 4){
                cambiarPropiedad($("#loader"),"visibility","hidden");
                alertify.error("Usuario sin permisos");
            } else{
                redireccionar("principal.php");
            }
        }
    };
    var error = function(){
        alertify.error("error");
    };
    postRequest(url,params,success,error);
}




