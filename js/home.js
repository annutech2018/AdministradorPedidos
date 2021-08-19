/* global alertify */

$(document).ready(function(){
    cargarDashBoard();
    cargarRappi();
    cargarPedidosNuevos();
    setInterval('cargarPedidosNuevos()',5000);
    setInterval('cargarRappi()',5000);
});

function cargarDashBoard(){
    var url = "source/httprequest/dashboard/GetDashboard.php";
    $("#tabla_inv tbody").html("");
    var params = {};
    var success = function(response)
    {
        $("#normalSpan").html(response.normal);
        $("#rappiSpan").html(response.rappi);
        $("#pedidosYaSpan").html(response.pedidos_ya);
        $("#entregadosSpan").html(response.entregado);
    };
    postRequest(url,params,success);
}

function cargarRappi(){
    var url = "source/httprequest/dashboard/AddPedidosRappi.php";
    $("#tabla_inv tbody").html("");
    var params = {};
    var success = function(response)
    {
    };
    postRequest(url,params,success);
}

function cargarPedidosNuevos(){
    var url = "source/httprequest/dashboard/GetPedidosNuevos.php";
    $("#contenedor_pedidos tbody").html("");
    var params = {};
    var success = function(response)
    {
        let html = '';
        html += '<div class="cont-pedido-row"><div class="txt">ID</div><div class="txt">Cliente</div><div class="txt">Tipo</div></div>';
        for(let i = 0 ; i < response.length;i++){
            let id= response[i].id;
            let cliente = response[i].cliente;
            let tipo = ''; 
            if(response[i].tipo === '0'){
                tipo = 'Normal';
            } else if(response[i].tipo === '1'){
                tipo = 'Rappi';
            } else if(response[i].tipo === '2'){
                tipo = 'PedidosYa';
            }            
            html += '<div class="cont-pedido-row2"><div class="txt2">'+id+'</div><div class="txt2">'+cliente+'</div><div class="txt2">'+tipo+'</div>';
            html += '<img src="img/aceptar.png" width="25" alt="Aceptar pedido" title="Aceptar pedido" onclick="aceptarPedido('+id+')" >';
            html += '<img src="img/cerrar.png" alt="Anular pedido" title="Anular pedido" width="22" onclick="anularPedido('+id+')">';
            html += '<img src="img/imprimir.png" alt="Imprimir comanda" title="Imprimir comanda" width="26"  onclick="imprimirComanda('+id+')"></div>';
        }
        $("#contenedor_pedidos").html(html);
    };
    postRequest(url,params,success);
}

function aceptarPedido(id){
    var url = "source/httprequest/pedido/ModEstadoPedido.php";
    var params = {id : id,estado : 1};
    $("#tabla_inv tbody").html("");
    var success = function(response)
    {
        alertify.success("Pedido aceptado");
    };
    postRequest(url,params,success);
}

function anularPedido(id){
    var url = "source/httprequest/pedido/ModEstadoPedido.php";
    var params = {id : id,estado : 4};
    $("#tabla_inv tbody").html("");
    var success = function(response)
    {
        alertify.success("Pedido anulado");
    };
    postRequest(url,params,success);
}

function imprimirComanda(id){
    window.open("imprimirComanda.php?id="+id)
}
