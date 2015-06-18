function validar_fecha(fecha){
    if(fecha.value != '99/99/9999')
    if (fecha !=  undefined && fecha.value !=  ""){
        if (!/^\d{2}\/\d{2}\/\d{4}$/.test(fecha.value)){
            divMensaje = document.getElementById('mensaje');                
            divMensaje.innerHTML= 'La fecha debe tener el formato: dd/mm/aaaa';            
            fecha.style.borderColor='red';
            fecha.focus();
            return false;
        }
        var dia  =  parseInt(fecha.value.substring(0,2),10);
        var mes  =  parseInt(fecha.value.substring(3,5),10);
        var anio =  parseInt(fecha.value.substring(6),10);
        divMensaje = document.getElementById('mensaje');      
    switch(mes){
        case 1:
        case 3:
        case 5:
        case 7:
        case 8: 
        case 10:
        case 12:
            numDias=31;
            break;
        case 4: case 6: case 9: case 11:
            numDias=30;
            break;
        case 2:
            if (comprobarSiBisisesto(anio)){ numDias=29 }else{ numDias=28};
            break;
        default:                     
            divMensaje.innerHTML= 'La fecha ingresada es incorrecta';
            fecha.focus();
            fecha.style.borderColor='red';
            return false;
    }
 
        if (dia>numDias || dia == 0){            
            divMensaje.innerHTML= 'La fecha ingresada es incorrecta';
	    fecha.focus();
            fecha.style.borderColor='red';
            return false;
        }
        fecha.style.borderColor='';
        divMensaje.innerHTML= '';
        //calculo la fecha de hoy 
        var hoy=new Date();
        //resto los años de las dos fechas 
   	var edad=(hoy.getFullYear()+1900)- anio; //-1 porque no se si ha cumplido años ya este año 
        //si resto los meses y me da menor que 0 entonces no ha cumplido años. Si da mayor si ha cumplido 
   	if (hoy.getMonth() < (mes - 1)) //+ 1 porque los meses empiezan en 0 
            edad--;
   	if (((mes-1) == hoy.getMonth()) && (hoy.getDate()<dia))
            edad--;
        if (edad >= 1900)
        {
            edad -= 1900;
        }
        document.getElementById('edad').value=edad;        
        return true;
    }
}

function comprobarSiBisisesto(anio){
if ( ( anio % 100 !=  0) && ((anio % 4  ==  0) || (anio % 400  ==  0))) {
    return true;
    }
else {
    return false;
    }
}

function validar_hora(hora){   
    if (hora !=  undefined && hora.value !=  ""){
        if (!/^\d{2}\:\d{2}$/.test(hora.value)){
            divMensaje = document.getElementById('mensaje');                
            divMensaje.innerHTML= 'La hora debe tener el formato: HH:MM';            
            fecha.style.borderColor='red';
            fecha.focus();
            return false;
        } else {
            divMensaje.innerHTML='';
            return true;
        }
    }
    
}