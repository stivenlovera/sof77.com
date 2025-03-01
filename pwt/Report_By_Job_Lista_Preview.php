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

		

	echo "// INSERTADO POR FABIOLA CARRASCO";
	exit();

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

	  $pdf->Multicell(0,5,"Report: Hours Person by Job",0,C,false);

  	  $pdf->Multicell(0,5,"from:".$f1." to:".$f2,0,C,false);

  	  $pdf->Multicell(0,5,"",0,L,false);

	  // titulo del detall	  

  	  $aux=$pdf->GetY();

	  $pdf->SetX(20);

	  $pdf->Multicell(0,5,"Nick Name",0,L,false);

	  $pdf->SetY($aux);

	  $pdf->SetX(60);

	  $pdf->Multicell(0,5,"Name",0,L,false);

	  $pdf->SetY($aux);

	  $pdf->SetX(114);

	  $pdf->Multicell(0,5,"Date",0,L,false);

	  $pdf->SetY($aux);

	  $pdf->SetX(140);

	  $pdf->Multicell(25,5,"Hours in Contract",0,C,false);

	  $pdf->SetY($aux);

	  $pdf->SetX(160);

	  $pdf->Multicell(25,5,"Hours in Ticket Work",0,C,false);

	  $pdf->SetY($aux);

	  $pdf->SetX(183);

	  $pdf->Multicell(20,5,"    Total   Hours",0,C,false);



	  $aux7=$pdf->GetY();

	  $pdf->line(10,$pdf->GetY()-10,200,$pdf->GetY()-10);

  	  $pdf->line(10,$aux+10,200,$aux+10);

	  $aux7=$pdf->GetY()+5;

	  $pdf->SetY($aux7);

	  

	}

		

	function subtotal(&$pdf,&$Parcial_HContract,&$Parcial_HTM)

	{

	  $aux=$pdf->GetY();

  	  $pdf->line(130,$pdf->GetY(),200,$pdf->GetY());

	  $pdf->SetX(100);

	  $pdf->Multicell(0,5,"Subtotal",0,L,false);

	  $pdf->SetY($aux);

	  $pdf->SetX(140);					  

	  $pdf->Multicell(20,5,number_format(($Parcial_HContract),2),0,R,false);

	  $pdf->SetY($aux);					  

	  $pdf->SetX(160);					  

	  $pdf->Multicell(20,5,number_format(($Parcial_HTM),2),0,R,false);

	  $pdf->SetY($aux);					  

	  $pdf->SetX(180);					  

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

	

	//  	  $dato=date_create($vto_date);

		  $af2=date_format($dato,'y/d/m');
exit ();
	

	$consulta = "SELECT pr.Pro_ID, pr.Codigo, pr.Nombre As Proyecto, p.Nick_Name, p.Nombre, p.Apellido_Paterno, a.Fecha, SUM(HContract) AS HContract, SUM(HTM) AS HTM ";

	$consulta = $consulta . " FROM personal p INNER JOIN actividad_personal ap ON  p.Empleado_ID=ap.Empleado_ID ";

	$consulta = $consulta . " INNER JOIN actividades a ON a.Actividad_ID=ap.Actividad_ID ";

	$consulta = $consulta . " INNER JOIN proyectos pr ON a.Pro_ID=pr.Pro_ID ";

	$consulta = $consulta . " WHERE a.Fecha>='".$af1."' AND  a.Fecha<='".$af2."' ";

if ($Pro_ID_Reporte!=-33)	

		$consulta = $consulta . " AND pr.Pro_ID=$Pro_ID_Reporte ";

		

	$consulta = $consulta . " GROUP BY pr.Pro_ID, pr.Codigo, pr.Nombre, p.Nick_Name, a.Fecha ";

	$consulta = $consulta . " ORDER BY pr.Pro_ID, pr.Codigo, a.Fecha, pr.Nombre, p.Nick_Name ";

	

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

		$Pro_ID=0;

		while($row=mysqli_fetch_array($result))

		{

			if (  ($Pro_ID!=$row["Pro_ID"] ) && ($bandera==0 ) )

			{				

				subtotal(&$pdf,$Parcial_HContract,$Parcial_HTM);

				$Pro_ID=$row["Pro_ID"];

				$bandera_2=1;						

			}	

			if($bandera==1)

			{

				$Pro_ID=$row["Pro_ID"];

				$bandera=0;

			}						

			if($bandera_2==1)

			{

				$aux=$pdf->GetX();

				$pdf->SetX(10);

				$pdf->Multicell(0,5,$row[Codigo]."-".$row[Proyecto],0,L,false);

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

			

			$pdf->Multicell(0,5,$row['Nick_Name'],0,L,false);

			$pdf->SetY($aux);

			$pdf->SetX(60);

			$pdf->Multicell(0,5,$row['Nombre']." ".$row['Apellido_Paterno'],0,L,false);

			$pdf->SetY($aux);					  

			$pdf->SetX(105);

			$pdf->Multicell(0,5,$fecha,0,L,false);

			$pdf->SetY($aux);

			$pdf->SetX(140);

			$pdf->Multicell(20,5,number_format(($row['HContract']),2),0,R,false);

			$pdf->SetY($aux);

			$pdf->SetX(160);					  

			$pdf->Multicell(20,5,number_format(($row['HTM']),2),0,R,false);

			$pdf->SetY($aux);

			$pdf->SetX(180);					  

			$pdf->Multicell(20,5,number_format(($row['HContract']+$row['HTM']),2),0,R,false);

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

		$pdf->SetX(140);					  		  

		$pdf->Multicell(20,5,number_format(($Total_HContract),2),0,R,false);

		$pdf->SetY($aux);					  

		$pdf->SetX(160);					  

		$pdf->Multicell(20,5,number_format(($Parcial_HTM),2),0,R,false);			

		$pdf->SetY($aux);					  

		$pdf->SetX(180);					  

		$pdf->Multicell(20,5,number_format(($Total_HContract+$Total_HTM),2),0,R,false);			

	}	

	mysqli_free_result($result);



	$pdf->Output("dato.pdf");

	?>

	<embed src="dato.pdf#toolbar=1&navpanes=0&scrollbar=0" width="1190" height="570"></embed>

    <?

	require('Library/Close_Conexion.php');	

?>







