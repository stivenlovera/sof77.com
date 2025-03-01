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
			   <title>Order</title> 
			</head> 
			<body>'.$Contenido.'</body>
		</html>';
		
		$headers  = "MIME-Version: 1.0\r\n";  
		$headers .= "From: info@precisionwall.com\n"; 
		$headers .= "Reply-To: info@precisionwall.com\n";
		$headers .= "Bcc: ".$Cc."\n";  		
		$headers .= "X-Priority: 1\n"; 
		$headers .= "X-Mailer: DT Formmail".VERSION."\n";       
		$headers .= "Content-Type: text/html;\n\tcharset=\"iso-8859-1\"\n";      
		
		$destinatario = $To; 
		$asunto = $Subject;     				  
		mail($destinatario, $asunto, $cuerpo, $headers);
		echo "<h2>Orden de Compra Enviada</h2>";		
	//echo $cuerpo;
	require('Library/Close_Conexion.php');	
?>
	<img src="images/spacer.gif" onload="$('#btn_send_email').attr('disabled','disabled');" />
	
        
   