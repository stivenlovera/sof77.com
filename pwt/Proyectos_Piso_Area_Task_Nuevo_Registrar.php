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

	

	

/*	$consulta = "SELECT LEFT(Nombre, 15) AS Area_Ini FROM area_control WHERE Area_ID=".$Area_ID;				

	$result2=$bd->ejecutar($consulta); 	

	while (($row2 = mysqli_fetch_array($result2) ))							

	{		

		$Area_Ini = $row2["Area_Ini"];

	}

	mysqli_free_result($result2);	*/	
	$lar=strlen($Num_Act);
	if ($lar<8 && $lar>3)
		$Num_Act="      ".$Num_Act;
	if 	($lar<3)
		$Num_Act=$ActAre." ".$ActTas;

	$strSQL = "INSERT INTO task (Tas_IDT,Pro_ID, Floor_ID, Area_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje, NumAct,ActAre,ActTas, Precio_Unitario ) ";	

	//$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",".$Area_ID.",'" .$Area_Ini."/". $Nombre . "','" . $Horas_Estimadas. "','" . $Material_Estimado. "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje."','". $Num_Act. "','". $Precio_Unitario. "')";		

$strSQL = $strSQL . " values ('".$Num_Act."',".$Pro_ID.",".$Floor_ID.",".$Area_ID.",'" . $Nombre . "','" . $Horas_Estimadas. "','" . $Material_Estimado. "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje."','". $Num_Act. "','". $ActAre. "','". $ActTas. "','". $Precio_Unitario. "')";		

	//echo $strSQL."<br>";				

	$res1=$bd->ejecutar($strSQL);  		

	if ($res1)

	{

		echo "Saved"; 	

		//echo "<img src='images/spacer.gif' onload='Proyectos_Piso_Lista();' />"; 	

	}

	else

		echo "ERROR";



	

	require('Library/Close_Conexion.php');	

?>