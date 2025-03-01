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

	$Emp_ID=$_GET['Emp_ID'];

	$Empleado_ID=$_GET['Empleado_ID'];	

	

	$consulta = "SELECT * FROM personal WHERE Empleado_ID=".$Empleado_ID;		

	//echo $consulta."<br>";

	$result2=$bd->ejecutar($consulta); 	

	while (($row2 = mysqli_fetch_array($result2) ))							

	{		

		$Empleado_ID = $row2["Empleado_ID"];

		$Nombre = $row2["Nombre"];

		$Apellido_Paterno  = $row2["Apellido_Paterno"];	

		$Apellido_Materno = $row2["Apellido_Materno"];

		$Nick_Name = $row2["Nick_Name"];		

		$Estado = $row2["Estado"];	

		$Ciudad = $row2["Ciudad"];	

		$Zip_Code = $row2["Zip_Code"];			

		$Calle = $row2["Calle"];

		$Numero=$row2["Numero"];

		$Cargo=$row2["Cargo"];

		$Numero_Seguro_Social=$row2["Numero_Seguro_Social"];

		$Fecha_Nacimiento=$row2["Fecha_Nacimiento"];

		$Fecha_Nacimiento=FormatDateTime($Fecha_Nacimiento,6);

		

		$Numero_Licencia_Conducir=$row2["Numero_Licencia_Conducir"];

		$Numero_Permiso_Trabajo=$row2["Numero_Permiso_Trabajo"];

		

		$Fecha_Expiracion_Trabajo=$row2["Fecha_Expiracion_Trabajo"];
		$Fecha_Contratacion =$row2["Fecha_Contratacion"];

		$Fecha_Expiracion_Trabajo=FormatDateTime($Fecha_Expiracion_Trabajo,6);
		$Fecha_Contratacion=FormatDateTime($Fecha_Contratacion,6);

		

		$Numero_Residente=$row2["Numero_Residente"];

		$email=$row2["email"];

		$Telefono=$row2["Telefono"];	

		$Celular=$row2["Celular"];	

		$Aux1=$row2["Aux1"];	

		$Aux2=$row2["Aux2"];	

		$Aux3=$row2["Aux3"];	

		$Aux4=$row2["Aux4"];	

		$Aux5=$row2["Aux5"];
		
		$User=$row2["Usuario"];
		
		$Password=$row2["Password"];
		$P1=$row2["P1"];
		$P2=$row2["P2"];
		$P3=$row2["P3"];
		$R1=$row2["R1"];
		$R2=$row2["R2"];
		$R3=$row2["R3"];
		
		$Indice_produccion=$row2["Indice_produccion"];
		$codbon=$row2["Nro_Bono"];
		$spebon=$row2["Spec_Bon1"];
		$notbon=$row2["Not_Bon"];
		$extra_mon=$row2["Extra_Mon1"];
		$extra_mon2=$row2["Extra_Mon2"];
		$benefitA=$row2["Benefit1"];
		$benefitB=$row2["Benefit2"];

	}

	mysqli_free_result($result2);				

?> 

    <form action="#" id="Form_Empresas_Empleado_Editar" name="Form_Empresas_Empleado_Editar">

    <table width="100%">

    	<tr>

        	<td width="100%">             

				<fieldset>

				  <legend><strong>Employee: Info</strong></legend>
					<table  cellpadding="2" cellspacing="2" width="100%">

						<tr>

							<td width="100"><strong>Name:</strong></td>

						    <td  ><input name="Nombre" type="text" id="Nombre" size="20" value="<?php echo $Nombre;?>"/> 
						    Last Name: <input name="Apellido_Paterno" type="text" id="Apellido_Paterno" size="25" value="<?php echo $Apellido_Paterno;?>"/>
						    Midle:
						    <input name="Apellido_Materno" type="text" id="Apellido_Materno" size="25" value="<?php echo $Apellido_Materno;?>"/></td>

						</tr>

						

						<tr>

							<td width="82"><p>Nick Name(No Edit/If change status create new employee):</p></td>

						    <td  ><input name="Nick_Name" type="text" id="Nick_Name" value="<?php echo $Nick_Name;?>" size="20" readonly="readonly"/>
Employee	#:				          <input name="Numero" type="text" id="Numero" size="8" value="<?php echo $Numero;?>"/> 
Phone #:
<input name="Telefono" type="text" id="Telefono" size="12" value="<?php echo $Telefono;?>"/></td>

						</tr>
<tr>

			  <td colspan="2" >

								<strong>SS/Status/Type Employee: </strong>

								<input name="Numero_Seguro_Social" type="text" id="Numero_Seguro_Social" size="14" value="<?php echo $Numero_Seguro_Social;?>"/> 

								<strong>Driver's License #: </strong>

								<input name="Numero_Licencia_Conducir" type="text" id="Numero_Licencia_Conducir" size="14" value="<?php echo $Numero_Licencia_Conducir;?>"/>
								DOB:
								<input name="Fecha_Nacimiento" type="text" id="Fecha_Nacimiento" size="20"  datepicker="true" datepicker_format="MM-DD-YYYY" value="<?php echo $Fecha_Nacimiento;?>"/>
                                <img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Nacimiento"));' />&nbsp;</td>

						</tr>	


						<tr>							

							<td><strong>Address:</strong></td>

						  <td><input name="Calle" type="text" id="Calle" size="30" value="<?php echo $Calle;?>"/>
City
  <input name="Ciudad" type="text" id="Ciudad" size="15" value="<?php echo $Ciudad;?>"/>
  <strong>State</strong>:
  <input type="text" id="Estado" name="Estado" size="8" value="<?php echo $Estado;?>"/>
  <strong>Zip Code:</strong>
  <input name="Zip_Code" type="text" id="Zip_Code" size="10" value="<?php echo $Zip_Code;?>"/></td>

					  	</tr>

						<tr>

							<td >Number Job:</td>

							<td><input name="Numero_Permiso_Trabajo" type="text" id="Numero_Permiso_Trabajo" size="10" value="<?php echo $Numero_Permiso_Trabajo;?>"/>
                              <strong>Number Resident:</strong>
                              <input name="Numero_Residente" type="text" id="Numero_Residente" size="8" value="<?php echo $Numero_Residente;?>"/>
                              <strong>Hire Date:</strong>
                              <input name="Fecha_Contratacion" type="text" id="Fecha_Contratacion" size="15"  datepicker="true" datepicker_format="MM-DD-YYYY" value="<?php echo $Fecha_Contratacion;?>" />
                            <img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Contratacion"));' /></td>

						</tr>	

						<tr>

							<td ><strong>Position:</strong></td>

							<td><input name="Cargo" type="text" id="Cargo" size="30" value="<?php echo $Cargo;?>"/>
Email:
  <input name="email" type="text" id="email" size="25" value="<?php echo $email;?>"/>
  <strong>Movil:</strong>
  <input name="Celular" type="text" id="Celular" size="12" value="<?php echo $Celular;?>"/></td>

						</tr>	
                        									

						
						<tr>

							<td colspan="2" ><strong>Produccion Index:
                                <input name="Indice_produccion" type="text" id="Indice_produccion" size="20" value="<?php echo $Indice_produccion;?>"/>
                            </strong></td>

						</tr>	

											

						<tr>

							<td colspan="2" >

								<p><em>Notes (Request off, Vacation etc.)Aux1<strong>:</strong></em>
								  
								  <input name="Aux1" type="text" id="Aux1" size="60" value="<?php echo $Aux1;?>"/> 
							  </p>
								<p>Aux2:
                                  <input name="Aux2" type="text" id="Aux2" value="<?php echo $Aux2;?>" size="40" /> 							
								  
								  Aux3:
								  
								  <input name="Aux3" type="text" id="Aux3" value="<?php echo $Aux3;?>" size="30" />
		                      </p></td>

					  </tr>	

												<tr>

							<td colspan="2" >

								<p>Aux4:
                                  <input name="Aux4" type="text" id="Aux4" value="<?php echo $Aux4;?>" size="80" /> 
					          </p>
								<p><em>FY=Office.FX=Field Related F=Field worker FS=Field Sub z.Adm=no longer -&gt;:</em>
								  
								  <input name="Aux5" type="text" id="Aux5" size="15" value="<?php echo $Aux5;?>"/> 
								  
								  <input name="Emp_ID" type="hidden" id="Emp_ID" size="30" value="<?php echo $Emp_ID;?>"/> 
								  
								  <input name="Empleado_ID" type="hidden" id="Empleado_ID" size="30" value="<?php echo $Empleado_ID;?>"/>
							  </p></td>

					  </tr>	
					   <tr>
							<td colspan="2" >
								<strong>User:</strong>
								<input name="User" type="text" id="User" size="20" value="<?php echo $User;?>"/>								
								<strong>Password:</strong>
								<input name="Password" type="text" id="Password" size="20" value="<?php echo $Password;?>"/>
							</td>
						</tr>
					 	 <tr>
							<td colspan="2" >
								<strong>Question 1:</strong>
								<input name="q1" type="text" id="q1" size="25" value="<?php echo $P1;?>"/>								
								<strong>Answer 1:</strong>
								<input name="a1" type="text" id="a1" size="20" value="<?php echo $R1;?>"/>
							</td>
						</tr>
						<tr>
							<td colspan="2" >
								<strong>Question 2:</strong>
								<input name="q2" type="text" id="q2" size="25" value="<?php echo $P2;?>"/>								
								<strong>Answer 2:</strong>
								<input name="a2" type="text" id="a2" size="20" value="<?php echo $R2;?>"/>
							</td>
						</tr>
						<tr>
							<td colspan="2" >
								<p><strong>Question 3:</strong>
								  <input name="q3" type="text" id="q3" size="25" value="<?php echo $P3;?>"/>								
								  <strong>Answer 3:</strong>
								  <input name="a3" type="text" id="a3" size="20" value="<?php echo $R3;?>"/>
							  </p>
							</td>
						</tr>
						<tr>
							<td colspan="2" >
							  <p><strong># or Code of Bonus:</strong>
								  <input name="codbon" type="text" id="codbon" size="18" value="<?php echo $codbon;?>"/>								
								  <strong>$Special Bonus:</strong>
							  <input name="spebon" type="text" id="spebon" size="15" value="<?php echo $spebon;?>"/></p>
								<p>Note for Bonus:
								  <input name="notbon" type="text" id="notbon" size="95" value="<?php echo $notbon;?>"/>						  
							</p>
								<p>$extra per week-&gt;Gas:
                                  <input name="extra_mon" type="text" id="extra_mon" size="6" value="<?php echo $extra_mon;?>"/>
								  Benefit A:
  <input name="benefitA" type="text" id="benefitA" size="15" value="<?php echo $benefitA;?>"/>
  $extra Productive:
  <input name="extra_mon2" type="text" id="extra_mon2" size="6" value="<?php echo $extra_mon2;?>"/>
							  
								  Benefits B:
                                    <textarea name="benefitB" cols="95" id="benefitB"><?php echo $benefitB;?></textarea>
			                  </p></td>
						</tr>


					</table>

				</fieldset>

				

        	</td>                             

        </tr>

		<tr>

			<td valign="top">                                            

				<div style="display:block" id="div_res_new_empresa">

					

                </div>                                  					

				<INPUT id="button" type="button" value="Save" name="button" onClick="Empresas_Empleados_Editar_Registrar();">

           	</td>       

		</tr>

	</table>

</form>

<?php

	require('Library/Close_Conexion.php');

?>

        

   