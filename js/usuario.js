/* global alertify */

    var accion = 'agregar';

    $(document).ready(()=>{
        cargarUsuarios();
        $("#enlaceBuscar").click(()=>{
            cargarUsuarios();
        });

        $("#enlaceLimpiar").click(()=>{
            $("#buscaNombre").val("");
            cargarUsuarios();
        });
        
        $("#enlaceAgregar").click(()=>{
            mostrarTrasero();
            accion = 'agregar';
            $("#nombre").val("");
            reset();
            $("#detalle_usuario").css('visibility','visible');
            $("#detalle_usuario").show();
            $("#nombre").blur(()=>{
                if($("#nombre").val() === ''){
                    reset();
                    return;
                }
                abrirModificar($("#id").val());
            });
        });
        $(".trasero").click(()=>{
            $(".trasero").css("visibility","hidden");
            $(".detalle").css("visibility","hidden");
        });
    });

    function cargarUsuarios(){
        reset();
        var url = "source/httprequest/usuario/GetUsuarios.php";
        $("#tabla_usr tbody").html("");
        var params = {nombre : $("#buscaNombre").val()};
        var success = function(response)
        {
            if(response.length === 0){
                alertify.error("No hay registros que mostrar");
                return;
            }
            var contenido = '';
            for(var i = 0; i < response.length; i++){
                let usuario = response[i];
                if(i % 2 === 0){
                    contenido += "<tr style='background-color:white;'>";
                }
                else{
                    contenido +=  "<tr'>";
                }
                let tipo = '';
                if(usuario.usuario_tipo === '0'){
                    tipo = 'ADMIN';
                } else if(usuario.usuario_tipo === '1'){
                    tipo = 'VENDEDOR';
                } else if(usuario.usuario_tipo === '2'){
                    tipo = 'MONITOR';
                } else if(usuario.usuario_tipo === '3'){
                    tipo = 'DESPACHO';
                } else if(usuario.usuario_tipo === '4'){
                    tipo = 'MOTORISTA';
                }
                
                contenido +=  "<td>"+usuario.usuario_id+"</td>";
                contenido +=  "<td>"+usuario.usuario_nombre+"</td>";
                contenido +=  "<td>"+tipo+"</td>";
                contenido +=  "<td><a onclick=\"abrirModificar('"+usuario.usuario_id+"')\" href=\"javascript:void(0)\"><img src= \"img/editar.png\" width=\"20\" height=\"20\"></a></td>";
                contenido +=  "<td><a onclick=\"eliminarUsuario('"+usuario.usuario_id+"')\" href=\"javascript:void(0)\"><img src= \"img/eliminar.png\" width=\"20\" height=\"20\"></a></td>";
                contenido +=  "</tr>";
            }
            $("#tabla_usr tbody").append(contenido);
        };
        postRequest(url,params,success);
    }
    
    
    function abrirModificar(id,mod = false){
        mostrarTrasero();
        var url = "source/httprequest/usuario/GetUsuario.php";
        var params = {id : id};
        var success = function(response)
        {
            if(response.usuario_nombre !== undefined){
                $("#id").val(id);
                $("#nombre").val(response.usuario_nombre);
                $("#tipo").val(response.usuario_tipo);
                accion = 'modificar';
                $("#detalle_usuario").css('visibility','visible');
                $("#detalle_usuario").show();
            }
            else{
                accion = 'agregar';
                if(mod){
                    alertify.error("Usuario no disponible");
                }
                reset();
            }
        };
        postRequest(url,params,success);
    }
    
    function guardarUsuario(){
        let id = $("#id").val();
        let nombre = $("#nombre").val();
        let clave1 = $("#clave1").val();
        let clave2 = $("#clave2").val();
        let tipo = $("#tipo").val();
        if(accion === 'agregar'){
            if(nombre === '' || clave1 === '' || clave2 === '' || tipo === ''){
                alertify.error("Debe llenar todos los campos obligatorios");
                return;
            }
        }
        else{
            if(nombre === '' || tipo === ''){
                alertify.error("Debe llenar todos los campos obligatorios");
                return;
            }
        }
        if(clave1 !== clave2){
            alertify.error("Las claves no coinciden");
            return;
        }
        var params = {id : id, nombre : nombre,clave1 : btoa(clave1), tipo : tipo};
        if(accion === 'agregar'){
            agregarUsuario(params);
        }
        else{
            modificarUsuario(params);
        }   
    }

    function modificarUsuario(params){
        let url = "source/httprequest/usuario/ModUsuario.php";
        let success = (response)=>{
            if(response.error === undefined){
                $("#detalle_usuario").css('visibility','hidden');
                $("#detalle_usuario").hide();
                cargarUsuarios();
                alertify.success(response.mensaje);
                $(".trasero").css("visibility","hidden");
            } else{
                alertify.error(response.error);
            }
        };
        postRequest(url,params,success);
    }
    
    function agregarUsuario(params){
        let url = "source/httprequest/usuario/AddUsuario.php";
        let success = (response)=>{
            if(response.error === undefined){
                $("#detalle_usuario").css('visibility','hidden');
                $("#detalle_usuario").hide();
                cargarUsuarios();
                alertify.success(response.mensaje);
                $(".trasero").css("visibility","hidden");
            }
            else{
                alertify.error(response.error);
            }
        };
        postRequest(url,params,success);
    }
    
    function eliminarUsuario(id){
        confirmar('Eliminar usuario','Esta seguro que desea eliminar el usuario '+id,()=>{
            let url = "source/httprequest/usuario/DelUsuario.php";
            let success = (response)=>{
                if(response.error === undefined){
                    cargarUsuarios();
                    alertify.success(response.mensaje);
                } else{
                    alertify.error(response.error);
                }
            };  
            var params = {id : id};
            postRequest(url,params,success);
        },()=>{});
    }
    
    function reset(){
        $("#nombre").val("");
        $("#clave1").val("");
        $("#clave2").val("");
        $("#tipo").val("");
    }
    