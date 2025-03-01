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
		require('funciones_php/Actividades.php');

	$id=$_POST['id'];
	$data  = explode("-",$_POST['id']);
	
	$campo = $data[0]; // nombre del campo
	$Pro_ID = $data[1]; // nombre del campo
	$Empleado_ID = $data[2]; // nombre del campo
	$Actividad_ID = $data[3]; // nombre del campo		
	
	$value = $_POST['value']; 
	$note=" ";
	if ($campo == "HContract" and $value == 0)
		{
			$note=",Note='He did not show up'";
		}
		else
		 if ($campo == "HContract")
			$note=",Note='G.H.S.UP'";
		

	$strSQL = "UPDATE actividad_personal SET ".$campo."='".$value."'".$note." WHERE Actividad_ID=".$Actividad_ID." AND Empleado_ID=".$Empleado_ID;					
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		echo $value;
		$consulta = "select * FROM actividad_personal WHERE Actividad_ID=".$Actividad_ID." AND Empleado_ID=".$Empleado_ID;
		$result2=$bd->ejecutar($consulta); 	
		while (($row2 = mysqli_fetch_array($result2) ))							
		{		
			$HContract = $row2["HContract"];
			$HTM = $row2["HTM"];
			$note=$row2["Note"];
		}
		mysqli_free_result($result2);		
		$Total=$HContract +	$HTM;
		
?>
		<img src="images/spacer.gif" onload="Atividades_Reporte_Diario_Personal_Respuesta( '<?php echo $id; ?>', <?php echo $Pro_ID; ?>, <?php echo $Empleado_ID; ?>,<?php echo $Actividad_ID; ?>, <?php echo $value; ?>, <?php echo $Total; ?>);" width="1" height="1" /> 
<?php


		
	}
	else
		echo "ERROR";	
		
	require('Library/Close_Conexion.php');	
?>	
