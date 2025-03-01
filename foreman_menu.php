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
	
	$Pro_ID=$_GET["Pro_ID"];
	$Actividad_ID=$_GET["Actividad_ID"];
	$Reg_ID=$_GET["Reg_ID"];	
	$_SESSION["Pro_ID"]=$Pro_ID;	
	//echo $Actividad_ID." actividad en formen<br>".$Pro_ID."Proy".$Reg_ID."RegID";

	$consulta = "SELECT* FROM personal WHERE personal.Empleado_ID=".$Empleado_ID;
	$result2=$bd->ejecutar($consulta);
		while (($row2 = mysqli_fetch_array($result2) ))
		{				
			
		}
	
?>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td align="left">
			<div id=tabmenu>
				<ul> 	
					<li onclick="makeactive(1,<?php echo $Reg_ID; ?>,<?php echo $Actividad_ID; ?>,<?php echo $Pro_ID; ?>)"><a class="" id="tab1"><span>Records-&gt;</span></a></li> 				
					<li onclick="makeactive(2,<?php echo $Reg_ID; ?>,<?php echo $Actividad_ID; ?>,<?php echo $Pro_ID; ?>)"><a class="" id="tab2"><span>Reports-&gt; </span></a></li> 
					<li ><a class="" id="view_Notas"><span>Notes-&gt; </span></a></li>
					<li ><a class="" id="view_Report"><span>Daily Report-&gt; </span></a></li>								 						
				</ul> 
			</div>
		</td>
	</tr>
	<tr>
		<td>		
			<div id="dropInfo1" class="dropcontent" style="display:none">	
				<fieldset></fieldset>
					<legend></legend>
						<div id="Div_Registro"></div>	
				</fieldset>		
			</div>
			<div id="dropInfo2" class="dropcontent" style="display:none">
				<fieldset>
					<legend></legend>  
					<div id="Div_Reporte" style="overflow:scroll; height:400"></div>
				</fieldset>		      
			</div>	
		</td>
	</tr>
</table>
<img src="images/spacer.gif" onload="makeactive(1,<?php echo $Reg_ID; ?>,<?php echo $Actividad_ID; ?>,<?php echo $Pro_ID; ?>)" />
