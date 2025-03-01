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
	$Pro_ID=$_SESSION["Pro_ID"];
?>

<LINK href="include/Stat.css" type="text/css" rel="stylesheet">
<link rel="STYLESHEET" type="text/css" href="include/estilo_reporte.css">
<script type="text/javascript" src="include/jquery-1.3.2.js"></script>
<script type="text/javascript" src="include/getAjax.js"></script> 
<script type="text/javascript" src="include/funciones.js"></script>
<script type="text/javascript" src="include/jquery.columnhover.js" ></script>	
<!-- Contact Form CSS files -->
<link type='text/css' href='css/basic.css' rel='stylesheet' media='screen' />
<script type='text/javascript' src='include/jquery.simplemodal.js'></script>
<script type="text/javascript" src="include/datepickercontrol.js"></script>
<link type="text/css" rel="stylesheet" href="css/datepickercontrol.css"/> 
<link href="css/flexigrid.pack.css" type="text/css" rel="stylesheet">	
<script src="include/flexigrid.pack.js" type="text/javascript"></script>
<link rel="stylesheet" href="jwysiwyg/jquery.wysiwyg.css" type="text/css" />
<script type="text/javascript" src="jwysiwyg/jquery.wysiwyg.js"></script>   

<style type="text/css">

p.MsoNormal {
margin:0cm;
margin-bottom:.0001pt;
font-size:12.0pt;
font-family:"Times New Roman";
}
</style>

<style type="text/css">
<!--
.style10 {
	color: #FF0000;
	font-size: medium;
}
-->
td.betterhover, #tabletwo tbody tr:hover
{
	background: LightCyan;
}
</style>

<script type="text/javascript">	
	function importar()
	{
		var checkboxes = document.getElementById("form_importar").Imp_ID;     
		var imp_id="";
		for (var x=0; x < checkboxes.length; x++) 
		{
			if (checkboxes[x].checked) 
			{
				if (imp_id=="")
					imp_id=imp_id+checkboxes[x].value;
				else
					imp_id=imp_id+","+checkboxes[x].value;
			}
		}
		//alert(imp_id)
		url = 'Proyectos_Importar_Upload_Registrar.php?imp_id='+imp_id;
		getAx(url,'Div_Importar_Resultado',150); 		
	}			
</script>	

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>	    
  	  	<td valign="top" width="99%">
			<table width="100%">
				<tr>
					<td colspan="2">
					<div>	
						<form id="form_importar" name="form_importar">				
						
			<?php
				$sql = "SELECT Pro_ID,Codigo,Nombre,CostCodeClosed,UpdateH FROM proyectos WHERE Pro_ID=".$Pro_ID;														
				$result89=$bd->ejecutar($sql); 
				//echo $sql."<br>";
				if (($row89 = mysqli_fetch_array($result89) ))	
				{									
					$CodigoJob=$row89["Codigo"];
					$CodigoJob=ltrim($CodigoJob);
					$CodigoJob=rtrim($CodigoJob);
					$NomJobA=$row89["Nombre"];
					$CostCodeClosed=$row89["CostCodeClosed"];
					$UpdateH=$row89["UpdateH"];
				
				}
				mysqli_free_result($result89);
		
				/*
				$Exist=0;
				//echo "Datos:Pro.Id : ".$Pro_ID;
				$sql = "SELECT COUNT(Pro_ID) AS Exist FROM edificios WHERE Pro_ID=".$Pro_ID;														
				$result89=$bd->ejecutar($sql); 
				//echo $sql."<br>";
				if (($row89 = mysqli_fetch_array($result89) ))	
				{									
					$Exist=$row89["Exist"];
				
				}
				mysqli_free_result($result89);
				echo "Exist: ".$Exist."  ".'<br>';*/
				$RDinsert=0;
				$xx=1;
				$Exist=0;
				if (($Exist!=0 && $xx==0) || ($CostCodeClosed==1) || ($UpdateH<>"Y"))
				{					
					echo "Job Cost Codes Generated Manualy /There is some structure for the project, unable to Import <br>";
					echo " Delete the structure 1st. and make sure the data for that job is empty  <br>";
					echo " Job set up to update hrs:".$UpdateH;						
					//echo " Status 5=Done 3,4=90%done 2=Coming Up 1=In process:".$CostCodeClosed." Job set up to update hrs:".$UpdateH;					
				}			
						
			    else
				{
			
							echo '<i style="color:blue;font-size:20px;font-family:calibri ;"> Generating Structure !!   </i> ';
							
							if ($_FILES["UserFile"]["error"] > 0)
							{
								echo "Return Code: " . $_FILES["UserFile"]["error"] . "<br />";
							}
							
							else
							{
								echo "Upload: " . $_FILES["UserFile"]["name"] . "<br />";
								
								//echo "Type: " . $_FILES["UserFile"]["type"] . "<br />";
								//echo "Size: " . ($_FILES["UserFile"]["size"] / 1024) . " Kb<br />";
								//echo "Temp file: " . $_FILES["UserFile"]["tmp_name"] . "<br />";
							
								if (file_exists("upload/" . $_FILES["UserFile"]["name"]))
								{
								  //echo $_FILES["UserFile"]["name"] . " Deleted ";
								  unlink("upload/" . $_FILES["UserFile"]["name"]);
								};
								
							 	move_uploaded_file($_FILES["UserFile"]["tmp_name"],
							  	"upload/" . $_FILES["UserFile"]["name"]);
							  	//echo "Stored in: " . "upload/" . $_FILES["UserFile"]["name"];
								
								$file = fopen("upload/" . $_FILES["UserFile"]["name"], "r") or exit("Unable to open file!");
								//Output a line of the file until the end is reached

								$strSQL = "TRUNCATE TABLE import_piso";		
								$res1=$bd->ejecutar($strSQL);  
								$JobIDTAnt="";

								while(!feof($file))
								{		
								
								////////////////////////////\\\\\\\\\\\
																
									list($JobIDT,$JobNom,$EdiCod,$EdiNom,$FloCod,$FloNom,$AreCod,$AreNom,$TasCod,$TasNom,$HorEst) = explode(",", fgets($file));
									list($Linea, $JobIDT) = explode(":", $JobIDT);
									$JobIDT=ltrim($JobIDT);
									$JobIDT=rtrim($JobIDT);	
									$Resultado='The structure of Cost Codes is imported, Tks';
									//echo $JobIDT."<br>";
									//echo $CodigoJob."<br>";		;
									if ($JobIDT=='000.00.0')
									  {
										$JobIDT=$CodigoJob;
										
										echo "Job: ".$NomJobA."<br>";
										echo '<i style="color:green;font-size:15px;font-family:calibri ;"> \ From Standard Areas and Cost Codes / </i> ';
									  }
									
									/*if ($JobIDT != $CodigoJob)
									{
										echo "The job you are trying import is not the same you selected "."<br>";
										echo "You selected:".$CodigoJob.$NomJobA."<br>";
										echo "In the file is:".$JobIDT.":".$JobNom."<br>";
										$Resultado='The structure it is not imported';			
										break;
										
									}*/
									
									
									$EdiCod=ltrim($EdiCod);									
									$EdiCod=rtrim($EdiCod);
									$FloCod=ltrim($FloCod);
									$FloCod=rtrim($FloCod);
									$AreCod=ltrim($AreCod);
									$AreCod=rtrim($AreCod);
									$TasCod=ltrim($TasCod);
									$TasCod=rtrim($TasCod);
									

									
									if ($AreCod=="")
									{
										$AreCod="01";
										$AreNom="TouchUp-Composite-PunchList";
										
									}
									if ($HorEst=="")
									{
										$HorEst=0;
									}
									
									//echo $JobIDT.",".$JobNom.",".$EdiCod.",".$EdiNom.",".$FloCod.",".$FloNom.",".$AreCod.",".$AreNom.",".$TasCod.",".$TasNom.",".$HorEst.",".$Linea."<br>";
									//echo "Llego<br>";	
									//exit ();

									if ($Linea=="NL")
									{	
									
										$JobIDT=ltrim($JobIDT);
										$JobIDT=rtrim($JobIDT);
										$sql = "SELECT Pro_ID,Codigo,Nombre FROM proyectos WHERE Codigo='".$JobIDT."'";														
										$result89=$bd->ejecutar($sql); 
										//echo $sql."<br>";
										if (($row89 = mysqli_fetch_array($result89) ))	
										{									
											$CodigoJob=$row89["Codigo"];
											$CodigoJob=ltrim($CodigoJob);
											$CodigoJob=rtrim($CodigoJob);
											$NomJobA=$row89["Nombre"];
											$Pro_ID=$row89["Pro_ID"];
										
										}
										else
										{
											$Resultado='The job does not exist on STP or there is some inconsistencies on the txt file Job# in the file: '.$JobIDT." ";		
											break;
										}
										mysqli_free_result($result89);
										
//								8888888888
												
												//$consulta="SELECT * FROM task where trim(substring(NumAct,1,5))='".$AreCod."' AND trim(substring(NumAct,6,9))='".$TasCod."' and Pro_ID=".$Pro_ID;
												
												
												//11/18/22   $consulta="SELECT * FROM task where ActAre='".$AreCod."' AND ActTas='".$TasCod."' and Pro_ID=".$Pro_ID;
												$consulta="SELECT * FROM task t Inner JOIN area_control a ON t.Area_ID=a.Area_ID 
LEFT JOIN floor f ON f.Floor_ID=a.Floor_ID 
LEFT JOIN edificios e ON e.Edificio_ID=f.Edificio_ID
inner join proyectos p on p.Pro_ID=t.Pro_ID  where t.ActAre='".$AreCod."' AND t.ActTas='".$TasCod."' and t.Pro_ID=".$Pro_ID." and a.Are_IDT='".$AreCod."' and f.Flo_IDT='".$FloCod."' and e.Edi_IDT='".$EdiCod."'";

//11/18


												echo " Task codigo: ".$TasCod." ".$TasNom."  //".$consulta."<br>";
												//exit ();
												
												$result2=$bd->ejecutar($consulta);
												$Updflag=0; 										
												while (($row2 = mysqli_fetch_array($result2) ))																
													{	
														$Task_ID = $row2["Task_ID"];
														$strSQL = "UPDATE task SET Horas_Estimadas=".$HorEst.",Nombre='".$TasNom."' WHERE Pro_ID=".$Pro_ID." AND Task_ID=".$Task_ID; 	
														echo " Task: ".$strSQL."<br>";														
														$res1=$bd->ejecutar($strSQL);
														$Updflag=1; 
													}
												mysqli_free_result($result2);	
												if ($Updflag==1)
													continue; 
												echo "continue after "."<br>";
									
									///888888888888
									

										
										
										
																												
										// verificar si existe
										$Edificio_ID="";
										$consulta = "SELECT Edificio_ID FROM edificios WHERE Pro_ID=".$Pro_ID." AND Edi_IDT='".$EdiCod."'";											
										echo " edificios codigo: ".$consulta."<br>";
												$result2=$bd->ejecutar($consulta); 										
												while (($row2 = mysqli_fetch_array($result2) ))																
												{	
													$Edificio_ID = $row2["Edificio_ID"];
												}
												mysqli_free_result($result2);	
											//echo "Edif Id:".$Edificio_ID."<br>";
											if ($Edificio_ID=="")
												{

												$strSQL = "INSERT INTO edificios (Nombre, Horas_Estimadas, Material_Estimado,Porcentaje,Pro_ID, Aux1, Aux2,Edi_IDT ) ";	
												$strSQL = $strSQL . " values ('".$EdiNom."',0,0,0,".$Pro_ID.",'','','".$EdiCod."')";		
												echo " edificios: ".$strSQL."<br>";														
												$res1=$bd->ejecutar($strSQL); 
												$consulta = "SELECT Edificio_ID FROM edificios WHERE Pro_ID=".$Pro_ID." AND Edi_IDT='".$EdiCod."'";											
												//echo " edificios codigo: ".$consulta."<br>";
												$result2=$bd->ejecutar($consulta); 										
												while (($row2 = mysqli_fetch_array($result2) ))																
													{	
														$Edificio_ID = $row2["Edificio_ID"];
													}
												mysqli_free_result($result2);	
																					
												}
												//echo "2nd Edif Id:".$Edificio_ID."<br>";
												
										// fin verificacion edificios  si existe y graba si no existe
										
										// Floor verificar si existe
										$Floor_ID="";
										$consulta = "SELECT Floor_ID,Edificio_ID FROM floor WHERE Pro_ID=".$Pro_ID." AND Edificio_ID=".$Edificio_ID." AND Flo_IDT='".$FloCod."'";											
										//echo " Floor codigo: ".$consulta."<br>";
										$result2=$bd->ejecutar($consulta); 										
												while (($row2 = mysqli_fetch_array($result2) ))																
												{	
													$Floor_ID = $row2["Floor_ID"];
												}
												mysqli_free_result($result2);	
											//echo "Floor Id:".$Floor_ID."<br>";
											if ($Floor_ID=="")
												{

												$strSQL = "INSERT INTO floor (Pro_ID,Flo_IDT,Nombre,Edificio_ID) ";	
												$strSQL = $strSQL . " values (".$Pro_ID.",'".$FloCod."','".$FloNom."',".$Edificio_ID.")";		
												echo " Floor: ".$strSQL."<br>";														
												$res1=$bd->ejecutar($strSQL); 
												$consulta = "SELECT Floor_ID,Edificio_ID FROM floor WHERE Pro_ID=".$Pro_ID." AND Edificio_ID=".$Edificio_ID." AND Flo_IDT='".$FloCod."'";									//echo " floor codigo: ".$consulta."<br>";
												$result2=$bd->ejecutar($consulta); 										
												while (($row2 = mysqli_fetch_array($result2) ))																
													{	
														$Floor_ID = $row2["Floor_ID"];
													}
												mysqli_free_result($result2);	
																					
												}
												//echo "2nd floor Id:".$Floor_ID."<br>";
												//exit();
										// fin verificacion Floor  si existe y graba si no existe
										
										
										// AREA verificar si existe
										$Area_ID="";
										$consulta = "SELECT Floor_ID,Area_ID,Are_IDT FROM area_control WHERE Pro_ID=".$Pro_ID." AND Floor_ID=".$Floor_ID." AND Are_IDT='".$AreCod."'";											
										//echo " Area codigo: ".$consulta."<br>";
												$result2=$bd->ejecutar($consulta); 										
												while (($row2 = mysqli_fetch_array($result2) ))																
												{	
													$Area_ID = $row2["Area_ID"];
													$Are_IDT = $row2["Are_IDT"];
												}
												mysqli_free_result($result2);	
											//echo "Area Id:".$Area_ID."<br>";
											if ($Area_ID=="")
												{

												$strSQL = "INSERT INTO area_control (Pro_ID,Are_IDT,Nombre,Floor_ID) ";	
												$strSQL = $strSQL . " values (".$Pro_ID.",'".$AreCod."','".$AreNom."',".$Floor_ID.")";		
												echo " Area: ".$strSQL."<br>";														
												$res1=$bd->ejecutar($strSQL); 
												$consulta = "SELECT Floor_ID,Area_ID,Are_IDT FROM area_control WHERE Pro_ID=".$Pro_ID." AND Floor_ID=".$Floor_ID." AND Are_IDT='".$AreCod."'";											
												//echo " Area codigo: ".$consulta."<br>";
												$result2=$bd->ejecutar($consulta); 										
												while (($row2 = mysqli_fetch_array($result2) ))																
													{	
														$Area_ID = $row2["Area_ID"];
														$Are_IDT = $row2["Are_IDT"];
													}
												mysqli_free_result($result2);	
																					
												}
												//echo "2nd AreaId:".$Area_ID."<br>";
												//exit();
										// AREA fin verificacion  si existe y graba si no existe
										
										
											// task verificar si existe
										$Task_ID="";
										$consulta = "SELECT Floor_ID,Area_ID, Task_ID,Horas_Estimadas,Nombre FROM task WHERE Pro_ID=".$Pro_ID." AND Floor_ID=".$Floor_ID." AND Area_ID=".$Area_ID." AND Tas_IDT='".$TasCod."'";											
										//echo " Task codigo: ".$consulta."<br>";
												$result2=$bd->ejecutar($consulta); 										
												while (($row2 = mysqli_fetch_array($result2) ))																
												{	
													$Task_ID = $row2["Task_ID"];
													$HorasEstimadas=$row2["Horas_Estimadas"];
													$Nombre_task=$row2["Nombre"];
												}
												mysqli_free_result($result2);	
											//echo "Task Id:".$Task_ID."<br>";
											if ($Task_ID=="")
												{
												$lon=strlen(rtrim($Are_IDT));
												if ($lon<4)
													$NumAct="       ".$TasCod;
												  else
												  	$NumAct=rtrim($Are_IDT)."   ".$TasCod;
												echo $Are_IDT," ",$lon."<br>";
												if ($Are_IDT=="NShow")
													$Are_IDT="";
													
													
												$AreCodx=trim($AreCod);
												if ($AreCodx > 900)
												{
														$NumAct="    ".$TasCod;
														$Are_IDT="  ";
														
												}
												$strSQL = "INSERT INTO task (Pro_ID,Tas_IDT,NumAct,ActAre,ActTas,Nombre,Floor_ID,Area_ID,Horas_Estimadas) ";	
												$strSQL = $strSQL . " values (".$Pro_ID.",'".$TasCod."','".$NumAct."','".$Are_IDT."','".$TasCod."','".$TasNom."',".$Floor_ID.",".$Area_ID.",".$HorEst.")";		
												echo " Task-: ".$strSQL."<br>";														
												$res1=$bd->ejecutar($strSQL); 
												$consulta = "SELECT Floor_ID,Area_ID, Task_ID FROM task WHERE Pro_ID=".$Pro_ID." AND Floor_ID=".$Floor_ID." AND Area_ID=".$Area_ID." AND Tas_IDT='".$TasCod."'";											
												//echo " Task codigo: ".$consulta."<br>";
												$result2=$bd->ejecutar($consulta); 										
												while (($row2 = mysqli_fetch_array($result2) ))																
													{	
														$Task_ID = $row2["Task_ID"];
													
													}
												mysqli_free_result($result2);	
												}
											 else
											 	{
												$HorEst=number_format($HorEst, 2);	
												$HorasEstimadas=number_format($HorasEstimadas, 2);
												if ($HorEst!=$HorasEstimadas)
												{	
												echo "HorEst:".$HorEst."/HorasEstimadas:".$HorasEstimadas."/--"."<br>";
												$strSQL = "UPDATE task SET Horas_Estimadas=".$HorEst." WHERE Pro_ID=".$Pro_ID." AND Floor_ID=".$Floor_ID." AND Area_ID=".$Area_ID." AND Tas_IDT='".$TasCod."'"; 	
												echo " Task: ".$strSQL."<br>";														
												$res1=$bd->ejecutar($strSQL); 
												}
												
												////8888888
												echo $Nombre_task."  nombre task <br>";
												
												if ($Nombre_task=="")
												{	
												$strSQL = "UPDATE task SET Nombre=".$TasNom." WHERE Pro_ID=".$Pro_ID." AND Floor_ID=".$Floor_ID." AND Area_ID=".$Area_ID." AND Tas_IDT='".$TasCod."'"; 	
												echo " Task: ".$strSQL."<br>";														
												$res1=$bd->ejecutar($strSQL); 
												}
												
												
												////888888
												}
												//echo "2nd TaskId:".$Task_ID."<br>";
												//exit();
										// task fin verificacion  si existe y graba si no existe
										
									}
								}
								fclose($file);
							/*	$AreCod="--";
								$AreNom='z.No show up/No Worked';
								$strSQL = "INSERT INTO area_control (Pro_ID,Are_IDT,Nombre,Floor_ID) ";	
								$strSQL = $strSQL . " values (".$Pro_ID.",'".$AreCod."','".$AreNom."',".$Floor_ID.")";		
								//echo " Area: ".$strSQL."<br>";														
								$res1=$bd->ejecutar($strSQL); 
								$consulta = "SELECT Floor_ID,Area_ID FROM area_control WHERE Pro_ID=".$Pro_ID." AND Floor_ID=".$Floor_ID." AND Are_IDT='".$AreCod."'";											
								//echo " Area codigo: ".$consulta."<br>";
								$result2=$bd->ejecutar($consulta); 										
									while (($row2 = mysqli_fetch_array($result2) ))																
										{	
											$Area_ID = $row2["Area_ID"];
										}
										mysqli_free_result($result2);								
								$TasCod="VACNOSHOW";
								$HorEst=0;
								$TasNom='z.No show up/No Worked';
								
								$strSQL = "INSERT INTO task (Pro_ID,Tas_IDT,Nombre,Floor_ID,Area_ID,Horas_Estimadas) ";	
								$strSQL = $strSQL . " values (".$Pro_ID.",'".$TasCod."','".$TasNom."',".$Floor_ID.",".$Area_ID.",".$HorEst.")";		
							//	echo " Task: ".$strSQL."<br>";														
								$res1=$bd->ejecutar($strSQL); 
								*/
											
								
								
								echo "<table border='1' cellspacing='0' cellpadding='0'>";
								echo "</table>";
								
							}
							
					}		
					
					echo $Resultado."<br>";
					
				?>
                        
                        
							<div id="Div_Importar_Resultado" name="Div_Importar_Resultado">							
								Ready to use --
							</div>
						</form>
					</div>
					</td> 
				</tr>					 
			</table>			
		</td>
	</tr>
</table>
<?php
	require('Library/Close_Conexion.php');
?>