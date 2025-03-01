function printSelection(node,estilo_print){

  var content=node.innerHTML
  var pwin=window.open('','print_content','width=10,height=10');

  pwin.document.open();
  if (!(estilo_print))
	pwin.document.write('<html><body onload="window.print()" style="margin-top:0px;margin-left:0px;margin-bottom:0px;margin-right:0px;padding-top:0px; padding-right:0px; padding-bottom:0px; padding-left:0px;">'+content+'</body></html>');
  else
  	pwin.document.write('<html><head><link rel="STYLESHEET" type="text/css" href="include/estilo_imprimir.css"></head><body onload="window.print()" style="margin-top:0px;margin-left:0px;margin-bottom:0px;margin-right:0px;padding-top:0px; padding-right:0px; padding-bottom:0px; padding-left:0px;font-family:Arial, Helvetica, sans-serif;font-size:small;">'+content+'</body></html>');
	
  pwin.document.close(); 
  setTimeout(function(){pwin.close();},1000);
}

function isNumeric(x) {

// I use this function like this: if (isNumeric(myVar)) { }
// regular expression that validates a value is numeric
var RegExp = /^(-)?(\d*)(\.?)(\d*)$/; // Note: this WILL allow a number that ends in a decimal: -452.
// compare the argument to the RegEx
// the 'match' function returns 0 if the value didn't match
var result = x.match(RegExp);
return result;
}


function checkdate(input){
var validformat=/^\d{2}\/\d{2}\/\d{4}$/ //Basic check for format validity
var returnval=false
if (input == '')
	returnval=true
else {
	if (!validformat.test(input))
	alert("Formato de fecha incorrecta. Por favor corrige y envie nuevamente.")
	else{ //Detailed check for valid date ranges
	var monthfield=input.split("/")[0]
	var dayfield=input.split("/")[1]
	var yearfield=input.split("/")[2]
	var dayobj = new Date(yearfield, monthfield-1, dayfield)
	if ((dayobj.getMonth()+1!=monthfield)||(dayobj.getDate()!=dayfield)||(dayobj.getFullYear()!=yearfield))
	alert("Rango invalido en Dia, Mes o Año.")
	else
	returnval=true
	}
}
//if (returnval==false) input.select()
return returnval
}


function ismail(checkStr)
{  
  var Valid = false;
  var Validp = false;
  for (i = 0;  i < checkStr.length;  i++)
  {
    ch = checkStr.charAt(i);    
      if (ch == "@")    
      {
        Valid = true;       
      }  
      if (ch == ".")
      {
        Validp = true;        
      }              
  } 
    if (Valid && Validp ) 
    	return(true)
    else
        return(false)	       
}


/*var html5_audiotypes={ //define list of audio file extensions and their associated audio types. Add to it if your specified audio file isn't on this list:
	"mp3": "audio/mpeg",
	"mp4": "audio/mp4",
	"ogg": "audio/ogg",
	"wav": "audio/wav"
}

function createsoundbite(sound){
	var html5audio=document.createElement('audio')
	if (html5audio.canPlayType){ //check support for HTML5 audio
		for (var i=0; i<arguments.length; i++){
			var sourceel=document.createElement('source')
			sourceel.setAttribute('src', arguments[i])
			if (arguments[i].match(/\.(\w+)$/i))
				sourceel.setAttribute('type', html5_audiotypes[RegExp.$1])
			html5audio.appendChild(sourceel)
		}
		html5audio.load()
		html5audio.playclip=function(){
			html5audio.pause()
			html5audio.currentTime=0
			html5audio.play()
		}
		return html5audio
	}
	else{
		return {playclip:function(){throw new Error("Your browser doesn't support HTML5 audio unfortunately")}}
	}
}*/

