function objetoAjax(){
	var xmlhttp=false;
	try{
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	}catch(e){
		try{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}catch(E){
			xmlhttp = false;
  		}
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

function modificacionUsuario() {
    //nombre y apellido
    divNom = document.getElementById('nom');
    divNom.innerHTML="";
    nombre = document.formulario.nombre.value;
    // identificacion de usuario
    divIden = document.getElementById('iden');
    divIden.innerHTML="";
    identif = document.formulario.usuarionombre.value;
    // password 1
    divP1 = document.getElementById('pass1');
    divP1.innerHTML="";
    passw1 = document.formulario.password1.value;
    // password 2
    divP2 = document.getElementById('pass2');
    divP2.innerHTML="";
    passw2 = document.formulario.password2.value;
    // ambito
    divEfec = document.getElementById('efec');
    divEfec.innerHTML="";
    efe=document.formulario.ambito[document.formulario.ambito.selectedIndex].value;
    // passwords no coinciden
    divFalta = document.getElementById('falta_dato');
    divFalta.innerHTML="";
    
    var opc=0;
    if (nombre=="")
    {divNom.innerHTML= '<img src="../images/valida.jpeg">';opc=1;}
    if (identif=="")
    {divIden.innerHTML= '<img src="../images/valida.jpeg">';opc=1;}
    if (passw1=="")
    {divP1.innerHTML= '<img src="../images/valida.jpeg">';opc=1;}
    if (passw2=="")
    {divP2.innerHTML= '<img src="../images/valida.jpeg">';opc=1;}
    if (efe=="")
    {divEfec.innerHTML= '<img src="../images/valida.jpeg">';opc=1;}
    if ((passw2!="")&&(passw2!="")&&(passw1!=passw2))
    {divFalta.innerHTML= '<br/><br/>Passwords no coinciden<br/>';return false;}

    if  (opc==1)    {
        divFalta.innerHTML= '<br/><br/>(<img src="../images/valida.jpeg">)&nbsp;Dato Requerido';
        return false;}   
    else  { 
      formulario.submit();}
}

function nuevoUsuario() {    
  
    //nombre
    var divNom = document.getElementById('falta_empleado');
    var empleado_id = document.formulario.empleado_hidden.value;
    document.formulario.empleado.style.borderColor='';
    divNom.style.display= 'none';
    // identificacion de usuario
    var divIden = document.getElementById('iden');
    var identif = document.formulario.usuarionombre.value;
    document.formulario.usuarionombre.style.borderColor='';
    divIden.style.display= 'none';
    // password 1
    var divP1 = document.getElementById('pass1');
    var passw1 = document.formulario.password1.value;
    document.formulario.password1.style.borderColor='';
    divP1.style.display= 'none';
    // password 2
    var divP2 = document.getElementById('pass2');
    var passw2 = document.formulario.password2.value;
    document.formulario.password2.style.borderColor='';
    divP2.style.display= 'none';
    
    var nivel = document.getElementById('nivel').value;
    var divNiv = document.getElementById('divNiv');
    document.formulario.nivel.style.borderColor='';
    nivel = nivel.substr(0, 1);
    
    var divFalta = document.getElementById('falta');
    divFalta.innerHTML= '';
    var opc=0;
    
    if (passw2=="") {divP2.style.display= 'inline';document.formulario.password2.style.borderColor='red'; document.formulario.password2.focus();opc=1;} else {divP2.display = 'none';}
    if (passw1=="") {divP1.style.display= 'inline';document.formulario.password1.style.borderColor='red'; document.formulario.password1.focus();opc=1;} else {divP1.display = 'none';}
    if (nivel==0) {divNiv.style.display= 'inline';document.formulario.nivel.style.borderColor='red'; document.formulario.nivel.focus();opc=1;} else {divNiv.innerHTML = '';}
    if (identif=="") {divIden.style.display= 'inline';document.formulario.usuarionombre.style.borderColor='red'; document.formulario.usuarionombre.focus();opc=1;} else {divIden.display = 'none';}    
    if (empleado_id=="") {divNom.style.display= 'inline';document.formulario.empleado.style.borderColor='red'; document.formulario.empleado.focus(); opc=1;} else {divNom.display = 'none';}

    if ((passw2!="")&&(passw2!="")&&(passw1!=passw2)) {divFalta.innerHTML= '<b><br/><br/>Passwords no coinciden<br/></b>';return false;}

    if (opc==1) {
       return false;
    } else {
      divResultado = document.getElementById('resultado');
      ajax=objetoAjax();
      ajax.open("POST", "guardaUsuario.php" ,true);
      ajax.onreadystatechange=function() {
      if (ajax.readyState==1){
            divResultado.innerHTML= '<center><img src="cargandoMini.gif"><br/>Guardando los datos...</center>';
      } else if (ajax.readyState==4) {
               //mostrar los nuevos registros en esta capa
               divFalta.innerHTML = ajax.responseText;
            }
      }
      //muy importante este encabezado ya que hacemos uso de un formulario
      ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
      //enviando los valores
      ajax.send("empleado_id="+empleado_id+"&identif="+identif+"&passw1="+passw1+"&passw2="+passw2+"&nivel="+nivel);
      return true;
    }
}

function editaUsuario() {  
    var ident = document.getElementById('ident').value;
    var divNom = document.getElementById('falta_empleado');
    var empleado_id = document.formulario.empleado_hidden.value;
    document.formulario.empleado.style.borderColor='';
    divNom.style.display= 'none';
  
    // identificacion de usuario
    var divIden = document.getElementById('iden');
    var identif = document.formulario.usuarionombre.value;
    document.formulario.usuarionombre.style.borderColor='';
    divIden.style.display= 'none';
    // password 1
    var divP1 = document.getElementById('pass1');
    var passw1 = document.formulario.password1.value;
    document.formulario.password1.style.borderColor='';
    divP1.style.display= 'none';
    // password 2
    var divP2 = document.getElementById('pass2');
    var passw2 = document.formulario.password2.value;
    document.formulario.password2.style.borderColor='';
    divP2.style.display= 'none';
    
    var nivel = document.getElementById('nivel').value;
    var divNiv = document.getElementById('divNiv');
    document.formulario.nivel.style.borderColor='';
    nivel = nivel.substr(0, 1);
    
    var divFalta = document.getElementById('falta');
    divFalta.innerHTML= '';
    var opc=0;
    
    if (passw2=="") {divP2.style.display= 'inline';document.formulario.password2.style.borderColor='red'; document.formulario.password2.focus();opc=1;} else {divP2.display = 'none';}
    if (passw1=="") {divP1.style.display= 'inline';document.formulario.password1.style.borderColor='red'; document.formulario.password1.focus();opc=1;} else {divP1.display = 'none';}
    if (nivel==0) {divNiv.style.display= 'inline';document.formulario.nivel.style.borderColor='red'; document.formulario.nivel.focus();opc=1;} else {divNiv.innerHTML = '';}
    if (identif=="") {divIden.style.display= 'inline';document.formulario.usuarionombre.style.borderColor='red'; document.formulario.usuarionombre.focus();opc=1;} else {divIden.display = 'none';}   
    if (empleado_id=="") {divNom.style.display= 'inline';document.formulario.empleado.style.borderColor='red'; document.formulario.empleado.focus(); opc=1;} else {divNom.display = 'none';}

    if ((passw2!="")&&(passw2!="")&&(passw1!=passw2)) {divFalta.innerHTML= '<b><br/><br/>Passwords no coinciden<br/></b>';return false;}

    if (opc==1) {
       return false;
    } else {
      divResultado = document.getElementById('resultado');
      ajax=objetoAjax();
      ajax.open("POST", "aut_editar.php" ,true);
      ajax.onreadystatechange=function() {
      if (ajax.readyState==1){
            divResultado.innerHTML= '<center><img src="cargandoMini.gif"><br/>Guardando los datos...</center>';
      } else if (ajax.readyState==4) {
               //mostrar los nuevos registros en esta capa
               divFalta.innerHTML = ajax.responseText;
            }
      }
      //muy importante este encabezado ya que hacemos uso de un formulario
      ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
      //enviando los valores
      ajax.send("empleado_id="+empleado_id+"&identif="+identif+"&passw1="+passw1+"&passw2="+passw2+"&nivel="+nivel+"&id="+ident);
      return true;
    }
}

function modificacionClave() {
   
   // password actual
   var divPA = document.getElementById('passA');   
   var passwA = document.getElementById('passwordA').value;
   document.formulario.passwordA.style.borderColor='';
   divPA.style.display= 'none';

    // password 1
    var divP1 = document.getElementById('pass1');    
    var passw1 = document.getElementById('password1').value;
    document.formulario.password1.style.borderColor='';
    divP1.style.display= 'none';
    
    // password 2
    var divP2 = document.getElementById('pass2');    
    var passw2 = document.getElementById('password2').value;
    document.formulario.password2.style.borderColor='';
    divP2.style.display= 'none';
    
    var ident = document.getElementById('ident').value;

    var divFalta = document.getElementById('falta');
    divFalta.innerHTML= '';
    var opc=0;
    
    if (passw2=="")
    {divP2.style.display= 'inline';document.formulario.password2.style.borderColor='red'; document.formulario.password2.focus();opc=1;} else {divP2.display = 'none';}
    
    if (passw1=="")
    {divP1.style.display= 'inline';document.formulario.password1.style.borderColor='red'; document.formulario.password1.focus();opc=1;} else {divP1.display = 'none';}
    
     if (passwA=="")
    {divPA.style.display= 'inline';document.formulario.passwordA.style.borderColor='red'; document.formulario.passwordA.focus();opc=1;} else {divPA.display = 'none';}
    
    if ((passw2!="")&&(passw2!="")&&(passw1!=passw2))
    {divFalta.innerHTML= '<b><br/><br/>Las claves nuevas no coinciden<br/></b>';return false;}

    if (opc==1) {
       return false;
    } else {
      divResultado = document.getElementById('resultado');
      ajax=objetoAjax();
      ajax.open("POST", "aut_cambio_clave.php" ,true);
      ajax.onreadystatechange=function() {
      if (ajax.readyState==1){
         divFalta.innerHTML= '<center><img src="../images/cargando.gif"><br/>Guardando los datos...</center>';
      } else if (ajax.readyState==4) {
               //mostrar los nuevos registros en esta capa
               divFalta.innerHTML = ajax.responseText;
            }
      }
      //muy importante este encabezado ya que hacemos uso de un formulario
      ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
      //enviando los valores
      ajax.send("passwordA="+passwA+"&password1="+passw1+"&password2="+passw2+"&passw2="+passw2+"&id="+ident);
       return true;
    }
}

function borrarUsuario(ident){
   var opc = confirm('Esta por eliminar un usuario');
   if (!opc) {
       return false;
    } else {
      divResultado = document.getElementById('resultado');
      ajax=objetoAjax();
      ajax.open("POST", "aut_baja_usuario.php" ,true);
      ajax.onreadystatechange=function() {
      if (ajax.readyState==1){
         divResultado.innerHTML= '<center><img src="../images/cargando.gif"><br/>Guardando los datos...</center>';
      } else if (ajax.readyState==4) {
               //mostrar los nuevos registros en esta capa
               divResultado.innerHTML = ajax.responseText;
            }
      }
      //muy importante este encabezado ya que hacemos uso de un formulario
      ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
      //enviando los valores
      ajax.send("ident="+ident);
       return true;
    }
}

function activarUsuario(ident){
   var opc = confirm('Esta por activar un usuario');
   if (!opc) {
       return false;
    } else {
      divResultado = document.getElementById('resultado');
      ajax=objetoAjax();
      ajax.open("POST", "aut_activar_usuario.php" ,true);
      ajax.onreadystatechange=function() {
      if (ajax.readyState==1){
         divResultado.innerHTML= '<center><img src="../images/cargando.gif"><br/>Guardando los datos...</center>';
      } else if (ajax.readyState==4) {
               //mostrar los nuevos registros en esta capa
               divResultado.innerHTML = ajax.responseText;
            }
      }
      //muy importante este encabezado ya que hacemos uso de un formulario
      ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
      //enviando los valores
      ajax.send("ident="+ident);
       return true;
    }
}

function editarUsuario(ident){
   divResultado = document.getElementById('contenedor');
   ajax=objetoAjax();
   ajax.open("POST", "aut_form_editar.php" ,true);
   ajax.onreadystatechange=function() {
   if (ajax.readyState==1){
      divResultado.innerHTML= '<center><img src="../images/cargando.gif"><br/>Guardando los datos...</center>';
   } else if (ajax.readyState==4) {
            //mostrar los nuevos registros en esta capa
            divResultado.innerHTML = ajax.responseText;
         }
   }
   //muy importante este encabezado ya que hacemos uso de un formulario
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("ident="+ident);
      return true;
}

function especialidades(ident){
   divResultado = document.getElementById('contenedor');
   ajax=objetoAjax();
   ajax.open("POST", "aut_especialidades.php" ,true);
   ajax.onreadystatechange=function() {
   if (ajax.readyState==1){
      divResultado.innerHTML= '<center><img src="../images/cargando.gif"><br/>Guardando los datos...</center>';
   } else if (ajax.readyState==4) {
            //mostrar los nuevos registros en esta capa
            divResultado.innerHTML = ajax.responseText;
         }
   }
   //muy importante este encabezado ya que hacemos uso de un formulario
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("ident="+ident);
      return true;
}

function modificaUsuarioExistente() {
    //nombre y apellido
    var ident = document.getElementById('ident').value;
    
    var divNom = document.getElementById('nom');
    var nombre = document.formulario.nombre.value;
    // identificacion de usuario
    var divIden = document.getElementById('iden');
    var identif = document.formulario.usuarionombre.value;
    // password 1
    var divP1 = document.getElementById('pass1');
    var passw1 = document.formulario.password1.value;
    // password 2
    var divP2 = document.getElementById('pass2');
    var passw2 = document.formulario.password2.value;
    
    var nivel = document.getElementById('nivel').value;
    var divNiv = document.getElementById('divNiv');
    nivel = nivel.substr(0, 1);
    
    var divFalta = document.getElementById('falta_dato');
    divFalta.innerHTML="";

    var opc=0;
    if (nombre=="") {divNom.innerHTML= '<img src="../images/valida.jpeg">';opc=1;} else {divNom.innerHTML = '';}
    if (identif=="") {divIden.innerHTML= '<img src="../images/valida.jpeg">';opc=1;} else {divIden.innerHTML = '';}
    if (passw1=="") {divP1.innerHTML= '<img src="../images/valida.jpeg">';opc=1;} else {divP1.innerHTML = '';}
    if (passw2=="") {divP2.innerHTML= '<img src="../images/valida.jpeg">';opc=1;} else {divP2.innerHTML = '';}
    if (nivel!="Z" && nivel!="N" && nivel!="C") {divNiv.innerHTML= '<img src="../images/valida.jpeg">';opc=1;} else {divNiv.innerHTML = '';}
    if ((passw2!="")&&(passw2!="")&&(passw1!=passw2)) {divFalta.innerHTML= '<b><br/><br/>Passwords no coinciden<br/></b>';return false;}

   if (opc==1) {
       divFalta.innerHTML= '<br/><br/>(<img src="../images/valida.jpeg">)&nbsp;Dato Requerido';
       return false;
    } else {
      divResultado = document.getElementById('resultado');
      ajax=objetoAjax();
      ajax.open("POST", "aut_modificar_usuario.php" ,true);
      ajax.onreadystatechange=function() {
      if (ajax.readyState==1){
         divResultado.innerHTML= '<center><img src="../images/cargando.gif"><br/>Guardando los datos...</center>';
      } else if (ajax.readyState==4) {
               //mostrar los nuevos registros en esta capa
               divResultado.innerHTML = ajax.responseText;
            }
      }
      //muy importante este encabezado ya que hacemos uso de un formulario
      ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
      //enviando los valores
      ajax.send("nombre="+nombre+"&identif="+identif+"&passw1="+passw1+"&passw2="+passw2+"&nivel="+nivel+"&ident="+ident);
       return true;
    }
}

function esInteger(e)
{
    var charCode
    if (navigator.appName  ==  "Netscape") // Veo si es Netscape o Explorer (mas adelante lo explicamos)
        charCode = e.which // leo la tecla que ingreso
    else
        charCode = e.keyCode // leo la tecla que ingreso
    status = charCode
    if (charCode > 31 && (charCode < 48 || charCode > 58))
    { // Chequeamos que sea un numero comparandolo con los valores ASCII
            return false
    }
            return true
}

function pedirDatos(){
	//donde se mostrar� el formulario con los datos
	divFormulario = document.getElementById('contenedor');
	divCargando = document.getElementById('cargando');
	divDocu = document.getElementById('valida_dni');
	
	dni = document.getElementById('dni').value;		
	
	if (dni==0)
	{
		divDocu.innerHTML= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';	
		return false;
	}	
	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	ajax.open("POST", "nuevoUsuario.php");
	divCargando.innerHTML= '<img src="js/cargandoMini.gif">';
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			//mostrar resultados en esta capa                        
			divFormulario.innerHTML = ajax.responseText;
			divFormulario.style.display="block";
                        document.getElementById('dni').focus();
		}
	}
	//como hacemos uso del metodo POST
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando el codigo del empleado
	ajax.send("dni="+dni);
}