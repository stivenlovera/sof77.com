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

	$Fecha_Inicio_Proyecto=ConvertDateToMysqlFormat($Fecha_Inicio_Proyecto);
	$Fecha_Fin_Proyecto=ConvertDateToMysqlFormat($Fecha_Fin_Proyecto);
if ($MilPay==0) $MilNote="";	
if ($ParkHel==0) $ParkNote="";

	$strSQL = "UPDATE proyectos SET  UpdateH='".$UpdateH."',Report_P_Done='".$Per_Done."',Emp_ID='".$Emp_ID."', Codigo='".$Codigo."', Nombre='".$Nombre."', Tipo_ID='".$Tipo_ID."', Estatus_ID='".$Estatus_ID."', Estado='".$Estado."', Ciudad='".$Ciudad."', Zip_Code='".$Zip_Code."', Calle='".$Calle."', Numero='".$Numero."', Fecha_Inicio='".$Fecha_Inicio_Proyecto."', Fecha_Fin='".$Fecha_Fin_Proyecto."', Horas='".$Horas."', Precio='".$Precio."', Project_Manager_ID='".$Project_Manager_ID."', Coordinador_Obra_ID='".$Coordinador_Obra_ID."', Foreman_ID='".$Foreman_ID."', Lead_ID='".$Lead_ID."', Coordinador_ID='".$Coordinador_ID."', Adi1='".$Co1."', Adi2='".$Co2."', Adi3='".$Co3."', Adi4='".$Co4."', Adi5='".$Co5."',Notes='".$Notes."',emails='".$Emails."', Manager_ID='".$Manager_ID."',Codigo_Bono='".$Codigo_Bono."', Monto_Bono='".$Monto_Bono."', Bono_General='".$Bono_General.  "', Miles_Pay='".$MilPay."',Miles_Note='".$MilNote."',Park_Help='".$ParkHel."', Park_Note='".$ParkNote."', Asistant_Proyect_ID='".$Asistant_Proyect_ID."' WHERE Pro_ID=".$Pro_ID;	

  

	//echo $strSQL."<br>";				
	//exit ();
	$res1=$bd->ejecutar($strSQL);  		

	if ($res1)

	{
		echo "Saved-:"; 			

	}

	else

	{

		echo "ERROR";

	}

	

	require('Library/Close_Conexion.php');	

?>

	<img src='images/spacer.gif' onload='Empresas_Lista_Proyectos(<?php echo $Emp_ID_Ant;?>);' />