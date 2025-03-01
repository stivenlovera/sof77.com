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

	<legend>List of Orders: </legend>

	<table>

		<tr>

			<td>

				<div>

					<table class="Tabla_Lista_Pedidos">

						<thead>	

						  <tr>

								<th width="100">&nbsp;</th>							 

								<th width="80" >P.O</th>

								<th width="70">Date</th>

								<th width="150">Vendor</th>

								<th width="200">User</th>														   								   											

						  </tr>	

						 </thead>	

						 <tbody>

				<?php   				       	

				//	$consulta = "SELECT pr.Codigo, p.*, o.Name, o.LastName, v.Nombre FROM pedidos p";
	$consulta = "SELECT pr.Codigo, p.*, o.Name, o.LastName,v.Nombre as Vnombre FROM pedidos p";


					$consulta = $consulta . " INNER JOIN proyectos pr ON pr.Pro_ID=p.Pro_ID  ";	

//					$consulta = $consulta . " INNER JOIN vendedor v ON p.Ven_ID=v.Ven_ID  ";	

					$consulta = $consulta . " INNER JOIN operators o ON o.OperatorID=p.OperatorID ";	
					$consulta = $consulta . " LEFT JOIN vendedor v ON v.Ven_ID=p.Ven_ID ";	

					$consulta = $consulta . " WHERE p.Pro_ID=".$Pro_ID;		

					$consulta = $consulta . " ORDER BY p.Fecha DESC, p.PO DESC ";		

					//echo $consulta."<br>";

					$contador=1;	 	  	 	  	  

				

					$result2=$bd->ejecutar($consulta); 	

					while (($row2 = mysqli_fetch_array($result2) ))							

					{		

						$PO = $row2["PO"];

						$Ped_ID = $row2["Ped_ID"];

						$Pro_ID = $row2["Pro_ID"];

						$Ven_ID = $row2["Ven_ID"];

						$Codigo = $row2["Codigo"];

						$OperatorID = $row2["OperatorID"];

						$Fecha = $row2["Fecha"];

						$Operador = $row2["Name"]." ".$row2["LastName"];	

						$Nombre = $row2["Vnombre"];	
						//$Nombre = " -- ";	

						

						$consulta = "SELECT * FROM pedidos_material p WHERE p.Ped_ID=".$Ped_ID;		

						$result22=$bd->ejecutar($consulta); 	

						if (($row22 = mysqli_fetch_array($result22) ))							

						{	

							$estilo="style=' font-size:x-small'";		 	

						}

						else

						{							

							$estilo="style=' font-size:x-small; background-color:#FF0000'";

						}

						mysqli_free_result($result22);		

						

					?>		

						<tr >											

							<td>

								 <a href="#">

									<img src="images/imp.png" border="0" width="18" height="15" onclick="Proyectos_Pedidos_Preview(<?php echo $Ped_ID; ?>,<?php echo $Pro_ID; ?>);" alt="Edit"/>	

								</a>	

								<a href="#">

									<img src="images/email.jpg" border="0" width="18" height="15" onclick="Proyectos_Pedidos_Email(<?php echo $Ped_ID; ?>,<?php echo $Pro_ID; ?>, <?php echo $Ven_ID; ?>);" alt="Edit"/>	

								</a>	

								 <a href="#">

									<img src="images/button_edit.gif" border="0" width="16" onclick="Proyectos_Pedidos_Editar(<?php echo $Ped_ID; ?>,<?php echo $Pro_ID; ?>);" alt="Edit"/>	

								</a>								

								<a href="#">

									<img src="images/icon_eliminar_0_gif.gif" border="0" width="16" onclick="Proyectos_Pedidos_Eliminar(<?php echo $Ped_ID; ?>,<?php echo $Pro_ID; ?>);" alt="Delete"/>		

								</a>				

							</td>

							<td <?php echo  $estilo; ?> ><?php echo  $PO; ?></td>						

							<td align="right" <?php echo  $estilo; ?> ><?php echo  FormatDateTime($Fecha, 8); ?></td>

							<td align="right" <?php echo  $estilo; ?> ><?php echo  $Nombre; ?></td>

							<td align="right" <?php echo  $estilo; ?> ><?php echo  $Operador; ?></td>							

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

						echo "<br><br>Not Found Record<br>";

					}				

					?>

				</div>				

			</td>

			<td>

				<div id="div_detalle_pedido">

				</div>

			</td>

		</tr>

	</table>		

	<img src="images/spacer.gif" onload="$('.Tabla_Lista_Pedidos').flexigrid({nowrap: false, showTableToggleBtn : true,width : 700,height :200, singleSelect: true	});" />	 

</fieldset>	

<?php

	require('Library/Close_Conexion.php');	

?>