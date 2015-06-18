function egl() {
    if (event.button==2 || event.button==3) {
    alert("Esta pagina fue diseñada por:\n\nDivision Desarrollo\nTelefono: 4209634");
    }
}
document.onmousedown=egl;

function show5(){
     if (!document.layers&&!document.all&&!document.getElementById)
     return
     var Digital=new Date()
     var hours=Digital.getHours()
     var minutes=Digital.getMinutes()
     var seconds=Digital.getSeconds()
     var dn="AM"
     if (hours>11)
        dn="PM"
     if (hours>12)
        hours=hours-12
    /*  if (hours==0)
     hours=127*/

     if (minutes<=9)
        minutes="0"+minutes
     if (seconds<=9)
        seconds="0"+seconds
    //change font size here to your desire
    myclock="<font size='2' face='Verdana, Arial, Helvetica, sans-serif' align='center' color='000999' ></br>"+hours+":"+minutes+":"
     +seconds+" "+dn+"</font>"
    if (document.layers){
        document.layers.liveclock.document.write(myclock)
        document.layers.liveclock.document.close()
    }
    else if (document.all)
    liveclock.innerHTML=myclock
    else if (document.getElementById)
    document.getElementById("liveclock").innerHTML=myclock
    setTimeout("show5()",1000)
}

