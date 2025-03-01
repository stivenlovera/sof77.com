/*
*Esta libreria es una libreria AJAX creada por Asterio benavides
*
*contacto asterio@coastt.org
*
* Despliega errores en ejecucion y un icono de ejecucion
* parametros
* getAx (url, capa, alto)
* url = programa y url a ejecutar
* capa = DIV donde se mostrara el resultado
* alto = alto en pixeles de la ventana de resultado
* postAx (url,valores, capa, alto)
* valores = conjunto de valores a enviarse en el post
*/

function creaAjaxSimple(){
  var objetoAjax=false;
  try {
   /*Para navegadores distintos a internet explorer*/
   objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
  } catch (e) {
   try {
     /*Para explorer*/
     objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
     } 
     catch (E) {
     objetoAjax = false;
   }
  }

  if (!objetoAjax && typeof XMLHttpRequest!='undefined') {
   objetoAjax = new XMLHttpRequest();
  }
  return objetoAjax;
}

function postAxSimple(url,valores, capa, alto) {
   var ajax=creaAjaxSimple();
   var capaContenedora = document.getElementById(capa);

/*Creamos y ejecutamos la instancia si el metodo elegido es POST*/

    ajax.open ('POST', url, true);
    ajax.onreadystatechange = function() {
         if (ajax.readyState==1) {
                 capaContenedora.innerHTML="<table width=\"100%\"><tr><td align=\"center\" valign=\"middle\" height=\""+alto+"\"><img src=\"..\\images\\indicator.gif\" width=\"16\" height=\"16\" border=0></td></tr></table>";
         }
         else if (ajax.readyState==4){
            if(ajax.status==200)
            {
                 document.getElementById(capa).innerHTML=ajax.responseText; 
            }
            else if(ajax.status==404)
                 {

                     capaContenedora.innerHTML = "La direccion no existe";
                 }
             else
                 {
                     capaContenedora.innerHTML = "Error: " + ajax.status + " " + ajax.responseText;
                 }
        }
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send(valores);
    return;
}

function getAxSimple(url, capa, alto) {
   var ajax=creaAjaxSimple();
   var capaContenedora = document.getElementById(capa);
   
   ajax.open ('GET', url, true);
   ajax.onreadystatechange = function() {
         if (ajax.readyState==1) {
                 capaContenedora.innerHTML="<table width=\"100%\"><tr><td align=\"center\" valign=\"middle\" height=\""+alto+"\"><img src=\"..\\images\\indicator.gif\" width=\"16\" height=\"16\" border=0></td></tr></table>";	
         }
         else if (ajax.readyState==4){
            if(ajax.status==200){ 
                 document.getElementById(capa).innerHTML=ajax.responseText; 
            }
            else if(ajax.status==404)
                 {

                     capaContenedora.innerHTML = "La direccion no existe";
                 }
                 else
                 {
                     capaContenedora.innerHTML = "Error: " + ajax.status + " " + ajax.responseText;
                 }
        }
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send(null);
    return
}


