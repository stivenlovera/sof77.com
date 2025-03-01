<?php	 		

	session_name("Administrador");

	session_start();		

	if ($_SESSION["EntityID"] == "")

	{

		header("Location:sessionexpired.php"); 	

	}	 			

	require('Library/Control_Cache.php');

	require('Library/Open_Conexion.php');

	$Pro_ID=$_GET['Pro_ID'];	

	

	$consulta = "SELECT * FROM proyectos WHERE Pro_ID=".$Pro_ID;		

	$result2=$bd->ejecutar($consulta); 	

	while (($row2 = mysqli_fetch_array($result2) ))							

	{		

		$Codigo = $row2["Codigo"];

	}

	mysqli_free_result($result2);

	

	$consulta = "SELECT max(PO_Corr) as PO_Corr FROM pedidos Where Pro_ID=".$Pro_ID;		
	$result2=$bd->ejecutar($consulta); 
	

	while (($row2 = mysqli_fetch_array($result2) ))							
	{		
		$PO_Corr = $row2["PO_Corr"]+1;
	}
	mysqli_free_result($result2);
	

	if ($PO_Corr=="")
		$PO_Corr=1;


	$PO = $Codigo."-".$PO_Corr;

					

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

						<td width="41">P.O.:</td>

						<td width="474"  >

							<input name="PO" type="text" id="PO" size="10" value="<?php echo $PO;?>" />

							Date:

							<input name="Fecha_Pedido" type="text" id="Fecha_Pedido" size="20" value="<?php echo date('m-d-Y');?>" datepicker="true" datepicker_format="MM-DD-YYYY"/>

							<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Pedido"));' />

							Vendor:

							<?php

									$sql = "select Ven_ID, Nombre FROM vendedor order by Nombre";														

									$result=$bd->ejecutar($sql); 		 

								?>

									<select size="1" name="Ven_ID" id="Ven_ID"  class="cuadro">      

										<option  value="">--Select Vender--</option>

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

									<input name="Pro_ID" type="hidden" id="Pro_ID" value="<?php echo $Pro_ID; ?>"/>
									<input name="PO_Corr" type="hidden" id="PO_Corr" value="<?php echo $PO_Corr; ?>"/>

					  </td>

					</tr>

					<tr>

						<td width="41">Note:</td>

						<td >							

							<textarea id="Note" name="Note" cols="60" rows="2">Please deliver to the job site tomorrow morning early.</textarea>

						</td>

						<td width="38" valign="bottom" align="left">							

							<div style="display:block" id="div_btn_new_pedido">	

								<INPUT id="button" type="button" value="Add" name="button" onClick="Proyectos_Pedidos_Nuevo_Registrar();">

							</div>

					  </td>

					</tr>														

				</table>					

        	</td>                             

        </tr>

		<tr>

			<td valign="top">                                            							

				<div style="display:block" id="div_res_new_pedido">					

				</div>           	

			</td>       

		</tr>		

	</table>

</form>			

<?php

	require('Library/Close_Conexion.php');

?>