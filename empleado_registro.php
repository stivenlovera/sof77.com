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

	$Empleado_ID=$_SESSION["Empleado_ID"];			
	require('funciones_php/empleado.php');	
	require('funciones_php/foreman.php');
	$Date_Work=$_SESSION["Date_Work"];	
?>

<LINK href="include/Stat.css" type="text/css" rel="stylesheet">
<link rel="STYLESHEET" type="text/css" href="include/estilo_reporte.css">

<LINK href="include/jquery-ui.css" type="text/css" rel="stylesheet">
<LINK href='include/demo.css' type='text/css' rel='stylesheet' media='screen' />
<script type="text/javascript" src="include/jquery-1.9.1.js"></script>
<script type="text/javascript" src="include/jquery-ui.1.10.3.js"></script>
<script type="text/javascript" src="include/iAjax.js"></script>
<script type="text/javascript" src="include/camcanvas.js"></script>

<!--<script type="text/javascript" src="include/jquery-1.3.2.js"></script>-->
<script type="text/javascript" src="include/getAjax.js"></script> 
<script type="text/javascript" src="include/funciones.js"></script>
<script type="text/javascript" src="include/jquery.columnhover.js" ></script>	
<!-- Contact Form CSS files -->

<link type='text/css' href='css/basic.css' rel='stylesheet' media='screen' />
<script type='text/javascript' src='include/jquery.simplemodal.js'></script>
<script type="text/javascript" src="include/datepickercontrol.js"></script>
<link type="text/css" rel="stylesheet" href="css/datepickercontrol.css"/> 
<link href="css/flexigrid.pack.css" type="text/css" rel="stylesheet">	
<script type="text/javascript" src="include/flexigrid.pack.js"></script>
<script type="text/javascript" src="include/jquery.jeditable.js"></script>






<style type="text/css">
	p.MsoNormal {
	margin:0cm;
	margin-bottom:.0001pt;
	font-size:12.0pt;
	font-family:"Times New Roman";
	}
</style>

<style type="text/css">
	<!--
	.style10 {
		color: #FF0000;
		font-size: medium;
	}
	-->
	
	td.betterhover, #tabletwo tbody tr:hover
	{
		background: LightCyan;
	}
</style>

	<div id="div_registro_res">
<?php
	//echo "llego";	
	
	$Reg_ID=-1;
	
	$consulta = "SELECT * FROM registro_diario WHERE Empleado_ID=".$Empleado_ID." AND '".$Date_Work."'=Fecha ";		
	$result2=$bd->ejecutar($consulta); 
	//echo $consulta."<br>"; 
	
	if (($row2 = mysqli_fetch_array($result2) ))							
	{	
		$Reg_ID = $row2["Reg_ID"];		
	}
	
	mysqli_free_result($result2);
	
	echo "<img src='images/spacer.gif' width='16' height='16' onload=\"empleado_registro_actividad(".$Reg_ID.");\"  align='middle'/>";

?>
	</div>
	<div id="div_registro_actividad"></div>
	
	
	
	


<?php



	require('Library/Close_Conexion.php');	



?>