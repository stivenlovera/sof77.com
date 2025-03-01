<?php	 		
	session_name("Administrador");
	session_start();		
			
	require('Library/Control_Cache.php');	
	require('Library/Open_Conexion.php');	
	require('Library/funciones.php');	
	
	
	
		$consulta = "SELECT ap.Empleado_ID,ap.Actividad_ID,a.Fecha,a.Actividad_ID,rd.Actividad_Id,rd.Reg_ID as rdRegID,rda.Reg_ID as rdaRegID,a.Pro_ID,ap.HContract,ap.Note FROM `actividad_personal` ap join actividades a on a.Actividad_ID=ap.Actividad_ID left join registro_diario rd on a.Actividad_ID=rd.Actividad_Id and rd.Empleado_ID=ap.Empleado_ID left join registro_diario_actividad rda on rd.Reg_ID=rda.Reg_ID where a.Fecha>'2021-04-25' and (rd.Reg_ID IS NULL OR rda.Reg_ID IS NULL ) and a.Pro_ID=1710";
		echo $consulta."<br>";	
		exit ();
		$result2=$bd->ejecutar($consulta); 	
		while (($row2 = mysqli_fetch_array($result2) ))							
		{	
			$Empleado_ID = $row2["Empleado_ID"];
			$Actividad_ID =$row2["Actividad_ID"];
			$Pro_ID =$row2["Pro_ID"];
			$Fecha=$row2["Fecha"];
			$HContract=	$row2["HContract"];		
			$Note=	$row2["Note"];	
			$rdRegID=$row2["rdRegID"];
			$rdaRegID=$row2["rdaRegID"];
			echo $Empleado_ID,"emp ID"."<br>";
			//exit();
			////////////////////
			//record in registro_diario 
			if ($rdRegID==NULL)
	   {
		
			$strSQL = "INSERT INTO registro_diario (Empleado_ID, Actividad_ID,Pro_ID,Fecha) ";	
			$strSQL = $strSQL . " values (" . $Empleado_ID . ", " . $Actividad_ID . ",".$Pro_ID.",'".$Fecha. "')";		
	echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  	
	
	
		$consulta = "SELECT Reg_ID FROM registro_diario WHERE Actividad_ID=".$Actividad_ID." AND	Empleado_ID=".$Empleado_ID." AND Pro_ID=".$Pro_ID." AND	Fecha ='".$Fecha."'";			
		$result3=$bd->ejecutar($consulta); 
		echo $consulta."<br>";	
		while (($row3 = mysqli_fetch_array($result3) ))							
		{	
			$Reg_ID = $row3["Reg_ID"];	
		}
		mysqli_free_result($result3);
	}
	    else
			$Reg_ID=$rdRegID;
			
		if ($rdaRegID==NULL)
		{
	
		$strSQL = "INSERT INTO registro_diario_actividad (Reg_ID) ";	
		$strSQL = $strSQL . " values (".$Reg_ID.")";		
		$res1=$bd->ejecutar($strSQL);  	
		echo $strSQL."<br>";
		}
				
		}
		mysqli_free_result($result2);
	
	
	require('Library/Close_Conexion.php');	
?>