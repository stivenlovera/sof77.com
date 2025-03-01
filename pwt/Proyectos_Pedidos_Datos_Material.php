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

	<table class="tabla_Datos_Items">

		<thead>	

		  <tr>

				<th width="200" style="font-size:x-small">Denomination</th>

				<th width="70" style="font-size:x-small">Q. Estimated</th>												   								   			

				<th width="70" style="font-size:x-small">Q. Ordered </th>			

				<th width="70" style="font-size:x-small">Q. Received </th>

				<th width="70" style="font-size:x-small">Q. Used </th>

				<th width="70" style="font-size:x-small">Ordered-Used</th>

				<th width="100" style="font-size:x-small">Estimate-Ordered</th>

				<th width="70" style="font-size:x-small">Price</th>

                <th width="120" style="font-size:x-small">Name Generic</th>

		  </tr>	

		 </thead>	

		 <tbody>

<?php   				       	

	$consulta = "SELECT m.* FROM materiales m WHERE m.Pro_ID=".$Pro_ID;		

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

		$result=$bd->ejecutar($consulta); 	

		while (($row = mysqli_fetch_array($result) ))							

		{		

			$Cantidad_Ordenada = $row["Cantidad_Ordenada"];

			if (is_null($Cantidad_Ordenada))

				$Cantidad_Ordenada=0;

				

			$Cantidad_Recibida = $row["Cantidad_Recibida"];

			if (is_null($Cantidad_Recibida))

				$Cantidad_Recibida=0;

				

			$Cantidad_Usada=$row["Cantidad_Usada"];		

			if (is_null($Cantidad_Usada))

				$Cantidad_Usada=0;

				

			$Saldo = $Cantidad_Recibida - $Cantidad_Usada;		

			$Por_Comprar = $Cantidad - $Cantidad_Ordenada ;

			

			

		}

		mysqli_free_result($result);		

		?>		

			<tr >											

				<td align="left" style="font-size:x-small"><?php echo  $Denominacion; ?></td>

				

				<td align="right" style="font-size:x-small"><?php echo  $Cantidad; ?></td>

				<td align="right" style="font-size:x-small"><?php  echo  $Cantidad_Ordenada; ?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Cantidad_Recibida;?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Cantidad_Usada;?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Saldo;?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Por_Comprar;?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Precio_Unitario;?></td>

                <td align="left" style="font-size:x-small"><?php echo  $Nombre_Generico; ?></td>

		  </tr>

<?php

		$contador++;

	}

	mysqli_free_result($result2);

	

?>	

		</tbody>

	</table> 

	<img src="images/spacer.gif" onload="$('.tabla_Datos_Items').flexigrid({nowrap: false, showTableToggleBtn : true,width : 900,height :100, singleSelect: true	});" />  	

<?php



	require('Library/Close_Conexion.php');	

?>