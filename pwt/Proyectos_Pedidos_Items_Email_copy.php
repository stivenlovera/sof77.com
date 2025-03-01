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
?> 
	<table width="100%" border="0" cellspacing="0" cellpadding="0">		
	  <tr>
			<th width="70" style="font-size:small">Quantity</th>
			<th width="70" style="font-size:small">Unit</th>
			<th width="200" style="font-size:small">Denomination</th>
			<th width="200" style="font-size:small">Note</th>			
			
			<!--<th width="70" style="font-size:small">Precio</th>
			<th width="70" style="font-size:small">Total</th>-->
	  </tr>	
<?php   				       	
	$consulta = "SELECT p.Ped_Mat_ID, p.Ped_ID, p.Mat_ID, m.Denominacion, m.Nombre_Generico, m.Unidad_Medida, p.Cantidad, m.Precio, c.Nombre as Categoria FROM pedidos_material p ";
	$consulta = $consulta . " INNER JOIN materiales m ON p.Mat_ID=m.Mat_ID  ";	
	$consulta = $consulta . " INNER JOIN categoria_material c ON c.Cat_ID=m.Cat_ID  ";	
	$consulta = $consulta . " WHERE p.Ped_ID=".$Ped_ID;		
	$consulta = $consulta . " ORDER BY m.Denominacion ";		
	//echo $consulta."<br>";
	$contador=1;
	$total=0;	 	  	 	  	  

	$result2=$bd->ejecutar($consulta); 	
	while (($row2 = mysqli_fetch_array($result2) ))							
	{		
		$Ped_Mat_ID = $row2["Ped_Mat_ID"];
		$Ped_ID = $row2["Ped_ID"];
		$Mat_ID = $row2["Mat_ID"];
		$Denominacion = $row2["Denominacion"];
		$Nombre_Generico = $row2["Nombre_Generico"];
		$Categoria = $row2["Categoria"];	
		$Unidad_Medida = $row2["Unidad_Medida"];
		$Cantidad = $row2["Cantidad"];
		$Precio = $row2["Precio"];											
	?>		
		<tr>											
			<td align="right" style="font-size:x-small"><?php echo  $Cantidad; ?>&nbsp;</td>
			<td align="center" style="font-size:x-small"><?php echo  $Unidad_Medida; ?>&nbsp;</td>
			<td align="left" style="font-size:x-small"><?php echo  $Denominacion; ?>&nbsp;</td>
			<td align="left" style="font-size:x-small"><?php echo  $Nombre_Generico; ?>&nbsp;</td>
			<!--<td align="right" style="font-size:x-small"><?php echo  $Precio; ?>&nbsp;</td>
			<td align="right" style="font-size:x-small"><?php echo  $Cantidad*$Precio; ?>&nbsp;</td>	-->		
		</tr>
		<?php    		
			$contador++;								 								
			$total=$total+($Cantidad*$Precio);
	}
	mysqli_free_result($result2);		
		?>
		<!--<tr>											
			<td align="right" colspan="6"><b>Total</b></td>						
			<td align="right" ><b><?php echo  $total; ?></b>&nbsp;</td>
		</tr>-->
	</table>   
	<img src='images/spacer.gif' onload='Proyectos_Pedidos_Items_Copiar();' />	
<?php
	require('Library/Close_Conexion.php');	
?>