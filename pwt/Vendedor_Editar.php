<?php	 		
	session_name("Administrador");
	session_start();		
	if ($_SESSION["EntityID"] == "")
	{
		header("Location:sessionexpired.php"); 	
	}	 			
	require('Library/Control_Cache.php');
	require('Library/Open_Conexion.php');
	
	$Ven_ID=$_GET['Ven_ID'];	
	
	$consulta = "SELECT * FROM vendedor WHERE Ven_ID=".$_GET['Ven_ID'];		
	//echo $consulta."<br>";
	$contador=1;	 	  	 	  	  

	$result2=$bd->ejecutar($consulta); 	
	while (($row2 = mysqli_fetch_array($result2) ))							
	{		
		$Emp_ID = $row2["Emp_ID"];
		$Codigo = $row2["Codigo"];	
		$Nombre = $row2["Nombre"];
		$Estado = $row2["Estado"];	
		$Ciudad = $row2["Ciudad"];
		$Zip_Code = $row2["Zip_Code"];			
		$Calle = $row2["Calle"];
		$Numero=$row2["Numero"];
		$Gerente_General=$row2["Gerente_General"];
		$Telefono=$row2["Telefono"];
		$Fax=$row2["Fax"];
		$Web=$row2["Web"];
		$email=$row2["email"];
		$Rubro=$row2["Rubro"];
		$Detalles=$row2["Detalles"];	
	}
	mysqli_free_result($result2);			
?> 
    <form id="Form_Vendedor_Editar" name="Form_Vendedor_Editar">
    <table>
    	<tr>
        	<td width="500">             
				<fieldset>
					<legend>Vendor Info</legend>
					<table  cellpadding="2" cellspacing="2">
						<tr>
							<td width="250"><strong>Code:</strong></td>
							<td ><input name="Codigo" type="text" id="Codigo" size="16" value="<?php echo $Codigo; ?>"/><label for="Codigo" generated="true" class="error"></label>
							<input name="Ven_ID" type="hidden" id="Ven_ID" size="16" value="<?php echo $Ven_ID; ?>"/>
							</td>
						</tr>
						<tr>
							<td><strong>Name:</strong></td>
						    <td ><input name="Nombre" type="text" id="Nombre" size="50" value="<?php echo $Nombre; ?>"/><label for="Nombre" generated="true" class="error"></label></td>
						</tr>
						<tr>							
							<td><strong>General Manager</strong>:</td>
							<td><input name="Gerente_General" type="text" id="Gerente_General" size="50" value="<?php echo $Gerente_General; ?>"/></td>
					  	</tr>
						<tr>
							<td ><strong>Street:</strong></td>
							<td><input name="Calle" type="text" id="Calle" size="50" value="<?php echo $Calle; ?>"/>
								<input name="Numero" type="hidden" id="Numero"/>
							</td>
						</tr>	
						<tr>
							<td ><strong>City:</strong></td>
							<td>
								 <input name="Ciudad" type="text" id="Ciudad" value="<?php echo $Ciudad; ?>"/>
								 <strong>State:</strong>
								 <input type="text" id="Estado" name="Estado" size="15" value="<?php echo $Estado; ?>"/> 
								 <strong>Zip Code: </strong>
								 <input name="Zip_Code" type="text" id="Zip_Code" size="15" value="<?php echo $Zip_Code; ?>"/>
							</td>
						</tr>												
						<tr>
							<td ><strong>Phone:</strong></td>
						    <td><input name="Telefono" type="text" id="Telefono" size="15" value="<?php echo $Telefono; ?>"/>
								<strong>Fax:</strong> 
							  <input name="Fax" type="text" id="Fax" size="15" value="<?php echo $Fax; ?>"/> 
								<strong>Web Site:								</strong>
								<input name="Web" type="text" id="Web" size="20" value="<?php echo $Web; ?>"/>
								<strong>email:</strong> 
							  <input name="email" type="text" id="email" size="20" value="<?php echo $email; ?>"/>
							  <label for="email" generated="true" class="error"></label>
							</td>
						</tr>	
						<tr>
							<td ><strong>Industry:</strong></td>
							<td><input name="Rubro" type="text" id="Rubro" size="50" value="<?php echo $Rubro; ?>"/></td>
						</tr>						
						<tr>
							<td ><strong>Details:</strong></td>
							<td><textarea  id="Detalles" name="Detalles" value="" rows="1" cols="96"><?php echo $Detalles; ?></textarea></td>
						</tr>	
					</table>
				</fieldset>
				
        	</td>                             
        </tr>
		<tr>
			<td valign="top">                                            
				<div style="display:block" id="div_res_new_vendedor">
					<INPUT  id="Bnt_Vendedor_Nuevo"  name="Bnt_Vendedor_Nuevo" type="button" value="Save" >
                </div>                                  					
           	</td>       
		</tr>
	</table>
</form>
<img src='images/spacer.gif' onload='Iniciar_Validacion_Vendedor_Editar();' />
<?php
	require('Library/Close_Conexion.php');
?>
