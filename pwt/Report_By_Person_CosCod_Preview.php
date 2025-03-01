<?php
	session_name("Administrador");
	session_start();
	//*******************************************************************
	//Datos enviados por proyecto_reporte_material_0.php
	//******************************************************************
	$vfrom_date=$_REQUEST["Fecha_Inicio_Busqueda"];
	$vto_date=$_REQUEST["Fecha_Fin_Busqueda"];
	$Pro_ID_Reporte=$_REQUEST["Pro_ID_Reporte"];
	$Nombre_Empleado=$_REQUEST["Nombre_Empleado"];
	$Nick_Name=$_REQUEST["Nick_Name"];
			
	require('Library/Control_Cache.php');	
	require('Library/Open_Conexion.php');
	require('Library/funciones.php');
		
	// INSERTADO POR FABIOLA CARRASCO
	require('pdf/fpdf.php');
	$pdf=new FPDF();
	$pdf->AddPage();
	

	// DEFINICION DE FUNCIONES DE CABEZERA DE SUBCUEPO
	$pdf->SetMargins(15,20,15,15);
	$pdf->SetFont('Arial','',10);
	$pdf->SetLineWidth(0.5); 
	$pdf->Setfillcolor(237,243,120);
	
	function membrete(&$pdf)
	{
		//ENCABEZADO
		$pdf->SetFont('Arial','',8);
		$pdf->Image('images/logo.png',5,5,30,10,"png");
		/*$pdf->SetY(15);
		$pdf->SetX(10);
		$pdf->Multicell(0,3,"Name Proyect:",0,L,false);
		$pdf->SetX(10);
		$pdf->Multicell(0,3,"PO: ",0,L,false);

		$pdf->SetX(10);		
		$pdf->Multicell(0,3,"Address: ",0,L,false);

		$pdf->SetX(10);		
		$pdf->Multicell(0,3,"Coordinator of the Work:",0,L,false);

		$pdf->SetX(10);		
		$pdf->Multicell(0,3,"Foreman: ",0,L,false);*/
		$pdf->SetFont('Arial','',10);
	}
	
	function encabezado(&$pdf,$f1,$f2)
	{
	  $f1=FormatDateTime($f1, 8);
	  $f2=FormatDateTime($f2, 8);
  	  $pdf->Multicell(0,5,"",0,'L',false);
	  $pdf->Multicell(0,5,"Report: Detail Total Hours/Job By cost Code",0,'C',false);
  	  $pdf->Multicell(0,5,"from:".$f1." to:".$f2,0,'C',false);
  	  $pdf->Multicell(0,5,"",0,'L',false);
	  // titulo del detall	  
   	  $aux=$pdf->GetY();
	  $pdf->SetX(20);
	  $pdf->Multicell(0,5,"Empl.#  Job#",0,'L',false);
	  $pdf->SetY($aux);
	  $pdf->SetX(42);
	  $pdf->Multicell(0,5,"Name",0,'L',false);
	  $pdf->SetY($aux);
	  $pdf->SetX(120);
	  $pdf->Multicell(0,5,"Date",0,'L',false);
	  $pdf->SetY($aux);
	  $pdf->SetX(120);
	  //$pdf->Multicell(25,5,"Hours in Contract",0,C,false);
	  $pdf->SetY($aux);
	  $pdf->SetX(140);
	  //$pdf->Multicell(25,5,"Hours in Ticket Work",0,C,false);
	  $pdf->SetY($aux);
	  $pdf->SetX(163);
	  $pdf->Multicell(20,5,"  Total   Hours",0,'C',false);
	  /*$pdf->SetY($aux);
	  $pdf->SetX(142);
	  $pdf->Multicell(30,5,"Used",0,C,false);
  	  $pdf->SetY($aux);
  	  $pdf->SetX(160);
	  $pdf->Multicell(23,5,"Balanced",0,C,false);*/
	  $aux7=$pdf->GetY();
	  $pdf->line(10,$pdf->GetY()-10,200,$pdf->GetY()-10);
  	  $pdf->line(10,$aux+10,200,$aux+10);
	  $pdf->SetY($aux7+10);
	  
	}
		
	function subtotal(&$pdf,&$Parcial_HContract,&$Parcial_HTM)
	{
	  $aux=$pdf->GetY();
  	  $pdf->line(130,$pdf->GetY(),200,$pdf->GetY());
	  $pdf->SetX(100);
	  $pdf->Multicell(0,5,"|||  Subtotal..  |",0,'L',false);
	  $pdf->SetY($aux);
	  $pdf->SetX(120);					  
	//  $pdf->Multicell(20,5,number_format(($Parcial_HContract),2),0,R,false);
	  $pdf->SetY($aux);					  
	  $pdf->SetX(140);					  
	//  $pdf->Multicell(20,5,number_format(($Parcial_HTM),2),0,R,false);
	  $pdf->SetY($aux);
	  $pdf->SetX(160);					  
	  $pdf->Multicell(20,5,number_format(($Parcial_HContract+$Parcial_HTM),2),0,'R',false);
			
   	  $pdf->line(130,$pdf->GetY(),200,$pdf->GetY());
   	  $pdf->Multicell(0,5,"",0,'L',false);
	  $Parcial_HContract=0;
	  $Parcial_HTM=0;
	}
		
	$vdia=substr($vfrom_date,3,2);
	$vmes=substr($vfrom_date,0,2);
	$vano=substr($vfrom_date,8,2);
	
	//	  $dato=date_create($vfrom_date);
	//	  $af1=date_format($dato,'y/d/m');
	$af1="20".$vano."-".$vmes."-".$vdia;
	
	$vdia=substr($vto_date,3,2);
	$vmes=substr($vto_date,0,2);
	$vano=substr($vto_date,8,2);
	
	$af2="20".$vano."-".$vmes."-".$vdia;
	
	//  	  $dato=date_create($vto_date);
	//	  $af2=date_format($dato,'y/d/m');
	
	$consulta = "SELECT p.Empleado_ID,p.Numero,ap.Actividad_ID,p.Nombre,t.Nombre as tnombre,p.Aux5,p.Nick_Name,p.Apellido_Materno, pr.Codigo, pr.Nombre,ap.Note, a.Fecha, rda.Horas_Contract+rda.Horas_TM AS HContract ";
	$consulta = $consulta . " FROM personal p INNER JOIN actividad_personal ap ON  p.Empleado_ID=ap.Empleado_ID ";
	$consulta = $consulta . " INNER JOIN actividades a ON a.Actividad_ID=ap.Actividad_ID ";
	$consulta = $consulta . " INNER JOIN proyectos pr ON a.Pro_ID=pr.Pro_ID ";
	
	
	$consulta = $consulta . " inner join registro_diario rd on rd.Actividad_Id=a.Actividad_ID inner JOIN registro_diario_actividad rda on rda.Reg_ID=rd.Reg_ID inner join task t on t.Task_ID=rda.Task_ID ";
	
	
	$consulta = $consulta . " WHERE a.Fecha>='".$af1."' AND  a.Fecha<='".$af2."'  and (substring(pr.Codigo,1,3)<900 or '".$Pro_ID_Reporte."'>0)";
	
	if ($Pro_ID_Reporte!=-33)	
		$consulta = $consulta . " AND pr.Pro_ID=$Pro_ID_Reporte ";
		
	if ($Nombre_Empleado!="")	
		$consulta = $consulta . " AND p.Aux5 like '%$Nombre_Empleado%' ";
	
	if ($Nick_Name!="")	
		$consulta = $consulta . " AND ((p.Nick_Name like '%$Nick_Name%') OR (p.Nombre like '%$Nick_Name%'  )) ";	
		
	
	$consulta = $consulta . " GROUP BY p.Nick_Name, pr.Codigo, pr.Nombre, a.Fecha ";
	$consulta = $consulta . " ORDER BY p.Apellido_Materno,p.Nick_Name,a.Fecha,t.nombre,pr.Codigo, pr.Nombre  ";
	
	
	
	///SELECT p.Empleado_ID,p.Numero,ap.Actividad_ID,p.Nombre,t.Nombre,p.Aux5,p.Nick_Name,p.Apellido_Materno, pr.Codigo, pr.Nombre,ap.Note, a.Fecha, sum(rda.Horas_Contract+rda.Horas_TM) AS HContract FROM personal p INNER JOIN actividad_personal ap ON p.Empleado_ID=ap.Empleado_ID INNER JOIN actividades a ON a.Actividad_ID=ap.Actividad_ID INNER JOIN proyectos pr ON a.Pro_ID=pr.Pro_ID inner join registro_diario rd on rd.Actividad_Id=a.Actividad_ID inner JOIN registro_diario_actividad rda on rda.Reg_ID=rd.Reg_ID inner join task t on t.Task_ID=rda.Task_ID WHERE a.Fecha>='2024-02-12' AND a.Fecha<='2024-02-26' and (substring(pr.Codigo,1,3)<900 or '-33'>0) GROUP BY p.Nick_Name,rda.Task_ID,pr.Codigo, pr.Nombre, a.Fecha ORDER BY p.Apellido_Materno,p.Nick_Name,t.nombre, a.Fecha, pr.Codigo, pr.Nombre
	
	
	
	
	
//echo $consulta."<br><br>" ;
	$result=$bd->ejecutar($consulta);
	// titulo del reporte
   	membrete($pdf,$vfrom_date);
	encabezado($pdf,$af1,$af2);

    if(mysqli_num_rows($result)>0) 		 
	{
		$total_ordenado=0;
		$total_recibido=0;
		$total_usado=0;
		$total_balance=0;
		$bandera=1;	
		$bandera_2=1;
		$Nick_Name=0;
		$EmpleadoID=0;
		$conlin=0;
		$connoshow=0;

		while($row=mysqli_fetch_array($result))
		{
			if (  ($EmpleadoID!=$row["Empleado_ID"] ) && ($bandera==0 ) )
			{				
	//subtotal(&$pdf,$Parcial_HContract,$Parcial_HTM); IT IS REPLACED W/CODE BELOW
	
	  $aux=$pdf->GetY();
  	  $pdf->line(130,$pdf->GetY(),200,$pdf->GetY());
	  $pdf->SetX(100);
	  $pdf->Multicell(0,5,"  Subtotal  |",0,'L',false);
	  $pdf->SetY($aux);
	  $pdf->SetX(120);					  
	//  $pdf->Multicell(20,5,number_format(($Parcial_HContract),2),0,R,false);
	  $pdf->SetY($aux);					  
	  $pdf->SetX(140);					  
	//  $pdf->Multicell(20,5,number_format(($Parcial_HTM),2),0,R,false);
	  $pdf->SetY($aux);
	  $pdf->SetX(180);
	  					  
	  $pdf->Multicell(20,5,number_format(($Parcial_HContract+$Parcial_HTM),2),0,'R',false);
			
   	  $pdf->line(130,$pdf->GetY(),200,$pdf->GetY());
   	  $pdf->Multicell(0,5,"",0,'L',false);
	  $Parcial_HContract=0;
	  $Parcial_HTM=0;

				///////// SUBTOTAL END 


				$Nick_Name=$row["Numero"]." | ".$row["Nick_Name"]." |";
				$EmpleadoID=$row["Empleado_ID"];
				$bandera_2=1;						
			}	
			if($bandera==1)
			{
				
				$EmpleadoID=$row["Empleado_ID"];
				//$Nick_Name=$row["Nick_Name"];
				$bandera=0;
			}						
			if($bandera_2==1)
			{
				$aux=$pdf->GetX();
				$pdf->SetX(15);
				$nick=$row[Numero]." | ".$row[Nick_Name]."  ".$row[Apellido_Materno];
				$pdf->Multicell(0,5,$nick."|",0,'L',false);
				
				$bandera_2=0;							  
			}
			//********************************************************************
			// DETALLE
			//********************************************************************
			$aux=$pdf->GetY();
			$pdf->SetX(20);
			//$dato=date_create($row["Fecha"]);
			//$fecha=date_format($dato,'y/m/d');
	
			$fecha=FormatDateTime($row["Fecha"], 8);
			$conlin++;
//			$pdf->Multicell(0,5,$conlin.": ".$row['Codigo'],0,'L',false);
			$textprint=$row['Numero']." | ".$row['Codigo'];
			$pdf->Multicell(0,5,$textprint,0,'L',false);
			$pdf->SetY($aux);
			$pdf->SetX(47);
			$pdf->Multicell(0,5,(substr(($row['Nombre']),0,24)),0,'L',false);
			$pdf->SetY($aux);					  
			$pdf->SetX(92);
			$pdf->Multicell(0,5,$fecha,0,'L',false);
			$pdf->SetY($aux);					  
			$pdf->SetX(131);
			$pdf->Multicell(60,5,"-".(substr($row['tnombre'],0,30)),0,'L',false);

			$pdf->SetY($aux);
			$pdf->SetX(120);
		//	$pdf->Multicell(20,5,number_format(($row['HContract']),2),0,R,false);
			$pdf->SetY($aux);
			$pdf->SetX(140);					  
		//	$pdf->Multicell(20,5,number_format(($row['HTM']),2),0,R,false);
			$pdf->SetY($aux);
			$pdf->SetX(180);					  
			
			// obtiene horas de Registro DIARIO ACTIVIDAD
	  $Actividad_ID=$row["Actividad_ID"];
	  $Empleado_ID=$row["Empleado_ID"];
	  
//	  $sql55 = "SELECT sum(rda.Horas_Contract) as Horas FROM registro_diario_actividad rda inner join registro_diario rd on rd.Reg_ID=rda.Reg_ID ";	
// 	  $sql55 = $sql55 . " WHERE  rd.Actividad_ID=".$Actividad_ID." AND rd.Empleado_ID=".$Empleado_ID;
		//echo $sql55."<br>";

//	$result_55=$bd->ejecutar($sql55);
	$RDA_Horas=0;
//   while($row55=mysqli_fetch_array($result_55))
	//{
		//$RDA_Horas=$row55["Horas"];
		//echo $RDA_Horas."<br>";
//	}
//	mysqli_free_result($result_55);	
		
	$TotHor=$row["HContract"];
	//if ($RDA_Horas != $TotHor )
		//$Rda_Tex="  rda:".$RDA_Horas;
	 // else
	  //	$Rda_Tex="";

	//Fin   horas  RDA   
			
			
			$Rda_Tex="";
			if (($row['HContract'])==0)
				{
					$connoshow++;
					//$Rda_Tex=" No show up ";
				}
				else
					$Rda_Tex="";

			$pdf->Multicell(20,5,number_format(($row['HContract']),2),0,'R',false);
			$note1=strlen($row['Note']);
			$pdf->SetY($aux);
			$pdf->SetX(180);					  
			$pdf->Multicell(25,5," ".$Rda_Tex);
			

			
			if ($note1>8)
				{
				$pdf->SetX(20);
				//$pdf->Multicell(0,5,(substr(($row['Note']),0,150)),5,'L',false);
				}
						
				
			$aux6=$pdf->GetY();
			//sumas parciales por material
			$Parcial_HContract=$Parcial_HContract+$row["HContract"];
  			$Parcial_HTM=$Parcial_HTM+$row["HTM"];
			
			//sumas totales 			  
			$Total_HContract=$Total_HContract+$row["HContract"];
			$Total_HTM=$Total_HTM+$row["HTM"];
			
			
//			$pdf->Multicell(20,5,number_format(($Total_HContract+$Total_HTM),2),0,'R',false);	
			
			
			if($aux6>=260)
			{
				$pdf->AddPage();
				membrete($pdf);
				encabezado($pdf,$af1,$af2);
			}
		}		
		
		//subtotal(&$pdf,$Parcial_HContract,$Parcial_HTM); REPLACED W/CODE BELOW
	  $aux=$pdf->GetY();
  	  $pdf->line(130,$pdf->GetY(),200,$pdf->GetY());
	  $pdf->SetX(100);
	  $pdf->Multicell(0,5," Subtotal   |",0,'L',false);
	  $pdf->SetY($aux);
	  $pdf->SetX(40);					  
//	  $pdf->Multicell(50,5,"Days Schedule:".number_format(($conlin),2),0,R,false);
	  $pdf->SetY($aux);					  
	  $pdf->SetX(90);					  
//	  $pdf->Multicell(50,5,"Days no show:".number_format(($connoshow),2),0,R,false);
	  $pdf->SetY($aux);
	  $pdf->SetX(180);					  
	  $pdf->Multicell(20,5,number_format(($Parcial_HContract+$Parcial_HTM),2),0,'R',false);
			
   	  $pdf->line(130,$pdf->GetY(),200,$pdf->GetY());
   	  $pdf->Multicell(0,5,"",0,'L',false);
	  $Parcial_HContract=0;
	  $Parcial_HTM=0;
	  $conlin=0;
	  $connoshow=0;

				///////// SUBTOTAL END 




		$pdf->line(10,$pdf->GetY(),200,$pdf->GetY());
		$pdf->Multicell(0,5,"",0,'L',false);										
		$aux=$pdf->GetY();
		$pdf->Multicell(0,5,"Total General:",0,'L',false);
		$pdf->SetY($aux);
		$pdf->SetX(120);					  		  
		//$pdf->Multicell(20,5,number_format(($Total_HContract),2),0,R,false);
		$pdf->SetY($aux);					  
		$pdf->SetX(140);					  
		//$pdf->Multicell(20,5,number_format(($Total_HTM),2),0,R,false);	
		$pdf->SetY($aux);					  
		$pdf->SetX(180);					  
		$pdf->Multicell(20,5,number_format(($Total_HContract+$Total_HTM),2),0,'R',false);			
	}	
	mysqli_free_result($result);

	$pdf->Output("dato.pdf");
	?>
	<embed src="dato.pdf#toolbar=1&navpanes=0&scrollbar=0" width="1000" height="570"></embed>
    <?
	require('Library/Close_Conexion.php');	
?>



