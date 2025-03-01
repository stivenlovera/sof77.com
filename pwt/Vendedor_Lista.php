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
			<th width="70">Code</th>				
			<th width="150">Name</th>								   								   			
		    <th width="150">Address</th>				   								   					 	
			<th width="100">General Manager</th>
            <th width="50">Phone</th>
			<th width="150">Fax</th>			
			<th width="80">Web</th>	
			<th width="80">email</th>	
			<th width="80">Industry</th>	
			<th width="80">Detail</th>									 
	  </tr>	
	 </thead>	
	 <tbody>
<?php   				       
	  					  
	$Nombre=$_GET['Nombre'];	
	$Estado=$_GET['Estado'];	
	$Ciudad=$_GET['Ciudad'];	
	$Zip_Code=$_GET['Zip_Code'];	
	$Calle=$_GET['Calle'];
	$Telefono=$_GET['Telefono'];	
	
	$consulta = "SELECT * FROM vendedor WHERE ";	
	
	if ( $_GET['Nombre'] != ""  )
	$consulta = $consulta." Nombre like '%".$_GET['Nombre']."%'  AND";     
		
	if ($_GET['Estado'] != ""  )
		$consulta = $consulta." Estado like '%".$_GET['Estado']."%'  AND" ; 
	
	if ($_GET['Ciudad'] != ""  )
		$consulta = $consulta." Ciudad like '%".$_GET['Ciudad']."%' AND";
	
	if ($_GET['Calle'] != ""  )
		$consulta = $consulta." Calle like '%".$_GET['Calle']."%' AND";
			
	if ($_GET['Zip_Code'] != ""  )
		$consulta = $consulta." Zip_Code like '%".$_GET['Zip_Code']."%' AND";
		
	if ($_GET['Telefono'] != ""  )
		$consulta = $consulta." Telefono='".$_GET['Telefono']."' AND" ;    	
		

	$consulta = $consulta." 1=1 ORDER BY Nombre";	
	
	//echo $consulta."<br>";
	$contador=1;	 	  	 	  	  

	$result2=$bd->ejecutar($consulta); 	
	while (($row2 = mysqli_fetch_array($result2) ))							
	{		
		$Ven_ID = $row2["Ven_ID"];
		$Codigo = $row2["Codigo"];	
		$Nombre = $row2["Nombre"];
		$Estado = $row2["Estado"];	
		$Ciudad = $row2["Ciudad"];
		$Zip_Code = $row2["Zip_Code"];			
		$Calle = $row2["Calle"];
		$Numero=$row2["Numero"];
		$Gerente_General=$row2["Gerente_General"];
		$Telefono=$row2["Telefono"];
		$Fax=$row2["Fax"];
		$Web=$row2["Web"];
		$email=$row2["email"];
		$Rubro=$row2["Rubro"];
		$Detalles=$row2["Detalles"];		
	?>		
		<tr >											
			<td> 	
				 <a href="#">
					<img src="images/button_edit.gif" border="0" width="16" onclick="Vendedor_Editar(<?php echo $Ven_ID; ?>);" alt="Edit"/>	
				</a>								
				<a href="#">
					<img src="images/icon_eliminar_0_gif.gif" border="0" width="16" onclick="Vendedor_Eliminar(<?php echo $Ven_ID; ?>);" alt="Delete"/>		
				</a>				
			</td>
			<td align="right" style="font-size:x-small"><?php echo $Codigo; ?></td>
			<td align="left">
				<?php echo $Nombre; ?> 
			</td>	
			<td align="left" style="font-size:x-small"><?php echo  $Numero." ".$Calle.", ".$Ciudad.", ".$Estado." ".$Zip_Code; ?></td>
			<td align="right" style="font-size:x-small"><?php echo  $Gerente_General; ?></td>	
			<td align="right" style="font-size:x-small"><?php echo  $Telefono; ?></td>	
			<td align="right" style="font-size:x-small"><?php echo  $Fax; ?></td>						
			<td align="right" style="font-size:x-small"><?php echo  $Web; ?></td>
			<td align="right" style="font-size:x-small"><?php echo  $email; ?></td>
			<td align="right" style="font-size:x-small"><?php echo  $Rubro; ?></td>		
			<td align="right" style="font-size:x-small"><?php echo  $Detalles; ?></td>			
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
<img src="images/spacer.gif" onload="$('.tabla_vendedor_listas').flexigrid({nowrap: false, showTableToggleBtn : true,width : 1000,height :200, singleSelect: true	});" />	 
</fieldset>	
<?php
	require('Library/Close_Conexion.php');	
?>