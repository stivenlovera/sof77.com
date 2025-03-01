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

<a role="button" href="https://app.sof77.com/auto-login-submittals?username=mo&password=mo&proyecto_id=<?php echo $Pro_ID?>" target="_blank" rel="noopener noreferrer">Export Excel</a>
<br>
<br>
<fieldset id="Fs_Lista_Cliente" class="" >

	<legend></legend>

<div>

	<table class="Tabla_Lista_Materiales">

		<thead>	

		  <tr>

				<th width="50">&nbsp;</th>	

				<th width="270">Denomination</th>

				<th width="50">Unit</th>

				<th width="70">Status</th>		

				<th width="100">Vendor</th>	

				<th width="100">Date Requested <br>
			    From  Vendor</th>

				<th width="100">Date Received<br>From vendor</th>

				<th width="100">Note vendor</th>

				<th width="100">Date Sent <br> to GC</th>

				<th width="100">Date Received<br>From GC</th>

				<th width="100">Note GC</th>	
				
				<th width="50">Total<br>Q.Needed</th>
                <th width="100">Q.Ordered</th>
				<th width="50">Unit Price</th>				
				<th width="100">Aux2</th>
				<th width="100">Aux2</th>
            <th width="70">Note</th>
			<th width="70">Apply to</th>
		  </tr>	
	  </thead>	
		 <tbody>

<?php  


 				       	

	$consulta = "SELECT m.*,sum(pm.Cantidad) as Pedidos, c.Nombre Categoria, v.Nombre as Vendedor FROM materiales m";

	$consulta = $consulta . " LEFT JOIN categoria_material c ON m.Cat_ID=c.Cat_ID  ";	

	$consulta = $consulta . " LEFT JOIN vendedor v ON v.Ven_ID=m.Ven_ID ";	
	$consulta = $consulta . " LEFT JOIN pedidos_material pm on pm.Mat_ID=m.Mat_Id  ";	
	$consulta = $consulta . " WHERE m.Pro_ID=".$Pro_ID;		

	$consulta = $consulta . " group by m.Mat_ID";
	$consulta = $consulta . " ORDER BY m.Cat_ID,m.Denominacion";
	
	//echo $consulta."<br>";
	//exit ();

	$contador=1;	 	  	 	  	  


$contasub=0;
	$result2=$bd->ejecutar($consulta); 	

	while (($row2 = mysqli_fetch_array($result2) ))							

	{		
		$contasub++;
		$Mat_ID = $row2["Mat_ID"];

		$Denominacion = $row2["Denominacion"];
		

		$Nombre_Generico=$row2["Nombre_Generico"];

		$Area_donde_va=$row2["Area_donde_va"];

		$Unidad_Medida = $row2["Unidad_Medida"];	

		$Cantidad = $row2["Cantidad"];	

		$Precio_Unitario = $row2["Precio_Unitario"];
		$Pedidos=$row2["Pedidos"];

		$Aux1 = $row2["Aux1"];			

		$Aux2 = $row2["Aux2"];

		$Aux3=$row2["Aux3"];

		$Fecha_from_vendor = $row2["Fecha_from_vendor"];

		$Fecha_to_vendor=$row2["Fecha_to_vendor"];

		$note_vendor = $row2["note_vendor"];

		$Fecha_from_gc=$row2["Fecha_from_gc"];

		$Fecha_to_gc = $row2["Fecha_to_gc"];

		$note_gc=$row2["note_gc"];

		
		$Categoria=$row2["Categoria"];

		$Vendedor=$row2["Vendedor"];			

		

	?>		

		<tr >											

			

			<td>

				 <a href="#">

					<img src="images/button_edit.gif" border="0" width="16" onclick="Proyectos_Materiales_Editar(<?php echo $Mat_ID; ?>,<?php echo $Pro_ID; ?>);" alt="Edit"/>	

				</a>								

				<a href="#">

					<img src="images/icon_eliminar_0_gif.gif" border="0" width="16" onclick="Proyectos_Materiales_Eliminar(<?php echo $Mat_ID; ?>,<?php echo $Pro_ID; ?>);" alt="Delete"/>		

				</a>				

			<td align="right" style="font-size:x-small"><?php echo  $contasub.":".$Denominacion; ?></td>

			<td align="right" style="font-size:x-small"><?php echo  $Unidad_Medida;?></td>

			<td align="left" style="font-size:x-small"><?php  echo  $Categoria; ?></td>		

			<td align="right" style="font-size:x-small"><?php echo  $Vendedor;?></td>	

			

			<td align="right" style="font-size:x-small"><?php echo  FormatDateTime($Fecha_to_vendor, 6);?></td>
            
<td align="right" style="font-size:x-small"><?php echo  FormatDateTime($Fecha_from_vendor, 6);?></td>

			<td align="right" style="font-size:x-small"><?php echo  $note_vendor;?></td>

			<td align="right" style="font-size:x-small"><?php echo  FormatDateTime($Fecha_to_gc, 6);?></td>
            
			<td align="right" style="font-size:x-small"><?php echo  FormatDateTime($Fecha_from_gc, 6);?></td>

			<td align="right" style="font-size:x-small"><?php echo  $note_gc;?></td>

			<td align="right" style="font-size:x-small"><?php echo  $Cantidad;?></td>
			<td align="right" style="font-size:x-small"><?php echo  $Pedidos;?></td>

			<td align="right" style="font-size:x-small"><?php echo  $Nombre_Generico; ?></td>

			<td align="right" style="font-size:x-small"><?php echo  $Area_donde_va; ?></td>			


			<td align="right" style="font-size:x-small"><?php echo  money_format("%= (#8.2n",($Precio_Unitario));?></td>			



			<td align="right" style="font-size:x-small"><?php echo  $Aux2;?></td>

			<td align="right" style="font-size:x-small"><?php echo  $Aux3;?></td>	
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

<img src="images/spacer.gif" onload="$('.Tabla_Lista_Materiales').flexigrid({nowrap: false, showTableToggleBtn : true,width : 1000,height :200, singleSelect: true	});" />	 

</fieldset>	



<style>
	.modal-open{overflow:hidden}.modal{position:fixed;top:0;right:0;bottom:0;left:0;z-index:1050;display:none;overflow:hidden;outline:0}.modal-open .modal{overflow-x:hidden;overflow-y:auto}.modal-dialog{position:relative;width:auto;margin:.5rem;pointer-events:none}.modal.fade .modal-dialog{transition:-webkit-transform .3s ease-out;transition:transform .3s ease-out;transition:transform .3s ease-out,-webkit-transform .3s ease-out;-webkit-transform:translate(0,-25%);transform:translate(0,-25%)}.modal.show .modal-dialog{-webkit-transform:translate(0,0);transform:translate(0,0)}.modal-dialog-centered{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;min-height:calc(100% - (.5rem * 2))}.modal-content{position:relative;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;width:100%;pointer-events:auto;background-color:#fff;background-clip:padding-box;border:1px solid rgba(0,0,0,.2);border-radius:.3rem;outline:0}.modal-backdrop{position:fixed;top:0;right:0;bottom:0;left:0;z-index:1040;background-color:#000}.modal-backdrop.fade{opacity:0}.modal-backdrop.show{opacity:.5}.modal-header{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:start;-ms-flex-align:start;align-items:flex-start;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;padding:1rem;border-bottom:1px solid #e9ecef;border-top-left-radius:.3rem;border-top-right-radius:.3rem}.modal-header .close{padding:1rem;margin:-1rem -1rem -1rem auto}.modal-title{margin-bottom:0;line-height:1.5}.modal-body{position:relative;-webkit-box-flex:1;-ms-flex:1 1 auto;flex:1 1 auto;padding:1rem}.modal-footer{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:end;-ms-flex-pack:end;justify-content:flex-end;padding:1rem;border-top:1px solid #e9ecef}.modal-footer>:not(:first-child){margin-left:.25rem}.modal-footer>:not(:last-child){margin-right:.25rem}.modal-scrollbar-measure{position:absolute;top:-9999px;width:50px;height:50px;overflow:scroll}@media (min-width:576px){.modal-dialog{max-width:500px;margin:1.75rem auto}.modal-dialog-centered{min-height:calc(100% - (1.75rem * 2))}.modal-sm{max-width:300px}}@media (min-width:992px){.modal-lg{max-width:800px}}
	.close{padding:1rem;margin:-1rem -1rem -1rem auto}
	button.close{padding:0;background-color:transparent;border:0;-webkit-appearance:none}
	@media only screen and (min-width: 580px) {
            .modal-lg {
                max-width: 80% !important;
            }
        }

        .file-footer-buttons>.btn {
            padding: 0.625rem 1rem;
            min-width: 0 !important;
            margin-top: 1rem;
        }
</style>
<script>
	$jq("#view_Excel").on('click', function(evt) {
		console.log("ene ejecucion")
		var options = {
			url: `https://app.sof77.com/submittals`,
			title: 'Preview',
			size: eModal.size.lg,
			buttons: [{
				text: 'ok',
				style: 'info',
				close: true,
				size: 'lg',
			}],
		};
		eModal.iframe(options);
	});
</script>
<?php

	require('Library/Close_Conexion.php');	

?>