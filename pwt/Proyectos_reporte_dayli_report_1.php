<?php

	session_name("Administrador");

	session_start();
//// change in>=180    from 240   to 180  to print Landscape also change $pdf=new FPDF('L','mm','Letter'); 
	//*******************************************************************

	//Datos enviados por proyecto_reporte_material_0.php

	//******************************************************************


	$vfrom_date=$_REQUEST["vfrom_date"];

	$vto_date=$_REQUEST["vto_date"];	

	$vdia=substr($vfrom_date,3,2);
	$vmes=substr($vfrom_date,0,2);
	$vano=substr($vfrom_date,8,2);
	$af1="20".$vano."-".$vmes."-".$vdia;	

	$vdia=substr($vto_date,3,2);
	$vmes=substr($vto_date,0,2);
	$vano=substr($vto_date,8,2);
	$af2="20".$vano."-".$vmes."-".$vdia;

	$Pro_ID_Reporte=$_REQUEST["Pro_ID_Reporte"];
	$pag=0;	
	$Tipo=$_REQUEST["Tipo"];
	$PmName=$_REQUEST["PmName"];
	//echo $Tipo.":tipo request"."<br>"."PM:".$PmName;
	//$Nombre_Material=$_REQUEST["Nombre_Material"];		



	require('Library/Control_Cache.php');	
	require('Library/Open_Conexion.php');
	require('Library/funciones.php');	

	// INSERTADO POR FABIOLA CARRASCO

	require('pdf/fpdf.php');
	$pdf=new FPDF('P','mm','Letter');

//	$pdf=new FPDF('L','mm','Legal');

	$pdf->AddPage();
	



	// DEFINICION DE FUNCIONES DE CABEZERA DE SUBCUERPO

	$pdf->SetMargins(15,20,15,15);

	$pdf->SetFont('Arial','',10);

	$pdf->SetLineWidth(0.3); 

	$pdf->Setfillcolor(237,243,120);	



	function membrete(&$pdf)

	{

		//ENCABEZADO

		$pdf->SetFont('Arial','',8);

		$pdf->Image('images/logo.png',5,5,30,10,"png");		

	}	





function encabezado(&$pdf,$f1,$f2, $Tipo,$Nombre,$Notes)

	{
		
		global $pag;
		$pag+=1;
		$f1=FormatDateTime($f1, 8);
		$f2=FormatDateTime($f2, 8);
		$pdf->Multicell(0,5,"",0,L,false);
		$pdf->Multicell(0,5,$pag,0,R,false);
		if ($Tipo=="Detalle")
			//$pdf->Multicell(0,5,"Detail: Hours Worked and Material Used",0,C,false);
			$pdf->Multicell(0,5,"Detail: Hours Worked by day",0,C,false);
		else
		  if ($Tipo=="Strur")
		  {

		  	$pdf->SetFont('Arial','',11);
			$pdf->Multicell(0,5,"Structure of control",0,C,false);
			$aux=($pdf->GetY()+3);
			$pdf->SetY($aux);
		   }

		    else

//			$pdf->Multicell(0,5,"TOTALS of Hours Worked by Area or Task and Material Used",0,C,false);
			$title="          TOTALS  of  Hours  Worked  by  Area  or  -Task  at:>> ".$Nombre;
			$pdf->Multicell(0,5,$title,0,C,false);
		if ($Tipo=="Strur")
		{
		$aux=$pdf->GetY();
		$pdf->SetX(20);
		$pdf->Multicell(80,5,"      Cost Code       Task       .",0,L,false);
		$pdf->SetY($aux);
		$pdf->SetX(100);
//		$pdf->Multicell(50,5,"#units estimated",0,L,false);
		//$pdf->Multicell(50,5,"% Reported before",0,L,false);
		$pdf->SetY($aux);
		$pdf->SetX(150);
//		$pdf->Multicell(50,5,"#units done",0,L,false);
		$pdf->Multicell(85,5,"% Report and Date_________ ",0,L,false);
		$aux7=$pdf->GetY()+4;
		$pdf->line(10,$pdf->GetY()-5,210,$pdf->GetY()-4);
		$pdf->line(10,$aux+5,210,$aux+5);
		$pdf->SetY($aux7);

		}

		else

		{

		// titulo del detall	

		

		$pdf->Multicell(0,5,"from: ".$f1."   to: ".$f2,0,C,false);
		$pdf->Multicell(0,5,"",0,L,false);
		$aux=($pdf->GetY()+2);
		$pdf->SetY($aux);
		$pdf->Multicell(0,5," Notes:",0,L,false);
		$pdf->SetY($aux);
		$pdf->SetX(25);
		$pdf->Multicell(0,5,$Notes,0,L,false);
		$aux=$pdf->GetY();
		$pdf->SetX(20);
		$pdf->Multicell(20,5,"       .",0,L,false);
		$pdf->SetY($aux);
		$pdf->SetX(70);
		//$pdf->Multicell(15,5,"#units estimated",0,L,false);
		$pdf->SetY($aux);
		$pdf->SetX(90);
		//$pdf->Multicell(15,5,"#units done",0,L,false);
		$pdf->SetY($aux);
		$pdf->SetX(100);
		if ($Tipo<>"Stru")
				$pdf->Multicell(25,5,"Hours Est.",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(115);
		//if ($Tipo<>"Stru")
			$pdf->Multicell(25,5,"Hrs.Used",0,R,false);
		$pdf->SetY($aux);
		$pdf->SetX(140);
		if ($Tipo<>"Stru")
			$pdf->Multicell(20,5,"Hrs.left",0,R,false);
		$pdf->SetY($aux);
		$pdf->SetX(160);
		if ($Tipo<>"Stru")
			$pdf->Multicell(18,5,"%hrs.used |",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(178);
		$pdf->Multicell(14,5,"%Done",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(195);
		$pdf->Multicell(20,5,"%Date Rec.",0,C,false);
		//$pdf->Multicell(20,5,"% Pending",0,C,false);
		$pdf->SetX(180);
		//$pdf->Multicell(20,5,"Material Est.",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(200);
		//$pdf->Multicell(20,5,"Material Used",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(220);
		//$pdf->Multicell(20,5,"Material left",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(240);
		//$pdf->Multicell(20,5,"%Mat.Used  |",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(260);
		$pdf->Multicell(20,5,"",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetY($aux);
		$pdf->SetX(320);
		$pdf->Multicell(20,5,"_             _",0,C,false);
		//$pdf->Multicell(20,5,"Hrs.T and M",0,C,false);
		$aux7=$pdf->GetY()+1;
		$pdf->line(10,$pdf->GetY()-5,350,$pdf->GetY()-5);
		$pdf->line(10,$aux+5,350,$aux+5);
		$pdf->SetY($aux7);
		}
	}	

// fin encabezado


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

////nnnnnnnnnnnnnnnn

$strSQL = "update task t1 INNER JOIN (select p.Pro_ID,p.Estatus_ID,t.Task_ID as TID,t.Horas_Estimadas,sum(rda.Horas_Contract) as horas from task t inner join registro_diario_actividad rda on rda.Task_ID=t.Task_ID inner join proyectos p on p.Pro_ID=t.Pro_ID where p.Estatus_ID=1 and t.nombre like '%Ticket Work%' group by concat(t.Pro_ID,t.Task_ID)) h1 on t1.Task_ID=h1.TID set t1.Horas_Estimadas=h1.horas";
//echo $strSQL."<br>";
//$res1=$bd->ejecutar($strSQL);
$strSQL="";
		

if 	($Tipo=="Area")
	{
			$Tipo="Totales";
		 	$TipoAux="SArea";
	}
$sql55 = "SELECT p.Pro_ID, p.Estatus_ID,p.Codigo, p.Nombre,p.Notes,pe.Empleado_ID,pe.Nombre as EmpNom,pe.Nick_Name,p.Manager_ID FROM proyectos p inner join personal pe on p.Manager_ID=pe.Empleado_ID";	
 if ($Pro_ID_Reporte==undefined)
 	{
	if ($Tipo=="Current")
	   {
	 	$TipoAux="SArea";
		$sql55 = $sql55 . " WHERE  p.Estatus_ID=1 ";
		$Tipo="Totales";
	   }
	if 	($Tipo=="Coming")
		{
	 	$sql55 = $sql55 . " WHERE  p.Estatus_ID=2 ";
		$Tipo="Totales";
		}
	}
  else
    {
		
  		$sql55 = $sql55 . " WHERE  p.Pro_ID=$Pro_ID_Reporte ";
	}
 
    if ($PmName<>"")
		$sql55 = $sql55 . " AND pe.Nick_Name like \"%".$PmName."%\""; 
		$sql55 = $sql55." ORDER BY p.Project_Manager_ID,p.Fecha_Inicio ";
//echo $sql55."  :sql"."<br>";
//echo $Tipo." Tipo"."<br>";
//exit ();	
	$result_55=$bd->ejecutar($sql55);

while($row55=mysqli_fetch_array($result_55))
{	

	$Pro_ID_Reporte=$row55["Pro_ID"];
	$Nombre=$row55["Nombre"]."  PM:".$row55["EmpNom"];
	$Notes=$row55["Notes"];
	$pdf->SetX(10);	

//echo $Pro_ID_Reporte.":Pro_Id in the loop"."<br>";
//echo $Tipo.":Tipo"."<br>";
	if ($pag>0)
	{
		$pdf->AddPage();
	}
	$pag=0;
	


////nnnnnnnnnnnnnn/


	

	// titulo del reporte

membrete($pdf,$vfrom_date);	

	

if ($Tipo=="Strur")

{

///// Inicio estructure 

  	
	//$Nombre=$Nombre."a15";
	encabezado($pdf,$af1,$af2, $Tipo,$Nombre,$Notes);
	$aux=51;		
	$aux7=51;
		
	$sql = "SELECT p.Pro_ID, p.Estatus_ID,p.Codigo, p.Nombre,p.Notes,p.Horas_Estimadas FROM proyectos p ";	
 	$sql = $sql . " WHERE  p.Pro_ID=$Pro_ID_Reporte ";
	//echo $sql;

	$result_0=$bd->ejecutar($sql);

 while($row0=mysqli_fetch_array($result_0))

	{	

	$Pro_ID=$row0["Pro_ID"];
	$Codigo=$row0["Codigo"];
	$Nombre=$row0["Nombre"];
	$Notes=$row0["Notes"];
	$job_Nombre=$row0["Nombre"];	  
	$pdf->SetX(10);	
	$pdf->Multicell(150,5,"Job::".$Codigo." ".$Nombre,0,L,false);
	$Job_Name1=$Codigo." ".$Nombre;
	$aux7=$pdf->GetY()+5;
	$pdf->SetY($aux7);

	//$pdf->line(10,$pdf->GetY()-15,250,$pdf->GetY()-15);

	//$pdf->line(10,$aux7+1,250,$aux7+1);																		

					if($aux7>=240)
					{
							$pdf->AddPage();
							membrete($pdf);
							//$Nombre=$Nombre."a2";
							encabezado($pdf,$af1,$af2, $Tipo,$Nombre,$Notes);				
							$aux=51;		
							$aux7=51;

							$aux=$pdf->GetY()+2;
					}
					else
					{			  
							  //$pdf->SetY($aux7);
							  //$aux=$pdf->GetY();
							  $aux=$aux7+12;
					}			

	$sql1 = "SELECT * FROM floor WHERE floor.Pro_ID=".$Pro_ID_Reporte." and nombre not like '%do not%' ORDER BY Nombre,Flo_IDT";
    //echo $sql1."<br>";
	$result_1=$bd->ejecutar($sql1);	
    while($row1=mysqli_fetch_array($result_1))
	{
		 $pdf->Ln(); 
		$Floor_Name=$row1['Nombre'];
		$Floor_ID=$row1["Floor_ID"];
		$pdf->SetX(13);	
		$pdf->Multicell(170,5,$row1['Nombre'],0,L,false);
		$bb=$aux_99-$aux;
	//$pdf->line(10,$pdf->GetY()-15,250,$pdf->GetY()-15);
	//$pdf->line(10,$aux+$bb,250,$aux+$bb);												
	$aux7=$pdf->GetY();							
					if($aux7>=240)
					{
							$pdf->AddPage();
							membrete($pdf);
							//$Nombre=$Nombre."a3";
							encabezado($pdf,$af1,$af2, $Tipo,$Nombre,$Notes);				
							$aux=51;		
 							$aux7=51;
							$aux=$pdf->GetY()+2;

					}

					else

					{			  

							  //$pdf->SetY($aux7);

							  //$aux=$pdf->GetY();

							  $aux=$aux7+12;

					}			

									

	

		$sql2 = "SELECT * FROM area_control WHERE area_control.Pro_ID=".$Pro_ID_Reporte." AND area_control.Floor_ID=".$Floor_ID." and nombre not like '%do not%' ORDER BY Nombre,Are_IDT";

		//echo $sql2."<br>";
		$result_2=$bd->ejecutar($sql2);	

		while($row2=mysqli_fetch_array($result_2))

		{

			$pdf->Ln(); 
			$Area_ID=$row2["Area_ID"];
			$pdf->SetX(15);				
			$pdf->Multicell(200,5,$row2['Nombre'],0,L,false);
			$Area_Name=$row2['Nombre'];
			$bb=$aux_99-$aux;
			$pdf->line(15,$pdf->GetY(),210,$pdf->GetY());
			//$pdf->line(10,$aux+$bb,250,$aux+$bb);												
			$aux7=$pdf->GetY();							
					if($aux7>=240)
					{
							$pdf->AddPage();
							membrete($pdf);
							//							$Nombre=$Nombre."a4";
							encabezado($pdf,$af1,$af2, $Tipo,$Nombre,$Notes);				
							$aux=51;		
							$aux7=51;

							$aux=$pdf->GetY()+2;
					}
					else
					{			  
							  //$pdf->SetY($aux7);
							  //$aux=$pdf->GetY();
							  $aux=$aux7+12;
					}			

			$sql3 = "SELECT * FROM task WHERE task.Pro_ID=".$Pro_ID_Reporte." AND task.Floor_ID=".$Floor_ID." AND task.Area_ID=".$Area_ID." and nombre not like '%do not%' ORDER BY Nombre,Tas_IDT";


			//echo $sql3."<br>";
			//exit();

			$result_3=$bd->ejecutar($sql3);	

			while($row3=mysqli_fetch_array($result_3))

			{
			$Task_ID=$row3["Task_ID"];
			$PorcentajeRec=$row3["PorcentajeRec"];
			$Last_Per_Recorded=$row3["Last_Per_Recorded"];
			$DateRec=date("m-d-Y",strtotime($row3["Last_Date_Per_Recorded"]));
			$Aniox=Substr($DateRec,6,4);
			//echo $Aniox." ";
			if ($Aniox<"2010")
				$DateRec="//";
			$aux7=$pdf->GetY();
			$pdf->SetY($aux7);
			$pdf->SetX(25);
			
			//$NumAct=$row3['NumAct'];
			$Nombre=$row3['NumAct']."  ".$row3['Nombre'];				
			//$Nombre=$row3['Tas_IDT']." ".$row3['Nombre'];
			$Tas_IDT=substr($row3['Tas_IDT'],0,2);
			//if ($Tas_IDT>75)
				//$Last_Per_Recorded=" N/A ";
			$Nombre=substr($Nombre,0,80); 
			$Task_Name=$row3['Nombre'];
			$pdf->Multicell(120,5,$Nombre,0,L,false);
			$pdf->SetY($aux7);
			$pdf->SetX(150);	
			$pdf->Multicell(50,5,$Last_Per_Recorded."% On:".$DateRec,0,L,false);
			$bb=$aux_99-$aux;
			//$pdf->line(25,$pdf->GetY(),250,$pdf->GetY());
			//$pdf->line(10,$aux+$bb,250,$aux+$bb);												
			$aux7=$pdf->GetY();							
					if($aux7>=240)
					{
							$pdf->AddPage();
							membrete($pdf);
							//							$Nombre=$Nombre."a5";
							encabezado($pdf,$af1,$af2, $Tipo,$Nombre,$Notes);				
							$aux=51;		
							$aux7=51;

							$aux=$pdf->GetY()+2;
					}
					else
					{			  
							  //$pdf->SetY($aux7);
							  //$aux=$pdf->GetY();
							  $aux=$aux7+12;
					}			
			}
	}
}
}

}

//////************ fin de function estructure 



else

{



// Inicio de actualizar % del job



$sql = "SELECT  SUM(Horas_Estimadas) AS Hest FROM task";
$sql = $sql . "  WHERE task.Pro_ID=".$Pro_ID_Reporte;	
		

				//echo $sql."<br>";
			//	exit ();

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

	//echo "/888  ". $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	
	
	

	//exit ();	

	$sql1 = "SELECT * FROM floor WHERE floor.Pro_ID=".$Pro_ID_Reporte." ORDER BY Nombre";

    //echo " 999 ".$sql1."<br>";

	$result_0=$bd->ejecutar($sql1);	
//exit ();
    while($row0=mysqli_fetch_array($result_0))

	{
		$Pro_ID=$row0["Pro_ID"];
		$Floor_ID=$row0["Floor_ID"];
		$Thes_floor=0;
		$Tmest_floor=0;
		$FUest=0;
		$FPor_Enjob=0;
		$sql2 = "SELECT * FROM area_control WHERE area_control.Pro_ID=".$Pro_ID_Reporte." AND area_control.Floor_ID=".$Floor_ID." ORDER BY Nombre";
//echo $sql2."<br>";
		$result_2=$bd->ejecutar($sql2);	
		while($row2=mysqli_fetch_array($result_2))
		{
			$Area_ID=$row2["Area_ID"];
			$Uest=$row2["Aux1"];
			$strSQL = "UPDATE task SET Aux2=(task.Horas_Estimadas*100/".$Thest_job.") WHERE task.Pro_ID=".$Pro_ID_Reporte." AND task.Floor_ID=".$Floor_ID." AND task.Area_ID=".$Area_ID;
	//		echo $strSQL."<br>";
			$res1=$bd->ejecutar($strSQL);
	
		$per100=100;
		$strSQL = "UPDATE task SET Last_Per_Recorded=".$per100." WHERE task.Pro_ID=".$Pro_ID_Reporte." AND (Nombre like '%ticket work%' or Last_Per_Recorded>100)";
		// AND (Last_Per_Recorded>100 or Last_Per_Recorded<50)";
		//echo $strSQL."<br>";
		$res1=$bd->ejecutar($strSQL);


		

		
		$strSQL="UPDATE task as t1 left join (SELECT t.nombre as tnombre,t.Task_ID as tid, sum(rd.Horas_Contract) as hused, t.Horas_Estimadas as hest FROM task t left join registro_diario_actividad rd on rd.Task_ID=t.task_id where t.Pro_ID=".$Pro_ID_Reporte." and t.nombre like '%allowance%') as h on h.tid=t1.Task_ID SET t1.Last_Per_Recorded=if ((h.hused/h.hest*100)>100,100,(h.hused/h.hest*100)) WHERE t1.Pro_ID=".$Pro_ID_Reporte." AND t1.Nombre like '%Allowance%'";		
		//echo $strSQL."<br>";
		//exit();
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
//			exit ();
			$Thes_floor+=$Hest;
			$Tmes_floor+=$Mest;
			$FUest+=$Uest;
			$FPor_Enjob+=$Por_Enjob;

		}

		$strSQL = "UPDATE floor SET Horas_Estimadas='".$Thes_floor."',Material_Estimado='".$Tmes_floor."',Aux1='".$FUest."',Aux2='".$FPor_Enjob."' WHERE floor.Pro_ID=".$Pro_ID_Reporte." AND floor.Floor_ID=".$Floor_ID;

 //echo $strSQL."<br>";

		$res1=$bd->ejecutar($strSQL);

	}

			

//////	// fin actualizacion % del job


//8888888888888
///// Inicio de reporte con cortes de control	
//**********************************************888888

	

	$sql = "SELECT p.Pro_ID, p.Estatus_ID,p.Codigo, p.Nombre,p.Horas_Estimadas FROM proyectos p ";	
	$sql = $sql . " WHERE  p.Pro_ID=$Pro_ID_Reporte ";
	$result_0=$bd->ejecutar($sql);
//exit ();
 while($row0=mysqli_fetch_array($result_0))

	{	

	$Pro_ID=$row0["Pro_ID"];

	$Codigo=$row0["Codigo"];

	$Nombre=$row0["Nombre"];

	$job_Nombre=$row0["Nombre"];

	$JobHoras_Estimadas=$row0["Horas_Estimadas"];
	$JAux2=$row0['Aux2'];
	//$Nombre=$Nombre."a16";
	encabezado($pdf,$af1,$af2, $Tipo,$Nombre,$Notes);	  
	$aux=51;		
	$aux7=51;
	$pdf->SetX(10);	
	$pdf->Multicell(150,5,"Job: ".$Codigo." ".$Nombre,0,L,false);
	$Job_Name1=$Codigo." ".$Nombre;
	$aux7=$pdf->GetY()+5;
	$pdf->SetY($aux7);
	$JFATotal_Cantidad_Usada=0;
	$JFATotal_Units_Done=0;
	$JFATotal_Used_Horas=0;
	$JFAHoras_Estimadas=0;
	$JFAPor_wj=0;
	$sql1 = "SELECT * FROM floor WHERE (floor.Horas_Estimadas>0 or floor.Horas_Estimadas<0) AND floor.Pro_ID=".$Pro_ID_Reporte;
	if ($Tipo=="Stru")
		$sql1 = $sql1." and floor.nombre not like '%do not%' ";
	$sql1=$sql1." ORDER BY Nombre";
//echo $sql1."<br>";
///8888888

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
		$pdf->SetX(10);	
		$pdf->Multicell(170,5,$row1['Nombre'],0,L,false);
		$aux7=$pdf->GetY()+2;
		$sql2 = "SELECT * FROM area_control WHERE (area_control.Horas_Estimadas>0 or area_control.Horas_Estimadas<0 )AND area_control.Pro_ID=".$Pro_ID_Reporte." AND area_control.Floor_ID=".$Floor_ID." ORDER BY nombre";
	//	echo $sql2."<br>";
		$result_2=$bd->ejecutar($sql2);	
//exit ();
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
			$Are_IDT=$row2["Are_IDT"];



			$pdf->SetX(15);		
			//$pdf->SetFont('Arial','IB',8);
		if ($TipoAux<>"SArea")			
				$pdf->Multicell(200,5,$Are_IDT.": ".$row2['Nombre'],0,L,R);
				
			//$pdf->SetFont('Arial','',8);


			$Area_Name=$row2['Nombre'];

			$sql3 = "SELECT * FROM task WHERE (task.Horas_Estimadas>1 or task.Horas_Estimadas<0 ) AND task.Pro_ID=".$Pro_ID_Reporte." AND task.Floor_ID=".$Floor_ID." AND task.Area_ID=".$Area_ID." ORDER BY Tas_IDT ";

			//echo $sql3."<br>";

			$result_3=$bd->ejecutar($sql3);	

			while($row3=mysqli_fetch_array($result_3))

			{

			$Units_Estimadas=$row3['Aux1'];
			$Tas_IDT=$row3['Tas_IDT'];
			$Material_Estimado=$row3['Material_Estimado'];
			$Horas_Estimadas=$row3['Horas_Estimadas'];
			$Total_Cantidad_Usada=0;
			$Total_Units_Done=0;
			$Total_Used_Horas=0;
			$Por_wj=$row3['Aux2'];
			$TAux2=$row3['Aux2'];
			$PorcentajeRec=$row3['Last_Per_Recorded'];
			$Last_Per_Recorded=$row3['Last_Per_Recorded'];
			$Last_Date_Per_Recorded=$row3['Last_Date_Per_Recorded'];
			$datex=$row3['Last_Date_Per_Recorded'];
			
			if ($datex=="")
				$Last_Date_Per_Recorded="-";
			else
			{
				$vdia=substr($datex,8,2);
				$vmes=substr($datex,5,2); 
				$vano=substr($datex,0,4);
				$Last_Date_Per_Recorded=$vmes."-".$vdia."-".$vano;   
			}
			
			
			$Total_MatUse=0;
			$NumAct=$row3['NumAct'];
			$Task_ID=$row3["Task_ID"];
			$pdf->SetX(18);	
			if ($Tipo=="Detalle")				
				$pdf->Multicell(200,5,$NumAct."> ".$row3['Nombre']." Task_ID:".$Task_ID,0,L,false);

			//$Task_Name=$NumAct."> ".$row3['Nombre'];
				$Task_Name=$row3['Nombre'];
			

//			$sql4 = "SELECT dr.Actividad_ID AS Actividad_ID,dr.Task_ID AS Task_ID, dr.Horas AS Horas, dr.Numero AS Numero,dr.MatUse AS Matusado,dr.Porcentaje AS PorRep, ac.Actividad_ID, ac.Fecha AS Fecha FROM dayli_report_task dr, actividades ac WHERE dr.Actividad_ID=ac.Actividad_ID AND dr.Task_ID=".$Task_ID;
		
	$sql4 = "SELECT rd.Reg_ID, rd.Actividad_ID,dr.Detalles,dr.Reg_ID, dr.Task_ID, dr.Horas_Contract AS Horas, ac.Actividad_ID, ac.Fecha AS Fecha FROM registro_diario_actividad dr, actividades ac, registro_diario rd WHERE rd.Actividad_ID=ac.Actividad_ID AND rd.Reg_ID=dr.Reg_ID AND dr.Task_ID=".$Task_ID;
			$sql4 = $sql4 ." AND ac.Fecha BETWEEN '".$af1."' AND '".$af2."'  ORDER BY ac.Fecha  ";
			//echo $sql4."<br>";
			$result_4=$bd->ejecutar($sql4);	
			//exit ();
			while($row4=mysqli_fetch_array($result_4))
			{
				$aux=$pdf->GetY();
				$pdf->SetX(20);
				$dato=date_create($row4["Fecha"]);
				$fecha=date_format($dato,'y/m/d');
				$dato1=$fecha;			
				//echo $dato1."Fecha <br>";
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
				$pdf->SetY($aux);
				$pdf->SetX(40);
				$pdf->Multicell(20,5,$fecha1,0,L,false);
				$pdf->SetX(70);
				$pdf->Multicell(15,5,$row['Units_Estimated'],0,R,false);
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
				$pdf->SetX(111);	
				$pdf->Multicell(25,5,$row4['Horas'],0,R,false);
				$pdf->SetY($aux);
				$pdf->SetX(140);
				$pdf->Multicell(60,4,$row4['Detalles'],0,L,false);
				//$pdf->Multicell(20,5,$row['Hrs_Left'],0,R,false);
				//$pdf->Multicell(20,5,"",0,R,false);
				$aux=$pdf->GetY();
				$pdf->SetY($aux);
				$pdf->SetX(160);	
				//$pdf->Multicell(20,5,$row['Percent_Used_Hrs'],0,R,false);			
				//$pdf->Multicell(20,5,"",0,R,false);	

				}
				$sql = "SELECT  SUM(pm.Cantidad_Usada) AS Cantidad_Usada FROM pedidos_material pm INNER JOIN materiales m ON pm.Mat_ID=m.Mat_ID ";
				$sql = $sql . "  WHERE m.Unidad_Medida='gl.' AND pm.Actividad_ID=".$row4['Actividad_ID']." AND  pm.Task_ID=".$row4['Task_ID'];	
				//echo $sql."<br>";
				$result=$bd->ejecutar($sql);	
				//exit ();
				while($row=mysqli_fetch_array($result))
					{
						$Cantidad_Usada=$row["Cantidad_Usada"];
					}
				mysqli_free_result($result);		
				$printx=0;
				if ($Tipo=="Detalle" && $printx==1)

				{	
				$pdf->SetY($aux);
				$pdf->SetX(180);
				$pdf->Multicell(20,5,"",0,R,false);			
				$pdf->SetY($aux);
				$pdf->SetX(200);
				$Cantidad_Usada=$row4['Matusado'];
				$pdf->Multicell(20,5,number_format($Cantidad_Usada,2),0,R,false);	
				$pdf->SetY($aux);
						$pdf->SetX(280);
						////***

				//		$texta=$row4['PorRep'];

					//	$Text='% completed at today: '.number_format($texta,2).'% reported';

						//$pdf->Multicell(60,5,$Text,0,L,false);
			//if ($TipoAux<>"SArea")	
				$aux=$pdf->GetY()+ 5;
				$pdf->SetY($aux);		

				}
				//$Total_Cantidad_Usada += $Cantidad_Usada;
				//$Total_Units_Done += $row4['Numero'];
				$Total_Used_Horas += $row4['Horas'];
				//$Total_MatUse+=$row4['Matusado'];
				$aux7=$pdf->GetY();					  
					if($aux7>=240)
					{
						$pdf->AddPage();
						
						membrete($pdf);
						//							$Nombre=$Nombre." a6";
						encabezado($pdf,$af1,$af2, $Tipo,$Nombre,$Notes);				
						$aux=51;		
						$aux7=51;

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
			$pdf->SetY($aux);	
			$pdf->SetX(18);		
			if ($TipoAux<>"SArea")			
				//$pdf->Multicell(80,5,"(".$Task_ID.")".$Tas_IDT." ".$Task_Name,0,L,false); 8888888888888888888  
				$pdf->Multicell(80,5,$Task_ID." | ".$Tas_IDT." ".$Task_Name,0,L,false);
			$Tk=substr($Task_Name,0,6);						
			if ($Tk=="Ticket")
			{
				$Horas_Estimadas=$Total_Used_Horas;
				$Total_Percent_Ejecutado=100;
				$PorcentajeRec=100;
				
			}
//			$pdf->Multicell(80,5,"    T.".$Task_Name,0,L,false);						
			$aux_99=$pdf->GetY();
			$pdf->SetX(70);
			//$pdf->Multicell(15,5,number_format($Units_Estimadas,2),0,R,false);
			$pdf->SetY($aux);		
			$pdf->SetX(85);				
			//$pdf->Multicell(15,5,number_format($Total_Units_Done,2),0,R,false);
			$pdf->SetY($aux);
			$pdf->SetX(90);
				if ($TipoAux<>"SArea")			
				  {
						if ($Tipo<>"Stru")
							$pdf->Multicell(25,5,number_format($Horas_Estimadas,2),0,R,false);
						
						$pdf->SetY($aux);
						$pdf->SetX(115);	
						//if ($Tipo<>"Stru")
											$pdf->Multicell(25,5,number_format($Total_Used_Horas,2),0,R,false);
						$pdf->SetY($aux);
						$pdf->SetX(140);
						$Total_Horas_Left=$Horas_Estimadas-$Total_Used_Horas;
						if ($Tipo<>"Stru")
							$pdf->Multicell(20,5,number_format($Total_Horas_Left,2),0,R,false);
						$pdf->SetY($aux);
						$pdf->SetX(160);
				  }
						if ($Horas_Estimadas>0)
						{
							$Total_Percent_Used_Horas=($Total_Used_Horas/$Horas_Estimadas)*100;
							if ($Horas_Estimadas<3)
								$Total_Percent_Used_Horas=0;
						}
						else
							{
							  $Total_Percent_Used_Horas=0;
							}
					/*	if ($Units_Estimadas>0)
						{
						//$Total_Percent_Ejecutado=$Total_Units_Done/$Units_Estimadas*100;
						}
						else
						{
						$Total_Percent_Ejecutado=0;
						}*/		

						if ($Total_Percent_Used_Horas>$Total_Percent_Ejecutado)
						{ 
						$textp="%**";
						}
						else
						{
						$textp="%  ";
						}
						$Text=number_format($Total_Percent_Used_Horas,0).$textp;
						//$pdf->Multicell(20,5,number_format($Total_Percent_Used_Horas,2),0,R,false);
						if ($TipoAux<>"SArea")			
						  if ($Tipo<>"Stru")
							$pdf->Multicell(15,5,$Text,0,R,false);
						$pdf->SetY($aux);
						$pdf->SetX(180);	
						//$pdf->Multicell(20,5,number_format($Material_Estimado,2),0,R,false);						
						$pdf->SetY($aux);
					//	$pdf->SetX(200);	
					//	$Total_Cantidad_Usada=$Total_MatUse;

					//	$pdf->Multicell(20,5,number_format($Total_Cantidad_Usada,2),0,R,false);

						$pdf->SetY($aux);

					//	$pdf->SetX(220);

					//	$total_Material_Left=$Material_Estimado-$Total_Cantidad_Usada;

					//	$pdf->Multicell(20,5,number_format($total_Material_Left,2),0,R,false);

						$pdf->SetY($aux);

					//	$pdf->SetX(240);

						if ($Material_Estimado>0)

						{

						//	$Total_Percent_Material_Used=$Total_Cantidad_Usada/$Material_Estimado*100;

						}

						else

						{
							$Total_Percent_Material_Used=0;
						}
				//		$Text=''.number_format($Total_Percent_Material_Used,0)."%";
				//		$pdf->Multicell(20,5,$Text,0,L,false);
						$pdf->SetY($aux);
						$pdf->SetX(260);
					if ($TipoAux<>"SArea")			
						$pdf->Multicell(20,5,'',0,R,false);
						//$pdf->Multicell(20,5,$TAux2,0,L,false);

						$pdf->SetY($aux);

						$pdf->SetX(178);
						$Total_Percent_Ejecutado=$PorcentajeRec;
						$Text=number_format($Total_Percent_Ejecutado,0).$textp;
					if ($TipoAux<>"SArea")			
						$pdf->Multicell(10,5,$Text,0,R,false);
						$pdf->SetY($aux);
						$pdf->SetX(190);
					if ($TipoAux<>"SArea")			
						$pdf->Multicell(25,5,"On:".$Last_Date_Per_Recorded,0,L,false);  
						
						
						
			$pdf->SetY($aux);
			//$pdf->SetX(210);
			$Total_Percent_Pendiente=100-$Total_Percent_Ejecutado;
			$Text=''.number_format($Total_Percent_Pendiente,0)."%";
			//$pdf->Multicell(20,5,$Text,0,L,false);
			$pdf->SetY($aux);
			//$pdf->SetX(198);
			$TPor_wj=($Total_Percent_Ejecutado*$Por_wj);
			//$Text=''.number_format($TPor_wj,2)."%";
			//$pdf->Multicell(20,5,$Text,0,L,false);
	if ($TipoAux<>"SArea")	
			$pdf->Multicell(20,5,'',0,L,false);
			//$pdf->Multicell(20,5,number_format($Total_Percent_Pendiente,2),0,R,false);
			if ($TipoAux<>"SArea")
				$aux7=$aux_99+1;

			//$aux7=$pdf->GetY();

			/*$pdf->line(10,$pdf->GetY()-5,350,$pdf->GetY()-5);

			$pdf->line(10,$aux+5,350,$aux+5);*/
			$bb=$aux_99-$aux;
			if ($Tipo=="Detalle")
			{
			$pdf->line(10,$pdf->GetY()-5,350,$pdf->GetY()-5);
			$pdf->line(10,$aux+$bb,350,$aux+$bb);
			}
			$pdf->SetY($aux7);												
			$aux7=$pdf->GetY();							

					if($aux7>=240)

					{
							$pdf->AddPage();
							
							membrete($pdf);
								//						$Nombre=$Nombre."a7";
							encabezado($pdf,$af1,$af2, $Tipo,$Nombre,$Notes);				
							$aux=51;		
							$aux7=51;

							$aux=$pdf->GetY()+2;
					}
					else
					{			  
							  //$pdf->SetY($aux7);
							  //$aux=$pdf->GetY();
							  $aux=$aux7;
					}			
			$ATotal_Cantidad_Usada+=$Total_Cantidad_Usada;
			$ATotal_Units_Done+=$Total_Units_Done;
			$ATotal_Used_Horas+=$Total_Used_Horas;
			$ATotal_Units_Estimadas+=$Units_Estimadas;
			$AHoras_Estimadas+=$Horas_Estimadas;
			//$ATotal_Per_wholejob+=($Total_Percent_Ejecutado);
			/*$strSQL = "UPDATE task SET  PorcentajeRec='".$PorcentajeRec."' WHERE Task_ID=".$Task_ID;	
			//echo $strSQL."<br>";				
			$res1=$bd->ejecutar($strSQL);*/
			$Contador++;
			$APor_wj+=$TPor_wj;
			}
////////////////INICIO IMPRESION DE TOTAL AREA/
			$pdf->SetFont('Arial','IB',8);
			$aux=$pdf->GetY();
			if ($aux==0 || is_null($aux))
			{
				$aux=51;
				$pdf->Sety($aux);	
			}
			//echo "Aux:".$aux."<br>";
			$pdf->SetY($aux);	
			$pdf->SetX(15);					
			$pdf->Multicell(80,5,"T..".$Area_Name,0,L,R);						
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
			if ($Tipo<>"Stru")
				$pdf->Multicell(25,5,number_format($AHoras_Estimadas,2),0,R,false);
			$pdf->SetY($aux);
			$pdf->SetX(115);
			if ($Tipo<>"Stru")	
								$pdf->Multicell(25,5,number_format($ATotal_Used_Horas,2),0,R,false);
			$pdf->SetY($aux);
			$pdf->SetX(140);
			$Total_Horas_Left=$AHoras_Estimadas-$ATotal_Used_Horas;
			if ($Tipo<>"Stru")
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
						$textp="%  ";
						}
						$Text=number_format($Total_Percent_Used_Horas,0).$textp;
						//$pdf->Multicell(20,5,number_format($Total_Percent_Used_Horas,2),0,R,false);
						if ($Tipo<>"Stru")
							$pdf->Multicell(15,5,$Text,0,R,false);
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
						//$pdf->SetX(260);
						$pdf->Multicell(20,5,'',0,L,false);
						//$pdf->Multicell(20,5,$AAux2,0,L,false);
						//$pdf->Multicell(20,5,number_format($total_Percent_Estimado,2),0,R,false);
						$pdf->SetY($aux);
						$pdf->SetX(178);
						if ($AAux2>0)
						{
							$Total_Percent_Ejecutado=$APor_wj/$AAux2;
						}
						else
						{
						$Total_Percent_Ejecutado=0;
						}		
						$Text=number_format($Total_Percent_Ejecutado,0).$textp; 
						$pdf->Multicell(10,5,$Text,0,R,false);
						$pdf->SetY($aux);
						$pdf->SetX(300);
						$Total_Percent_Pendiente=100-$Total_Percent_Ejecutado;
						$Text='    '.number_format($Total_Percent_Pendiente,2)."%";
						$pdf->Multicell(20,5,$Text,0,L,false);
			//$pdf->Multicell(20,5,number_format($Total_Percent_Pendiente,2),0,R,false);
if ($TipoAux<>"SArea")
				$aux7=$aux_99+5;
			else 
			$aux7=$aux_99+2;
			//$aux7=$pdf->GetY();
			/*$pdf->line(10,$pdf->GetY()-5,350,$pdf->GetY()-5);
			$pdf->line(10,$aux+5,350,$aux+5);*/
			$bb=$aux_99-$aux;
if ($TipoAux<>"SArea")			
			$pdf->line(10,$pdf->GetY()-5,350,$pdf->GetY()-5);
if ($TipoAux<>"SArea")			
			$pdf->line(10,$aux+$bb,350,$aux+$bb);

			$pdf->SetY($aux7);												
			$aux7=$pdf->GetY();							

					if($aux7>=240)

					{

							$pdf->AddPage();
							

							membrete($pdf);
							//$Nombre=$Nombre."a8aaaaaaa";

							encabezado($pdf,$af1,$af2, $Tipo,$Nombre,$Notes);		
							$aux=51;		
							$aux7=51;
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

			$pdf->SetFont('Arial','',8);

///////////	FIN IMPRESION TOTAL AREA				

		}
///// Inicio impresion FLOOR 
		$pdf->SetFont('Arial','IB',8);
			$aux=$pdf->GetY();																	
			$pdf->SetX(12);					
			$pdf->Multicell(50,5,"Total ".$Floor_Name,0,L,"Y");						
			$aux_99=$pdf->GetY();
			$pdf->SetY($aux);	
			$pdf->SetX(70);
			//$pdf->Multicell(15,5,number_format($FATotal_Units_Estimadas,2),0,R,false);
			$pdf->SetY($aux);		
			$pdf->SetX(85);				
			//$pdf->Multicell(15,5,number_format($FATotal_Units_Done,2),0,R,false);
			$pdf->SetY($aux);
						$pdf->SetX(90);
						if ($Tipo<>"Stru")
							$pdf->Multicell(25,5,number_format($FAHoras_Estimadas,2),0,R,false);
							
						$pdf->SetY($aux);
						$pdf->SetX(115);	
						if ($Tipo<>"Stru")
												$pdf->Multicell(25,5,number_format($FATotal_Used_Horas,2),0,R,false);
						$pdf->SetY($aux);
						$pdf->SetX(140);
						$Total_Horas_Left=$FAHoras_Estimadas-$FATotal_Used_Horas;
						if ($Tipo<>"Stru")
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
						$textp="%  ";
						}
						$Text=number_format($Total_Percent_Used_Horas,0).$textp;
						//$pdf->Multicell(20,5,number_format($Total_Percent_Used_Horas,2),0,R,false);
						if ($Tipo<>"Stru")
							$pdf->Multicell(15,5,$Text,0,R,false);
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
						//$pdf->SetX(260);
						//$pdf->Multicell(20,5,'',0,L,false);
						//$pdf->Multicell(20,5,$FAux2,0,L,false);
						//$pdf->Multicell(20,5,number_format($total_Percent_Estimado,2),0,R,false);
						$pdf->SetY($aux);
						$pdf->SetX(178);
						if ($FAux2>0)
						{
							$Total_Percent_Ejecutado=$FAPor_wj/$FAux2;
						}

						else
						{
							$Total_Percent_Ejecutado=0;
						}
						$Text=number_format($Total_Percent_Ejecutado,0).$textp;
						$pdf->Multicell(10,5,$Text,0,R,false);
						$pdf->SetY($aux);
						$pdf->SetX(198);
						
					

			$pdf->SetY($aux);
	//		$pdf->SetX(300);
			$Total_Percent_Pendiente=100-$Total_Percent_Ejecutado;
//			$Text='    '.number_format($Total_Percent_Pendiente,2)."%";
			//$pdf->Multicell(20,5,$Text,0,L,false);

			//$pdf->Multicell(20,5,number_format($Total_Percent_Pendiente,2),0,R,false);
			$aux7=$aux_99+5;
			//$aux7=$pdf->GetY();
			/*$pdf->line(10,$pdf->GetY()-5,350,$pdf->GetY()-5);
			$pdf->line(10,$aux+5,350,$aux+5);*/
			$bb=$aux_99-$aux;
		if ($TipoAux<>"SArea")	
			$pdf->line(10,$pdf->GetY()-5,350,$pdf->GetY()-5);
			else 
			$pdf->line(10,$pdf->GetY()-1,350,$pdf->GetY()-1);
			
			$pdf->line(10,$aux+$bb,350,$aux+$bb);
			$pdf->SetY($aux7);												
			$aux7=$pdf->GetY();							
					if($aux7>=240)
					{
							$pdf->AddPage();
							
							membrete($pdf);
														//$Nombre=$Nombre."a9";
							encabezado($pdf,$af1,$af2, $Tipo,$Nombre,$Notes);
							$aux=51;		
							$aux7=51;
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
			$JFATotal_Per_wholejob+=($Total_Percent_Ejecutado/100)*($FAHoras_Estimadas/$JobHoras_Estimadas);
			$JFAPor_wj+=$FAPor_wj;
			$pdf->SetFont('Arial','',8);



////// Fin impresion FLOOR 		
	}
	
/// inicio impresion tasks not estimated 77777
$TotNoE=0;
			$sql3 = "SELECT t.*,rda.*,sum(rda.Horas_Contract) as SumaH,rd.Fecha,rd.Reg_ID FROM task t join registro_diario_actividad rda on t.Task_ID=rda.Task_ID left join registro_diario rd on rd.Reg_ID=rda.Reg_ID WHERE (t.Horas_Estimadas between 0 and 1 ) AND t.Pro_ID=".$Pro_ID_Reporte." AND rd.Fecha BETWEEN '".$af1."' AND '".$af2."' GROUP BY t.Task_ID ORDER BY Tas_IDT ";


//echo $sql3."<br>";

			$result_3=$bd->ejecutar($sql3);	

			while($row3=mysqli_fetch_array($result_3))

			{

			
			$Tas_IDT=$row3['Tas_IDT'];
			$Task_ID=$row3['Task_ID'];
			$SumH=$row3['SumaH'];
			$Task_Name=$row3['Nombre'];
			$aux=$pdf->GetY();																	
			$pdf->SetY($aux);	
			$pdf->SetX(18);					
			$pdf->Multicell(80,5,"(".$Task_ID.") ".$Tas_IDT." ".$Task_Name,0,L,false);
			$Tk=substr($Task_Name,0,6);						
			$aux_99=$pdf->GetY();
			$pdf->SetX(70);
			$pdf->SetY($aux);		
			$pdf->SetX(85);				
			$pdf->SetY($aux);
			$pdf->SetX(115);	
			$pdf->Multicell(25,5,number_format($SumH,2),0,R,false);
			$TotNoE=$TotNoE+$SumH;
			$aux7=$aux_99+1;
			$pdf->SetY($aux7);												
			$aux7=$pdf->GetY();	
			$aux7=$aux_99+5;
			if($aux7>=240)
					{
							$pdf->AddPage();
							
							membrete($pdf);
														//$Nombre=$Nombre."a10";
							encabezado($pdf,$af1,$af2, $Tipo,$Nombre,$Notes);
							$aux=51;		
							$aux7=51;
				
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
			$pdf->SetY($aux);	
			$pdf->SetX(18);					
			$pdf->Multicell(80,5,"Total Tasks Not estimated:",0,L,false);
			$Tk=substr($Task_Name,0,6);						
			$aux_99=$pdf->GetY();
			$pdf->SetX(70);
			$pdf->SetY($aux);		
			$pdf->SetX(85);				
			$pdf->SetY($aux);
			$pdf->SetX(115);	
			$pdf->Multicell(25,5,number_format($TotNoE,2),0,R,false);
	
	
	$aux7=$aux_99+5;
			//$aux7=$pdf->GetY();
			/*$pdf->line(10,$pdf->GetY()-5,350,$pdf->GetY()-5);
			$pdf->line(10,$aux+5,350,$aux+5);*/
			$bb=$aux_99-$aux;
			$pdf->line(10,$pdf->GetY()-5,350,$pdf->GetY()-5);
			$pdf->line(10,$aux+$bb,350,$aux+$bb);
			$pdf->SetY($aux7);												
			$aux7=$pdf->GetY();	
	
	
	
	
			
/// fin 	impresion tasks not estimated  7777


////   impresion de horas no definidas q area

	$Hcontract=0;
	$G_Used_Horas=0;

	$HTM=0;
	$consulta = "select SUM(HContract) AS HContract, SUM(HTM) AS HTM FROM actividad_personal ap INNER JOIN actividades a ON ap.Actividad_ID=a.Actividad_ID ";
	$consulta = $consulta . " WHERE a.Pro_ID=".$Pro_ID." AND a.Fecha BETWEEN '".$af1."' AND '".$af2."' ";	
	//echo $consulta;	
	$result33=$bd->ejecutar($consulta); 	
	
	while (($row33 = mysqli_fetch_array($result33) ))							
		{				
			$HContract = $row33["HContract"];
			$HTM = $row33["HTM"];
		}
			$pdf->SetFont('Arial','IB',8);
			$aux=$pdf->GetY();																	
			$pdf->SetX(10);					
			$pdf->Multicell(50,5,"Hours not allocated: ",0,L,false);						
			$aux_99=$pdf->GetY();
			$pdf->SetY($aux);	
			$pdf->SetX(70);
			//$pdf->Multicell(15,5,number_format($JFATotal_Units_Estimadas,2),0,R,false);
			$pdf->SetY($aux);		
			$pdf->SetX(85);				
			//$pdf->Multicell(15,5,number_format($JFATotal_Units_Done,2),0,R,false);
			$pdf->SetY($aux);
			$pdf->SetX(90);
			$pdf->Multicell(25,5,number_format(0,2),0,R,false);
			$pdf->SetY($aux);
			$pdf->SetX(115);
			$G_Used_Horas=$HContract-$JFATotal_Used_Horas-$TotNoE;
			$pdf->Multicell(25,5,number_format($G_Used_Horas,2),0,R,false);
			$pdf->SetY($aux);
			$pdf->SetX(320);	
			$pdf->Multicell(20,5,number_format($HTM,2),0,R,false);
			$aux7=$aux_99+5;
			$bb=$aux_99-$aux;
			$pdf->line(10,$pdf->GetY()-5,350,$pdf->GetY()-5);
			$pdf->line(10,$aux+$bb,350,$aux+$bb);
			$pdf->SetY($aux7);												
			$aux7=$pdf->GetY();							
			if($aux7>=240)

					{

							$pdf->AddPage();
							
							membrete($pdf);
														//$Nombre=$Nombre."a12";
							encabezado($pdf,$af1,$af2, $Tipo,$Nombre,$Notes);				
							$aux=51;		
							$aux7=51;

							$aux=$pdf->GetY()+2;

					}
					else
					{			  
							  //$pdf->SetY($aux7);
							  //$aux=$pdf->GetY();
							  $aux=$aux7;
					}			

/// fin impresion horas no definidas

//// Inicio impresion JOB

			$pdf->SetFont('Arial','IB',8);

			$aux=$pdf->GetY();																	

			$pdf->SetX(10);					

			$pdf->Multicell(50,5,"Total Job:: ".$Job_Name1,0,L,false);						

			$aux_99=$pdf->GetY();
			$pdf->SetY($aux);	
			$pdf->SetX(70);
			//$pdf->Multicell(15,5,number_format($JFATotal_Units_Estimadas,2),0,R,false);
			$pdf->SetY($aux);		
			$pdf->SetX(85);				
			//$pdf->Multicell(15,5,number_format($JFATotal_Units_Done,2),0,R,false);
			$pdf->SetY($aux);
			$pdf->SetX(90);
			if ($Tipo<>"Stru")
				$pdf->Multicell(25,5,number_format($JFAHoras_Estimadas,2),0,R,false);
			$pdf->SetY($aux);
			$pdf->SetX(115);	
			$JFATotal_Used_Horas=$JFATotal_Used_Horas+$TotNoE+$G_Used_Horas;
			if ($Tipo<>"Stru")
				$pdf->Multicell(25,5,number_format($JFATotal_Used_Horas,2),0,R,false);
			$pdf->SetY($aux);
			$pdf->SetX(140);
			$Total_Horas_Left=$JFAHoras_Estimadas-$JFATotal_Used_Horas;
			if ($Tipo<>"Stru")
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
						$textp="%  ";
						}
						$Text=number_format($Total_Percent_Used_Horas,0).$textp;
						if ($Tipo<>"Stru")
							$pdf->Multicell(15,5,$Text,0,R,false);

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
						$Text=''.number_format($Total_Percent_Material_Used,2)."%";*/
						//$pdf->Multicell(20,5,$Text,0,L,false);
						$pdf->SetY($aux);
						$pdf->SetX(260);
						//$pdf->Multicell(20,5,$JAux2,0,L,false);
						$pdf->Multicell(20,5,number_format($total_Percent_Estimado,2),0,R,false);
						$pdf->SetY($aux);
						$pdf->SetX(178);
						$Total_Percent_Ejecutado=$JFAPor_wj/100;
						$Text=number_format($Total_Percent_Ejecutado,0).$textp;
						$pdf->Multicell(10,5,$Text,0,R,false);
			$pdf->SetY($aux);
			$pdf->SetX(300);
			$Total_Percent_Pendiente=100-$Total_Percent_Ejecutado;
			$Text='    '.number_format($Total_Percent_Pendiente,2)."%";
			//$pdf->Multicell(20,5,$Text,0,L,false);

			//$pdf->Multicell(20,5,number_format($Total_Percent_Pendiente,2),0,R,false);
			$aux7=$aux_99+5;

			$aux7=$pdf->GetY();

			/*$pdf->line(10,$pdf->GetY()-5,350,$pdf->GetY()-5);

			$pdf->line(10,$aux+5,350,$aux+5);*/
			$bb=$aux_99-$aux;
			$pdf->line(10,$pdf->GetY()-5,350,$pdf->GetY()-5);
			$pdf->line(10,$aux+$bb,350,$aux+$bb);
			$pdf->SetY($aux7);												
			$aux7=$pdf->GetY();							
					if($aux7>=240)
					{
						$pdf->AddPage();
						
							membrete($pdf);
							//$Nombre=$Nombre."a1";
							encabezado($pdf,$af1,$af2, $Tipo,$Nombre,$Notes);				
							$aux=51;		
							$aux7=51;
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

}	

	
}
	
mysqli_free_result($result55);		
	
		

	$pdf->Output("dato.pdf");

	

?>

	<embed src="dato.pdf#toolbar=1&navpanes=0&scrollbar=1" width="990" height="670"></embed>

<?

	require('Library/Close_Conexion.php');	

?>















