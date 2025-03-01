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

?> 
			<table>

				<tr>

					<td>Project Manager:</td>

					<td> 								  

						<?php

							$sql = "select Empleado_ID, Nombre, Apellido_Paterno, Apellido_Materno FROM personal WHERE Emp_ID=".$Emp_ID." ORDER BY Nombre";														

							$result=$bd->ejecutar($sql); 		 

						?>

							<select size="1" name="Project_Manager_ID" id="Project_Manager_ID"  class="cuadro">      

								<option  value="">--Select Project Manager--</option>

						<?php		

								while (($row = mysqli_fetch_array($result) ))							

								{								

						?>

									<option value="<?php echo  $row["Empleado_ID"];?>"><?php echo $row["Nombre"]." ".$row["Apellido_Paterno"]." ".$row["Apellido_Materno"];?></option>

						<?php

								}

								mysqli_free_result($result);	

						?>

							</select>

					</td>

				</tr>

				<tr>

					<td>Superintendent:</td>

					<td> 							  

						<?php

							$sql = "select Empleado_ID, Nombre, Apellido_Paterno, Apellido_Materno FROM personal WHERE Emp_ID=".$Emp_ID." ORDER BY Nombre";															

							$result=$bd->ejecutar($sql); 		 

						?>

							<select size="1" name="Coordinador_Obra_ID" id="Coordinador_Obra_ID"  class="cuadro">      

								<option  value="">--Select Superintendent--</option>

						<?php		

								while (($row = mysqli_fetch_array($result) ))							

								{								

						?>

									<option value="<?php echo  $row["Empleado_ID"];?>"><?php echo $row["Nombre"]." ".$row["Apellido_Paterno"]." ".$row["Apellido_Materno"];?></option>

						<?php

								}

								mysqli_free_result($result);	

						?>

							</select>

					</td>

				</tr>

			</table>	

<?php

	require('Library/Close_Conexion.php');	

?>