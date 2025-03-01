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

	$Pro_ID=$_GET['Pro_ID'];	

	

	$consulta = "SELECT p.*, v.Nombre FROM pedidos p";

	$consulta = $consulta . " INNER JOIN vendedor v ON p.Ven_ID=v.Ven_ID  ";	

	$consulta = $consulta . " WHERE p.Ped_ID=".$Ped_ID;		



	//echo $consulta."<br>";

	$contador=1;	 	  	 	  	  



	$result2=$bd->ejecutar($consulta); 	

	while (($row2 = mysqli_fetch_array($result2) ))							

	{		

		$Ven_ID = $row2["Ven_ID"];

		$Fecha = $row2["Fecha"];

		$Note = $row2["Note"];	

		$PO = $row2["PO"];			

		

		if ( !(is_null($Fecha)) )		

			$Fecha=FormatDateTime($Fecha, 6);

		else

			$Fecha="";

	}

	mysqli_free_result($result2);

?> 	

    <form id="Form_Proyectos_Pedidos_Nuevo" name="Form_Proyectos_Pedidos_Nuevo">

    <table width="100%">

    	<tr>

        	<td width="100%">             				

				<table  cellpadding="2" cellspacing="2" width="100%">

					<tr>

						<td colspan="2">

							<p><b><span style="font-size:x-large">Purchase Order</span></b></p>

						</td>

					</tr>

					<tr>

						<td width="82">P.O.:</td>

						<td width="614"  >

							<input name="PO" type="text" id="PO" size="10" value="<?php echo $PO;?>" />

							Date:

							<input name="Fecha_Pedido" type="text" id="Fecha_Pedido" size="20" value="<?php echo $Fecha;?>" datepicker="true" datepicker_format="MM-DD-YYYY"/>

							<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Pedido"));' />

							Vendor:

							<?php

								$sql = "select Ven_ID, Nombre FROM vendedor order by Nombre";														

								$result=$bd->ejecutar($sql); 		 

							?>

								<select size="1" name="Ven_ID" id="Ven_ID"  class="cuadro">      

									<option  value="">--Select Vendor--</option>

							<?php		

									while (($row = mysqli_fetch_array($result) ))							

									{								

							?>

										<option value="<?php echo  $row["Ven_ID"];?>"><?php echo $row["Nombre"];?></option>

							<?php

									}

									mysqli_free_result($result);	

							?>

								</select> 

								<input name="Ped_ID" type="hidden" id="Ped_ID" value="<?php echo $Ped_ID; ?>"/>

								<input name="Pro_ID" type="hidden" id="Pro_ID" value="<?php echo $Pro_ID; ?>"/>

								<img src="images/spacer.gif" height="1" width="1" onload="$('#Ven_ID').val(<?php echo $Ven_ID;?>)" />

					  </td>

					</tr>

					<tr>

						<td width="82">Note:</td>

						<td >							

							<textarea id="Note" name="Note" cols="60" rows="2"><?php echo $Note; ?></textarea>

						</td>

						<td width="406" valign="bottom" align="left">							

							<span style="display:block" id="div_res_new_pedido">

								<INPUT id="button" type="button" value="Save" name="button" onClick="Proyectos_Pedidos_Editar_Registrar();">

						  </span>					

					  </td>

					</tr>														

				</table>				

        	</td>                             

        </tr>

	</table>

</form>		

	<form action="#" id="form_pedidos_nuevo_item" name="form_pedidos_nuevo_item">

		<table  width="100%" cellpadding="2" cellspacing="2">

			<tr>

			  <td>											

					<b>Material: </b> 

					<?php

						//$sql = "select Mat_ID, Denominacion,Nombre_Generico, Unidad_Medida FROM materiales WHERE Pro_ID=".$Pro_ID." ORDER BY Denominacion";				

						$sql = "select m.Mat_ID, m.Denominacion, m.Cat_ID, m.Unidad_Medida FROM materiales m INNER JOIN proyectos p ON m.Pro_ID=p.Pro_ID  INNER JOIN categoria_material c on m.Cat_ID=c.Cat_ID";

						$sql = $sql."  WHERE m.Pro_ID=".$Pro_ID." OR p.Codigo='000.00.0' ";														

						$sql = $sql."  ORDER BY Cat_ID,Denominacion";										

						$result=$bd->ejecutar($sql); 

								 

					?>

						<select size="1" name="Mat_ID_Pedido" id="Mat_ID_Pedido"  class="cuadro edit_material"b>      

							<option  value="">--Select Material--</option>

					<?php		

							while (($row = mysqli_fetch_array($result) ))							

							{								

					?>

								<option value="<?php echo  $row["Mat_ID"];?>"><?php echo ($row["Denominacion"]."-".$row["Nombre_Generico"]."-".$row["Unidad_Medida"]." /".$row["c.Nombre"]);?></option>

					<?php

							}

							mysqli_free_result($result);	

					?>

						</select> 

						<input name="Ped_ID_Item" type="hidden" id="Ped_ID_Item" value="<?php echo $Ped_ID; ?>"/>

						<input name="Ped_Mat_ID" type="hidden" id="Ped_Mat_ID" value=""/>

						

						<b>Quantity:</b>

						<input name="Cantidad" type="text" id="Cantidad" value="" size="10"/> 											

						&nbsp;&nbsp;&nbsp;						

						<span  id="span_bnt_New" >

							<INPUT type='button' value='Add' id='Boton_Agregar_Item' name='Boton_Agregar_Item' onClick='Proyectos_Pedidos_Nuevo_Item_Registrar();'>						

						</span> 

						<span id="span_bnt_save" style="display:none">

							<INPUT id="button" type="button" value="Save" name="button" onClick="Proyectos_Pedidos_Items_Editar_Guardar();">   

							<INPUT id="button" type="button" value="Cancel" name="button" onClick="Proyectos_Pedidos_Items_Cancelar();"> 					

						</span>						 

			  </td>

			</tr>
			<tr>
					<td>
						<b>Detail: </b> &nbsp;&nbsp;&nbsp;
						<input name="item_detalle" type="text" id="item_detalle" value="" size="50"/> 
					</td>
			</tr>		

			<tr>

				<td>					

					<div id="div_pedido_lista_items" name="div_pedido_lista_items"></div>	

				</td>

			</tr>

		</table>						

	</form>			

	<fieldset id="Fs_Lista_Cliente" class="" >

			<legend>Submittals - Equipment, Tools and Sundries</legend>

			<div id="Div_Datos_Material"></div>

		</fieldset>

	<img src='images/spacer.gif' onload='Proyectos_Pedidos_Datos_Material(<?php echo $Pro_ID;?>);' />

<?php

	echo "<img src='images/spacer.gif' onload='Proyectos_Pedidos_Items_Lista($Ped_ID);' />"; 	

	require('Library/Close_Conexion.php');

?>
<script>
	$jq(document).ready(function() {
		$jq('.edit_material').select2();
	});
</script>