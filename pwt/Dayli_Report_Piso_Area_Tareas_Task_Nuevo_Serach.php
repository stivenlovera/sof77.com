<?php	 		
	session_name("Administrador");
	session_start();		
	if ($_SESSION["EntityID"] === "")
	{
		header("Location:sessionexpired.php"); 	
	}	 			
	require('Library/Control_Cache.php');
	require('Library/Open_Conexion.php');		
	
	$Task_ID=$_GET['Task_ID'];	
	$Actividad_ID=$_GET['Actividad_ID'];
	$Nro_act=$_GET['Nro_act'];
	echo $Nro_act."_".$Task_ID."_".$Actividad_ID."<br>";	
?>     


    <table>
    	<tr>        	                             			        	
			<td width="500" valign="top">             
				<fieldset id="fs_Tarea">
					<legend>Dealy Report Level 3 or Task Info (New Record)</legend>
					<form id="FORM_Dayli_Report_Piso_Area_Tareas_Task_Nuevo" name="FORM_Dayli_Report_Piso_Area_Tareas_Task_Nuevo">
						<table width="842"  cellpadding="2" cellspacing="2">
<tr>
								<td width="161"><strong>Hours Worked:</strong></td>
<td width="465" ><input name="Horas" type="text" id="Horas" size="12" /> 
							  	Material Used:
							      <input name="MatUse" type="text" id="MatUse" size="12" /> 
							      %Completed at today:
				  	              <input name="PerCom" type="text" id="PerCom" size="12" />
</tr>
							<tr>
								<td><strong>Notes:</strong></td>
								<td ><input name="Nota_Horas" type="text" id="Nota_Horas" size="70"/></td>
							</tr>
							<!--<tr>							
								<td><strong>%</strong>:</td>
								<td>
									<input name="Porcentaje" type="text" id="Porcentaje"/>							
								</td>
							</tr>
							<tr>
								<td ><strong>Note %:</strong></td>
								<td>
									<input name="Nota_Porcentaje" type="text" id="Nota_Porcentaje"/>							
								</td>
							</tr>-->
							<tr>							
								<td><strong>Number Units Done:</strong>:</td>
								<td>
									<input name="Numero" type="text" id="Numero"/>							
								</td>
							</tr>
							<!--<tr>
								<td ><strong>Note Number:</strong></td>
								<td>
									<input name="Nota_Numero" type="text" id="Nota_Numero"/>							
								</td>
							</tr>			
							<tr>
								<td ><strong>Aux1:</strong></td>
								<td>
									 <input name="Aux1" type="text" id="Aux1"/>
								</td>
							</tr>												
							<tr>
								<td ><strong>Aux1_Nota:</strong></td>
								<td>
									<input name="Aux1_Nota" type="text" id="Aux1_Nota"/>
								</td>
							</tr>	
							<tr>
								<td ><strong>Aux2:</strong></td>
								<td><input name="Aux2" type="text" id="Aux2"/></td>
							</tr>
							<tr>
								<td ><strong>Aux2_Nota:</strong></td>
								<td><input name="Aux2_Nota" type="text" id="Aux2_Nota"/></td>
							</tr>
							<tr>
								<td ><strong>Aux3:</strong></td>
								<td><input name="Aux3" type="text" id="Aux3"/></td>
							</tr>-->
							<tr>
								<td ><strong>Aux_Notes:</strong></td>
								<td>
									<input name="Aux3_Nota" type="text" id="Aux3_Nota"/>
									<input name="Task_ID" type="hidden" id="Task_ID" value="<?php echo $Task_ID;?>"/>
									<input name="Actividad_ID" type="hidden" id="Area_ID" value="<?php echo $Actividad_ID;?>"/>
                                    <input name="NumAct" type="hidden" id="NumAct" value="<?php echo $NumAct;?>"/>
								</td>
							</tr>												
						</table>
					  <INPUT  id="Bnt_Dayli_Report_Nuevo"  name="Bnt_Dayli_Report_Nuevo" type="button" value="Add" onclick="Dayli_Report_Piso_Area_Tareas_Task_Nuevo_Registrar();" >									       
					</form>
					<div style="display:block" id="Div_Dayli_Report_Piso_Area_Tareas_Task_Nuevo_res">				
					</div>					
				</fieldset>				
        	</td>                             
        </tr>
	</table>
<?php
	require('Library/Close_Conexion.php');
?>
