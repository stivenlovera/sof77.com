<?php	 		

	session_name("Administrador");

	session_start();		

	if ($_SESSION["EntityID"] == "")

	{

		header("Location:sessionexpired.php"); 	

	}	 			

	require('Library/Control_Cache.php');

	require('Library/Open_Conexion.php');

	

	$Pro_ID=$_GET['Pro_ID'];

	$NumAct=$_GET['NumAct'];

	

	$consulta = "SELECT * FROM task WHERE Pro_ID=".$_GET['Pro_ID'];		

	echo $consulta."<br>";

	$contador=1;	 	  	 	  	  



	$result2=$bd->ejecutar($consulta); 	

	while (($row2 = mysqli_fetch_array($result2) ))							

	{			

		$Nombre = $row2["Nombre"];

		//$Horas_Estimadas = $row2["Horas_Estimadas"];	

		//$Material_Estimado = $row2["Material_Estimado"];

		//$Aux1 = $row2["Aux1"];			

		//$Aux2 = $row2["Aux2"];

		//$Aux3=$row2["Aux3"];

		//$Aux4=$row2["Aux4"];

		//$Aux5=$row2["Aux5"];

		//$Aux6=$row2["Aux6"];

		$Porcentaje=$row2["Porcentaje"];

		$NumAct=$row2["NumAct"];

	}

	mysqli_free_result($result2);

	echo "NUMact:".$NumAct."...".$Nombre."Nombreee";			

?> 





<?php

	require('Library/Close_Conexion.php');

?>

