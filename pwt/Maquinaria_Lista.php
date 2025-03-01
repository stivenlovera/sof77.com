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
	<legend> Machines-Tools: </legend>
<div>
<table class="tabla_maquinaria_lista">
	<thead>	
	  <tr>
			<th width="20" >Nro.</th>
       		<th width="60">&nbsp;</th>	
			<th width="60">Status</th>				 			
			<th width="150">Name</th>				
			<th width="150">Note</th>			
			<th width="80">Aux1</th>
			<th width="80">Aux2</th>									   								   			
		    <th width="80">Aux3</th>				   								   					 				
	  </tr>	
	 </thead>	
	 <tbody>
<?php  

	$Name=$_GET['Name'];	
	$Activo=$_GET['Activo'];	
	 				       
	  					  
	$consulta = "SELECT * FROM maquinarias WHERE ";	
	
	if ( $_GET['Name'] != ""  )
	$consulta = $consulta." Nombre like '%".$_GET['Name']."%'  AND";   
	
	if ( $_GET['Activo'] == "1"  )
	
		$consulta = $consulta." Activo AND";     
	else
		if ( $_GET['Activo'] == "0"  )
			$consulta = $consulta." NOT (Activo) AND";     

	$consulta = $consulta." 1=1 ORDER BY Nombre";	
	
	//echo $consulta."<br>";
	$contador=1;	 	  	 	  	  

	$result2=$bd->ejecutar($consulta); 	
	while (($row2 = mysqli_fetch_array($result2) ))							
	{		
		$Maq_ID = $row2["Maq_ID"];
		$Nombre = $row2["Nombre"];
		$Note=$row2["Note"];	
		$Aux1=$row2["Aux1"];		
		$Aux2=$row2["Aux2"];			
		$Aux3 = $row2["Aux3"];	
		$Activo = $row2["Activo"];
		
		if ( $Activo )
			$icono="paperOk.gif";
		else
			$icono="paperBad.gif";
	?>	
		<tr >											
			<td><?php echo  $contador?></td>
			<td>
				 <a href="#">
					<img src="images/button_edit.gif" border="0" width="16" onclick="Maquinaria_Editar(<?php echo $Maq_ID; ?>);" alt="Edit"/>	
				</a>								
				<a href="#">
					<img src="images/icon_eliminar_0_gif.gif" border="0" width="16" onclick="Maquinaria_Eliminar(<?php echo $Maq_ID; ?>);" alt="Delete"/>		
				</a>				
			</td>						
			<td align="right" style="font-size:x-small">				
				<img src="images/<?php echo  $icono; ?>" width="16" height="16" />
			</td>
			<td align="left">
				<a href="javascript:Maquinaria_Menu(<?php echo  $Maq_ID?>);">
					<?php echo $Nombre; ?> 
				</a>
			</td>			
			<td align="left" style="font-size:x-small"><?php echo  $Note;?></td>
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
		echo "<br><br>Records Not Found<br>";
	}				
	?>
</div>
<img src="images/spacer.gif" onload="$('.tabla_maquinaria_lista').flexigrid({nowrap: false, showTableToggleBtn : true,width : 1000,height :200, singleSelect: true	});" />	 
</fieldset>	
<?php
	require('Library/Close_Conexion.php');	
?>