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
	
	function membrete(&$pdf,$pnombre)
	{
		//ENCABEZADO
		$pdf->SetFont('Arial','',8);
		$pdf->Image('images/logo.png',5,5,30,10,"png");
		$pdf->SetY(15);
		$pdf->SetX(10);
		$pdf->Multicell(0,3,"Name Proyect:".$pnombre,0,L,false);
		$pdf->SetX(10);
		/*$pdf->Multicell(0,3,"PO: ",0,L,false);

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
	  $pdf->Multicell(0,5,"Report: Totals Hours By Person -",0,C,false);
  	  $pdf->Multicell(0,5,"from:".$f1." to:".$f2,0,C,false);
  	  $pdf->Multicell(0,5,"",0,L,false);
	  // titulo del detall	  
  	  $aux=$pdf->GetY();
	  $pdf->SetX(20);
	  $pdf->Multicell(0,5,"Nick Name",0,L,false);
	  $pdf->SetY($aux);
	  $pdf->SetX(42);
	  //$pdf->Multicell(0,5,"Complete Name",0,L,false);	  
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
	  $pdf->SetY($aux7+10);
	  
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
	
	$consulta = "SELECT p.Empleado_ID, p.Nick_Name, p.Nombre,p.Aux5,p.Numero, p.Apellido_Paterno, p.Apellido_Materno,p.Cargo,p.email,p.Celular, pr.Codigo,pr.Nombre as pnombre, SUM(rda.Horas_Contract) AS HContract, SUM(rda.Horas_TM) AS HTM ";
	$consulta = $consulta . " FROM personal p INNER JOIN actividad_personal ap ON  p.Empleado_ID=ap.Empleado_ID ";
	$consulta = $consulta . " INNER JOIN actividades a ON a.Actividad_ID=ap.Actividad_ID ";
	$consulta = $consulta . " INNER JOIN proyectos pr ON a.Pro_ID=pr.Pro_ID ";
	$consulta = $consulta . " inner join registro_diario rd on rd.Actividad_Id=a.Actividad_ID and rd.Empleado_ID=p.Empleado_ID inner JOIN registro_diario_actividad rda on rda.Reg_ID=rd.Reg_ID ";
	
	$consulta = $consulta . " WHERE a.Fecha>='".$af1."' AND  a.Fecha<='".$af2."' and (substring(pr.Codigo,1,3)<900 or '".$Pro_ID_Reporte."'>0)";
	if ($Nombre_Empleado<>"")
		$consulta=$consulta." and p.Aux5='".$Nombre_Empleado."'";
//	$consulta = $consulta . " WHERE (p.Aux5='F' OR p.Aux5='FS') AND a.Fecha>='".$af1."' AND  a.Fecha<='".$af2."' ";
//echo 	$Pro_ID_Reporte."<br>";
	if ($Pro_ID_Reporte!=-33 and $Pro_ID_Reporte!=-44 )	
		$consulta = $consulta . " AND pr.Pro_ID=$Pro_ID_Reporte ";		
	
	
	
//	$consulta = $consulta . " and (p.Nick_Name like '%$Nick_Name%'  )  GROUP BY pr.Pro_ID  ";
	
	if ($Pro_ID_Reporte==-44)
			$consulta = $consulta . " GROUP BY pr.Pro_ID,Nick_Name, p.Nombre,  p.Apellido_Paterno, p.Apellido_Materno ";
	   else 
			$consulta = $consulta . " GROUP BY p.Nick_Name, p.Nombre,  p.Apellido_Paterno, p.Apellido_Materno ";
	
	
	if ( ($Nombre_Empleado!="") || 	($Nick_Name!="") )
	{
		$consulta = $consulta . " HAVING 1=1 ";
	
		if ($Nombre_Empleado!="")	
			$consulta = $consulta . " AND p.Aux5  like '%$Nombre_Empleado%' ";
		
		if ($Nick_Name!="")	
			$consulta = $consulta . " AND ((p.Nick_Name like '%$Nick_Name%') OR (p.Nombre like '%$Nick_Name%'  )) ";
	}
	
	$consulta = $consulta . " ORDER BY p.Aux5,  HContract DESC,p.Numero,pr.Codigo,p.Nick_Name"; 
	
	//echo $consulta ;
	$result=$bd->ejecutar($consulta);
	
    if(mysqli_num_rows($result)>0) 		 
	{
		$total_ordenado=0;
		$total_recibido=0;
		$total_usado=0;
		$total_balance=0;
		$bandera=1;	
		$bandera_2=1;
		$Nick_Name=0;
		$Nroaux=0;
		if ($Pro_ID_Reporte>0) 
		{
			//$row1=mysqli_fetch_array($result);
			//$pnombre=$row['Codigo']."  ".$row1['pnombre'];
		}
		else 
			$pnombre=" All Projects";
		// titulo del reporte
		membrete($pdf,$pnombre);
		encabezado($pdf,$af1,$af2);
	
		while($row=mysqli_fetch_array($result))
		{

			//********************************************************************
			// DETALLE
			//********************************************************************
			$active=" ";
			$codigox=substr( $row['Codigo'],0,3);
			//echo $row['Codigo']." ".$codigox."<br>";
			$auxf=($row['Aux5'])."Z   ";
			$auxf=(substr($auxf,0,2));
			if ($auxf != "FY" AND $auxf != "FX" AND $auxf != "FS" AND $auxf != "FZ" AND $auxf != "FU")
			     $active ="X ";
			if ($auxf =="FS")
			     $active="Sub ";
			if ($auxf =="FU")
			     $active="Uni ";
			if ($auxf =="FY")
			     $active="Of.";
			if ($auxf =="FX")
			     $active="FR ";
		//	if ($codigox>900)
			//{
				//echo $row['Codigo']." ".$codigox."<br>";
				//$active="Off ";
			//}
				 
				 
	 
			$Nroaux=$Nroaux+1;
			$cargo=$row['Cargo'];  
			$cargo=substr($cargo, -3, -1);  
			if (($cargo <>"L1") and ($cargo <>"L2") and $cargo <>"L3")
			     $cargo="     ";
			$aux=$pdf->GetY();
			$pdf->SetX(5);	
// para numerar empleados
			$pdf->Multicell(0,7,$active.number_format(($Nroaux),0),0,L,false);
// fin numerar empleados
			$pdf->SetY($aux);
			$pdf->SetX(17);
			$pdf->Multicell(50,5,$cargo."  |".$row['Nick_Name'],0,L,false);
			$pdf->SetY($aux);
			$pdf->SetX(73);
			
			if ($Pro_ID_Reporte==-44)
				$Aux5="|".$row["Codigo"]." |".substr($row['pnombre'],0,60)." |";		
			 else
				$Aux5="|".$row['Numero']." |".$row['email']."| Cel:".$row['Celular'];
			//$Aux5=$row['Numero']." ".$row['Aux5'].$row['email']." ".$row['Celular'];
			$pdf->Multicell(110,5," ".$Aux5." ",0,L,false);			
			//$pdf->Multicell(0,5,$row['Nombre']." ".$row['Apellido_Paterno']." ".$row['Apellido_Materno'],0,L,false);			
			$pdf->SetY($aux);
			$pdf->SetX(120);
			//$pdf->Multicell(20,5,number_format(($row['HContract']),2),0,R,false);
			$pdf->SetY($aux);
			$pdf->SetX(140);					  
			//$pdf->Multicell(20,5,number_format(($row['HTM']),2),0,R,false);
			$pdf->SetY($aux);
			$pdf->SetX(175);					  
			$pdf->Multicell(20,5,"|  ".number_format(($row['HContract']+$row['HTM']),2),0,R,false);
			$aux6=$pdf->GetY();			
			//sumas totales 			  
			$Total_HContract=$Total_HContract+$row["HContract"];
			$Total_HTM=$Total_HTM+$row["HTM"];
			// inicio actualizacion de horas para ayuda
			$f1=FormatDateTime($vfrom_date, 8);
	  		$f2=FormatDateTime($vto_date, 8);
			$f1=FormatDateTime($f1, 8);
	  		$f2=FormatDateTime($f2, 8);
			$f3=date("m-d-Y");
			$aux2=" /Hrs.".($row['HContract']+$row['HTM'])." from:".$f1." to:".$f2."/Updated:".$f3;
			//echo $aux1;
			$strSQL = "UPDATE personal SET Aux2='".$aux2."' WHERE Empleado_ID=".$row['Empleado_ID'];
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);
			
			
			
			/// fin actualizacion de horas
			
			
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
		$pdf->Multicell(0,5,"Total General:",0,L,false);
		$pdf->SetY($aux);
		$pdf->SetX(120);					  		  
		//$pdf->Multicell(20,5,number_format(($Total_HContract),2),0,R,false);
		$pdf->SetY($aux);					  
		$pdf->SetX(140);					  
		//$pdf->Multicell(20,5,number_format(($Total_HTM),2),0,R,false);	
		$pdf->SetY($aux);					  
		$pdf->SetX(175);					  
		$pdf->Multicell(20,5,number_format(($Total_HContract+$Total_HTM),2),0,R,false);			
	}	
	mysqli_free_result($result);

	$pdf->Output("dato.pdf");
	?>
	<embed src="dato.pdf#toolbar=1&navpanes=0&scrollbar=0" width="1000" height="570"></embed>
    <?
	require('Library/Close_Conexion.php');	
?>



