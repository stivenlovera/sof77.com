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
	
	$strSQL = "UPDATE floor SET Flo_IDT='".$Flo_IDT."',Nombre='".$Nombre."', Horas_Estimadas='".$Horas_Estimadas."', Material_Estimado='".$Material_Estimado."', Aux1='".$Aux1."', Aux2='".$Aux2."', Aux3='".$Aux3."', Aux4='".$Aux4."', Aux5='".$Aux5."', Aux6='".$Aux6."', Porcentaje='".$Porcentaje."' WHERE Floor_ID=".$Floor_ID;	
			
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		echo "Saved"; 	
		echo "<img src='images/spacer.gif' onload='Proyectos_Piso_Lista(".$Pro_ID.");' />"; 
	}
	else
		echo "ERROR";

	
	require('Library/Close_Conexion.php');	
?>