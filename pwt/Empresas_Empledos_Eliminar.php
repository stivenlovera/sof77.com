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

	$Empleado_ID=$_GET['Empleado_ID'];		



	$consulta = "SELECT * FROM proyectos WHERE Project_Manager_ID=".$Empleado_ID." OR Coordinador_Obra_ID=".$Empleado_ID." OR Foreman_ID=".$Empleado_ID." OR Coordinador_ID=".$Empleado_ID." OR Manager_ID=".$Empleado_ID;	

	$result2=$bd->ejecutar($consulta); 	

	if (($row2 = mysqli_fetch_array($result2) ))							

	{

		echo "Not is possible delete. Record  has related tables.";	

	}

	else

	{

		$strSQL = "DELETE FROM personal WHERE Empleado_ID=".$Empleado_ID;	

				

		//echo $strSQL."<br>";				

		$res1=$bd->ejecutar($strSQL);  		

		if ($res1)

		{

			echo "Record Deleted"; 	

			echo "<img src='images/spacer.gif' onload='Empresas_Lista_Empleados($Emp_ID);' />"; 

		}

		else

			echo "ERROR";

	}

	mysqli_free_result($result2);	

	

	require('Library/Close_Conexion.php');	

?>