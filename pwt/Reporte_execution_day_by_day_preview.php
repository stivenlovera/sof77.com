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



		$pdf->Multicell(50,5,"Total Hours in range of dates",0,L,true);



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



		$consulta = "SELECT Horas,Adi1,Adi2,Adi3,Adi4,Adi5 FROM proyectos WHERE Pro_ID=".$Pro_ID;



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



			$Co1=$row2["Adi1"];



			$Co2=$row2["Adi2"];



			$Co3=$row2["Adi3"];



			$Co4=$row2["Adi4"];



			$Co5=$row2["Adi5"];



			$Horas=$Horas+$Co1+$Co2+$Co3+$Co4+$Co5;



			$consulta = "select SUM(HContract) AS HContract, SUM(HTM) AS HTM FROM actividad_personal ap INNER JOIN actividades a ON ap.Actividad_ID=a.Actividad_ID ";



			$consulta = $consulta . " WHERE a.Pro_ID=".$Pro_ID;	



			$result33=$bd->ejecutar($consulta);







			while (($row33 = mysqli_fetch_array($result33) ))



			{



				$HContract = $row33["HContract"];



				$HTM = $row33["HTM"];



				//$HContract=$HContract-$HTM;



				



						//	echo $HContract."  ".$Pro_ID."<br>";



			}



			mysqli_free_result($result33);



			







			if ($Horas>0)



			{



				$PorcHoras=round((($HContract/$Horas)*100),2);



			}



		  	else



			{



				$PorcHoras="-";



			}	







			$HorasPen=$Horas-$HContract;



			$THoras=number_format(($HContract+$HTM),2);



			$Horas= number_format($Horas,2);



			$HContract= number_format($HContract,2);



			$HTM= number_format($HTM,2);



			



			$HorasPen= number_format($HorasPen,2);



			$Detalle = "Summary whole job:Hours to Work Contract+Change Orders:".$Horas."h   Hours Worked:".($HContract)."h   Worked:".$PorcHoras."%";



			$Detalle = $Detalle."  //   T&M: ".$HTM."h   Total Hours:".($THoras)."h  Horas Left:".$HorasPen;



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



	  	//************************************* INICIO Material Used ********************************



		$detmat=0;



		if ($detmat==1)



		{



		echo "dddddddddddd";



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



		}	



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







	/*$sql = "SELECT 



	p.Pro_ID,



	p.codigo, 



	p.nombre,



	p.calle,



	p.ciudad,



	p.estado,



	p.zip_code,



	d.Fecha,



	d.Pro_ID,



	a.Pro_ID,



	a.Fecha



	FROM actividades a LEFT JOIN dayli_task d ON (a.Pro_ID=d.Pro_ID AND a.Fecha=d.Fecha)



	INNER JOIN proyectos p ON p.Pro_id=d.Pro_ID



	WHERE a.Fecha between '$af1' AND '$af2' ";	*/

	

	$sql = "SELECT 



	p.Pro_ID,



	p.codigo, 



	p.nombre,



	p.calle,



	p.ciudad,



	p.estado,



	p.zip_code,

	

	a.Pro_ID,

	a.Actividad_ID,

	a.Fecha



	FROM actividades a 



	INNER JOIN proyectos p ON p.Pro_id=a.Pro_ID



	WHERE a.Fecha between '$af1' AND '$af2' ";	







	if ($Pro_ID_Reporte!=-33)	



		$sql = $sql . " AND p.Pro_ID=$Pro_ID_Reporte ";



	$sql = $sql . " GROUP BY p.Pro_ID, p.codigo, p.nombre, p.calle, p.ciudad, p.estado, p.zip_code, a.Fecha



	ORDER BY p.nombre, a.fecha";	







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



					Sub_Total($pdf,$Total_HContract,$Total_HTM, $Fecha, $Pro_ID_Ant, $bd );					



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

			$aux22=$pdf->GetY();

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



			



			$pdf->SetY($aux33+1);							  



			$aux7=$pdf->GetY();				



			if($aux7>=180)



			{



				$pdf->AddPage('L');



				membrete($pdf);



				encabezado($pdf,$af1,$af2);



				$aux=$pdf->GetY()+5;

				$aux22=$aux;	



			}



			//$pdf->SetY($aux33);



			//************************************* FIN Horas de Trabajo *************************************					  			  /// inicio imprimir units done

					

			$sql4 = "SELECT dr.Nota_Horas AS NHoras, dr.Actividad_ID AS Actividad_ID,dr.Task_ID AS Task_ID, dr.Horas AS Horas, dr.Numero AS Numero, t.Task_ID AS Task_IDT, t.Nombre AS Nombre  FROM dayli_report_task dr JOIN task t  ON t.Task_ID=dr.Task_ID WHERE dr.Actividad_ID=".$row['Actividad_ID'];

			

			//echo $sql4."<br>";

			$result_4=$bd->ejecutar($sql4);	

			while($row4=mysqli_fetch_array($result_4))

			{

				//echo $sql4."<br>";	

				/*$dato=date_create($row["Fecha"]);

				$fecha=date_format($dato,'y/m/d');

				$dato1=$fecha;			

				

				$vdia=substr($dato1,6,2);

				$vmes=substr($dato1,3,2);

				$vano=substr($dato1,0,2);

				

				$fecha1="20".$vano."-".$vmes."-" .$vdia;

				$texdia= substr((FormatDateTime($fecha1, 8)),0,3);						  				

				$fecha1=$texdia.".".$vmes."-".$vdia."-".$vano;

				$pdf->SetY($aux);

				$pdf->SetX(20);					  

				$pdf->Multicell(20,5,$fecha1,0,L,false);

				$pdf->SetY($aux);

				$pdf->SetX(41);

				$pdf->Multicell(8,5,"On:",0,L,false);

				$pdf->SetY($aux);

				$pdf->SetX(47);

				$Nombret=trim($row4['Nombre']);

				$pdf->Multicell(40,5,$Nombret,0,L,false);

				$pdf->SetY($aux);

				$pdf->SetX(93);

				$pdf->Multicell(20,5,"Units Done:",0,L,false);

				$aux33=$pdf->GetY();

				$pdf->SetY($aux);

				$pdf->SetX(110);				

				$pdf->Multicell(10,5,$row4['Numero'],0,L,false);

				$pdf->SetY($aux);

				$pdf->SetX(121);

				$pdf->Multicell(18,5,"Hrs.Used:",0,L,false);

				$pdf->SetY($aux);

				$pdf->SetX(138);	

				$pdf->Multicell(20,5,$row4['Horas']."h",0,L,false);*/

				$Nombret=(trim($row4['Nombre']));

				$Udone="On:".$Nombret." Units Done:".$row4['Numero']."/ Hrs.Used:".$row4['Horas']."h";

				

				$sql6 = "SELECT  SUM(pm.Cantidad_Usada) AS Cantidad_Usada FROM pedidos_material pm INNER JOIN materiales m ON pm.Mat_ID=m.Mat_ID ";

				$sql6 = $sql6 . "  WHERE m.Unidad_Medida='gl.' AND pm.Actividad_ID=".$row['Actividad_ID']." AND  pm.Task_ID=".$row4['Task_ID'];	

					

				//echo $sql."<br>";

				$result6=$bd->ejecutar($sql6);	

				while($row6=mysqli_fetch_array($result6))

					{

						$Cantidad_Usada=$row6["Cantidad_Usada"];

					}

				mysqli_free_result($result6);		

				/*$pdf->SetY($aux);

				$pdf->SetX(158);

				$pdf->Multicell(15,5,"Mat.Used:",0,L,false);			

				$pdf->SetY($aux);

				$pdf->SetX(175);

				$pdf->Multicell(20,5,number_format($Cantidad_Usada,2)."gl.",0,L,false);

				$pdf->SetY($aux);

				$pdf->SetX(200);	

				$pdf->Multicell(45,5,"Notes:".$row4['NHoras'],0,L,false);	

				$aux=$pdf->GetY();				

  				$pdf->SetY($aux+10);				  

				$aux7=$pdf->GetY();	*/	

				$Udone=$Udone." Mat.Used:".(number_format($Cantidad_Usada,2))."gl."."Notes:".($row4['NHoras']);

				$pdf->SetY($aux33+1);							  

			$aux7=$pdf->GetY();				



			if($aux7>=180)



			{

				$pdf->AddPage('L');

				membrete($pdf);

				encabezado($pdf,$af1,$af2);

				$aux=$pdf->GetY()+5;

				$aux22=$aux;	



			}

			

			$pdf->SetY($aux22+1);

			$pdf->SetX(50);					  

			$pdf->Multicell(145,5,$Udone,0,'L',0);

			$aux22=$pdf->GetY()+1;

			$aux=$aux22;

			$Udone="";

			

			}								



	// fin imprimir units done 

					

				

















			$Pro_ID_Ant=$Pro_ID;			



		}	



		Sub_Total($pdf,$Total_HContract,$Total_HTM, $Fecha, $Pro_ID_Ant, $bd );					



	}		



	$pdf->Output("dato.pdf");



?>







	<embed src="dato.pdf#toolbar=1&navpanes=0&scrollbar=0" width="1190" height="570"></embed>



<?



	require('Library/Close_Conexion.php');	



?>































































