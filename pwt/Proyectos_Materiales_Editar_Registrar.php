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
	
	$Fecha_Registro=ConvertDateToMysqlFormat($Fecha_Registro);
	
	if ($Fecha_Envio!="")
		$Fecha_Envio="'".ConvertDateToMysqlFormat($Fecha_Envio)."'";
	else
		$Fecha_Envio="NULL";
		
	if ($Fecha_Recibido!="")
		$Fecha_Recibido="'".ConvertDateToMysqlFormat($Fecha_Recibido)."'";
	else
		$Fecha_Recibido="NULL";

	if ($Fecha_from_vendor!="")
		$Fecha_from_vendor="'".ConvertDateToMysqlFormat($Fecha_from_vendor)."'";
	else
		$Fecha_from_vendor="NULL";

	if ($Fecha_to_vendor!="")
		$Fecha_to_vendor="'".ConvertDateToMysqlFormat($Fecha_to_vendor)."'";
	else
		$Fecha_to_vendor="NULL";

	if ($Fecha_from_gc!="")
		$Fecha_from_gc="'".ConvertDateToMysqlFormat($Fecha_from_gc)."'";
	else
		$Fecha_from_gc="NULL";

	if ($Fecha_to_gc!="")
		$Fecha_to_gc="'".ConvertDateToMysqlFormat($Fecha_to_gc)."'";
	else
		$Fecha_to_gc="NULL";
		
	$strSQL = "UPDATE materiales SET Denominacion='" . $Denominacion . "', Nombre_Generico='" . $Nombre_Generico . "', Area_donde_va='" . $Area_donde_va . "', Unidad_Medida='" . $Unidad_Medida . "', Cantidad='" . $Cantidad. "', Precio_Unitario='" . $Precio_Unitario . "', Cat_ID=" . $Cat_ID . ", Ven_ID=" . $Ven_ID. ", Fecha_Registro='" . $Fecha_Registro. "', Fecha_Envio=" . $Fecha_Envio. ", Fecha_Recibido=" . $Fecha_Recibido. ", Aux1='" . $Aux1. "', Aux2='" . $Aux2. "', Aux3='" . $Aux3. "' , Fecha_from_vendor=" .$Fecha_from_vendor.", Fecha_to_vendor=" .$Fecha_to_vendor." , note_vendor='" .$note_vendor."' , Fecha_from_gc=" .$Fecha_from_gc." , Fecha_to_gc=" .$Fecha_to_gc." , note_gc='" .$note_gc."'";	
	$strSQL = $strSQL . " WHERE Mat_ID=" . $Mat_ID ;		
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		echo "Update Data"; 	
		echo "<img src='images/spacer.gif' onload='Proyectos_Materiales_Lista($Pro_ID);' />"; 
	}
	else
		echo "ERROR";

	
	require('Library/Close_Conexion.php');	
?>