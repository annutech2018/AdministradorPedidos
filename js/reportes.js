/* global alertify */

$(document).ready(function(){
    iniciarFecha([$("#desde"),$("#hasta")]);
    cargarClientes();
    
    $("#enlaceBuscar").click(function(){
        cargarReporte();
    });
    
    $("#enlaceLimpiar").click(function(){
       $("#tipo").prop('selectedIndex',0);  
       $("#clienteCombo").val("");
       $("#desde").val("");  
       $("#hasta").val("");
       $("#tabla_ventas tbody").html("");
    });
    
    $("#enlaceExcel").click(function(){
        var params = "cliente="+$('#clienteCombo').val()+"&desde="+$("#desde").val()+
                "&hasta="+$("#hasta").val();
        var tipo = $("#tipo").val();
        if(tipo===""){
            alertify.error("Seleccione tipo de reporte");
            return;
        } else if(tipo==="0"){
            exportar('source/httprequest/reporte/GetReporteProdVendExcel',params);            
        } else if(tipo === "1"){
            exportar('source/httprequest/reporte/GetReportePedidosExcel',params);
        }
    });
        
});
    
    function cargarReporte(){
        var url = '';
        if($("#tipo").val()===""){
            alertify.error("Seleccione tipo de reporte");
            return;
        } else if($("#tipo").val()==="0"){
            url = "source/httprequest/reporte/GetReporteProdVend.php";
        }else if($("#tipo").val()==="1"){
            url = "source/httprequest/reporte/GetReportePedidos.php";
        }
        $("#tabla_ventas tbody").html("");
        var params = {desde : $("#desde").val(),hasta : $("#hasta").val(),cliente : $("#clienteCombo").val()};
        var success = function(response)
        {
            if(response.length === 0){
                alertify.error("No hay registros que mostrar");
                return;
            }
            var contenido = '';
            for(var i = 0 ; i < response.length ; i++){
                if(i % 2 === 0){
                    contenido += "<tr style='background-color:white;'>";
                }
                else{
                    contenido +=  "<tr>";
                }
                contenido+="<td>"+response[i].reporte_item+"</td><td>"+
                        response[i].reporte_valor+"</td></tr>";
            }
            $("#tabla_ventas tbody").html(contenido);
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
