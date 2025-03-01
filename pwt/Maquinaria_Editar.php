<?php	 		
	session_name("Administrador");
	session_start();		
	if ($_SESSION["EntityID"] == "")
	{
		header("Location:sessionexpired.php"); 	
	}	 			
	require('Library/Control_Cache.php');
	require('Library/Open_Conexion.php');
	
	$Maq_ID=$_GET['Maq_ID'];	 				       
	  					  
	$consulta = "SELECT * FROM maquinarias WHERE Maq_ID=".$Maq_ID; 
	//echo $consulta;  	
	$result2=$bd->ejecutar($consulta); 	
	while (($row2 = mysqli_fetch_array($result2) ))							
	{		
		$Maq_ID = $row2["Maq_ID"];
		$Nombre = $row2["Nombre"];
		$Note=$row2["Note"];	
		$Aux1=$row2["Aux1"];		
		$Aux2=$row2["Aux2"];			
		$Aux3 = $row2["Aux3"];	
		$Activo = $row2["Activo"];
		
		$Estado_Activo="";
		$Estado_InActivo="";
		
		if ($Activo)
			$Estado_Activo="checked='checked'";
		else
			$Estado_InActivo="checked='checked'";
	}
	mysqli_free_result($result2);				
?> 
    <form id="Form_Maquinaria_Editar" name="Form_Maquinaria_Editar">
    <table>
    	<tr>
        	<td width="500">             
				<fieldset>
					<legend>Company Info</legend>
					<table  cellpadding="2" cellspacing="2">
						<tr>
							<td width="250"><strong>Name:</strong></td>
							<td ><input name="Nombre" type="text" id="Nombre" size="16" value="<?php echo $Nombre; ?>"/><label for="Nombre" generated="true" class="error"></label></td>
						</tr>
						<tr>
							<td><strong>Note:</strong></td>
						    <td ><input name="Note" type="text" id="Note" size="50" value="<?php echo $Note; ?>"/></td>
						</tr>
						<tr>							
							<td><strong>Aux 1:</strong>:</td>
							<td><input name="Aux1" type="text" id="Aux1" size="50" value="<?php echo $Aux1; ?>"/></td>
					  	</tr>
						<tr>
							<td ><strong>Aux 2:</strong></td>
							<td><input name="Aux2" type="text" id="Aux2" size="50" value="<?php echo $Aux2; ?>"/></td>
						</tr>	
						<tr>
							<td ><strong>Aux 3:</strong></td>
							<td>
								<input name="Aux3" type="text" id="Aux3"  size="50" value="<?php echo $Aux3; ?>"/>
								<input name="Maq_ID" type="Hidden" id="Maq_ID"  size="50" value="<?php echo $Maq_ID; ?>"/>
							</td>
						</tr>	
						<tr>
							<td ><strong>State:</strong></td>
							<td>
								Active <input type="radio" name="Estado_Radio" id="Estado_Radio" <?php echo $Estado_Activo; ?> value="1" /> 
								In Active <input type="radio" name="Estado_Radio" id="Estado_Radio" <?php echo $Estado_InActivo; ?> value="0" /> 
							</td>
						</tr>												
					</table>
				</fieldset>			
        	</td>                             
        </tr>
		<tr>
			<td valign="top">                                            
				<div style="display:block" id="div_res_new_maquinaria">
					<INPUT  id="Bnt_Maquinaria_Editar"  name="Bnt_Maquinaria_Editar" type="button" value="Add" >
                </div>                                  					
           	</td>       
		</tr>
	</table>
</form>
<img src='images/spacer.gif' onload='iniciar_validacion_maquinaria_editar();' />
<?php
	require('Library/Close_Conexion.php');
?>
