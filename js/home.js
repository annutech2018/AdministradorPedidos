$(document).ready(function(){
    cargarDashBoard();
   
});

function cargarDashBoard(){
    var url = "source/httprequest/dashboard/GetDashboard.php";
    $("#tabla_inv tbody").html("");
    var params = {};
    var success = function(response)
    {
        $("#creadosSpan").html(response.creado);
        $("#aceptadosSpan").html(response.aceptado);
        $("#despachadosSpan").html(response.despachado);
        $("#entregadosSpan").html(response.entregado);
    };
    postRequest(url,params,success);
}
