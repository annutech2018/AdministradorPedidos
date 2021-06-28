/* global google, alertify, urlBase, bordeRojo, VALOR_AUX */

function buscar(){
    let id = $("#id").val();
    let aux = $("#aux").val();
    if(id === '' || aux === ''){
        alertify.error("Ingrese número de pedido");
        return;
    }
    if(isNaN(id) || isNaN(aux)){
        alertify.error("número de pedido inválido");
        return;
    }
    var params = {id : id, aux : aux};
    var url = "source/httprequest/pedido/GetPedidoDetalleDespacho.php";
    var success = function(response)
    {
        if(response.length === 0){
            alertify.success("N PEDIDO NO ENCONTRADO");
            return;
        }
        
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
            adjunto = "<a href='javascript:void(0)'onClick=\"verAdjunto('"+response[0].pedido_adjunto_despacho+"')\"><img alt='Ver adjunto' title='Ver adjunto' width='20' height='20' src='img/detalle.png'><a/>";
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


function entregar(){
    var pedido = $("#id").val();
    cambiarEstado(pedido,3);
}

function login(){
    var usuario = $("#usuario").val();
    var password = btoa($("#password").val());
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
            entregar();
        }
    };
    var error = function(){
        alertify.error("error");
    };
    postRequest(url,params,success,error);
}

function cambiarEstado(id,valor){
        if(valor === '4'){
            if(confirmar('Anular pedido','¿Esta seguro que desea anular el pedido?',function(){
                var correo = '';
                var url = "source/httprequest/pedido/GetPedido.php";
                var params = {id : id};
                var success = function(response)
                {
                    correo = response.pedido_cliente_mail;
                    var url = "source/httprequest/pedido/ModEstadoPedido.php";
                    var params = {id : id,estado : valor};
                    var success = function(response)
                    {   
                        if(response.mensaje ==='0'){
                            alertify.error("Ocurrio un error en el servidor");
                        } else{
                            if(valor === '3'){
                                if(response.pedido_id_aux !== '0'){
                                    enviarCorreo(correo,response.pedido_id_aux);
                                }else{
                                    enviarCorreo(correo,id);
                                }
                            }
                            alertify.success("Estado modificado");
                            $("#aceptar").css("display","none");
                        }
                    };
                    postRequest(url,params,success);
                };
                postRequest(url,params,success);
            }),function(){return false});
        }
        else{
            var correo = '';
            var url = "source/httprequest/pedido/GetPedido.php";
            var params = {id : id};
            var success = function(response)
            {
                correo = response.pedido_cliente_mail;
                var url = "source/httprequest/pedido/ModEstadoPedido.php";
                var params = {id : id,estado : valor};
                var success = function(response)
                {   
                    if(response.mensaje ==='0'){
                        alertify.error("Ocurrio un error en el servidor");
                    } else{
                        if(valor === '3'){
                            enviarCorreo(correo,id);
                        }
                        alertify.success("Estado modificado");
                        $("#aceptar").css("display","none");
                    }
                };
                postRequest(url,params,success);
            };
            postRequest(url,params,success);
        }
    }
    
    function subirFichero(event,form,nombre,archivo,index,tipo,ext)
    {   
        var aux = archivo.val().split(".")[1].toLowerCase();
        var url = 'source/util/subirFichero.php?nombre='+nombre+'&archivo='+archivo.val()+"&ext="+ext+"&tipo="+VALOR_AUX;
        $.ajax({
            async: true,
            type: 'POST',
            url: url,
            data: new FormData(form[0]),
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function (xhr) {
                //if(ext === 'xls'){
                    mostrarTrasero();
                    cambiarPropiedad($("#form_cargando"),"visibility","visible");
                //}
            },   
            success: function(){         
                var archivo = $("#comprobanteOcultaDespacho"+index).val();
                modificarAdjuntoPedido(nombre,archivo,tipo);
            },
            error: function(response){}
        });
        event.preventDefault();
    }
    
    function modificarAdjuntoPedido(id,adjunto,tipo){
        var url = "source/httprequest/pedido/ModAdjuntoPedido.php";
        var params = {id : id,adjunto:id+"_"+adjunto,tipo:tipo};
        var success = function(response)
        {
            if(response.mensaje ==='0'){
                alertify.error("Ocurrio un error en el servidor");
            } else{
                
                alertify.success("Adjunto cargado");
            }
        };
        postRequest(url,params,success);
    }