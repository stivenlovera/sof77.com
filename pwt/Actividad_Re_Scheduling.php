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

	

	$Pro_ID=$_GET['Pro_ID'];	

	$Actividad_ID=$_GET['Actividad_ID'];

	

	$consulta = "select * FROM actividades WHERE Actividad_ID=".$Actividad_ID;

	$result2=$bd->ejecutar($consulta); 	

	while (($row2 = mysqli_fetch_array($result2) ))							

	{		

		$Fecha = $row2["Fecha"];

	}

	mysqli_free_result($result2);	

	

	$Fecha_Sugerida=date('Y-m-d');

	$es_dia_habil=false;	

	while (	!($es_dia_habil) )

	{

		$consulta = "select DATE_ADD('".$Fecha_Sugerida."', INTERVAL 1 DAY) as Fecha_Sugerida ";

		$result2=$bd->ejecutar($consulta); 	

		if (($row2 = mysqli_fetch_array($result2) ))						

		{		

			$Fecha_Sugerida = $row2["Fecha_Sugerida"];

			$es_dia_habil=Es_Dia_Habil($Fecha_Sugerida, $bd);

		}

		mysqli_free_result($result2);	

	}

?>

<fieldset>

	<legend>Re Scheduling</legend> 	

	<form id="Form_Re_Scheduling" name="Form_Re_Scheduling">

		<input name="Fecha_Schedule" type="text" id="Fecha_Schedule" size="20" datepicker="true" datepicker_format="MM-DD-YYYY" value="<?php echo FormatDateTime($Fecha_Sugerida,6) ;?>" />	

		<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Schedule"));' />

		<input name="Pro_ID" type="hidden" id="Pro_ID" size="20" value="<?php echo $Pro_ID;?>" />

		<input name="Actividad_ID" type="hidden" id="Actividad_ID" size="20" value="<?php echo $Actividad_ID;?>" />

		

		<div id="Div_Res_Res_Scheduling">

			<input type="button" name="Btn_Re_Scheduling" type="Btn_Re_Scheduling" value="Re scheduling" onclick="Actividad_Re_Scheduling_Registrar();" />

		</div>

	</form>

</fieldset>

<?php

	require('Library/Close_Conexion.php');	

?>