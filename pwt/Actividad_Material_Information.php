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
	$Actividad_ID=$_GET['Actividad_ID'];

	$consulta = "select * FROM actividades WHERE Actividad_ID=".$Actividad_ID;
	$result2=$bd->ejecutar($consulta); 	
	while (($row2 = mysqli_fetch_array($result2) ))	
	{	
		$Fecha = $row2["Fecha"];
	}
	mysqli_free_result($result2);	
?> 

<fieldset>
	<legend><a href="#" onclick="Actividad_Material_Information_Maximizar(<?php echo $Actividad_ID;?>, <?php echo $Pro_ID;?>);">Submittals Infottrmation</a></legend>
	<table width="690" height="46" class="tabla_Datos_Items">
<thead>	
		  <tr>
				<th width="259" style="font-size:x-small;">Denomination</th>
<th width="49" style="font-size:x-small">Received </th>
			<th width="39" style="font-size:x-small">Used  </th>
			<th width="59" style="font-size:x-small">Estimated</th>	
			<th width="61" style="font-size:x-small">T.Ordered</th>
			<th width="65" style="font-size:x-small">T.Received</th>
			<th width="47" style="font-size:x-small">T.Used</th>
			<th width="75" style="font-size:x-small">% Used</th>
    </tr>	
		 </thead>	
		 <tbody>
<?php          	
	//$consulta = "SELECT m.* FROM materiales m WHERE m.Pro_ID=".$Pro_ID." OR p.Nombre='General Sundries' ";	
	$consulta = "select m.* FROM materiales m INNER JOIN proyectos p ON m.Pro_ID=p.Pro_ID ";
	$consulta = $consulta."  WHERE m.Pro_ID=".$Pro_ID." OR p.Nombre='General Sundries' ";	
	$consulta = $consulta."  ORDER BY Denominacion";	
	//echo $consulta;
	$contador=1; 	 	  	  

	$result2=$bd->ejecutar($consulta); 
	while (($row2 = mysqli_fetch_array($result2) ))	
	{	
		$Mat_ID = $row2["Mat_ID"];
		$Denominacion = $row2["Denominacion"];
		$Nombre_Generico=$row2["Nombre_Generico"];
		$Precio_Unitario = $row2["Precio_Unitario"];
		$Cantidad = $row2["Cantidad"];	
		$consulta = "SELECT SUM(Cantidad) as Cantidad_Ordenada, SUM(Cantidad_Recibida) as Cantidad_Recibida, SUM(Cantidad_Usada) as Cantidad_Usada FROM pedidos_material ";
		$consulta = $consulta . " WHERE Mat_ID=".$Mat_ID ;

		//echo  $consulta;	
		$result=$bd->ejecutar($consulta); 
		while (($row = mysqli_fetch_array($result) ))
		{	
			$Total_Cantidad_Ordenada = $row["Cantidad_Ordenada"];
			if (is_null($Total_Cantidad_Ordenada))
				$Total_Cantidad_Ordenada=0;
			$Total_Cantidad_Recibida = $row["Cantidad_Recibida"];
			if (is_null($Total_Cantidad_Recibida))
				$Total_Cantidad_Recibida=0;
				
			$Total_Cantidad_Usada=$row["Cantidad_Usada"];
			
			if (is_null($Total_Cantidad_Usada))
				$Total_Cantidad_Usada=0;

			$Saldo = $Total_Cantidad_Recibida - $Total_Cantidad_Usada;							

			if (  ( !(is_null($Cantidad) )  )   &&  ($Cantidad!=0)  )
			{
				$Por_Usada = ($Total_Cantidad_Usada*100)/$Cantidad;	
				$Por_Comprar = $Cantidad - $Total_Cantidad_Ordenada;
			}
			else
			{
				$Por_Usada = "&nbsp;";
				$Por_Comprar ="&nbsp;";
			}
		}
		mysqli_free_result($result);


		$consulta = "SELECT * FROM pedidos_material pm INNER JOIN pedidos p ON pm.Ped_ID=p.Ped_ID AND p.Fecha='".$Fecha."' ";
		$consulta = $consulta."  WHERE pm.Mat_ID=".$Mat_ID." AND (NOT (pm.Cantidad_Recibida is NULL)) ";	

		//echo $consulta."<bR>";

		$result=$bd->ejecutar($consulta); 	

		if (($row = mysqli_fetch_array($result) ))	
		{	
			$Ped_Mat_ID_Recibida = $row["Ped_Mat_ID"];
			$Cantidad_Recibida = $row["Cantidad_Recibida"];
		}
		else
		{
			$Cantidad_Recibida = 0;
		}
		mysqli_free_result($result);

		$consulta = "SELECT * FROM pedidos_material pm INNER JOIN pedidos p ON pm.Ped_ID=p.Ped_ID AND p.Fecha='".$Fecha."' ";
		$consulta = $consulta."  WHERE pm.Mat_ID=".$Mat_ID." AND (NOT (pm.Cantidad_Usada is NULL)) ";
		//echo $consulta."<bR>";
		$result=$bd->ejecutar($consulta); 

		if (($row = mysqli_fetch_array($result) ))	
		{	
			$Ped_Mat_ID_Usada = $row["Ped_Mat_ID"];
			$Cantidad_Usada = $row["Cantidad_Usada"];
		}
		else
		{
			$Cantidad_Usada = 0;
		}
		mysqli_free_result($result);	
		?>
			<tr >											
				<td height="15" align="left" style="font-size:x-small"><?php echo  $Denominacion; ?></td>
		        <td align="right" style="font-size:x-small">
					<div id="Cantidad_Recibida-<?php echo  $Pro_ID;?>-<?php echo  $Mat_ID;?>-<?php echo  $Actividad_ID;?>"><?php echo $Cantidad_Recibida;?></div>
					<img src="images/spacer.gif" onload="Atividades_Reporte_Diario_Material('Cantidad_Recibida-<?php echo  $Pro_ID;?>-<?php echo  $Mat_ID;?>-<?php echo  $Actividad_ID;?>');" />
				</td>
				<td align="right" style="font-size:x-small">
					<div id="Cantidad_Usada-<?php echo  $Pro_ID;?>-<?php echo  $Mat_ID;?>-<?php echo  $Actividad_ID;?>"><?php echo $Cantidad_Usada;?></div>
					<img src="images/spacer.gif" onload="Atividades_Reporte_Diario_Material('Cantidad_Usada-<?php echo  $Pro_ID;?>-<?php echo  $Mat_ID;?>-<?php echo  $Actividad_ID;?>');" />
				</td>
				<td align="right" style="font-size:x-small"><?php echo  $Cantidad; ?></td>
				<td align="right" style="font-size:x-small"><?php  echo  $Total_Cantidad_Ordenada; ?></td>
				<td align="right" style="font-size:x-small"><?php echo  $Total_Cantidad_Recibida;?></td>
				<td align="right" style="font-size:x-small"><?php echo  $Total_Cantidad_Usada;?></td>
				<td align="right" style="font-size:x-small"><?php echo  $Por_Usada;?></td>
		  </tr>
<?php
		$contador++;
	}
	mysqli_free_result($result2);	
?>	
		</tbody>
	</table> 
<img src="images/spacer.gif" onload="$('.tabla_Datos_Items').flexigrid({nowrap: false, showTableToggleBtn : true,width : 600,height :150, singleSelect: true	});" />  	
</fieldset>
<img src="images/spacer.gif" onload="Actividad_Task_Information(<?php echo $Actividad_ID;?>,<?php echo $Pro_ID;?>);" /> 
<?php
	require('Library/Close_Conexion.php');	
?>