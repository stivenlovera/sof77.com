<?php

	session_name("Administrador");

	session_start();

	//*******************************************************************

	//Datos enviados por proyecto_reporte_material_0.php

	//******************************************************************

	$vfrom_date=$_REQUEST["Fecha_Inicio_Busqueda"];

	$vto_date=$_REQUEST["Fecha_Fin_Busqueda"];

	$Pro_ID_Reporte=$_REQUEST["Pro_ID_Reporte"];

	

		

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

  	  $pdf->Multicell(0,5,"",0,L,false);

	  $pdf->Multicell(0,5,"Report: Hours Totals By Job",0,C,false);

  	  $pdf->Multicell(0,5,"from:".$f1." to:".$f2,0,C,false);

  	  $pdf->Multicell(0,5,"",0,L,false);

	  // titulo del detall	  

  	  $aux=$pdf->GetY();

	  $pdf->SetX(20);

	  $pdf->Multicell(30,5,"Code",0,L,false);

	  $pdf->SetY($aux);

	  $pdf->SetX(50);

	  $pdf->Multicell(80,5,"Job",0,L,false);	  

	  $pdf->SetY($aux);

	  $pdf->SetX(130);

	  $pdf->Multicell(20,5,"Hours By Dates",0,C,false);

	  $pdf->SetY($aux);

	  $pdf->SetX(150);

	  $pdf->Multicell(23,5,"Hrs.next 6o days",0,C,false);

	  $pdf->SetY($aux);

	  $pdf->SetX(173);

	  $pdf->Multicell(30,5,"Total Job Hours used",0,C,false);

	  /*$pdf->SetY($aux);

	  $pdf->SetX(142);

	  $pdf->Multicell(30,5,"Used",0,C,false);

  	  $pdf->SetY($aux);

  	  $pdf->SetX(160);

	  $pdf->Multicell(23,5,"Balanced",0,C,false);*/

	  $aux7=$pdf->GetY();

	  $pdf->line(10,$pdf->GetY()-10,200,$pdf->GetY()-10);

  	  $pdf->line(10,$aux+10,200,$aux+10);

	  $pdf->SetY($aux7);

	  

	}

		

	function subtotal(&$pdf,&$Parcial_HContract,&$Parcial_HTM)

	{

	  $aux=$pdf->GetY();

  	  $pdf->line(130,$pdf->GetY(),200,$pdf->GetY());

	  $pdf->SetX(100);

	  $pdf->Multicell(0,5,"Subtotal",0,L,false);

	  $pdf->SetY($aux);

	  $pdf->SetX(120);					  

	  $pdf->Multicell(20,5,number_format(($Parcial_HContract),2),0,R,false);

	  $pdf->SetY($aux);					  

	  $pdf->SetX(140);					  

	  $pdf->Multicell(20,5,number_format(($Parcial_HTM),2),0,R,false);

	  $pdf->SetY($aux);					  

	  $pdf->SetX(160);					  

	  $pdf->Multicell(20,5,number_format(($Parcial_HContract+$Parcial_HTM),2),0,R,false);

   	  $pdf->line(130,$pdf->GetY(),200,$pdf->GetY());

   	  $pdf->Multicell(0,5,"",0,L,false);

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
	$Date1 = $af2;
	$date = new DateTime($Date1);
	$date->modify('+60 day');
	$Date2 = $date->format('Y-m-d');
	$af2Plus=$date->format('Y-m-d');



	//  	  $dato=date_create($vto_date);

	//	  $af2=date_format($dato,'y/d/m');
$sql="UPDATE proyectos set Tot_Hor_Usa=0,Tot_Hor_UsaAux=0 WHERE Pro_ID>1";
		$result89=$bd->ejecutar($sql);
		mysqli_free_result($result89);
	
// suma total de horas inicio
	$sql="UPDATE proyectos p INNER JOIN (SELECT rd.Pro_ID,rd.Reg_ID,SUM(ra.Horas_Contract) 'suma' FROM registro_diario_actividad ra inner join registro_diario rd on rd.Reg_ID=ra.Reg_ID GROUP BY rd.Pro_ID) ah ON p.Pro_ID=ah.Pro_ID SET p.Tot_Hor_Usa = ah.suma WHERE p.Pro_ID=ah.Pro_ID ";
	//echo $sql;
	//exit ();
		$result89=$bd->ejecutar($sql);
		mysqli_free_result($result89);

$sql="UPDATE proyectos p INNER JOIN (SELECT rd.Pro_ID,rd.Reg_ID,rd.Fecha,SUM(ra.Horas_Contract) 'suma' FROM registro_diario_actividad ra inner join registro_diario rd on rd.Reg_ID=ra.Reg_ID where rd.Fecha>'".$af2."' AND  rd.Fecha<='".$af2Plus."' GROUP BY rd.Pro_ID) ah ON p.Pro_ID=ah.Pro_ID SET p.Tot_Hor_UsaAux = ah.suma WHERE p.Pro_ID=ah.Pro_ID ";
	//echo $sql;
	//exit ();
		$result89=$bd->ejecutar($sql);
		mysqli_free_result($result89);
	
//	suma total de horas fin

	$consulta = "SELECT pr.Codigo,pr.Estado, pr.Nombre,pr.Tot_Hor_Usa,pr.Tot_Hor_UsaAux,pr.Codigo_Bono, pr.calle, pr.ciudad, pr.estado, pr.zip_code,tp.Nombre_Tipo, SUM(HContract) AS HContract, SUM(HTM) AS HTM ";
	$consulta = $consulta . " FROM personal p INNER JOIN actividad_personal ap ON  p.Empleado_ID=ap.Empleado_ID ";
	$consulta = $consulta . " INNER JOIN actividades a ON a.Actividad_ID=ap.Actividad_ID ";
	$consulta = $consulta . " INNER JOIN proyectos pr ON a.Pro_ID=pr.Pro_ID ";
$consulta = $consulta . " INNER JOIN tipo_proyecto tp ON tp.Tipo_ID=pr.Tipo_ID ";
	
	$consulta = $consulta . " WHERE a.Fecha>='".$af1."' AND  a.Fecha<='".$af2."'  ";
	//$consulta = $consulta . " WHERE a.Fecha>='".$af1."' AND  a.Fecha<='".$af2."' and pr.Estado='DC' ";
	if ($Pro_ID_Reporte!=-33)	
		$consulta = $consulta . " AND pr.Pro_ID=$Pro_ID_Reporte ";
	$consulta = $consulta . " GROUP BY pr.Codigo, pr.Nombre, pr.calle, pr.ciudad, pr.estado, pr.zip_code ";
	$consulta = $consulta . " ORDER BY Tot_Hor_UsaAux,HContract DESC,pr.Codigo, pr.Nombre ";

	//$consulta = $consulta . " GROUP BY p.Nick_Name, p.Nombre,  p.Apellido_Paterno, p.Apellido_Materno ";
	//$consulta = $consulta . " ORDER BY  p.Nick_Name";

    //echo $consulta ;

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

		while($row=mysqli_fetch_array($result))

		{
			//********************************************************************

			// DETALLE

			//********************************************************************
			$aux=$pdf->GetY();
			$pdf->SetX(5);			
			$codbono="";
			if ($row['Codigo_Bono']<>'')
				$codbono=' Bonus:'.$row['Codigo_Bono'];
				
			
			//$codbono=" ".$row['Nombre_Tipo'];
			//$codbono=" ".$row['Estado'];
			$pdf->Multicell(60,5,$row['Codigo'].$codbono,0,L,false);
			$pdf->SetY($aux);
			$pdf->SetX(60);
			//$pdf->Multicell(80,5,$row['Mombre'].", Add:".$row['calle'].",".$row['ciudad'].",".$row['estado'].",".$row['zip_code'],0,L,false);			
			$pdf->Multicell(80,5,$row['Nombre'],0,L,false);			
			$pdf->SetY($aux);
			$pdf->SetX(130);
			$pdf->Multicell(20,5,number_format(($row['HContract']),2),0,R,false);				
			$pdf->SetY($aux);
			$pdf->SetX(150);					  
			$pdf->Multicell(20,5,number_format(($row['Tot_Hor_UsaAux']),2),0,R,false);
			$pdf->SetY($aux);
			$pdf->SetX(170);					  
			$pdf->Multicell(20,5,number_format(($row['Tot_Hor_Usa']),2),0,R,false);
			$aux6=$pdf->GetY();			
			//sumas totales 			  

			$Total_HContract=$Total_HContract+$row["HContract"];
			$GTot_Hor_Usa=$GTot_Hor_Usa+$row["Tot_Hor_Usa"];
			$Total_HTM=$Total_HTM+$row["HTM"];
			if($aux6>=260)
			{
				$pdf->AddPage();
				membrete($pdf);
				encabezado($pdf,$af1,$af2);

			}

		}		
		$pdf->line(10,$pdf->GetY(),200,$pdf->GetY());
		$pdf->Multicell(0,5,"",0,L,false);										
		$aux=$pdf->GetY();
		$pdf->Multicell(0,5,"Total General",0,L,false);
		$pdf->SetY($aux);
		$pdf->SetX(130);					  		  
		$pdf->Multicell(20,5,number_format(($Total_HContract),2),0,R,false);
		$pdf->SetY($aux);					  
		$pdf->SetX(150);	
//		$pdf->Multicell(20,5,number_format(($Total_HTM),2),0,R,false);
		$pdf->SetY($aux);					  
		$pdf->SetX(170);					  
	//	$pdf->Multicell(20,5,number_format(($Total_HContract+$Total_HTM),2),0,R,false);			
		$pdf->Multicell(20,5,number_format(($GTot_Hor_Usa),2),0,R,false);			
	}	
	mysqli_free_result($result);
	$pdf->Output("dato.pdf");
	?>
	<embed src="dato.pdf#toolbar=1&navpanes=0&scrollbar=0" width="1190" height="570"></embed>
    <?
	require('Library/Close_Conexion.php');	
?>







