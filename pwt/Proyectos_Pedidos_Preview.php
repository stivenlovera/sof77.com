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
	
	$consulta = "SELECT p.*, v.Nombre FROM pedidos p";
	$consulta = $consulta . " INNER JOIN vendedor v ON p.Ven_ID=v.Ven_ID  ";	
	$consulta = $consulta . " WHERE p.Ped_ID=".$Ped_ID;		

	//echo $consulta."<br>";
	$contador=1;	 	  	 	  	  

	$result2=$bd->ejecutar($consulta); 	
	while (($row2 = mysqli_fetch_array($result2) ))							
	{		
		$Ven_ID = $row2["Ven_ID"];
		$Fecha = $row2["Fecha"];	
		$Note = $row2["Note"];	
		
		if ( !(is_null($Fecha)) )		
			$Fecha=FormatDateTime($Fecha, 8);
		else
			$Fecha="";
	}
	mysqli_free_result($result2);
	
	$consulta = "SELECT p.*, t.Nombre_Tipo, e.Nombre_Estatus, ";
	$consulta = $consulta . " CONCAT(em1.Nombre, ' ', em1.Apellido_Paterno, ' ',  em1.Apellido_Materno) as Foreman, em1.Telefono as TelefonoF,  em1.Celular as  CelularF, ";
	$consulta = $consulta . " CONCAT(em5.Nombre, ' ',  em5.Apellido_Paterno, ' ',  em5.Apellido_Materno) as Coordinador_Obra, em5.Telefono as TelefonoC,  em5.Celular as  CelularC FROM proyectos p ";
	$consulta = $consulta . " LEFT JOIN tipo_proyecto t ON p.Tipo_ID=t.Tipo_ID  ";
	
	$consulta = $consulta . " LEFT JOIN estatus e ON p.Estatus_ID=e.Estatus_ID ";			
	$consulta = $consulta . " LEFT JOIN personal em1 ON em1.Empleado_ID=p.Foreman_ID ";		
	$consulta = $consulta . " LEFT JOIN personal em5 ON em5.Empleado_ID=p.Coordinador_Obra_ID ";		
	
	
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
						
		$Foreman=$row2["Foreman"];
		$TelefonoF=$row2["TelefonoF"];
		$CelularF=$row2["CelularF"];
	}
	mysqli_free_result($result2);
?> 
	<input type="button" value="Print" onclick="printSelection(document.getElementById('Div_Orden_Impresion'));return false" />
<br />		
<div id="Div_Orden_Impresion">    
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td><img src="images/logo.gif" width="170" height="80" /></td>
			<td align="center" valign="bottom" style="font-size:x-large">&nbsp;</td>
			<td align="right" valign="top">								
			</td>			
		</tr>
		<tr><td></td></tr>
		<tr>
			<td colspan="3">
				<p><b><span style="font-size:x-large">Purchase Order</span></b></p>
				<b>Date:</b><?php echo FormatDateTime($Fecha, 8); ?><bR />
			  	<b>Job:</b> <?php echo $Codigo." ".$Nombre;?><bR />
		        <b>Address:</b>  <?php echo  $Numero." ".$Calle.", ".$Ciudad.", ".$Estado." ".$Zip_Code; ?><bR />
				<b>Super Intendent:</b> <?php echo $Coordinador_Obra." <b>Movil:</b>".$CelularC;?><bR />
		        <b>Foreman:</b> <?php echo $Foreman." <b>Movil:</b>".$CelularF;?><bR />
		        <b>PO:</b> <?php echo  $Codigo."-".$Ped_ID; ?>		        	            
			</td>
		</tr>
	</table>		
	<br />
	<div id="div_pedido_lista_items" name="div_pedido_lista_items"></div>
	<br />	<br />
	<Table border="0" width="90%" cellpadding="0" cellspacing="0">
		<tr>
			<td width="60"><strong>Note:</strong></td><td><?php echo $Note; ?></td>
		</tr>
	</Table>
</div>
<?php
	echo "<img src='images/spacer.gif' onload='Proyectos_Pedidos_Items_Preview($Ped_ID);' />"; 
	require('Library/Close_Conexion.php');
?>