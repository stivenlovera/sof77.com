
<?php	 		

	session_name("Administrador");
	session_start();
	if ($_SESSION["EntityID"] == "")
	{
		header("Location:sessionexpired.php"); 	
	}	
	echo "empleado Registro act registrar under www/pwt <br>";	
	require('Library/Control_Cache.php');
	require('Library/Open_Conexion.php');
	require('Library/funciones.php');				         					  		
	echo " in empleado_registro_actividad_registrar under pwt";
	$Reg_ID=$_GET["Reg_ID"];
	$Empleado_ID=$_SESSION["Empleado_ID"];	
	
	$Task_ID_1=$_GET["Task_ID_1"];
	$Horas_Contract_1=$_GET["Horas_Contract_1"];
	$Horas_TM_1=$_GET["Horas_TM_1"];
	$Detalle_1=$_GET["Detalle_1"];
	$RDA_ID_1=$_GET["RDA_ID_1"];	
	
	$Task_ID_2=$_GET["Task_ID_2"];
	$Horas_Contract_2=$_GET["Horas_Contract_2"];
	$Horas_TM_2=$_GET["Horas_TM_2"];
	$Detalle_2=$_GET["Detalle_2"];
	$RDA_ID_2=$_GET["RDA_ID_2"];		
	
	$Task_ID_3=$_GET["Task_ID_3"];
	$Horas_Contract_3=$_GET["Horas_Contract_3"];
	$Horas_TM_3=$_GET["Horas_TM_3"];
	$Detalle_3=$_GET["Detalle_3"];
	$RDA_ID_3=$_GET["RDA_ID_3"];
	$Date_Work=$_SESSION["Date_Work"];	
	
	if ( $Reg_ID==-1)
	{
		$strSQL = "INSERT INTO registro_diario (Empleado_ID,  Fecha, Pro_ID) ";	
		$strSQL = $strSQL . " values (".$Empleado_ID.", CURDATE(),".$_SESSION["Pro_ID"].")";		
		$result2=$bd->ejecutar($strSQL);
		
		$sql = "SELECT Reg_ID FROM registro_diario ORDER BY Reg_ID DESC";														
		$result=$bd->ejecutar($sql); 		
		if (($row = mysqli_fetch_array($result) ))	
		{									
			$Reg_ID=$row["Reg_ID"];
		}
		mysqli_free_result($result);				
	}
	
	//if ( ($Task_ID_1!=-1) && (Horas_TM_1>0) && (Horas_TM_1<10) )
	if ( $Task_ID_1!=-1)
	//if(1==1)
	{
		if ($RDA_ID_1==-1)
		{	
			$strSQL = "INSERT INTO registro_diario_actividad (Reg_ID, Task_ID, Horas_Contract, Horas_TM, Detalles) ";	
			$strSQL = $strSQL . " values (".$Reg_ID.",".$Task_ID_1.",'".$Horas_Contract_1."','".$Horas_TM_1."','".$Detalle_1."')";	
			$result2=$bd->ejecutar($strSQL);
			//echo $strSQL."<br>";			 
		}
		else
		{
			$strSQL = "UPDATE registro_diario_actividad  SET Task_ID=".$Task_ID_1.", Horas_Contract='".$Horas_Contract_1."', Horas_TM='".$Horas_TM_1."', Detalles='".$Detalle_1."'";	
			$strSQL = $strSQL . " WHERE RDA_ID=".$RDA_ID_1;	
			$result2=$bd->ejecutar($strSQL);
		}		
	}
	else
	{
		$strSQL = "DELETE FROM registro_diario_actividad  ";	
		$strSQL = $strSQL . " WHERE RDA_ID=".$RDA_ID_1;	
		$result2=$bd->ejecutar($strSQL);
	}
	
	//if ( ($Task_ID_2!=-1) && (Horas_TM_2>0) && (Horas_TM_2<10) )
	//if(1==1)
	if ( $Task_ID_2!=-1)
	{
		if ($RDA_ID_2==-1)
		{
			$strSQL = "INSERT INTO registro_diario_actividad (Reg_ID, Task_ID, Horas_Contract, Horas_TM, Detalles) ";	
			$strSQL = $strSQL . " values (".$Reg_ID.",".$Task_ID_2.",'".$Horas_Contract_2."','".$Horas_TM_2."','".$Detalle_2."')";	
			$result2=$bd->ejecutar($strSQL); 		
			//echo $strSQL."<br>"; 			
		}
		else
		{
			$strSQL = "UPDATE registro_diario_actividad  SET Task_ID=".$Task_ID_2.", Horas_Contract='".$Horas_Contract_2."', Horas_TM='".$Horas_TM_2."', Detalles='".$Detalle_2."'";	
			$strSQL = $strSQL . " WHERE RDA_ID=".$RDA_ID_2;	
			$result2=$bd->ejecutar($strSQL);
		}
	}
	else
	{
		$strSQL = "DELETE FROM registro_diario_actividad  ";	
		$strSQL = $strSQL . " WHERE RDA_ID=".$RDA_ID_2;	
		$result2=$bd->ejecutar($strSQL);
	}
	
	
	if ( $Task_ID_3!=-1)
	{
		if ($RDA_ID_3==-1)
		{
			$strSQL = "INSERT INTO registro_diario_actividad (Reg_ID, Task_ID, Horas_Contract, Horas_TM, Detalles) ";	
			$strSQL = $strSQL . " values (".$Reg_ID.",".$Task_ID_3.",'".$Horas_Contract_3."','".$Horas_TM_3."','".$Detalle_3."')";	
			$result2=$bd->ejecutar($strSQL); 
			//echo $strSQL."<br>"; 			
		}
		else
		{
			$strSQL = "UPDATE registro_diario_actividad  SET Task_ID=".$Task_ID_3.", Horas_Contract='".$Horas_Contract_3."', Horas_TM='".$Horas_TM_3."', Detalles='".$Detalle_3."'";	
			$strSQL = $strSQL . " WHERE RDA_ID=".$RDA_ID_3;	
			$result2=$bd->ejecutar($strSQL);
		}
	}
	else
	{
		$strSQL = "DELETE FROM registro_diario_actividad  ";	
		$strSQL = $strSQL . " WHERE RDA_ID=".$RDA_ID_3;	
		$result2=$bd->ejecutar($strSQL);
	}
	
	$sql = "SELECT SUM(Horas_Contract) AS Horas_Contract, SUM(Horas_TM) AS Horas_TM FROM registro_diario_actividad WHERE Reg_ID IN (SELECT Reg_ID FROM registro_diario WHERE Empleado_ID=".$Empleado_ID." AND Fecha='".$Date_Work."')";														
	$result89=$bd->ejecutar($sql); 
	echo $sql."<br>";
	$Horas_Contract="";
	$Horas_TM="";		
	if (($row89 = mysqli_fetch_array($result89) ))	
	{									
		$Horas_Contract=$row89["Horas_Contract"];
		$Horas_TM=$row89["Horas_TM"];
	}
	mysqli_free_result($result89);
	$strSQL = "UPDATE actividad_personal SET HContract=".$Horas_Contract.", HTM=".$Horas_TM." WHERE Empleado_ID=".$Empleado_ID." AND Actividad_ID IN (SELECT Actividad_ID FROM actividades WHERE Pro_ID=".$_SESSION["Pro_ID"]." AND Fecha='".$Date_Work."') ";	
	$result89=$bd->ejecutar($strSQL);
	//echo $strSQL."<br>";
	
	//echo $strSQL;
	if ($result2)
	{
		echo "Registro Satisfactorio.";
		echo "<img src='images/spacer.gif' onload=\"$('#basic-modal-content-espera').dialog('close')\" />";	
	}
	else
		echo "Error en Registro";

	require('Library/Close_Conexion.php');	

?>