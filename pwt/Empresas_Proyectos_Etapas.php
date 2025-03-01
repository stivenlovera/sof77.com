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
				
	$Pro_ID = $_GET['Pro_ID'];
	$Fecha_Inicio=$_GET['Fecha_Inicio'];
	$Fecha_Inicio=$_GET['Fecha_Inicio'];
	$Fecha_Fin=$_GET['$Fecha_Fin'];
	$Total_Horas=$_GET['Total_Horas'];
	$Horas=$Total_Horas;
		
	?>
	<fieldset id="Fs_Lista_Cliente" class="" >
		<legend></legend>
		<legend>List of Stages:
		                                                                                                                      </legend><form action="#" id="form_etapas_nuevo" name="form_etapas_nuevo">
		                                                                                                                        <table  width="100%" cellpadding="2" cellspacing="2">
			 <tr>
				  <td align="left" valign="top">											
						<p>Name=Ini (Auto generate 3 stages)Name=Add (to add stage) Name=No SDate (no Start date) Name=No EDate (no End Date) <b>Note:</b>
                          <input type="text" id="Note" name="Note" value="" size="30" />
						</p>
<b>Name</b> 
				    <input type="text" id="Nombre" name="Nombre" value="" size="20" />				    <!--<b>Effort %</b> 
						<input type="text"  name="Porcentaje_Esfuerzo" id="Porcentaje_Esfuerzo" value="" size="4"/> -->						
				    <b>Total Hours of job:</b> 
				    <input name="Horas" type="text" id="Horas" class="hota_total" value="" size="10" />								
				    <b>Star Date:</b> 
				    <input  type="text" id="Fecha_Inicio_Etapa" name="Fecha_Inicio_Etapa" value="" size="10"  datepicker="true" datepicker_format="MM-DD-YYYY" />				    <img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Inicio_Etapa"));' /> 
						  
				    <b>End Date:</b> 
				    <input  type="text" id="Fecha_Fin_Etapa" name="Fecha_Fin_Etapa" value="" size="10"  datepicker="true" datepicker_format="MM-DD-YYYY"/>
				    <img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Fin_Etapa"));' /> 						
				    <input name="Etapas_ID" type="hidden" id="Etapas_ID" value=""/>
				    <input name="Pro_ID" type="hidden" id="Pro_ID" value="<?php echo $Pro_ID; ?>" size="4" />	
				    <span id="span_bnt_New">
				      <INPUT id="button" type="button" value="Generate/Update Stages/Add" name="button" onClick="Empresas_Proyectos_Etapas_Registrar();">   					
			        </span>
						<table width="1186" cellpadding="0" cellspacing="0">
						  <col width="200" />
						  <tr>
						    <td width="299">Stages:1st. 20 % days= 10% hours / 2nd. 60% days=80% hours / 3rd.20% days=10% hours</td>
					      </tr>
		     </table></tr>					
			</table>						
		</form>	
		<div id="Div_Empresas_Proyectos_Etapas_Lista">
		</div>	
	</fieldset>
<?php
	echo "<img src='images/spacer.gif' onload='Empresas_Proyectos_Etapas_Lista($Pro_ID);' />"; 		
	require('Library/Close_Conexion.php');
?>