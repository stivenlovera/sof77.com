<?php
	session_name("Administrador");
	session_start();
	//*******************************************************************
	//Datos enviados por proyecto_reporte_material_0.php
	//cambios realizados 02/16/13
	//******************************************************************
	$vfrom_date=$_REQUEST["vfrom_date"];
	$vto_date=$_REQUEST["vto_date"];	

	$Pro_ID_Reporte=$_REQUEST["Pro_ID_Reporte"];		
	
	require('Library/Control_Cache.php');	
	require('Library/Open_Conexion.php');
	require('Library/funciones.php');	
	// INSERTADO POR FABIOLA CARRASCO
	require('pdf/fpdf.php');
	//$pdf=new FPDF('L','mm','Letter');
	$pdf=new FPDF('L','mm','Legal');
	$pdf->AddPage();

	// DEFINICION DE FUNCIONES DE CABEZERA DE SUBCUEPO
	$pdf->SetMargins(10,10,10,10);
	$pdf->SetFont('Arial','',11);
	$pdf->SetLineWidth(0.5); 
	$pdf->Setfillcolor(237,243,120);	

	function membrete(&$pdf)
	{
		//ENCABEZADO
		$pdf->SetFont('Arial','',8);
		$pdf->Image('images/logo.png',5,5,30,10,"png");		
	}	

	function encabezado(&$pdf,$f1,$f2)
	{
		$f1=FormatDateTime($f1, 8);
		$f2=FormatDateTime($f2, 8);
		$pdf->Multicell(0,5,"",0,L,false);
		
		
		$pdf->Multicell(0,5,"RESUME OF JOBS--:: from ".$f1."   to: ".$f2,0,C,false);
		//$pdf->Multicell(0,5,"from: ".$f1."   to: ".$f2,0,C,false);
		
		$pdf->Multicell(0,5,"",0,L,false);
		
		// titulo del detall	  
		$aux=$pdf->GetY();
		$pdf->SetX(20);
		$pdf->Multicell(20,5,"",0,L,false);
		$pdf->SetY($aux);
		$pdf->SetX(70);
		$pdf->Multicell(15,5,". ",0,L,false);
		$pdf->SetY($aux);
		$pdf->SetX(85);
		$pdf->Multicell(15,5,". ",0,L,false);
		$pdf->SetY($aux);
		$pdf->SetX(90);
		$pdf->Multicell(30,5,"Hrs.Estimated",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(124);
		$pdf->Multicell(20,5,"Hrs.Used",0,l,false);
		$pdf->SetY($aux);
		$pdf->SetX(150);
		$pdf->Multicell(15,5,"Hrs.left",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(171);
		$pdf->Multicell(25,5,"%hrs.used",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(197);
		$pdf->Multicell(20,5," //",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(221);
		$pdf->Multicell(20,5," ///",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(245);
		$pdf->Multicell(35,5,"Hours on Ticket",0,C,false);
		/*$pdf->SetY($aux);
		$pdf->SetX(240);
		$pdf->Multicell(20,5,".",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(260);
		$pdf->Multicell(20,5,".",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(280);
		$pdf->Multicell(20,5,"% Done",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(300);
		$pdf->Multicell(20,5,"% Pending",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(320);
		$pdf->Multicell(20,5,"Notes:",0,C,false);*/
		
		$aux7=$pdf->GetY()+3;
		$pdf->line(10,$pdf->GetY()-7,290,$pdf->GetY()-7);
		$pdf->line(10,$aux+6,290,$aux+6);
		$pdf->SetY($aux7);
	}	

	
	$vdia=substr($vfrom_date,3,2);
	$vmes=substr($vfrom_date,0,2);
	$vano=substr($vfrom_date,8,2);
	
	//	  $dato=date_create($vfrom_date);
	//	  $af1=date_format($dato,'y/d/m');
	$af1="20".$vano."-".$vmes."-" .$vdia;
	$vdia=substr($vto_date,3,2);
	$vmes=substr($vto_date,0,2);
	$vano=substr($vto_date,8,2);
	
	$af2="20".$vano."-".$vmes."-" .$vdia;
	
	// titulo del reporte
	membrete($pdf,$vfrom_date);	
	

	$total_grl_floor_area_Units_Estimated = 0;
	$total_grl_floor_area_units_done = 0;
	$total_grl_floor_area_Horas_Estimadas = 0;
	$total_grl_floor_area_used_hrs = 0;
	$total_grl_floor_area_Hrs_Left = 0;
	$total_grl_floor_area_Percent_Used_Hrs = 0;
	
	$total_grl_floor_area_Material_Estimado = 0;
	$total_grl_floor_area_Cantidad_Usada = 0;	
	$total_grl_floor_area_Material_Left = 0;
	$total_grl_floor_area_Percent_Material_Used = 0;
	$total_grl_floor_area_Percent_Estimado = 0;
	$total_grl_floor_area_Percent_Ejecutado = 0;
	$total_grl_floor_area_Percent_Pendiente = 0;
	$numjob = 0;
	encabezado($pdf,$af1,$af2);	

	$sql = "SELECT p.*, em.Nombre as Company, ";	
	$sql = $sql . " CONCAT(em1.Nick_Name) as Foreman, ";
	$sql = $sql . " CONCAT(em2.Nick_Name) as Pwtsuper, ";
	$sql = $sql . " CONCAT(em3.Nick_Name) as Manager ";
	
	//$sql = $sql . " CONCAT(em4.Nombre, ' ',  em4.Apellido_Paterno) as GCManager ";
	$sql = $sql . " FROM proyectos p ";
	
	$sql = $sql . " INNER JOIN empresas em ON p.Emp_ID=em.Emp_ID ";	
	$sql = $sql . " LEFT JOIN personal em1 ON em1.Empleado_ID=p.Foreman_ID ";
	$sql = $sql . " LEFT JOIN personal em2 ON em2.Empleado_ID=p.Coordinador_ID ";		
	$sql = $sql . " LEFT JOIN personal em3 ON em3.Empleado_ID=p.Manager_ID ";	
	//$sql = $sql . " LEFT JOIN personal em4 ON em4.Empleado_ID=p.Coordinador_Obra_ID ";
	
	if ($Pro_ID_Reporte!="-33")	
		$sql = $sql . " WHERE  p.Pro_ID IN ($Pro_ID_Reporte) ";

	$sql = $sql . " GROUP BY p.Pro_ID, p.Codigo, p.Nombre ORDER BY p.Nombre ";
//echo $sql."<br>";
	$result_00=$bd->ejecutar($sql);	
    while($row00=mysqli_fetch_array($result_00))
	{
	
		
		$Pro_ID=$row00["Pro_ID"];
		$Codigo=$row00["Codigo"];
		$Nombre=$row00["Nombre"];
		
		$Estado = $row00["Estado"];	
		$Ciudad = $row00["Ciudad"];	
		$Zip_Code = $row00["Zip_Code"];			
		$Calle = $row00["Calle"];
		$Nota=$row00["Notes"];
		
		
		$Company=$row00["Company"];
		$Foreman=$row00["Foreman"];
		$Manager=$row00["Manager"];
		$Pwtsuper=$row00["Pwtsuper"];
		
		$Task_ID_Ant=-333;
		$Area_ID_Ant=-333;
		$Floor_ID_Ant=-333;	
		
		$aux7=$pdf->GetY();							
		if($aux7>=170)
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
		
		
		
				$sql91="select * from estatus where estatus.Estatus_ID=".$row00['Estatus_ID'];
				//echo $sql91;
				$result91=$bd->ejecutar($sql91);						

			    if (mysql_num_rows($result91)>0) 
				//and ($row['Estatus_ID']<>3)
				{
					$row91=mysqli_fetch_array($result91);
					$status=$row91['Nombre_Estatus'];
					}
				   else
				   $status="";
			
		$aux_99=$pdf->GetY();	
		$aux=$pdf->GetY()+5; 
		$pdf->SetY($aux);
		$pdf->SetX(10);
		$numjob++;	
		$pdf->Multicell(100,5,$numjob." /Job: ".$Codigo." ".$Nombre,0,L,'R'); 	
		$pdf->SetY($aux);				
		$pdf->SetX(110);	
		$pdf->Multicell(100,5,"Add: ".$Numero." ".$Calle.", ".$Ciudad.", ".$Estado." ".$Zip_Code,0,L,false); 	
		$pdf->SetY($aux);				
		$pdf->SetX(255);			
		$pdf->Multicell(35,5,"Status:".$status,0,R,false);
		//$pdf->SetX(210);	
		//$pdf->Multicell(120,5,"GC.: ".$Company." Contact: ".$Super,0,L,false); 
		$aux=$pdf->GetY();
		$pdf->SetY($aux);  
		$pdf->SetX(10);	
		$Texta=$Manager." / ".$Pwtsuper;
		$pdf->Multicell(100,5,"PWT: ".$Texta,0,L,false); 	
		$pdf->SetY($aux);				
		$pdf->SetX(110);	
		$pdf->Multicell(100,5,"Foreman PWT: ".$Foreman,0,L,false); 
		
		
// Inicio de actualizar % del job
$Pro_ID_Reporte=$Pro_ID;
$sql = "SELECT  SUM(Horas_Estimadas) AS Hest FROM task";
					$sql = $sql . "  WHERE task.Pro_ID=".$Pro_ID_Reporte;	
					
	//			echo $sql."<br>";
					$result_1=$bd->ejecutar($sql);	
					$row1=mysqli_fetch_array($result_1);
					$Hest=$row1["Hest"];
				//echo $Hest."<br>";
	$Thest_job=$Hest;
	if ($Thest_job==0)
	{
	 $Thest_job=1;
	 }
	$strSQL = "UPDATE proyectos SET Horas_Estimadas='".$Hest. "',Aux2=100 WHERE proyectos.Pro_ID=".$Pro_ID_Reporte;
//	echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
		
	$sql1 = "SELECT * FROM floor WHERE floor.Pro_ID=".$Pro_ID_Reporte;
//echo $sql1."<br>";
	$result_0=$bd->ejecutar($sql1);	
    while($row0=mysqli_fetch_array($result_0))
	{
		$Pro_ID=$row0["Pro_ID"];
		$Floor_ID=$row0["Floor_ID"];
		$Thest_floor=0;
		$Tmest_floor=0;
		$FUest=0;
		$FPor_Enjob=0;
		$sql2 = "SELECT * FROM area_control WHERE area_control.Pro_ID=".$Pro_ID_Reporte." AND area_control.Floor_ID=".$Floor_ID;
//echo $sql2."<br>";
		$result_2=$bd->ejecutar($sql2);	
		while($row2=mysqli_fetch_array($result_2))
		{
			$Area_ID=$row2["Area_ID"];
			$Uest=$row2["Aux1"];
			$strSQL = "UPDATE task SET Aux2=(task.Horas_Estimadas*100/".$Thest_job.") WHERE task.Pro_ID=".$Pro_ID_Reporte." AND task.Floor_ID=".$Floor_ID." AND task.Area_ID=".$Area_ID;
			//echo $strSQL."<br>";
			$res1=$bd->ejecutar($strSQL);
			
			$sql3 = "SELECT SUM(Horas_Estimadas) AS Hest, SUM(Aux2) AS Por_Enjob FROM task WHERE task.Pro_ID=".$Pro_ID_Reporte." AND task.Floor_ID=".$Floor_ID." AND task.Area_ID=".$Area_ID;
//echo $sql3."<br>";
			$result_3=$bd->ejecutar($sql3);	
			$row3=mysqli_fetch_array($result_3);
			$Hest=$row3["Hest"];
			$Por_Enjob=$row3["Por_Enjob"];
			
			$sql3 = "SELECT SUM(Material_Estimado) AS Mest FROM task WHERE task.Pro_ID=".$Pro_ID_Reporte." AND task.Floor_ID=".$Floor_ID." AND task.Area_ID=".$Area_ID;
//echo $sql3."<br>";
			$result_3=$bd->ejecutar($sql3);	
			$row3=mysqli_fetch_array($result_3);	
			$Mest=$row3["Mest"];
	
			
			$strSQL = "UPDATE area_control SET Horas_Estimadas='".$Hest. "',Material_Estimado='".$Mest."',Aux2='".$Por_Enjob."' WHERE area_control.Pro_ID=".$Pro_ID_Reporte." AND area_control.Floor_ID=".$Floor_ID." AND area_control.Area_ID=".$Area_ID;
	//echo $strSQL."<br>";				
			$res1=$bd->ejecutar($strSQL);
			$Thes_floor=($Thes_floor+$Hest);
			$Tmes_floor=($Tmes_floor+$Mest);
			$FUest+=$Uest;
			$FPor_Enjob+=$Por_Enjob;
		}
		$strSQL = "UPDATE floor SET Horas_Estimadas='".$Thes_floor."',Material_Estimado='".$Tmes_floor."',Aux1='".$FUest."',Aux2='".$FPor_Enjob."' WHERE floor.Pro_ID=".$Pro_ID_Reporte." AND floor.Floor_ID=".$Floor_ID;
 //echo $strSQL."<br>";
		$res1=$bd->ejecutar($strSQL);
	}
			
//////	// fin actualizacion % del job

		
	
		
		
		
		
		
//*********************************************/// Inicio de reporte con cortes de control	
	
	
	$Pro_ID=$row00["Pro_ID"];
	$Codigo=$row00["Codigo"];
	$Nombre=$row00["Nombre"];
	$Notas=$row00["Notes"];
	$job_Nombre=$row00["Nombre"];
	$JobHoras_Estimadas=$row00["Horas_Estimadas"];
	$JAux2=$row00["Aux2"];
	$Super_ID=$row00["Coordinador_Obra_ID"];
	$Horas=$row00["Horas"];
	$Co1=$row00["Adi1"];
	$Co2=$row00["Adi2"];
	$Co3=$row00["Adi3"];
	$Co4=$row00["Adi4"];
	$Co5=$row00["Adi5"];
	$Horas=$Horas+$Co1+$Co2+$Co3+$Co4+$Co5;
	$Hcontract=0;
	$HTM=0;
	$consulta = "select SUM(HContract) AS HContract, SUM(HTM) AS HTM FROM actividad_personal ap INNER JOIN actividades a ON ap.Actividad_ID=a.Actividad_ID ";
	$consulta = $consulta . " WHERE a.Pro_ID=".$Pro_ID." AND a.fecha between "."'".$af1."' AND '".$af2."'";	
	//echo $consulta;	
	$result33=$bd->ejecutar($consulta); 	
	while (($row33 = mysqli_fetch_array($result33) ))							
		{				
			$HContract = $row33["HContract"];
			$HTM = $row33["HTM"];
		}
 
 if ($Super_ID=="")
 	$Super_ID=1;
	$consulta="SELECT * from personal WHERE personal.Empleado_ID=".$Super_ID;
	//echo $consulta;
	$result33=$bd->ejecutar($consulta);
	while (($row33 = mysqli_fetch_array($result33) ))							
		{				
			$Super= $row33["Nombre"];
			$Super=($Super." ".$row33["Apellido_Paterno"]);
			$pdf->SetY($aux);
			$pdf->SetX(210);	
			$pdf->Multicell(120,5,"GC.: ".$Company." Contact: ".$Super,0,L,false);
		}
	
	//encabezado($pdf,$af1,$af2, $Tipo);	  
	//$pdf->SetX(10);	
	//$pdf->Multicell(150,5,"Job: ".$Codigo." ".$Nombre,0,L,false);
			$aux=$pdf->GetY();
			$pdf->SetY($aux);
			$pdf->SetX(20);	
			$pdf->Multicell(120,5,"R: ".$Notas,0,L,false);
	
	
	
	$JFATotal_Cantidad_Usada=0;
	$JFATotal_Units_Done=0;
	$JFATotal_Used_Horas=0;
	$JFAHoras_Estimadas=0;
	$JFAPor_wj=0;

	$sql1 = "SELECT * FROM floor WHERE floor.Pro_ID=".$Pro_ID_Reporte;
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
		//$pdf->SetX(13);	
		//$pdf->Multicell(170,5,$row1['Nombre'],0,L,false);
	
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
			//$pdf->SetX(15);				
			//$pdf->Multicell(200,5,$row2['Nombre'],0,L,false);
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
			//$pdf->SetX(18);	
			//if ($Tipo=="Detalle")				
				//$pdf->Multicell(200,5,$row3['Nombre'],0,L,false);
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
				$pdf->Multicell(25,5,$row4['Horas'],0,R,false);
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
				
				/*$aux7=$pdf->GetY();					  
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
					}*/
				
			}								

			/*$aux=$pdf->GetY();																	
			$pdf->SetX(18);					
			$pdf->Multicell(50,5,"Total ".$Task_Name,0,L,false);						
			$aux_99=$pdf->GetY();
				
			$pdf->SetY($aux);	
			$pdf->SetX(70);
			$pdf->Multicell(15,5,number_format($Units_Estimadas,2),0,R,false);
			$pdf->SetY($aux);		
			$pdf->SetX(85);				
			$pdf->Multicell(15,5,number_format($Total_Units_Done,2),0,R,false);
			$pdf->SetY($aux);
						$pdf->SetX(90);
						$pdf->Multicell(25,5,number_format($Horas_Estimadas,2),0,R,false);
						$pdf->SetY($aux);
						$pdf->SetX(115);	
						$pdf->Multicell(25,5,number_format($Total_Used_Horas,2),0,R,false);
						$pdf->SetY($aux);
						$pdf->SetX(140);*/
						$Total_Horas_Left=$Horas_Estimadas-$Total_Used_Horas;
						//$pdf->Multicell(20,5,number_format($Total_Horas_Left,2),0,R,false);
						//$pdf->SetY($aux);
						//$pdf->SetX(160);
						
						
						if ($Horas_Estimadas>5)
						{
						$Total_Percent_Used_Horas=($Total_Used_Horas/$Horas_Estimadas)*100;
						}
						else
							{
							  $Total_Percent_Used_Horas=0;
							}
							
							
						if ($Units_Estimadas>0)
						{
						$Total_Percent_Ejecutado=$Total_Units_Done/$Units_Estimadas*100;
						}
						else
						{
						$Total_Percent_Ejecutado=0;
						}		
						
					
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
						/*$pdf->Multicell(20,5,$Text,0,L,false);
						$pdf->SetY($aux);
						$pdf->SetX(180);	
						$pdf->Multicell(20,5,number_format($Material_Estimado,2),0,R,false);						
						$pdf->SetY($aux);
						$pdf->SetX(200);	
						$pdf->Multicell(20,5,number_format($Total_Cantidad_Usada,2),0,R,false);
						$pdf->SetY($aux);
						$pdf->SetX(220);*/
						$total_Material_Left=$Material_Estimado-$Total_Cantidad_Usada;
						//$pdf->Multicell(20,5,number_format($total_Material_Left,2),0,R,false);
						//$pdf->SetY($aux);
						//$pdf->SetX(240);
						if ($Material_Estimado>0)
						{
							$Total_Percent_Material_Used=$Total_Cantidad_Usada/$Material_Estimado*100;
						}
						else
						{
							$Total_Percent_Material_Used=0;
						}
						
						$Text='    '.number_format($Total_Percent_Material_Used,2)."%";
						/*$pdf->Multicell(20,5,$Text,0,L,false);
						$pdf->SetY($aux);
						$pdf->SetX(260);
						$pdf->Multicell(20,5,'',0,L,false);
						//$pdf->Multicell(20,5,$TAux2,0,L,false);
						$pdf->SetY($aux);
						$pdf->SetX(280);
						
						$Text='    '.number_format($Total_Percent_Ejecutado,2).$textp;
						$pdf->Multicell(20,5,$Text,0,L,false);
			$pdf->SetY($aux);
			$pdf->SetX(300);*/
			$Total_Percent_Pendiente=100-$Total_Percent_Ejecutado;
			
			$Text='    '.number_format($Total_Percent_Pendiente,2)."%";
			//$pdf->Multicell(20,5,$Text,0,L,false);
			
			
			//$pdf->SetY($aux);
			//$pdf->SetX(325);
			
			$TPor_wj=($Total_Percent_Ejecutado*$Por_wj);
			$Text='    '.number_format($TPor_wj,2)."%";
			//$pdf->Multicell(20,5,$Text,0,L,false);
			//$pdf->Multicell(20,5,'',0,L,false);
			
			
			
			//$pdf->Multicell(20,5,number_format($Total_Percent_Pendiente,2),0,R,false);
					
			//$aux7=$aux_99+5;
			//$aux7=$pdf->GetY();
			/*$pdf->line(10,$pdf->GetY()-5,350,$pdf->GetY()-5);
			$pdf->line(10,$aux+5,350,$aux+5);*/
					
			//$bb=$aux_99-$aux;
			//$pdf->line(10,$pdf->GetY()-5,350,$pdf->GetY()-5);
			//$pdf->line(10,$aux+$bb,350,$aux+$bb);
						
			/*$pdf->SetY($aux7);												
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
					}	*/		
			$ATotal_Cantidad_Usada+=$Total_Cantidad_Usada;
			$ATotal_Units_Done+=$Total_Units_Done;
			$ATotal_Used_Horas+=$Total_Used_Horas;
			$ATotal_Units_Estimadas+=$Units_Estimadas;
			$AHoras_Estimadas+=$Horas_Estimadas;
			//$ATotal_Per_wholejob+=($Total_Percent_Ejecutado);
			$Contador++;
			$APor_wj+=$TPor_wj;
			}
////////////////INICIO IMPRESION DE TOTAL AREA/
			/*$aux=$pdf->GetY();																	
			$pdf->SetX(15);					
			$pdf->Multicell(50,5,"Total ".$Area_Name,0,L,false);						
			$aux_99=$pdf->GetY();
				
			$pdf->SetY($aux);	
			$pdf->SetX(70);
			*/
			if ($Contador==0)
			{
			$Contador=1;
			}
			$ATotal_Units_Estimadas=$ATotal_Units_Estimadas/$Contador;
			//$pdf->Multicell(15,5,number_format($ATotal_Units_Estimadas,2),0,R,false);
			//$pdf->SetY($aux);		
			//$pdf->SetX(85);			
			$ATotal_Units_Done=$ATotal_Units_Done/$Contador;	
			//$pdf->Multicell(15,5,number_format($ATotal_Units_Done,2),0,R,false);
			/*$pdf->SetY($aux);
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
						$pdf->SetX(160);*/
						if ($AHoras_Estimadas>0)
						{
						$Total_Percent_Used_Horas=($ATotal_Used_Horas/$AHoras_Estimadas)*100;
						}
						else
							{
							  $Total_Percent_Used_Horas=0;
							}
						If ($AAux2==0)
							$AAux2=1;
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
						//$pdf->Multicell(20,5,$Text,0,L,false);
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
						/*$pdf->SetY($aux);
						$pdf->SetX(260);
						$pdf->Multicell(20,5,'',0,L,false);
						//$pdf->Multicell(20,5,$AAux2,0,L,false);
						//$pdf->Multicell(20,5,number_format($total_Percent_Estimado,2),0,R,false);
						$pdf->SetY($aux);
						$pdf->SetX(280);*/
						if ($AAux2>0)
						{
						
						$Total_Percent_Ejecutado=$APor_wj/$AAux2;
						}
						else
						{
						$Total_Percent_Ejecutado=0;
						}		
						$Text='    '.number_format($Total_Percent_Ejecutado,2).$textp; 
						/*$pdf->Multicell(20,5,$Text,0,L,false);
			$pdf->SetY($aux);
			$pdf->SetX(300);*/
			$Total_Percent_Pendiente=100-$Total_Percent_Ejecutado;
			
			$Text='    '.number_format($Total_Percent_Pendiente,2)."%";
			//$pdf->Multicell(20,5,$Text,0,L,false);
			//$pdf->Multicell(20,5,number_format($Total_Percent_Pendiente,2),0,R,false);
					
			//$aux7=$aux_99+5;
			//$aux7=$pdf->GetY();
			/*$pdf->line(10,$pdf->GetY()-5,350,$pdf->GetY()-5);
			$pdf->line(10,$aux+5,350,$aux+5);
					
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
					}			*/
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
			//$aux=$pdf->GetY()+5;
			//$pdf->SetY($aux);																
			//$pdf->SetX(20);					
			//$pdf->Multicell(70,5,"Total ".$Floor_Name,0,L,false);						
			//$aux_99=$pdf->GetY();
				
			//$pdf->SetY($aux);	
			//$pdf->SetX(70);
			
			//$pdf->Multicell(15,5,number_format($FATotal_Units_Estimadas,2),0,R,false);
			//$pdf->SetY($aux);		
			//$pdf->SetX(85);				
			//$pdf->Multicell(15,5,number_format($FATotal_Units_Done,2),0,R,false);
			/*$pdf->SetY($aux);
						$pdf->SetX(90);
						$pdf->Multicell(25,5,number_format($FAHoras_Estimadas,2),0,R,false);
						$pdf->SetY($aux);
						$pdf->SetX(115);	
						$pdf->Multicell(25,5,number_format($FATotal_Used_Horas,2),0,R,false);
						$pdf->SetY($aux);
						$pdf->SetX(145);
						$Total_Horas_Left=$FAHoras_Estimadas-$FATotal_Used_Horas;
						$pdf->Multicell(20,5,number_format($Total_Horas_Left,2),0,R,false);
						$pdf->SetY($aux);
						$pdf->SetX(177);*/
						if ($FAHoras_Estimadas>5)
						{
						$Total_Percent_Used_Horas=($FATotal_Used_Horas/$FAHoras_Estimadas)*100;
						}
						else
							{
							  $Total_Percent_Used_Horas=0;
							}
						If ($FAux2==0)
							$FAux2=1;	
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
						//$pdf->Multicell(20,5,$Text,0,L,false);
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
						$pdf->Multicell(20,5,$Text,0,L,false);
						$pdf->SetY($aux);
						$pdf->SetX(260);
						$pdf->Multicell(20,5,'',0,L,false);*/
						//$pdf->Multicell(20,5,$FAux2,0,L,false);
						//$pdf->Multicell(20,5,number_format($total_Percent_Estimado,2),0,R,false);
	//					$pdf->SetY($aux);
	//					$pdf->SetX(200);
						if ($FAux2>0)
						{
						
						$Total_Percent_Ejecutado=$FAPor_wj/$FAux2;
						}
						else
						{
						$Total_Percent_Ejecutado=0;
						}
						$Text='    '.number_format($Total_Percent_Ejecutado,2).$textp;
		//				$pdf->Multicell(20,5,$Text,0,L,false);
	//		$pdf->SetY($aux);
	//		$pdf->SetX(223);
			$Total_Percent_Pendiente=100-$Total_Percent_Ejecutado;
			
			$Text='    '.number_format($Total_Percent_Pendiente,2)."%";
	//		$pdf->Multicell(20,5,$Text,0,L,false);
					
	//		$aux7=$aux_99+5;
	//		$aux7=$pdf->GetY();
			/*$pdf->line(10,$pdf->GetY()-5,350,$pdf->GetY()-5);
			$pdf->line(10,$aux+5,350,$aux+5);*/
					
	//		$bb=$aux_99-$aux;
		//	$pdf->line(10,$pdf->GetY()-5,290,$pdf->GetY()-5);
	//		$pdf->line(10,$aux+$bb,290,$aux+$bb);
					
			//$pdf->SetY($aux7);												
		//	$aux7=$pdf->GetY();							
			/*		if($aux7>=180)
					{
							$pdf->AddPage();
							membrete($pdf);
							encabezado($pdf,$af1,$af2, $Tipo);				
							$aux=$pdf->GetY()+2;
					}
					else
					{			  
							 // $pdf->SetY($aux7);
							  //$aux=$pdf->GetY();
							  $aux=$aux7;
					}*/			
			$JFATotal_Cantidad_Usada+=$Total_Cantidad_Usada;
			$JFATotal_Units_Done+=$FATotal_Units_Done;
			$JFATotal_Used_Horas+=$FATotal_Used_Horas;
			$JFAHoras_Estimadas+=$FAHoras_Estimadas;
			$JFATotal_Units_Estimadas+=$FATotal_Units_Estimadas;
			//$JFATotal_Per_wholejob+=($Total_Percent_Ejecutado/100)*($FAHoras_Estimadas/$JobHoras_Estimadas);
			$JFAPor_wj+=$FAPor_wj;
		

////// Fin impresion FLOOR 		
	}
	
	
/// Inicio horas no definidas en areas

			/*$aux=$pdf->GetY()+3;	
			$pdf->SetY($aux);																
			$pdf->SetX(10);					
			$pdf->Multicell(50,5,"General Areas: ".$Job_Name,0,L,false);						
			$aux_99=$pdf->GetY();
				
						$pdf->SetY($aux);
						$pdf->SetX(115);*/	
						
						$G_Used_Horas=$HContract-$JFATotal_Used_Horas;
						
						
	/*					$pdf->Multicell(25,5,number_format($G_Used_Horas,2),0,R,false);

			$pdf->SetY($aux);
			$pdf->SetX(249);	
			$pdf->Multicell(20,5,number_format($HTM,2),0,R,false);
					
			$aux7=$aux_99+5;
			$aux7=$pdf->GetY();
			$pdf->line(10,$pdf->GetY()-5,350,$pdf->GetY()-5);
			$pdf->line(10,$aux+5,290,$aux+5);
			
		
			$aux=$pdf->GetY();																
			$pdf->SetY($aux);	
			$pdf->line(10,$pdf->GetY(),290,$pdf->GetY());
			$pdf->line(10,$aux+1,290,$aux+1);*/
			
		
								
			//$pdf->SetY($aux7);												
		/*	$aux7=$pdf->GetY();							
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
					}	*/		

//// fin horas no definidas
	
	
//// Inicio impresion JOB

			$aux=$pdf->GetY()+3;	
			$pdf->SetY($aux);																
			$pdf->SetX(10);					
			$pdf->Multicell(50,5,"Total Job: ".$Job_Name,0,L,false);						
			$aux_99=$pdf->GetY();
				
			$pdf->SetY($aux);	
			$pdf->SetX(70);
			
			//$pdf->Multicell(15,5,number_format($JFATotal_Units_Estimadas,2),0,R,false);
			$pdf->SetY($aux);		
			$pdf->SetX(85);				
			//$pdf->Multicell(15,5,number_format($JFATotal_Units_Done,2),0,R,false);
			if ($JFAHoras_Estimadas==0) 
				$JFAHoras_Estimadas=$Horas;
			if	($JFAHoras_Estimadas<$Horas)
				$JFAHoras_Estimadas=$Horas;
				
			if ($JFATotal_Used_Horas==0) 
				$JFATotal_Used_Horas=$HContract;
			if ($JFATotal_Used_Horas<$HContract )
				$JFATotal_Used_Horas=$HContract;

			
			$pdf->SetY($aux);
						$pdf->SetX(90);
						$pdf->Multicell(25,5,number_format($JFAHoras_Estimadas,2),0,R,false);
						$pdf->SetY($aux);
						$pdf->SetX(115);	
						$pdf->Multicell(25,5,number_format($JFATotal_Used_Horas,2),0,R,false);
						$pdf->SetY($aux);
						$pdf->SetX(145);
						$Total_Horas_Left=$JFAHoras_Estimadas-$JFATotal_Used_Horas;
						$pdf->Multicell(20,5,number_format($Total_Horas_Left,2),0,R,false);
						$pdf->SetY($aux);
						$pdf->SetX(177);
						if ($JFAHoras_Estimadas>0)
						{
						$Total_Percent_Used_Horas=($JFATotal_Used_Horas/$JFAHoras_Estimadas)*100;
						}
						else
							{
							  $Total_Percent_Used_Horas=0;
							}
						$Total_Percent_Ejecutado=$JFAPor_wj/100;
						if ($Total_Percent_Used_Horas>$Total_Percent_Ejecutado and $Total_Percent_Ejecutado<>0)
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
						$pdf->Multicell(20,5,$Text,0,L,false);
						$pdf->SetY($aux);
						$pdf->SetX(200);
						$pdf->Multicell(20,5,$JAux2,0,L,false);*/
						//$pdf->Multicell(20,5,number_format($total_Percent_Estimado,2),0,R,false);
						$pdf->SetY($aux);
						$pdf->SetX(200);
						
						$Total_Percent_Ejecutado=$JFAPor_wj/100;
						
						$Text='    '.number_format($Total_Percent_Ejecutado,2).$textp;
						if ($Total_Percent_Ejecutado==0)
							$Text="       --";
						$pdf->Multicell(20,5,$Text,0,L,false);
			$pdf->SetY($aux);
			$pdf->SetX(223);
			$Total_Percent_Pendiente=100-$Total_Percent_Ejecutado;
			
			$Text='    '.number_format($Total_Percent_Pendiente,2)."%";
			if ($Total_Percent_Ejecutado==0)
							$Text="       --";
			$pdf->Multicell(20,5,$Text,0,L,false);
			//$pdf->Multicell(20,5,number_format($Total_Percent_Pendiente,2),0,R,false);
			$pdf->SetY($aux);
			$pdf->SetX(249);	
			$pdf->Multicell(20,5,number_format($HTM,2),0,R,false);
					
			$aux7=$aux_99+5;
			$aux7=$pdf->GetY();
			//$pdf->line(10,$pdf->GetY()-5,350,$pdf->GetY()-5);
			$pdf->line(10,$aux+5,290,$aux+5);
			
		
			$aux=$pdf->GetY();																
			$pdf->SetY($aux);	
			$pdf->line(10,$pdf->GetY(),290,$pdf->GetY());
			$pdf->line(10,$aux+1,290,$aux+1);
			
		
								
			//$pdf->SetY($aux7);												
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

// fin ciclo jobs 

	$pdf->Output("dato.pdf");
	
?>
	<embed src="dato.pdf#toolbar=1&navpanes=0&scrollbar=1" width="990" height="670"></embed>
<?
	require('Library/Close_Conexion.php');	
?>







