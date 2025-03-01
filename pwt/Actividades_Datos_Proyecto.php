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
$contador=0;

		$Pro_ID=$_GET['Pro_ID'];
		$Actividad_ID=$_GET['Actividad_ID'];
		//$Task_ID=522;
		//$Nro_act=88;
		$consulta = "SELECT p.*, e.Nombre as Company FROM proyectos p INNER JOIN empresas e ON p.Emp_ID=e.Emp_ID WHERE p.Pro_ID=".$Pro_ID;		

		//echo $consulta."<br>";
		$result2=$bd->ejecutar($consulta);
		if (($row2 = mysqli_fetch_array($result2) ))
		{	
			$Codigo = $row2["Codigo"];
			$Emp_ID = $row2["Emp_ID"];
			$Company = $row2["Company"];
			$Nombre = $row2["Nombre"];
			$Fecha_Inicio=$row2["Fecha_Inicio"];
			$Fecha_Fin=$row2["Fecha_Fin"];	
			$Horas=$row2["Horas"];	
			$Estado = $row2["Estado"];
			$Ciudad = $row2["Ciudad"];
			$Zip_Code = $row2["Zip_Code"];
			$Calle = $row2["Calle"];
			$Numero=$row2["Numero"];

			$Contratista_General=$row2["Contratista_General"];
			$Co1=$row2["Adi1"];
			$Co2=$row2["Adi2"];
			$Co3=$row2["Adi3"];
			$Co4=$row2["Adi4"];
			$Co5=$row2["Adi5"];
			$Notes=$row2["Notes"];

			$consulta = "SELECT p.*, ";
			$consulta = $consulta . " CONCAT(em1.Nombre, ' ', em1.Apellido_Paterno, ' ',  em1.Apellido_Materno) as Foreman, em1.Telefono as TelefonoF,  em1.Celular as  CelularF, ";

		$consulta = $consulta . " CONCAT(em5.Nombre, ' ',  em5.Apellido_Paterno, ' ',  em5.Apellido_Materno) as Coordinador_Obra, em5.Telefono as TelefonoC,  em5.Celular as  CelularC  FROM proyectos p ";

			$consulta = $consulta . " LEFT JOIN personal em1 ON em1.Empleado_ID=p.Foreman_ID ";		
			$consulta = $consulta . " LEFT JOIN personal em5 ON em5.Empleado_ID=p.Coordinador_Obra_ID ";
			$consulta = $consulta . " WHERE p.Pro_ID=".$Pro_ID;	
			//echo $consulta."<br>";	
			$result33=$bd->ejecutar($consulta); 
			while (($row33 = mysqli_fetch_array($result33) ))
			{
				$Codigo = $row33["Codigo"];
				$Foreman=$row33["Foreman"];
				$TelefonoF=$row33["TelefonoF"];
				$CelularF = $row33["CelularF"];	
				$Coordinador_Obra = $row33["Coordinador_Obra"];	
				$TelefonoC = $row33["TelefonoC"];
				$CelularC = $row33["CelularC"];
				$Numero = $row33["Numero"];
				$Calle = $row33["Calle"];
				$Ciudad = $row33["Ciudad"];
				$Estado = $row33["Estado"];
				$Zip_Code = $row33["Zip_Code"];	
				$Estatus_ID=$row33["Estatus_ID"];
				$Address= $Numero." ".$Calle.", ".$Ciudad.", ".$Estado." ".$Zip_Code;
				$Pro_ID=$row33["Pro_ID"];
			}
			mysqli_free_result($result33);
			$consulta = "select SUM(HContract) AS HContract, SUM(HTM) AS HTM FROM actividad_personal ap INNER JOIN actividades a ON ap.Actividad_ID=a.Actividad_ID ";
			$consulta = $consulta . " WHERE a.Pro_ID=".$Pro_ID;	
			$result33=$bd->ejecutar($consulta); 
			while (($row33 = mysqli_fetch_array($result33) ))	
			{	
				$HContract = $row33["HContract"];
				$HTM = $row33["HTM"];
			}
			mysqli_free_result($result33);

			if ($Horas!=0)
			{
				$Horas=$Horas+$Co1+$Co2+$Co3+$Co4+$Co5;
				$Promedio = $HContract/$Horas;
			}
			else
				$Promedio = 0;
		?> 
<fieldset id="Fs_Lista_Cliente" class="" >
	<legend><strong>Project Information:</strong></legend>
	<table width="933" >
      <tr>
        <td width="203"><strong># Project:</strong> <?php echo $Codigo;?></td>
        <td width="335"><strong>Name:</strong> <?php echo $Nombre;?></td>
        <td width="373"><strong>GC Company:</strong><?php echo $Company;?></td>
      </tr>
    </table>
    <table width="933" >
      <tr>
        <td width="920"><strong><em>Notes: <?php echo $Notes;?></em></strong></td>
      </tr>
    </table>
	<div>
	  <table width="942">
  <tr>	
				<td width="242" height="23"><strong>Super GC:</strong> <?php echo $Coordinador_Obra;?></td>
		<td width="240"><strong>Foreman:</strong> <?php echo $Foreman;?></td>



	    </tr>



			<tr>



				<td><strong>Hrs.to Work+Cos:</strong> <?php echo round($Horas,2);?></td>



				<td>Hrs.Worked: <?php echo round($HContract,2);?> <strong>Hrs.Left</strong>:<?php echo round(($Horas-$HContract),2);?></td>



			  <td width="127"><strong>%Worked:</strong> <?php echo round(($Promedio)*100,2);?>%</td>



				<td width="135"><strong>Hrs T&M:</strong> <?php echo round($HTM,2);?></td>



			  <td width="174"><strong>Total Hrs:</strong> <?php echo round(($HContract+$HTM),2);?></td>				



	    </tr>



        



		<?php    		



		}



		mysqli_free_result($result2);		



		?>



		</table>   



	    <?php		



		if ($contador == 1 )



		{



			echo "<br><br>No hay Registros<br>";



		}				



		?>



        <form  id="form1" name="form1" />



          <p></p>



          <p><strong>Status:</strong> 



							      <?php



									$sql = "select Estatus_ID, Nombre_Estatus FROM estatus order by Nombre_Estatus";														



									$result=$bd->ejecutar($sql); 		 



								?>



									<select name="EstatusID" size="1"  class="cuadro" id="EstatusID" onchange="Proyecto_Registrar_Estatus(<?php echo $Pro_ID;?>, this.value);">      



									  <option  value="-1">- Status -</option>



							          <?php		



										while (($row = mysqli_fetch_array($result) ))							



										{								



								?>



									  <option value="<?php echo $row["Estatus_ID"];?>"><?php echo $row["Nombre_Estatus"];?></option>  







						              <?php



										}



										



										mysqli_free_result($result);		



								?>

                              

								  </select>

      </form>

      <form id="form2" name="form2">

            Activity # or Cost Code::

              <input type="text" name="NumAct" id="NumAct" />

        	<input type="button" value="Enter Report" onclick=" Dayli_Report_Piso_Area_Tareas_Task_Nuevo_Search(<?php echo $Pro_ID;?>, <?php echo $Actividad_ID;?>) " />        

      </form>  

     

      

            

      

          <p>
      <Div id="Res_Status" name="Res_Status"></Div>
    </div>
</fieldset>	
<img src="images/spacer.gif" onload="Actividad_Material_Information(<?php echo $Actividad_ID;?>,<?php echo $Pro_ID;?>);" />  	
<?php
	require('Library/Close_Conexion.php');	
?>