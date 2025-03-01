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
	
	$Fecha_Inicio_Busqueda=ConvertDateToMysqlFormat($_GET['Fecha_Inicio_Busqueda']);	
	$Fecha_Fin_Busqueda=ConvertDateToMysqlFormat($_GET['Fecha_Fin_Busqueda']);	
	$Pro_ID_Reporte=$_REQUEST["Pro_ID_Reporte"];	
?> 
<fieldset id="Fs_Lista_Cliente" class="" >
	<legend></legend>
<div>
<table class="Tabla_Report_By_Person_Lista"  >
	<thead>	
	  <tr>
			<th width="200">Nick_Name</th>
			<th width="70"># Job</th>				
			<th width="200">Name</th>								   								   			
		    <th width="200">Date</th>
			<th width="200">Hours in Contract</th>
			<th width="200">Hours on Ticket Work</th>
	  </tr>	
	 </thead>	
	 <tbody>
<?php   				       	
	$consulta = "SELECT p.Nick_Name, pr.Codigo, pr.Nombre, a.Fecha, SUM(HContract) AS HContract, SUM(HTM) AS HTM ";
	$consulta = $consulta . " FROM personal p INNER JOIN actividad_personal ap ON  p.Empleado_ID=ap.Empleado_ID ";
	$consulta = $consulta . " INNER JOIN actividades a ON a.Actividad_ID=ap.Actividad_ID ";
	$consulta = $consulta . " INNER JOIN proyectos pr ON a.Pro_ID=pr.Pro_ID ";
	$consulta = $consulta . " WHERE a.Fecha>='".$Fecha_Inicio_Busqueda."' AND  a.Fecha<='".$Fecha_Fin_Busqueda."' ";
	
	if ($Pro_ID_Reporte!=-33)	
		$consulta = $consulta . " AND pr.Pro_ID=$Pro_ID_Reporte ";
		
	
	
	$consulta = $consulta . " GROUP BY p.Nick_Name, pr.Codigo, pr.Nombre, a.Fecha ";
	$consulta = $consulta . " ORDER BY  p.Nick_Name";
	
	//echo $consulta."<br>";
	$contador=1;	 	  	 	  	  

	$result2=$bd->ejecutar($consulta); 	
	while (($row2 = mysqli_fetch_array($result2) ))							
	{			
		$Nick_Name = $row2["Nick_Name"];
		$Codigo = $row2["Codigo"];
		$Nombre = $row2["Nombre"];
		$Fecha  = $row2["Fecha"];	
		$HContract = $row2["HContract"];
		$HTM = $row2["HTM"];	
	?>		
		<tr >											
			<td align="right" style="font-size:x-small"><?php echo  $Nick_Name; ?></td>
			<td align="right" style="font-size:x-small"><?php echo  $Codigo; ?></td>
			<td align="right" style="font-size:x-small"><?php echo  $Nombre; ?></td>
			<td align="right" style="font-size:x-small"><?php echo  $Fecha; ?></td>		
			<td align="right" style="font-size:x-small"><?php echo  $HContract; ?></td>		
			<td align="right" style="font-size:x-small"><?php echo  $HTM; ?></td>		
	  </tr>
<?php    		
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
<img src="images/spacer.gif" onload="$('.Tabla_Report_By_Person_Lista').flexigrid({nowrap: false, showTableToggleBtn : true,width : 1000,height :200, singleSelect: true	});" />	 
</fieldset>	
<?php
	require('Library/Close_Conexion.php');	
?>