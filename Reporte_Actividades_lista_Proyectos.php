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
	<legend>List of Projects: </legend>
<div>
<table class="tabla_proyectos_listas">
	<thead>	
	  <tr>
       		<th width="25" >Nro.</th>
			<th width="20" >&nbsp;</th>
			<th width="70">Code</th>				
			<th width="150">Job Name</th>			
			<th width="80">Start Date</th>
			<th width="80">Finish Date</th>									   								   			
			<th width="100">Comapany</th>
			<th width="100">General Constractor</th>
			<th width="150">Address</th>			
	  </tr>	
	 </thead>	
	 <tbody>
<?php   				       
	  					  
	$Company=$_GET['Company'];	
	$Name=$_GET['Nombre'];	
	
	$consulta = "SELECT p.*, e.Nombre as Company FROM proyectos p INNER JOIN empresas e ON p.Emp_ID=e.Emp_ID WHERE ";	
	
	if ( $_GET['Company'] != ""  )
	$consulta = $consulta." e.Nombre like '%".$_GET['Company']."%'  AND";   
	
	if ( $_GET['Nombre'] != ""  )
	$consulta = $consulta." p.Nombre like '%".$_GET['Nombre']."%'  AND";   
	$consulta = $consulta." 1=1 ORDER BY p.Nombre";	
	
	//echo $consulta."<br>";
	$contador=1;	 	  	 	  	  

	$result2=$bd->ejecutar($consulta); 	
	while (($row2 = mysqli_fetch_array($result2) ))							
	{		
		$Codigo = $row2["Codigo"];
		$Emp_ID = $row2["Emp_ID"];
		$Company = $row2["Company"];
		$Pro_ID = $row2["Pro_ID"];
		$Nombre = $row2["Nombre"];
		$Fecha_Inicio=$row2["Fecha_Inicio"];	
		$Fecha_Fin=$row2["Fecha_Fin"];		
		$Horas=$row2["Horas"];			
		$Estado = $row2["Estado"];	
		$Ciudad = $row2["Ciudad"];
		$Zip_Code = $row2["Zip_Code"];			
		$Calle = $row2["Calle"];
		$Numero=$row2["Numero"];
		$Contratista_General=$row2["Contratista_General"];
	?>	
		<tr >											
			<td><?php echo  $contador?></td>						
			<td>
				<a href="#" onclick="Reporte_Actividad_Datos_Nueva(<?php echo  $Pro_ID; ?>,'<?php echo  $Codigo; ?>','<?php echo  $Nombre; ?>')">
					<img src="images/arrow_right_sobre.gif" width="18" height="15" />
				</a>
			</td>
			<td align="right" style="font-size:x-small"><?php echo  $Codigo; ?></td>			
			<td align="left">				
				<?php echo $Nombre; ?> 				
			</td>			
			<td align="left" style="font-size:x-small"><?php echo  FormatDateTime($Fecha_Inicio, 8);?></td>
			<td align="right" style="font-size:x-small"><?php echo  FormatDateTime($Fecha_Fin, 8);?></td>	
			<td align="right" style="font-size:x-small"><?php echo  $Horas; ?></td>				
			<td align="right" style="font-size:x-small"><?php echo  $Company; ?></td>						
			<td align="right" style="font-size:x-small"><?php echo  $Contratista_General; ?></td>	
			<td align="right" style="font-size:x-small"><?php echo  $Numero." ".$Calle.", ".$Ciudad.", ".$Estado." ".$Zip_Code; ?></td>
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
		echo "<br><br>No hay Registros<br>";
	}				
	?>
</div>
<img src="images/spacer.gif" onload="$('.tabla_proyectos_listas').flexigrid({nowrap: false, showTableToggleBtn : true,width : 850,height :100, singleSelect: true	});" />	 
</fieldset>	
<?php
	require('Library/Close_Conexion.php');	
?>