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
	$Mat_ID=$_GET['Mat_ID'];	
	
	$consulta = "SELECT m.*, c.Nombre Categoria, v.Nombre as Vendedor FROM materiales m";
	$consulta = $consulta . " INNER JOIN categoria_material c ON m.Cat_ID=c.Cat_ID  ";	
	$consulta = $consulta . " INNER JOIN vendedor v ON v.Ven_ID=m.Ven_ID ";	
	$consulta = $consulta . " WHERE m.Mat_ID=".$Mat_ID;		
	$consulta = $consulta . " ORDER BY m.Denominacion";		
	//echo $consulta."<br>";
	$contador=1;	 	  	 	  	  

	$result2=$bd->ejecutar($consulta); 	
	while (($row2 = mysqli_fetch_array($result2) ))							
	{		
		$Mat_ID = $row2["Mat_ID"];
		$Denominacion = $row2["Denominacion"];
		$Nombre_Generico=$row2["Nombre_Generico"];
		$Area_donde_va=$row2["Area_donde_va"];
		$Unidad_Medida = $row2["Unidad_Medida"];	
		$Cantidad = $row2["Cantidad"];
		$Precio_Unitario = $row2["Precio_Unitario"];					
		$Aux1 = $row2["Aux1"];			
		$Aux2 = $row2["Aux2"];
		$Aux3=$row2["Aux3"];
						
		$Cat_ID=$row2["Cat_ID"];
		$Ven_ID=$row2["Ven_ID"];
		
		$Fecha_Registro=$row2["Fecha_Registro"];
		$Fecha_Envio=$row2["Fecha_Envio"];
		$Fecha_Recibido=$row2["Fecha_Recibido"];

		$Fecha_from_vendor=$row2["Fecha_from_vendor"];
		$Fecha_to_vendor=$row2["Fecha_to_vendor"];
		$note_vendor=$row2["note_vendor"];

		$Fecha_from_gc=$row2["Fecha_from_gc"];
		$Fecha_to_gc=$row2["Fecha_to_gc"];
		$note_gc=$row2["note_gc"];
		
		if ( !(is_null($Fecha_Registro)) )		
			$Fecha_Registro=FormatDateTime($Fecha_Registro, 6);
		else
			$Fecha_Registro="";
		
		if ( !(is_null($Fecha_Envio)) )		
			$Fecha_Envio=FormatDateTime($Fecha_Envio, 6);
		else
			$Fecha_Envio="";
			
		if ( !(is_null($Fecha_Recibido)) )		
			$Fecha_Recibido=FormatDateTime($Fecha_Recibido, 6);
		else
			$Fecha_Recibido="";	
			
		if ( !(is_null($Fecha_from_vendor)) )		
			$Fecha_from_vendor=FormatDateTime($Fecha_from_vendor, 6);
		else
			$Fecha_from_vendor="";
		
		if ( !(is_null($Fecha_to_vendor)) )		
			$Fecha_to_vendor=FormatDateTime($Fecha_to_vendor, 6);
		else
			$Fecha_to_vendor="";
		
		if ( !(is_null($Fecha_from_gc)) )		
			$Fecha_from_gc=FormatDateTime($Fecha_from_gc, 6);
		else
			$Fecha_from_gc="";

		if ( !(is_null($Fecha_to_gc)) )		
			$Fecha_to_gc=FormatDateTime($Fecha_to_gc, 6);
		else
			$Fecha_to_gc="";
	}
	mysqli_free_result($result2);				
?> 
    <form action="#" id="Form_Proyectos_Materiales_Editar" name="Form_Proyectos_Materiales_Editar">
    <table width="100%">
    	<tr>
        	<td width="100%">             
				<fieldset>
					<legend><strong>Submittals Info</strong></legend>
					<table  cellpadding="2" cellspacing="2" width="100%">
						<tr>
							<td width="150"><strong>Denomination</strong>:</td>
					  	    <td  >
								<input name="Denominacion" type="text" id="Denominacion" size="40" value="<?php echo $Denominacion;?>"/>
								<label for="Denominacion" generated="true" class="error"></label>
							</td>
						</tr>						
						<tr>
							<td ><strong>Note</strong>:</td>
							<td><input type="text" id="Nombre_Generico" name="Nombre_Generico" size="40"  value="<?php echo $Nombre_Generico;?>"/></td>
						</tr>													
						<tr>
							<td><strong>Apply to :</strong></td>
						    <td >
								<input name="Area_donde_va" type="text" id="Area_donde_va" size="20"  value="<?php echo $Area_donde_va;?>"/>
							</td>
						</tr>
						<tr>
							<td><strong>Unit gl/yd/lf/lb .....:</strong></td>
						    <td >
								<input name="Unidad_Medida" type="text" id="Unidad_Medida" size="10" value="<?php echo $Unidad_Medida;?>"/>
								<label for="Unidad_Medida" generated="true" class="error"></label>
								&nbsp;&nbsp;
								<strong>Quantity:</strong>
								<input name="Cantidad" type="text" id="Cantidad" size="10" value="<?php echo $Cantidad;?>"/>&nbsp;&nbsp;<strong>Unit Price:</strong>
								<input name="Precio_Unitario" type="text" id="Precio_Unitario" size="10" value="<?php echo $Precio_Unitario;?>"/>&nbsp;&nbsp;

							</td>
						</tr>	
						<tr>							
							<td colspan="2"><strong>Status: </strong>
							  <?php
									$sql = "select Cat_ID, Nombre FROM categoria_material order by Nombre";														
									$result=$bd->ejecutar($sql); 		 
								?>
									<select size="1" name="Cat_ID" id="Cat_ID"  class="cuadro">      
										<option  value="">--Select Staus--</option>
								<?php		
										while (($row = mysqli_fetch_array($result) ))							
										{								
								?>
											<option value="<?php echo  $row["Cat_ID"];?>"><?php echo $row["Nombre"];?></option>
								<?php
										}
										mysqli_free_result($result);	
								?>
									</select><label for="Cat_ID" generated="true" class="error"></label>
									<strong>Vendor:</strong>
									<?php
									$sql = "select Ven_ID, Nombre FROM vendedor order by Nombre";														
									$result=$bd->ejecutar($sql); 		 
								?>
									<select size="1" name="Ven_ID" id="Ven_ID"  class="cuadro">      
										<option  value="">--Select Type--</option>
								<?php		
										while (($row = mysqli_fetch_array($result) ))							
										{								
								?>
											<option value="<?php echo  $row["Ven_ID"];?>"><?php echo $row["Nombre"];?></option>
								<?php
										}
										mysqli_free_result($result);	
								?>
									</select> <label for="Ven_ID" generated="true" class="error"></label>
									<input name="Pro_ID" type="hidden" id="Pro_ID" value="<?php echo $Pro_ID; ?>"/>
									<input name="Mat_ID" type="hidden" id="Mat_ID" value="<?php echo $Mat_ID; ?>"/>
									<img src="images/spacer.gif" height="1" width="1" onload="$('#Cat_ID').val(<?php echo $Cat_ID;?>)" />
									<img src="images/spacer.gif" height="1" width="1" onload="$('#Ven_ID').val(<?php echo $Ven_ID;?>)" />
						  </td>
				  	    </tr>
						<tr>
							<td><strong>Enter date:</strong></td>
						    <td >
								<input name="Fecha_Registro" type="text" id="Fecha_Registro" size="10" value="<?php echo $Fecha_Registro; ?>" datepicker="true" datepicker_format="MM-DD-YYYY" />
								<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Registro"));' />&nbsp;&nbsp;<strong>Send Date:</strong>
								<input name="Fecha_Envio" type="text" id="Fecha_Envio" size="10" value="<?php echo $Fecha_Envio; ?>" datepicker="true" datepicker_format="MM-DD-YYYY" />
								<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Envio"));' />&nbsp;&nbsp;<strong>Return date:</strong>
								<input name="Fecha_Recibido" type="text" id="Fecha_Recibido" size="10" value="<?php echo $Fecha_Recibido; ?>" datepicker="true" datepicker_format="MM-DD-YYYY" />
								<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Recibido"));' />&nbsp;&nbsp;

							</td>
						</tr>						
						<tr>
							<td><strong>Aux1:</strong></td>
						    <td >
								<input name="Aux1" type="text" id="Aux1" size="50"  value="<?php echo $Aux1;?>"/>
							</td>
						</tr>
						<tr>
							<td><strong>Aux2:</strong></td>
						    <td >
								<input name="Aux2" type="text" id="Aux2" size="50"  value="<?php echo $Aux2;?>"/>
							</td>
						</tr>
						<tr>
							<td><strong>Aux3:</strong></td>
						    <td >
								<input name="Aux3" type="text" id="Aux3" size="50"  value="<?php echo $Aux3;?>"/>
							</td>
						</tr>																	
					</table>
					<table>
						<tbody>
							<tr>
								<td colspan="7"><hr></td>
							</tr>
							<tr>
								<td>
									<strong>Sent to the vendor:</strong>
								</td>
								<td>
                                <input name="Fecha_to_vendor" type="text" id="Fecha_to_vendor" size="10" value="<?php echo $Fecha_to_vendor;?>" datepicker="true" datepicker_format="MM-DD-YYYY" />
									
									<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_from_vendor"));' />
								</td>
								<td>
									<strong>Return from vendor:</strong>
								</td>
								<td>
                                <input name="Fecha_from_vendor" type="text" id="Fecha_from_vendor" size="10" value="<?php echo $Fecha_from_vendor;?>" datepicker="true" datepicker_format="MM-DD-YYYY" />
									
									<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_to_vendor"));' />
								</td>
								<td>
									<strong>Note Vendor:</strong>
								</td>
								<td colspan="2">
									<input  type="text" id="note_vendor" name="note_vendor" size="15" value="<?php echo $note_vendor;?>" />
								</td>
							</tr>
							<tr>
								<td>
									<strong>Sent to GC:</strong>
								</td>
								<td>
									<input name="Fecha_to_gc" type="text" id="Fecha_to_gc" size="10" value="<?php echo $Fecha_from_gc;?>" datepicker="true" datepicker_format="MM-DD-YYYY" />
									<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_from_gc"));' />
								</td>
								<td>
									<strong>Return from GC:</strong>
								</td>
								<td>
                                <input name="Fecha_from_gc" type="text" id="Fecha_from_gc" size="10" value="<?php echo $Fecha_from_gc;?>" datepicker="true" datepicker_format="MM-DD-YYYY" />
									
									<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_to_gc"));' />
								</td>
								<td>
									<strong>Note GC:</strong>
								</td>
								<td colspan="2">
									<input  type="text" id="note_gc" name="note_gc" size="15" value="<?php echo $note_gc;?>" />
								</td>
							</tr>
						</tbody>
					</table>
				</fieldset>
				
        	</td>                             
        </tr>
		<tr>
			<td valign="top"> 
				<div style="display:block" id="div_res_new_material">                                           
					<INPUT id="Bnt_Proyecto_Material_Editar" type="button" value="Save" name="Bnt_Proyecto_Material_Editar" >                
				</div>                  															
           	</td>       
		</tr>		
	</table>
</form>	
<img src='images/spacer.gif' onload='Iniciar_Validacion_Proyecto_Material_Editar();' />
<?php
	require('Library/Close_Conexion.php');
?>