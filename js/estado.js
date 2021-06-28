/* global google, alertify */

var MENU_VISIBLE = false;

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
    
    $("#codigo").keydown(function(e){
        if(isTeclaEnter(e)){
            buscar();
        }
    });

});


function buscar(){
    let codigo = $("#codigo").val();
    if(codigo === ''){
        alertify.error("Ingrese número de pedido");
        return;
    }
    if(isNaN(codigo)){
        alertify.error("número de pedido inválido");
        return;
    }
    var params = {id : codigo};
    var url = "source/httprequest/pedido/GetPedidoDetalleCliente.php";
    var success = function(response)
    {
        if(response.length === 0){
            alertify.success("N PEDIDO NO ENCONTRADO");
            return;
        }
        $("#cont1").css("display","none");
        $(".img3").css("display","none");
        $(".img4").css("display","none");
        $("#nro_pedido").css("display","block");
        $(".res1").css("display","block");
        $(".res2").css("display","block");
        $(".cont-id-pedido").css("display","block");
        $(".volver").css("display","inline-block");
        $("#cont_estado").css("visibility","visible");
        $(".max").css("visibility","visible");
        $(".pie-cliente").css("visibility","visible");
        if(response[0].pedido_id_aux !== '0'){
            $("#nro_pedido").html(response[0].pedido_id_aux);
        }else{
            $("#nro_pedido").html(response[0].pedido_id);
        }
        $("#nombre_pedido").html(response[0].pedido_cliente_nombre);
        $("#dir_pedido").html(response[0].pedido_cliente_direccion);
        var estado = '';
        if(response[0].pedido_estado === '0'){
            estado = 'creado';
        } if(response[0].pedido_estado === '1'){
            estado = 'aceptado';
        }if(response[0].pedido_estado === '2'){
            estado = 'despachado';
        } if(response[0].pedido_estado === '3'){
            estado = 'entregado';
        }
        $("#estado").html(estado.toUpperCase());
        var despachado = response[0].pedido_despachado;
        if(despachado === ''){
            $("#despachado").html("PENDIENTE");            
        }else{
            $("#despachado").html(despachado);
    }   
        var msj = 'Para realizar seguiminto al envío de tu producto pincha ';
        if(despachado === 'CHILE EXPRESS'){
            $("#url_des").html(msj+"<a target='_blank' href='https://www.chilexpress.cl/estado-envio-paquete-courier'>acá</a>");
        }else if(despachado === 'STARKEN'){
            $("#url_des").html(msj+"<a target='_blank' href='https://www.starken.cl/seguimiento'>acá</a>");
        }else if(despachado === 'CORREOS DE CHILE'){
            $("#url_des").html(msj+"<a target='_blank' href='https://www.correos.cl/seguimiento-en-linea'>acá</a>");
        }
        var adjunto = '';
        if(response[0].pedido_adjunto_despacho !== ''){
            adjunto = "<a href='javascript:void(0)'onClick=\"verAdjunto('"+response[0].pedido_adjunto_despacho+"')\"><img alt='Ver adjunto' title='Ver adjunto' width='40' height='40' src='img/detalle.png'><a/>";
        } else{
            adjunto = "NO DISPONIBLE";
        }
        $("#adjuntado").html(adjunto);
        if(response[0].pedido_codigo_despacho !== ''){
            $("#despa2").html("Recuerda que tu codigo de despacho es: <span id='despa'>"+response[0].pedido_codigo_despacho+"</span>");
        }
        $("#tabla_detalle tbody").html("");
        for(var i = 0; i < response.length;i++){
            var detalle = response[i];
            var nombre = detalle.producto_nombre;
            var cantidad = Math.round(detalle.detalle_cantidad);
            var total = Math.round(detalle.pedido_total);
            
            $("#tabla_detalle tbody").append("<tr><td>"+nombre+"</td><td>"+cantidad+"</td><td>"+total+"</td></tr>");
        }
    };
    postRequest(url,params,success,false);
}

function verAdjunto(archivo){
    window.open('source/util/despacho/'+archivo);
}