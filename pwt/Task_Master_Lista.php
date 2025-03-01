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
	
?> 
<fieldset id="Fs_Lista_Cliente" class="" >
	<legend>List of Vendors: </legend>
<div>
<table class="tabla_vendedor_listas">
	<thead>	
	  <tr>
       		<th width="60">&nbsp;</th>	
			<th width="150">Name</th>								   								   			
		    <th width="100">Time Stimated</th>				   								   					 	
			<th width="100">Material Stimated</th>
            <th width="50">Aux1</th>
			<th width="50">Aux2</th>
			<th width="50">Aux3</th>
			<th width="50">Aux4</th>
			<th width="50">Aux5</th>
			<th width="50">Aux6</th>
			<th width="80">%</th>									 
	  </tr>	
	 </thead>	
	 <tbody>
<?php   				       
	  					  
	$Nombre=$_GET['Nombre'];			
	
	$consulta = "SELECT * FROM task_master  ";	
	
	if ( $_GET['Nombre'] != ""  )
	$consulta = $consulta." WHERE Nombre like '%".$_GET['Nombre']."%' ";     			

	$consulta = $consulta." ORDER BY Nombre";	
	
	//echo $consulta."<br>";
	$contador=1;	 	  	 	  	  

	$result2=$bd->ejecutar($consulta); 	
	while (($row2 = mysqli_fetch_array($result2) ))							
	{		
		$Task_Master_ID = $row2["Task_Master_ID"];
		$Nombre = $row2["Nombre"];		
		$Horas_Estimadas=$row2["Horas_Estimadas"];
		$Material_Estimado=$row2["Material_Estimado"];
		$Aux1=$row2["Aux1"];		
		$Aux2=$row2["Aux2"];		
		$Aux3=$row2["Aux3"];		
		$Aux4=$row2["Aux4"];		
		$Aux5=$row2["Aux5"];		
		$Aux6=$row2["Aux6"];		
		$Porcentaje=$row2["Porcentaje"];		
	?>		
		<tr >											
			<td> 	
				 <a href="#">
					<img src="images/button_edit.gif" border="0" width="16" onclick="Task_Master_Editar(<?php echo $Task_Master_ID; ?>);" alt="Edit"/>	
				</a>								
				<a href="#">
					<img src="images/icon_eliminar_0_gif.gif" border="0" width="16" onclick="Task_Master_Eliminar(<?php echo $Task_Master_ID; ?>);" alt="Delete"/>		
				</a>				
			</td>
			<td align="left">
				<?php echo $Nombre; ?> 
			</td>	
			<td align="left" style="font-size:x-small"><?php echo  $Horas_Estimadas; ?></td>
			<td align="right" style="font-size:x-small"><?php echo  $Material_Estimado; ?></td>	
			<td align="right" style="font-size:x-small"><?php echo  $Telefono; ?></td>	
			<td align="right" style="font-size:x-small"><?php echo  $Aux1; ?></td>						
			<td align="right" style="font-size:x-small"><?php echo  $Aux2; ?></td>
			<td align="right" style="font-size:x-small"><?php echo  $Aux3; ?></td>
			<td align="right" style="font-size:x-small"><?php echo  $Aux4; ?></td>		
			<td align="right" style="font-size:x-small"><?php echo  $Aux5; ?></td>			
			<td align="right" style="font-size:x-small"><?php echo  $Aux6; ?></td>			
			<td align="right" style="font-size:x-small"><?php echo  $Porcentaje; ?></td>			
	  </tr>
		<?php    		
			$contador++;								 								
	}
	mysqli_free_result($result2);		
			?>
		</tbody>
	</table>   
	<?php		
	if ($contador == 1 )
	{
		echo "<br><br>Records Not Found<br>";
	}				
	?>
</div>
<img src="images/spacer.gif" onload="$('.tabla_vendedor_listas').flexigrid({nowrap: false, showTableToggleBtn : true,width : 1000,height :200, singleSelect: true	});" />	 
</fieldset>	
<?php
	require('Library/Close_Conexion.php');	
?>