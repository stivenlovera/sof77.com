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







	







	$Ped_ID=$_GET['Ped_ID'];







	$Pro_ID=$_GET['Pro_ID'];







	$Ven_ID=$_GET['Ven_ID'];		







	





/*consulta original */
/* $consulta = "SELECT p.*, v.Nombre, v.email email_vendedor FROM pedidos p";
$consulta = $consulta . " INNER JOIN vendedor v ON p.Ven_ID=v.Ven_ID  ";	
$consulta = $consulta . " WHERE p.Ped_ID=".$Ped_ID;	 */	

	$consulta = "SELECT p.* FROM pedidos p";







	//$consulta = $consulta . " INNER JOIN vendedor v ON p.Ven_ID=v.Ven_ID  ";	







	$consulta = $consulta . " WHERE p.Ped_ID=".$Ped_ID;		















	echo $consulta."<br>";







	$contador=1;	 	  	 	  	  















	$result2=$bd->ejecutar($consulta); 	







	while (($row2 = mysqli_fetch_array($result2) ))							







	{		







		$PO = $row2["PO"];



		



		$Ven_ID = $row2["Ven_ID"];







		$email = $row2["email_vendedor"];







		$Fecha = $row2["Fecha"];







		$Note = $row2["Note"];	







		







		if ( !(is_null($Fecha)) )		







			$Fecha=FormatDateTime($Fecha, 6);







		else







			$Fecha="";







	}
	mysqli_free_result($result2);		
	
	$consulta = "SELECT p.*, t.Nombre_Tipo, e.Nombre_Estatus, ";
	//$consulta = $consulta . " CONCAT(em1.Nombre, ' ', em1.Apellido_Paterno, ' ',  em1.Apellido_Materno) as Foreman, em1.Telefono as TelefonoF,  em1.Celular as  CelularF, ";
	$consulta = $consulta . " em1.Nick_Name as Foreman, em1.Telefono as TelefonoF,  em1.Celular as  CelularF, ";
	$consulta = $consulta . " em7.Nick_Name as Lead, em7.Telefono as TelefonoL,  em7.Celular as  CelularL, ";
	$consulta = $consulta . " CONCAT(em5.Nombre, ' ',  em5.Apellido_Paterno, ' ',  em5.Apellido_Materno) as Coordinador_Obra, em5.Telefono as TelefonoC,  em5.Celular as  CelularC, em6.email FROM proyectos p ";
	$consulta = $consulta . " LEFT JOIN tipo_proyecto t ON p.Tipo_ID=t.Tipo_ID  ";
	$consulta = $consulta . " LEFT JOIN estatus e ON p.Estatus_ID=e.Estatus_ID ";			
	$consulta = $consulta . " LEFT JOIN personal em1 ON em1.Empleado_ID=p.Foreman_ID ";		
	$consulta = $consulta . " LEFT JOIN personal em5 ON em5.Empleado_ID=p.Coordinador_Obra_ID ";
	$consulta = $consulta . " LEFT JOIN personal em6 ON em6.Empleado_ID=p.Coordinador_ID ";	
		$consulta = $consulta . " LEFT JOIN personal em7 ON em7.Empleado_ID=p.Lead_ID ";	
	$consulta = $consulta . " WHERE p.Pro_ID=".$Pro_ID." ORDER BY Fecha_Inicio";		
	//echo $consulta."<br>";
	$contador=0;	 	  	 	  	  
	$result2=$bd->ejecutar($consulta); 	
	while (($row2 = mysqli_fetch_array($result2) ))							
	{		
		$Pro_ID = $row2["Pro_ID"];
		$Codigo = $row2["Codigo"];
		$Nombre = $row2["Nombre"];
		$Nombre_Estatus=$row2["Nombre_Estatus"];
		$Nombre_Tipo=$row2["Nombre_Tipo"];
		$Estado = $row2["Estado"];
		$Ciudad = $row2["Ciudad"];	
		$Zip_Code = $row2["Zip_Code"];			
		$Calle = $row2["Calle"];
		$Numero=$row2["Numero"];
		$Contratista_General=$row2["Contratista_General"];
		$Coordinador_Obra=$row2["Coordinador_Obra"];		
		$TelefonoC=$row2["TelefonoC"];
		$CelularC=$row2["CelularC"];
		$email_pwt=$row2["email"];
		//echo $email_pwt;
		$Foreman=$row2["Foreman"];
		$TelefonoF=$row2["TelefonoF"];
		$CelularF=$row2["CelularF"];
		$Lead=$row2["Lead"];
		$CelularL=$row2["CelularL"];
		
		
	}
	mysqli_free_result($result2);

?> 

	<input id="btn_send_email" name="btn_send_email" type="button" value="Send" onclick="Proyectos_Pedidos_Email_Send();" />	
	<form id="Form_Proyecto_Pedidos_Email_Send_NO USE">

		<table>
			<tr>
				<td><b>Subject::</b></td>
				<td><input type="text" id="Subject" name="Subject" value="<?php echo $Nombre;?> -  Order"   size="80" /></td>
			</tr>
			<tr>
				<td><b>To:<br />
				</b></td>
				<td><input type="text" id="To" name="To" value="<?php echo $email;?>"  size="50"/></td>
			</tr>
			<tr>
				<td><b>Cc:</b></td>
				<td><input type="text" id="Cc" name="Cc" value="<?php echo $email_pwt;?>"   size="50" /></td>
			</tr>
		</table>		
	</form>
    <textarea name="wysiwyg" id="wysiwyg" rows="27" cols="90">					

	</textarea>  		

	<div id="Div_Orden_Email" style="display:none">  			
		<p><b><span style="font-size:x-large">Purchase Order</span></b></p>
		<b>Date:</b><?php echo FormatDateTime($Fecha, 8); ?><bR />
		<b>GC-Superintendent:</b> <?php echo $Coordinador_Obra." <b>Movil:</b>".$CelularC;?><bR />
		<p><b>Job:</b> <?php echo $Codigo." ".$Nombre;?><bR />
		<b>Address:</b>  <?php echo  $Numero." ".$Calle.", ".$Ciudad.", ".$Estado." ".$Zip_Code; ?><bR />
		<b>PWT Contacts:</b> <?php echo $Foreman." <b>Movil:</b>".$CelularF;?><bR /> 2nd.Contact: <?php echo $Lead." <b>Movil:</b>".$CelularL;?> <bR />

		<b>PO:</b> <?php echo  $PO; ?>		        







		</p>







		<div id="div_pedido_lista_items" name="div_pedido_lista_items"></div>		







		



	<?php echo $Note; ?><bR />







    <b><bR />



    <b>Thank you<bR />



    



	</div>







<?php







	echo "<img src='images/spacer.gif' onload='Proyectos_Pedidos_Items_Email($Ped_ID);' />";	







	require('Library/Close_Conexion.php');







?>