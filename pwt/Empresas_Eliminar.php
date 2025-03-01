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
				         					  
	$Emp_ID=$_GET['Emp_ID'];	
	
	$consulta = "SELECT * FROM proyectos WHERE Emp_ID=".$Emp_ID;	
	$result2=$bd->ejecutar($consulta); 	
	if (($row2 = mysqli_fetch_array($result2) ))							
	{
		echo "Not is possible delete. Company has other  information";	
	}
	else
	{
		$strSQL = "DELETE FROM empresas WHERE Emp_ID=".$Emp_ID;	
				
		//echo $strSQL."<br>";				
		$res1=$bd->ejecutar($strSQL);  		
		if ($res1)
		{
			echo "Deleted"; 	
			echo "<img src='images/spacer.gif' onload='Empresas_Lista();' />"; 
		}
		else
			echo "ERROR";
	}
	mysqli_free_result($result2);	
	
	require('Library/Close_Conexion.php');	
?>