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
		
	//echo "***".$_POST['Painters']. ", ".$_POST['Aprentices']."***<br>";		         					  
	
	foreach($_POST as $nombre_campo => $valor)
	{
	   	
	   	if (  (empty($valor))  &&   ($valor!=0)   )	
				$asignacion = "\$" . $nombre_campo . "='';";			
		else
			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";			
			
	   	eval($asignacion);
	} 	
	
	//echo "***".$Painters. ", ".$Aprentices."***";
	
	$Fecha=$txt_date;
	
	/*$Fecha=ConvertDateToMysqlFormat($Fecha);
	$txt_Coming=ConvertDateToMysqlFormat($txt_Coming);
	$txt_Framig=ConvertDateToMysqlFormat($txt_Framig);
	$txt_Hanging=ConvertDateToMysqlFormat($txt_Hanging);
	$date1_painting=ConvertDateToMysqlFormat($date1_painting);
	$date2_painting=ConvertDateToMysqlFormat($date2_painting);
	$date3_painting=ConvertDateToMysqlFormat($date3_painting); */
	
	
	
	$strSQL = "INSERT INTO informe_proyecto (Empleado_ID, Pro_ID, Fecha, Check_status , Check_coming , Date_Check_coming, Check_framing, Date_Check_framing,
				 Check_hanging, Date_Check_hanging, Check_construction, Check_hidden, hidden_yes_no, others, Check_we_can, Date_estimate, Date_actual, DAte_finally,
				 Check_quality, text_Check_quality, Check_discuse, text_Check_discuse , Check_control, text_Check_control,
				 pwt_actual, pwt_quality , pwt_production_rate, pwt_painters, pwt_apprentices, pwt_comments , pwt_action, pwt_miscellaneous,
				 gc, gc_action,
				 quality, quality_comments , quality_action_taken, Drywall, Drywall_comments, Drywall_action_taken) ";	
	$strSQL = $strSQL . " values (".$_SESSION["Empleado_ID"].", '" . $Pro_ID . "','" . $Fecha. "'," . $status. "," . $Coming. ",'" . $txt_Coming . "'," . $Framig. ",'" . $txt_Framig. "'," . $Hanging . ",'" . $txt_Hanging. "', ". $schedule. ", ".$hidden. ",'" . $YesNo . "', '" . $txt_hidden. "', " . $painting. ", '" . $date1_painting. "', '" . $date2_painting. "', '" . $date3_painting."', ".$Quality. ", '".$txt_Quality. "', ".$Discuss. ", '".$txt_Discuss. "', ".$complete. ", '".$txt_complete. "', '".$areas. "', '".$Quality2. "', '".$rate. "', ".$Painters. ", ".$Aprentices. ", '".$areas_Comments. "', '".$areas_taken. "', '".$areas_Miscellaneus. "', '".$sequencing. "', '".$sequencing_taken. "', '".$substrates. "', '".$substrates_Comments. "', '".$substrates_taken. "', '".$Drywall. "', '".$Drywall_Comments. "', '".$Drywall_taken. "')";
	
  
	//echo $strSQL."<br>";
	//echo $Contenido."<br>";					
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{		
		echo "<img src='images/spacer.gif' onload='informe_proyecto_Menu(".$Pro_ID.",\"".$Nombre."\");'>";
		echo "Record successful !!!";
		
		if ($email=="Si")
		{		
			$consulta = "SELECT emails FROM proyectos WHERE Pro_ID=".$Pro_ID;	
			$result32=$bd->ejecutar($consulta); 	
			while (($row32 = mysqli_fetch_array($result32) ))							
			{	
	//*******************************************************************************************
				$consulta = "SELECT *, p.Nombre as Proyecto, CONCAT(em.Nombre, ' ', em.Apellido_Paterno, ' ',  em.Apellido_Materno) AS Empleado FROM informe_proyecto i INNER JOIN proyectos p ON i.Pro_ID=p.Pro_ID ";
				$consulta = $consulta . " INNER JOIN personal em ON em.Empleado_ID=i.Empleado_ID ";	
				$consulta = $consulta." WHERE i.Pro_ID=".$Pro_ID." ORDER BY Informe_ID DESC";					
				//echo $consulta."<br>";
			
				$result2=$bd->ejecutar($consulta); 	
				if (($row2 = mysqli_fetch_array($result2) ))							
				{	
					$Nombre = $row2["Proyecto"];
					$Empleado	= $row2["Empleado"];			
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
					$Contenido="							
							<div id='Div_Form_Informe'>
								<form>
								<table width='100%'>
									<tr>
										<td width='100%'>
											<fieldset>
												<legend><strong>Superintendet Daily Field Report (by email)</strong></legend>
												<div id='Div_Proyecto_Proyecto_Nuevo_Datos' name='Div_Proyecto_Proyecto_Nuevo_Datos' style='height: 500px; overflow-y: scroll;display:block' >
													<table  cellpadding='2' cellspacing='2' width='100%'>
														<tr>
															<td width='82' colspan='2'><strong>Name:</strong>
																<input name='Nombre' type='text' id='Nombre' size='20' value='". $Empleado."'/> 
																<strong>Job Name:</strong> 
																<input name='Job' type='text' id='Job' size='20' value='". $Nombre."'/>
																<strong>Date: </strong>                                       
																<input type='text' name='txt_date' size='14' value='". $Fecha."' id='txt_date' datepicker='true' datepicker_format='MM-DD-YYYY'  > 													
															</td>
														</tr>                         
														<tr>
															<td colspan='2'><strong>Goal of de Visit</strong></td>
														</tr>
														<tr>
															<td ><input type='checkbox' name='status' id='status' ".$Check_status."  > status of the construction </td>
															<td>
																<table>
																	<tr><td><input type='checkbox' name='Coming' id='Coming' ".$Check_coming."  > Coming off the Ground </td>
																	<td>
																			<input type='text' name='txt_Coming' size='14' value = '".$Date_Check_coming." ' id='txt_Coming' datepicker='true' datepicker_format='MM-DD-YYYY'  >														
																	</td>
																	</tr>
																	<tr><td><input type='checkbox' name='Framig' id='Framig' ".$Check_framing."  > Framig </td>
																	<td>:<input name='txt_Framig' type='text' id='txt_Framig' value='". $Date_Check_framing." ' datepicker='true' datepicker_format='MM-DD-YYYY'  ></td> </tr>
																	<tr><td><input type='checkbox' name='Hanging' id='Hanging' ".$Check_hanging."  > Hanging Drywall</td>
																	<td>:<input name='txt_Hanging' type='text' id='txt_Hanging' value='". $Date_Check_hanging." ' datepicker='true' datepicker_format='MM-DD-YYYY'  >
																	</td></tr>
																</table>
															</td>
														</tr>
														<tr>
															<td  colspan='2'><input type='checkbox' name='schedule' id='schedule' ".$Check_construction."  > Find out the schedule of the construction and the sequence of finishes </td>
														</tr>
														<tr>
															<td  colspan='2'><input type='checkbox' name='hidden' id='hidden' ".$Check_hidden."  > Find out if can we paint hidden item: <input type='radio' name='YesNo' id='YesNo' value='No'  ".$estado_yes_no_1." > No / <input type='radio' name='YesNo' id='YesNo' value='Yes' ".$estado_yes_no_2." > Yes (Lintels before windows /Elevator shaf before the elevator equipment /Mechanical, beams etc.)<input name='txt_hidden' type='text' id='txt_hidden' value='". $others." '></td>
														</tr>                       
														<tr>
															<td><input type='checkbox' name='painting' id='painting' ".$Check_we_can."  > Find when can we start painting </td><td>Stimate Start Date:<input name='date1_painting' type='text' id='date1_painting' value='". $Date_estimate." ' datepicker='true' datepicker_format='MM-DD-YYYY'  ></td>
														</tr>
														<tr>
															<td></td><td>Actual Start Date:<input name='date2_painting' type='text' id='date2_painting' value='". $Date_actual." 'datepicker='true' datepicker_format='MM-DD-YYYY'  ></td>
														</tr>
														<tr>
															<td></td><td>Finish Date:<input name='date3_painting' type='text' id='date3_painting' value='". $DAte_finally." 'datepicker='true' datepicker_format='MM-DD-YYYY'  ></td>
														</tr>
														<tr>
															<td><input type='checkbox' name='Quality' id='Quality' ".$Check_quality."  >Quality control and see next areas to be painted and status of special finishes </td><td><input name='txt_Quality' type='text' id='txt_Quality' value='". $text_Check_quality." '></td>                                
														</tr>
														<tr>
															<td><input type='checkbox' name='Discuss' id='Discuss' ".$Check_discuse."  > Discuss w/GC </td><td><input name='txt_Discuss' type='text' id='txt_Discuss' value='". $text_Check_discuse." '></td>
														</tr>
														<tr>
															<td width='200'><input type='checkbox' name='complete' id='complete' ".$Check_control."  > 
															Control the complete execution of the scope of work for Contract and Change Orders, (report remaining items if there is some): </td>
															<td><input name='txt_complete' type='text' id='txt_complete' value='". $text_Check_control." '></td>
														</tr>
														<tr> <td colspan='2'><b>PWT Work and Crew:</b></td></tr>      
														<tr>
															<td>Actual Working areas:<input name='areas' type='text' id='areas' value='". $pwt_actual." '></td><td>Quality:<input name='Quality2' type='text' id='Quality2' value='". $pwt_quality." '></td>
														</tr>
														<tr>
															<td>Perception of the production rate:<input type='radio' name='rate' id='rate' value='Excelent' ".$estado_rate_1." > Excelent/<input type='radio' name='rate' id='rate' value='Good' ".$estado_rate_2." > Good/ <input type='radio' name='rate' id='rate' value='Regular' ".$estado_rate_3." > Regular/<input type='radio' name='rate' id='rate' value='Poor' ".$estado_rate_4." > Poor</td><td>Man power:Painters#<input type='text' name='Painters' id='Painters' value='". $pwt_painters." '> Aprentices#<input type='text' name='Aprentices' id='Aprentices' value='". $pwt_apprentices." '></td>
														</tr>
														<tr><td colspan='2'>Comments:<input name='areas_Comments' type='text' id='areas_Comments' value='". $pwt_comments." '></td></tr>
														<tr><td colspan='2'>Taken actions or need to be taken:<input name='areas_taken' type='text' id='areas_taken' value='". $pwt_action." '></td></tr>
														<tr><td colspan='2'>Miscellaneus(Deliveries, Pick-UP of the Equipment, Meetings Etc):<input name='areas_Miscellaneus' type='text' id='areas_Miscellaneus' value='". $pwt_miscellaneous." '></td></tr>
														<tr> <td colspan='2'><b>GC And other trades work:</b></td></tr>                           
														<tr><td colspan='2'>GC organization and sequencing:<input name='sequencing' type='text' id='sequencing' value='". $gc." '></td></tr>
														<tr><td colspan='2'>Taken action or need to be taken:<input name='sequencing_taken' type='text' id='sequencing_taken' value='". $gc_action." '></td></tr>
														<tr> <td colspan='2'><b>Other Trades work:</b></td></tr>
														<tr><td colspan='2'>Quality of the substrates:(Drywall/wood/metals/concret etc.)</td></tr>
														<tr><td colspan='2'>Comments:<input name='substrates_Comments' type='text' id='substrates_Comments' value='". $quality_comments." '></td></tr>
														<tr><td colspan='2'>Actions take or need to be taken:<input name='substrates_taken' type='text' id='substrates_taken' value='". $quality_action_taken." '></td></tr>
														<tr><td colspan='2'>Drywall point up:<input type='radio' name='Drywall' id='Drywall' value='Excessive' ".$estado_Drywall_1." > Excessive/<input type='radio' name='Drywall' id='Drywall' value='Acceptable' ".$estado_Drywall_2." > Acceptable 5% of the wall</td></tr>
														<tr><td colspan='2'>Comments:<input name='Drywall_Comments' type='text' id='Drywall_Comments' value='". $Drywall_comments." '></td></tr>
														<tr><td colspan='2'>Taken actions or need to be taken:<input name='Drywall_taken' type='text' id='Drywall_taken' value='". $Drywall_action_taken." '></td></tr>
													</table>
												</div>
											</fieldset> 								
									   </td>
									</tr>
								</table>   
								</form>         
						</div>
					";
					
					$asunto="Inform Regitered at Superintendet Daily Field Report ".$Fecha." JOB:".$Nombre;		
	
					$destinatario = "mario.olmos@precisionwall.com";
					//$CC="cristian.frias.s@gmail.com,marioolmosvk@hotmail.com";				
					$CC=$row32["emails"];					
					//echo "******<br>".$Contenido."<br>*****<br>";	
					$cuerpo = '	
						<html> 	
							<head> 	
							   <title>Inform Register</title> 	
							</head>	
							<body>'.$Contenido.'</body>	
						</html>';			
				
					$headers  = "MIME-Version: 1.0\r\n"; 	
					$headers .= "From: ".$destinatario."\n"; 	
					$headers .= "Reply-To: ".$destinatario."\n";	
					$headers .= "Cc: ".$CC."\n";  			
		
					$headers .= "X-Priority: 1\n"; 	
					$headers .= "X-Mailer: DT Formmail".VERSION."\n"; 
					$headers .= "Content-Type: text/html;\n\tcharset=\"iso-8859-1\"\n";		  
			
					mail($destinatario, $asunto, $cuerpo, $headers);
					echo "<br>email send successful !!!";
				}
				mysqli_free_result($result2);           
	//*******************************************************************************************						
			}
			mysqli_free_result($result32);		
		}
	}
	else
	{
		echo "ERROR";
	}	
	require('Library/Close_Conexion.php');	
?>
	
	
	