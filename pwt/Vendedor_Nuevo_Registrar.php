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
	
	$strSQL = "INSERT INTO vendedor (Codigo, Nombre, Estado, Ciudad, Zip_Code, Calle, Numero, Gerente_General, Telefono, Fax, Web, email, Rubro, Detalles ) ";	
	$strSQL = $strSQL . " values ('" . $Codigo . "','" . $Nombre . "','" . $Estado. "','" . $Ciudad . "','" . $Zip_Code. "','" . $Calle. "','" . $Numero . "','" . $Gerente_General. "','" . $Telefono. "','" . $Fax. "', '" . $Web. "','" . $email. "', '" . $Rubro. "', '" . $Detalles. "')";		
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		echo "Saved"; 	
		echo "<img src='images/spacer.gif' onload='Vendedor_Lista();' />"; 
	}
	else
		echo "ERROR";

	
	require('Library/Close_Conexion.php');	
?>