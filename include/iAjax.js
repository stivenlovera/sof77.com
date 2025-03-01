/*
*Esta libreria es una libreria AJAX creada por Asterio benavides
*
*contacto asterio@incabook.com
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

function postAx (urlpost, valores, capa, alto) {
	  $("#"+capa).html("<div class='ajaxload' style='height='"+ alto +"'></div>")
	  $("#"+capa).show(); 
	$.ajax({ 
		 type: "POST",
		 url: urlpost,
	  	 data: valores,
		 cache: false,
		beforeSend: function(){$("#"+capa).show("fast");}, 
		//complete: function(){ $("#"+capa).hide("fast");},
		success: function(html){ 
	  			//$("#"+capa).show(); 
	  			$("#"+capa).html(html); 
					}
		}); //close $.ajax( 
}


function getAx (urlpost, capa, alto) {
	  $("#"+capa).html("<div class='ajaxload' style='height='"+ alto +"'></div>")	
	  $("#"+capa).show(); 
	$.ajax({ 
		 type: "GET",
		 url: urlpost,
		 cache: false,
		beforeSend: function(){$("#"+capa).show("fast");}, 
		//complete: function(){ $("#"+capa).hide("fast");},
		success: function(html){ 
	  			//$("#"+capa).show(); 
	  			$("#"+capa).html(html); 
					}
		}); //close $.ajax( 
}

function getAxMultip (urlpost, capa, alto, id_display) {
	
var capaContenedora = capa.split("|"); // 
var capaDisplay = document.getElementById(capaContenedora[id_display]);

	  $("#"+capaDisplay).html("<div class='ajaxload' style='height='"+ alto +"'></div>")	
	  $("#"+capaDisplay).show(); 
	$.ajax({ 
		 type: "GET",
		 url: urlpost,
		 cache: false,
		beforeSend: function(){$("#"+capaDisplay).show("fast");}, 
		//complete: function(){ $("#"+capa).hide("fast");},
		success: function(html){ 
	  			//$("#"+capa).show(); 
				var response = html.split("||");

				for (i=0; i <= capaContenedora.length - 1 ; i++) 
					$("#"+capaContenedora[i]).html(response[i]); 
				}
		}); //close $.ajax( 
}

