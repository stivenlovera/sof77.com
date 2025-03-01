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
	
	$strSQL = "UPDATE vendedor SET Codigo='".$Codigo."', Nombre='".$Nombre."', Estado='".$Estado."', Ciudad='".$Ciudad."', Zip_Code='".$Zip_Code."', Calle='".$Calle."', Numero='".$Numero."', Gerente_General='".$Gerente_General."', Telefono='".$Telefono."', Fax='".$Fax."', Web='".$Web."', email='".$email."', Rubro='".$Rubro."', Detalles='".$Detalles."' WHERE Ven_ID=".$Ven_ID;	
			
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