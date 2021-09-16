/* global alertify */

    var CANTIDAD_VENTAS = 0;

    var accion = 'agregar';

    $(document).ready(()=>{
        cargarClientes();

        $("#enlaceBuscar").click(()=>{
            cargarClientes();
        });

        $("#enlaceLimpiar").click(()=>{
            $("#buscaRut").val("");
            $("#buscaNombre").val("");
            $("#buscaGiro").val("");
            $("#buscaMail").val("");
            cargarClientes();
        });
        
        $("#enlaceAgregar").click(()=>{
            mostrarTrasero();
            accion = 'agregar';
            $("#rut").val("");
            $("#rut").prop("disabled",false);
            reset();
            $("#detalle_cliente").css('visibility','visible');
            $("#detalle_cliente").show();
            $("#rut").blur(()=>{
                if($("#rut").val() === ''){
                    reset();
                    return;
                } 
                abrirModificar($("#rut").val());
            });
        });
        
        $("#enlaceExcel").click(function(){
            var params = "rut="+$('#buscaRut').val()+"&nombre="+$("#buscaNombre").val()+
                "&giro="+$("#buscaGiro").val()+"&mail="+$("#buscaMail").val();
            exportar('source/httprequest/cliente/GetClientesExcel',params);            
        });
        
        $(".trasero").click(()=>{
            $(".trasero").css("visibility","hidden");
            $(".detalle").css("visibility","hidden");
        });
    });

    function cargarClientes(){
        reset();
        var url = "source/httprequest/cliente/GetClientes.php";
        $("#tabla_cli tbody").html("");
        var params = {rut : $("#buscaRut").val(), nombre : $("#buscaNombre").val(),
            giro : $("#buscaGiro").val(),mail : $("#buscaMail").val()};
        var success = function(response)
        {
            if(response.length === 0){
                alertify.error("No hay registros que mostrar");
                return;
            }
            var contenido = '';
            for(var i = 0; i < response.length; i++){
                let cliente = response[i];
                if(i % 2 === 0){
                    contenido += "<tr style='background-color:white;'>";
                }
                else{
                    contenido += "<tr'>";
                }
                    contenido += "<td>"+cliente.cliente_rut+"</td>";
                    contenido += "<td>"+cliente.cliente_nombre+"</td>";
                    contenido += "<td>"+cliente.cliente_giro+"</td>";
                    contenido += "<td>"+cliente.cliente_mail+"</td>";
                    contenido += "<td>"+cliente.cliente_telefono+"</td>";
                    contenido += "<td>"+cliente.cliente_direccion+"</td>";
                    contenido += "<td>"+cliente.cliente_comuna+"</td>";
                    contenido += "<td>"+cliente.cliente_ciudad+"</td>";
                    contenido += "<td><a onclick=\"abrirModificar('"+cliente.cliente_rut+"',true)\" href=\"javascript:void(0)\"><img src= \"img/editar.png\" width=\"20\" height=\"20\"></a></td>";
                    contenido += "<td><a onclick=\"eliminarCliente('"+cliente.cliente_rut+"')\" href=\"javascript:void(0)\"><img src= \"img/eliminar.png\" width=\"20\" height=\"20\"></a></td>";
                contenido += "</tr>";
            }
            $("#tabla_cli tbody").append(contenido);
        };
        postRequest(url,params,success);
    }
    
    
    function abrirModificar(rut,mod=false){
        mostrarTrasero();
        var url = "source/httprequest/cliente/GetCliente.php";
        var params = {rut : rut};
        var success = function(response)
        {
            if(response.cliente_rut !== undefined){
                $("#rut").val(rut);
                $("#rut").prop("disabled",true);
                $("#nombre").val(response.cliente_nombre);
                $("#giro").val(response.cliente_giro);
                $("#mail").val(response.cliente_mail);
                $("#telefono").val(response.cliente_telefono);
                $("#direccion").val(response.cliente_direccion);
                $("#comuna").val(response.cliente_comuna);
                $("#ciudad").val(response.cliente_ciudad);

                accion = 'modificar';
                $("#detalle_cliente").css('visibility','visible');
                $("#detalle_cliente").show();
            }
            else{
                accion = 'agregar';
                if(mod){
                    alertify.error("Cliente no disponible");
                }
                reset();
            }
            setTimeout('ocultar()',30000);
        };
        postRequest(url,params,success);
    }
    
    function guardarCliente(){
        let rut = $("#rut").val();
        let nombre = $("#nombre").val();
        let giro = $("#giro").val();
        let mail = $("#mail").val();
        let telefono = $("#telefono").val();
        let direccion = $("#direccion").val();
        let comuna = $("#comuna").val();
        let ciudad = $("#ciudad").val();
        if(rut === '' || nombre === '' || giro === '' || mail === '' || telefono === '' || direccion === ''
                 || comuna === '' || ciudad === ''){
            alertify.error("Debe llenar todos los campos obligatorios");
            return;
        }
        if(!validarNumero(telefono)){
            alertify.error("Teléfono costo debe ser numérico");
            return;
        }
        if(!validarRut(rut)){
            alertify.error("Rut invalido");
            return;
        }
        if(!validarEmail(mail)){
            alertify.error("E-mail invalido");
            return;
        }
        var params = {rut : rut, nombre : nombre,giro : giro, 
            mail : mail, telefono : telefono, direccion : direccion,
            ciudad : ciudad, comuna : comuna};
        if(accion === 'agregar'){
            agregarCliente(params);
        }
        else{
            modificarCliente(params);
        }
    }

    function modificarCliente(params){
        let url = "source/httprequest/cliente/ModCliente.php";
        let success = (response)=>{
            if(response.error === undefined){
                $("#detalle_cliente").css('visibility','hidden');
                $("#detalle_cliente").hide();
                cargarClientes();
                alertify.success(response.mensaje);
                $(".trasero").css("visibility","hidden");
                accion = 'agregar';
            } else{
                alertify.error(response.error);
            }
        };
        
        postRequest(url,params,success);
    }
    
    function agregarCliente(params){
        let url = "source/httprequest/cliente/AddCliente.php";
        let success = (response)=>{
            if(response.error === undefined){
                $("#detalle_cliente").css('visibility','hidden');
                $("#detalle_cliente").hide();
                cargarClientes();
                alertify.success(response.mensaje);
                $(".trasero").css("visibility","hidden");
            }
            else{
                alertify.error(response.error);
            }
        };
        postRequest(url,params,success);
    }
    
    function eliminarCliente(rut){
        confirmar('Eliminar cliente','Esta seguro que desea eliminar el cliente '+rut,()=>{
            let url = "source/httprequest/cliente/DelCliente.php";
            let success = (response)=>{
                if(response.error === undefined){
                    cargarClientes();
                    alertify.success(response.mensaje);
                } else{
                    alertify.error(response.error);
                }
            };
            var params = {rut : rut};
            postRequest(url,params,success);
        },()=>{});
    }
    
    function reset(){
        accion === 'agregar';
        $("#rut").val("");
        $("#nombre").val("");
        $("#giro").val("");
        $("#mail").val("");
        $("#telefono").val("");
        $("#direccion").val("");
        $("#comuna").val("");
        $("#ciudad").val("");
    }
    
    
    function ocultar(){
        $("#detalle_cliente").css('visibility','hidden');
        $("#detalle_cliente").hide();
    }
    
    