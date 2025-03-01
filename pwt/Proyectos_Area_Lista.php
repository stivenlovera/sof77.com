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
<fieldset id="Fs_Lista_Cliente" class="" >
	<legend>List Area: </legend>
	<table>
		<tr>
			<td>
				<div>
					<table class="Tabla_Lista_Areas">
						<thead>	
						  <tr>
								<th width="100">&nbsp;</th>							 
								<th width="150" >Name</th>
								<th width="100">Note</th>
								<th width="100">Aux 1</th>
								<th width="100">Aux 2</th>
								<th width="100">Aux 3</th>
						  </tr>	
						 </thead>	
						 <tbody>
				<?php   				       	
					$consulta = "SELECT * FROM area_control WHERE Pro_ID=".$Pro_ID." ORDER BY Nombre ";		
					//echo $consulta."<br>";
					$contador=1;	 	  	 	  	  
				
					$result2=$bd->ejecutar($consulta); 	
					while (($row2 = mysqli_fetch_array($result2) ))							
					{		
						$Area_ID = $row2["Area_ID"];
						$Nombre = $row2["Nombre"];
						$Note = $row2["Note"];
						$Aux1 = $row2["Aux1"];
						$Aux2 = $row2["Aux2"];
						$Aux3 = $row2["Aux3"];
					?>		
						<tr >											
							<td>								 
								 <a href="#">
									<img src="images/button_edit.gif" border="0" width="16" onclick="Proyectos_Area_Editar(<?php echo $Area_ID; ?>,<?php echo $Pro_ID; ?>);" alt="Edit"/>	
								</a>								
								<a href="#">
									<img src="images/icon_eliminar_0_gif.gif" border="0" width="16" onclick="Proyectos_Area_Eliminar(<?php echo $Area_ID; ?>,<?php echo $Pro_ID; ?>);" alt="Delete"/>		
								</a>				
							</td>
							<td  style="font-size:x-small"><?php echo  $Nombre; ?></td>						
							<td align="right" style="font-size:x-small"><?php echo  $Note; ?></td>
							<td align="right" style="font-size:x-small"><?php echo  $Aux1; ?></td>
							<td align="right" style="font-size:x-small"><?php echo  $Aux2; ?></td>							
							<td align="right" style="font-size:x-small"><?php echo  $Aux3; ?></td>							
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
						echo "<br><br>Record Not Found<br>";
					}				
					?>
				</div>				
			</td>			
		</tr>
	</table>		
	<img src="images/spacer.gif" onload="$('.Tabla_Lista_Areas').flexigrid({nowrap: false, showTableToggleBtn : true,width : 700,height :200, singleSelect: true	});" />	 
</fieldset>	
<?php
	require('Library/Close_Conexion.php');	
?>