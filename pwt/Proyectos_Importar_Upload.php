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
	$_SESSION["PageTitle"] = "Moviles";	
	$_SESSION["Cond_ID_Aux"] = "";			

	require('Header.php');
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
	    <td valign="top">		  
			<div id="ac_frmSearchMain">				  
				<form enctype="multipart/form-data" action="Proyectos_Importar_Upload.php" method="POST">			
				    <input type="hidden" name="MAX_FILE_SIZE" value="512000" />
					<table width="267" class="moduletable" >
						<tr>

							<th colspan="3">Import Structure Projects</th>
						</tr>		  		 					
						<tr>
							<td ><b>File  :</b></td>					
							<td colspan="2" valign="middle">
								<input type="file" name="UserFile" id="UserFile" />
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<a href="#"><input name="button" type="submit" value="Import from txt" /></a>&nbsp;&nbsp;&nbsp;
							  	<a href="#"><input type="reset" value=" Clear "  /></a>		
							</td>													
						</tr>					  					  
					</table>
				</form>	
			</div>
		</td>
		<td width="12" background="images/div_bkg.gif" valign="middle" onclick="javascript:ShowSearch()">
		  	<div id="rpt_closetab">
				<img src="images/div_left.gif" border="0" width="12" />
		  	</div>	  
	  	</td>
  	  	<td valign="top" width="99%">
			<table width="100%">
				<tr>
					<td colspan="2">
					<div>	
						<form id="form_importar" name="form_importar">				
						<?php
							if ($_FILES["UserFile"]["error"] > 0)
							{
								echo "Return Code: " . $_FILES["UserFile"]["error"] . "<br />";
							}
							else
							{
								//echo "Upload: " . $_FILES["UserFile"]["name"] . "<br />";
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

								$strSQL = "TRUNCATE TABLE import";		
								$res1=$bd->ejecutar($strSQL);  		

								while(!feof($file))
								{									
									list($Cod1, $Cod2, $Cod3, $job, $add, $nose1, $city, $state, $Zip_Code, $nose3, $submital, $estado_submital, $fecha) = explode("!", fgets($file));
									list($Linea, $Cod1) = explode(":", $Cod1);
									
									$submital=trim($submital); 
									$submital=str_replace("'","\'",$submital);
									
									//if ($Linea=="NL")									
									//	echo "$Cod1, $Cod2, $Cod3, $job, $add, $nose1, $city, $state, $nose2, $nose3, $submital, $estado_submital, $fecha ". "<br />";
									//echo "$Cod1, $Cod2, $Cod3, $job, $add, $nose1, $city, $state, $nose2, $nose3, $submital, $estado_submital, $fecha ". "<br />";																		
									if ($Linea=="NL")
									{									
										$Codigo=trim($Cod1).".".trim($Cod2).".".trim($Cod3);	
										
										$consulta = "SELECT Pro_ID FROM proyectos WHERE Codigo='".$Codigo."'";										
										$Pro_ID=-1;
										$result2=$bd->ejecutar($consulta); 	
										while (($row2 = mysqli_fetch_array($result2) ))							
										{		
											$Pro_ID = $row2["Pro_ID"];
										}
										mysqli_free_result($result2);										
										
										$Mat_ID=-1;										
										if ($Pro_ID==-1)
										{																	
											$strSQL = "INSERT INTO import (Job, Code, Address, City, Zip_Code, State, Submital, Estado_Submital, Fecha, Pro_ID, Mat_ID) ";	
											$strSQL = $strSQL . " values ('".trim($job)."', '".$Codigo."', '". trim($add). "','" . trim($city). "', '" . trim($state). "', '" . trim($Zip_Code). "', '" . trim($submital). "', '" . trim($estado_submital). "', '" .ConvertDateToMysqlFormat( trim($fecha)). "', ".$Pro_ID.", ".$Mat_ID.")";										
											//echo $strSQL."<br>";												
											$res1=$bd->ejecutar($strSQL); 								
										}
										else										
										{											
											if (    ($submital!="") && (   !(is_null($submital))   )     )
											{
												$consulta = "SELECT Mat_ID FROM materiales WHERE Denominacion='".trim($submital)."' AND Pro_ID=".$Pro_ID;	
												//echo $consulta."<br>";																				
												$result2=$bd->ejecutar($consulta); 	
												while (($row2 = mysqli_fetch_array($result2) ))							
												{		
													$Mat_ID = $row2["Pro_ID"];
												}
												mysqli_free_result($result2);											
	
												if ($Mat_ID==-1)
												{																	
													$strSQL = "INSERT INTO import (Job, Code, Address, City, Zip_Code, State, Submital, Estado_Submital, Fecha, Pro_ID, Mat_ID) ";	
													$strSQL = $strSQL . " values ('".trim($job)."', '".$Codigo."', '". trim($add). "','" . trim($city). "', '" . trim($state). "', '" . trim($Zip_Code). "', '" . trim($submital). "', '" . trim($estado_submital). "', '" .ConvertDateToMysqlFormat( trim($fecha)). "', ".$Pro_ID.", ".$Mat_ID.")";										
													//echo $strSQL."<br>";												
													$res1=$bd->ejecutar($strSQL); 								
												}
											}
										}
										
									}									
								}
								fclose($file);
								
								$consulta = "SELECT * FROM import ";				 
								$result2=$bd->ejecutar($consulta); 					
								echo "<table border='1' cellspacing='0' cellpadding='0'>";
								while (($row2 = mysqli_fetch_array($result2) ))											
								{						
									$ID = $row2["ID"];	
									$Job = $row2["Job"];				
									$Code = $row2["Code"];				
									$Address = $row2["Address"];				
									$City = $row2["City"];				
									$Zip_Code = $row2["Zip_Code"];				
									$State = $row2["State"];				
									$Submital = $row2["Submital"];				
									$Estado_Submital = $row2["Estado_Submital"];	
									$Fecha = $row2["Fecha"];	
									
									echo "<tr><td>$Code</td><td>$Job</td><td>$Address</td><td>$City</td><td>$Zip_Code</td><td>$State</td><td>$Submital</td><td>$Estado_Submital</td><td>$Fecha</td><td><input type='checkbox' checked='checked' value='$ID' id='Imp_ID' /></td></tr>";				
								}			
								mysqli_free_result($result2);								
								echo "</table>";
							}
						?>
							<div id="Div_Importar_Resultado" name="Div_Importar_Resultado">							
								<input type="button" value="Execute Import" onclick="importar();" />
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