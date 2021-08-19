/* global alertify */

    var accion = 'agregar';

    $(document).ready(()=>{
        cargarProductos();

        $("#enlaceBuscar").click(()=>{
            cargarProductos();
        });
        
        $("#enlaceLimpiar").click(()=>{
            $("#buscaCodigo").val("");
            $("#buscaNombre").val("");
            $("#buscaDepto").prop('selectedIndex',0);  
            $("#buscaTipo").prop('selectedIndex',0);  
            cargarProductos();
        });
        
        $("#enlaceAgregar").click(()=>{
            accion = 'agregar';
            $("#codigo").val("");
            reset();
            $("#detalle_producto").css('visibility','visible');
            $("#detalle_producto").show();
            $("#codigo").blur(()=>{
                if($("#codigo").val() === ''){
                    reset();
                    return;
                }
                if(!validarNumero($("#codigo").val())){
                    alertify.error("Codigo invalido");
                    $("#codigo").val("");
                    return;
                }
                abrirModificar($("#codigo").val());
            });
        });
        
        $("#enlaceExcel").click(function(){
            var params = "codigo="+$('#buscaCodigo').val()+"&nombre="+$("#buscaNombre").val()+"&nivel=0";
            exportar('source/httprequest/producto/GetProductosExcel',params);            
        });
        
        $("#tipo").change(()=>{
            let aux = $("#tipo").val();
            if(aux === '0'){
                let add = Math.round($("#addStock").val());
                $("#addStock").val(add);
                $("#addStock").attr("step","1");
                let del = Math.round($("#delStock").val());
                $("#addStock").val(del);
                $("#delStock").attr("step","1");
            } else{
                $("#addStock").attr("step","0.125");
                $("#delStock").attr("step","0.125");
            }
        });
    });

    function cargarProductos(){
        var url = "source/httprequest/producto/GetProductos.php";
        $("#tabla_prod tbody").html("");
        var params = {codigo : $("#buscaCodigo").val(), nombre : $("#buscaNombre").val(),
            depto : $("#buscaDepto").val(),tipo : $("#buscaTipo").val(),nivel : "0"};
        var success = function(response)
        {
           if(response.length === 0){
                alertify.error("No hay registros que mostrar");
                return;
            }
            var contenido = '';
            $("#tabla_prod tbody").html("");
            for(var i = 0; i < response.length; i++){
                let producto = response[i];
                if(i % 2 === 0){
                    contenido += "<tr style='background-color:white;'>";
                }
                else{
                    contenido +=  "<tr>";
                }

                contenido += "<td>"+producto.producto_codigo+"</td>\n\
                              <td>"+producto.producto_nombre+"</td>\n\
                              <td>"+producto.producto_descripcion+"</td>\n\
                              <td>$ "+Math.round((parseFloat(producto.producto_coste) + parseFloat(producto.producto_coste_iva)))+"</td>\n\
                              <td>$ "+Math.round((parseFloat(producto.producto_precio) + parseFloat(producto.producto_precio_iva)))+"</td>\n\
                              <td>"+(producto.producto_tipo === '0' ? Math.round(producto.producto_cantidad) : producto.producto_cantidad)+"</td>\n\
                              <td><a onclick=\"abrirModificar('"+producto.producto_codigo+"',true)\" href=\"javascript:void(0)\"><img src= \"img/editar.png\" width=\"20\" height=\"20\"></a></td>\n\
                              <td><a onclick=\"eliminarProducto('"+producto.producto_codigo+"')\" href=\"javascript:void(0)\"><img src= \"img/eliminar.png\" width=\"20\" height=\"20\"></a></td>";           
            }
            $("#tabla_prod tbody").html(contenido);
        };
        postRequest(url,params,success);
    }
    
    function abrirModificar(codigo, mod = false){
        var url = "source/httprequest/producto/GetProducto.php";
        var params = {codigo : codigo,nivel:"0"};
        var success = function(response)
        {
            if(response.producto_nombre !== undefined){
                $("#delStock").prop("disabled",false);
                $("#codigo").val(codigo);
                $("#nombre").val(response.producto_nombre);
                $("#descripcion").val(response.producto_descripcion);
                $("#costo").val(Math.round((parseFloat(response.producto_coste) + parseFloat(response.producto_coste_iva))));
                $("#precio").val(Math.round((parseFloat(response.producto_precio) + parseFloat(response.producto_precio_iva))));
                $("#tipo").val(response.producto_tipo);
                $("#depto").val(response.producto_dep_id);
                $("#existencia").val(response.producto_cantidad);
                $("#addStock").val("0");
                $("#delStock").val("0");
                $("#img").attr("src",response.producto_imagen === '' ? 'img/default.jpg' : 'img/productos/'+response.producto_imagen);
                accion = 'modificar';
                $("#detalle_producto").css('visibility','visible');
                $("#detalle_producto").show();
            }
            else{
                accion = 'agregar';
                if(mod){
                    alertify.error("Producto no disponible");
                }
                reset();
            }
        };
        postRequest(url,params,success);
    }
    
    function guardarProducto(){
        let codigo = $("#codigo").val();
        let nombre = $("#nombre").val();
        let descripcion = $("#descripcion").val();
        let precioCosto = $("#costo").val();
        let precioVenta = $("#precio").val();
        let tipo = $("#tipo").val();
        let imagen = $("#imagenOculta").val();
        let existencia = $("#existencia").val();        
        let addStock = $("#addStock").val();
        let delStock = $("#delStock").val();
        if(codigo === '' || nombre === '' || descripcion === '' || precioCosto === '' || precioVenta === ''){
            alertify.error("Ingrese todos los campos necesarios");
            return;
        }
        if(!validarNumero(precioCosto)){
            alertify.error("Precio costo debe ser numérico");
            return;
        }
        if(!validarNumero(precioVenta)){
            alertify.error("Precio venta debe ser numérico");
            return;
        }
        if(!validarNumero(existencia)){
            alertify.error("Existencia debe ser numérico");
            return;
        }
        if(!validarNumero(addStock)){
            alertify.error("Agregar Stock debe ser numérico");
            return;
        }
        if(!validarNumero(delStock)){
            alertify.error("Quitar stock debe ser numérico");
            return;
        }
        if (parseInt(precioCosto) >= parseInt(precioVenta)){
            alertify.error("El precio de costo no puede ser igual o mayor al precio de venta");
            return;
        }
        if (parseInt(addStock) > 100000){
            alertify.error("Agregar stock debe ser menor o igual a 100000");
            $("#addStock").val("0");
            return;
        }
        if (parseInt(delStock) > 100000){
            alertify.error("Quitar stock debe ser menor o igual a 100000");
            $("#delStock").val("0");
            return;
        }
        
        var params = {codigo : codigo, nombre : nombre,descripcion : descripcion, 
            precioCosto : precioCosto, precioVenta : precioVenta,tipo:tipo, imagen: imagen,
            existencia : existencia, addStock: addStock, delStock: delStock,nivel:"0"};
        if(accion === 'agregar'){
            agregarProducto(params);
        }
        else{
            modificarProducto(params);
        }   
    }

    function modificarProducto(params){
        let url = "source/httprequest/producto/ModProducto.php";
        let success = (response)=>{
            if(response.error === undefined){
                $("#detalle_producto").css('visibility','hidden');
                $("#detalle_producto").hide();
                cargarProductos();
                alertify.success(response.mensaje);
            }
            else if(response.error === '-5'){
                
            }
            else{
                alertify.error(response.error);
            }
        };
        postRequest(url,params,success);
    }
    
    function agregarProducto(params){
        let url = "source/httprequest/producto/AddProducto.php";
        let success = (response)=>{
            if(response.error === undefined){
                $("#detalle_producto").css('visibility','hidden');
                $("#detalle_producto").hide();
                cargarProductos();
                alertify.success(response.mensaje);
            }
            else if(response.error === '-5'){
                cargarProductoNombre(params.nombre);
            }
            else{
                alertify.error(response.error);
            }
        };
        postRequest(url,params,success);
    }
    
    function eliminarProducto(codigo){
        confirmar('Eliminar producto','Esta seguro que desea eliminar el insumo '+codigo,()=>{
            let url = "source/httprequest/producto/DelProducto.php";
            let success = (response)=>{
                if(response.error === undefined){
                    cargarProductos();
                    alertify.success(response.mensaje);
                } else{
                    alertify.error(response.error);
                }
            };
            var params = {codigo : codigo,nivel:"0"};
            postRequest(url,params,success); 
        },()=>{
            
        });
    }
    
    function cargarProductoNombre(nombre){
        let params = {nombre: nombre};
        let url = "source/httprequest/producto/GetProductoNombre.php";
        let success = (response)=>{
            let producto = response;
            confirmar('Producto repetido','El insumo '+nombre+
                    " esta asociado al codigo " + producto.producto_id + ", ¿ desea editar el insumo "+producto.producto_id+" ?",
            ()=>{
                abrirModificar(producto.producto_codigo);
                return;
            },
            ()=>{
                return;
            });
        };
        postRequest(url,params,success); 
    }
    
    function reset(){
        //$("#codigo").val("");
        $("#nombre").val("");
        $("#descripcion").val("");
        $("#costo").val("");
        $("#precio").val("");
        $("#depto").val("");
        $("#tipo").val("0");
        $("#existencia").val("0");
        $("#addStock").val("0");
        $("#delStock").val("0");
        $("#nuevo").val("0");
        $("#normal").val("0");
        $("#premium").val("0");
        $("#catalogo").prop("checked",false);
        $("#img").attr("src","img/default.jpg");
    }
   
    function ocultar(){
        $("#detalle_producto").css('visibility','hidden');
        $("#detalle_producto").hide();
    }