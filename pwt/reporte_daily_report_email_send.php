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

$email=$_GET["email"];

$pro_ID=$_GET["pro_ID"];

$actividad_ID=$_GET["actividad_ID"];	

	

	

//	$email='marioprueba@hot.com';

?> 

















	<input id="btn_send_email" type="button" value="Send" onclick="Proyectos_Repoprte_Actividad_email_send();" />

	<form id="Form_Proyecto_Pedidos_Email_Send">

		<table>

			<tr>

				<td><b>Subject:</b></td>

				<td><input type="text" id="Subject" name="Subject" value="Daily Report"   size="30" /></td>

			</tr>

			<tr>

				<td><b>To:</b></td>

				<td><input name="To" type="text" id="To" onfocus="<?php echo $email;?>" onclick="<?php echo $email;?>" onmouseup="<?php echo $email;?>" value="<?php echo $email;?>"  size="30"/></td>

			</tr>

			<tr>

				<td><b>Cc:</b></td>

				<td><input type="text" id="Cc" name="Cc" value="<?php echo $email_pwt;?>"   size="30" /></td>

			</tr>

		</table>		

	</form>

    <textarea name="wysiwyg" id="wysiwyg" rows="30" cols="150">					

	</textarea>  	

	<div id="Div_Reporte_Email" style="display:none">  			

<?php

$vfrom_date=$_REQUEST["vfrom_date"];

$vto_date=$_REQUEST["vto_date"];

echo $vfrom_date."<br>";





								



function encabezado($f1,$f2)



			{		  

				$f1t=FormatDateTime($f1, 8);

	  			//$f2t=FormatDateTime($f2, 8);

				$titt="Daily Report ".$f1t;

				if ($f1<>$f2)	

				{ 	

					$titt="Daily report: ".$f1t;

					//." to: ".$f2t;	

			  	}	

				//echo $titt;

			  	//echo "<p><h3>Schedule for </h3> <b>from:".$f1." to:".$f2."</b></p>";

				echo "<p><h3>  </h3> <b>".$titt."</b></p>";			  

			}



			

function encabezado2()

			{

			  echo "<b>Employees Off: </b>";

			  echo " ";

			}





function encabezado3()

			{

				echo "<b>Jobs Coming Up:</b>";

			}







			

function per_sin_act($f1,$f2,$pbd)

			//DESCRIPCION:PERSONAL SIN ACTIVIDAD

			{	

				if($f1==$f2)

				{				

					encabezado2();

					//echo "<p> $f1, $f2 ";				

			$sql = "SELECT p.* FROM personal p WHERE  p.Emp_ID=6 AND (p.Aux5 <>'Adm' OR p.Aux5 is NULL) AND (p.Empleado_ID NOT IN (SELECT p1.Empleado_ID FROM personal p1 



			INNER JOIN actividad_personal ap ON ap.Empleado_ID=p1.Empleado_ID 



			INNER JOIN actividades a ON a.Actividad_ID=ap.Actividad_ID 



			WHERE a.Fecha='".$f1."')) ORDER BY p.Nick_Name ";

				$result2=$pbd->ejecutar($sql);	

					if(mysql_num_rows($result2)>0) 		 

					{		

						$bandera=1;	

						$bandera_2=1;	

						while($row=mysqli_fetch_array($result2))

						{	

							// DETALLE



//"<p>".$row2['Codigo']." / ",$row2['Nombre']." / ".$Numero." ".$Calle.", ".$Ciudad.", ".$Estado." ".$Zip_Code." / ".$row2['Fecha_Inicio']."</p>"



							//********************************************************************



							$nickt=$row['Nick_Name'];



							//$auxt=$row['Aux1'];



							if ($auxt==NULL)



							{$nickt=$nickt." ";}



							else



							{ 



								$nickt=$nickt." ".$row['Aux1'];



							}



							 



							if ($auxt==NULL)



							{echo $nickt.", ";}



							else



							{ 



								echo "<p>".$nickt."</p>";



							}



							//echo "<p>".$nickt."</p>";



							//echo " / ".$row['nombre']." ".$row['apellido_paterno']." ".$row['apellido_materno'].", ";







						}						  







					}







				}







			}



			//************************************************************************************************





function pro_ult_sem($pbd)

			//*********************************************

			//DESCRIPCION: pro_ult_sem PRO_ YECTOS QUE SE VAN HA EJECUTAR LAS DOS ULT_ IMAS SEM_ ANA

			//********************************************

			{	

				encabezado3();					

				$fecha1= date('Y-m-d');

				$fecha2= date('Y-m-d', strtotime('+365 day'));

				$sql="select * from proyectos where fecha_inicio>='$fecha1' and fecha_inicio<='$fecha2'";

			//	echo $sql;

				//echo $sql;

				$result2=$pbd->ejecutar($sql);	

				if(mysql_num_rows($result2)>0) 		 

				{		

					while($row2=mysqli_fetch_array($result2))

					{	

						//********************************************************************

						// DETALLE	

						$Estado = $row2["Estado"];	

						$Ciudad = $row2["Ciudad"];	

						$Zip_Code = $row2["Zip_Code"];			

						$Calle = $row2["Calle"];

						$Numero=$row2["Numero"];

						$fecini=$row2["Fecha_Inicio"];

						$vdia=substr($fecini,8,2);

						$vmes=substr($fecini,5,2);

						$vano=substr($fecini,0,4);

						$fecini=$vmes."-" .$vdia."-".$vano;

						echo "<p>".$row2['Codigo']." / ",$row2['Nombre']." / ".$Numero." ".$Calle.", ".$Ciudad.", ".$Estado." ".$Zip_Code." Start Date:".$fecini."</p>";

					}

				}

			}





//// 3333 Inicio daily report





	$vdia=substr($vfrom_date,3,2);

	$vmes=substr($vfrom_date,0,2);

	$vano=substr($vfrom_date,8,2);

	$af1="20".$vano."-".$vmes."-".$vdia;

	$vdia=substr($vto_date,3,2);

	$vmes=substr($vto_date,0,2);

	$vano=substr($vto_date,8,2);

	$af2="20".$vano."-".$vmes."-" .$vdia;

	

	$sql = "select

	proyectos.Pro_ID,

	proyectos.codigo, 

	proyectos.nombre,

	proyectos.calle,

	proyectos.ciudad,

	proyectos.Estado,

	proyectos.zip_code,

	proyectos.coordinador_obra_id,

	proyectos.Estatus_ID,	

	proyectos.emails,

	actividades.Fecha,

	actividades.hora,

	actividades.descripcion,

	actividades.Actividad_ID,

	actividades.Descripcion,

	actividades.Aux2,

	actividades.Aux3,	

	actividades.Aux4,

	tipo_actividad.actividad_nombre,

	empresas.Codigo 

	FROM tipo_actividad inner join 

	(actividades inner join proyectos on actividades.pro_id=proyectos.pro_id) on tipo_actividad.tipo_actividad_id=actividades.tipo_actividad_id inner join empresas on proyectos.Emp_ID=empresas.Emp_ID

	WHERE actividades.Actividad_ID=$actividad_ID ";

	

	$result=$bd->ejecutar($sql);



//echo $sql;



	// titulo del reporte

	//encabezado($af1,$af2);

    if(mysql_num_rows($result)>0) 		 

	{		



		$bandera=1;	

		$bandera_2=1;	



		while ($row=mysqli_fetch_array($result))

		{	

				$email=$row["emails"];

				//echo $email;

				//echo $row["nombre"];

				

				//BUSQUEDA DE PERSONAL DEL PROYECTO

				$sql="select personal.nombre, personal.Nick_Name  from personal inner join 

				(actividad_personal inner join actividades on actividad_personal.actividad_id=actividades.actividad_id)

				on personal.empleado_id=actividad_personal.empleado_id where actividades.actividad_id=".$row["Actividad_ID"];

				$result2=$bd->ejecutar($sql);						

			    if(mysql_num_rows($result2)>0) 		 

				{

					$vempleados="";

					while($row2=mysqli_fetch_array($result2))

					{	

						if($vempleados=="")

							{

							$vempleados=$row2["Nick_Name"];

							}

						else

							{

							$vempleados=$vempleados.",".$row2["Nick_Name"];

							}

					}

				}

				$sql2="select * from personal where Empleado_ID=".$row['coordinador_obra_id'];

				$result3=$bd->ejecutar($sql2);						

			    if(mysql_num_rows($result3)>0) 		 

				{

					$row3=mysqli_fetch_array($result3);

					$vcontacto=$row3['Nombre']." ".$row3['Apellido_Paterno']." ".$row3['Apellido_Materno'];

				}



			  



			  // DETALLE



				$sql91="select * from estatus where estatus.Estatus_ID=".$row['Estatus_ID'];

				//echo $sql91;

				$result91=$bd->ejecutar($sql91);						

			    if ((mysql_num_rows($result91)>0) and ($row['Estatus_ID']<>3) )

				{

					$row91=mysqli_fetch_array($result91);

					$status=$row91['Nombre_Estatus'];

					}

				   else

				   $status="";

					$descripcion=$row['Descripcion'];

					$aux2=$row['Aux2'];

					$aux3=$row['Aux3'];

					$aux4=$row['Aux4'];

					$email=$row['emails'];

					$af1=FormatDateTime($row['Fecha'], 8);

					echo "Daily Report: ".$af1."<br><br>";

				echo "(".$row['Codigo'].") ".$row['codigo']." ".$row['nombre']." Add:".$row['calle'].",".$row['ciudad'].",".$row['estado'].",".$row['zip_code']." Contac:".$vcontacto." /PWT:".$pwtsuper.",".$pwtforeman." / ".$Fechat."  ".( date("g:i a", strtotime($row['hora'])) )."  /".$vempleados." / ".$row['actividad_nombre']." ".$row['descripcion']."<br>"."<br>";

					

				  // INICIO Work Done 



				  echo "Work Done:<br>";	

				  $consulta = "SELECT ac.*, d.Task_ID, d.Descp1, d.Descp2, d.Descp3, d.Descp4, d.Fecha FROM dayli_task d INNER JOIN area_control ac ON ac.Area_ID=d.Area_ID WHERE d.Pro_ID=".$row['Pro_ID']." AND d.Fecha='".$row['Fecha']."' ORDER BY  Fecha DESC, Nombre ASC";			



					//echo $consulta;

					$result2=$bd->ejecutar($consulta); 	

					$Work_Done="";

					while (($row2 = mysqli_fetch_array($result2) ))							



					{		

						$Nombre = $row2["Nombre"];

						$Descp1 = $row2["Descp1"];					

						//$Work_Done=$Work_Done.$Nombre ." ".$Descp1.", ";

						$Work_Done=$Work_Done.$Descp1.", ";

					}

					mysqli_free_result($result2);

					$Work_Done=$Work_Done;

					//.", ".$descripcion.", News:".$aux4;				  

					echo "<pre>".$Work_Done."<pre>";	

					

				/// inicio imprimir units done

					

			$sql4 = "SELECT dr.Nota_Horas AS NHoras, dr.Actividad_ID AS Actividad_ID,dr.Task_ID AS Task_ID, dr.Horas AS Horas, dr.Numero AS Numero, t.Task_ID AS Task_IDT, t.Nombre AS Nombre  FROM dayli_report_task dr JOIN task t  ON t.Task_ID=dr.Task_ID WHERE dr.Actividad_ID=".$row['Actividad_ID'];

			

			//echo $sql4."<br>";

			$result_4=$bd->ejecutar($sql4);	

			while($row4=mysqli_fetch_array($result_4))

			{

				//echo $sql4."<br>";	

				$dato=date_create($row["Fecha"]);

				$fecha=date_format($dato,'y/m/d');

				$dato1=$fecha;			

				

				$vdia=substr($dato1,6,2);

				$vmes=substr($dato1,3,2);

				$vano=substr($dato1,0,2);

				

				$fecha1="20".$vano."-".$vmes."-" .$vdia;

				$texdia= substr((FormatDateTime($fecha1, 8)),0,3);						  				

				$fecha1=$texdia.".".$vmes."-".$vdia."-".$vano;

				//echo $fecha1;

				echo " On: ";

				$Nombret=(trim($row4['Nombre']))."                ";

				$Nombret=(substr($Nombret, 0, 17))."  ";

				echo $Nombret;

				echo "    Units Done:".$row4['Numero']."     Hrs.Used:".$row4['Horas']."h <br>";

			//	$sql6 = "SELECT  SUM(pm.Cantidad_Usada) AS Cantidad_Usada FROM pedidos_material pm INNER JOIN materiales m ON pm.Mat_ID=m.Mat_ID ";

				//$sql6 = $sql6 . "  WHERE m.Unidad_Medida='gl.' AND pm.Actividad_ID=".$row['Actividad_ID']." AND  pm.Task_ID=".$row4['Task_ID'];	

				

				/*echo $sql."<br>";

				$result6=$bd->ejecutar($sql6);	

				while($row6=mysqli_fetch_array($result6))

					{

						$Cantidad_Usada=$row6["Cantidad_Usada"];

					}

				mysqli_free_result($result6);		

				echo " Mat.Used:";	*/		



			}								



					

					// fin imprimir units done 

	

				  // FIN Work Done 	



				  // INICIO Horas de Trabajo  

					echo "<p>";

				    echo "Hours Worked: <br>";	

					$consulta = "SELECT p.*, ap.HContract, ap.HTM, ap.Note FROM personal p 

					INNER JOIN actividad_personal ap ON ap.Empleado_ID=p.Empleado_ID 

					WHERE ap.Actividad_ID=".$row['Actividad_ID'];	

					//echo $consulta;

					$Detalle="";

					$Total_HContract = 0;

					$Total_HTM = 0;

					$result2=$bd->ejecutar($consulta);

					while (($row2 = mysqli_fetch_array($result2) ))							

					{		

						$Empleado_ID = $row2["Empleado_ID"];

						$Nick_Name = $row2["Nick_Name"];

						$Nombre=$row2["Nombre"];

						$Apellido_Paterno = $row2["Apellido_Paterno"];		

						$Apellido_Materno = $row2["Apellido_Materno"];			

						$Celular = $row2["Celular"];

						$HContract = number_format($row2["HContract"],2);

						if (is_null($HContract))

							$HContract=0;

						$HTM = number_format($row2["HTM"],2);

						if (is_null($HTM))

							$HTM=0;

						$Note = $row2["Note"];		

						$Total_HContract = number_format(($Total_HContract + $HContract),2);

						$Total_HTM = number_format(($Total_HTM + $HTM),2);

						$TotDay=number_format(($Total_HContract+$Total_HTM),2);

						//$Detalle= $Detalle.$row2['Nick_Name']."   Contract=".$HContract."h   T&M=".$HTM."h   Total=".$Total."h, ";

						$nick=$row2['Nick_Name']."           ";

						$nick=(substr($nick, 0, 12));

						echo $nick." Contract: ".$HContract."h   T&M: ".$HTM."h <br>";

						



						

						

						//$Detalle= $Detalle.$row2['Nick_Name']." Contract: ".$HContract."h T&M: ".$HTM."h / ";

					}



					mysqli_free_result($result2);	

					

					$Detalleh = "          T.Contract=".$Total_HContract."h  T.T&M=".$Total_HTM."h        Total Day=".$TotDay."h, ";

					echo $Detalleh."<br>";

					echo $Detalle;



				  //FIN Horas de Trabajo 	



				  //INICIO Submitals  

					echo "<p>";

					echo "Material Used:<br>";	

				    $consulta = "SELECT m.Denominacion, m.Unidad_Medida, pm.Cantidad_Usada FROM pedidos p ";

					$consulta = $consulta."  INNER JOIN pedidos_material pm ON pm.Ped_ID=p.Ped_ID AND p.Fecha='".$row['Fecha']."' AND (NOT (pm.Cantidad_Usada is NULL)) ";

					$consulta = $consulta."  INNER JOIN materiales m ON m.Mat_ID=pm.Mat_ID ";

					$consulta = $consulta."  WHERE p.Pro_ID=".$row['Pro_ID'];	

					$consulta = $consulta."  ORDER BY m.Denominacion";	

					//echo $consulta."<bR>";				

					$Detalle="";

					$result2=$bd->ejecutar($consulta); 	

					while (($row2 = mysqli_fetch_array($result2) ))							

					{		

						//$Denominacion = substr($row2["Denominacion"], 0, 5); 						 

						$Denominacion = $row2["Denominacion"]; 						 

						$Unidad_Medida = $row2["Unidad_Medida"];

						$Cantidad_Usada=$row2["Cantidad_Usada"];							

						echo $Cantidad_Usada.$Unidad_Medida."  ".$Denominacion." <br>";

						//$Detalle = $Detalle.$Cantidad_Usada.$Unidad_Medida." ".$Denominacion.", "; 					

					}

					mysqli_free_result($result2);					

					echo $Detalle;



				  // FIN Submitals 



				  // INICIO TOTAL HOURS 	  



				    $consulta = "SELECT p.*, e.Nombre as Company FROM proyectos p INNER JOIN empresas e ON p.Emp_ID=e.Emp_ID WHERE p.Pro_ID=".$row['Pro_ID'];				

					//echo $consulta."<br>";

					$Detalle="";

					$result2=$bd->ejecutar($consulta); 	

					if (($row2 = mysqli_fetch_array($result2) ))							

					{		

						$Codigo = $row2["Codigo"];

						$Emp_ID = $row2["Emp_ID"];

						$Company = $row2["Company"];

						$Pro_ID = $row2["Pro_ID"];

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

						$consulta = "SELECT p.*, ";

						$consulta = $consulta . " CONCAT(em1.Nombre, ' ', em1.Apellido_Paterno, ' ',  em1.Apellido_Materno) as Foreman, em1.Telefono as TelefonoF,  em1.Celular as  CelularF, ";

					$consulta = $consulta . " CONCAT(em5.Nombre, ' ',  em5.Apellido_Paterno, ' ',  em5.Apellido_Materno) as Coordinador_Obra, em5.Telefono as TelefonoC,  em5.Celular as  CelularC  FROM proyectos p ";

						$consulta = $consulta . " LEFT JOIN personal em1 ON em1.Empleado_ID=p.Foreman_ID ";		

						$consulta = $consulta . " LEFT JOIN personal em5 ON em5.Empleado_ID=p.Coordinador_Obra_ID ";				

						$consulta = $consulta . " WHERE p.Pro_ID=".$row['Pro_ID'];		

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

						$consulta = "select SUM(HContract) AS HContract, SUM(HTM) AS HTM FROM actividad_personal ap INNER JOIN actividades a ON ap.Actividad_ID=a.Actividad_ID ";

						$consulta = $consulta . " WHERE a.Pro_ID=".$row['Pro_ID']." AND a.Fecha<='".$row['Fecha']."'";		

						$result33=$bd->ejecutar($consulta); 	

						while (($row33 = mysqli_fetch_array($result33) ))							

						{				

							$HContract = $row33["HContract"];

							$HTM = $row33["HTM"];

						}



						mysqli_free_result($result33);

						if ($Horas>0)

						{

							$PorcHoras=round((($HContract/$Horas)*100),2);

						}

						  Else

						    {

								$PorcHoras="-";

							}

							$TotHoras=$HContract+$HTM;



							$Horas=number_format($Horas,2);



							$HContract=number_format($HContract,2);



							$HTM=number_format($HTM,2);



							$TotHoras=number_format(($TotHoras),2);

							$Detalle = "TOTALS-> Hours Worked in Contract:".$HContract."h";

							$Detalle = $Detalle."     T&M Hours:".$HTM."h   Total Hours:".$TotHoras;

						//$Detalle = "Hours to Work:".$Horas."h   Hours Worked:".$HContract."h  Worked:".$PorcHoras."%";

						//$Detalle = $Detalle."     T&M:".$HTM."h   Total Hours:".$TotHoras;



					



					}



					mysqli_free_result($result2);					

					echo "<p>";

					echo $Detalle;	

				  



				  // FIN TOTAL HOURS 



				  // INICIO Material Used  



				  // FIN Material Used 



				  // INICIO Material Request 

				   echo "<p>";

					echo "Material Requested:";	

				    $consulta = "SELECT m.Denominacion, m.Unidad_Medida, SUM(pm.Cantidad) AS Cantidad  FROM pedidos p ";

					$consulta = $consulta."  INNER JOIN pedidos_material pm ON pm.Ped_ID=p.Ped_ID AND p.Fecha='".$row['Fecha']."' ";

					$consulta = $consulta."  INNER JOIN materiales m ON m.Mat_ID=pm.Mat_ID ";

					$consulta = $consulta."  WHERE p.Pro_ID=".$row['Pro_ID'];	

					$consulta = $consulta."  GROUP BY m.Denominacion, m.Unidad_Medida";	

					//echo $consulta."<bR>";				

					$Detalle="";

					$result2=$bd->ejecutar($consulta); 	

					while (($row2 = mysqli_fetch_array($result2) ))							

					{		

						$Denominacion = substr($row2["Denominacion"], 0, 10);

						$Unidad_Medida = $row2["Unidad_Medida"];

						$Cantidad_Usada=$row2["Cantidad"];																	  

						if ( !(is_null($Cantidad_Usada)) )

							$Detalle = $Detalle.$Cantidad_Usada.$Unidad_Medida." ".$Denominacion.", "; 					



					}

					mysqli_free_result($result2);					

					echo $Detalle;



				  // FIN Material Request 



				  //INICIO Visitors 



				    $consulta = "SELECT * FROM dayli_task ";

					$consulta = $consulta."  WHERE Fecha='".$row['Fecha']."' AND Pro_ID=".$row['Pro_ID'];	

					$consulta = $consulta."  ORDER BY Task_ID ";	

					//echo $consulta."<bR>";

					$Descp3 = "";

					$Descp4 = "";

					$result2=$bd->ejecutar($consulta); 	

					if (($row2 = mysqli_fetch_array($result2) ))							



					{	

						$Descp3 = $row2["Descp3"];

						$Descp4 = $row2["Descp4"];

					}										



					mysqli_free_result($result2);

					echo "<p>";									

					echo "Visitor:".$Descp3."<br>";

					//$descp3=$Descp3.",".$aux2;

					echo "Painters to return:";	

					$Descp4=$Descp4.",".$aux3;

					echo $Descp4."<br><br>";

					echo "<p>";



				  // FIN Material Request 





			}

	}		



//	$pdf->Output("dato.pdf");











//333333 fin daily report 



/*

			$vdia=substr($vfrom_date,3,2);

			$vmes=substr($vfrom_date,0,2);

			$vano=substr($vfrom_date,8,2);

			$af1="20".$vano."-".$vmes."-" .$vdia;

			$vdia=substr($vto_date,3,2);

			$vmes=substr($vto_date,0,2);

			$vano=substr($vto_date,8,2);

			$af2="20".$vano."-".$vmes."-" .$vdia;

			$sql = "select

			proyectos.codigo,

			proyectos.Emp_ID, 

			proyectos.nombre,

			proyectos.calle,

			proyectos.ciudad,

			proyectos.estado,

			proyectos.zip_code,

			proyectos.coordinador_obra_id,

			proyectos.Foreman_ID,

			proyectos.Coordinador_ID,	

			actividades.Fecha,

			actividades.hora,

			actividades.descripcion,

			actividades.actividad_id,	

			tipo_actividad.actividad_nombre,

			empresas.Codigo 

			from tipo_actividad inner join 

			(actividades inner join proyectos on actividades.pro_id=proyectos.pro_id) on tipo_actividad.tipo_actividad_id=actividades.tipo_actividad_id inner join empresas on proyectos.Emp_ID=empresas.Emp_ID

			where actividades.fecha between '$af1' and '$af2' order by nombre,fecha,hora";	

//				$sql = $sql . " AND actividades.Pro_ID=$Pro_ID_Reporte ";



//echo $sql;

			$result=$bd->ejecutar($sql);

		  	// titulo del reporte

			encabezado($af1,$af2);	

			if(mysql_num_rows($result)>0) 		 

			{		

				$bandera=1;	

				$bandera_2=1;	

				while($row=mysqli_fetch_array($result))

				{	

					///*****************************************************



					//*BUSQUEDA DE PERSONAL DEL PROYECTO

					$sql="select personal.nombre,personal.Nick_Name  from personal inner join 

					(actividad_personal inner join actividades on actividad_personal.actividad_id=actividades.actividad_id)

					on personal.empleado_id=actividad_personal.empleado_id where actividades.actividad_id=".$row["actividad_id"].  " ORDER BY personal.Nick_Name";

					$result2=$bd->ejecutar($sql);

					$vempleados="";						

					if(mysql_num_rows($result2)>0)

					{

						$vempleados="";

						while($row2=mysqli_fetch_array($result2))

						{	

							if($vempleados=="")

							{

								$vempleados=$row2["Nick_Name"];

							}

							else

							{

								$vempleados=$vempleados.",".$row2["Nick_Name"];

							}

						}

					}					

					$sql2="select * from personal where Empleado_ID=".$row['coordinador_obra_id'];

					$result3=$bd->ejecutar($sql2);						

					if(mysql_num_rows($result3)>0) 		 

					{

					  $row3=mysqli_fetch_array($result3);

					  $vcontacto=$row3['Nombre']." ".$row3['Apellido_Paterno']." ".$row3['Apellido_Materno']." ".$row3['Celular'];

					}		



					$sql2="select * from personal where Empleado_ID=".$row['Foreman_ID'];

					$result3=$bd->ejecutar($sql2);						

					if(mysql_num_rows($result3)>0) 		 

					{

					  $row3=mysqli_fetch_array($result3);

					  $pwtforeman=$row3['Nick_Name'];

					}	



					$sql2="select * from personal where Empleado_ID=".$row['Coordinador_ID'];

					$result3=$bd->ejecutar($sql2);						

					$pwtsuper=" ";

					if(mysql_num_rows($result3)>0) 		 

					{

					  $row3=mysqli_fetch_array($result3);

					  $pwtsuper=$row3['Nick_Name'];

					}	



					//********************************************************************

					// DETALLE

					//********************************************************************

					$vfrom_date=$_REQUEST["vfrom_date"];

					$vto_date=$_REQUEST["vto_date"];

					$Fechat=" ";

					if ($vfrom_date<>$vto_date)

					{

						$Fechat=FormatDateTime($row['Fecha'],8);}					



						//echo( date("g:i a", strtotime($row['hora'])) );//06:23 pm



						//echo "<p>"."(".$row['Codigo'].") ".$row['codigo']." ".$row['nombre']." Add:".$row['calle'].",".$row['ciudad'].",".$row['estado'].",".$row['zip_code']." Contac:".$vcontacto." /PWT:".$pwtforeman." / ".$Fechat."  ".( date("g:i a", strtotime($row['hora'])) )."  /".$vempleados." / ".$row['actividad_nombre']." ".$row['descripcion']."</p><br>";

						

						echo "(".$row['Codigo'].") ".$row['codigo']." ".$row['nombre']." Add:".$row['calle'].",".$row['ciudad'].",".$row['estado'].",".$row['zip_code']." Contac:".$vcontacto." /PWT:".$pwtsuper.",".$pwtforeman." / ".$Fechat."  ".( date("g:i a", strtotime($row['hora'])) )."  /".$vempleados." / ".$row['actividad_nombre']." ".$row['descripcion']."<br><br><br>";

					}	

			}

			echo "<p>";				

			per_sin_act($af1,$af2,$bd);

			echo "<p>";		

			pro_ult_sem($bd); 

			

*/			

?>		

	</div>

	<img src='images/spacer.gif' onload='Proyectos_Reporte_Actividad_Copiar();' />	

<?php	

	require('Library/Close_Conexion.php');

?>