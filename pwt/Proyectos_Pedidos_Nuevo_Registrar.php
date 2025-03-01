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

				         					  

	foreach($_POST as $nombre_campo => $valor)

	{

	   	

	   	if  ( !empty($valor )  )

			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";			

		else

			$asignacion = "\$" . $nombre_campo . "='';";			

			

	   	eval($asignacion);

	} 		

	

	$Fecha_Pedido=ConvertDateToMysqlFormat($Fecha_Pedido);

	

	$strSQL = "INSERT INTO pedidos (Pro_ID, Ven_ID, OperatorID, Fecha, PO, PO_Corr, Note) ";	

	$strSQL = $strSQL . " values (".$Pro_ID."," . $Ven_ID . "," . $_SESSION["OperatorID"]. ",'" . $Fecha_Pedido. "', '" . $PO. "', '" . $PO_Corr. "', '" . $Note. "')";		

  

	//echo $strSQL."<br>";				

	$res1=$bd->ejecutar($strSQL);  		

	if ($res1)

	{

		echo "Saved"; 								

		echo "<img src='images/spacer.gif' onload='Proyectos_Pedidos_Lista($Pro_ID);' />"; 

		

		$consulta3 = "SELECT MAX(Ped_ID) as Ped_ID FROM pedidos";

		$result3=$bd->ejecutar($consulta3); 	

		while (($row3 = mysqli_fetch_array($result3) ))							

		{		

			$Ped_ID = $row3["Ped_ID"];

		}	

		mysqli_free_result($result3);		

	?>

		 <form action="#" id="form_pedidos_nuevo_item" name="form_pedidos_nuevo_item">

			<table  width="100%" cellpadding="2" cellspacing="2">

				<tr>

				  <td>											

					<p><b>Material:</b>
					  <?php

							$sql = "select m.Mat_ID, m.Denominacion, m.Cat_ID FROM materiales m INNER JOIN proyectos p ON m.Pro_ID=p.Pro_ID ";

							$sql = $sql."  WHERE m.Pro_ID=".$Pro_ID." OR p.Codigo='000.00.0' ";														

							$sql = $sql."  ORDER BY Cat_ID,Denominacion";

							//echo $sql;														

							$result=$bd->ejecutar($sql); 		 

						?>
						  
					  <select size="1" name="Mat_ID_Pedido" id="Mat_ID_Pedido"  class="cuadro new_material">      
						    
					    <option  value="">--Select Material--</option>
						    
					    <?php		

								while (($row = mysqli_fetch_array($result) ))							

								{								

						?>
						    
					    <option value="<?php echo  $row["Mat_ID"];?>"><?php echo substr($row["Denominacion"],0,58);?></option>
						    
					    <?php

								}

								mysqli_free_result($result);	

						?>
						    
				      </select> 
						  
					  <input name="Ped_ID_Item" type="hidden" id="Ped_ID_Item" value="<?php echo $Ped_ID; ?>"/>
						  
					  <b>Quantity:</b>
					  <input name="Cantidad" type="text" id="Cantidad" value="" size="7"/>
					  <INPUT type='button' value='Add' id='Boton_Agregar_Item' name='Boton_Agregar_Item' onClick='Proyectos_Pedidos_Nuevo_Item_Registrar();'>
				    </p>

							

					</td>

				</tr>
				<tr>
					<td>
						<b>Detail or note: </b> 
						<input type="text" name="item_detalle" id="item_detalle" value="" size="30"/>
					</td>
				</tr>	

				<tr>

					<td>

						<div id="div_pedido_lista_items" name="div_pedido_lista_items"></div>

					</td>

				</tr>

			</table>						

		</form>	

		<img src='images/spacer.gif' onload='Proyectos_Pedidos_Datos_Material(<?php echo $Pro_ID;?>);' />

		<fieldset id="Fs_Lista_Cliente" class="" >

			<legend>Submittals - Equipment, Tools and Sundries</legend>

			<div id="Div_Datos_Material"></div>

		</fieldset>

<?php

	}

	else

	{

		echo "ERROR";

	}

	

	require('Library/Close_Conexion.php');	

?>

<script>
	$jq(document).ready(function() {
		$jq('.new_material').select2();
	});
</script>