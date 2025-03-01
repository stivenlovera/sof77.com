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

	$Nombre = $_SESSION["Nombre"];
	$Pro_ID = $_GET["Pro_ID"];
	$Informe_ID = $_GET["Informe_ID"];
	
	$consulta = "SELECT * FROM personal WHERE Empleado_ID=".$_SESSION["Empleado_ID"];	
	$result2=$bd->ejecutar($consulta); 	
	while (($row2 = mysqli_fetch_array($result2) ))							
	{		
		$Empleado = $row2["Nombre"]." ".$row2["Apellido_Paterno"]." ".$row2["Apellido_Materno"];
	}
	mysqli_free_result($result2);
	
	if ($Informe_ID=="")
	{
		$consulta = "SELECT *, p.Nombre as Proyecto, CONCAT(em.Nombre, ' ', em.Apellido_Paterno, ' ',  em.Apellido_Materno) AS Empleado FROM informe_proyecto i INNER JOIN proyectos p ON i.Pro_ID=p.Pro_ID ";
		$consulta = $consulta . " INNER JOIN personal em ON em.Empleado_ID=i.Empleado_ID ";	
		$consulta = $consulta." WHERE i.Pro_ID=".$Pro_ID." ORDER BY Informe_ID DESC";	
	}
	else
	{
		$consulta = "SELECT *, p.Nombre as Proyecto, CONCAT(em.Nombre, ' ', em.Apellido_Paterno, ' ',  em.Apellido_Materno) AS Empleado FROM informe_proyecto i INNER JOIN proyectos p ON i.Pro_ID=p.Pro_ID ";
		$consulta = $consulta . " INNER JOIN personal em ON em.Empleado_ID=i.Empleado_ID ";	
		$consulta = $consulta." WHERE i.Informe_ID=".$Informe_ID;	
	}
	
	//echo $consulta."<br>";
	$contador=1;	 	  	 	  	  

	$result2=$bd->ejecutar($consulta); 	
	if (($row2 = mysqli_fetch_array($result2) ))							
	{		
		$Nombre = $row2["Proyecto"];		
		$Fecha = FormatDateTime($row2["Fecha"], 6);
		$Check_status = $row2["Check_status"];
		if ($Check_status)	$Check_status ="checked";
		
		$Check_coming = $row2["Check_coming"];
		if ($Check_coming)	$Check_coming ="checked";			
		$Date_Check_coming = FormatDateTime($row2["Date_Check_coming"], 6);
		
		$Check_framing = $row2["Check_framing"];
		if ($Check_framing)	$Check_framing ="checked";		
		$Date_Check_framing = FormatDateTime($row2["Date_Check_framing"], 6);
		
		$Check_hanging=$row2["Check_hanging"];
		if ($Check_hanging)	$Check_hanging ="checked";		
		$Date_Check_hanging=FormatDateTime($row2["Date_Check_hanging"], 6);
		
		$Check_construction=$row2["Check_construction"];
		if ($Check_construction)	$Check_construction ="checked";
		
		$Check_hidden=$row2["Check_hidden"];
		if ($Check_hidden)	$Check_hidden ="checked";
		
		$hidden_yes_no=$row2["hidden_yes_no"];		
		switch ($hidden_yes_no) {
			case "No":
				$estado_yes_no_1="checked";
				$estado_yes_no_2="";				
				break;
			case "Yes":
				$estado_yes_no_1="";
				$estado_yes_no_2="checked";				
				break;			
		}
		
		$others=$row2["others"];
		$Check_we_can=$row2["Check_we_can"];
		if ($Check_we_can)	$Check_we_can ="checked";
		
		$Date_estimate=FormatDateTime($row2["Date_estimate"], 6);
		$Date_actual=FormatDateTime($row2["Date_actual"], 6);
		$DAte_finally=FormatDateTime($row2["DAte_finally"], 6);
		
		$Check_quality=$row2["Check_quality"];
		if ($Check_quality)	$Check_quality ="checked";
		
		$text_Check_quality=$row2["text_Check_quality"];
		$Check_discuse=$row2["Check_discuse"];
		if ($Check_discuse)	$Check_discuse ="checked";
		
		$text_Check_discuse=$row2["text_Check_discuse"];
		$Check_control=$row2["Check_control"];
		if ($Check_control)	$Check_control ="checked";
		
		$text_Check_control=$row2["text_Check_control"];
		$pwt_actual=$row2["pwt_actual"];
		$pwt_quality=$row2["pwt_quality"];
		$pwt_production_rate=$row2["pwt_production_rate"];
		switch ($pwt_production_rate) {
			case "Excelent":
				$estado_rate_1="checked";
				$estado_rate_2="";	
				$estado_rate_3="";	
				$estado_rate_4="";	
				break;
			case "Good":
				$estado_rate_1="";
				$estado_rate_2="checked";	
				$estado_rate_3="";	
				$estado_rate_4="";
				break;
			case "Regular":
				$estado_rate_1="";
				$estado_rate_2="";	
				$estado_rate_3="checked";	
				$estado_rate_4="";
				break;
			case "Poor":
				$estado_rate_1="";
				$estado_rate_2="";	
				$estado_rate_3="";	
				$estado_rate_4="checked";
				break;
		}		
		
		$pwt_painters=$row2["pwt_painters"];
		$pwt_apprentices=$row2["pwt_apprentices"];
		$pwt_comments=$row2["pwt_comments"];
		$pwt_action=$row2["pwt_action"];
		$pwt_miscellaneous=$row2["pwt_miscellaneous"];
		$gc=$row2["gc"];
		$gc_action=$row2["gc_action"];
		$quality=$row2["quality"];
		switch ($quality) {
			case "Drywall":
				$estado_quality_1="checked";
				$estado_quality_2="";	
				$estado_quality_3="";	
				$estado_quality_4="";	
				break;
			case "wood":
				$estado_quality_1="";
				$estado_quality_2="checked";	
				$estado_quality_3="";	
				$estado_quality_4="";
				break;
			case "metals":
				$estado_quality_1="";
				$estado_quality_2="";	
				$estado_quality_3="checked";	
				$estado_quality_4="";
				break;
			case "concret":
				$estado_quality_1="";
				$estado_quality_2="";	
				$estado_quality_3="";	
				$estado_quality_4="checked";
				break;
		}
	
		$quality_comments=$row2["quality_comments"];
		$quality_action_taken=$row2["quality_action_taken"];
		$Drywall=$row2["Drywall"];		
		switch ($Drywall) {
			case "Excessive":
				$estado_Drywall_1="checked";
				$estado_Drywall_2="";				
				break;
			case "Acceptable":
				$estado_Drywall_1="";
				$estado_Drywall_2="checked";				
				break;			
		}
		
		$Drywall_comments=$row2["Drywall_comments"];
		$Drywall_action_taken=$row2["Drywall_action_taken"];		
	}
	else
	{
		$Fecha = date("m-d-Y");
		$Check_status = "";
		$Check_coming = "";
		$Date_Check_coming = date("m-d-Y");
		$Check_framing = "";
		$Date_Check_framing =date("m-d-Y");
		$Check_hanging="";
		$Date_Check_hanging=date("m-d-Y");
		$Check_construction="";
		$Check_hidden="";
		$hidden_yes_no="";
		$others="";
		$Check_we_can="";
		$Date_estimate=date("m-d-Y");
		$Date_actual=date("m-d-Y");
		$DAte_finally=date("m-d-Y");
		$Check_quality="";
		$text_Check_quality="";
		$Check_discuse="";
		$text_Check_discuse="";
		$Check_control="";
		$text_Check_control="";
		$pwt_actual="";
		$pwt_quality="";
		$pwt_production_rate="";
		$pwt_painters="0";
		$pwt_apprentices="0";
		$pwt_comments="";
		$pwt_action="";
		$pwt_miscellaneous="";
		$gc="";
		$gc_action="";
		$quality="";
		$quality_comments="";
		$quality_action_taken="";
		$Drywall="";
		$Drywall_comments="";
		$Drywall_action_taken="";
		
		$estado_quality_4="checked";
	}
	mysqli_free_result($result2);
		
		
?> 
<div id="Div_Form_Informe">
    <form action="#" id="Form_Informe_Proyecto_Nuevo" name="Form_Informe_Proyecto_Nuevo">
        <table width="100%">
            <tr>
                <td width="100%">
                    <fieldset>
                        <legend><strong>Superintendet Daily Field Report</strong></legend>
                        <div id="Div_Proyecto_Proyecto_Nuevo_Datos" name="Div_Proyecto_Proyecto_Nuevo_Datos" style="height: 500px; overflow-y: scroll;display:block" >
                            <table  cellpadding="2" cellspacing="2" width="100%">
                                <tr>
                                    <td colspan="2"><strong>Name:</strong>
                                        <input name="Nombre" type="text" id="Nombre" size="20" value="<?php echo $Empleado;?>"/> 
                                        <strong>Job Name:</strong> 
                                        <input name="Job" type="text" id="Job" size="20" value="<?php echo $Nombre;?>"/>
                                        <strong>Date: </strong>                                       
                                        <input type="text" name="txt_date" size="14" value="<?php echo $Fecha;?>" id="txt_date" datepicker="true" datepicker_format="MM-DD-YYYY"  > 
                                        <img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("txt_date"));' />
                                    </td>
                                </tr>                         
                                <tr>
                                    <td colspan="2"><strong>Goal of de Visit</strong></td>
                                </tr>
                                <tr>
                                    <td ><input type="checkbox" name="status" id="status" <?php echo $Check_status; ?> > 
                                    Status of the construction: </td>
                                    <td width="535">
                                        <table>
                                            <tr><td width="176"><input type="checkbox" name="Coming" id="Coming" <?php echo $Check_coming; ?> > Coming off the Ground </td>
                                            
                                            <tr><td><input type="checkbox" name="Framig" id="Framig" <?php echo $Check_framing; ?> > Framig </td>
                                            
                                            <tr><td><input type="checkbox" name="Hanging" id="Hanging" <?php echo $Check_hanging; ?> > Hanging Drywall</td>
                                            
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td  colspan="2"><input type="checkbox" name="schedule" id="schedule" <?php echo $Check_construction; ?> > 
                                    Find out the schedule of the construction and the sequence of finishes </td>
                                </tr>
                                <tr>
                                    <td  colspan="2"><input type="checkbox" name="hidden" id="hidden" <?php echo $Check_hidden; ?> > 
                                    Find out if we can paint hidden items: is there posible paint hide items:
                                      <input type="radio" name="YesNo" id="YesNo" value="No"  <?php echo $estado_yes_no_1; ?>> No / <input type="radio" name="YesNo" id="YesNo" value="Yes" <?php echo $estado_yes_no_2; ?>> 
                                      Yes (Lintels before windows /Elevator shaf before the elevator equipment /Mechanical etc.)
                                      <input name="txt_hidden" type="text" id="txt_hidden" value="<?php echo $others; ?>" size="55"></td>
                                </tr>                       
                                <tr>
                                    <td>&nbsp;</td><td>Stimate Start Date:<input name="date1_painting" type="text" id="date1_painting" value="<?php echo $Date_estimate; ?>" datepicker="true" datepicker_format="MM-DD-YYYY"  > 
                                            <img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("date1_painting"));' /></td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" name="painting" id="painting" <?php echo $Check_we_can; ?> />
Find dates: </td><td>Actual Start Date:<input name="date2_painting" type="text" id="date2_painting" value="<?php echo $Date_actual; ?>"datepicker="true" datepicker_format="MM-DD-YYYY"  > 
                                            <img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("date2_painting"));' /></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td> Finish Date:
                                      <input name="date3_painting" type="text" id="date3_painting" value="<?php echo $DAte_finally; ?>"datepicker="true" datepicker_format="MM-DD-YYYY"  > 
                                            <img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("date3_painting"));' /></td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" name="Quality" id="Quality" <?php echo $Check_quality; ?> >
                                      Quality control and  see next areas to be painted and status of special finishes</td><td>&nbsp;</td>                                
                                </tr>
                                <tr>
                                    <td><input type="checkbox" name="Discuss" id="Discuss" <?php echo $Check_discuse; ?> > Discuss w/GC </td><td><input name="txt_Discuss" type="text" id="txt_Discuss" value="<?php echo $text_Check_discuse; ?>" size="60" /></td>
                                </tr>
                                <tr>
                                    <td width="187"><input type="checkbox" name="complete" id="complete" <?php echo $Check_control; ?> > 
                                    Control the complete execution of the scope of work for Contract and Change Orders, (report remaining items if there is some) </td>
                                    <td><p>Usualy at the end of the job</p>
                                      <p>
                                        <textarea name="txt_complete" cols="50" rows="2" id="txt_complete"><?php echo $text_Check_control; ?></textarea>
                                    </p></td>
                                </tr>
                                <tr> <td colspan="2"><b>PWT Work and Crew:</b></td></tr>      
                                <tr>
                                    <td align="left" valign="bottom"><p>Actual Working areas:
                                        <textarea name="areas" cols="30" rows="1" id="areas"><?php echo $pwt_actual; ?></textarea>
                                    </p>
                                      <p>
                                   Quality
                                  <input name="Quality2" type="text" id="Quality2" value="<?php echo $pwt_quality; ?>" size="20" />
                                  </p></td><td valign="top"> 
                                      <p>Next Areas to paint:</p>
                                      <p>
  <textarea name="txt_Quality" cols="45" rows="1" id="txt_Quality"><?php echo $text_Check_quality; ?></textarea>
                                      </p></td>
                                </tr>
                                <tr>
                                    <td>Perception production rate:
                                      <input type="radio" name="rate" id="rate" value="Excelent" <?php echo $estado_rate_1; ?>> 
                                      Excelent/..
                                      <input type="radio" name="rate" id="rate" value="Good" <?php echo $estado_rate_2; ?>> Good/ <input type="radio" name="rate" id="rate" value="Regular" <?php echo $estado_rate_3; ?>> Regular/<input type="radio" name="rate" id="rate" value="Poor" <?php echo $estado_rate_4; ?>> Poor</td><td>Man power:Painters#<input name="Painters" type="text" id="Painters" value="<?php echo $pwt_painters; ?>" size="5"> Aprentices#<input name="Aprentices" type="text" id="Aprentices" value="<?php echo $pwt_apprentices; ?>" size="5"></td>
                                </tr>
                                <tr><td colspan="2">Comments:<input name="areas_Comments" type="text" id="areas_Comments" value="<?php echo $pwt_comments; ?>" size="75"></td></tr>
                                <tr>
                                  <td colspan="2">Actions taken or need to be taken:
                                    <input name="areas_taken" type="text" id="areas_taken" value="<?php echo $pwt_action; ?>" size="55"></td></tr>
                                <tr><td colspan="2"><p>Miscellaneus(Deliveries, Pick-UP of the Equipment, Meetings Etc)</p>
                                  <p>
                                    <input name="areas_Miscellaneus" type="text" id="areas_Miscellaneus" value="<?php echo $pwt_miscellaneous; ?>" size="85">
                                </p></td></tr>
                                <tr> <td colspan="2"><b>GC And other trades work:</b></td></tr>                           
                                <tr>
                                  <td colspan="2">GC organization and sequencing :
                                    <input name="sequencing" type="text" id="sequencing" value="<?php echo $gc; ?>" size="30"></td></tr>
                                <tr>
                                  <td colspan="2">Action taken or need to be taken:
                                <input name="sequencing_taken" type="text" id="sequencing_taken" value="<?php echo $gc_action; ?>" size="30"></td></tr>
                                <tr> <td colspan="2"><b>Other Trades work:</b></td></tr>
                                <tr><td colspan="2">Quality of the substrates:<div style="display:none"><input type="radio" name="substrates" id="substrates" value="Drywall" <?php echo $estado_quality_1; ?>> Drywall/<input type="radio" name="substrates" id="substrates" value="wood" <?php echo $estado_quality_2; ?>>  wood/ <input type="radio" name="substrates" id="substrates" value="metals"  <?php echo $estado_quality_3; ?>> metals/<input type="radio" name="substrates" id="substrates" value="concret" <?php echo $estado_quality_4; ?> > concret etc.</div>
                                	(Drywall/wood/metals/concret etc.)
                                </td></tr>
                                <tr><td colspan="2">Comments:<input name="substrates_Comments" type="text" id="substrates_Comments" value="<?php echo $quality_comments; ?>" size="65"></td></tr>
                                <tr>
                                  <td colspan="2">Actions taken or need to be taken:
                                <input name="substrates_taken" type="text" id="substrates_taken" value="<?php echo $quality_action_taken; ?>" size="55"></td></tr>
                                <tr><td colspan="2">Drywall point up:<input type="radio" name="Drywall" id="Drywall" value="Excessive"<?php echo $estado_Drywall_1; ?>> Excessive/<input type="radio" name="Drywall" id="Drywall" value="Acceptable"<?php echo $estado_Drywall_2; ?>> Acceptable 5% of the wall</td></tr>
                                <tr><td colspan="2">Comments:<input name="Drywall_Comments" type="text" id="Drywall_Comments" value="<?php echo $Drywall_comments; ?>" size="80"></td></tr>
                                <tr>
                                  <td colspan="2">Action taken or need to be taken:
                                <textarea name="Drywall_taken" cols="55" rows="1" id="Drywall_taken"><?php echo $Drywall_action_taken; ?></textarea></td></tr>
                            </table>
                        </div>
                    </fieldset>            
                    <input type="button" value="Save" id="Boton_Salvar" onClick="informe_proyecto_nuevo_registrar(<?php echo $Pro_ID;?>,'No');">
                    <input type="button" value="Save & email" id="Boton_Salvar" onClick="informe_proyecto_nuevo_registrar(<?php echo $Pro_ID;?>,'Si');"> <input type="reset" value="Clear">   
               </td>
            </tr>
        </table>            
    </form>
</div>
<div id="Res_Informe"></div>

	<!--<img src='images/spacer.gif' onload='Iniciar_Validacion_Informe_Proyecto_Nuevo();' />-->
<?php
	require('Library/Close_Conexion.php');
?>