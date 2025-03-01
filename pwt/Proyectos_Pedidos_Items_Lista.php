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

	

	$Ped_ID=$_GET['Ped_ID'];	

?> 

	<table>

		<tr>

			<td>

				<div>

					<table class="Tabla_Pedidos_Items_Lista">

						<thead>	

						  <tr>

								<th width="50"></th>

							<th width="250">Denomination</th>

								

								<th width="50">Status</th>

								<th width="50">Quantity</th>

                                <th width="40">Unit</th>

								<th width="50">Price/U</th>	

                                <th width="150">Generic Name</th>													 

								<th width="150">Aux1</th>													 

						  </tr>	

						 </thead>	

						 <tbody>

				<?php   				       	

					$consulta = "SELECT p.Ped_Mat_ID, p.Ped_ID, p.Mat_ID, m.Denominacion, m.Nombre_Generico, m.Unidad_Medida, p.Cantidad, m.Precio, c.Nombre as Categoria, p.Aux1 FROM pedidos_material p ";

					$consulta = $consulta . " INNER JOIN materiales m ON p.Mat_ID=m.Mat_ID  ";	

					$consulta = $consulta . " INNER JOIN categoria_material c ON c.Cat_ID=m.Cat_ID  ";	

					$consulta = $consulta . " WHERE p.Ped_ID=".$Ped_ID;		

					$consulta = $consulta . " ORDER BY m.Denominacion ";		

					//echo $consulta."<br>";

					$contador=1;	 	  	 	  	  

				

					$result2=$bd->ejecutar($consulta); 	

					while (($row2 = mysqli_fetch_array($result2) ))							

					{		

						$Ped_Mat_ID = $row2["Ped_Mat_ID"];

						$Ped_ID = $row2["Ped_ID"];

						$Mat_ID = $row2["Mat_ID"];

						$Denominacion = $row2["Denominacion"];

						

						$Categoria = $row2["Categoria"];	

						$Cantidad = Number_format($row2["Cantidad"],2);

						$Unidad_Medida = $row2["Unidad_Medida"];

						$Precio = Number_Format($row2["Precio"],2);

						$Nombre_Generico = $row2["Nombre_Generico"];
						
						$item_detalle = $row2["Aux1"];

											

					?>		

						<tr >											

							<td>

								 <a href="#">

									<img src="images/button_edit.gif" border="0" width="16" onclick="Proyectos_Pedidos_Item_Editar(<?php echo $Ped_Mat_ID; ?>,<?php echo $Ped_ID; ?>, <?php echo $Mat_ID; ?>, <?php echo $Cantidad; ?>, '<?php echo $item_detalle; ?>');" alt="Edit"/>	

								</a>								

								<a href="#">

									<img src="images/icon_eliminar_0_gif.gif" border="0" width="16" onclick="Proyectos_Pedidos_Item_Eliminar(<?php echo $Ped_Mat_ID; ?>,<?php echo $Ped_ID; ?>);" alt="Delete"/>		

								</a>				

							</td>

							<td align="right" style="font-size:x-small"><?php echo  $Denominacion; ?>&nbsp;</td>							

							<td align="right" style="font-size:x-small"><?php echo  $Categoria; ?>&nbsp;</td>	

							<td align="right" style="font-size:x-small"><?php echo  $Cantidad; ?>&nbsp;</td>

                            <td align="right" style="font-size:x-small"><?php echo  $Unidad_Medida; ?>&nbsp;</td>

							<td align="right" style="font-size:x-small"><?php echo  $Precio; ?>&nbsp;</td>

                            <td align="right" style="font-size:x-small"><?php echo  $Nombre_Generico; ?>&nbsp;</td>	
							
							<td align="right" style="font-size:x-small"><?php echo  $item_detalle; ?>&nbsp;</td>														

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

			</td>

			<td>

				<div id="div_detalle_pedido">

				</div>

			</td>

		</tr>

	</table>		

	<img src="images/spacer.gif" onload="$('.Tabla_Pedidos_Items_Lista').flexigrid({nowrap: false, showTableToggleBtn : true,width : 900,height :100, singleSelect: true	});" />	 

<?php

	require('Library/Close_Conexion.php');	

?>