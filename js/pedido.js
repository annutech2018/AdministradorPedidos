/* global alertify, urlUtil, TIPO_USUARIO, urlBase */

var ID_PDF_CORREO = 0;
var TIPO_PDF_CORREO = 0;
var totalTabla = 0;
var tipo = 'agregar';
var ID_PEDIDO = 0;
var indexAgregado = 0;
var input_sel;

$(document).ready(function(){
    $('#detalle_venta').hide();
    $('#enviar_correo').hide();
    iniciarFecha([$("#desde"),$("#hasta"),$("#fechaDetalle")]);
    iniciarHora([$("#horaDetalle")]);
    cargarClientes();
    cargarUsuarios();
    cargarVentas();
    
    $("#enlaceBuscar").click(function(){
        cargarVentas();
    });
    
    $("#enlaceAgregarPedido").click(function(){
        agregarPedido();
    });
    
    $("#enlaceLimpiar").click(function(){
       $("#id").val("");
       $("#desde").val("");  
       $("#hasta").val("");
       $("#estadoCombo").prop('selectedIndex',0);  
       $("#usuarioCombo").prop('selectedIndex',0);  
       $("#clienteCombo").prop('selectedIndex',0);  
       cargarVentas();
    });
    
    $("#clienteDetalle").blur(function(){
        if(tipo === 'agregar'){
            cargarCliente();
        }
    });
    
    $(".contenedor_busc input").keydown(function(e){
        if(isTeclaEnter(e)){
            cargarVentas();
        }
    });
    
    $("#adicional").change(function(){
        agregarProducto();
        var valor = $(this).val() / 2;
        var ciudad = $("#adicional option:selected").text();
        $("#idAdd"+indexAgregado).val("0");
        $("#idAdd"+indexAgregado).prop("disabled",true);
        $("#nombreAdd"+indexAgregado).val("ENVIO A "+ciudad);
        $("#nombreAdd"+indexAgregado).prop("disabled",true);
        $("#precioAdd"+indexAgregado).val(valor);
        $("#precioAdd"+indexAgregado).prop("disabled",true);
        $("#cantidadAdd"+indexAgregado).val(1);
        $("#cantidadAdd"+indexAgregado).prop("disabled",true);
        $("#totalAdd"+indexAgregado).val(valor);
        $("#totalAdd"+indexAgregado).prop("disabled",true);
        cambiarTotal();
        setDescuento($("#descuentoDetalle").val());
    });
    
    $("#clienteDetalle").keydown(function(e){
        if(isTeclaEnter(e)){
            if(tipo === 'agregar'){
                cargarCliente();
            }
        }
    });
    
    $("#descuentoDetalle").keydown(function(e){
        setDescuento($(this).val());
    });
    
    $("#descuentoDetalle").change(function(e){
        setDescuento($(this).val());
    });
       
    
    $("#enlaceExcel").click(function(){
        var params = "id="+$('#pedido').val()+"&estado="+$('#estadoCombo').val()+"&cliente="+
                $('#clienteCombo').val()+"&usuario="+$('#usuarioCombo').val()+"&desde="+$("#desde").val()+
                "&hasta="+$("#hasta").val();
        exportar('source/httprequest/pedido/GetPedidosExcel',params);
    });
    
    $(".trasero").click(()=>{
        $(".trasero").css("visibility","hidden");
        $(".detalle").css("visibility","hidden");
        $("#ingresar_codigo_pago").css("visibility","hidden");
        $("#ingresar_codigo_despacho").css("visibility","hidden");
    });
    
    if(TIPO_USUARIO !== '3'){
        $("#enlaceAgregarPedido").css("display","block");
//        $("#enlacePistolear").css("display","none");
    }

        
});

    function setDescuento(value){
        if(validarNumero(value)){
            if(value !== 0){
                var desc = (totalTabla * value ) / 100;
                var total = totalTabla;
                $("#totalDetalle").val(Math.round(total - desc));
            } else{
                $("#totalDetalle").val(totalTabla);
            }
        }
    }

    function enviarDte(id,tipo){
        var url = "source/util/enviarDte.php";
        var params = {id : id,tipo:tipo};
        var success = function(response)
        {
            cargarVentas();
            alertify.success("Documento enviado");
        };
        postRequest(url,params,success);
    }
    
    function cargarClientes(){
        var url = "source/httprequest/cliente/GetClientes.php";
        var params = {};
        var success = function(response)
        {
            for(var i = 0; i < response.length; i++){
                let cliente = response[i];
                $("#clienteCombo").append("<option value=\""+cliente.cliente_rut+"\">"+cliente.cliente_rut+" - "+cliente.cliente_nombre+"</option>");
            }
        };
        postRequest(url,params,success);
    }
    
    function cargarUsuarios(){
        var url = "source/httprequest/usuario/GetUsuarios.php";
        var params = {};
        var success = function(response)
        {
            for(var i = 0; i < response.length; i++){
                let usuario = response[i];
                $("#usuarioCombo").append("<option value=\""+usuario.usuario_id+"\">"+usuario.usuario_nombre+"</option>");
            }
        };
        postRequest(url,params,success);
    }
    
    function cargarID(){
        var codigo = $("#codigoPistola").val();
        var id = parseInt(codigo.substring(0,codigo.length-1));
        var url = "source/httprequest/pedido/GetPedido.php";
        $("#tabla_ventas tbody").html("");
        var params = {id : id};
        var success = function(response)
        {
            if(response.pedido_estado === undefined){
                cerrarModal($("#ingresar_codigo_pistola"));
                alertify.error("Pedido no encontrado");
                cargarVentas();
                return;
            }
            if(response.pedido_estado !== '3'){
                if(confirmar('Cambiar estado','¿Desea cambiar el estado del pedido a entregado?',()=>{
                    cambiarEstado(id,3,1);
                },()=>{}));
                $(".trasero").css("visibility","hidden");
                $("#idpedido").val(id);
                cargarVentas();
                cerrarModal($("#ingresar_codigo_pistola"));
            } else{
                $("#idpedido").val(id);
                cerrarModal($("#ingresar_codigo_pistola"));
                cargarVentas();
                alertify.info("Pedido ya entregado");
            }
        };
        postRequest(url,params,success);
    }
    
    function pistolear(){
        mostrarTrasero();
        $("#ingresar_codigo_pistola").show();
        $("#ingresar_codigo_pistola").css("visibility","visible");
        $("#codigoPistola").val("");
    }
    
    function cargarVentas(){
        var url = "source/httprequest/pedido/GetPedidos.php";
        $("#tabla_ventas tbody").html("");
        var params = {id : $("#idpedido").val(),
        desde : $("#desde").val(),hasta : $("#hasta").val(),estado : $("#estadoCombo").val(),
        cliente : $("#clienteCombo").val(),usuario : $("#usuarioCombo").val(),telefono : $("#nro_tel").val(),ig : $("#user_ig").val()};
        var success = function(response)
        {
            if(response.length === 0){
                alertify.error("No hay registros que mostrar");
                return;
            }
            var contenido = '';
            $("#tabla_ventas tbody").html("");
            var disabled = ' ';
            if(TIPO_USUARIO === '1'){
                disabled = ' disabled';
            }
            for(var i = 0; i < response.length; i++){
                let venta = response[i];
                if(i % 2 === 0){
                    contenido += "<tr style='background-color:white;'>";
                }
                else{
                    contenido +=  "<tr>";
                }
                var estAux = venta.pedido_estado;
                var opciones = '';
                var opcionAnulado = "";
                if(TIPO_USUARIO === '0' || TIPO_USUARIO === '2'){
                    opcionAnulado = "<option value='4'>ANULADO</option>";
                }
                
                if(estAux === '0'){
                    opciones = "<option value='0'>CREADO</option><option value='1'>ACEPTADO</option>"+opcionAnulado;
                } else if(estAux === '1'){
                    opciones = "<option value='1'>ACEPTADO</option><option value='2'>DESPACHADO</option>"+opcionAnulado;
                } else if(estAux === '2'){
                    opciones = "<option value='2'>DESPACHADO</option><option value='3'>ENTREGADO</option>"+opcionAnulado;
                } else if(estAux === '3'){
                    opciones = "<option value='3'>ENTREGADO</option>"+opcionAnulado;
                } else if(estAux === '4'){
                    opciones = opcionAnulado;
                }else if(estAux === '5'){
                    opciones = "<option value='5'>PENDIENTE</option>";
                }
               
                
                var select = "<select style='width:100px;background-position: 79px, 0;' id='estadoAux"+i+"' "+disabled+" onchange=\"cambiarEstado("+venta.pedido_id+",$(this).val(),"+i+")\">"+opciones+"</select>";
                
                let totalAprox = Math.round(venta.pedido_total);
                var id = venta.pedido_id;
                var idAux = venta.pedido_id_aux !== '0' ?venta.pedido_id_aux :venta.pedido_id ;
                if(venta.pedido_id_aux !== '0'){
                    id = venta.pedido_id_aux + '('+id+')';
                }
                var tipo = '';
                if(venta.pedido_tipo === '0'){
                    tipo = 'NORMAL';
                } else if(venta.pedido_tipo === '1'){
                    tipo = 'RAPPI';
                } else if(venta.pedido_tipo === '2'){
                    tipo = 'PEDIDOS YA';
                }
                contenido += "<td>"+id+"</td>\n\
                              <td>"+venta.pedido_fecha+"</td>\n\
                              <td>"+select+"</td>\n\
                              <td>$ "+totalAprox+"</td>\n\
                              <td>"+venta.pedido_usuario+"</td>\n\
                              <td>"+venta.pedido_cliente_nombre+"</td>\n\
                              <td>"+venta.pedido_cliente_telefono+"</td>\n\
                              <td>"+tipo+"</td>\n\
                              <td><a href='javascript:void(0)' onClick='verDetalle("+venta.pedido_id+")' ><img alt='Ver detalle' title='Ver detalle' width='20' height='20' src='img/flecha.png'><a/></td>";                                
         
                            if(TIPO_USUARIO === '0' || TIPO_USUARIO === '2'){
                                if(estAux === '1'){
                                    contenido += "<td><a href='javascript:void(0)' onClick='imprimir("+venta.pedido_id+","+venta.pedido_id_aux+")' ><img alt='Imprimir codigo' title='Imprimir codigo' width='20' height='20' src='img/imprimir.png'><a/></td>";
                                    contenido += "<td><a href='javascript:void(0)' onClick='imprimirQR("+venta.pedido_id+","+venta.pedido_id_aux+")' ><img alt='Imprimir codigo QR' title='Imprimir codigo QR' width='20' height='20' src='img/qr.png'><a/></td>";
                                
                                } else {
                                    contenido += "<td>&nbsp;</td><td>&nbsp;</td>";                                    
                                }
                            } else{
                                contenido += "<td>&nbsp;</td><td>&nbsp;</td>";    
                            }
                            if(venta.pedido_codigo_pago === ''){
                                contenido+="<td><a href='javascript:void(0)'onClick=\"abrirPago("+venta.pedido_id+")\" ><img alt='Ingresar codigo de pago' title='Ingresar codigo de pago' width='20' height='20' src='img/editar.png'><a/></td>";
                            }else {
                                contenido+="<td><a href='javascript:void(0)'onClick=\"abrirPago("+venta.pedido_id+",'"+venta.pedido_codigo_pago+"')\" >"+venta.pedido_codigo_pago+"</a></td>";
                            }
                            if(venta.pedido_adjunto_pago === ''){
                                contenido+="<td><input type=\"hidden\" id=\"comprobanteOcultaPago"+i+"\">\n\
                                            <form id=\"formComprobantePago"+i+"\" enctype=\"multipart/form-data\" method=\"POST\" \n\
                                            onsubmit=\"subirFichero(event,$('#formComprobantePago"+i+"'),"+venta.pedido_id+",$('#comprobanteOcultaPago"+i+"'),'"+i+"',0,'pago')\">\n\
                                            <input name=\"comprobante\" type=\"file\" class=\"file\" id=\"comprobantePago"+i+"\" accept=\"image/x-png,image/jpeg,application/pdf\" onchange=\"enviarFormFile($('#comprobantePago"+i+"').val(),$('#comprobanteOcultaPago"+i+"'),$('#formComprobantePago"+i+"'))\">\n\
                                            </form>\n\
                                            <a href='javascript:void(0)' onClick=\"abrirFile(event,$('#comprobantePago"+i+":hidden'))\" ><img alt='Adjuntar comprobante de pago' title='Adjuntar comprobante de pago' width='20' height='20' src='img/adjuntar.png'><a/></td><td></td>";
                            } else {
                                contenido+="<td><input type=\"hidden\" id=\"comprobanteOcultaPago"+i+"\">\n\
                                            <form id=\"formComprobantePago"+i+"\" enctype=\"multipart/form-data\" method=\"POST\" \n\
                                            onsubmit=\"subirFichero(event,$('#formComprobantePago"+i+"'),"+venta.pedido_id+",$('#comprobanteOcultaPago"+i+"'),'"+i+"',0,'pago')\">\n\
                                            <input name=\"comprobante\" type=\"file\" class=\"file\" id=\"comprobantePago"+i+"\" accept=\"image/x-png,image/jpeg,application/pdf\" onchange=\"enviarFormFile($('#comprobantePago"+i+"').val(),$('#comprobanteOcultaPago"+i+"'),$('#formComprobantePago"+i+"'))\">\n\
                                            </form>\n\
                                            <a href='javascript:void(0)'onClick=\"abrirFile(event,$('#comprobantePago"+i+":hidden'))\" ><img alt='Adjuntar comprobante de pago' title='Adjuntar comprobante de pago' width='20' height='20' src='img/adjuntar.png'><a/></td><td><input type=\"hidden\" id=\"comprobanteOcultaPago"+i+"\">\n\
                                        <a href='javascript:void(0)'onClick=\"verAdjunto('"+venta.pedido_adjunto_pago+"','pago')\" ><img alt='Ver comprobante de pago' title='Ver comprobante de pago' width='20' height='20' src='img/detalle.png'><a/></td>";
                            }
                            if(venta.pedido_codigo_despacho === ''){
                                contenido+="<td><a href='javascript:void(0)' onClick=\"abrirDespacho("+venta.pedido_id+")\" ><img alt='Ingresar codigo de despacho' title='Adjuntar codigo de despacho' width='20' height='20' src='img/editar.png'><a/></td>";
                            }else {
                                contenido+="<td><a href='javascript:void(0)'onClick=\"abrirDespacho("+venta.pedido_id+",'"+venta.pedido_codigo_despacho+"')\" >"+venta.pedido_codigo_despacho+"</a></td>";
                            }
                            if(venta.pedido_adjunto_despacho === ''){
                                contenido+="<td><input type=\"hidden\" id=\"comprobanteOcultaDespacho"+i+"\">\n\
                                    <form id=\"formComprobanteDespacho"+i+"\" enctype=\"multipart/form-data\" method=\"POST\" \n\
                                    onsubmit=\"subirFichero(event,$('#formComprobanteDespacho"+i+"'),"+venta.pedido_id+",$('#comprobanteOcultaDespacho"+i+"'),'"+i+"',1,'despacho')\">\n\
                                    <input name=\"comprobante\" type=\"file\" class=\"file\" id=\"comprobanteDespacho"+i+"\" accept=\"image/x-png,image/jpeg,application/pdf\" onchange=\"enviarFormFile($('#comprobanteDespacho"+i+"').val(),$('#comprobanteOcultaDespacho"+i+"'),$('#formComprobanteDespacho"+i+"'))\">\n\
                                    </form>\n\
                                    <a href='javascript:void(0)' onClick=\"abrirFile(event,$('#comprobanteDespacho"+i+":hidden'))\" ><img alt='Adjuntar comprobante de despacho' title='Adjuntar comprobante de despacho' width='20' height='20' src='img/adjuntar.png'><a/></td><td></td>";
                            }else {
                                contenido+="<td><input type=\"hidden\" id=\"comprobanteOcultaDespacho"+i+"\">\n\
                                    <form id=\"formComprobanteDespacho"+i+"\" enctype=\"multipart/form-data\" method=\"POST\" \n\
                                    onsubmit=\"subirFichero(event,$('#formComprobanteDespacho"+i+"'),"+venta.pedido_id+",$('#comprobanteOcultaDespacho"+i+"'),'"+i+"',1,'despacho')\">\n\
                                    <input name=\"comprobante\" type=\"file\" class=\"file\" id=\"comprobanteDespacho"+i+"\" accept=\"image/x-png,image/jpeg,application/pdf\" onchange=\"enviarFormFile($('#comprobanteDespacho"+i+"').val(),$('#comprobanteOcultaDespacho"+i+"'),$('#formComprobanteDespacho"+i+"'))\">\n\
                                    </form>\n\
                                    <a href='javascript:void(0)' onClick=\"abrirFile(event,$('#comprobanteDespacho"+i+":hidden'))\" ><img alt='Adjuntar comprobante de despacho' title='Adjuntar comprobante de despacho' width='20' height='20' src='img/adjuntar.png'><a/></td><td><input type=\"hidden\" id=\"comprobanteOcultaDespacho"+i+"\">\n\
                                    <a href='javascript:void(0)'onClick=\"verAdjunto('"+venta.pedido_adjunto_despacho+"','despacho')\" ><img alt='Ver comprobante de despacho' title='Ver comprobante de despacho' width='20' height='20' src='img/detalle.png'><a/></td>";
                            }
                            contenido+="<tr>";
           
            }
            $("#tabla_ventas tbody").html(contenido);
        };
        postRequest(url,params,success);
    }
    
    
    
    function abrirPago(id,codigo = undefined){
        ID_PEDIDO = id;
        mostrarTrasero();
        if(codigo !== undefined){
            $("#codigoPago").val(codigo);
        } else{
            $("#codigoPago").val("");            
        }
        $('#ingresar_codigo_pago').show();
        $('#ingresar_codigo_pago').css('visibility','visible');
    }
    
    function abrirDespacho(id,codigo = undefined){
        ID_PEDIDO = id;
        if(codigo !== undefined){
            $("#codigoDespacho").val(codigo);
        } else{
            $("#codigoDespacho").val("");            
        }
        mostrarTrasero();
        $('#ingresar_codigo_despacho').show();
        $('#ingresar_codigo_despacho').css('visibility','visible');
    }
    
    function verDetalle(id){
        ID_PEDIDO = id;
        if(TIPO_USUARIO === '3'){
            $("#enlaceAddProd").css("display","none");
            $("#enlaceGuardar").css("display","none");
        }
        totalTabla = 0;
        tipo = 'editar';
        $("#pedidoDetalle").prop("disabled",true);
        var url = "source/httprequest/pedido/GetPedidoDetalle.php";
        var params = {id : id};
        var success = function(response)
        {
            $("#cont-pedido").css("display","block");
            mostrarTrasero();
            var contenido = '';
            $("#detalle_productos tbody").html("");
            for(var i = 0; i < response.length; i++){
                let pedido = response[i];
                if(i === 0){
                    var id = pedido.pedido_id;
                    if(pedido.pedido_id_aux !== '0'){
                        id = pedido.pedido_id_aux + '('+id+')';
                    }
                    $("#pedidoDetalle").val(id);
                    $("#clienteDetalle").val(pedido.pedido_cliente);
                    $("#nombreDetalle").val(pedido.pedido_cliente_nombre);
                    $("#direccionDetalle").val(pedido.pedido_cliente_direccion);
                    $("#comunaDetalle").val(pedido.pedido_cliente_comuna);
                    $("#telefonoDetalle").val(pedido.pedido_cliente_telefono);
                    $("#mailDetalle").val(pedido.pedido_cliente_mail);
                    $("#igDetalle").val(pedido.pedido_ig);
                    $("#observacionDetalle").val(pedido.pedido_observacion);
                    $("#descuentoDetalle").val(Math.round(pedido.pedido_descuento));
                    $("#despachado").val(pedido.pedido_despachado);
                    $("#adicional").val(pedido.pedido_adicional);
                    $("#totalDetalle").val(Math.round(pedido.pedido_total));
                    $("#fechaDetalle").val(pedido.pedido_fecha);
                    $("#horaDetalle").val(pedido.pedido_hora);
                }
                
                                
                if(pedido.producto_id === undefined){
                    continue;
                }
                let precio = Math.round(parseFloat(pedido.producto_precio) + parseFloat(pedido.producto_precio_iva));
                contenido += "<tr id='tr"+i+"'><td><input class=\"sin-borde\"  onfocus=\"setInput($(this),false)\" type=\"text\" id=\"idAdd"+i+"\" onblur=\"cargarProductos($(this).val(),"+i+")\" value=\""+pedido.producto_id+"\"></td>\n\
                              <td><input class=\"sin-borde\" type=\"text\" onfocus=\"setInput($(this))\" id=\"nombreAdd"+i+"\" value=\""+pedido.producto_nombre+"\"></td>\n\
                              <td><input class=\"sin-borde\" type=\"text\" onfocus=\"setInput($(this),false)\" id=\"precioAdd"+i+"\"  oninput=\"cambiarTotal()\" onblur=\"validar($(this))\" value=\""+precio+"\"></td>\n\
                              <td><input class=\"sin-borde\" type=\"text\" onfocus=\"setInput($(this),false)\" min=\"1\" id=\"cantidadAdd"+i+"\" oninput=\"cambiarTotal()\" onblur=\"validar($(this))\" value=\""+Math.round(pedido.detalle_cantidad)+"\"></td>\n\
                              <td><input class=\"sin-borde\" type=\"text\" id=\"totalAdd"+i+"\" value=\""+(precio*pedido.detalle_cantidad)+"\" readonly></td>\n\
                              <td><a href='javascript:void(0)' onclick='borrarItem("+i+")'><img src='img/cerrar.png' width='25' height='25' alt='Eliminar item' title='Eliminar item'></a></td></tr>";
                totalTabla += Math.round(precio * Math.round(pedido.detalle_cantidad));
            }
            $("#detalle_productos tbody").append(contenido);
            $("#detalle_venta").css("visibility","visible");
            $('#detalle_venta').show();
        };
        postRequest(url,params,success);
    }
    
    function imprimir(id,aux){
       window.open("print.php?id="+id+"&aux="+aux);
    }
    
    function imprimirQR(id,aux){
       window.open("https://bleachapp.cl/phpqrcode/print.php?id="+id+"&aux="+aux);
    }
    
    function abrirEnviar(id,tipo){
        ID_PDF_CORREO = id;
        TIPO_PDF_CORREO = tipo;
        $('#enviar_correo').show();
        $('#enviar_correo').css('visibility','visible');
        $("#enviaCorreo").focus();
    }
    
    function enviarCorreo(){
        var correo = $('#enviaCorreo').val();
        if(!validarEmail(correo)){
            alertify.error("E-mail inválido");
            return;
        }
        var url = urlUtil+"/enviarCorreo.php";
        var params = {correo : correo,tipo : TIPO_PDF_CORREO,id : ID_PDF_CORREO};
        var success = (response)=>{
            if(response.mensaje === 'ok'){
                alertify.success("E-mail enviado a "+correo+" con exito");
            } else{
                alertify.error("Ocurrio un error al enviar el e-mail");
            }
            $('#enviar_correo').hide();
            $('#enviar_correo').css('visibility','hidden');
            $("#enviaCorreo").text("");
        };
        postRequest(url,params,success);
    }
    
    function cambiarEstado(id,valor,index){
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
                            cargarVentas();
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
                        cargarVentas();
                    }
                };
                postRequest(url,params,success);
            };
            postRequest(url,params,success);
        }
    }
    
    function agregarPedido(){
        totalTabla = 0;
        tipo = 'agregar';
        $("#enlaceAddProd").css("display","block");
        $("#enlaceGuardar").css("display","block");
        $("#enlaceAddProd").css("display","block");
        $("#cont-pedido").css("display","none");
        $("#detalle_venta input").val("");
        $("#igDetalle").val("");
        $("#observacionDetalle").val("");
        $("#despachado").val("");
        $("#adicional").val("-1");
        $("#descuentoDetalle").val("0");
        $("#totalDetalle").val("0");
        $("#detalle_venta").css('visibility','visible');
        $("#detalle_venta").show();
        $("#detalle_productos tbody").html("");
        var hoy = new Date();
        var dia = hoy.getDate() < 10 ? '0'+hoy.getDate() : hoy.getDate();
        var mes = ( hoy.getMonth() + 1 ) < 10 ? '0'+( hoy.getMonth() + 1 ) : ( hoy.getMonth() + 1 );
        var anio = hoy.getFullYear();
        $("#fechaDetalle").val(dia+"/"+mes+"/"+anio);
        var hora = hoy.getHours() < 10 ? '0'+hoy.getHours() : hoy.getHours();
        var minuto = hoy.getMinutes() < 10 ? '0'+hoy.getMinutes() : hoy.getMinutes();
        $("#horaDetalle").val(hora+':'+minuto);
        mostrarTrasero();
    }
    
    function cargarClientes(){
        var url = "source/httprequest/cliente/GetClientes.php";
        var params = {rut : $("#buscaRut").val(), nombre : $("#buscaNombre").val(),
            giro : $("#buscaGiro").val(),mail : $("#buscaMail").val()};
        var success = function(response)
        {
            var contenido = '';
            for(var i = 0; i < response.length; i++){
                contenido += "<option value='"+response[i].cliente_rut+"'>"+response[i].cliente_rut+"</option>";
            }
            $("#clienteCombo").append(contenido);
            $("#clienteDetalleList").append(contenido);
        };
        postRequest(url,params,success);
    }
    
    function cargarCliente(){
        var rut = $("#clienteDetalle").val();
        if(rut !== ''){
            var url = "source/httprequest/cliente/GetCliente.php";
            var params = {rut : rut};
            var success = function(response)
            {
                $("#nombreDetalle").val(response.cliente_nombre);
                $("#direccionDetalle").val(response.cliente_direccion);
                $("#comunaDetalle").val(response.cliente_comuna);
                $("#telefonoDetalle").val(response.cliente_telefono);
                $("#mailDetalle").val(response.cliente_mail);
            };
            postRequest(url,params,success);
        }
    }
    
    function agregarProducto(){
        var index = $("#detalle_productos tbody tr").length;
        var contenido = "<tr id='tr"+index+"'><td><input onfocus=\"setInput($(this),false)\" class=\"sin-borde\" type=\"text\" id=\"idAdd"+index+"\" onkeydown=\"cargarProductosEnter(event,$(this).val(),"+index+")\" onblur=\"cargarProductos($(this).val(),"+index+")\"></td>"+                        
                        "<td><input class=\"sin-borde\" onfocus=\"setInput($(this))\" type=\"text\" id=\"nombreAdd"+index+"\"></td>"+
                        "<td><input class=\"sin-borde\" onfocus=\"setInput($(this),false)\" type=\"text\" id=\"precioAdd"+index+"\" oninput=\"cambiarTotal()\" onblur=\"validar($(this))\"></td>"+
                        "<td><input class=\"sin-borde\" onfocus=\"setInput($(this),false)\" type=\"text\" min=\"1\" value='1' id=\"cantidadAdd"+index+"\" oninput=\"cambiarTotal()\" onblur=\"validar($(this))\" ></td>"+
                        "<td><input class=\"sin-borde\" type=\"text\" id=\"totalAdd"+index+"\" readonly></td>"+
                        "<td><a href='javascript:void(0)' onclick='borrarItem("+index+")'><img src='img/cerrar.png' width='25' height='25' alt='Eliminar item' title='Eliminar item'></a></td></tr>";
        $("#detalle_productos tbody").append(contenido);
        $("#idAdd"+index+"").focus();
        input_sel = $("#idAdd"+index+"");
        indexAgregado = index;
    }
    
    function borrarItem(index){
        $("#tr"+index).remove();
        cambiarTotal();
    }
    
    function cargarProductosEnter(e,id,index){
        if(isTeclaEnter(e)){
            cargarProductos(id,index);
        }
    }    
    
    function cargarProductos(id,index){
        if(id === ""){
            return;
        }
        var cont = 0;
        var total = $("#detalle_productos tbody tr").length;
        for(var i = 0; i < total ; i++){
            if($("#idAdd"+i).val() === id){
                cont++;
            }
        }
        if(cont > 1){
            alertify.error("Producto ya se encuentra ingresado");
            return;
        }
        var url = "source/httprequest/producto/GetProducto.php";
        var params = {codigo : id};
        var success = function(response)
        {
            if(response.producto_id === undefined){
                $("#nombreAdd"+index).val("");
                $("#precioAdd"+index).val("");
                $("#cantidadAdd"+index).val("");
                $("#totalAdd"+index).val("");
                alertify.error("Producto no encontrado");
                return;
            }
                if(response.producto_cantidad === 0){
                    alertify.error("Producto sin stock");
                    return;
                }
                let producto = response;
                $("#idAdd"+index).prop("disabled",true);
                $("#nombreAdd"+index).focus();
                $("#nombreAdd"+index).val(producto.producto_nombre);
                let precio = Math.round(parseFloat(producto.producto_precio)+parseFloat(producto.producto_precio_iva));
                let cantidad = 1;
                $("#precioAdd"+index).val(precio);
                $("#cantidadAdd"+index).val(cantidad);
                cambiarTotal();
                $("#totalAdd"+index).val(precio * cantidad);
                setDescuento($("#descuentoDetalle").val());
        };
        postRequest(url,params,success);
    }
    
    
    function guardarPedido(){
        var id = $("#pedidoDetalle").val();
        var fecha = $("#fechaDetalle").val() +' '+$("#horaDetalle").val();
        var cliente = $("#clienteDetalle").val();
        var descuento = $("#descuentoDetalle").val();
        var total = $("#totalDetalle").val();
        var nombre = $("#nombreDetalle").val();
        var direccion = $("#direccionDetalle").val();
        var comuna = $("#comunaDetalle").val();
        var telefono = $("#telefonoDetalle").val();
        var mail = $("#mailDetalle").val();
        var ig = $("#igDetalle").val();
        var observacion = $("#observacionDetalle").val();
        var despachado = $("#despachado").val();
        var adicional = $("#adicional").val() / 2;
        if(fecha === '' ){
            alertify.error("Ingrese todos los campos necesarios");
            return;            
        }
        if(!validarRut(cliente)){
            alertify.error("Rut inválido");
            return;
        }
        if(mail !== '' && !validarEmail(mail)){
            alertify.error("E-mail inválido");
            return;
        }
        if(!validarNumero(telefono)){
            alertify.error("Teléfono inválido");
            return;
        }
        if(!validarNumero(total)){
            alertify.error("Total inválido");
            return;
        }
        if(!validarNumero(descuento)){
            alertify.error("Descuento inválido");
            return;
        }
        if(totalTabla === 0){
            alertify.error("Debe agregar algun producto a este pedido");
            return;
        }
        if(tipo ==='agregar'){
            var url = "source/httprequest/pedido/AddPedido.php";
            var params = {fecha : fecha,cliente:cliente,nombre:nombre,direccion:direccion,comuna:comuna,telefono:telefono,mail:mail,ig:ig,adicional:adicional,observacion:observacion,despachado:despachado,descuento:descuento,total:total};
            var success = function(response){
                var index = $("#detalle_productos tbody tr").length;
                for(var i = 0; i < index;i++){
                    var url = "source/httprequest/pedido/AddPedidoDetalle.php";
                    var codigo = $("#idAdd"+i).val();
                    var nombre = $("#nombreAdd"+i).val();
                    var precio = $("#precioAdd"+i).val();
                    var cantidad = $("#cantidadAdd"+i).val();
                    if(codigo.trim() === '' || nombre.trim() === '' || precio.trim() === '' || cantidad.trim() === ''){
                        continue;
                    }
                    var pedido = response.mensaje;
                    var params = {codigo : codigo,nombre:nombre,precio:precio,cantidad:cantidad,pedido:pedido};
                    postRequest(url,params,null);
                }
                $("#clienteDetalle").val("");
                $("#nombreDetalle").val("");
                $("#direccionDetalle").val("");
                $("#comunaDetalle").val("");
                $("#mailDetalle").val("");
                $("#igDetalle").val("");
                $("#observacionDetalle").val("");
                $("#despachado").val("");
                $("#descuentoDetalle").val("0");
                $("#totalDetalle").val("0");
                $("#detalle_productos tbody").html("");
                alertify.success("Pedido agregado con el ID "+response.mensaje);
                totalTabla = 0;
                cargarVentas();
            };
        } else {
            var url = "source/httprequest/pedido/ModPedido.php";
            var params = {id: ID_PEDIDO,fecha : fecha,cliente:cliente,nombre:nombre,direccion:direccion,comuna:comuna,telefono:telefono,mail:mail,ig:ig,adicional:adicional,observacion:observacion,despachado:despachado,descuento:descuento,total:total};
            var success = function(){
                var url = "source/httprequest/pedido/DelPedidoDetalle.php";
                var params = {id: ID_PEDIDO};
                var success = function(response){
                    var index = $("#detalle_productos tbody tr").length;
                    for(var i = 0; i < index;i++){
                        var url = "source/httprequest/pedido/AddPedidoDetalle.php";
                        var codigo = $("#idAdd"+i).val();
                        var nombre = $("#nombreAdd"+i).val();
                        var precio = $("#precioAdd"+i).val();
                        var cantidad = $("#cantidadAdd"+i).val();
                        var params = {codigo : codigo,nombre:nombre,precio:precio,cantidad:cantidad,pedido:ID_PEDIDO};
                        postRequest(url,params,null);
                    }
                    $("#fechaDetalle").val("");
                    $("#clienteDetalle").val("");
                    $("#nombreDetalle").val("");
                    $("#direccionDetalle").val("");
                    $("#comunaDetalle").val("");
                    $("#mailDetalle").val("");
                    $("#totalDetalle").val("0");
                    $("#detalle_productos tbody").html("");
                    alertify.success("Pedido "+id+" modificado");
                    $("#detalle_venta").hide();
                    $("#detalle_venta").css("visibility","hidden");
                    $(".trasero").css("visibility","hidden");
                    totalTabla = 0;
                    cargarVentas();
                };
                postRequest(url,params,success);
            };
        }
        tipo = 'agregar';
        postRequest(url,params,success);
    }
    
    function cambiarTotal(){
        var cont = $("#detalle_productos tbody").html();
        if(cont === ""){
            totalTabla = 0;
            $("#descuentoDetalle").val(0);
            $("#totalDetalle").val(totalTabla);
            return;
        }
        var index = $("#detalle_productos tbody tr").length;
        totalTabla = 0;
        for(var j = 0; j < index;j++){
            var cantidad = $("#cantidadAdd"+j).val();
            var precio = $("#precioAdd"+j).val();
            console.log(cantidad+" "+precio)
            if(cantidad === undefined || precio === undefined){
                continue;
            }else if(cantidad.trim() === '' || precio.trim() === ''){
                return;
            }
            if(isNaN(cantidad)){
                alertify.error('Cantidad inválida');
                $("#cantidadAdd"+j).val("");
                $("#totalAdd"+j).val("");
                return;
            }
            if(isNaN(precio)){
                alertify.error('Precio inválido');
                $("#precioAdd"+j).val("");
                 $("#totalAdd"+j).val("");
                return;
            }
            var aux = parseInt(cantidad) * parseInt(precio);
            $("#totalAdd"+j).val(aux);
            totalTabla += parseInt($("#totalAdd"+j).val());
        }
        var aux = $("#descuentoDetalle").val();
        setDescuento(aux);
    }
    
    function validar(obj){
        if(!validarNumero(obj.val())){
            alertify.error("Valor inválido");
            obj.val("");
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
                if(ext === 'xls'){
                    if(aux === 'xlsx'){
                    } else{
                        //alertify.error("Archivo inválido");
                        //return;
                    }
                }
                if(ext !== 'xls'){
                    if(aux === 'pdf' || aux === 'png' || aux === 'jpg'){
                    } else{
                        //alertify.error("Archivo inválido");
                        //return;
                    }
                }
                
                var archivo = '';
                if(ext === 'pago'){
                    archivo = $("#comprobanteOcultaPago"+index).val();
                } else if(ext === 'despacho'){
                    archivo = $("#comprobanteOcultaDespacho"+index).val();
                } else if(ext === 'xls'){
                    archivo = $("#excelPedidoOculta").val();
                }
                
                if(ext !== 'xls'){
                    modificarAdjuntoPedido(nombre,archivo,tipo);
                } else{
                    cargarVentas();
                    alertify.success("Pedidos cargados correctamente");
                } 
                cambiarPropiedad($("#form_cargando"),"visibility","hidden");
                $(".trasero").css("visibility","hidden");
            },
            error: function(response)
            {
            }
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
                cargarVentas();
            }
        };
        postRequest(url,params,success);
    }
    
    function verAdjunto(archivo,ext){
        window.open('source/util/'+ext+'/'+archivo);
    }

    function ingresarCodigo(codigo,tipo){
        var url = "source/httprequest/pedido/ModCodigoPedido.php";
        var params = {id : ID_PEDIDO,codigo:codigo,tipo:tipo};
        var success = function(response)
        {
            if(response.mensaje ==='0'){
                alertify.error("Ocurrio un error en el servidor");
            } else{
                alertify.success("Código modificado");
                $("#ingresar_codigo_pago").hide();
                $("#ingresar_codigo_despacho").hide();
                $(".trasero").css("visibility","hidden");
                cargarVentas();
            }
        };
        postRequest(url,params,success);
    }
    
    function enviarCorreo(mail,id)
    {
        var url = urlUtil + "/enviarCorreo.php";
        var params = {mail : mail,id:id};
        postRequest(url,params,(response)=>{
        if(response.mensaje === 'ok'){
            alertify.success("Correo enviado a "+mail);
        }
        });
    }


    function calcular(data){
        if(input_sel === undefined){
            return;
        }
        if(input_sel.val()==='0'){
            input_sel.val('');
        }
        input_sel.val(input_sel.val()+data);
        input_sel.focus();
        cambiarTotal();
    }

    function vaciar(){
        if(input_sel === undefined){
            return;
        }
        input_sel.val('0');
        cambiarTotal();
    }

    function borrar(){
        if(input_sel === undefined){
            return;
        }
        if( input_sel.val().length > 1){
            let data = input_sel.val().substr(0, input_sel.val().length - 1);
            input_sel.val(data);
        } else{
            input_sel.val(0);
        }
        cambiarTotal();
    }

    function setInput(obj,focus = true){
        input_sel = obj;
        if(focus){
            //input_sel.focus();
        }
    }