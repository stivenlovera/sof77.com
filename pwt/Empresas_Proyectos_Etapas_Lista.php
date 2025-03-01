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
	
?> 
<table width="810" class="Tabla_Lista_Etapas"  >
	<thead>	
	  <tr>
	  		<th width="40">&nbsp;</th>	
       		<!--<th width="10" >Nro.</th>-->
			<th width="150">Name</th>				
			<!--<th width="50">Effort %</th>	-->							   								   			
			<th width="90">Start Date</th>
			<th width="90">End Date</th>
			<th width="60">Hours</th>	
            <th width="150">Note</th>												 
	  </tr>	
	 </thead>	
	 <tbody>
<?php   				       	
	$consulta = "SELECT * FROM etapas WHERE Pro_ID=".$Pro_ID." ORDER BY Fecha_Inicio";		
	//echo $consulta."<br>";
	$contador=1;	 	  	 	  	  

	$result2=$bd->ejecutar($consulta); 	
	while (($row2 = mysqli_fetch_array($result2) ))							
	{		
		$Etapas_ID = $row2["Etapas_ID"];
		$Nombre = $row2["Nombre"];
		//$Porcentaje_Esfuerzo  = $row2["Porcentaje_Esfuerzo"];	
		$Fecha_Inicio = FormatDateTime($row2["Fecha_Inicio"], 6);
		$Fecha_Fin = FormatDateTime($row2["Fecha_Fin"], 6);	
		$Fecha_Inicio2 = FormatDateTime($row2["Fecha_Inicio"], 8);
		$Fecha_Fin2 = FormatDateTime($row2["Fecha_Fin"], 8);	
		$Horas = $row2["Horas"];
		$Note = $row2["Note"];
	?>		
		<tr >											
			<td> 	
				 <a href="#">
					<img src="images/button_edit.gif" border="0" width="16" onclick="Empresas_Proyecto_Etapas_Editar(<?php echo $Etapas_ID; ?>, <?php echo $Pro_ID; ?>, '<?php echo $Nombre; ?>', '<?php echo $Fecha_Inicio; ?>', '<?php echo $Fecha_Fin; ?>', '<?php echo $Horas; ?>', '<?php echo $Note; ?>');" alt="Edit"/>	
				</a>								
				<a href="#">
					<img src="images/icon_eliminar_0_gif.gif" border="0" width="16" onclick="Empresas_Proyecto_Etapas_Eliminar(<?php echo $Etapas_ID; ?>, <?php echo $Pro_ID; ?>);" alt="Delete"/>		
				</a>				
			</td>
			<!--<td ><?php echo  $contador?></td>-->						
			<td align="right" style="font-size:x-small"><?php echo  $Nombre; ?></td>			
			<!--<td align="center" style="font-size:x-small"><?php echo  $Porcentaje_Esfuerzo; ?>%</td>	-->	
			<td align="right" style="font-size:x-small"><?php echo  $Fecha_Inicio2; ?></td>		
			<td align="right" style="font-size:x-small"><?php echo  $Fecha_Fin2; ?></td>		
			<td align="Center" style="font-size:x-small"><?php echo  $Horas; ?></td>
           	<td align="Center" style="font-size:x-small"><?php echo  $Note; ?></td>		
	  </tr>
		<?php    		
			$contador++;								 								
	}
	mysqli_free_result($result2);		
			?>
		</tbody>
	</table>   	
<img src="images/spacer.gif" onload="$('.Tabla_Lista_Etapas').flexigrid({nowrap: false, showTableToggleBtn : true,width : 700,height :100, singleSelect: true	});" />	 
<?php
	require('Library/Close_Conexion.php');	
?>