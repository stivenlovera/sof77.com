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



	



	$Proyecto=ConvertDateToMysqlFormat($_GET['Proyecto']);



	$Pro_ID=ConvertDateToMysqlFormat($_GET['Pro_ID']);



	$From_Date=ConvertDateToMysqlFormat($_GET['From_Date']);



	$To_Date=ConvertDateToMysqlFormat($_GET['To_Date']);	



?> 



<table class="Tabla_Lista_Actividades"  >



	<thead>	



	  <tr>



			<th width="110">&nbsp;</th>				 



		<th width="410">Project</th>			



		<th width="80">Date</th>		



		<th width="50">Hour</th>		



		<th width="80">Type</th>					



		<th width="150">Employees</th>



        <th width="162">Description</th>				



		<th width="100">Aux1</th>								   								   			



		<th width="100">Aux2</th>



		<th width="100">Aux3</th>



	  </tr>	



	 </thead>	



	 <tbody>



<?php   				       	



	$consulta = "SELECT p.Pro_ID, p.Nombre, p.Fecha_Inicio, p.Fecha_Fin, p.Horas, a.*, ta.Actividad_Nombre FROM actividades a 



		INNER JOIN tipo_actividad ta ON a.Tipo_Actividad_ID=ta.Tipo_Actividad_ID 



		INNER JOIN proyectos p ON p.Pro_ID=a.Pro_ID



		WHERE ((a.Fecha>='".$From_Date."' AND a.Fecha<='".$To_Date."') OR a.Fecha='2013-01-01') ";	



		



		if ($_GET['Proyecto'] != ""  )



			$consulta = $consulta." AND p.Nombre like '%".$_GET['Proyecto']."%'  ";	



		



		if ($_GET['Pro_ID'] != ""  )



			$consulta = $consulta." AND p.Pro_ID=".$_GET['Pro_ID'];			







		//$consulta = $consulta." ORDER BY a.Fecha, p.Pro_ID, Hora";



		//$consulta = $consulta." ORDER BY  p.Pro_ID,a.Fecha, Hora";



		$consulta = $consulta." ORDER BY p.Nombre,p.Pro_ID,a.Tipo_Actividad_ID,a.Fecha, Hora";



	



	//echo $consulta."<br>";



	$contador=0;



	$Pro_ID_Ant=-33;	 	  	 	  	  







	$result2=$bd->ejecutar($consulta); 	



	while (($row2 = mysqli_fetch_array($result2) ))							

	{	

		$contador++;



		$Pro_ID = $row2["Pro_ID"];



		$Nombre = $row2["Nombre"];



		$Fecha_Inicio = $row2["Fecha_Inicio"];



		$Fecha_Fin = $row2["Fecha_Fin"];



		$Fecha = $row2["Fecha"];



		$Horas = $row2["Horas"];



		$Actividad_ID = $row2["Actividad_ID"];



		$Tipo_Actividad_ID = $row2["Tipo_Actividad_ID"];



		$Actividad_Nombre = $row2["Actividad_Nombre"];



		$Descripcion  = $row2["Descripcion"];	
		$Hora = $row2["Hora"];
		$Aux1 = $row2["Aux1"];	
		$Aux2 = $row2["Aux2"];
		$Aux3 = $row2["Aux3"];
		$Fecha = $row2["Fecha"];
		$Color = $row2["Color"];
		$consulta = "SELECT p.* FROM personal p
		INNER JOIN actividad_personal ap ON ap.Empleado_ID=p.Empleado_ID 
		WHERE ap.Actividad_ID=".$Actividad_ID;
				
		//echo $consulta."<br>";		
		$result33=$bd->ejecutar($consulta); 
		$empleados="";

		while (($row33 = mysqli_fetch_array($result33) ))	
		{		
			if ($empleados=="")		
				$empleados=$row33["Nick_Name"];
				//$empleados=$row33["Nombre"]." ".$row33["Apellido_Paterno"];
			else
				$empleados=$empleados.", ".$row33["Nick_Name"];
				//$empleados=$empleados.", ".$row33["Nombre"]." ".$row33["Apellido_Paterno"];
		}
		mysqli_free_result($result33);

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

			$Address= $Numero." ".$Calle.", ".$Ciudad.", ".$Estado." ".$Zip_Code;
		}
		mysqli_free_result($result33);		

		if (is_null($Color) ) 
			$Estilo="background-color:#FFFFFF"; 
		else
			$Estilo="background-color:".$Color; 

		$File0="";
		if (  (is_null($Color) )  ||  ($Color=="FFFFFF") )
			$File0="_s"; 		

		$File1="";
		if (  $Color=="FF0000" )
			$File1="_s"; 		

		$File2="";
		if (  $Color=="00FF00" )
			$File2="_s"; 			

		$File3="";
		if (  $Color=="0000FF" )
			$File3="_s"; 			

		$File4="";
		if (  $Color=="00FFFF" )
			$File4="_s"; 		

		$File5="";
		if (  $Color=="FF00FF" )
			$File5="_s"; 
	?>		
		<tr>
			<?php
				if ($Pro_ID_Ant!=$Pro_ID)
				{
					$contador++;
				}
				else
				{
					//echo "<td></td><td></td><td></td><td></td><td></td>";
				}
			?>

			<td >
				<a href="#" onclick="Actividades_Asignar_Personal(<?php echo $Actividad_ID; ?>, '<?php echo $Fecha; ?>');">
					<img src="images/icon_asignar_0_gif.gif"/>
				</a>
				<a href="#" onclick="Actividades_Editar_Reporte(<?php echo $Actividad_ID; ?>, <?php echo $Pro_ID; ?>);">
					<img src="images/icon_editar_0_gif.gif"/>
				</a>
				<a href="#" onclick="Actividades_Eliminar_Reporte(<?php echo $Actividad_ID; ?>);">
					<img src="images/icon_eliminar_0_gif.gif" />
				</a>

				<img src="images/color_0<?php echo $File0; ?>.jpg" value="FFFFFF" name="Color_0" id="Color_0" onclick="reporte_cronograma_actividades_color('FFFFFF', <?php echo $Actividad_ID; ?>);" />

				<img src="images/color_1<?php echo $File1; ?>.jpg" value="FF0000" name="Color_1" id="Color_1" onclick="reporte_cronograma_actividades_color('FF0000', <?php echo $Actividad_ID; ?>);"/>

				<img src="images/color_2<?php echo $File2; ?>.jpg" value="90EE90" name="Color_2" id="Color_2" onclick="reporte_cronograma_actividades_color('90EE90', <?php echo $Actividad_ID; ?>);"/>

				<img src="images/color_3<?php echo $File3; ?>.jpg" value="4682B4" name="Color_3" id="Color_3" onclick="reporte_cronograma_actividades_color('4682B4', <?php echo $Actividad_ID; ?>);"/>

				<img src="images/color_4<?php echo $File4; ?>.jpg" value="ADD8E6" name="Color_4" id="Color_4" onclick="reporte_cronograma_actividades_color('ADD8E6', <?php echo $Actividad_ID; ?>);"/>

				<img src="images/color_5<?php echo $File5; ?>.jpg" value="FFFF00" name="Color_5" id="Color_5" onclick="reporte_cronograma_actividades_color('FFFF00', <?php echo $Actividad_ID; ?>);"/>
			</td>
			<td align="right"  style="font-size:x-small; <?php echo $Estilo; ?>">
				<a href="#" onclick="Atividades_Reporte_Diario(<?php echo $Actividad_ID; ?>, <?php echo $Pro_ID; ?>);">
					<?php echo "$Codigo/$Nombre/$Address<br><b>Contac:</b>$Coordinador_Obra <b>Movil:</b>$CelularC<br><b>Foreman:</b>$Foreman <b>Movil:</b>$CelularF<br>"; ?>
				</a>
			</td>


			<td align="right"  style="font-size:x-small; <?php echo $Estilo; ?>"><?php echo FormatDateTime($Fecha,8); ?></td>	
			<td align="right"  style="font-size:x-small; <?php echo $Estilo; ?>"><?php echo $Hora; ?></td>			
			<td align="center" style="font-size:x-small; <?php echo $Estilo; ?>"><?php echo $Actividad_Nombre; ?></td>
            <td align="Center" style="font-size:x-small; <?php echo $Estilo; ?>"><?php echo $empleados; ?></td>		
			<td align="right"  style="font-size:x-small; <?php echo $Estilo; ?>"><?php echo $Descripcion; ?></td>	
			<td align="right"  style="font-size:x-small; <?php echo $Estilo; ?>"><?php echo $Aux1; ?></td>		
			<td align="center" style="font-size:x-small; <?php echo $Estilo; ?>"><?php echo $Aux2; ?></td>		
			<td align="Center" style="font-size:x-small; <?php echo $Estilo; ?>"><?php echo $Aux3; ?></td>		
	  </tr>
		<?php    		
			$Pro_ID_Ant=$Pro_ID;											 								
	}
	mysqli_free_result($result2);		
			?>
		</tbody>
	</table>
<?php
	if ( ($From_Date==$To_Date ) && ($Proyecto=="") && ($contador>0) )
	{
		$Fecha_Sugerida=date('Y-m-d');
		$es_dia_habil=false;	
		while (	!($es_dia_habil) )
		{
			$consulta = "select DATE_ADD('".$Fecha_Sugerida."', INTERVAL 1 DAY) as Fecha_Sugerida ";
			$result2=$bd->ejecutar($consulta); 	
			if (($row2 = mysqli_fetch_array($result2) ))						
			{		
				$Fecha_Sugerida = $row2["Fecha_Sugerida"];
				$es_dia_habil=Es_Dia_Habil($Fecha_Sugerida, $bd);
			}
			mysqli_free_result($result2);	
		}
?>	
		<fieldset>
			<legend>Global Re Scheduling</legend> 	
			<form id="Form_Global_Re_Scheduling" name="Form_Global_Re_Scheduling">
				<input name="Fecha_Global_Schedule" type="text" id="Fecha_Global_Schedule" size="20" datepicker="true" datepicker_format="MM-DD-YYYY" value="<?php echo FormatDateTime($Fecha_Sugerida,6) ;?>" />	
				<input type="hidden" name="fecha_original" id="fecha_original" value="<?php echo $From_Date; ?>" />
				<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Global_Schedule"));' />				
				<div id="Div_Res_Global_Scheduling">
					<input type="button" name="Btn_Re_Global_Scheduling" type="Btn_Re_Global_Scheduling" value="Global Re scheduling" onclick="Actividad_Global_Re_Scheduling_Registrar();" />	
				</div>
			</form>
		</fieldset>
<?php
	}
?>	
<img src="images/spacer.gif" onload="$('.Tabla_Lista_Actividades').flexigrid({nowrap: false, title : 'Activity List',showTableToggleBtn : true,width : 1100,height :350, singleSelect: true	});" />	 
<?php
	require('Library/Close_Conexion.php');	
?>