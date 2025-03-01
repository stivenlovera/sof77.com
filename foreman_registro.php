<?php

	session_name("Administrador");
	session_start();		

	if ($_SESSION["EntityID"] == "")
	{
		header("Location:sessionexpired.php"); 	
	}	

	require('Library/Control_Cache.php');	
	require('Library/Open_Conexion.php');	
	require('Library/funciones.php');	

	$Empleado_ID=$_SESSION["Empleado_ID"];
	//echo $_SESSION["Empleado_ID"];			
	require('funciones_php/foreman.php');
	require('funciones_php/empleado.php');	
?>
<meta name="viewport" content="width=device-width, user-scalable=no">
<LINK href="include/Stat.css" type="text/css" rel="stylesheet">
<link rel="STYLESHEET" type="text/css" href="include/estilo_reporte.css">


<LINK href="include/jquery-ui.css" type="text/css" rel="stylesheet">
<LINK href='include/demo.css' type='text/css' rel='stylesheet' media='screen' />


<script type="text/javascript" src="include/jquery-1.9.1.js"></script>
<script type="text/javascript" src="include/jquery-ui.1.10.3.js"></script>
<script type="text/javascript" src="include/iAjax.js"></script>
		

<script type="text/javascript" src="include/getAjax.js"></script> 
<script type="text/javascript" src="include/funciones.js"></script>

<script type="text/javascript" src="include/flexigrid.pack.js"></script>	
<script type="text/javascript" src="include/jquery.jeditable.js"></script> 

<!-- Contact Form CSS files -->

<link type='text/css' href='css/basic.css' rel='stylesheet' media='screen' />

<script type="text/javascript">	
	var Latitud="";
	var Longitud="";
	
	
	function SendEnter (event) {
			var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
			if (keyCode == 13) {		
					postAx('foreman_validaPassword2.php','user='+document.ss.username.value+'&pass='+document.ss.password.value+'&Pro_ID='+document.ss.Pro_ID.value+'&Reg_ID='+document.ss.Reg_ID.value,'passWrong',15);			
			} 
			else
			return true;
		}   
	
	function SendClick () 
	{
		postAx('foreman_validaPassword2.php','user='+document.ss.username.value+'&pass='+document.ss.password.value+'&Pro_ID='+document.ss.Pro_ID.value+'&Reg_ID='+document.ss.Reg_ID.value,'passWrong',15);			
	}      
	
	function postAxLog (url,valores, capa, alto) {
	   var ajax=creaAjax();
	   var capaContenedora = document.getElementById(capa);
	
	/*Creamos y ejecutamos la instancia si el metodo elegido es POST*/
	
		ajax.open ('POST', url, true);
		ajax.onreadystatechange = function() {
			 if (ajax.readyState==1) {
					 capaContenedora.innerHTML="<table width=\"100%\"><tr><td align=\"center\" valign=\"middle\" height=\""+alto+"\"><img src=\"images\\indicatortext.gif\" width=\"80\" height=\"16\" border=0></td></tr></table>";
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
</script>
<script>	
	function subir_foto_form()
	{
		$("#mensaje").html("<img src='images/indicator.gif'>");
		
		
    	var formData = new FormData(document.getElementById("formuploadajax"));
        formData.append("dato", "valor");
        $.ajax({
                url: "foreman_registro_actividad_asistencia_foto.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
	     		processData: false
            }).done(function(res){
                    $("#div_asistencia_reg").html(res);
                });       
    }
 </script> 
<script>
	//function miubicacion()
	//{
		//alert("llego");
		if ("geolocation" in navigator){ //check geolocation available
		//alert("entro a la preguntaGPS ");
			//try to get user current location using getCurrentPosition() method
			navigator.geolocation.getCurrentPosition(function(position){
					//$("#result").html("Found your location xxx <br />Lat : "+position.coords.latitude+" </br>Lang :"+ position.coords.longitude);
					Latitud=position.coords.latitude,
					Longitud=position.coords.longitude
				});
		}else{
			console.log("Browser doesn't support geolocation!");
		}

//alert(Latitud);

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://unpkg.com/emodal@1.2.69/dist/eModal.min.js"></script>
<style type="text/css">
	p.MsoNormal {
	margin:0cm;
	margin-bottom:.0001pt;
	font-size:12.0pt;
	font-family:"Times New Roman";
	}
</style>

<style type="text/css">
	<!--
	.style10 {
		color: #FF0000;
		font-size: medium;
	}
	-->
	
	td.betterhover, #tabletwo tbody tr:hover
	{
		background: LightCyan;
	}
</style>
<style>
	.modal-open{overflow:hidden}.modal{position:fixed;top:0;right:0;bottom:0;left:0;z-index:1050;display:none;overflow:hidden;outline:0}.modal-open .modal{overflow-x:hidden;overflow-y:auto}.modal-dialog{position:relative;width:auto;margin:.5rem;pointer-events:none}.modal.fade .modal-dialog{transition:-webkit-transform .3s ease-out;transition:transform .3s ease-out;transition:transform .3s ease-out,-webkit-transform .3s ease-out;-webkit-transform:translate(0,-25%);transform:translate(0,-25%)}.modal.show .modal-dialog{-webkit-transform:translate(0,0);transform:translate(0,0)}.modal-dialog-centered{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;min-height:calc(100% - (.5rem * 2))}.modal-content{position:relative;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;width:100%;pointer-events:auto;background-color:#fff;background-clip:padding-box;border:1px solid rgba(0,0,0,.2);border-radius:.3rem;outline:0}.modal-backdrop{position:fixed;top:0;right:0;bottom:0;left:0;z-index:1040;background-color:#000}.modal-backdrop.fade{opacity:0}.modal-backdrop.show{opacity:.5}.modal-header{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:start;-ms-flex-align:start;align-items:flex-start;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;padding:1rem;border-bottom:1px solid #e9ecef;border-top-left-radius:.3rem;border-top-right-radius:.3rem}.modal-header .close{padding:1rem;margin:-1rem -1rem -1rem auto}.modal-title{margin-bottom:0;line-height:1.5}.modal-body{position:relative;-webkit-box-flex:1;-ms-flex:1 1 auto;flex:1 1 auto;padding:1rem}.modal-footer{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:end;-ms-flex-pack:end;justify-content:flex-end;padding:1rem;border-top:1px solid #e9ecef}.modal-footer>:not(:first-child){margin-left:.25rem}.modal-footer>:not(:last-child){margin-right:.25rem}.modal-scrollbar-measure{position:absolute;top:-9999px;width:50px;height:50px;overflow:scroll}@media (min-width:576px){.modal-dialog{max-width:500px;margin:1.75rem auto}.modal-dialog-centered{min-height:calc(100% - (1.75rem * 2))}.modal-sm{max-width:300px}}@media (min-width:992px){.modal-lg{max-width:800px}}
	.close{padding:1rem;margin:-1rem -1rem -1rem auto}
	button.close{padding:0;background-color:transparent;border:0;-webkit-appearance:none}
	@media only screen and (min-width: 580px) {
            .modal-lg {
                max-width: 80% !important;
            }
        }

        .file-footer-buttons>.btn {
            padding: 0.625rem 1rem;
            min-width: 0 !important;
            margin-top: 1rem;
        }
</style>
<style type="text/css">
	<!--
	.sinput {
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size: 10px;
	}
	-->
</style>
	<div id="result"></div>
	<div id="div_registro_res">
<?php
	//echo "llego";	
	
	$Reg_ID=-1;	

	echo "<img src='images/spacer.gif' width='16' height='16' onload=\"foreman_registro_actividad(".$Reg_ID.");\"  align='middle'/>";	
?>
	</div>
	<div id="div_registro_actividad"></div>
<?php
	require('Library/Close_Conexion.php');	
?>


