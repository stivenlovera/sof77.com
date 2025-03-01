<?php	 		

	$Pro_ID = $_GET['Pro_ID'];
	$Fecha_Inicio=$_GET['Fecha_Inicio'];
	$Fecha_Inicio=$_GET['Fecha_Inicio'];
	$Fecha_Fin=$_GET['$Fecha_Fin'];
	$Total_Horas=$_GET['Total_Horas'];
	$Horas=$Total_Horas;
	$Nombre=$Pro_ID;
				         					  
	$strSQL="rrrrrrrrrrrrr rrrrrrrrrrrrrrr    etapas ".$Pro_ID."  ".$Fecha_Inicio." Fin:".$Fecha_Fin;

	echo $strSQL."<br>";				

	

	require('Library/Close_Conexion.php');	

?>

	<img src='images/spacer.gif' onload='Empresas_Lista_Proyectos(<?php echo $Emp_ID_Ant;?>);' />