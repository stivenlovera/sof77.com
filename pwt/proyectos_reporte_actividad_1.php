<?php



	session_name("Administrador");



	session_start();



	//*******************************************************************



	//Datos enviados por proyecto_reporte_material_0.php



	//******************************************************************



	$vfrom_date=$_REQUEST["vfrom_date"];



	$vto_date=$_REQUEST["vto_date"];



	



		



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



	$pdf->Setfillcolor(237,243,120);



	



	function membrete(&$pdf)



	{



		//ENCABEZADO



		$pdf->SetFont('Arial','',8);



		$pdf->Image('images/logo.png',5,5,30,10,"png");



		}



	



	function encabezado(&$pdf,$f1,$f2)



	{



	   //****************************************************************



	   //DESCRIPCION:PERMITE IMPRIMIR EL ESCABEZADO DE LA PRIMERA CONSULTA



	  //*****************************************************************



	    $f1=FormatDateTime ($f1,8);



	  $f2=FormatDateTime ($f2,8);



  	  $pdf->Multicell(0,5,"",0,L,false);



	  $pdf->Multicell(0,5,"Details of activities",0,C,false);



  	  $pdf->Multicell(0,5,"from:".$f1." to:".$f2,0,C,false);



  	  $pdf->Multicell(0,5,"",0,L,false);



	  // titulo del detall	  



  	  $aux=$pdf->GetY();



	  $pdf->SetX(20);



	  $pdf->Multicell(0,5,"Code/Proyect",0,L,false);



	  $pdf->SetY($aux);



	  $pdf->SetX(80);



	  $pdf->Multicell(0,5,"Date",0,L,false);



	  $pdf->SetY($aux);



	  $pdf->SetX(110);



	  $pdf->Multicell(0,5,"Time",0,L,false);



	  $pdf->SetY($aux);



	  $pdf->SetX(130);



	  $pdf->Multicell(0,5,"Type Activities",0,L,false);



	  $pdf->SetY($aux);



	  $pdf->SetX(155);



	  $pdf->Multicell(25,5,"Decription",0,L,false);



	  $pdf->SetY($aux);



	  $pdf->SetX(220);



	  $pdf->Multicell(25,5,"Employee",0,L,false);	 



	  $aux7=$pdf->GetY();



   	  $pdf->line(10,$aux+5,270,$aux+5);



	  $pdf->line(10,$pdf->GetY()-5,270,$pdf->GetY()-5);



	  $pdf->SetY($aux7);



	  



	}



	



	function encabezado2(&$pdf,$f1,$f2)



	{



		//****************************************************************



		//DESCRIPCION:PERMITE IMPRIMIR EL ESCABEZADO DE LA SEGUNDA CONSULTA



		//*****************************************************************



	  $f1=FormatDateTime ($f1,8);



	  $f2=FormatDateTime ($f2,8);



  	  $pdf->Multicell(0,5,"",0,L,false);



	  $pdf->Multicell(0,5,"Employees Off",0,C,false);



  	  $pdf->Multicell(0,5,"from:".$f1." to:".$f2,0,C,false);



  	  $pdf->Multicell(0,5,"",0,L,false);



	  // titulo del detall	  



  	  $aux=$pdf->GetY();



	  $pdf->SetX(20);



	  $pdf->Multicell(0,5,"Name",0,L,false);



	  $pdf->SetY($aux);



	  $pdf->SetX(70);



	  $pdf->Multicell(0,5," ",0,L,false);



	  $aux7=$pdf->GetY();



   	  $pdf->line(10,$aux+5,200,$aux+5);



	  $pdf->line(10,$pdf->GetY()-5,200,$pdf->GetY()-5);



	  $pdf->SetY($aux7);



	}



	



	function encabezado3(&$pdf)



	{



		//****************************************************************



		//DESCRIPCION:PERMITE IMPRIMIR EL ESCABEZADO DE LA SEGUNDA CONSULTA



		//*****************************************************************



	  $pdf->Multicell(0,5,"",0,L,false);



	  $pdf->Multicell(0,5,"Jobs Coming Up",0,C,false);



  	  $pdf->Multicell(0,5,"from:".date('m/d/Y'),0,C,false);



	  $pdf->Multicell(0,5,"from:".$fec1,0,C,false);



  	  $pdf->Multicell(0,5,"",0,L,false);



	  // titulo del detall	  



  	  $aux=$pdf->GetY();



	  $pdf->SetX(10);



	  $pdf->Multicell(0,5,"Code",0,L,false);



	  $pdf->SetY($aux);



	  $pdf->SetX(50);



	  $pdf->Multicell(0,5,"Projects",0,L,false);



  	  $pdf->SetY($aux);



	  $pdf->SetX(100);



	  $pdf->Multicell(0,5,"Adress",0,L,false);



   	  $pdf->SetY($aux);



	  $pdf->SetX(150);



	  $pdf->Multicell(0,5,"initiation Date",0,L,false);



	  $aux7=$pdf->GetY();



   	  $pdf->line(10,$aux+5,200,$aux+5);



	  $pdf->line(10,$pdf->GetY()-5,200,$pdf->GetY()-5);



	  $pdf->SetY($aux7);



	}



	



	function per_sin_act(&$pdf,$f1,$f2,$pbd)



	//*********************************************



	//DESCRIPCION:PERSONAL SIN ACTIVIDAD



	//********************************************



	{	



		if($f1==$f2)



		{



		$pdf->AddPage('P');



		membrete($pdf);



		encabezado2($pdf,$f1,$f2);		



		// $sql="select personal.nombre,



		//personal.apellido_paterno,



		//personal.apellido_materno, Nick_Name



		//from personal where personal.empleado_id not in (select actividad_personal.empleado_id from actividad_personal inner join actividades on actividad_personal.actividad_id=actividades.actividad_id where actividades.fecha='".$vfl."')" ;



		$sql="SELECT personal.Nick_Name, personal.nombre,



		personal.apellido_paterno,



		personal.aux5,



		personal.aux1,



		personal.apellido_materno



		FROM personal INNER JOIN empresas ON personal.Emp_ID=empresas.Emp_ID WHERE ((personal.aux5 is NULL) OR (personal.aux5<>'Adm')) AND empresas.Codigo='PWT' AND personal.empleado_id NOT IN (SELECT actividad_personal.empleado_id FROM actividad_personal INNER JOIN actividades ON actividad_personal.actividad_id=actividades.actividad_id WHERE actividades.fecha='".$f1."')";



		$result2=$pbd->ejecutar($sql);	



		if(mysql_num_rows($result2)>0) 		 



		{		



			$bandera=1;	



			$bandera_2=1;	



			$aux3=$pdf->GetY();



			while($row=mysqli_fetch_array($result2))



				{	



				  //********************************************************************



				  // DETALLE



				  //********************************************************************



				  $tono = ($tono==240) ? 200 : 240;



				  $pdf->SetFillColor($tono);



				  $aux=$pdf->GetY();



				  $pdf->SetX(20);



  				  $pdf->Rect(10, $aux, 190,10,'F');  	  	  



				  $pdf->Multicell(0,5,$row['nombre'],0,L,false);



				  $pdf->SetY($aux);



				  $pdf->SetX(70);



				  $pdf->Multicell(0,5,$row['apellido_paterno']." ".$row['apellido_materno']."  ".$row['aux1'],0,L,false);



				  $aux6=$pdf->GetY();



				  if($aux6>=260)



					{



					$pdf->AddPage('P');



					membrete($pdf);



					encabezado2($pdf,$af1,$af2);



					}



				}



			  



			}



		}



	}



	//************************************************************************************************







	



	function pro_ult_sem(&$pdf,$pbd)



	//*********************************************



	//DESCRIPCION: pro_ult_sem PRO_ YECTOS QUE SE VAN HA EJECUTAR LAS DOS ULT_ IMAS SEM_ ANA



	//********************************************



	{	



		$pdf->AddPage('P');



		membrete($pdf);



		encabezado3($pdf);	



		



		$fecha1= date('Y-m-d');



		$fecha2= date('Y-m-d', strtotime('+14 day'));



		$sql="select * from proyectos where fecha_inicio>='$fecha1' and fecha_inicio<='$fecha2'";



		$result2=$pbd->ejecutar($sql);	



		if(mysql_num_rows($result2)>0) 		 



		{		



			$bandera=1;	



			$bandera_2=1;	



			$aux3=$pdf->GetY();



			while($row2=mysqli_fetch_array($result2))



				{	



				  //********************************************************************



				  // DETALLE



				  //********************************************************************



				  $tono = ($tono==240) ? 200 : 240;



				  $pdf->SetFillColor($tono);



				  $aux=$pdf->GetY();



				  $pdf->SetX(10);



				  $pdf->Rect(10, $aux, 190,10,'F');  	  	  



				  $pdf->Multicell(0,5,$row2['Codigo'],0,L,false);



				  $pdf->SetY($aux);



				  $pdf->SetX(50);



				  $pdf->Multicell(0,5,$row2['Nombre'],0,L,false);



				  $pdf->SetY($aux);



				  $pdf->SetX(100);



				  $pdf->Multicell(0,5,$row2['Calle'],0,L,false);



				  $pdf->SetY($aux);



				  $pdf->SetX(150);



				  $pdf->Multicell(0,5,FormatDateTime(($row2['Fecha_Inicio']),8),0,L,false);



				  



				  $aux6=$pdf->GetY();



				  if($aux6>=260)



					{



					$pdf->AddPage('P');



					membrete($pdf);



					encabezado3($pdf,$af1,$af2);



					}



			}



			  



		}



	}







	//************************************************************************************************



		



	



	$vdia=substr($vfrom_date,3,2);



	$vmes=substr($vfrom_date,0,2);



	$vano=substr($vfrom_date,8,2);



	$af1="20".$vano."-".$vmes."-" .$vdia;



	



	$vdia=substr($vto_date,3,2);



	$vmes=substr($vto_date,0,2);



	$vano=substr($vto_date,8,2);



	



	$af2="20".$vano."-".$vmes."-" .$vdia;



	   



	$sql = "select



	proyectos.codigo, 



	proyectos.nombre,



	proyectos.calle,



	proyectos.ciudad,



	proyectos.estado,



	proyectos.zip_code,



	proyectos.coordinador_obra_id,	



	actividades.Fecha,



	actividades.hora,



	actividades.descripcion,



	actividades.actividad_id,	



	tipo_actividad.actividad_nombre



	from tipo_actividad inner join 



	(actividades inner join proyectos on actividades.pro_id=proyectos.pro_id) on tipo_actividad.tipo_actividad_id=actividades.tipo_actividad_id 



	where actividades.fecha between '$af1' and '$af2' order by nombre,fecha,hora";	



	$result=$bd->ejecutar($sql);



	  // titulo del reporte



   	membrete($pdf,$vfrom_date);



	encabezado($pdf,$af1,$af2);







    if(mysql_num_rows($result)>0) 		 



	{		



		$bandera=1;	



		$bandera_2=1;	



		$aux3=$pdf->GetY();



		$aux=$pdf->GetY()+2;



		while($row=mysqli_fetch_array($result))



			{	



				///*****************************************************



				//*BUSQUEDA DE PERSONAL DEL PROYECTO



				$sql="select personal.nombre, personal.Nick_Name  from personal inner join 



				(actividad_personal inner join actividades on actividad_personal.actividad_id=actividades.actividad_id)



				on personal.empleado_id=actividad_personal.empleado_id where actividades.actividad_id=".$row["actividad_id"];



				$result2=$bd->ejecutar($sql);						



				$vempleados="";



			    if(mysql_num_rows($result2)>0) 		 



				{



					$vempleados="";



					while($row2=mysqli_fetch_array($result2))



					{	



						if($vempleados=="")



							{



							//$vempleados=$row2["nombre"];



							$vempleados=$row2["Nick_Name"];



							}



						else



							{



							$vempleados=$vempleados.", ".$row2["Nick_Name"];



							}



					}







				}



				



				$sql2="select * from personal where Empleado_ID=".$row['coordinador_obra_id'];



				$result3=$bd->ejecutar($sql2);						



			    if(mysql_num_rows($result3)>0) 		 



				{



					$row3=mysqli_fetch_array($result3);



					//$vcontacto=$row3['Nombre']." ".$row3['Apellido_Paterno']." ".$row3['Apellido_Materno'];



					$vcontacto=$row3['Nick_Name'].": ".$row3['Celular'];

					//echo $vcontacto;

				}





			  //********************************************************************



			  // DETALLE



			  //********************************************************************



				  $tono = ($tono==240) ? 200 : 240;



				  $pdf->SetFillColor($tono);



				  



				  $pdf->SetY($aux);



				  $pdf->SetX(10);



  			      $pdf->Rect(10, $aux, 260,10,'F');  	  	  



//				  $dato=date_create($row["fecha"]);



//				  $fecha=date_format($dato,'y/m/d');



				  $pdf->Multicell(70,5,($row['codigo'].",".$row['nombre']." Add:".$row['calle'].",".$row['ciudad'].",".$row['estado'].",".$row['zip_code']." Contac:".$vcontacto),0,L,true);

				  

				  $aux77=$pdf->GetY();				  



				  $pdf->SetY($aux);



				  $pdf->SetX(80);



				  //echo $row['fecha'];



				  $pdf->Multicell(25,5,FormatDateTime($row['Fecha'],8),0,L,true);



				  $pdf->SetY($aux);



				  $pdf->SetX(110);



				  $pdf->Multicell(25,5,$row['hora'],0,L,true);



				  $pdf->SetY($aux);					  



				  $pdf->SetX(130);



				  $pdf->Multicell(25,5,$row['actividad_nombre'],0,L,true);



				  $pdf->SetY($aux);



				  $pdf->SetX(155);



				  $pdf->Multicell(45,5,$row['descripcion'],0,L,true);



				  $pdf->SetY($aux);



				  $pdf->SetX(220);					  



				  $pdf->Multicell(50,5,$vempleados,0,L,true);



				  $pdf->SetY($aux77+10);				  

				  $aux66=$pdf->GetY();	

				  if($aux66>=190)

				  {

					$pdf->AddPage('L');

					membrete($pdf);

					encabezado($pdf,$af1,$af2);

					$aux77=$pdf->GetY();				

				 }

				 $pdf->SetY($aux77);

				 $aux=$pdf->GetY();



			}



		  



	}		



	per_sin_act(&$pdf,$af1,$af2,$bd);



	pro_ult_sem(&$pdf,$bd);		



	$pdf->Output("dato.pdf");



	?>



	<embed src="dato.pdf#toolbar=1&navpanes=0&scrollbar=0" width="1200" height="500"></embed>



    <?



	require('Library/Close_Conexion.php');	



?>















