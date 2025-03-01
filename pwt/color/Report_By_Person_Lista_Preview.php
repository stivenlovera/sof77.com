<?php
	session_name("Administrador");
	session_start();
	//*******************************************************************
	//Datos enviados por proyecto_reporte_material_0.php
	//******************************************************************
	$vfrom_date=$_REQUEST["Fecha_Inicio_Busqueda"];
	$vto_date=$_REQUEST["Fecha_Fin_Busqueda"];
	
		
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
  	  $pdf->Multicell(0,5,"",0,L,false);
	  $pdf->Multicell(0,5,"Report By Person",0,C,false);
  	  $pdf->Multicell(0,5,"from:".$f1." to:".$f2,0,C,false);
  	  $pdf->Multicell(0,5,"",0,L,false);
	  // titulo del detall	  
  	  $aux=$pdf->GetY();
	  $pdf->SetX(20);
	  $pdf->Multicell(0,5,"# Job",0,L,false);
	  $pdf->SetY($aux);
	  $pdf->SetX(42);
	  $pdf->Multicell(0,5,"Name",0,L,false);
	  $pdf->SetY($aux);
	  $pdf->SetX(96);
	  $pdf->Multicell(0,5,"Date",0,L,false);
	  $pdf->SetY($aux);
	  $pdf->SetX(120);
	  $pdf->Multicell(25,5,"Hours in Contract",0,C,false);
	  $pdf->SetY($aux);
	  $pdf->SetX(140);
	  $pdf->Multicell(25,5,"Hours in Ticket Work",0,C,false);
	  $pdf->SetY($aux);
	  $pdf->SetX(160);
	  $pdf->Multicell(25,5,"Total Hours",0,C,false);
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
	  $pdf->Multicell(20,5,$Parcial_HContract,0,R,false);
	  $pdf->SetY($aux);					  
	  $pdf->SetX(140);					  
	  $pdf->Multicell(20,5,$Parcial_HTM,0,R,false);
	  $pdf->SetY($aux);
	  $pdf->SetX(160);					  
	  $pdf->Multicell(20,5,$Parcial_HContract+$Parcial_HTM,0,R,false);
			
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
	
	//  	  $dato=date_create($vto_date);
	//	  $af2=date_format($dato,'y/d/m');
	
	$consulta = "SELECT p.Nick_Name, pr.Codigo, pr.Nombre, a.Fecha, SUM(HContract) AS HContract, SUM(HTM) AS HTM ";
	$consulta = $consulta . " FROM personal p INNER JOIN actividad_personal ap ON  p.Empleado_ID=ap.Empleado_ID ";
	$consulta = $consulta . " INNER JOIN actividades a ON a.Actividad_ID=ap.Actividad_ID ";
	$consulta = $consulta . " INNER JOIN proyectos pr ON a.Pro_ID=pr.Pro_ID ";
	$consulta = $consulta . " WHERE a.Fecha>='".$af1."' AND  a.Fecha<='".$af2."' ";
	$consulta = $consulta . " GROUP BY p.Nick_Name, pr.Codigo, pr.Nombre, a.Fecha ";
	$consulta = $consulta . " ORDER BY p.Nick_Name, a.Fecha, pr.Codigo, pr.Nombre  ";
	
	//echo $consulta ;
	$result=$bd->ejecutar($consulta);
	// titulo del reporte
   	membrete($pdf,$vfrom_date);
	encabezado($pdf,$af1,$af2);

    if(mysql_num_rows($result)>0) 		 
	{
		$total_ordenado=0;
		$total_recibido=0;
		$total_usado=0;
		$total_balance=0;
		$bandera=1;	
		$bandera_2=1;
		$Nick_Name=0;
		while($row=mysql_fetch_array($result))
		{
			if (  ($Nick_Name!=$row["Nick_Name"] ) && ($bandera==0 ) )
			{				
				subtotal(&$pdf,$Parcial_HContract,$Parcial_HTM);
				$Nick_Name=$row["Nick_Name"];
				$bandera_2=1;						
			}	
			if($bandera==1)
			{
				$Nick_Name=$row["Nick_Name"];
				$bandera=0;
			}						
			if($bandera_2==1)
			{
				$aux=$pdf->GetX();
				$pdf->SetX(20);
				$pdf->Multicell(0,5,$row[Nick_Name],0,L,false);
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
			
			$pdf->Multicell(0,5,$row['Codigo'],0,L,false);
			$pdf->SetY($aux);
			$pdf->SetX(42);
			$pdf->Multicell(0,5,$row['Nombre'],0,L,false);
			$pdf->SetY($aux);					  
			$pdf->SetX(86);
			$pdf->Multicell(0,5,$fecha,0,L,false);
			$pdf->SetY($aux);
			$pdf->SetX(120);
			$pdf->Multicell(20,5,$row['HContract'],0,R,false);
			$pdf->SetY($aux);
			$pdf->SetX(140);					  
			$pdf->Multicell(20,5,$row['HTM'],0,R,false);
			$pdf->SetY($aux);
			$pdf->SetX(160);					  
			$pdf->Multicell(20,5,$row['HContract']+$row['HTM'],0,R,false);
			$aux6=$pdf->GetY();
			
			//sumas parciales por material
			$Parcial_HContract=$Parcial_HContract+$row["HContract"];
  			$Parcial_HTM=$Parcial_HTM+$row["HTM"];
			
			//sumas totales 			  
			$Total_HContract=$Total_HContract+$row["HContract"];
			$Total_HTM=$Total_HTM+$row["HTM"];
			
			
			if($aux6>=260)
			{
				$pdf->AddPage();
				membrete($pdf);
				encabezado($pdf,$af1,$af2);
			}
		}		
		
		subtotal(&$pdf,$Parcial_HContract,$Parcial_HTM);
		$pdf->line(10,$pdf->GetY(),200,$pdf->GetY());
		$pdf->Multicell(0,5,"",0,L,false);										
		$aux=$pdf->GetY();
		$pdf->Multicell(0,5,"Total General",0,L,false);
		$pdf->SetY($aux);
		$pdf->SetX(120);					  		  
		$pdf->Multicell(20,5,$Total_HContract,0,R,false);
		$pdf->SetY($aux);					  
		$pdf->SetX(140);					  
		$pdf->Multicell(20,5,$Total_HTM,0,R,false);	
		$pdf->SetY($aux);					  
		$pdf->SetX(160);					  
		$pdf->Multicell(20,5,$Total_HContract+$Total_HTM,0,R,false);			
	}	
	mysql_free_result($result);

	$pdf->Output("dato.pdf");
	?>
	<embed src="dato.pdf#toolbar=1&navpanes=0&scrollbar=0" width="990" height="570"></embed>
    <?
	require('Library/Close_Conexion.php');	
?>



