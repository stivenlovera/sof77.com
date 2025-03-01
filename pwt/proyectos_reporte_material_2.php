<?php
	session_name("Administrador");
	session_start();
	//*******************************************************************
	//Datos enviados por proyecto_reporte_material_0.php
	//******************************************************************
	$vfrom_date=$_REQUEST["vfrom_date"];
	$vto_date=$_REQUEST["vto_date"];
	$Pro_ID_Reporte=$_REQUEST["Pro_ID_Reporte"];
	$Nombre_Material=$_REQUEST["Nombre_Material"];
	
		
	require('Library/Control_Cache.php');	
	require('Library/Open_Conexion.php');	
	// INSERTADO POR FABIOLA CARRASCO
	require('pdf/fpdf.php');
	$pdf=new FPDF('L','mm','Letter');
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
	}
	
	function encabezado(&$pdf,$f1,$f2)
	{
  	  $pdf->Multicell(0,5,"",0,L,false);
	  $pdf->Multicell(0,5,"Details of materials ordered and used",0,C,false);
  	  $pdf->Multicell(0,5,"from:".$f1." to:".$f2,0,C,false);
  	  $pdf->Multicell(0,5,"",0,L,false);
	  // titulo del detall	  
  	  $aux=$pdf->GetY();
	  $pdf->SetX(20);
	  $pdf->Multicell(110,5,"Description",0,L,false);
	  $pdf->SetY($aux);
	  $pdf->SetX(130);
	  $pdf->Multicell(20,5,"U.Med.",0,L,false);
	  $pdf->SetY($aux);
	  $pdf->SetX(150);
	  $pdf->Multicell(25,5,"Ordered",0,C,false);
	  $pdf->SetY($aux);
	  $pdf->SetX(175);
	  $pdf->Multicell(25,5,"Recived",0,C,false);
	  $pdf->SetY($aux);
	  $pdf->SetX(200);
	  $pdf->Multicell(15,5,"Used",0,C,false);
  	  $pdf->SetY($aux);
  	  $pdf->SetX(215);
	  $pdf->Multicell(30,5,"Ordered - Received",0,C,false);
	  $pdf->SetY($aux);
  	  $pdf->SetX(240);
	  $pdf->Multicell(30,5,"Received - Used",0,C,false);
	  $aux7=$pdf->GetY();
	  $pdf->line(10,$pdf->GetY()-7,265,$pdf->GetY()-7);
  	  $pdf->line(10,$aux+5,265,$aux+5);
	  $pdf->SetY($aux7+3);
	  
	}
	
	function subtotal(&$pdf,&$parcial_ordenado,&$parcial_recibido,&$parcial_usado,&$parcial_balance,$vproducto,$vmedida,&$parcial_balance_1,&$parcial_balance_2)
	{
	  $aux=$pdf->GetY();
  	  //$pdf->line(10,$pdf->GetY(),200,$pdf->GetY());
	  $pdf->SetX(20);
	  $pdf->Multicell(110,5,$vproducto,0,L,false);
	  $aux33=$pdf->GetY();
	  $pdf->SetY($aux);
	  $pdf->SetX(130);		  				  
	  $pdf->Multicell(15,5,$vmedida,0,L,false);
	  $pdf->SetY($aux);
	  $pdf->SetX(145);					  
	  $pdf->Multicell(25,5,$parcial_ordenado,0,R,false);
	  $pdf->SetY($aux);					  
	  $pdf->SetX(170);					  
	  $pdf->Multicell(25,5,$parcial_recibido,0,R,false);
	  $pdf->SetY($aux);
	  $pdf->SetX(195);					  
	  $pdf->Multicell(20,5,$parcial_usado,0,R,false);
	  $pdf->SetY($aux);
	  $pdf->SetX(215);					  
	  $pdf->Multicell(20,5,$parcial_balance_1,0,R,false);
	  $pdf->SetY($aux);
	  $pdf->SetX(240);					  
	  $pdf->Multicell(20,5,$parcial_balance_2,0,R,false);	
	  
	  $pdf->SetY($aux33);							
	  $parcial_ordenado=0;
	  $parcial_recibido=0;
	  $parcial_usado=0;
	  $parcial_balance=0;
	  $parcial_balance_1=0;
	  $parcial_balance_2=0;								
	}
	  $vdia=substr($vfrom_date,3,2);
  	  $vmes=substr($vfrom_date,0,2);
  	  $vano=substr($vfrom_date,8,2);
	   
//	  $dato=date_create($vfrom_date);
//	  $af1=date_format($dato,'y/d/m');
	  $af1=$vano."/".$vmes."/" .$vdia;
	  $af1x=$vmes."/" .$vdia."/".$vano;

	  $vdia=substr($vto_date,3,2);
  	  $vmes=substr($vto_date,0,2);
  	  $vano=substr($vto_date,8,2);

	  $af2=$vano."/".$vmes."/" .$vdia;
  	  $af2x=$vmes."/" .$vdia."/".$vano;
	 // titulo del reporte
	membrete($pdf,$vfrom_date);
	encabezado($pdf,$af1x,$af2x);
	  
$sql = "SELECT proyectos.Pro_ID, proyectos.Codigo, proyectos.Nombre FROM proyectos inner join (pedidos inner join (pedidos_material inner join materiales on pedidos_material.mat_id=materiales.mat_id)	on pedidos.ped_id=pedidos_material.ped_id) on proyectos.pro_id=pedidos.pro_id WHERE pedidos.fecha between '$af1' AND '$af2' ";
	
	if ($Pro_ID_Reporte!=-33)	
		$sql = $sql . " AND proyectos.Pro_ID=$Pro_ID_Reporte ";

	if ($Nombre_Material!="")	
		$sql = $sql . " AND materiales.denominacion like '%$Nombre_Material%' ";

	$sql = $sql . " GROUP BY proyectos.Pro_ID, proyectos.Codigo, proyectos.Nombre ORDER BY proyectos.Codigo, proyectos.Nombre ";
	
	$result_0=$bd->ejecutar($sql);	
    while($row0=mysqli_fetch_array($result_0))
	{
		$Pro_ID=$row0["Pro_ID"];
		$Codigo=$row0["Codigo"];
		$Nombre=$row0["Nombre"];
		
		$pdf->Multicell(150,5,"Job: ".$Codigo." ".$Nombre,0,L,false);  

			$sql = "SELECT pedidos.fecha,materiales.denominacion,materiales.unidad_medida,pedidos_material.cantidad,pedidos_material.cantidad_recibida,pedidos_material.cantidad_usada FROM	proyectos inner join (pedidos INNER JOIN (pedidos_material INNER JOIN materiales on pedidos_material.mat_id=materiales.mat_id)	ON pedidos.ped_id=pedidos_material.ped_id) on proyectos.pro_id=pedidos.pro_id WHERE pedidos.Pro_ID=$Pro_ID AND pedidos.fecha between '$af1' AND '$af2'";
			
			if ($Nombre_Material!="")	
				$sql = $sql . " AND materiales.denominacion like '%$Nombre_Material%' ";
		
			$sql = $sql . "  ORDER BY materiales.denominacion,materiales.unidad_medida,pedidos.fecha ";
			
			$result=$bd->ejecutar($sql);			
			if(mysqli_num_rows($result)>0) 		 
			{
				$total_ordenado=0;
				$total_recibido=0;
				$total_usado=0;
				$total_balance=0;				
				$total_balance_1=0;
				$total_balance_2=0;
				
				$total_1=0;
				$total_2=0;
				$bandera=1;	
				$bandera_2=1;	
				$aux3=$pdf->GetY();
				while($row=mysqli_fetch_array($result))
					{
						if(($vdenominacion!=$row["denominacion"] || $vunidad_medida!=$row["unidad_medida"]) && $bandera==0)
							{				
							 subtotal($pdf,$parcial_ordenado,$parcial_recibido,$parcial_usado,$parcial_balance,$vdenominacion,$vunidad_medida,$parcial_balance_1,$parcial_balance_2	);					 				     $vdenominacion=$row["denominacion"];
							 $vunidad_medida=$row["unidad_medida"];		
												
							}	
						if($bandera==1)
							{
							$vdenominacion=$row["denominacion"];
							$vunidad_medida=$row["unidad_medida"];
							$bandera=0;
							}						
					
						   //********************************************************************
						   // DETALLE
						   //********************************************************************
						/*  $aux=$pdf->GetY();
						  $pdf->SetX(20);
						  $dato=date_create($row["fecha"]);
						  $fecha=date_format($dato,'y/m/d');
						  $pdf->Multicell(0,5,$fecha,0,L,false);
						  $pdf->SetY($aux);
						  $pdf->SetX(42);
						  $pdf->Multicell(0,5,$row['denominacion'],0,L,false);
						  $pdf->SetY($aux);					  
						  $pdf->SetX(96);
						  $pdf->Multicell(0,5,$row['unidad_medida'],0,L,false);
						  $pdf->SetY($aux);
						  $pdf->SetX(110);
						  $pdf->Multicell(20,5,$row['cantidad'],0,R,false);
						  $pdf->SetY($aux);
						  $pdf->SetX(126);					  
						  $pdf->Multicell(20,5,$row['cantidad_recibida'],0,R,false);
						  $pdf->SetY($aux);
						  $pdf->SetX(142);
						  $pdf->Multicell(20,5,$row['cantidad_usada'],0,R,false);
						  $pdf->SetY($aux);
						  $pdf->SetX(160);
						  $pdf->Multicell(20,5,$row['cantidad_usada'],0,R,false); */
						
							
					  //sumas parciales por material
					  
					  $parcial_ordenado=$parcial_ordenado+$row["cantidad"];
					  $parcial_recibido=$parcial_recibido+$row["cantidad_recibida"];
					  $parcial_usado=$parcial_usado+$row["cantidad_usada"];
					  $parcial_balance_1=$parcial_balance_1+($row['cantidad']-$row['cantidad_recibida']);
					  $parcial_balance_2=$parcial_balance_2+($row['cantidad_recibida']-$row['cantidad_usada']);
					  
					  //sumas totales por material			  
					  $total_ordenado=$total_ordenado+$row["cantidad"];
					  $total_recibido=$total_recibido+$row["cantidad_recibida"];
					  $total_usado=$total_usado+$row["cantidad_usada"];			  
					  $total_1=$total_1+$row['cantidad']-$row['cantidad_recibida'];
					  $total_2=$total_2+$row['cantidad_recibida']-$row['cantidad_usada'];
					  
					  $aux6=$pdf->GetY();
					  if($aux6>=180)
						{
						$pdf->AddPage();
						membrete($pdf);
						encabezado($pdf,$af1x,$af2x);
						}
		
		
					}
				  subtotal($pdf,$parcial_ordenado,$parcial_recibido,$parcial_usado,$parcial_balance,$vdenominacion,$vunidad_medida,$parcial_balance_1,$parcial_balance_2);
				 
				  $aux=$pdf->GetY();
				  $pdf->line(10,$pdf->GetY(),260,$pdf->GetY());
//				  $pdf->Multicell(0,5,"Total General",0,L,false);
				  $pdf->SetY($aux);
				  $pdf->SetX(145);					  		  
	//			  $pdf->Multicell(25,5,$total_ordenado,0,R,false);
				  $pdf->SetY($aux);					  
				  $pdf->SetX(170);					  
		//		  $pdf->Multicell(25,5,$total_recibido,0,R,false);
				  $pdf->SetY($aux);
				  $pdf->SetX(195);					  		  
			//	  $pdf->Multicell(20,5,$total_usado,0,R,false);
				  $pdf->SetY($aux);
				  $pdf->SetX(215);					  		  
				//  $pdf->Multicell(20,5,$total_1,0,R,false);	
				  $pdf->SetY($aux);
				  $pdf->SetX(240);					  		  
				  //$pdf->Multicell(20,5,$total_2,0,R,false);									
			}	
	}
	$pdf->Output("dato.pdf");
	?>
	<embed src="dato.pdf#toolbar=1&navpanes=0&scrollbar=0" width="990" height="570"></embed>
    <?
	require('Library/Close_Conexion.php');	
?>



