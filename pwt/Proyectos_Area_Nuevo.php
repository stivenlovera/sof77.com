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

?> 

    <form action="#" id="Form_Proyectos_Area_Nuevo" name="Form_Proyectos_Area_Nuevo">

    <table width="75%">

    	<tr>

        	<td width="100%">             

				<fieldset>

					<legend><strong>Level 2 Info:</strong></legend>

					<table  cellpadding="2" cellspacing="2" width="100%">
                    <tr>

							<td width="150"><strong>Area Code::</strong></td>

					  	    <td  >

							<input name="Are_IDT" type="text" id="Are_IDT" size="20"/></td>

						</tr>		
                    

						<tr>

							<td width="150"><strong>Name:</strong></td>

					  	    <td  >

							<input name="Nombre" type="text" id="Nombre" size="40"/></td>

						</tr>						

						<tr>

							<td ><strong>Note:</strong></td>

							<td><input type="text" id="Note" name="Note" size="40"/></td>

						</tr>																			

						<tr>

							<td><strong># Units:</strong></td>

				      <td >

								<input name="Aux1" type="text" id="Aux1" size="15"/>

							</td>

						</tr>

						<tr>

							<td><strong>Aux2:</strong></td>

						    <td >

								<input name="Aux2" type="text" id="Aux2" size="50"/>

							</td>

						</tr>

						<tr>

							<td><strong>Aux3:</strong></td>

						    <td >

								<input name="Aux3" type="text" id="Aux3" size="50"/>

								<input name="Pro_ID" type="hidden" id="Pro_ID" value="<?php echo $Pro_ID; ?>"/>

							</td>

						</tr>											

					</table>

				</fieldset>

				

        	</td>                             

        </tr>

		<tr>

			<td valign="top">                                            

				<div style="display:block" id="div_res_new_area">

					<INPUT id="button" type="button" value="Add" name="button" onClick="Proyectos_Area_Nuevo_Registrar();">                

				</div>				

           	</td>       

		</tr>		

	</table>

</form>	

<?php

	require('Library/Close_Conexion.php');

?>