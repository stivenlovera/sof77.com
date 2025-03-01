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
	
	$Pro_ID=$_GET['Pro_ID'];	
	$Area_ID=$_GET['Area_ID'];	
	
	$consulta = "SELECT * FROM area_control WHERE Area_ID=".$Area_ID;		

	//echo $consulta."<br>";
	$contador=1;	 	  	 	  	  

	$result2=$bd->ejecutar($consulta); 	
	while (($row2 = mysqli_fetch_array($result2) ))							
	{		
		$Nombre = $row2["Nombre"];
		$Note = $row2["Note"];
		$Aux1 = $row2["Aux1"];
		$Aux2 = $row2["Aux2"];
		$Aux3 = $row2["Aux3"];		
	}
	mysqli_free_result($result2);				
?> 
   <form action="#" id="Form_Proyectos_Area_Editar" name="Form_Proyectos_Area_Editar">
    <table width="100%">
    	<tr>
        	<td width="100%">             
				<fieldset>
					<legend><strong>Area Info</strong></legend>
					<table  cellpadding="2" cellspacing="2" width="100%">
						<tr>
							<td width="150"><strong>Name:</strong></td>
					  	    <td  >
							<input name="Nombre" type="text" id="Nombre" size="40" value="<?php echo $Nombre; ?>"/></td>
						</tr>						
						<tr>
							<td ><strong>Note:</strong></td>
							<td><input type="text" id="Note" name="Note" size="40" value="<?php echo $Note; ?>"/></td>
						</tr>																			
						<tr>
							<td><strong>Aux1:</strong></td>
						    <td >
								<input name="Aux1" type="text" id="Aux1" size="50" value="<?php echo $Aux1; ?>"/>
							</td>
						</tr>
						<tr>
							<td><strong>Aux2:</strong></td>
						    <td >
								<input name="Aux2" type="text" id="Aux2" size="50" value="<?php echo $Aux2; ?>"/>
							</td>
						</tr>
						<tr>
							<td><strong>Aux3:</strong></td>
						    <td >
								<input name="Aux3" type="text" id="Aux3" size="50" value="<?php echo $Aux3; ?>"/>
								<input name="Pro_ID" type="hidden" id="Pro_ID" value="<?php echo $Pro_ID; ?>"/>
								<input name="Area_ID" type="hidden" id="Pro_ID" value="<?php echo $Area_ID; ?>"/>
							</td>
						</tr>											
					</table>
				</fieldset>
				
        	</td>                             
        </tr>
		<tr>
			<td valign="top">                                            
				<div style="display:block" id="div_res_new_area">
					<INPUT id="button" type="button" value="Save" name="button" onClick="Proyectos_Area_Editar_Registrar();">                
				</div>				
           	</td>       
		</tr>		
	</table>
</form>	
<?php
	require('Library/Close_Conexion.php');
?>