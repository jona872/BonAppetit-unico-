<?php
/**
 * @version    1.0
 * @since      File available since Release 1.0
 * 
*/
// Se chequea si existe un login
require_once ('../usuarios/aut_verifica.inc.php');

if(isset($_GET['t'])) {
    $tipo = $_GET['t'];
} else $tipo = 0;

?>
<!DOCTYPE html>
<html>
<head>    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Bon Appetit</title>
    <link rel="shortcut icon" href="../img/favicon.ico" />    
    <link rel="stylesheet" type="text/css" href="../css/menu.css"> 
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">     
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
        var nocacheurl = url+"&t="+timestamp;

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
            refreshDivs('mesas',1,'mesas.php?tipo=<?=$tipo?>');
        }
    </script>
</head>
<body>
<div class="contenedor">
<header> <?php include_once ('../ClasesBasicas/Encabezado.php'); ?> </header>
<div id="cuerpo">    
    <!-- mesas --> 
        <div id="body">                                                            
            <div id="ubicacion">
                <ul class="ubicacion">
                <?php 
                require_once ('../ClasesBasicas/ConsultaBD.php');
                $con = new ConsultaBD();
                $con->Conectar();        
                $sql = "select * from ubicacion ";
                $con->executeQuery($sql);                    
                if($tipo==0)
                    echo "<a href=index.php?t=0><li class='sel'><span>Todas</span></li></a>";
                else 
                    echo "<a href=index.php?t=0><li><span>Todas</span></li></a>";
                while($inf = $con->getFetchObject()){                    
                    $nombre = htmlentities($inf->descripcion);             
                    if($inf->id==$tipo)
                        echo "<a href=index.php?t=".$inf->id."><li class='sel'><span>".$nombre."</span></li></a>";
                    else
                        echo "<a href=index.php?t=".$inf->id."><li><span>".$nombre."</span></li></a>";
                }
                $con->Close();	
                ?>          
                </ul>
            </div>
            <div id="mesas">
                        
            </div>
        </div>
</div>
<footer><?php include_once ('../ClasesBasicas/Pie.php'); ?></footer>
</div>
</body>
</html>
