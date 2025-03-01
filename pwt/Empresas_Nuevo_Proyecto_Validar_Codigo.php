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
	
	$Codigo=$_GET['Codigo'];	
	$consulta = "SELECT * FROM proyectos WHERE Codigo='".$_GET['Codigo']."' ";		
	
	if ( $_GET['Pro_ID'] != ""  )
		$consulta = $consulta." AND Pro_ID<>'".$_GET['Pro_ID']."' ";  
	//echo $consulta."<br>";

	$result2=$bd->ejecutar($consulta); 	
	if (($row2 = mysqli_fetch_array($result2) ))							
	{		
		$Resp="This Code already in use";
	}
	else
	{
		$Resp="OK";
	}	
	mysqli_free_result($result2);
	require('Library/Close_Conexion.php');	
?>
<img src='images/spacer.gif' onload='$("#Div_Validar_Codigo").html("<?php echo $Resp; ?>");' width='1' height='1' /> 