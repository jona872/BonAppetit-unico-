function esInteger(e)
{
    var charCode
    if (navigator.appName  ==  "Netscape") // Veo si es Netscape o Explorer (mas adelante lo explicamos)
        charCode = e.which // leo la tecla que ingreso
    else
        charCode = e.keyCode // leo la tecla que ingreso
    status = charCode
    
    if (((charCode!=13)&&(charCode!=27)&&(charCode!=46)) && charCode > 31 && (charCode < 48 || charCode > 58))
    { // Chequeamos que sea un numero comparandolo con los valores ASCII
            return false
    }
    
    return true
}

function calculaTotal(dcto, total) {
    var totalFinal = total-(dcto.value*total/100);
    var flotante = parseFloat(totalFinal);
    var resultado = Math.round(flotante*100)/100;    
    document.getElementById('divTotal').innerHTML=resultado;
    document.getElementById('pagacon').value=resultado;
    document.getElementById('divVuelto').innerHTML="0.00"; 
}

function calculaVuelto(totalDinero, total) {   
    var totalFinal = totalDinero.value-total;
    var flotante = parseFloat(totalFinal);
    var resultado = Math.round(flotante*100)/100;
    document.getElementById('divVuelto').innerHTML=resultado.toFixed(2); 
}