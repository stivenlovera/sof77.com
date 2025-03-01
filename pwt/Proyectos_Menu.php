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

	

	$Pro_ID=trim($_GET['Pro_ID']);
	$_SESSION["Pro_ID"]=$Pro_ID;
	

	$PUEDE_VER_PROYECTOS=validaRol(4,$bd);	

	$PUEDE_VER_PERSONAL=validaRol(5,$bd);

	$PUEDE_VER_DATOS=validaRol(6,$bd);

	$PUEDE_VER_LOGS=validaRol(7,$bd);

	

	$consulta = "SELECT * FROM proyectos WHERE Pro_ID=".$Pro_ID;    		

	$result2=$bd->ejecutar($consulta);
	 	

	while (($row2 = mysqli_fetch_array($result2) ))							

	{		

		$Codigo = $row2["Codigo"];	

		$Nombre = $row2["Nombre"];

	}

	mysqli_free_result($result2);	

?> 



<div id='div_menu_cliente_aux'>

	<fieldset id="Datos Cliente" class="" >

		<legend>Job: <?php echo $Codigo." ".$Nombre; ?></legend>	

		<table border="0" cellpadding="0" cellspacing="0" width="100%">

			<tr>

				<td align="left">

					<div id=tabmenu>

						<ul > 	

							<?php 

							if ($PUEDE_VER_PROYECTOS) 

							{

							?>

								<li onclick="makeactive(1,<?php echo $Pro_ID; ?>)"><a class="" id="tab1"><span>Submittals</span></a></li> 				

							

							

							

							<?php 

							}

							else

							{

							?>

								<span id="tab1"></span>

							<?php 

							} 

								

							if ($PUEDE_VER_PERSONAL) 

							{

							?>

								<li onclick="makeactive(2,<?php echo $Pro_ID; ?>)"><a class="" id="tab2"><span>Orders</span></a></li> 				

							<?php 

							} 

							else

							{

							?>

								<span id="tab2"></span>

							<?php 

							} 								

							if ($PUEDE_VER_DATOS) 

							{

							?>

								<li onclick="makeactive(3,<?php echo $Pro_ID; ?>)"><a class="" id="tab3"><span>Control Area</span></a></li> 				

							<?php 

							} 

							else

							{

							?>

								<span id="tab3"></span>

							<?php 

							}

							

							if ($PUEDE_VER_LOGS) 

							{

							?>

								<li onclick="makeactive(4,<?php echo $Pro_ID; ?>)"><a class="" id="tab4"><span>.</span></a></li> 				

							<?php 

							} 

							else

							{

							?>

								<span id="tab4"></span>

							<?php 

							}	

														

							if ($PUEDE_VER_LOGS) 

							{

							?>

								<li onclick="makeactive(5,<?php echo $Pro_ID; ?>)"><a class="" id="tab5"><span>Activities</span></a></li> 				

							<?php 

							} 

							else

							{

							?>

								<span id="tab5"></span>

							<?php 

							}	

							

							if ($PUEDE_VER_DATOS) 

							{

							?>

								<li onclick="makeactive(6,<?php echo $Pro_ID; ?>)"><a class="" id="tab6"><span>Levels 1,2,3 Or Floors</span></a></li> 				

							<?php 

							} 

							else

							{

							?>

								<span id="tab6"></span>

							<?php 

							}							

							if ($PUEDE_VER_DATOS) 

							{

							?>

								<li onclick="makeactive(7,<?php echo $Pro_ID; ?>)"><a class="" id="tab7"><span>Import</span></a></li> 				

							<?php 

							} 

							else

							{

							?>

								<span id="tab7"></span>

							<?php 

							}							


							?>								

						</ul> 

					</div><br>

				</td>

			</tr>

			<tr>

				<td >	

					<div id="dropInfo1" class="dropcontent" style="display:none">

						<FORM><input type="button" value="New Submittals" onclick="Proyectos_Materiales_Nuevo(<?php echo  $Pro_ID?>);" /></FORM>

						<div id="Div_Proyectos_Materiales_Lista"></div>

					</div>

					<div id="dropInfo2" class="dropcontent" style="display:none">

						<FORM><input type="button" value="New Order" onclick="Proyectos_Pedidos_Nuevo(<?php echo  $Pro_ID?>);" /></FORM>

					   	<div id="Div_Proyectos_Pedidos_Lista"></div>

					</div>	

					<div id="dropInfo3" class="dropcontent" style="display:none">

						<FORM><input type="button" value="New Area" onclick="Proyectos_Area_Nuevo(<?php echo  $Pro_ID?>);" /></FORM>

						<div id="Div_Proyectos_Area_Lista"></div>

					</div>	

					<div id="dropInfo4" class="dropcontent" style="display:none">

						<div style="display:none">		

						<FORM><input type="button" value="New Machines-Tools" onclick="Proyectos_Maquinaria_Nuevo(<?php echo  $Pro_ID?>);" /></FORM>

						<div id="Div_Proyectos_Maquinaria_Lista"></div>

						</div>

					</div>	

					<div id="dropInfo5" class="dropcontent" style="display:none">		

						<FORM><input type="button" value="New Activity" onclick="Proyectos_Actividades_Nuevo(<?php echo  $Pro_ID?>);" /></FORM>

						<div id="Div_Proyectos_Actividades_Lista"></div>

					</div>	

					<div id="dropInfo6" class="dropcontent" style="display:none">		
<FORM><input type="button" value="Create basic project levels" onclick="Project_Levels(<?php echo  $Pro_ID?>);" /></FORM>  

						<FORM><input type="button" value="New on Level 0" onclick="Proyectos_Edificio_Nuevo(<?php echo  $Pro_ID?>);" /></FORM>                     	
						<div id="Div_Proyectos_Edificio_Lista"></div>

					</div>
					<div id="dropInfo7" class="dropcontent" style="display:none">	
						<form enctype="multipart/form-data" action="Proyectos_Piso_Importar_Upload.php" method="POST" target="Iframe_import">			
							<input type="hidden" name="MAX_FILE_SIZE" value="512000" />
							<input type="hidden" name="Pro_ID" id="Pro_ID" value="<?php echo $Pro_ID;?>" />
							<table width="267" class="moduletable" >
								<tr>
		
									<th colspan="3">Import P.Structure and Estimate</th>
								</tr>		  		 					
								<tr>
									<td ><b>File:</b></td>					
									<td colspan="2" valign="middle">
										<input type="file" name="UserFile" id="UserFile" />
									</td>
								</tr>
								<tr>
									<td colspan="2" align="center">
										<a href="#"><input name="button" type="submit" value="Import txt file" /></a>&nbsp;&nbsp;&nbsp;
										<a href="#"><input type="reset" value=" Clear "  /></a>		
									</td>													
								</tr>					  					  
							</table>
						</form>		
						<iframe id="Iframe_import" name="Iframe_import" width="900" height="300" scrolling="yes"></iframe>
					</div>						

				</td>

			</tr>

		</table>

	</fieldset>

</div>