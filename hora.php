<?php
  function hora_actual(&$fecha,&$hora_actual)
/*	{
	$utctime=gmdate("H:i:s",time());
	$hora_actual = date('H:i:s', strtotime ($utctime.' -300 minutes'));
    
	//echo "//".$horas."//";
    $fecha=date('Y-m-d');
	$f1=date('Y-m-d', '2018-11-03');		
	$f2=date('Y-m-d', '2019-03-10');
//	echo $f1."///--/".$f2;
	if ($fecha > $f1 && $fecha < $f2)
				{
					$horas = date('H:i:s', strtotime ($utctime.' -300 minutes'));
	//echo "//".$horas."//";
				}
	}*/
	
{
    date_default_timezone_set('US/Eastern');
	$utctime=date("H:i:s",time());
//	$utctime=date('h:i:s:u');

//	$hora_actual = date('H:i:s', strtotime ($utctime.' -728 minutes'));
	$hora_actual=$utctime;    
	//echo "//utctime:".$utctime." Hora actual:".$hora_actual."//<br>";
		
    $fecha=date('Y-m-d');
	// 1ST ********  mm/dd/yyyy
/*	$f1 = strtotime('11/05/2018');
	$f1 = date('Y-m-d',$f1);
	$f2 = strtotime('03/10/2019');
	$f2 = date('Y-m-d',$f2);
	//echo "fecha: ".$fecha."  F1:".$f1."  F2:".$f2."<br>";
	if ($fecha > $f1 && $fecha < $f2)
			{
				$hora_actual = date('H:i:s', strtotime ($utctime.' -300 minutes'));
	
			}

   //2ND:	03/11/2019	11/03/2019	-240  ***  mm/dd/yyyy
	$f1 = strtotime('03/11/2019');
	$f1 = date('Y-m-d',$f1);
	$f2 = strtotime('11/03/2019');
	$f2 = date('Y-m-d',$f2);
	//echo "fecha: ".$fecha."  F1:".$f1."  F2:".$f2."<br>";
	if ($fecha > $f1 && $fecha < $f2)
			{
				$hora_actual = date('H:i:s', strtotime ($utctime.' -240 minutes'));
	
			}
	
   //3RD:	11/04/2019	03/08/2020	-300   ***  mm/dd/yyyy
	$f1 = strtotime('11/04/2019');
	$f1 = date('Y-m-d',$f1);
	$f2 = strtotime('03/08/2020');
	$f2 = date('Y-m-d',$f2);
	//echo "fecha: ".$fecha."  F1:".$f1."  F2:".$f2."<br>";
	if ($fecha > $f1 && $fecha < $f2)
			{
				$hora_actual = date('H:i:s', strtotime ($utctime.' -300 minutes'));
	
			}
   //4TH:	03/09/2020	11/01/2020	-240   ***  mm/dd/yyyy
	$f1 = strtotime('03/09/2020');
	$f1 = date('Y-m-d',$f1);
	$f2 = strtotime('11/01/2020');
	$f2 = date('Y-m-d',$f2);
	//echo "fecha: ".$fecha."  F1:".$f1."  F2:".$f2."<br>";
	if ($fecha > $f1 && $fecha < $f2)
			{
				$hora_actual = date('H:i:s', strtotime ($utctime.' -240 minutes'));
	
			}
   //5TH:	11/02/2020	03/14/2021	-300   ***  mm/dd/yyyy
	$f1 = strtotime('11/02/2020');
	$f1 = date('Y-m-d',$f1);
	$f2 = strtotime('03/14/2021');
	$f2 = date('Y-m-d',$f2);
	//echo "fecha: ".$fecha."  F1:".$f1."  F2:".$f2."<br>";
	if ($fecha > $f1 && $fecha < $f2)
			{
				$hora_actual = date('H:i:s', strtotime ($utctime.' -300 minutes'));
	
			}
   //6TH:	03/15/2021	11/07/2021	-240   ***  mm/dd/yyyy
	$f1 = strtotime('03/15/2021');
	$f1 = date('Y-m-d',$f1);
	$f2 = strtotime('11/07/2021');
	$f2 = date('Y-m-d',$f2);
	//echo "fecha: ".$fecha."  F1:".$f1."  F2:".$f2."<br>";
	if ($fecha > $f1 && $fecha < $f2)
			{
				$hora_actual = date('H:i:s', strtotime ($utctime.' -728 minutes'));
	
			} 
   //5TH:	11/08/2021	03/12/2022	-788   ***  mm/dd/yyyy
	$f1 = strtotime('11/08/2021');
	$f1 = date('Y-m-d',$f1);
	$f2 = strtotime('03/12/2022');
	$f2 = date('Y-m-d',$f2);
	//echo "fecha: ".$fecha."  F1:".$f1."  F2:".$f2."<br>";
	if ($fecha > $f1 && $fecha < $f2)
			{
				$hora_actual = date('H:i:s', strtotime ($utctime.' -788 minutes'));
	
			}
   //6TH:	03/13/2022	11/05/2022	-728   ***  mm/dd/yyyy
	$f1 = strtotime('03/13/2022');
	$f1 = date('Y-m-d',$f1);
	$f2 = strtotime('11/05/2022');
	$f2 = date('Y-m-d',$f2);
	//echo "fecha: ".$fecha."  F1:".$f1."  F2:".$f2."<br>";
	if ($fecha > $f1 && $fecha < $f2)
			{
				$hora_actual = date('H:i:s', strtotime ($utctime.' -728 minutes'));
	
			} 
			
			




	echo "/////".$hora_actual."Hora_actual <br>"; */
	}	
	
?>	

	
	
