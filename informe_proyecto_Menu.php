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
	$_SESSION["Nombre"] = $_GET["Nombre"];	
	
	
?> 
<fieldset id="Fs_Lista_Cliente" class="" >
	<legend>List of Informes Job <?php echo $_GET["Nombre"]; ?>: </legend>
<div>
	<button title="New" onClick="informe_proyecto_nuevo(<?php echo $_GET["Pro_ID"];?>,'');">New</button>    
<table class="tabla_proyectos_listas">
	<thead>	
	  <tr>	
      		<th width="40">&nbsp;&nbsp;</th>
            <th width="70">Infrome ID</th>		
			<th width="70">Project</th>
			<th width="150">Name Project</th>
			<th width="150">Employe</th>
			<!--<th width="70">Status</th>
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
			<th width="100">Foreman PWT</th>-->				 
	  </tr>	
	 </thead>	
	 <tbody>
<?php   				       
	  					  
	$Pro_ID=$_GET['Pro_ID'];	
	
	$consulta = "SELECT *, p.Nombre as Proyecto, CONCAT(em.Nombre, ' ', em.Apellido_Paterno, ' ',  em.Apellido_Materno) AS Empleado FROM informe_proyecto i INNER JOIN proyectos p ON i.Pro_ID=p.Pro_ID ";
	$consulta = $consulta . " INNER JOIN personal em ON em.Empleado_ID=i.Empleado_ID ";	
	$consulta = $consulta." WHERE i.Pro_ID=".$Pro_ID." ORDER BY Informe_ID ";	
	
	//echo $consulta."<br>";
	$contador=1;	 	  	 	  	  

	$result2=$bd->ejecutar($consulta); 	
	while (($row2 = mysqli_fetch_array($result2) ))							
	{		
		$Pro_ID = $row2["Pro_ID"];
		$Codigo = $row2["Codigo"];
		$Proyecto = $row2["Proyecto"];
		$Informe_ID = $row2["Informe_ID"];
		$Empleado_ID = $row2["Empleado_ID"];
		$Empleado = $row2["Empleado"];
		$Fecha=$row2["Fecha"];
				
	?>   		
            <tr >
            	<td><img src="images/icon_nuevo_sintxt_0_gif.gif" onClick="informe_proyecto_nuevo(<?php echo $_GET["Pro_ID"];?>,<?php echo $Informe_ID;?>);"></td>	
                <td><?php echo $Informe_ID;?></td>				
                <td align="right" style="font-size:x-small"><?php echo  $Codigo; ?></td>
                <td align="right" style="font-size:x-small"><?php echo $Proyecto; ?></td>
                <td align="right" style="font-size:x-small"><?php echo  $Empleado; ?></td>
                <!--<td align="right" style="font-size:x-small"><?php //echo  $Nombre_Estatus; ?></td>
                <td align="right" style="font-size:x-small"><?php //echo  $Nombre_Tipo; ?></td>			
                <td align="left" style="font-size:x-small"><?php //echo  $Numero." ".$Calle.", ".$Ciudad.", ".$Estado." ".$Zip_Code; ?></td>
                <td align="right" style="font-size:x-small"><?php //echo  FormatDateTime($Fecha_Inicio, 8);?></td>
                <td align="right" style="font-size:x-small"><?php //echo  FormatDateTime($Fecha_Fin, 8);?></td>
                <td align="right" style="font-size:x-small"><?php //echo  $Horas;?></td>
                <td align="right" style="font-size:x-small"><?php //echo  $Precio;?></td>
                <td align="right" style="font-size:x-small"><?php //echo  $Project_Manager;?></td>
                <td align="right" style="font-size:x-small"><?php //echo  $Coordinador_Obra;?></td>
                <td align="right" style="font-size:x-small"><?php //echo  $Manager; ?></td>			
                <td align="right" style="font-size:x-small"><?php //echo  $Cordinador;?></td>			
                <td align="right" style="font-size:x-small"><?php //echo  $Foreman;?></td>-->
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