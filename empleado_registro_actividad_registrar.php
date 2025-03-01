
<?php	 		

	session_name("Administrador");
	session_start();
	if ($_SESSION["EntityID"] == "")
	{
		header("Location:sessionexpired.php"); 	
	}	
	echo "empleado_registro_actividad_registrar under www";	
	require('Library/Control_Cache.php');
	require('Library/Open_Conexion.php');
	require('Library/funciones.php');				         					  		

	$Reg_ID=$_GET["Reg_ID"];
	$Empleado_ID=$_SESSION["Empleado_ID"];	
	
	$Task_ID_1=$_GET["Task_ID_1"];
	echo "  Task ID1:".$Task_ID_1;
	$Horas_Contract_1=$_GET["Horas_Contract_1"];
	$Horas_TM_1=$_GET["Horas_TM_1"];
	$Detalle_1=$_GET["Detalle_1"];
	$RDA_ID_1=$_GET["RDA_ID_1"];	
	echo $RDA_ID_1." RDAid 1 <br>";
	
	$Task_ID_2=$_GET["Task_ID_2"];
	echo "  Task ID2:".$Task_ID_2;
	$Horas_Contract_2=$_GET["Horas_Contract_2"];
	$Horas_TM_2=$_GET["Horas_TM_2"];
	$Detalle_2=$_GET["Detalle_2"];
	$RDA_ID_2=$_GET["RDA_ID_2"];		
	echo $RDA_ID_2." RDAid 2 <br>";
	
	$Task_ID_3=$_GET["Task_ID_3"];
	echo "  Task ID3:".$Task_ID_3;
	$Horas_Contract_3=$_GET["Horas_Contract_3"];
	$Horas_TM_3=$_GET["Horas_TM_3"];
	$Detalle_3=$_GET["Detalle_3"];
	$RDA_ID_3=$_GET["RDA_ID_3"];
	echo $RDA_ID_3." RDAid 3 <br>";
	
	$Date_Work=$_SESSION["Date_Work"];
	//echo "RDA_id_3: ".$RDA_ID_3;
	//time_sleep_until(time()+5);	
	
/*	if ( $Reg_ID==-1)
	{
		$strSQL = "INSERT INTO registro_diario (Empleado_ID,  Fecha, Pro_ID) ";	
		$strSQL = $strSQL . " values (".$Empleado_ID.", CURDATE(),".$_SESSION["Pro_ID"].")";
		echo "empregactreg:".$strSQL;		
		$result2=$bd->ejecutar($strSQL);
		
		$sql = "SELECT Reg_ID FROM registro_diario ORDER BY Reg_ID DESC";														
		$result=$bd->ejecutar($sql); 		
		if (($row = mysqli_fetch_array($result) ))	
		{									
			$Reg_ID=$row["Reg_ID"];
		}
		mysqli_free_result($result);				
	} */
	
	//if ( ($Task_ID_1!=-1) && (Horas_TM_1>0) && (Horas_TM_1<10) )
	if ( $Task_ID_1!=-1)
	//if(1==1)
	{
		if ($RDA_ID_1==-1)
		{	
			$strSQL = "INSERT INTO registro_diario_actividad (Reg_ID, Task_ID, Horas_Contract, Horas_TM, Detalles) ";	
			$strSQL = $strSQL . " values (".$Reg_ID.",".$Task_ID_1.",'".$Horas_Contract_1."','".$Horas_TM_1."','".$Detalle_1."')";	
			$result2=$bd->ejecutar($strSQL);
			echo "<br> 1 :".$strSQL."<br>";
			mysqli_free_result($result2);
			//time_sleep_until(time()+10);			 
		}
		else
		{
			$strSQL = "UPDATE registro_diario_actividad  SET Task_ID=".$Task_ID_1.", Horas_Contract='".$Horas_Contract_1."', Horas_TM='".$Horas_TM_1."', Detalles='".$Detalle_1."'";	
			$strSQL = $strSQL . " WHERE RDA_ID=".$RDA_ID_1;	
			$result2=$bd->ejecutar($strSQL);
			mysqli_free_result($result2);
		}		
	}
	else
	{
		//$strSQL = "DELETE FROM registro_diario_actividad  ";	
		//$strSQL = $strSQL . " WHERE RDA_ID=".$RDA_ID_1;	
		//$result2=$bd->ejecutar($strSQL);
		//mysqli_free_result($result2);
	}
	
	//if ( ($Task_ID_2!=-1) && (Horas_TM_2>0) && (Horas_TM_2<10) )
	//if(1==1)
	if ( $Task_ID_2!=-1 && $Horas_Contract_2>0 )
	{
		if ($RDA_ID_2==-1)
		{
			$strSQL = "INSERT INTO registro_diario_actividad (Reg_ID, Task_ID, Horas_Contract, Horas_TM, Detalles) ";	
			$strSQL = $strSQL . " values (".$Reg_ID.",".$Task_ID_2.",'".$Horas_Contract_2."','".$Horas_TM_2."','".$Detalle_2."')";	
			$result2=$bd->ejecutar($strSQL); 		
			//echo "2:".$strSQL."<br>"; 
			//time_sleep_until(time()+5);
			mysqli_free_result($result2);			
		}
		else
		{
			$strSQL = "UPDATE registro_diario_actividad  SET Task_ID=".$Task_ID_2.", Horas_Contract='".$Horas_Contract_2."', Horas_TM='".$Horas_TM_2."', Detalles='".$Detalle_2."'";	
			$strSQL = $strSQL . " WHERE RDA_ID=".$RDA_ID_2;	
			$result2=$bd->ejecutar($strSQL);
			mysqli_free_result($result2);
		}
	}
	else
	{
		//$strSQL = "DELETE FROM registro_diario_actividad  ";	
		//$strSQL = $strSQL . " WHERE RDA_ID=".$RDA_ID_2;	
		//$result2=$bd->ejecutar($strSQL);
		//mysqli_free_result($result2);
	}
	
	
	if ( $Task_ID_3!=-1 && $Horas_Contract_3>0)
	{
		if ($RDA_ID_3==-1)
		{
			$strSQL = "INSERT INTO registro_diario_actividad (Reg_ID, Task_ID, Horas_Contract, Horas_TM, Detalles) ";	
			$strSQL = $strSQL . " values (".$Reg_ID.",".$Task_ID_3.",'".$Horas_Contract_3."','".$Horas_TM_3."','".$Detalle_3."')";	
			$result2=$bd->ejecutar($strSQL); 
			//echo "3 :".$strSQL."<br>"; 	
			//time_sleep_until(time()+5);
			mysqli_free_result($result2);		
		}
		else
		{
			$strSQL = "UPDATE registro_diario_actividad  SET Task_ID=".$Task_ID_3.", Horas_Contract='".$Horas_Contract_3."', Horas_TM='".$Horas_TM_3."', Detalles='".$Detalle_3."'";	
			$strSQL = $strSQL . " WHERE RDA_ID=".$RDA_ID_3;	
			$result2=$bd->ejecutar($strSQL);
			mysqli_free_result($result2);
		}
	}
	else
	{
		$strSQL = "DELETE FROM registro_diario_actividad  ";	
		$strSQL = $strSQL . " WHERE RDA_ID=".$RDA_ID_3;	
		$result2=$bd->ejecutar($strSQL);
		mysqli_free_result($result2);
	}
	
	/// encuentra actividad Id
	$sql = "SELECT rda.Reg_ID,rd.Actividad_ID FROM registro_diario_actividad rda INNER JOIN registro_diario rd on rd.Reg_ID=rda.Reg_ID WHERE rd.Reg_ID=".$Reg_ID." AND rd.Empleado_ID=".$Empleado_ID." AND rd.Fecha='".$Date_Work."'";														
	$result89=$bd->ejecutar($sql); 
	echo $sql."<br>";
	if (($row89 = mysqli_fetch_array($result89) ))	
		{									
			$Actividad_ID=$row89["Actividad_ID"];
		}
		else
		    $Actividad_ID=0;
		mysqli_free_result($result89);
	//// fin actividad id
	
	
	$sql = "SELECT SUM(Horas_Contract) AS Horas_Contract, SUM(Horas_TM) AS Horas_TM FROM registro_diario_actividad rda INNER JOIN registro_diario rd on rd.Reg_ID=rda.Reg_ID WHERE rd.Reg_ID=".$Reg_ID." AND rd.Empleado_ID=".$Empleado_ID." AND rd.Fecha='".$Date_Work."'";														
	$result89=$bd->ejecutar($sql); 
	//echo $sql."<br>";
	
	////////////
		$Horas_Contract=0;
		$Horas_TM=0;
		$Nota=" P.STP-TimeCard ";		
		if (($row89 = mysqli_fetch_array($result89) ))	
		{									
			$Horas_Contract=$row89["Horas_Contract"];
			$Horas_TM=$row89["Horas_TM"];
		}
		else
			{
			$Horas_Contract=0;
			$Horas_TM=0;	
			}
		mysqli_free_result($result89);
		//echo "hgh ".$Horas_Contract.'<br>';
		if ($Horas_Contract==0)
			{
			$Nota=" STP-TimeCard/No show up to the field/";
			$Horas_Contract=0;
			$Horas_TM=0;
			}
	
			$strSQL = "UPDATE actividad_personal SET HContract=".$Horas_Contract.", HTM=".$Horas_TM.", Note=CONCAT(Note,'".$Nota."') WHERE Empleado_ID=".$Empleado_ID." AND Actividad_ID=".$Actividad_ID;	
echo $strSQL."<br>";
		$result89=$bd->ejecutar($strSQL);
		mysqli_free_result($result89);

	if ($result2)
	{
		echo "Succesfull// Recorded OK!";
		//cierra ventana 
		echo "<img src='images/spacer.gif' onload=\"$('#basic-modal-content-espera').dialog('close')\" />";	
	}
	else
		echo "! Error recording ! ";

	require('Library/Close_Conexion.php');	

?>