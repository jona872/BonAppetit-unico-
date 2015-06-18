<?php
/**
 * @version    1.0
 * @since      File available since Release 1.0
 * 
*/
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ConsultaBD.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>        
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Bon Appetit</title>
    <link rel="shortcut icon" href="../img/favicon.ico" />    
    <link rel="stylesheet" type="text/css" href="../css/jquery.autocomplete.css" />
    <link rel="stylesheet" type="text/css" href="../css/menu.css" /> 
    <link rel="stylesheet" type="text/css" href="../css/estilos.css" /> 
    <!-- lista dinamica -->
<!--    <script type="text/javascript" src="js/ajax-dynamic-list.js"></script>
    <script type="text/javascript" src="js/ajax.js"></script>   -->

    <script type="text/javascript"> 
        function guardarDatos(){
            var item = document.getElementById('myitem');
            var item_id = document.getElementById('item');
            var cantidad = document.getElementById('cantidad');
            item.style.borderColor='';  
            cantidad.style.borderColor='';
            error=0
            if(item.value==''){
                item.style.borderColor='red';
                item.focus();
                error=1
            }
            if(item_id.value=='')
                error=1;
            if((cantidad.value=='')||(cantidad.value==0)){
//                cantidad.style.borderColor='red';
//                cantidad.focus();
//                error=1;
                  cantidad.value=1;  
            }
            if(error==1)   { 
                cantidad.value=''; 
                item.value='';
                item_id.value='';
                return false;        
            } else
                frm_agregar.submit();
        }

	function fn_agregar(){
		var str = $("#frm_agregar").serialize();
		$.ajax({
			url: 'ajax_agregar.php',
			data: str,
			type: 'post',
			success: function(data){
				if(data != "")
					alert(data);
                                document.getElementById('item').value='';
                                document.getElementById('myitem').value='';
                                document.getElementById('cantidad').value='';
                                document.getElementById('observaciones').value='';
				fn_buscar(<?php echo $_GET['p']; ?>);
			}
		});
	};
        
        function fn_eliminar(ide_ped){
            var respuesta = confirm("Desea eliminar el pedido?");
            if (respuesta){
                    $.ajax({
                            url: 'ajax_eliminar.php',
                            data: 'ide_ped=' + ide_ped,
                            type: 'post',
                            success: function(data){
                                    if(data!="")
                                            alert(data);
                                    fn_buscar(<?php echo $_GET['p']; ?>)
                            }
                    });
            }
        }
        
        function fn_sumar(ide_ped){
            $.ajax({
                    url: 'ajax_sumar.php',
                    data: 'ide_ped=' + ide_ped,
                    type: 'post',
                    success: function(data){
                            if(data!="")
                                    alert(data);
                            fn_buscar(<?php echo $_GET['p']; ?>)
                    }
            });
        }
        
        function fn_sumarEntregado(ide_ped){
            $.ajax({
                    url: 'ajax_sumarEntregado.php',
                    data: 'ide_ped=' + ide_ped,
                    type: 'post',
                    success: function(data){
                            if(data!="")
                                    alert(data);
                            fn_buscar(<?php echo $_GET['p']; ?>)
                    }
            });
        }
        
        function fn_restar(ide_ped){
            $.ajax({
                    url: 'ajax_restar.php',
                    data: 'ide_ped=' + ide_ped,
                    type: 'post',
                    success: function(data){
                            if(data!="")
                                    alert(data);
                            fn_buscar(<?php echo $_GET['p']; ?>)
                    }
            });
        }
        
        function fn_entregar(ide_ped){
		$.ajax({
                    url: 'ajax_entregar.php',
                    data: 'ide_ped=' + ide_ped,
                    type: 'post',
                    success: function(data){
                            if(data!="")
                                    alert(data);
                            fn_buscar(<?php echo $_GET['p']; ?>)
                    }		
		});
	};
        
        function fn_cocinar(ide_ped){
		$.ajax({
                    url: 'ajax_cocinar.php',
                    data: 'ide_ped=' + ide_ped,
                    type: 'post',
                    success: function(data){
                            if(data!="")
                                    alert(data);
                            fn_buscar(<?php echo $_GET['p']; ?>)
                    }		
		});
	};
        
        function fn_tomarpedido(ide_ped){
		$.ajax({
                    url: 'ajax_tomarpedido.php',
                    data: 'ide_ped=' + ide_ped,
                    type: 'post',
                    success: function(data){
                            if(data!="")
                                    alert(data);
                            fn_buscar(<?php echo $_GET['p']; ?>)
                    }		
		});
	};
        
        function marcar(source) 
	{
		checkboxes=document.getElementsByTagName('input'); //obtenemos todos los controles del tipo Input
		for(i=0;i<checkboxes.length;i++) //recoremos todos los controles
		{
			if(checkboxes[i].type == "checkbox") //solo si es un checkbox entramos
			{
				checkboxes[i].checked=source.checked; //si es un checkbox le damos el valor del checkbox que lo llamó (Marcar/Desmarcar Todos)
			}
		}
	}
    </script>
    <script language="javascript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>    
    <script language="javascript" type="text/javascript" src="js/jquery.blockUI.js"></script>
    <script type="text/javascript" src="js/jquery.autocomplete.js" />    
    <script language="javascript" type="text/javascript" src="js/jquery.validate.1.5.2.js"></script>    
    <script language="javascript" type="text/javascript" src="index.js"></script>
    <script type="text/javascript" src="js/valida.js"></script>
    <script type="text/javascript" src="js/jquery.jeditable.js"></script>
    <script type="text/javascript" language="javascript">
        function refreshDivs(divid,secs,url)
        {

        // define our vars
        var divid,secs,url,fetch_unix_timestamp;

        // Chequeamos que las variables no esten vacias..
        if(divid == ""){ alert('Error: escribe el id del div que quieres refrescar'); return;}
        else if(!document.getElementById(divid)){ alert('Error: el Div ID selectionado no esta definido: '+divid); return;}
        else if(secs == ""){ alert('Error: indica la cantidad de segundos que quieres que el div se refresque'); return;}
        else if(url == ""){ alert('Error: la URL del documento que quieres cargar en el div no puede estar vacia.'); return;}

        // The XMLHttpRequest object

        var xmlHttp;
        try{
        xmlHttp=new XMLHttpRequest(); // Firefox, Opera 8.0+, Safari
        }
        catch (e){
        try{
        xmlHttp=new ActiveXObject("Msxml2.XMLHTTP"); // Internet Explorer
        }
        catch (e){
        try{
        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch (e){
        alert("Tu explorador no soporta AJAX.");
        return false;
        }
        }
        }

        // Timestamp para evitar que se cachee el array GET

        fetch_unix_timestamp = function()
        {
        return parseInt(new Date().getTime().toString().substring(0, 10))
        }

        var timestamp = fetch_unix_timestamp();
        var nocacheurl = url+"?t="+timestamp+"&id="+<?php echo $_GET['p']?>;

        // the ajax call
        xmlHttp.onreadystatechange=function(){
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200){
        document.getElementById(divid).innerHTML=xmlHttp.responseText;
        setTimeout(function(){refreshDivs(divid,secs,url);},secs*1000);
        }
        }
        xmlHttp.open("GET",nocacheurl,true);
        xmlHttp.send(null);
    
        }

        // LLamamos las funciones con los repectivos parametros de los DIVs que queremos refrescar.
        window.onload = function startrefresh(){
            document.getElementById('myitem').focus();
            
          //  refreshDivs('mesas',1,'reloj_Mesa.php');
        }
    </script>
    <script language="javascript" type="text/javascript">
    $(document).ready(function(){
	fn_buscar(<?php echo $_GET['p']; ?>);
	$("#grilla tbody tr").mouseover(function(){
		$(this).addClass("over");
	}).mouseout(function(){
		$(this).removeClass("over");
	});
    });    
    
    </script>
    <script type="text/javascript">
var timeInput;
var timeButton;
var timeDiv;
var timerDate;
var timerHandler;
 

function startTimer() {
    if(document.getElementById('time').value!='') {
        timeInput = document.getElementById('time');
        verifica = document.getElementById('verifica').value;
        timeDiv = document.getElementById('apDiv3');  
	mesa = document.getElementById('mesaO');
        display = document.getElementById('display');
        
        var timeStr = timeInput.value;
	if(timeStr == null || timeStr == "") return;
	
	var timeValues = timeStr.split(":");
	var th = parseInt(timeValues[0], 10);
	var tm = parseInt(timeValues[1], 10);
	var ts = parseInt(timeValues[2], 10);
	
	timerDate = new Date();
	timerDate.setHours(th);
	timerDate.setMinutes(tm);
	timerDate.setSeconds(ts);


	if(timerHandler) {
		timerHandler = clearInterval(timerHandler);
	}
	
	if(th == 0 && tm == 0 && ts == 0) return;

        if(verifica==0)
            timerHandler = setInterval(updateNegativo, 1000);
        else
            timerHandler = setInterval(update, 1000);
    }
	
}
function update() {
	var th = timerDate.getHours();
	var tm = timerDate.getMinutes();
	var ts = timerDate.getSeconds();

	var str = (th < 10 ? ( "0" + th ): th) + ":"
			+ (tm < 10 ? ( "0" + tm ): tm) + ":"
			+ (ts < 10 ? ( "0" + ts ): ts);
	timeDiv.innerHTML = str;
        
	if(th == 0 && tm == 0 && ts == 0) { mesaO.style.backgroundColor='#222222'; 
        document.getElementById('verifica').value=0; document.getElementById('time').value="-00:00:01"; startTimer()}        
	else timerDate.setSeconds(--ts);
        
}
function updateNegativo() {
	var th = timerDate.getHours();
	var tm = timerDate.getMinutes();
	var ts = timerDate.getSeconds();

	var str = (th < 10 ? ( "0" + th ): th) + ":"
			+ (tm < 10 ? ( "0" + tm ): tm) + ":"
			+ (ts < 10 ? ( "0" + ts ): ts);
	timeDiv.innerHTML = str;        
	if(th == 0 && tm == 0 && ts == 0) { mesaO.style.backgroundColor='#222222';}                
	else timerDate.setSeconds(++ts);
        
}
</script>
</head>
<body >
<div class="contenedor">
<header> <?php 
if(isset($_GET['p'])) {
include_once '../ClasesBasicas/Encabezado.php'; ?> </header>
<div id="cuerpo" style="padding-bottom: 50px;">    
    <div id="body">
    <?php   if(!isset($_GET['c'])) { ?>
    <form id="frm_agregar" name="frm_agregar" action="javascript: fn_agregar(<?php echo $_GET['p']?>);document.getElementById('myitem').focus();" autocomplete="off" method="POST" >
        <fieldset>
        <input type="hidden" name="pedido_maestro_id" id="pedido_maestro_id" value="<?php echo $_GET['p']?>"/>
        <div id="resultado" style="text-align: left">    
            
            <?php 
            
            $conexion = new ConsultaBD();
                       
            echo "<h1>Comanda</h1>";

//            echo "<div class='mesa'><div class='numero'>".$ver->mesa_nro."</div><div class='reloj'>MESA</div></div><p>";

            $conexion->Conectar();
            $sql = 'SELECT * FROM receta_maestros';                               
            $select =  $conexion->executeQuery($sql);;
            $conexion->Close();
            $dd='';
            $value= null;
            $field='item';
                $dd .= '<script type="text/javascript">
                $(function()
                {
                        // Updated script
                        var categories = $.map($("#s'.$field.' option"),function(e, i)
                        {
                        return e;
                        });

                        $("#my'.$field.'").autocomplete(categories,
                        {
                        matchContains : true,
                        formatItem : function(item) { return item.text; }
                        });
                        // Added to fill hidden field with option value
                        $("#my'.$field.'").result(function(event, item, formatted)
                        {
                        $("#'.$field.'").val(item.value);
                        }
                )});
                </script>';
                $dd .= '
                <input type="hidden" id="'.$field.'" name="'.$field.'" size="1" readonly="true"></input>
                <input type="text" id="my'.$field.'" name="my'.$field.'" size="50" onKeypress="if((event.keyCode == 13)||(event.charCode == 27)) guardarDatos();">
                    </input>'.'<select id="s'.$field.'" style="display: none">';
                while ($foreign = mysql_fetch_assoc($select)) {  
                        $dd .= "<option title=\"".$foreign['descripcion']."\"   value='".$foreign['id']."'";
                        if ($foreign['id'] == $value){ $dd .= ' selected';}
                        if (!empty($foreign['descripcion'])){
                                $dd .= '>'.utf8_encode($foreign['descripcion'])." - ".$foreign['codigo'].'</option>';
                        }else{
                                $dd .= '>'.$foreign['id'].'</option>';
                        }
                } 

                echo  $dd;
		
            ?>            
      
<!--                <input type="text" id="item" name="item" value="" onKeyUp="ajax_showOptionsItem(this,'getItemByLetters',event)" size="50" placeholder="Adicionar" onBlur="this.style.color='#333333'" onKeypress="if((event.keyCode == 13)||(event.charCode == 27)) guardarDatos();" />*
                <input type="hidden" id="item_hidden" name="item_ID" />-->
                <div id="falta_item" class="falta_dato" style="display:none;">*</div>            
                <input type="text" id="cantidad" name="cantidad" value="" size="10" onKeypress="if((event.keyCode == 13)||(event.charCode == 27)) guardarDatos(); return esInteger(event)" placeholder="Cantidad"/>                                                
                <textarea id="observaciones" name="observaciones" placeholder="Observaciones" onKeypress="if((event.keyCode == 13)||(event.charCode == 27)) guardarDatos();"></textarea>
                <div style="margin: 0 auto;">
                <input type="button" value="&nbsp;&nbsp;&nbsp;Guardar&nbsp;&nbsp;&nbsp;" class="button" onclick="guardarDatos()" name="guardar"/>                                             
                </div>
            
        </div>
        </fieldset>
    </form>
    <?php  } ?>
    <center>
        <div id="div_listar" style="margin-top: 10px;"></div>
    </center>
    <div id="div_oculto" style="display: none;"></div>
    </div>
</div>
<?php } ?>
</div>
<footer><?php include_once '../ClasesBasicas/Pie.php'; ?></footer>
</body>
</html>