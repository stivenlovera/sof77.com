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

					

	$Subject=$_POST['Subject'];

	$To=$_POST['To'];

	$Cc=$_POST['Cc'];

	$Contenido=$_POST['Contenido'];			

 		

	$cuerpo = '

		<html> 

			<head> 

			   <title>Solicitud de Taxis Para Servicio Funebre</title> 

			</head> 

			<body>'.$Contenido.'</body>

		</html>';

		

		$headers  = "MIME-Version: 1.0\r\n";  

		$headers .= "From: ".$Cc."\n"; 

		$headers .= "Reply-To: ".$Cc."\n";

		$headers .= "Cc: ".$Cc."\n";  		

		//$headers .= "Bcc: cfrias@radiotaxicordial.com, cristian.frias.s@gmail.com\n";  

		$headers .= "X-Priority: 1\n"; 

		$headers .= "X-Mailer: DT Formmail".VERSION."\n";       

		$headers .= "Content-Type: text/html;\n\tcharset=\"iso-8859-1\"\n";      

		

		$destinatario = $To; 

		$asunto = $Subject;     		

		  

		mail($destinatario, $asunto, $cuerpo, $headers);

		

		/*$sql = "UPDATE Concordia_Servicios SET  Estado='Enviado' WHERE Servicio_ID=".$Servicio_ID;														

		$res1=$bd->ejecutar($sql);

		

		$sql = "insert into Concordia_Servicios_Logs (Servicio_ID, Usuario,  Observacion, Fecha ) values(" . $Servicio_ID. ", '" . $_SESSION['nombre_empleado'] . "', 'Envio de Solicitud', NOW())";														

		$res1=$bd->ejecutar($sql);   	

		

		if ($res1==1) 

		{

			echo "<h2>Orden de Servicio Enviada</h2>";

			echo "<img src='images/spacer.gif' onload='Servicios_Lista();' />"; 

		}

		else

		{

			echo "ERROR No se pudoe enviar la Orden de Servicio";

		}*/

		echo "<h2>Orden de Compra Enviada</h2>";	

	

	//echo $cuerpo;

	require('Library/Close_Conexion.php');	
?>
	<img src="images/spacer.gif" onload="$('#btn_send_email').attr('disabled','disabled');" />

	

        

   