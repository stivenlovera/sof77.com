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
				         					  
	foreach($_POST as $nombre_campo => $valor)
	{
	   	
	   	if  ( !empty($valor )  )
			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";			
		else
			$asignacion = "\$" . $nombre_campo . "='';";			
			
	   	eval($asignacion);
	} 	
	
	$Fecha_Inicio_Proyecto=ConvertDateToMysqlFormat($Fecha_Inicio_Proyecto);
	$Fecha_Fin_Proyecto=ConvertDateToMysqlFormat($Fecha_Fin_Proyecto);
	
	$Horas=$Pro_Horas;
	
	/*$consulta = "SELECT codigo FROM tipo_proyecto WHERE Tipo_ID=".$Tipo_ID; 	 
	$result=$bd->ejecutar($consulta); 
	if (($row = mysql_fetch_array($result) ))							
	{		
		$Codigo = $row["codigo"];	
	}
	mysql_free_result($result);	*/
	
	$strSQL = "INSERT INTO proyectos (Emp_ID, Nombre, Tipo_ID, Estatus_ID, Estado, Ciudad, Zip_Code, Calle, Numero, Fecha_Inicio, Fecha_Fin, Horas, Precio, Project_Manager_ID, Coordinador_Obra_ID, Foreman_ID, Coordinador_ID, Manager_ID ) ";	
	$strSQL = $strSQL . " values (".$Emp_ID.", '" . $Nombre . "'," . $Tipo_ID. "," . $Estatus_ID. ",'" . $Estado. "','" . $Ciudad . "','" . $Zip_Code. "','" . $Calle. "','" . $Numero . "','" . $Fecha_Inicio_Proyecto. "', '". $Fecha_Fin_Proyecto. "', '".$Pro_Horas. "','" . $Precio . "', " . $Project_Manager_ID. ", " . $Coordinador_Obra_ID. ", " . $Foreman_ID. ", " . $Coordinador_ID. ", " . $Manager_ID. ")";		
  
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		if ($Numero_Etapas>0)
		{
			echo "Saved"; 	
			$consulta = "SELECT max(Pro_ID) as Pro_ID FROM proyectos"; 	 
			$result=$bd->ejecutar($consulta); 
			if (($row = mysqli_fetch_array($result) ))							
			{		
				$Pro_ID = $row["Pro_ID"];	
			}
			mysqli_free_result($result);	
			
			//$Codigo=$Pro_ID.".".date(y).".".$Codigo;				
			
			$strSQL = "UPDATE proyectos SET Codigo='".$Codigo."' WHERE Pro_ID=".$Pro_ID;					
			$res1=$bd->ejecutar($strSQL);  
			
			$strSQL = "INSERT INTO floor (Pro_ID, Nombre ) ";	
			$strSQL = $strSQL . " values (".$Pro_ID.",'General Floor')";		
			//echo $strSQL."<br>";				
			$res1=$bd->ejecutar($strSQL);  		
			if ($res1)
			{
				$consulta = "SELECT MAX(Floor_ID) as Floor_ID FROM floor WHERE Pro_ID=".$Pro_ID;	
				$result22=$bd->ejecutar($consulta); 	
				if (($row2 = mysqli_fetch_array($result22) ))							
				{		
					$Floor_ID = $row2["Floor_ID"];
					
					$strSQL = "INSERT INTO area_control (Pro_ID, Floor_ID, Nombre) ";	
					$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",'GF General Area')";		
					//echo $strSQL."<br>";				
					$res1=$bd->ejecutar($strSQL);  		
					if ($res1)
					{
						$consulta = "SELECT MAX(Area_ID) AS Area_ID FROM area_control WHERE Pro_ID=".$Pro_ID. " AND Floor_ID=".$Floor_ID;				
						$result33=$bd->ejecutar($consulta); 	
						if (($row2 = mysqli_fetch_array($result33) ))							
						{		
							$Area_ID = $row2["Area_ID"];
							
							$strSQL = "INSERT INTO task (Pro_ID, Floor_ID, Area_ID, Nombre) ";	
							$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",".$Area_ID.",'GFGA General Task')";		
							//echo $strSQL."<br>";				
							$res1=$bd->ejecutar($strSQL);  	
							
						}
						mysqli_free_result($result33);	
					}					
				}
				mysqli_free_result($result22);		
			}
							
			$strSQL = "INSERT INTO area_control (Pro_ID, Nombre, Note, Aux1, Aux2, Aux3) ";	
			$strSQL = $strSQL . " values (".$Pro_ID.",'General', '','','', '')";					
			$res1=$bd->ejecutar($strSQL);  			
			
			echo "<img src='images/spacer.gif' onload='Empresas_Proyectos_Etapas($Pro_ID);' />"; 
		}
	}
	else
	{
		echo "ERROR";
	}
	
	require('Library/Close_Conexion.php');	
?>
	<input name="Aux_Horas" type="Hidden" id="Aux_Horas" value="<?php echo $Pro_Horas; ?>"/>
	<img src='images/spacer.gif' onload='Empresas_Lista_Proyectos(<?php echo $Emp_ID;?>);' />
	