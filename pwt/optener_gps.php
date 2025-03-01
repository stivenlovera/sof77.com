<script type="text/javascript" src="include/jquery-1.9.1.js"></script>
<script type="text/javascript" src="include/jquery-ui.1.10.3.js"></script>
<script type="text/javascript" src="include/iAjax.js"></script>
		

<script type="text/javascript" src="include/getAjax.js"></script> 
<script type="text/javascript" src="include/funciones.js"></script>
<script type="text/javascript" src="include/jquery.columnhover.js" ></script>	
<!-- Contact Form CSS files -->

<link type='text/css' href='css/basic.css' rel='stylesheet' media='screen' />
<script type='text/javascript' src='include/jquery.simplemodal.js'></script>
<script type="text/javascript" src="include/datepickercontrol.js"></script>
<link type="text/css" rel="stylesheet" href="css/datepickercontrol.css"/> 
<link href="css/flexigrid.pack.css" type="text/css" rel="stylesheet">	
<script type="text/javascript" src="include/flexigrid.pack.js"></script>
<script type="text/javascript" src="include/jquery.jeditable.js"></script>

<script type="text/javascript" src="include/camcanvas.js"></script>
 
	
<script>
	function miubicacion()
	{
		alert("llego");
		if ("geolocation" in navigator){ //check geolocation available
			//try to get user current location using getCurrentPosition() method
			navigator.geolocation.getCurrentPosition(function(position){
					$("#result").html("Found your location xxx <br />Lat : "+position.coords.latitude+" </br>Lang :"+ position.coords.longitude);
				});
		}else{
			console.log("Browser doesn't support geolocation!");
		}
	}
</script>

<button onClick="miubicacion();" >MI Ubicacion</button><br>
<div id="result"></div>