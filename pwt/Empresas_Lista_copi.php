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
	<legend>List of Companies: </legend>
<div>

<!--<table class="moduletable"  width="100%" cellpadding="2" cellspacing="0" cols=9>-->
<table class="moduletable"  width="100%" cellpadding="2" cellspacing="2" id='Tabla_Lista_Empresas' name='Tabla_Lista_Empresas'  cols=9>
	<thead>	
	  <tr>
       		<th width="10" >Nro.</th>
			<th width="70">Code</th>				
			<th width="150">Name</th>								   								   			
		    <th width="80">State</th>				   								   					 	
			<th width="100">City</th>
            <th width="50">Zip Code</th>
			<th width="150">Address</th>			
			<th width="80">Phone</th>	
			<th width="80">Detalles</th>			
			<th width="20">&nbsp;</th>				 
	  </tr>	
	 </thead>	
	 <tbody>
<?php   				       
	  					  
	$Company=$_GET['Company'];	
	$State=$_GET['State'];	
	$City=$_GET['City'];	
	$Zip_Code=$_GET['Zip_Code'];	
	$Address=$_GET['Address'];
	$Phone=$_GET['Phone'];	
	
	$consulta = "SELECT * FROM empresas WHERE ";	
	
	if ( $_GET['Company'] != ""  )
	$consulta = $consulta." Company like '%".$_GET['Nombre']."%'  AND";     
		
	if ($_GET['State'] != ""  )
		$consulta = $consulta." State like '%".$_GET['Estado']."%'  AND" ; 
	
	if ($_GET['City'] != ""  )
		$consulta = $consulta." City like '%".$_GET['Ciudad']."%' AND";
		
	if ($_GET['Zip_Code'] != ""  )
		$consulta = $consulta." Zip_Code like '%".$_GET['Zip_Code']."%' AND";
		
	if ($_GET['Phone'] != ""  )
		$consulta = $consulta." Phone='".$_GET['Telefono']."' AND" ;    	
		

	$consulta = $consulta." 1=1 ORDER BY Nombre";	
	
	//echo $consulta."<br>";
	$contador=0;	 	  	 	  	  

	$result2=$bd->ejecutar($consulta); 	
	while (($row2 = mysqli_fetch_array($result2) ))							
	{		
		$Emp_ID = $row2["Emp_ID"];
		$Codigo = $row2["Codigo"];	
		$Nombre = $row2["Nombre"];
		$Estado = $row2["Estado"];	
		$Ciudad = $row2["Ciudad"];
		$Zip_Code = $row2["Zip_Code"];			
		$Calle = $row2["Calle"];
		$Numero=$row2["Numero"];
		$Telefono=$row2["Telefono"];
		$Detalles=$row2["Detalles"];
			
		if (($contador%2) == 0) 
			$clase='class="estilopar"';  
		else
			$clase='class="estiloimpar"'; 
	?>		
		<tr id="Tabla_Lista_Empresas_<?php echo  $contador?>" onclick="Tabla_Lista_Empresas.Enciende_Fila_MouseClick(<?php echo  $contador?>,event);" onMouseOver="Tabla_Lista_Empresas.Enciende_Fila_MouseMove(<?php echo  $contador?>);" onMouseOut="Tabla_Lista_Empresas.Apaga_Fila_No_Clickeada(<?php echo $contador?>);"  <?php echo  $clase?>  >											
			<td width="10" ><?php echo  $contador?></td>						
			<td width="80" align="right" style="font-size:x-small"><?php echo  $Codigo; ?></td>
			<td width="150" align="left">
				<a href="javascript:Empresas_Menu(<?php echo  $Emp_ID?>);">
					<?php echo $Nombre; ?> 
				</a>
			</td>	
			<td width="83" align="left" style="font-size:x-small"><?php echo  $Estado; ?></td>
			<td width="80" align="right" style="font-size:x-small"><?php echo  $Ciudad; ?></td>	
			<td width="80" align="right" style="font-size:x-small"><?php echo  $Zip_Code; ?></td>	
			<td width="80" align="right" style="font-size:x-small"><?php echo  $Calle; ?></td>						
			<td width="80" align="right" style="font-size:x-small"><?php echo  $Telefono; ?></td>		
			<td width="80" align="right" style="font-size:x-small"><?php echo  $Detalles; ?></td>
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
<table width="100%">
	<tr>
		<td>					
		</td>
		<td align="right">			
			<?php 
				if (($contador-1)==1) 
					echo "<b> Total: ".($contador -1)." Company<b>";
				else
					echo "<b> Total: ".($contador -1.)." Companies<b>";		
			?>
		</td>
	</tr>
</table>
<?php
	if ($contador>10) {
?>
		<img src="images/spacer.gif" onload="Iniciliazar_Tabla('Tabla_Lista_Empresas',300);" />	 
<?php
	}		
?>
</fieldset>	
<?php
	require('Library/Close_Conexion.php');	
?>