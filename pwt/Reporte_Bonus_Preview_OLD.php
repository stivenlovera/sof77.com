<?php
	session_name("Administrador");
	session_start();
	//*******************************************************************
	//Datos enviados por proyecto_reporte_material_0.php
	//******************************************************************	

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
		$pdf->SetFont('Arial','',10);
	}

	

	function encabezado(&$pdf,$Codigo_Bono,$Nick_Name)
	{	 
	  $pdf->Multicell(0,5,"Production Bonus ".$Codigo_Bono,0,C,false);
	  $pdf->Multicell(0,5,"Bonus:".$Codigo_Bono,0,L,false);
  	  $pdf->Multicell(0,5,"Employe:".$Nick_Name,0,L,false);
	  $pdf->Multicell(0,5,"",0,L,false);

  	  $aux=$pdf->GetY();
	  $pdf->SetX(20);
	  $pdf->Multicell(0,5,"# Job",0,L,false);

	  $pdf->SetY($aux);
	  $pdf->SetX(50);
	  $pdf->Multicell(20,5,"Job",0,C,false);

	  $pdf->SetY($aux);
	  $pdf->SetX(110);
	  $pdf->Multicell(20,5,"General Bonus",0,L,false);
	  
	  $pdf->SetY($aux);
	  $pdf->SetX(130);
	  $pdf->Multicell(20,5,"Hour Worked",0,L,false);

	  $pdf->SetY($aux);
	  $pdf->SetX(150);
	  $pdf->Multicell(20,5,"Bonus by Hours",0,C,false);

	  $pdf->SetY($aux);
	  $pdf->SetX(170);
	  $pdf->Multicell(30,5,"Totals",0,C,false);

  	  
	  $aux7=$pdf->GetY();
	  $pdf->line(10,$pdf->GetY()-5,200,$pdf->GetY()-5);
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

	  $pdf->SetY($aux);				  

	  $pdf->SetX(140);					  

	//  $pdf->Multicell(20,5,number_format(($Parcial_HTM),2),0,R,false);

	  $pdf->SetY($aux);

	  $pdf->SetX(160);					  

	  $pdf->Multicell(20,5,number_format(($Parcial_HContract+$Parcial_HTM),2),0,R,false);

			

   	  $pdf->line(130,$pdf->GetY(),200,$pdf->GetY());

   	  $pdf->Multicell(0,5,"",0,L,false);

	  $Parcial_Monto_Proyecto=0;
	  $Parcial_Monto_Total=0;

	}
	
	$Codigo_Bono=$_REQUEST["Codigo_Bono"];	
	
	$consulta = "SELECT pr.Pro_ID, pr.Monto_Bono, SUM(Indice_Produccion*HContract) AS HContract, SUM(Indice_Produccion*HTM) AS HTM ";

	$consulta = $consulta . " FROM personal p INNER JOIN actividad_personal ap ON  p.Empleado_ID=ap.Empleado_ID AND (p.aux5 ='f' || p.aux5 ='F') ";
	$consulta = $consulta . " INNER JOIN actividades a ON a.Actividad_ID=ap.Actividad_ID ";
	$consulta = $consulta . " INNER JOIN proyectos pr ON a.Pro_ID=pr.Pro_ID ";
	$consulta = $consulta . " WHERE (pr.Codigo_Bono='".$Codigo_Bono."')  ";
	$consulta = $consulta . " GROUP BY pr.Codigo";
	$consulta = $consulta . " ORDER BY pr.Nombre  ";	
	//echo $consulta ;

	$result=$bd->ejecutar($consulta);
    while($row=mysql_fetch_array($result))
	{
		$Pro_ID=$row["Pro_ID"];
		$Total_Horas=$row["HContract"]+$row["HTM"];
		$Indice_Global=$row["Monto_Bono"]/$Total_Horas;
		$consulta = "UPDATE proyectos SET Indice_Global='".$Indice_Global."' WHERE Pro_ID=".$Pro_ID;		
		$result32=$bd->ejecutar($consulta);
		
		//echo $Total_Horas."**".$row["Monto_Bono"]."**".$consulta."<br>";
	}
	mysql_free_result($result);
	
	$consulta = "SELECT p.Nick_Name,p.Apellido_Materno, p.aux5, p.Indice_Produccion, pr.Pro_ID, pr.Codigo, pr.Nombre, pr.Indice_Global, pr.Bono_General, ap.Note, a.Fecha, SUM(HContract) AS HContract, SUM(HTM) AS HTM ";

	$consulta = $consulta . " FROM personal p INNER JOIN actividad_personal ap ON  p.Empleado_ID=ap.Empleado_ID AND (p.aux5 ='f' || p.aux5 ='F') ";
	$consulta = $consulta . " INNER JOIN actividades a ON a.Actividad_ID=ap.Actividad_ID ";
	$consulta = $consulta . " INNER JOIN proyectos pr ON a.Pro_ID=pr.Pro_ID ";
	//$consulta = $consulta . " WHERE pr.Codigo_Bono='".$Codigo_Bono."'  ";
	//$consulta = $consulta . " GROUP BY p.Nick_Name, pr.Codigo, pr.Nombre, a.Fecha ";
	$consulta = $consulta . " GROUP BY p.Nick_Name, pr.Codigo, pr.Nombre ";
	$consulta = $consulta . " ORDER BY p.Apellido_Materno,p.Nick_Name, pr.Codigo, pr.Nombre  ";	

	//echo $consulta ;

	$result=$bd->ejecutar($consulta);
	// titulo del reporte
    if(mysql_num_rows($result)>0) 
	{

		$total_ordenado=0;
		$total_recibido=0;
		$total_usado=0;
		$total_balance=0;
		$bandera=1;	
		$bandera_2=1;
		$Nick_Name=0;
		
		$Parcial_Monto_Proyecto=0;
		$Parcial_Monto_Total=0;
		
		$Total_Monto_Proyecto=0;
		$Total_Monto_Total=0;
		$Pro_IDs="-7";

		while($row=mysql_fetch_array($result))
		{

			if (  ($Nick_Name!=$row["Nick_Name"] ) && ($bandera==0 ) )
			{
				
				$consulta = "SELECT Codigo, Nombre, Bono_General FROM proyectos WHERE Codigo_Bono='".$Codigo_Bono."'  ";
				$consulta = $consulta . " AND Pro_ID NOT IN (".$Pro_IDs.") ";
				//echo $consulta ;			
				$result99=$bd->ejecutar($consulta);
				while($row99=mysql_fetch_array($result99))
				{
					$aux=$pdf->GetY();
					$pdf->SetX(20);					
					$pdf->Multicell(0,5,$row99['Codigo'],0,L,false);
					$pdf->SetY($aux);
					$pdf->SetX(40);
					$pdf->Multicell(0,5,(substr(($row99['Nombre']),0,24)),0,L,false);
					$pdf->SetY($aux);
					
					$pdf->SetX(100);
					$pdf->Multicell(20,5,$row99["Bono_General"],0,R,false);
					$pdf->SetY($aux);
						
					$pdf->SetX(120);
					$pdf->Multicell(20,5,"0.00",0,R,false);					
					
					$pdf->SetY($aux);
					$pdf->SetX(150);
					$pdf->Multicell(20,5,"0.00",0,R,false);						
					
					$pdf->SetY($aux);
					$pdf->SetX(170);
					$pdf->Multicell(20,5,$row99["Bono_General"],0,R,false);
					$Parcial_Monto_Total=$Parcial_Monto_Total+$row99["Bono_General"];
				}
				mysql_free_result($result99);
				$Pro_IDs="-7";
	
				if ($Parcial_Monto_Total<0)
				{
					$aux=$pdf->GetY();
					$pdf->SetX(20);					
					$pdf->Multicell(0,5,"PW",0,L,false);
					$pdf->SetY($aux);
					$pdf->SetX(40);
					$pdf->Multicell(0,5,"AJUSTE",0,L,false);
					$pdf->SetY($aux);
					
					$pdf->SetX(100);
					$pdf->Multicell(20,5,"0.00",0,R,false);
					$pdf->SetY($aux);
						
					$pdf->SetX(120);
					$pdf->Multicell(20,5,"0.00",0,R,false);					
					
					$pdf->SetY($aux);
					$pdf->SetX(150);
					$pdf->Multicell(20,5,($Parcial_Monto_Proyecto*-1),0,R,false);						
					
					$pdf->SetY($aux);
					$pdf->SetX(170);
					$pdf->Multicell(20,5,($Parcial_Monto_Total*-1),0,R,false);
					$Parcial_Monto_Proyecto=$Parcial_Monto_Proyecto+($Parcial_Monto_Proyecto*-1);
					$Parcial_Monto_Total=$Parcial_Monto_Total+($Parcial_Monto_Total*-1);
				}
				
				$aux=$pdf->GetY();
				$pdf->line(100,$pdf->GetY(),200,$pdf->GetY());
				$pdf->SetX(100);
				$pdf->Multicell(0,5,"Total Payable",0,L,false);	 
				
				$pdf->SetY($aux);
				$pdf->SetX(150);	
				$pdf->Multicell(20,5,$Parcial_Monto_Proyecto,0,R,false);
				
				$pdf->SetY($aux);
				$pdf->SetX(170);	
				$pdf->Multicell(20,5,$Parcial_Monto_Total,0,R,false);
				

				$pdf->Multicell(20,5,"",0,R,false);
				$pdf->SetX(150);	
				$pdf->Multicell(40,5,"Date:". date('m-d-Y'),0,R,false);	
						
				$Parcial_Monto_Proyecto=0;				
				$Parcial_Monto_Total=0;
				///////// SUBTOTAL END 
				$Nick_Name=$row["Nick_Name"];
				$bandera_2=1;	
				$pdf->AddPage();				
			}	

			if($bandera==1)
			{
				$Nick_Name=$row["Nick_Name"];
				$bandera=0;
			}						

			if($bandera_2==1)
			{							
				membrete($pdf);
				encabezado($pdf,$Codigo_Bono,$Nick_Name);
				$bandera_2=0;
			}

			//********************************************************************
			// DETALLE

			//********************************************************************
			$aux=$pdf->GetY();
			$pdf->SetX(20);			
			$pdf->Multicell(0,5,$row['Codigo'],0,L,false);
			$pdf->SetY($aux);
			$pdf->SetX(40);
			$pdf->Multicell(0,5,(substr(($row['Nombre']),0,24)),0,L,false);
			$pdf->SetY($aux);
			
			$pdf->SetX(100);
			$pdf->Multicell(20,5,$row["Bono_General"],0,R,false);
			$pdf->SetY($aux);
				
			$pdf->SetX(120);
			$pdf->Multicell(20,5,number_format(($row['HContract']+$row['HTM']),2),0,R,false);
			
			
			$Monto_Proyecto= number_format(( ($row['HContract']+$row['HTM'])*$row['Indice_Produccion'] ) * $row['Indice_Global'],2);			
			$pdf->SetY($aux);
			$pdf->SetX(150);
			$pdf->Multicell(20,5,$Monto_Proyecto,0,R,false);						
			
			$pdf->SetY($aux);
			$pdf->SetX(170);
			$pdf->Multicell(20,5,$Monto_Proyecto+$row["Bono_General"],0,R,false);							  

			//sumas parciales por material
			
			$Pro_IDs=$Pro_IDs.", ".$row['Pro_ID'];

			$Parcial_Monto_Proyecto=$Parcial_Monto_Proyecto+$Monto_Proyecto;
			$Parcial_Monto_Total=$Parcial_Monto_Total+($Monto_Proyecto+$row["Bono_General"]);
			
			$Total_Monto_Proyecto=$Parcial_Monto_Proyecto+$Monto_Proyecto;
			$Total_Monto_Total=$Parcial_Monto_Total+$Monto_Proyecto;			
  			

			/*if($aux6>=260)
			{
				$pdf->AddPage();
				membrete($pdf);
				encabezado($pdf,$af1,$af2);
			}*/
		}	
		
		$consulta = "SELECT Codigo, Nombre, Bono_General FROM proyectos WHERE Codigo_Bono='".$Codigo_Bono."'  ";
		$consulta = $consulta . " AND Pro_ID NOT IN (".$Pro_IDs.") ";
		//echo $consulta ;			
		$result99=$bd->ejecutar($consulta);
		while($row99=mysql_fetch_array($result99))
		{
			$aux=$pdf->GetY();
			$pdf->SetX(20);
			$fecha=FormatDateTime($row99["Fecha"], 8);
			$pdf->Multicell(0,5,$row99['Codigo'],0,L,false);
			$pdf->SetY($aux);
			$pdf->SetX(40);
			$pdf->Multicell(0,5,(substr(($row99['Nombre']),0,24)),0,L,false);
			$pdf->SetY($aux);
			
			$pdf->SetX(100);
			$pdf->Multicell(20,5,$row99["Bono_General"],0,R,false);
			$pdf->SetY($aux);
				
			$pdf->SetX(120);
			$pdf->Multicell(20,5,"0.00",0,R,false);					
			
			$pdf->SetY($aux);
			$pdf->SetX(150);
			$pdf->Multicell(20,5,"0.00",0,R,false);						
			
			$pdf->SetY($aux);
			$pdf->SetX(170);
			$pdf->Multicell(20,5,$row99["Bono_General"],0,R,false);
			$Parcial_Monto_Total=$Parcial_Monto_Total+$row99["Bono_General"];
		}
		mysql_free_result($result99);
		
		if ($Parcial_Monto_Total<0)
		{
			$aux=$pdf->GetY();
			$pdf->SetX(20);					
			$pdf->Multicell(0,5,"PW",0,L,false);
			$pdf->SetY($aux);
			$pdf->SetX(40);
			$pdf->Multicell(0,5,"AJUSTE",0,L,false);
			$pdf->SetY($aux);
			
			$pdf->SetX(100);
			$pdf->Multicell(20,5,"0.00",0,R,false);
			$pdf->SetY($aux);
				
			$pdf->SetX(120);
			$pdf->Multicell(20,5,"0.00",0,R,false);					
			
			$pdf->SetY($aux);
			$pdf->SetX(150);
			$pdf->Multicell(20,5,($Parcial_Monto_Proyecto*-1),0,R,false);						
			
			$pdf->SetY($aux);
			$pdf->SetX(170);
			$pdf->Multicell(20,5,($Parcial_Monto_Total*-1),0,R,false);
			$Parcial_Monto_Proyecto=$Parcial_Monto_Proyecto+($Parcial_Monto_Proyecto*-1);
			$Parcial_Monto_Total=$Parcial_Monto_Total+($Parcial_Monto_Total*-1);
		}
				
		$aux=$pdf->GetY();
		$pdf->line(130,$pdf->GetY(),200,$pdf->GetY());
		$pdf->SetX(100);
		$pdf->Multicell(0,5,"Subtotal",0,L,false);	 
		
		$pdf->SetY($aux);
		$pdf->SetX(150);	
		$pdf->Multicell(20,5,$Parcial_Monto_Proyecto,0,R,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(170);	
		$pdf->Multicell(20,5,$Parcial_Monto_Total,0,R,false);		
	}	

	mysql_free_result($result);
	$pdf->Output("dato.pdf");
?>

	<embed src="dato.pdf#toolbar=1&navpanes=0&scrollbar=0" width="1190" height="570"></embed>

<?
	require('Library/Close_Conexion.php');	
?>







