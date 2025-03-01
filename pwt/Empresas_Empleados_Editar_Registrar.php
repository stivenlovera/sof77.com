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
	
	$strSQL = "UPDATE personal SET Nombre='".$Nombre."', Apellido_Paterno='".$Apellido_Paterno."', Apellido_Materno='".$Apellido_Materno."', Nick_Name='".$Nick_Name."', Estado='".$Estado."', Ciudad='".$Ciudad."', Zip_Code='".$Zip_Code."', Calle='".$Calle."', Numero='".$Numero."', Telefono='".$Telefono."', Celular='".$Celular."'  ,email='".$email."' ,Cargo='".$Cargo."', Numero_Seguro_Social='".$Numero_Seguro_Social."', Fecha_Nacimiento='".ConvertDateToMysqlFormat($Fecha_Nacimiento)."', Numero_Licencia_Conducir='".$Numero_Licencia_Conducir."', Numero_Permiso_Trabajo='".$Numero_Permiso_Trabajo."', Fecha_Expiracion_Trabajo='".ConvertDateToMysqlFormat($Fecha_Expiracion_Trabajo)."',Fecha_Contratacion='".ConvertDateToMysqlFormat($Fecha_Contratacion)."', Numero_Residente='".$Numero_Residente."', Aux1='".$Aux1."', Aux2='".$Aux2."', Aux3='".$Aux3."', Aux4='".$Aux4."', Aux5='".$Aux5."', Usuario='".$User."', Password='".$Password."', P1='".$q1."', P2='".$q2."', P3='".$q3."', R1='".$a1."', R2='".$a2."', R3='".$a3."', Indice_produccion='".$Indice_produccion."', Nro_Bono='".$codbon."', Spec_Bon1='".$spebon."', Not_Bon='".$notbon."', Not_Bon='".$notbon."', Extra_Mon1='".$extra_mon."', Benefit1='".$benefitA."', Extra_Mon2='".$extra_mon2."', Benefit2='".$benefitB."' WHERE Empleado_ID=".$Empleado_ID;
	
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		echo "Saved";
		echo "<img src='images/spacer.gif' onload='Empresas_Lista_Empleados(".$Emp_ID.");' />";  	
	}
	else
		echo "ERROR";

	
	require('Library/Close_Conexion.php');	
?>