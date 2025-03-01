<?php

	session_name("Administrador");

	session_start();

	//*******************************************************************

	//Datos enviados por proyecto_reporte_material_0.php

	//******************************************************************

	$Pro_ID_Reporte=$_REQUEST["Pro_ID_Reporte"];	

	

	//$Tipo=$_REQUEST["Tipo"];

	//$Nombre_Material=$_REQUEST["Nombre_Material"];		



	require('Library/Control_Cache.php');	

	require('Library/Open_Conexion.php');

	require('Library/funciones.php');	

	// INSERTADO POR FABIOLA CARRASCO

	require('pdf/fpdf.php');

	//$pdf=new FPDF('L','mm','Letter');

	$pdf=new FPDF('L','mm','Legal');

	$pdf->AddPage();



	// DEFINICION DE FUNCIONES DE CABEZERA DE SUBCUEPO

	$pdf->SetMargins(15,20,15,15);

	$pdf->SetFont('Arial','',12);

	$pdf->SetLineWidth(0.5); 

	$pdf->Setfillcolor(237,243,120);	



	function membrete(&$pdf)

	{

		//ENCABEZADO

		$pdf->SetFont('Arial','',8);

		$pdf->Image('images/logo.png',5,5,30,10,"png");		

	}	



	function encabezado(&$pdf,$f1,$f2, $Tipo)

	{

		$f1=FormatDateTime($f1, 8);

		$f2=FormatDateTime($f2, 8);

		$pdf->Multicell(0,5,"",0,L,false);

		$pdf->Multicell(0,5,"Job Structure",0,C,false);

		

		// titulo del detall	  

		$aux=$pdf->GetY();

		$pdf->SetX(20);

		$pdf->Multicell(20,5,"       .",0,L,false);

		$pdf->SetY($aux);

		$pdf->SetX(70);

		$pdf->Multicell(15,5,"#units estimated",0,L,false);

		$pdf->SetY($aux);

		$pdf->SetX(90);

		$pdf->Multicell(15,5,"#units done",0,L,false);

		

		

		$aux7=$pdf->GetY()+5;

		$pdf->line(10,$pdf->GetY()-7,350,$pdf->GetY()-7);

		$pdf->line(10,$aux+10,350,$aux+10);

		$pdf->SetY($aux7);

	}	



	

	// titulo del reporte

	membrete($pdf,$vfrom_date);	

	

	



///// Inicio de reporte con cortes de control	

	

	$sql = "SELECT p.Pro_ID, p.Codigo, p.Nombre,p.Horas_Estimadas FROM proyectos p ";	

	$sql = $sql . " WHERE  p.Pro_ID=$Pro_ID_Reporte ";

	$result_0=$bd->ejecutar($sql);

 while($row0=mysqli_fetch_array($result_0))

	{	

	$Pro_ID=$row0["Pro_ID"];

	$Codigo=$row0["Codigo"];

	$Nombre=$row0["Nombre"];

	$job_Nombre=$row0["Nombre"];

	$JobHoras_Estimadas=$row0["Horas_Estimadas"];

	$JAux2=$row0['Aux2'];

	

	encabezado($pdf,$af1,$af2, $Tipo);	  

	$pdf->SetX(10);	

	$pdf->Multicell(150,5,"Job: ".$Codigo." ".$Nombre,0,L,false);

	$JFATotal_Cantidad_Usada=0;

	$JFATotal_Units_Done=0;

	$JFATotal_Used_Horas=0;

	$JFAHoras_Estimadas=0;

	$JFAPor_wj=0;



	$sql1 = "SELECT * FROM floor WHERE floor.Pro_ID=".$Pro_ID_Reporte." Order by Nombre";

//echo $sql1."<br>";

	$result_1=$bd->ejecutar($sql1);	

    while($row1=mysqli_fetch_array($result_1))

	{

		$FAUnits_Estimadas=$row11['Aux1'];

		$FAMaterial_Estimado=$row1['Material_Estimado'];

		$FAux2=$row1['Aux2'];

		//$FAHoras_Estimadas=$row1['Horas_Estimadas'];

		$FAHoras_Estimadas=0;

		$FATotal_Cantidad_Usada=0;

		$FATotal_Units_Done=0;

		$FATotal_Used_Horas=0;

		$FATotal_Units_Estimadas=0;

		$FATotal_Per_wholejob=0;

		$FAPor_wj=0;

		$Floor_Name=$row1['Nombre'];

		$Floor_ID=$row1["Floor_ID"];

		$pdf->SetX(13);	

		$pdf->Multicell(170,5,$row1['Nombre'],0,L,false);

	

		$sql2 = "SELECT * FROM area_control WHERE area_control.Pro_ID=".$Pro_ID_Reporte." AND area_control.Floor_ID=".$Floor_ID;

		//echo $sql2."<br>";

		$result_2=$bd->ejecutar($sql2);	

		while($row2=mysqli_fetch_array($result_2))

		{

			$AUnits_Estimadas=$row2['Aux1'];

			$AMaterial_Estimado=$row2['Material_Estimado'];

			$AAux2=$row2['Aux2'];

			$AHoras_Estimadas=0;

			//$AHoras_Estimadas=$row2['Horas_Estimadas'];

			$ATotal_Cantidad_Usada=0;

			$ATotal_Units_Done=0;

			$ATotal_Used_Horas=0;

			$ATotal_Units_Estimadas=0;

			$ATotal_Per_wholejob=0;

			$APor_wj=0;

			$Contador=0;

			

			$Area_ID=$row2["Area_ID"];

			$pdf->SetX(15);				

			$pdf->Multicell(200,5,$row2['Nombre'],0,L,false);

			$Area_Name=$row2['Nombre'];

			$sql3 = "SELECT * FROM task WHERE task.Pro_ID=".$Pro_ID_Reporte." AND task.Floor_ID=".$Floor_ID." AND task.Area_ID=".$Area_ID;

			//echo $sql3."<br>";

			$result_3=$bd->ejecutar($sql3);	

			while($row3=mysqli_fetch_array($result_3))

			{

			$Units_Estimadas=$row3['Aux1'];

			$Material_Estimado=$row3['Material_Estimado'];

			$Horas_Estimadas=$row3['Horas_Estimadas'];

			$Total_Cantidad_Usada=0;

			$Total_Units_Done=0;

			$Total_Used_Horas=0;

			$Por_wj=$row3['Aux2'];

			$TAux2=$row3['Aux2'];

			

			

			$Task_ID=$row3["Task_ID"];

			$pdf->SetX(18);	

			if ($Tipo=="Detalle")				

				$pdf->Multicell(200,5,$row3['Nombre'],0,L,false);

			$Task_Name=$row3['Nombre'];

			

			$sql4 = "SELECT dr.Actividad_ID AS Actividad_ID,dr.Task_ID AS Task_ID, dr.Horas AS Horas, dr.Numero AS Numero, ac.Actividad_ID, ac.Fecha AS Fecha FROM dayli_report_task dr, actividades ac WHERE dr.Actividad_ID=ac.Actividad_ID AND dr.Task_ID=".$Task_ID;

			$sql4 = $sql4 . " ORDER BY ac.Fecha  ";

			//echo $sql4."<br>";

			$result_4=$bd->ejecutar($sql4);	

			while($row4=mysqli_fetch_array($result_4))

			{

				//echo $sql2."<br>";

				$aux=$pdf->GetY();

				$pdf->SetX(20);

				$dato=date_create($row4["Fecha"]);

				$fecha=date_format($dato,'y/m/d');

				$dato1=$fecha;			

				

				$vdia=substr($dato1,6,2);

				$vmes=substr($dato1,3,2);

				$vano=substr($dato1,0,2);

				

				$fecha1="20".$vano."-".$vmes."-" .$vdia;

				$texdia= substr((FormatDateTime($fecha1, 8)),0,3);						  				

				$fecha1=$texdia.".".$vmes."-".$vdia."-".$vano;

			

			///////////**************

				if ($Tipo=="Detalle")

				{

				$aux=$pdf->GetY();

				$pdf->SetX(40);

				$pdf->Multicell(20,5,$fecha1,0,L,false);

				$pdf->SetY($aux);

				$pdf->SetX(70);

				//$pdf->Multicell(15,5,$row['Units_Estimated'],0,R,false);

				$pdf->Multicell(15,5,"",0,R,false);

				$aux33=$pdf->GetY();

				$pdf->SetY($aux);

				$pdf->SetX(85);				

				$pdf->Multicell(15,5,$row4['Numero'],0,R,false);

				$pdf->SetY($aux);

				$pdf->SetX(90);

				$pdf->Multicell(25,5,"",0,R,false);

				$pdf->Multicell(25,5,"",0,R,false);

				$pdf->SetY($aux);

				$pdf->SetX(115);	

				//$pdf->Multicell(25,5,$row4['Horas'],0,R,false);

				$pdf->SetY($aux);

				$pdf->SetX(140);

				//$pdf->Multicell(20,5,$row['Hrs_Left'],0,R,false);

				$pdf->Multicell(20,5,"",0,R,false);

				$pdf->SetY($aux);

				$pdf->SetX(160);	

				//$pdf->Multicell(20,5,$row['Percent_Used_Hrs'],0,R,false);			

				$pdf->Multicell(20,5,"",0,R,false);	

				}

				

					

				$sql = "SELECT  SUM(pm.Cantidad_Usada) AS Cantidad_Usada FROM pedidos_material pm INNER JOIN materiales m ON pm.Mat_ID=m.Mat_ID ";

				$sql = $sql . "  WHERE m.Unidad_Medida='gl.' AND pm.Actividad_ID=".$row4['Actividad_ID']." AND  pm.Task_ID=".$row4['Task_ID'];	

					

				//echo $sql."<br>";

				$result=$bd->ejecutar($sql);	

				while($row=mysqli_fetch_array($result))

					{

						$Cantidad_Usada=$row["Cantidad_Usada"];

					}

				mysqli_free_result($result);		

				if ($Tipo=="Detalle")

				{	

				$pdf->SetY($aux);

				$pdf->SetX(180);

				$pdf->Multicell(20,5,"",0,R,false);			

				$pdf->SetY($aux);

				$pdf->SetX(200);

				$pdf->Multicell(20,5,number_format($Cantidad_Usada,2),0,R,false);			

				}

				$Total_Cantidad_Usada += $Cantidad_Usada;

				$Total_Units_Done += $row4['Numero'];

				$Total_Used_Horas += $row4['Horas'];

				

				$aux7=$pdf->GetY();					  

					if($aux7>=180)

					{

						$pdf->AddPage();

						membrete($pdf);

						encabezado($pdf,$af1,$af2, $Tipo);				

						$aux=$pdf->GetY()+2;

					}

					else

					{			  

					  //$pdf->SetY($aux7);

					  //$aux=$pdf->GetY();

					  $aux=$aux7;

					}

				

			}								



			$aux=$pdf->GetY();																	

			$pdf->SetX(18);					

			$pdf->Multicell(50,5,"Total ".$Task_Name,0,L,false);						

			$aux_99=$pdf->GetY();

				

			$pdf->SetY($aux);	

			$pdf->SetX(70);

					

			$aux7=$aux_99+5;

			$bb=$aux_99-$aux;

			$pdf->line(10,$pdf->GetY()-5,350,$pdf->GetY()-5);

			$pdf->line(10,$aux+$bb,350,$aux+$bb);

						

			$pdf->SetY($aux7);												

			$aux7=$pdf->GetY();							

					if($aux7>=180)

					{

							$pdf->AddPage();

							membrete($pdf);

							encabezado($pdf,$af1,$af2, $Tipo);				

							$aux=$pdf->GetY()+2;

					}

					else

					{			  

							  //$pdf->SetY($aux7);

							  //$aux=$pdf->GetY();

							  $aux=$aux7;

					}			

			$Contador++;

			$APor_wj+=$TPor_wj;

			}

////////////////INICIO IMPRESION DE TOTAL AREA/

			$aux=$pdf->GetY();																	

			$pdf->SetX(15);					

			$pdf->Multicell(50,5,"Total ".$Area_Name,0,L,false);						

			$aux_99=$pdf->GetY();

				

			$pdf->SetY($aux);	

			$pdf->SetX(70);

			

			if ($Contador==0)

			{

			$Contador=1;

			}

			$ATotal_Units_Estimadas=$ATotal_Units_Estimadas/$Contador;

			//$pdf->Multicell(15,5,number_format($ATotal_Units_Estimadas,2),0,R,false);

			$pdf->SetY($aux);		

			$pdf->SetX(85);			

			$ATotal_Units_Done=$ATotal_Units_Done/$Contador;	

			//$pdf->Multicell(15,5,number_format($ATotal_Units_Done,2),0,R,false);

			$pdf->SetY($aux);

						$pdf->SetX(90);

						$pdf->Multicell(25,5,number_format($AHoras_Estimadas,2),0,R,false);

						$pdf->SetY($aux);

						$pdf->SetX(115);	

						$pdf->Multicell(25,5,number_format($ATotal_Used_Horas,2),0,R,false);

						$pdf->SetY($aux);

						$pdf->SetX(140);

						$Total_Horas_Left=$AHoras_Estimadas-$ATotal_Used_Horas;

						$pdf->Multicell(20,5,number_format($Total_Horas_Left,2),0,R,false);

						$pdf->SetY($aux);

						$pdf->SetX(160);

						if ($AHoras_Estimadas>0)

						{

						$Total_Percent_Used_Horas=($ATotal_Used_Horas/$AHoras_Estimadas)*100;

						if ($AHoras_Estimadas<3)

							$Total_Percent_Used_Horas=0;

						}

						else

							{

							  $Total_Percent_Used_Horas=0;

							}

						if ($AAux2==0)

							$Total_Percent_Ejecutado=0;	

						  else

							$Total_Percent_Ejecutado=$APor_wj/$AAux2;

						if ($Total_Percent_Used_Horas>$Total_Percent_Ejecutado)

						{

						$textp="%**";

						}

						else

						{

						$textp="%";

						}

						$Text='    '.number_format($Total_Percent_Used_Horas,2).$textp;

						//$pdf->Multicell(20,5,number_format($Total_Percent_Used_Horas,2),0,R,false);

						$pdf->Multicell(20,5,$Text,0,L,false);

						/*$pdf->SetY($aux);

						$pdf->SetX(180);	

						$pdf->Multicell(20,5,number_format($AMaterial_Estimado,2),0,R,false);						

						$pdf->SetY($aux);

						$pdf->SetX(200);	

						$pdf->Multicell(20,5,number_format($ATotal_Cantidad_Usada,2),0,R,false);

						$pdf->SetY($aux);

						$pdf->SetX(220);

						$total_Material_Left=$AMaterial_Estimado-$ATotal_Cantidad_Usada;

						$pdf->Multicell(20,5,number_format($total_Material_Left,2),0,R,false);

						$pdf->SetY($aux);

						$pdf->SetX(240);

						if ($AMaterial_Estimado>0)

						{

							$Total_Percent_Material_Used=$ATotal_Cantidad_Usada/$AMaterial_Estimado*100;

						}

						else

						{

							$Total_Percent_Material_Used=0;

						}

						

						$Text='    '.number_format($Total_Percent_Material_Used,2)."%";

						$pdf->Multicell(20,5,$Text,0,L,false);*/

						$pdf->SetY($aux);

						$pdf->SetX(260);

						$pdf->Multicell(20,5,'',0,L,false);

						//$pdf->Multicell(20,5,$AAux2,0,L,false);

						//$pdf->Multicell(20,5,number_format($total_Percent_Estimado,2),0,R,false);

						$pdf->SetY($aux);

						$pdf->SetX(280);

						if ($AAux2>0)

						{

						

						$Total_Percent_Ejecutado=$APor_wj/$AAux2;

						}

						else

						{

						$Total_Percent_Ejecutado=0;

						}		

						$Text='    '.number_format($Total_Percent_Ejecutado,2).$textp; 

						$pdf->Multicell(20,5,$Text,0,L,false);

			$pdf->SetY($aux);

			$pdf->SetX(300);

			$Total_Percent_Pendiente=100-$Total_Percent_Ejecutado;

			

			$Text='    '.number_format($Total_Percent_Pendiente,2)."%";

			$pdf->Multicell(20,5,$Text,0,L,false);

			//$pdf->Multicell(20,5,number_format($Total_Percent_Pendiente,2),0,R,false);

					

			$aux7=$aux_99+5;

			//$aux7=$pdf->GetY();

			/*$pdf->line(10,$pdf->GetY()-5,350,$pdf->GetY()-5);

			$pdf->line(10,$aux+5,350,$aux+5);*/

					

			$bb=$aux_99-$aux;

			$pdf->line(10,$pdf->GetY()-5,350,$pdf->GetY()-5);

			$pdf->line(10,$aux+$bb,350,$aux+$bb);

						

			$pdf->SetY($aux7);												

			$aux7=$pdf->GetY();							

					if($aux7>=180)

					{

							$pdf->AddPage();

							membrete($pdf);

							encabezado($pdf,$af1,$af2, $Tipo);				

							$aux=$pdf->GetY()+2;

					}

					else

					{			  

							  //$pdf->SetY($aux7);

							  //$aux=$pdf->GetY();

							  $aux=$aux7;

					}			

			$FATotal_Cantidad_Usada+=$ATotal_Cantidad_Usada;

			$FATotal_Units_Done+=$ATotal_Units_Done;

			$FATotal_Used_Horas+=$ATotal_Used_Horas;

			$FATotal_Units_Estimadas+=$ATotal_Units_Estimadas;

			$FAHoras_Estimadas+=$AHoras_Estimadas;

			//$FATotal_Per_wholejob+=($Total_Percent_Ejecutado/100)*($AHoras_Estimadas/$JobHoras_Estimadas);

			$FATotal_Per_wholejob+=$Total_Percent_Ejecutado;

			$FAPor_wj+=$APor_wj;

///////////	FIN IMPRESION TOTAL AREA				

		}

		

///// Inicio impresion FLOOR 

			$aux=$pdf->GetY();																	

			$pdf->SetX(12);					

			$pdf->Multicell(50,5,"Total ".$Floor_Name,0,L,false);						

			$aux_99=$pdf->GetY();

				

			$pdf->SetY($aux);	

			$pdf->SetX(70);

			

			//$pdf->Multicell(15,5,number_format($FATotal_Units_Estimadas,2),0,R,false);

			$pdf->SetY($aux);		

			$pdf->SetX(85);				

			//$pdf->Multicell(15,5,number_format($FATotal_Units_Done,2),0,R,false);

			$pdf->SetY($aux);

						$pdf->SetX(90);

						$pdf->Multicell(25,5,number_format($FAHoras_Estimadas,2),0,R,false);

						$pdf->SetY($aux);

						$pdf->SetX(115);	

						$pdf->Multicell(25,5,number_format($FATotal_Used_Horas,2),0,R,false);

						$pdf->SetY($aux);

						$pdf->SetX(140);

						$Total_Horas_Left=$FAHoras_Estimadas-$FATotal_Used_Horas;

						$pdf->Multicell(20,5,number_format($Total_Horas_Left,2),0,R,false);

						$pdf->SetY($aux);

						$pdf->SetX(160);

						if ($FAHoras_Estimadas>0)

						{

						$Total_Percent_Used_Horas=($FATotal_Used_Horas/$FAHoras_Estimadas)*100;

						if ($FAHoras_Estimadas<3)

							$Total_Percent_Used_Horas=0;

						}

						else

							{

							  $Total_Percent_Used_Horas=0;

							}

						if ($FAux2==0)

								$Total_Percent_Ejecutado=0;

						   else	

							$Total_Percent_Ejecutado=$FAPor_wj/$FAux2;

						if ($Total_Percent_Used_Horas>$Total_Percent_Ejecutado)

						{

						$textp="%**";

						}

						else

						{

						$textp="%";

						}

						$Text='    '.number_format($Total_Percent_Used_Horas,2).$textp;

						//$pdf->Multicell(20,5,number_format($Total_Percent_Used_Horas,2),0,R,false);

						$pdf->Multicell(20,5,$Text,0,L,false);

						/*$pdf->SetY($aux);

						$pdf->SetX(180);	

						$pdf->Multicell(20,5,number_format($FAMaterial_Estimado,2),0,R,false);						

						$pdf->SetY($aux);

						$pdf->SetX(200);	

						$pdf->Multicell(20,5,number_format($FATotal_Cantidad_Usada,2),0,R,false);

						$pdf->SetY($aux);

						$pdf->SetX(220);

						$total_Material_Left=$FAMaterial_Estimado-$FATotal_Cantidad_Usada;

						$pdf->Multicell(20,5,number_format($total_Material_Left,2),0,R,false);

						$pdf->SetY($aux);

						$pdf->SetX(240);

						if ($FAMaterial_Estimado>0)

						{

							$Total_Percent_Material_Used=$FATotal_Cantidad_Usada/$FAMaterial_Estimado*100;

						}

						else

						{

							$Total_Percent_Material_Used=0;

						}

						

						$Text='    '.number_format($Total_Percent_Material_Used,2)."%";

						$pdf->Multicell(20,5,$Text,0,L,false);*/

						$pdf->SetY($aux);

						$pdf->SetX(260);

						$pdf->Multicell(20,5,'',0,L,false);

						//$pdf->Multicell(20,5,$FAux2,0,L,false);

						//$pdf->Multicell(20,5,number_format($total_Percent_Estimado,2),0,R,false);

						$pdf->SetY($aux);

						$pdf->SetX(280);

						if ($FAux2>0)

						{

						

						$Total_Percent_Ejecutado=$FAPor_wj/$FAux2;

						}

						else

						{

						$Total_Percent_Ejecutado=0;

						}

						$Text='    '.number_format($Total_Percent_Ejecutado,2).$textp;

						$pdf->Multicell(20,5,$Text,0,L,false);

			$pdf->SetY($aux);

			$pdf->SetX(300);

			$Total_Percent_Pendiente=100-$Total_Percent_Ejecutado;

			

			$Text='    '.number_format($Total_Percent_Pendiente,2)."%";

			$pdf->Multicell(20,5,$Text,0,L,false);

			//$pdf->Multicell(20,5,number_format($Total_Percent_Pendiente,2),0,R,false);

					

			$aux7=$aux_99+5;

			//$aux7=$pdf->GetY();

			/*$pdf->line(10,$pdf->GetY()-5,350,$pdf->GetY()-5);

			$pdf->line(10,$aux+5,350,$aux+5);*/

					

			$bb=$aux_99-$aux;

			$pdf->line(10,$pdf->GetY()-5,350,$pdf->GetY()-5);

			$pdf->line(10,$aux+$bb,350,$aux+$bb);

						

			$pdf->SetY($aux7);												

			$aux7=$pdf->GetY();							

					if($aux7>=180)

					{

							$pdf->AddPage();

							membrete($pdf);

							encabezado($pdf,$af1,$af2, $Tipo);				

							$aux=$pdf->GetY()+2;

					}

					else

					{			  

							  //$pdf->SetY($aux7);

							  //$aux=$pdf->GetY();

							  $aux=$aux7;

					}			

			$JFATotal_Cantidad_Usada+=$Total_Cantidad_Usada;

			$JFATotal_Units_Done+=$FATotal_Units_Done;

			$JFATotal_Used_Horas+=$FATotal_Used_Horas;

			$JFAHoras_Estimadas+=$FAHoras_Estimadas;

			$JFATotal_Units_Estimadas+=$FATotal_Units_Estimadas;

			//$JFATotal_Per_wholejob+=($Total_Percent_Ejecutado/100)*($FAHoras_Estimadas/$JobHoras_Estimadas);

			$JFAPor_wj+=$FAPor_wj;

		



////// Fin impresion FLOOR 		

	}

//// Inicio impresion JOB

			$aux=$pdf->GetY();																	

			$pdf->SetX(10);					

			$pdf->Multicell(50,5,"Total Job: ".$Job_Name,0,L,false);						

			$aux_99=$pdf->GetY();

				

			$pdf->SetY($aux);	

			$pdf->SetX(70);

			

			//$pdf->Multicell(15,5,number_format($JFATotal_Units_Estimadas,2),0,R,false);

			$pdf->SetY($aux);		

			$pdf->SetX(85);				

			//$pdf->Multicell(15,5,number_format($JFATotal_Units_Done,2),0,R,false);

			$pdf->SetY($aux);

						$pdf->SetX(90);

						$pdf->Multicell(25,5,number_format($JFAHoras_Estimadas,2),0,R,false);

						$pdf->SetY($aux);

						$pdf->SetX(115);	

						$pdf->Multicell(25,5,number_format($JFATotal_Used_Horas,2),0,R,false);

						$pdf->SetY($aux);

						$pdf->SetX(140);

						$Total_Horas_Left=$JFAHoras_Estimadas-$JFATotal_Used_Horas;

						$pdf->Multicell(20,5,number_format($Total_Horas_Left,2),0,R,false);

						$pdf->SetY($aux);

						$pdf->SetX(160);

						if ($JFAHoras_Estimadas>0)

						{

						$Total_Percent_Used_Horas=($JFATotal_Used_Horas/$JFAHoras_Estimadas)*100;

						}

						else

							{

							  $Total_Percent_Used_Horas=0;

							}

						$Total_Percent_Ejecutado=$JFAPor_wj/100;

						if ($Total_Percent_Used_Horas>$Total_Percent_Ejecutado)

						{

						$textp="%**";

						}

						else

						{

						$textp="%";

						}

							

						$Text='    '.number_format($Total_Percent_Used_Horas,2).$textp;

						//$pdf->Multicell(20,5,number_format($Total_Percent_Used_Horas,2),0,R,false);

						$pdf->Multicell(20,5,$Text,0,L,false);

						/*$pdf->SetY($aux);

						$pdf->SetX(180);	

						$pdf->Multicell(20,5,number_format($JFAMaterial_Estimado,2),0,R,false);						

						$pdf->SetY($aux);

						$pdf->SetX(200);	

						$pdf->Multicell(20,5,number_format($JFATotal_Cantidad_Usada,2),0,R,false);

						$pdf->SetY($aux);

						$pdf->SetX(220);

						$total_Material_Left=$JFAMaterial_Estimado-$JFATotal_Cantidad_Usada;

						$pdf->Multicell(20,5,number_format($total_Material_Left,2),0,R,false);

						$pdf->SetY($aux);

						$pdf->SetX(240);

						if ($JFAMaterial_Estimado>0)

						{

							$Total_Percent_Material_Used=$JFATotal_Cantidad_Usada/$JFAMaterial_Estimado*100;

						}

						else

						{

							$Total_Percent_Material_Used=0;

						}

						

						$Text='    '.number_format($Total_Percent_Material_Used,2)."%";

						$pdf->Multicell(20,5,$Text,0,L,false);*/

						$pdf->SetY($aux);

						$pdf->SetX(260);

						$pdf->Multicell(20,5,$JAux2,0,L,false);

						//$pdf->Multicell(20,5,number_format($total_Percent_Estimado,2),0,R,false);

						$pdf->SetY($aux);

						$pdf->SetX(280);

						

						$Total_Percent_Ejecutado=$JFAPor_wj/100;

						

						$Text='    '.number_format($Total_Percent_Ejecutado,2).$textp;

						$pdf->Multicell(20,5,$Text,0,L,false);

			$pdf->SetY($aux);

			$pdf->SetX(300);

			$Total_Percent_Pendiente=100-$Total_Percent_Ejecutado;

			

			$Text='    '.number_format($Total_Percent_Pendiente,2)."%";

			$pdf->Multicell(20,5,$Text,0,L,false);

			//$pdf->Multicell(20,5,number_format($Total_Percent_Pendiente,2),0,R,false);

					

			$aux7=$aux_99+5;

			//$aux7=$pdf->GetY();

			/*$pdf->line(10,$pdf->GetY()-5,350,$pdf->GetY()-5);

			$pdf->line(10,$aux+5,350,$aux+5);*/

					

			$bb=$aux_99-$aux;

			$pdf->line(10,$pdf->GetY()-5,350,$pdf->GetY()-5);

			$pdf->line(10,$aux+$bb,350,$aux+$bb);

						

			$pdf->SetY($aux7);												

			$aux7=$pdf->GetY();							

					if($aux7>=180)

					{

							$pdf->AddPage();

							membrete($pdf);

							encabezado($pdf,$af1,$af2, $Tipo);				

							$aux=$pdf->GetY()+2;

					}

					else

					{			  

							  //$pdf->SetY($aux7);

							  //$aux=$pdf->GetY();

							  $aux=$aux7;

					}			



//// Fin impresion JOB 	



	

}

	

	

	

	

	

	

	

	

	

			

	$pdf->Output("dato.pdf");

	

?>

	<embed src="dato.pdf#toolbar=1&navpanes=0&scrollbar=1" width="990" height="670"></embed>

<?

	require('Library/Close_Conexion.php');	

?>















