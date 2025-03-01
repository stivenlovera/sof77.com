<?php

	session_name("Administrador");

	session_start();

	//*******************************************************************

	//Datos enviados por proyecto_reporte_material_0.php

	//******************************************************************

	$vfrom_date=$_REQUEST["vfrom_date"];

	$vto_date=$_REQUEST["vto_date"];

	

		

	require('Library/Control_Cache.php');	

	require('Library/Open_Conexion.php');

	require('Library/funciones.php');	

	// INSERTADO POR FABIOLA CARRASCO

	require('pdf/fpdf.php');

	$pdf=new FPDF('L','mm','Letter');

	$pdf->AddPage();

	



	// DEFINICION DE FUNCIONES DE CABEZERA DE SUBCUEPO

	$pdf->SetMargins(15,20,15,15);

	$pdf->SetFont('Arial','',10);

	$pdf->SetLineWidth(0.5); 

	$pdf->Setfillcolor(255,255,255);

	

	function membrete(&$pdf)

	{

		//ENCABEZADO

		$pdf->SetFont('Arial','',8);

		$pdf->Image('images/logo.png',5,5,30,10,"png");

		}

	

	function encabezado(&$pdf,$f1,$f2)

	{

	   //****************************************************************

	   //DESCRIPCION:PERMITE IMPRIMIR EL ESCABEZADO DE LA PRIMERA CONSULTA

	  //*****************************************************************
	  $f1=FormatDateTime($f1, 8);
	  $f2=FormatDateTime($f2, 8);

  	  $pdf->Multicell(0,5,"",0,L,false);

	  $pdf->Multicell(0,5,"Daily Report",0,C,false);

  	  $pdf->Multicell(0,5,"from:".$f1." to:".$f2,0,C,false);

  	  $pdf->Multicell(0,5,"",0,L,false);

	  // titulo del detall	  

  	  $aux=$pdf->GetY();

	  $pdf->SetX(20);

	  $pdf->Multicell(60,5,"Code/Proyect",0,L,false);

	  $pdf->SetY($aux);

	  $pdf->SetX(80);

	  $pdf->Multicell(40,5,"Date",0,L,false);

	  $pdf->SetY($aux);

	  $pdf->SetX(120);

	  $pdf->Multicell(10,5,"Time",0,L,false);

	  $pdf->SetY($aux);

	  //$pdf->SetX(130);

	  //$pdf->Multicell(25,5,"Type Activities",0,L,false);

	  //$pdf->SetY($aux);

	  //$pdf->SetX(155);

	  //$pdf->Multicell(65,5,"Decription",0,L,false);

	  //$pdf->SetY($aux);

	  $pdf->SetX(135);

	  $pdf->Multicell(70,5,"Employees",0,L,false);	 

	  $aux7=$pdf->GetY();

   	  $pdf->line(10,$aux+5,270,$aux+5);

	  $pdf->line(10,$pdf->GetY()-5,270,$pdf->GetY()-5);

	  $pdf->SetY($aux7);	  

	}	

		

	

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

	proyectos.estado,

	proyectos.zip_code,

	proyectos.coordinador_obra_id,	

	actividades.Fecha,

	actividades.hora,

	actividades.descripcion,

	actividades.Actividad_ID,	

	tipo_actividad.actividad_nombre

	from tipo_actividad inner join 

	(actividades inner join proyectos on actividades.pro_id=proyectos.pro_id) on tipo_actividad.tipo_actividad_id=actividades.tipo_actividad_id 

	where actividades.fecha between '$af1' and '$af2' order by nombre,fecha,hora";	

	$result=$bd->ejecutar($sql);

	//echo $sql;

	  // titulo del reporte

   	membrete($pdf,$vfrom_date);

	encabezado($pdf,$af1,$af2);

	

	

    if(mysql_num_rows($result)>0) 		 

	{		

		$bandera=1;	

		$bandera_2=1;	

		$aux3=$pdf->GetY();

		$aux=$pdf->GetY()+2;

		while ($row=mysqli_fetch_array($result))

		{	

				///*****************************************************

				//*BUSQUEDA DE PERSONAL DEL PROYECTO

				$sql="select personal.nombre  from personal inner join 

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

							$vempleados=$row2["nombre"];

							}

						else

							{

							$vempleados=$vempleados.",".$row2["nombre"];

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



			  //********************************************************************

			  // DETALLE

			  //********************************************************************

				  //$tono = ($tono==240) ? 200 : 240;

				  //$pdf->SetFillColor($tono);

				  

				  $pdf->SetY($aux);

				  $pdf->SetX(10);

//				  $dato=date_create($row["fecha"]);

//				  $fecha=date_format($dato,'y/m/d');

				  $pdf->Multicell(70,5,$row['codigo'].",".$row['nombre'].", Add:".$row['calle'].",".$row['ciudad'].",".$row['estado'].",".$row['zip_code']." Contac:".$vcontacto,0,L,true);			  

				  

				  $pdf->SetY($aux);

				  $pdf->SetX(80);

				  $pdf->Multicell(40,5,FormatDateTime($row['Fecha'],8),0,L,true);

				  $pdf->SetY($aux);

				  $pdf->SetX(120);

				  $pdf->Multicell(15,5,$row['hora'],0,L,true);

				  $pdf->SetY($aux);					  

				 // $pdf->SetX(130);

				 // $pdf->Multicell(25,5,$row['actividad_nombre'],0,L,true);

				  //$pdf->SetY($aux);

				  //$pdf->SetX(155);

				  //$pdf->Multicell(35,5,$row['descripcion'],0,L,true);

				  //$pdf->SetY($aux);

				  $pdf->SetX(135);					  

				  $pdf->Multicell(70,5,$vempleados,0,L,true);			  				  

				  

				  $aux=$pdf->GetY();				

				  $pdf->SetY($aux+10);				  

				  $aux7=$pdf->GetY();				

				  if($aux7>=180)

				  {

					  $pdf->AddPage('L');

					  membrete($pdf);

					  encabezado($pdf,$af1,$af2);

					  $aux=$pdf->GetY()+2;	

				  }	

				  $pdf->SetY($aux);				  

				  

				  			  

				  //************************************* INICIO Work Done *************************************

				  $aux=$aux+10;

				  $pdf->SetY($aux);

				  $pdf->SetX(20);					  

				  $pdf->Multicell(25,5,"Work Done:",0,L,true);	

				  

				  $consulta = "SELECT ac.*, d.Task_ID, d.Descp1, d.Descp2, d.Descp3, d.Descp4, d.Fecha FROM dayli_task d INNER JOIN area_control ac ON ac.Area_ID=d.Area_ID WHERE d.Pro_ID=".$row['Pro_ID']." AND d.Fecha='".$row['Fecha']."' ORDER BY  Fecha DESC, Nombre ASC";			

					//echo $consulta;

					$result2=$bd->ejecutar($consulta); 	

					$Work_Done="";

					while (($row2 = mysqli_fetch_array($result2) ))							

					{		

						$Nombre = $row2["Nombre"];

						$Descp1 = $row2["Descp1"];					

						$Work_Done=$Work_Done.$Nombre ." ".$Descp1.", ";

					}

					mysqli_free_result($result2);

					$pdf->SetY($aux);

					$pdf->SetX(45);					  

					$pdf->Multicell(225,5,$Work_Done,0,L,true);	

					

				  $aux=$pdf->GetY();				

				  $pdf->SetY($aux+10);				  

				  $aux7=$pdf->GetY();				

				  if($aux7>=180)

				  {

					  $pdf->AddPage('L');

					  membrete($pdf);

					  encabezado($pdf,$af1,$af2);

					  $aux=$pdf->GetY()+2;	

				  }	

				  $pdf->SetY($aux);				  

				  

				  //************************************* FIN Work Done *************************************	

				  //************************************* INICIO Horas de Trabajo *************************************				  

					$pdf->SetY($aux);

				    $pdf->SetX(20);					  

				    $pdf->Multicell(25,5,"Hours:",0,L,true);	

					

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

						$Detalle= $Detalle.$row2['Nick_Name']." Contract: ".$HContract."h  T&M: ".$HTM."h / ";

					}

					mysqli_free_result($result2);					

					$pdf->SetY($aux);

					$pdf->SetX(45);						

					$pdf->Multicell(180,5,$Detalle,0,L,true);

					

					$Detalle = "  T.Contract=".$Total_HContract."h   T.T&M=".$Total_HTM."h        Total Day=".$TotDay."h, ";

					$pdf->SetY($aux);

					$pdf->SetX(225);						

					$pdf->Multicell(50,5,$Detalle,0,L,true);					

					

						

				  $aux=$pdf->GetY();				

				  $pdf->SetY($aux+10);				  

				  $aux7=$pdf->GetY();				

				  if($aux7>=180)

				  {

					  $pdf->AddPage('L');

					  membrete($pdf);

					  encabezado($pdf,$af1,$af2);

					  $aux=$pdf->GetY()+2;	

				  }	

				  $pdf->SetY($aux);				  

				  //************************************* FIN Horas de Trabajo *************************************	

				  //************************************* INICIO Submitals *************************************				  

				  

					$pdf->SetY($aux);

					$pdf->SetX(20);

					$pdf->Multicell(25,5,"Material Used:",0,L,true);	

					

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

						$Denominacion = substr($row2["Denominacion"], 0, 5); 						 

						$Unidad_Medida = $row2["Unidad_Medida"];

						$Cantidad_Usada=$row2["Cantidad_Usada"];																	  

						

						$Detalle = $Detalle.$Cantidad_Usada.$Unidad_Medida." ".$Denominacion.", "; 					

					}

					mysqli_free_result($result2);					

					

					$pdf->SetY($aux);

					$pdf->SetX(45);

					$pdf->Multicell(225,5,$Detalle,0,L,true);

					

				  $aux=$pdf->GetY();				

				  $pdf->SetY($aux+10);				  

				  $aux7=$pdf->GetY();				

				  if($aux7>=180)

				  {

					  $pdf->AddPage('L');

					  membrete($pdf);

					  encabezado($pdf,$af1,$af2);

					  $aux=$pdf->GetY()+2;	

				  }	

				  $pdf->SetY($aux);				  

				  //************************************* FIN Submitals *************************************

				  //************************************* INICIO TOTAL HOURS *************************************				  

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

						$consulta = $consulta . " WHERE a.Pro_ID=".$row['Pro_ID'];		

					

						$result33=$bd->ejecutar($consulta); 	

						while (($row33 = mysqli_fetch_array($result33) ))							

						{				

							$HContract = $row33["HContract"];

							$HTM = $row33["HTM"];

						}

						mysqli_free_result($result33);

					 		$Horas=number_format($Horas,2);

							$HContract=number_format($HContract,2);

							$HTM=number_format($HTM,2);

							$TotHoras=number_format(($HContract+$HTM),2);

	

						$Detalle = "Hours to Work:".$Horas."h   Hours Worked:".$HContract."h  Worked:".round(($HContract/$Horas)*100,2)."%";

						$Detalle = $Detalle."     T&M:".$HTM."h   Total Hours:".$TotHoras;

					

					}

					mysqli_free_result($result2);					

					

					$pdf->SetY($aux);

					$pdf->SetX(20);

					$pdf->Multicell(220,5,$Detalle,0,L,true);	

										

				  $aux=$pdf->GetY();				

				  $pdf->SetY($aux+10);				  

				  $aux7=$pdf->GetY();				

				  if($aux7>=180)

				  {

					  $pdf->AddPage('L');

					  membrete($pdf);

					  encabezado($pdf,$af1,$af2);

					  $aux=$pdf->GetY()+2;	

				  }	

				  $pdf->SetY($aux);				  

				  //************************************* FIN TOTAL HOURS *************************************

				  //************************************* INICIO Material Used *************************************				  

				    $pdf->SetY($aux);

					$pdf->SetX(20);

					$pdf->Multicell(40,5,"Total Material Used:",0,L,true);	

					

				    $consulta = "select m.* FROM materiales m INNER JOIN proyectos p ON m.Pro_ID=p.Pro_ID ";

					$consulta = $consulta."  WHERE m.Pro_ID=".$row['Pro_ID']." OR p.Nombre='General Sundries' ";														

					$consulta = $consulta."  ORDER BY Denominacion";		

					//echo $consulta;

					$contador=1;	 	  	 	  	  

					$result2=$bd->ejecutar($consulta); 	

					while (($row2 = mysqli_fetch_array($result2) ))							

					{		

						$Mat_ID = $row2["Mat_ID"];

						$Denominacion = $row2["Denominacion"];

						$Nombre_Generico=$row2["Nombre_Generico"];

						$Unidad_Medida = $row2["Unidad_Medida"];

						$Precio_Unitario = $row2["Precio_Unitario"];		

						$Cantidad = $row2["Cantidad"];			

						

						$consulta = "SELECT SUM(Cantidad) as Cantidad_Ordenada, SUM(Cantidad_Recibida) as Cantidad_Recibida, SUM(Cantidad_Usada) as Cantidad_Usada FROM pedidos_material ";

						$consulta = $consulta . " WHERE Mat_ID=".$Mat_ID ;

						

						//echo  $consulta;			 	  	 	  	  

						$result22=$bd->ejecutar($consulta); 	

						while (($row22 = mysqli_fetch_array($result22) ))							

						{		

							$Total_Cantidad_Ordenada = $row22["Cantidad_Ordenada"];

							if (is_null($Total_Cantidad_Ordenada))

								$Total_Cantidad_Ordenada=0;

								

							$Total_Cantidad_Recibida = $row22["Cantidad_Recibida"];

							if (is_null($Total_Cantidad_Recibida))

								$Total_Cantidad_Recibida=0;

								

							$Total_Cantidad_Usada=$row22["Cantidad_Usada"];		

							if (is_null($Total_Cantidad_Usada))

								$Total_Cantidad_Usada=0;

								

							$Saldo = $Total_Cantidad_Recibida - $Total_Cantidad_Usada;				

							

							if (  ( !(is_null($Cantidad) )  )  && ($Cantidad!=0)  )

							{

								$Por_Usada = ($Total_Cantidad_Usada*100)/$Cantidad;	

								$Por_Comprar = $Cantidad - $Total_Cantidad_Ordenada;	

							}

							else

							{

								$Por_Usada = "&nbsp;";

								$Por_Comprar ="&nbsp;";

							}

						}

						mysqli_free_result($result22);

						//$Por_Usada=number_format(Por_Usada,2);				



						$Detalle = $Denominacion."   Estimated=".$Cantidad.$Unidad_Medida."   Ordered=".$Total_Cantidad_Ordenada.$Unidad_Medida;

						$Detalle = $Detalle ."    Received=".$Total_Cantidad_Recibida.$Unidad_Medida."    Used=".$Total_Cantidad_Usada.$Unidad_Medida;

						$Detalle = $Detalle ."    Used=".$Por_Usada."%";   

						

						$pdf->SetX(60);

						$pdf->Multicell(225,5, $Detalle ,0,L,true);

						

						  $aux=$pdf->GetY();				

						  $pdf->SetY($aux+10);				  

						  $aux7=$pdf->GetY();				

						  if($aux7>=180)

						  {

							  $pdf->AddPage('L');

							  membrete($pdf);

							  encabezado($pdf,$af1,$af2);

							  $aux=$pdf->GetY()+2;	

						  }	

						  $pdf->SetY($aux);				  

				  

						$contador++;

					}

					mysqli_free_result($result2);										

				  //************************************* FIN Material Used *************************************

				  //************************************* INICIO Material Request *************************************				  

				  

					$pdf->SetY($aux);

					$pdf->SetX(20);

					$pdf->Multicell(25,5,"Material Request:",0,L,true);	

					

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

						$Denominacion = $row2["Denominacion"];

						$Unidad_Medida = $row2["Unidad_Medida"];

						$Cantidad_Usada=$row2["Cantidad"];																	  

						

						if ( !(is_null($Cantidad_Usada)) )

							$Detalle = $Detalle.$Cantidad_Usada.$Unidad_Medida." ".$Denominacion.", "; 					

					}

					mysqli_free_result($result2);					

					

					$pdf->SetY($aux);

					$pdf->SetX(45);

					$pdf->Multicell(225,5,$Detalle,0,L,true);

					

				  $aux=$pdf->GetY();				

				  $pdf->SetY($aux+10);				  

				  $aux7=$pdf->GetY();				

				  if($aux7>=180)

				  {

					  $pdf->AddPage('L');

					  membrete($pdf);

					  encabezado($pdf,$af1,$af2);

					  $aux=$pdf->GetY()+2;	

				  }	

				  $pdf->SetY($aux);				  

				  //************************************* FIN Material Request *************************************

				  //************************************* INICIO Visitors *************************************				  

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

						

					$pdf->SetY($aux);

					$pdf->SetX(20);

					$pdf->Multicell(25,5,"Visitor:",0,L,true);	

					

					$pdf->SetY($aux);

					$pdf->SetX(45);

					$pdf->Multicell(225,5,$Descp3,0,L,true);

					

					  $aux=$pdf->GetY();				

					  $pdf->SetY($aux+10);				  

					  $aux7=$pdf->GetY();				

					  if($aux7>=180)

					  {

						  $pdf->AddPage('L');

						  membrete($pdf);

						  encabezado($pdf,$af1,$af2);

						  $aux=$pdf->GetY()+2;	

					  }	

					  $pdf->SetY($aux);				  

										

					$pdf->SetY($aux);

					$pdf->SetX(20);

					$pdf->Multicell(25,5,"Painters to return:",0,L,true);	

					

					$pdf->SetY($aux);

					$pdf->SetX(45);

					$pdf->Multicell(225,5,$Descp4,0,L,true);

					$pdf->SetY($aux+10);				  

					$aux=$pdf->GetY();		

					

					if($aux>=180)

					{

						$pdf->AddPage('L');

						membrete($pdf);

						encabezado($pdf,$af1,$af2);

						$aux=$pdf->GetY()+2;	

					}

				  //************************************* FIN Material Request *************************************

				  $pdf->SetLineWidth(0.5); 

				  $pdf->line(10,$pdf->GetY(),270,$pdf->GetY());

				  $aux=$pdf->GetY()+2;

			}

		  

	}		

	$pdf->Output("dato.pdf");

	?>

	<embed src="dato.pdf#toolbar=1&navpanes=0&scrollbar=0" width="1190" height="570"></embed>

    <?

	require('Library/Close_Conexion.php');	

?>







