<?php
	session_name("Administrador");
	session_start();

	//*******************************************************************
	//Datos enviados por proyecto_reporte_material_0.php
	//******************************************************************

	$vfrom_date=$_REQUEST["Fecha_Inicio_Busqueda"];
	$vto_date=$_REQUEST["Fecha_Fin_Busqueda"];
	$Pro_ID_Reporte=$_REQUEST["Pro_ID_Reporte"];
	$Campo=$_REQUEST["Nombre_Empleado"];
	$Nick=$_REQUEST["Nick"];			

	require('Library/Control_Cache.php');
	require('Library/Open_Conexion.php');
	require('Library/funciones.php');
		

	// INSERTADO POR FABIOLA CARRASCO

	require('pdf/fpdf.php');
	$pdf=new FPDF('L','mm','oficio');
	$pdf->AddPage();

	// DEFINICION DE FUNCIONES DE CABEZERA DE SUBCUEPO

	$pdf->SetMargins(15,15,15,15);
	$pdf->SetFont('Arial','',7);
	$pdf->SetLineWidth(0.5);
	$pdf->Setfillcolor(237,243,120);

	

	function membrete(&$pdf)
	{
		//ENCABEZADO

		$pdf->SetFont('Arial','',7);
		$pdf->Image('images/logo.png',5,5,30,10,"png");	
		$pdf->SetFont('Arial','',7);
	}

	

	function encabezado(&$pdf,$f1,$f2)
	{
	  $f1=FormatDateTime($f1, 8);
	  $f2=FormatDateTime($f2, 8);  	  
	  
	  $pdf->Multicell(0,5,"Superintendent daily report records",0,C,false);
  	  $pdf->Multicell(0,5,"from:".$f1." to:".$f2,0,C,false);  	  

	  // titulo del detall	  

  	  $aux=$pdf->GetY();
	  $pdf->SetX(10);
	  $pdf->Multicell(25,5,"# Superintendent",0,L,false);
	  
	  $pdf->SetY($aux);
	  $pdf->SetX(35);
	  $pdf->Multicell(10,5,"Date",0,L,false);

	  $pdf->SetY($aux);
	  $pdf->SetX(50);
	  $pdf->Multicell(35,5,"Job",0,L,false);
	  
	  $pdf->SetY($aux);
	  $pdf->SetX(80);
	  $pdf->Multicell(15,5,"Coming of the ground",0,C,false);
	 
	  $pdf->SetY($aux);
	  $pdf->SetX(93);
	  $pdf->Multicell(12,5,"Freming",0,C,false);
	 
	  $pdf->SetY($aux);
	  $pdf->SetX(105);
	  $pdf->Multicell(12,5,"Hanging DryWall",0,L,false);
	 
	  $pdf->SetY($aux);
	  $pdf->SetX(117);
	  $pdf->Multicell(10,5,"Next Visit",0,L,false);
	 
	  $pdf->SetY($aux);
	  $pdf->SetX(132);
	  $pdf->Multicell(17,5,"Find Schedule",0,L,false);
	 
	  $pdf->SetY($aux);
	  $pdf->SetX(150);
	  $pdf->Multicell(25,5,"Find to Paint hidden items",0,L,false);
	 
	  $pdf->SetY($aux);
	  $pdf->SetX(175);
	  $pdf->Multicell(17,5,"Find start date to paint",0,L,false);
	 
	  $pdf->SetY($aux);
	  $pdf->SetX(192);
	  $pdf->Multicell(25,5,"Actual Working Areas",0,L,false);
	 
	  $pdf->SetY($aux);
	  $pdf->SetX(221);
	  $pdf->Multicell(15,5,"Quality",0,L,false);
	 
	  $pdf->SetY($aux);
	  $pdf->SetX(242);
	  $pdf->Multicell(20,5,"Perception of Production Rate",0,L,false);
	 
	  $pdf->SetY($aux);
	  $pdf->SetX(267);
	  $pdf->Multicell(20,5,"Coments",0,L,false);
	 
	  $pdf->SetY($aux);
	  $pdf->SetX(287);
	  $pdf->Multicell(20,5,"Action Take or need be take",0,L,false);
	 
	  $pdf->SetY($aux);
	  $pdf->SetX(312);
	  $pdf->Multicell(20,5,"Miscellaneus",0,L,false);
	  
	  
	  $aux7=$pdf->GetY();

	  $pdf->line(10,$pdf->GetY()-5,330,$pdf->GetY()-5);

  	  $pdf->line(10,$aux+10,330,$aux+10);

	  $pdf->SetY($aux7+5);

	  

	}		

	$vdia=substr($vfrom_date,3,2);
	$vmes=substr($vfrom_date,0,2);
	$vano=substr($vfrom_date,8,2);
	$af1="20".$vano."-".$vmes."-".$vdia;

	

	$vdia=substr($vto_date,3,2);
	$vmes=substr($vto_date,0,2);
	$vano=substr($vto_date,8,2);
	$af2="20".$vano."-".$vmes."-".$vdia;

	

	$consulta = "SELECT *, p.Nombre as Proyecto, CONCAT(em.Nombre, ' ', em.Apellido_Paterno, ' ',  em.Apellido_Materno) AS Empleado ";
	$consulta = $consulta . " FROM informe_proyecto i INNER JOIN proyectos p ON i.Pro_ID=p.Pro_ID ";
	$consulta = $consulta . " INNER JOIN personal em ON em.Empleado_ID=i.Empleado_ID ";	
	$consulta = $consulta . " WHERE i.Fecha>='".$af1."' AND  i.Fecha<='".$af2."' ";
	

	if ($Pro_ID_Reporte!=-33)	
		$consulta = $consulta . " AND i.Pro_ID=$Pro_ID_Reporte ";	
		
	if ($Nick!="")	
		$consulta = $consulta . " AND em.Nick_Name='".$Nick."' ";	
			

	if ($campo!="")	
		$consulta = $consulta . $campo;
	
	$consulta = $consulta . " ORDER BY i.Fecha ";	

	//echo $consulta ;
	$result=$bd->ejecutar($consulta);
	// titulo del reporte

   	membrete($pdf,$vfrom_date);
	encabezado($pdf,$af1,$af2);
	$cont=0;
    if(mysqli_num_rows($result)>0) 
	{		

		while($row=mysqli_fetch_array($result))
		{			 
			$fecha=FormatDateTime($row["Fecha"], 7);
			
			if ( ($row["Check_coming"]) || ($row["Check_coming"]==1)  )
				$Check_coming="|X|";
			else
				$Check_coming="| |";
			
			if ( ($row["Check_framing"]) || ($row["Check_framing"]==1)  )
				$Check_framing="|X|";
			else
				$Check_framing="| |";
				
			if ( ($row["Check_hanging"]) || ($row["Check_hanging"]==1)  )
				$Check_hanging="|X|";
			else
				$Check_hanging="| |";					
			
			$Date_Check_coming=FormatDateTime($row["Date_Check_coming"], 7);
			
			if ( ($row["Check_construction"]) || ($row["Check_construction"]==1)  )
				$Check_construction="|X|";
			else
				$Check_construction="| |";					

			$others=$row["others"];
			
			//$Date_estimate=FormatDateTime($row["Date_estimate"], 7);
//			$Date_actual=FormatDateTime($row["Date_actual"], 7);
//			$DAte_finally=FormatDateTime($row["DAte_finally"], 7);
			
			$pwt_actual=$row["pwt_actual"];
			$pwt_quality=$row["pwt_quality"];
			$pwt_production_rate=$row["pwt_production_rate"];
			$pwt_comments=$row["pwt_comments"];
			$pwt_action=$row["pwt_action"];
			$pwt_miscellaneous=$row["pwt_miscellaneous"];			
			
			if ( ($row["Check_quality"]) || ($row["Check_quality"]==1)  )
				$Check_quality="|X|";
			else
				$Check_quality="| |";					

			$text_Check_quality=$row["text_Check_quality"];
			
			if ( ($row["Check_discuse"]) || ($row["Check_discuse"]==1)  )
				$Check_discuse="|X|";
			else
				$Check_discuse="| |";					

			$text_Check_discuse=$row["text_Check_discuse"];
			
			if ( ($row["Check_control"]) || ($row["Check_control"]==1)  )
				$Check_control="|X|";
			else
				$Check_control="| |";					

			$text_Check_control=$row["text_Check_control"];		
			
			//********************************************************************
			// DETALLE
			//********************************************************************
			
			$aux=$pdf->GetY();
			$pdf->SetX(10);
			$pdf->Multicell(25,5,$row['Empleado'],0,L,false);
			
			$pdf->SetY($aux);
			$pdf->SetX(30);
			$pdf->Multicell(15,5,$fecha,0,L,false);

			$pdf->SetY($aux);
			$pdf->SetX(45);
			$pdf->Multicell(35,5,$row["Proyecto"],0,L,false);
			
			$pdf->SetY($aux);
			$pdf->SetX(82);
			$pdf->Multicell(5,5,$Check_coming,0,C,false);
			
			$pdf->SetY($aux);
			$pdf->SetX(93);
			$pdf->Multicell(5,5,$Check_framing,0,C,false);
			
			$pdf->SetY($aux);
			$pdf->SetX(104);
			$pdf->Multicell(5,5,$Check_hanging,0,C,false);
			
			$pdf->SetY($aux);
			$pdf->SetX(115);
			$pdf->Multicell(15,5,$Date_Check_coming,0,C,false);
			
			$pdf->SetY($aux);
			$pdf->SetX(130);
			$pdf->Multicell(15,5,$Check_construction,0,C,false);
			
			$pdf->SetY($aux);
			$pdf->SetX(145);
			$pdf->Multicell(20,5,$others,0,L,false);
			
			$pdf->SetY($aux);
			$pdf->SetX(172);
			$pdf->Multicell(19,5,"E:".$Date_estimate." A:".$Date_actual. "End:".$DAte_finally,0,L,false);				
			
			$pdf->SetY($aux);
			$pdf->SetX(191);
			$pdf->Multicell(20,5,$pwt_actual,0,L,false);
			
			$pdf->SetY($aux);
			$pdf->SetX(215);
			$pdf->Multicell(20,5,$pwt_quality,0,L,false);
			
			$pdf->SetY($aux);
			$pdf->SetX(245);
			$pdf->Multicell(20,5,$pwt_production_rate,0,L,false);
			
			$pdf->SetY($aux);
			$pdf->SetX(265);
			$pdf->Multicell(20,5,$pwt_comments,0,L,false);
			
			$pdf->SetY($aux);
			$pdf->SetX(285);
			$pdf->Multicell(20,5,$pwt_action,0,L,false);
			
			$pdf->SetY($aux);
			$pdf->SetX(310);
			$pdf->Multicell(30,5,$pwt_miscellaneous,0,L,false);					
			
			$pdf->SetX(82);
			$pdf->Multicell(5,5,$Check_quality,0,C,false);
			$pdf->SetX(87);
			$pdf->Multicell(50,5,$text_Check_quality,0,L,false);
			
			$pdf->SetX(82);
			$pdf->Multicell(5,5,$Check_discuse,0,C,false);
			$pdf->SetX(87);
			$pdf->Multicell(50,5,$text_Check_discuse,0,L,false);
			
			$pdf->SetX(82);
			$pdf->Multicell(5,5,$Check_control,0,C,false);
			$pdf->SetX(87);
			$pdf->Multicell(50,5,$text_Check_control,0,L,false);
			
			$pdf->SetFont('Arial','B',7);
			$pdf->SetX(82);
			$pdf->Multicell(50,5,"GC an other trades work:",0,l,false);	
			$pdf->SetFont('Arial','',7);
			
			$pdf->SetX(82);
			$pdf->Multicell(50,5,$row['gc'],0,l,false);	
			$pdf->SetX(82);
			$pdf->Multicell(50,5,$row['gc_action'],0,l,false);	
			$pdf->SetX(82);
			$pdf->SetFont('Arial','B',7);
			$pdf->Multicell(50,5,"Other trades work:",0,l,false);
			$pdf->SetFont('Arial','',7);
			
			$pdf->SetX(82);
			$pdf->Multicell(50,5,$row['quality_comments'],0,l,false);	
			$pdf->SetX(82);
			$pdf->Multicell(50,5,$row['quality_action_taken'],0,l,false);	
			$pdf->SetX(82);
			$pdf->Multicell(50,5,$row['Drywall'],0,l,false);	
			$pdf->SetX(82);
			$pdf->Multicell(50,5,$row['Drywall_comments'],0,l,false);	
			$pdf->SetX(82);
			$pdf->Multicell(50,5,$row['Drywall_action_taken'],0,l,false);	
			$cont++;		

			if($cont>=2)
			{
				$pdf->AddPage();
				membrete($pdf);
				encabezado($pdf,$af1,$af2);
				$cont=0;
			}
		}	
	}	

	mysqli_free_result($result);
	$pdf->Output("dato.pdf");
?>
	<embed src="dato.pdf#toolbar=1&navpanes=0&scrollbar=0" width="1190" height="570"></embed>
<?
	require('Library/Close_Conexion.php');	

?>







