<?php



	session_name("Administrador");



	session_start();



	//*******************************************************************



	//Datos enviados por proyecto_reporte_material_0.php



	//******************************************************************



	$vfrom_date=$_REQUEST["vfrom_date"];



	$vto_date=$_REQUEST["vto_date"];

	

	$Pro_ID_Reporte=$_REQUEST["Pro_ID_Reporte"];



	require('Library/Control_Cache.php');	



	require('Library/Open_Conexion.php');



	require('Library/funciones.php');	



	// INSERTADO POR FABIOLA CARRASCO



	require('pdf/fpdf.php');



	$pdf=new FPDF('L','mm','Letter');



	$pdf->AddPage();



	







	// DEFINICION DE FUNCIONES DE CABEZERA DE SUBCUEPO



	$pdf->SetMargins(15,20,15,15);



	$pdf->SetFont('Arial','',10);



	$pdf->SetLineWidth(0.5); 



	$pdf->Setfillcolor(255,255,255);



	



	function membrete(&$pdf)



	{



		//ENCABEZADO



		$pdf->SetFont('Arial','',8);



		$pdf->Image('images/logo.png',5,5,30,10,"png");



	}



	



	function Sub_Total(&$pdf, &$Total_HContract, &$Total_HTM, $Fecha, $Pro_ID, $bd)



	{



	



		$aux=$pdf->GetY()+1;	



		$pdf->SetY($aux);



		$pdf->SetX(200);						



		$pdf->Multicell(70,5,"   -------------------------------------------------------------------",0,L,true);



	



		$aux=$pdf->GetY();	



		$pdf->SetY($aux);



		$pdf->SetX(150);						



		$pdf->Multicell(50,5,"Total Hours worked",0,L,true);



		$pdf->SetY($aux);



		$pdf->SetX(200);						



		$pdf->Multicell(30,5,$Total_HContract,0,L,true);



		$pdf->SetY($aux);



		$pdf->SetX(230);						



		$pdf->Multicell(20,5,$Total_HTM,0,L,true);



		$pdf->SetY($aux);



		$pdf->SetX(250);				



		$THC=money_format("%= (#8.2n",($Total_HContract+$Total_HTM));		



		$pdf->Multicell(20,5,$THC,0,L,true);		



		



		$Total_HContract=0;



		$Total_HTM=0;



		



		$aux=$pdf->GetY();			



		$pdf->SetY($aux+10);				  



		$aux7=$pdf->GetY();				



		if($aux7>=180)



		{



			$pdf->AddPage('L');



			membrete($pdf);



			encabezado($pdf,$af1,$af2);



			$aux=$pdf->GetY()+2;	



		}		



		$pdf->SetY($aux);



		$pdf->SetX(30);						



		$pdf->Multicell(130,5,"Total on job to ".$Fecha,0,L,true);



		



		//************************************* INICIO TOTAL HOURS *************************************				  



		$consulta = "SELECT Horas FROM proyectos WHERE Pro_ID=".$Pro_ID;				



		//echo $consulta."<br>";		



		$Detalle="";

			$Horas=0;

			$HContract=0;

			$PorcHoras=0;

			$HTM=0;



	



		$result2=$bd->ejecutar($consulta); 	



		if (($row2 = mysqli_fetch_array($result2) ))							



		{		



			$Horas=$row2["Horas"];						



			



			$consulta = "select SUM(HContract) AS HContract, SUM(HTM) AS HTM FROM actividad_personal ap INNER JOIN actividades a ON ap.Actividad_ID=a.Actividad_ID ";



			$consulta = $consulta . " WHERE a.Pro_ID=".$Pro_ID;		



		



			$result33=$bd->ejecutar($consulta); 	



			while (($row33 = mysqli_fetch_array($result33) ))							



			{				



				$HContract = $row33["HContract"];



				$HTM = $row33["HTM"];



			}



			mysqli_free_result($result33);

			

			if ($Horas>0)

						{

							$PorcHoras=round((($HContract/$Horas)*100),2);

						}

						  Else

						    {

								$PorcHoras="-";

							}

			

			$HorasPen=$Horas-$HContract;



			$Horas= number_format($Horas,2);



			$HContract= number_format($HContract,2);



			$HTM= number_format($HTM,2);



			$THoras=number_format(($HContract+$HTM),2);

			$HorasPen= number_format($HorasPen,2);



				



			$Detalle = "Hours to Work:".$Horas."h   Hours Worked:".$HContract."h   Worked:".$PorcHoras."%";



			$Detalle = $Detalle."      T&M: ".$HTM."h   Total Hours:".($THoras)."h  Horas Left:".$HorasPen;

			

			

	



		}



		mysqli_free_result($result2);					



		



		$pdf->SetY($aux);



		$pdf->SetX(30);



		$pdf->Multicell(220,5,$Detalle,0,L,true);	





		$aux=$pdf->GetY();							



		$pdf->SetY($aux+10);				  



		$aux7=$pdf->GetY();				



		if($aux7>=180)



		{



			$pdf->AddPage('L');



			membrete($pdf);



			encabezado($pdf,$af1,$af2);



			$aux=$pdf->GetY()+2;



		}



	  //************************************* FIN TOTAL HOURS *************************************



	  	//************************************* INICIO Material Used *************************************				  



			$pdf->SetY($aux);



			$pdf->SetX(30);



			$pdf->Multicell(40,5,"Total Material Used:",0,L,true);	



			



			$consulta = "select m.* FROM materiales m INNER JOIN proyectos p ON m.Pro_ID=p.Pro_ID ";



			$consulta = $consulta."  WHERE m.Pro_ID=".$Pro_ID." OR p.Nombre='General Sundries' ";														



			$consulta = $consulta."  ORDER BY Denominacion";		



			//echo $consulta;



			$contador=1;	 	  	 	  	  



			$result2=$bd->ejecutar($consulta); 	



			while (($row2 = mysqli_fetch_array($result2) ))							



			{		



				$Mat_ID = $row2["Mat_ID"];



				$Denominacion = $row2["Denominacion"];



				$Nombre_Generico=$row2["Nombre_Generico"];



				$Unidad_Medida = $row2["Unidad_Medida"];



				$Precio_Unitario = $row2["Precio_Unitario"];		



				$Cantidad = $row2["Cantidad"];			



				



				$consulta = "SELECT SUM(Cantidad) as Cantidad_Ordenada, SUM(Cantidad_Recibida) as Cantidad_Recibida, SUM(Cantidad_Usada) as Cantidad_Usada FROM pedidos_material ";



				$consulta = $consulta . " WHERE Mat_ID=".$Mat_ID ;



				



				//echo  $consulta;			 	  	 	  	  



				$result22=$bd->ejecutar($consulta); 	



				while (($row22 = mysqli_fetch_array($result22) ))							



				{		



					$Total_Cantidad_Ordenada = $row22["Cantidad_Ordenada"];



					if (is_null($Total_Cantidad_Ordenada))



						$Total_Cantidad_Ordenada=0;



						



					$Total_Cantidad_Recibida = $row22["Cantidad_Recibida"];



					if (is_null($Total_Cantidad_Recibida))



						$Total_Cantidad_Recibida=0;



						



					$Total_Cantidad_Usada=$row22["Cantidad_Usada"];		



					if (is_null($Total_Cantidad_Usada))



						$Total_Cantidad_Usada=0;



						



					$Saldo = $Total_Cantidad_Recibida - $Total_Cantidad_Usada;				



					



					if (  ( !(is_null($Cantidad) )  )  && ($Cantidad!=0)  )



					{



						$Por_Usada = ($Total_Cantidad_Usada*100)/$Cantidad;	



						$Por_Comprar = $Cantidad - $Total_Cantidad_Ordenada;	



					}



					else



					{



						$Por_Usada = 0; //"&nbsp;";



						$Por_Comprar =0; //"&nbsp;";



					}



				}



				mysqli_free_result($result22);				







				$Detalle = "   Estimated=".$Cantidad.$Unidad_Medida."   Ordered=".$Total_Cantidad_Ordenada.$Unidad_Medida;



				$Detalle = $Detalle ."    Received=".$Total_Cantidad_Recibida.$Unidad_Medida."    Used=".$Total_Cantidad_Usada.$Unidad_Medida;



				$Detalle = $Detalle ."     Used=".$Por_Usada."%";   



				$aux=$pdf->GetY();



				$pdf->SetY($aux);



				$pdf->SetX(35);



				$pdf->Multicell(100,5, $Denominacion,0,L,true);



				$pdf->SetY($aux);



				$pdf->SetX(137);



				$pdf->Multicell(110,5,$Detalle ,0,L,true);				



				$aux=$pdf->GetY();				



				$pdf->SetY($aux+10);				  



				$aux7=$pdf->GetY();				



				if($aux7>=180)



				{



					$pdf->AddPage('L');



					membrete($pdf);



					encabezado($pdf,$af1,$af2);



					$aux=$pdf->GetY()+2;		



				}



				$pdf->SetY($aux);				  



				$contador++;



			}



			mysqli_free_result($result2);										



		  //************************************* FIN Material Used *************************************		



	}



	



	function encabezado(&$pdf,$f1,$f2)



	{



	   //****************************************************************



	   //DESCRIPCION:PERMITE IMPRIMIR EL ESCABEZADO DE LA PRIMERA CONSULTA



	  //*****************************************************************

	  $f1=FormatDateTime($f1, 8);

	  $f2=FormatDateTime($f2, 8);

	  

  	  $pdf->Multicell(0,5,"",0,L,false);



	  $pdf->Multicell(0,5,"Report Execution day by day",0,C,false);



  	  $pdf->Multicell(0,5,"from:".$f1." to:".$f2,0,C,false); 



	  $pdf->Multicell(0,5,"",0,L,false);



	  // titulo del detall	  



  	  $aux=$pdf->GetY();	 



	  $pdf->SetX(30);



	  $pdf->Multicell(30,5,"Date",0,L,false);



	  $pdf->SetY($aux);



	  $pdf->SetX(60);



	  $pdf->Multicell(140,5,"Work Done",0,L,false);



	  



	  $pdf->SetY($aux);



	  $pdf->SetX(200);	  



	  $pdf->Multicell(30,5,"Hours Contract",0,L,false);



	  $pdf->SetY($aux);



	  $pdf->SetX(235);



	  $pdf->Multicell(20,5,"T&M",0,L,false);



	  



	  $pdf->SetY($aux);



	  $pdf->SetX(250);



	  $pdf->Multicell(20,5,"Total Hours",0,L,false);



	  



	  $aux7=$pdf->GetY();



   	  $pdf->line(10,$aux+5,270,$aux+5);



	  $pdf->line(10,$pdf->GetY()-5,270,$pdf->GetY()-5);



	  $pdf->SetY($aux7);	  



	}	



		



	



	$vdia=substr($vfrom_date,3,2);



	$vmes=substr($vfrom_date,0,2);



	$vano=substr($vfrom_date,8,2);



	$af1="20".$vano."-".$vmes."-" .$vdia;	



	$vdia=substr($vto_date,3,2);



	$vmes=substr($vto_date,0,2);



	$vano=substr($vto_date,8,2);



	



	$af2="20".$vano."-".$vmes."-" .$vdia;



	   



	$sql = "SELECT 



	p.Pro_ID,



	p.codigo, 



	p.nombre,



	p.calle,



	p.ciudad,



	p.estado,



	p.zip_code,



	d.Fecha



	FROM dayli_task d 



	INNER JOIN proyectos p ON p.Pro_id=d.Pro_ID



	WHERE d.Fecha between '$af1' AND '$af2' ";

	

	if ($Pro_ID_Reporte!=-33)	

		$sql = $sql . " AND p.Pro_ID=$Pro_ID_Reporte ";



	$sql = $sql . " GROUP BY p.Pro_ID, p.codigo, p.nombre, p.calle, p.ciudad, p.estado, p.zip_code, d.Fecha



	ORDER BY p.nombre, d.fecha";	



	$result=$bd->ejecutar($sql);



	//echo $sql;



	// titulo del reporte



   	membrete($pdf,$vfrom_date);



	encabezado($pdf,$af1,$af2);	

	



    if(mysql_num_rows($result)>0) 		 



	{		



		$Pro_ID_Ant=-1;	



		$Total_HContract=0;



		$Total_HTM=0;



		$aux=$pdf->GetY()+2;



		while ($row=mysqli_fetch_array($result))

		{				

						

			//********************************************************************

			// DETALLE



			//********************************************************************

			$Pro_ID = $row["Pro_ID"];

			$Fecha = $row["Fecha"];		

			//echo "**".$Pro_ID_Ant."--".$Pro_ID."+++<br>";



			if ($Pro_ID_Ant!=$Pro_ID)



			{						



				if ($Pro_ID_Ant!=-1)



				{



					Sub_Total($pdf,$Total_HContract,$Total_HTM, $Fecha, $Pro_ID, $bd );					

					$aux=$pdf->GetY()+5;



				}				



				$pdf->SetY($aux);



				$pdf->SetX(10);				



				$pdf->Multicell(170,5,$row['codigo'].",".$row['nombre'].", Add:".$row['calle'].",".$row['ciudad'].",".$row['estado'].",".$row['zip_code']." Contac:".$vcontacto,0,L,true);				



			}			



			$Fecha_aux=FormatDateTime($Fecha, 6);



			$aux=$pdf->GetY();



			$pdf->SetX(30);					  



			$pdf->Multicell(30,5,$Fecha_aux,0,L,true);	



						



			//************************************* INICIO Work Done *************************************				  			  			



			



			$consulta = "SELECT ac.*, d.Task_ID, d.Descp1, d.Descp2, d.Descp3, d.Descp4, d.Fecha FROM dayli_task d INNER JOIN area_control ac ON ac.Area_ID=d.Area_ID WHERE d.Pro_ID=".$Pro_ID." AND d.Fecha='".$Fecha."' ORDER BY  Fecha DESC, Nombre ASC";			



			//echo $consulta;



			$result2=$bd->ejecutar($consulta); 	



			$Work_Done="";



			while (($row2 = mysqli_fetch_array($result2) ))							



			{		



				$Nombre = $row2["Nombre"];



				$Descp1 = $row2["Descp1"];					



				$Work_Done=$Work_Done.$Nombre ." ".$Descp1.", ";



			}



			mysqli_free_result($result2);									



			$pdf->SetY($aux);			



			$pdf->SetX(50);					  



			$pdf->Multicell(145,5,$Work_Done,0,'L',0);			



			$aux33=$pdf->GetY();



		  //************************************* FIN Work Done *************************************	



		  //************************************* INICIO Horas de Trabajo *************************************				  					



			$consulta = "SELECT SUM(ap.HContract) AS HContract, SUM(ap.HTM) AS HTM FROM personal p 



			INNER JOIN actividad_personal ap ON ap.Empleado_ID=p.Empleado_ID 



			INNER JOIN actividades a ON a.Actividad_ID=ap.Actividad_ID 



			WHERE a.Fecha='".$Fecha."' AND a.Pro_ID=".$Pro_ID;	



			



			//echo $consulta;



			$result2=$bd->ejecutar($consulta); 	



			while (($row2 = mysqli_fetch_array($result2) ))	

			{		



				$HContract = money_format("%= (#8.2n",($row2["HContract"]));



				if (is_null($HContract))



					$HContract=0;



					



				$HTM = money_format("%= (#8.2n",($row2["HTM"]));



				if (is_null($HTM))



					$HTM=0;







				$Total = money_format("%= (#8.2n",($HContract+$HTM));



			}



			mysqli_free_result($result2);			



			



			$Total_HContract=money_format("%= (#8.2n",($Total_HContract+$HContract));



			$Total_HTM=money_format("%= (#8.2n",($Total_HTM+$HTM)); 



			



					



			$pdf->SetY($aux);



			$pdf->SetX(200);						



			$pdf->Multicell(30,5,$HContract,0,L,true);



			$pdf->SetY($aux);



			$pdf->SetX(230);						



			$pdf->Multicell(20,5,$HTM,0,L,true);



			$pdf->SetY($aux);



			$pdf->SetX(250);						



			$pdf->Multicell(20,5,$Total,0,L,true);		



			



			$aux=$pdf->GetY();					



			$pdf->SetY($aux+10);				  



			$aux7=$pdf->GetY();				



			if($aux7>=180)



			{



				$pdf->AddPage('L');



				membrete($pdf);



				encabezado($pdf,$af1,$af2);



				$aux=$pdf->GetY()+2;	



			}



			$pdf->SetY($aux33);



			//************************************* FIN Horas de Trabajo *************************************					  			  



			$Pro_ID_Ant=$Pro_ID;			



		}	

		



		Sub_Total($pdf,$Total_HContract,$Total_HTM, $Fecha, $Pro_ID, $bd );					



	}		



	$pdf->Output("dato.pdf");



	?>



	<embed src="dato.pdf#toolbar=1&navpanes=0&scrollbar=0" width="1190" height="570"></embed>



    <?



	require('Library/Close_Conexion.php');	



?>















