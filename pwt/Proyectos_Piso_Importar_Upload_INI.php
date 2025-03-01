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

								while(!feof($file))
								{										
									list($Codigo, $Nombre, $horas_estimadas, $material_estimando, $Numero_unidades, $Notas) = explode("!", fgets($file));
									list($Linea, $Codigo) = explode(":", $Codigo);
									echo $Codigo.", ".$Nombre.", ".$horas_estimadas.", ".$material_estimando.", ".$Numero_unidades.", ".$Notas."<br>";
									//echo "Llego<br>";	
									//$submital=trim($submital); 
									//$submital=str_replace("'","\'",$submital);
									if ($Linea=="NL")
									{								
										$strSQL = "INSERT INTO import_piso (Codigo, Nombre, horas_estimadas, material_estimando, Numero_unidades, Notas) ";	
										$strSQL = $strSQL . " values ('".trim($Codigo)."', '".$Nombre."', '". trim($horas_estimadas). "','" . trim($material_estimando). "', '" . trim($Numero_unidades). "', '" . trim($Notas). "')";										
										echo $strSQL."<br>";												
										$res1=$bd->ejecutar($Codigo); 
										
										if (strlen($Codigo)==2)
										{
											$strSQL = "INSERT INTO edificios (Nombre, Horas_Estimadas, Material_Estimado,Porcentaje,Pro_ID, Aux1, Aux2 ) ";	
											$strSQL = $strSQL . " values ('".trim($Codigo).$Nombre."',". $horas_estimadas.",".$material_estimando.",0,".$Pro_ID.",'','')";		
											echo " edificios: ".$strSQL."<br>";														
											$res1=$bd->ejecutar($strSQL); 
										}
										else
										
										  if (strlen($Codigo)==4)
										   {
												$consulta = "SELECT Edificio_ID FROM edificios WHERE Pro_ID=".$Pro_ID." AND LEFT(Nombre,2)=LEFT('".$Codigo."', 2) ";											
												echo " edificios codigo: ".$consulta."<br>";
												$result2=$bd->ejecutar($consulta); 										
												while (($row2 = mysqli_fetch_array($result2) ))																
												{	
													$Edificio_ID = $row2["Edificio_ID"];

													$strSQL = "INSERT INTO floor (Pro_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje,Edificio_ID ) ";	
												$strSQL = $strSQL . " values (".$Pro_ID.",'".trim($Codigo).$Nombre ."',". $horas_estimadas. ",".$material_estimando.",0,0,0,'','','',0,".$Edificio_ID.")";		
												echo "Floor : ".$strSQL."<br>";														
												$res1=$bd->ejecutar($strSQL); 
												}
												mysqli_free_result($result2);	
												
											///
											
										}
										else
										{
											if (strlen($Codigo)==6)
											{
												$consulta = "SELECT Floor_ID FROM floor WHERE Pro_ID=".$Pro_ID." AND LEFT(Nombre,4)=LEFT('".$Codigo."', 4) ";											
												$result2=$bd->ejecutar($consulta); 										
												while (($row2 = mysqli_fetch_array($result2) ))																
												{	
													$Floor_ID = $row2["Floor_ID"];
													$strSQL = "INSERT INTO area_control (Pro_ID, Floor_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje ) ";	
													$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",'" .trim($Codigo).$Nombre . "','" . $horas_estimadas. "','" . $material_estimando . "','" . $Numero_unidades. "','','','" . $Notas. "','','', '')";		
													//echo $strSQL."<br>";														
													$res1=$bd->ejecutar($strSQL); 											
												}
												mysqli_free_result($result2);	
											}
											else
											{
												if (strlen($Codigo)==8)
												{
													$consulta = "SELECT Floor_ID, Area_ID FROM area_control WHERE Pro_ID=".$Pro_ID." AND LEFT(Nombre, 6)=LEFT('".$Codigo."', 6) ";											
													$result2=$bd->ejecutar($consulta); 										
													while (($row2 = mysqli_fetch_array($result2) ))																
													{	
														$Floor_ID = $row2["Floor_ID"];
														$Area_ID = $row2["Area_ID"];
														
														$strSQL = "INSERT INTO task (Pro_ID, Floor_ID, Area_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje ) ";	
														$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",".$Area_ID.",'" . trim($Codigo).$Nombre . "','" . $horas_estimadas. "','" . $material_estimando . "','" . $Numero_unidades. "','','','" . $Notas. "','','', '')";		
														//echo $strSQL."<br>";														
														$res1=$bd->ejecutar($strSQL); 											
													}
													mysqli_free_result($result2);
												}
											}
										}
									}
								}
								fclose($file);
								
								$consulta = "SELECT * FROM import_piso ";				 
								$result2=$bd->ejecutar($consulta); 					
								echo "<table border='1' cellspacing='0' cellpadding='0'>";
								while (($row2 = mysqli_fetch_array($result2) ))											
								{						
									$ID = $row2["ID"];	
									$Codigo = $row2["Codigo"];				
									$Nombre = $row2["Nombre"];				
									$horas_estimadas = $row2["horas_estimadas"];				
									$material_estimando = $row2["material_estimando"];				
									$Numero_unidades = $row2["Numero_unidades"];				
									$Notas = $row2["Notas"];													
									
									echo "<tr><td>$Codigo</td><td>$Nombre</td><td>$horas_estimadas</td><td>$material_estimando</td><td>$Numero_unidades</td><td>$Notas</td></tr>";				
								}			
								mysqli_free_result($result2);								
								echo "</table>";
							}
						?>
							<div id="Div_Importar_Resultado" name="Div_Importar_Resultado">							
								OK ok
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