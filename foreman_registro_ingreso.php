
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
	include ("hora.php");				         					  	
/*//  
	function hora_va(&$fecha,&$horas)
	{
	$utctime=gmdate("H:i:s",time());
	$horas = date('H:i:s', strtotime ($utctime.' -300 minutes'));
	echo "//".$horas."//";
	$f1=date('d/m/Y', '03/11/2018');		
	$f2=date('d/m/Y', '10/03/2019');
//	echo $f1."///--/".$f2;
	if ($fecha > $f1 && $fecha < $f2)
				{
					$horas = date('H:i:s', strtotime ($utctime.' -300 minutes'));
	echo "//".$horas."/final/";
				}
	}
			
///*/
	
	$Empleado_ID=$_SESSION["Empleado_ID"];
	$Date_Work=$_SESSION["Date_Work"];	
	$Actividad_ID=$_SESSION["Actividad_ID"];
	$Date_Hoy= date('Y-m-d');
	$Hora_Real =gmdate("H:i:s",time());
	hora_actual($Date_Work,$Hora_Real);
//	$utctime=gmdate("H:i:s",time());
//	$Hora_Real = date('H:i:s', strtotime ($utctime.' -300 minutes'));
	

	$strSQL = "INSERT INTO registro_diario (Empleado_ID, Hora_Ingreso, Fecha, Pro_ID, Actividad_ID,Fecha_Hingreso) ";	
	//$strSQL = $strSQL . " values (".$Empleado_ID.",UTC_TIME(), CURDATE())";	
	$strSQL = $strSQL . " values (".$Empleado_ID.",'".$Hora_Real."','".$Date_Work."',".$_SESSION["Pro_ID"].",".$Actividad_ID."'".$Date_Hoy."')";	
	$result2=$bd->ejecutar($strSQL); 
	echo " forreging 1:".$strSQL;
	if ($result2)
		echo "Registro de Ingreso Satisfactorio.";
	else
		echo "Error en Registro";
?>

	

<?php
	require('Library/Close_Conexion.php');	

?>