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
	
	$Fecha=$_GET['Fecha'];	
	$Pro_ID=$_GET['Pro_ID'];	
	
	$sql = "SELECT Codigo, Nombre FROM proyectos WHERE Pro_ID=".$Pro_ID;
	//echo $sql;														
	$result=$bd->ejecutar($sql); 		 
	while (($row = mysqli_fetch_array($result) ))							
	{								
		$Nombre=$row["Nombre"];
		$Codigo=$row["Codigo"];
	}
	mysqli_free_result($result);				
?> 
<form id="Form_Actividad_Nueva" name="Form_Actividad_Nueva">
    <table width="100%">
    	<tr>
        	<td width="100%">             
				<fieldset>
					<legend><strong>New Activity : <?php echo $Nombre."-".$Codigo."-".FormatDateTime($Fecha, 6);?></strong></legend>
					<table  cellpadding="2" cellspacing="2" width="100%">
						<tr>
							<td ><b>Date:</b></td>
							<td><input type="text" name="Fecha_Actividad" id="Fecha_Actividad" size="12" datepicker="true" datepicker_format="MM-DD-YYYY" value="<?php echo FormatDateTime($Fecha, 6);?>" />
								<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Actividad"));' />					     
								<b>Hour:</b><input type="text" name="Hora" id="Hora" size="12"/>						     
							   	<b>Type:</b> <?php
									$sql = "select Tipo_Actividad_ID, Actividad_Nombre FROM tipo_actividad order by Actividad_Nombre";														
									$result=$bd->ejecutar($sql); 		 
								?>
									<select size="1" name="Tipo_Actividad_ID" id="Tipo_Actividad_ID"  class="cuadro">      
										<option  value="">--Select Type--</option>
								<?php		
										while (($row = mysqli_fetch_array($result) ))							
										{								
								?>
											<option value="<?php echo  $row["Tipo_Actividad_ID"];?>" ><?php echo $row["Actividad_Nombre"];?></option>
								<?php
										}
										mysqli_free_result($result);	
								?>
									</select>
								
							</td>
						</tr>	
						<tr>
							<td width="82"><b>Description</b></td>
						  	<td >
									<textarea id="Descripcion" name="Descripcion" cols="80" rows="4"></textarea>														
							</td>
						</tr>						
						<tr>
							<td ><b>Aux 1:</b></td>
							<td><input name="Aux1" id="Aux1" type="text" size="20"/> 
							&nbsp;&nbsp;						     
							   	<b>Aux 2:</b><input name="Aux2" id="Aux2" type="text" size="20"/>
							   	&nbsp;&nbsp;						     
								<b>Aux 3:</b><input name="Aux3" id="Aux3" type="text" size="20"/>	
								<input name="Pro_ID" id="Pro_ID" type="hidden" value="<?php echo $Pro_ID; ?>" size="20"/>	
								<input type="hidden" id="Actividad_ID" name="Actividad_ID" value="" />					     
							</td>
						</tr>													
						
					</table>
				</fieldset>
				
        	</td>                             
        </tr>
		<tr>
			<td valign="top">                                            
				<div style="display:block" id="div_res_nueva_actividad">						
                </div>
				<span>
					<INPUT id="button" type="button" value="New" name="button" onClick="Actividad_Nueva_Registrar();">   					
				</span> 
				<span id="span_bnt_save" style="display:none">
					<INPUT id="button" type="button" value="Save" name="button" onClick="Actividades_Editar_Guardar();">   
					<INPUT id="button" type="button" value="Cancel" name="button" onClick="Actividades_Editar_Cancelar();"> 					
				</span>
           	</td>       
		</tr>		
	</table>
</form>
	<table>
		<tr>
			<td>
				<div id="Div_Actividades_Lista" name="Div_Actividades_Lista" >					
				</div>
			</td>
		</tr>
	</table>
      <?php
	echo "<img src='images/spacer.gif' onload='Actividades_Lista(\"$Fecha\", $Pro_ID);' />"; 
	require('Library/Close_Conexion.php');
?>