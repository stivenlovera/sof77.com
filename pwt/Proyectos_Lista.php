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
	<legend>List of Projects/: </legend>
<div>
<table class="tabla_proyectos_listas">
	<thead>	
	  <tr>
			<th width="80">&nbsp;</th>		
			<th width="70">Project</th>
			<th width="150">Name Project</th>
			<th width="150">GC - Company</th>
			<th width="70">Status</th>
			<th width="70">Type</th>														   								   			
		    <th width="200">Address</th>			
			<th width="100">Start Date</th>
			<th width="100">End Date</th>
			<th width="100">Time</th>
			<th width="100">Price</th>
			<th width="100">Project Manager</th>
			<th width="100">Superintendent</th>
			<th width="100">Project Manager PWT</th>
			<th width="100">Project Coordinator PWT</th>
			<th width="100">Foreman PWT</th>				 
	  </tr>	
	 </thead>	
	 <tbody>
<?php   				       
	  					  
	$Company=$_GET['Company'];	
	$Name=$_GET['Name'];	
	$State=$_GET['State'];	
	$City=$_GET['City'];	
	$Zip_Code=$_GET['Zip_Code'];	
	$Address=$_GET['Address'];	
	
	/*$consulta = "SELECT p.*, e.Nombre as Company FROM proyectos p INNER JOIN empresas e ON p.Emp_ID=e.Emp_ID WHERE ";	*/
	
	$consulta = "SELECT p.*, t.Nombre_Tipo, e.Nombre_Estatus,  em.Nombre as Company, ";
	
	$consulta = $consulta . " CONCAT(em1.Nombre, ' ', em1.Apellido_Paterno, ' ',  em1.Apellido_Materno) as Foreman, ";
	$consulta = $consulta . " CONCAT(em2.Nombre, ' ',  em2.Apellido_Paterno, ' ',  em2.Apellido_Materno) as Cordinador, ";
	$consulta = $consulta . " CONCAT(em3.Nombre, ' ',  em3.Apellido_Paterno, ' ',  em3.Apellido_Materno) as Manager, ";
	$consulta = $consulta . " CONCAT(em4.Nombre, ' ',  em4.Apellido_Paterno, ' ',  em4.Apellido_Materno) as Project_Manager, ";
	$consulta = $consulta . " CONCAT(em5.Nombre, ' ',  em5.Apellido_Paterno, ' ',  em5.Apellido_Materno) as Coordinador_Obra  FROM proyectos p ";
	$consulta = $consulta . " LEFT JOIN tipo_proyecto t ON p.Tipo_ID=t.Tipo_ID  ";
	$consulta = $consulta . " INNER JOIN empresas em ON p.Emp_ID=em.Emp_ID ";		
	$consulta = $consulta . " LEFT JOIN estatus e ON p.Estatus_ID=e.Estatus_ID ";		
	
	$consulta = $consulta . " LEFT JOIN personal em1 ON em1.Empleado_ID=p.Foreman_ID ";		
	$consulta = $consulta . " LEFT JOIN personal em2 ON em2.Empleado_ID=p.Coordinador_ID ";		
	$consulta = $consulta . " LEFT JOIN personal em3 ON em3.Empleado_ID=p.Manager_ID ";	
	
	$consulta = $consulta . " LEFT JOIN personal em4 ON em4.Empleado_ID=p.Project_Manager_ID ";		
	$consulta = $consulta . " LEFT JOIN personal em5 ON em5.Empleado_ID=p.Coordinador_Obra_ID WHERE  1=1 ";	
	
	
	if ( $_GET['Name'] !=""  )
	$consulta = $consulta." AND (p.Nombre like '%".$_GET['Name']."%'  "." OR p.Codigo like '%".$_GET['Name']."%'  )";   
	
	if ( $_GET['Company'] != ""  )
	$consulta = $consulta." AND (em.Nombre like '%".$_GET['Company']."%' )";     
		
	if ($_GET['State'] != ""  )
		$consulta = $consulta." AND p.Estado like '%".$_GET['State']."%' " ; 
	
	if ($_GET['City'] != ""  )
		$consulta = $consulta." AND p.Ciudad like '%".$_GET['City']."%' ";
		
	if ($_GET['Zip_Code'] != ""  )
		$consulta = $consulta." AND p.Zip_Code like '%".$_GET['Zip_Code']."%' ";		
	
	if ($_GET['Estatus_ID'] != ""  )
		$consulta = $consulta." AND p.Estatus_ID=".$_GET['Estatus_ID']." ";	
	
	if ($_GET['Criterio'] != ""  )
		$consulta = $consulta." ".$_GET['Criterio'];		
		
	

	$consulta = $consulta." ORDER BY p.Estatus_ID,p.Nombre";	
	
	//echo $consulta."<br>";
	$contador=1;	 	  	 	  	  

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
		$Fecha_Inicio=$row2["Fecha_Inicio"];
		$Fecha_Fin=$row2["Fecha_Fin"];
		$Horas=$row2["Horas"];
		$Precio=$row2["Precio"];
		$Project_Manager=$row2["Project_Manager"];
		$Coordinador_Obra=$row2["Coordinador_Obra"];
		
		$Foreman=$row2["Foreman"];
		$Cordinador=$row2["Cordinador"];
		$Manager=$row2["Manager"];
		$Company=$row2["Company"];				
	?>	
		<tr >											
			<td>
				 <a href="#">
					<img src="images/button_edit.gif" border="0" width="16" onclick="Proyecto_Editar(<?php echo $Pro_ID; ?>);" alt="Edit"/>	
				</a>				
				<a href="#">
					<img src="images/icon_eliminar_0_gif.gif" border="0" width="16" onclick="Proyecto_Eliminar(<?php echo $Pro_ID; ?>);$('#basic-modal-content-espera').modal();return false;"/>
				</a>
			</td>			
			<td align="right" style="font-size:x-small"><?php echo  $Codigo; ?></td>
			<td align="right" style="font-size:x-small">
				<a href="javascript:Proyectos_Menu(<?php echo  $Pro_ID?>);">
					<?php echo $Nombre; ?> 
				</a>
			</td>
			<td align="right" style="font-size:x-small"><?php echo  $Company; ?></td>
			<td align="right" style="font-size:x-small"><?php echo  $Nombre_Estatus; ?></td>
			<td align="right" style="font-size:x-small"><?php echo  $Nombre_Tipo; ?></td>			
			<td align="left" style="font-size:x-small"><?php echo  $Numero." ".$Calle.", ".$Ciudad.", ".$Estado." ".$Zip_Code; ?></td>
			<td align="right" style="font-size:x-small"><?php echo  FormatDateTime($Fecha_Inicio, 8);?></td>
			<td align="right" style="font-size:x-small"><?php echo  FormatDateTime($Fecha_Fin, 8);?></td>
			<td align="right" style="font-size:x-small"><?php echo  $Horas;?></td>
			<td align="right" style="font-size:x-small"><?php echo  $Precio;?></td>
			<td align="right" style="font-size:x-small"><?php echo  $Project_Manager;?></td>
			<td align="right" style="font-size:x-small"><?php echo  $Coordinador_Obra;?></td>
			<td align="right" style="font-size:x-small"><?php echo  $Manager; ?></td>			
			<td align="right" style="font-size:x-small"><?php echo  $Cordinador;?></td>			
			<td align="right" style="font-size:x-small"><?php echo  $Foreman;?></td>
	  </tr>
		<?php    		
			$contador++;								 								
	}
	mysqli_free_result($result2);		
			?>
		</tbody>
	</table>   	
</div>
<img src="images/spacer.gif" onload="$('.tabla_proyectos_listas').flexigrid({nowrap: false, showTableToggleBtn : true,width : 1000,height :200, singleSelect: true	});" />	 
</fieldset>	
<?php
	require('Library/Close_Conexion.php');	
?>