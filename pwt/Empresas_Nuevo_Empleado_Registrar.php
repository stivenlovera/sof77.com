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
	//echo $Fecha_Contratacion."<br> ";	
	$Fecha_Contratacion=ConvertDateToMysqlFormat($Fecha_Contratacion);
	
	$strSQL = "INSERT INTO personal (Emp_ID, Nombre, Apellido_Paterno, Apellido_Materno, Nick_Name, Estado, Ciudad, Zip_Code, Calle, Numero, Telefono, Celular, email, Cargo, Numero_Seguro_Social, Fecha_Nacimiento, Numero_Licencia_Conducir, Numero_Permiso_Trabajo, Fecha_Expiracion_Trabajo, Numero_Residente, Aux1, Aux2, Aux3, Aux4, Aux5, Usuario, Password, P1, P2, P3, R1, R2, R3,Fecha_Contratacion ) ";	
	$strSQL = $strSQL . " values (".$Emp_ID.",'" . $Nombre . "','" . $Apellido_Paterno. "','" . $Apellido_Materno. "','" . $Nick_Name. "','" . $Estado. "','" . $Ciudad . "','" . $Zip_Code. "','" . $Calle. "','" . $Numero . "','" . $Telefono . "','" . $Celular . "','" . $email . "','" . $Cargo. "','" .$Numero_Seguro_Social. "','" . ConvertDateToMysqlFormat($Fecha_Nacimiento). "', '" . $Numero_Licencia_Conducir. "', '" . $Numero_Permiso_Trabajo. "', '" . ConvertDateToMysqlFormat($Fecha_Expiracion_Trabajo). "', '" . $Numero_Residente. "', '" . $Aux1. "', '" . $Aux2. "', '" . $Aux3. "', '" . $Aux4. "', '" . $Aux5. "','" . $User. "','" . $Password. "','" . $q1. "', '" . $q2. "','" . $q3. "','" . $a1. "','" . $a2. "','" . $a3. "','".$Fecha_Contratacion."')";		
	//echo $strSQL."<br>";
	//echo $Fecha_Contratacion;				
	//exit ();
	$res1=$bd->ejecutar($strSQL);  		
	
	if ($res1)
		echo "Saved"; 	
	else
		echo "ERROR";

	
	require('Library/Close_Conexion.php');	
?>
	<img src='images/spacer.gif' onload='Empresas_Lista_Empleados(<?php echo $Emp_ID;?>);' />