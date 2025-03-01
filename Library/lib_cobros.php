<?php
function materias_actuales($estudiante,$Periodo,$bd,$link)
{

	$cantmat_a=0;
	//cuanta las materias del periodo actual
	//echo "<br>select distinct materia,periodo,nota,obs,ci from computacion where estudiante='$estudiante' and obs<>'ABANDONO' ORDER BY PERIODO";
	$sql="select distinct materia,periodo,nota,obs,ci from computacion where estudiante='$estudiante' and obs<>'ABANDONO' AND (obs<>'CONVALIDACION') ORDER BY PERIODO"; 
	$result3=$bd->ejecutar($sql);      
	while($row3 = mysql_fetch_array($result3))
	{
		$materia=$row3[0];		
		$periodo=$row3[1];
		if($periodo==$Periodo)
		{
			$cantmat_a=$cantmat_a+1;
		}		
	}
	mysql_free_result($result3);		
	return $cantmat_a;
}

function materias_anteriores($estudiante,$Periodo,$bd,$link)
{

	$cantmat=0;
	//if (strtoupper($estudiante)=="LUQUE BURGOA MIGUEL ANTONIO")
	//echo "** materias_anteriores ** $estudiante  select fecha_fin from periodo where cod_periodo='$Periodo'<br>";
	$sql="select fecha_fin from periodo where cod_periodo='$Periodo'";	
	$result3=$bd->ejecutar($sql);   
	//echo $sql;        
    while($row3 = mysql_fetch_array($result3))
    {
		$fecha_fin=$row3[0];
	}
	mysql_free_result($result3);	
	
	//cuanta las materias del periodo actual y de periodos pasados del estudiante actual
	//echo "<br>select distinct materia,periodo,nota,obs,ci from computacion where estudiante='$estudiante' and obs<>'ABANDONO' ORDER BY PERIODO";
	//$result3=mysql_query("select distinct materia,periodo,nota,obs,ci from computacion where estudiante='$estudiante' and obs<>'ABANDONO' ORDER BY PERIODO",$link);      
	$sql="select distinct materia,periodo,nota,obs, segunda,turno 
								from computacion  INNER JOIN periodo ON (computacion.PERIODO = periodo.cod_periodo)
							  where estudiante='$estudiante' AND (obs<>'ABANDONO') AND (obs<>'ABANDONADO')
							ORDER BY  periodo.fecha_ini";
	$result3=$bd->ejecutar($sql);   
	//echo $sql;        
    while($row3 = mysql_fetch_array($result3))
    {
		$materia=$row3[0];		
        $periodo=$row3[1];		
		$result33=$bd->ejecutar("select fecha_fin from periodo where cod_periodo='$periodo'");   
		while($row33 = mysql_fetch_array($result33))
		{	
			$fecha_fin_mat=$row33['fecha_fin'];	
		}
		mysql_free_result($result33);	
		
		if($fecha_fin_mat<=$fecha_fin)
		{
	        $nota=$row3[2];
			$obs=$row3[3];
			$cantmat=$cantmat+1;			
		}		
	 }
	 mysql_free_result($result3);	
	return $cantmat;
}

function pagos_bs($estudiante,$bd,$link)
{
	$acummontobs=0;
	$sql="select distinct numrecibo,montobs,montosus,concepto,fecha,estudiante,numfactura from pagop9 where estudiante='$estudiante' and (numrecibo<>'0' or numfactura<>'0') and numfactura<>numrecibo ORDER BY numrecibo";      
	$result2=$bd->ejecutar($sql); 
    while($row2 = mysql_fetch_array($result2))
	{
		$numrecibo=$row2[0];
		$montobs=$row2[1];
		$montosus=$row2[2];
		$concepto=$row2[3];
		$fecha=$row2[4];
		$estudiante=$row2[5];
		$numfactura=$row2[6];
		$acummontobs=$acummontobs+$montobs;		
	}
	mysql_free_result($result2);	
	return $acummontobs;
}

function pagos_sus($estudiante,$bd,$link)
{
	$acummontosus=0;
	$sql="select distinct numrecibo,montobs,montosus,concepto,fecha,estudiante,numfactura from pagop9 where estudiante='$estudiante' and (numrecibo<>'0' or numfactura<>'0') and numfactura<>numrecibo ORDER BY numrecibo";      
	$result2=$bd->ejecutar($sql); 
    while($row2 = mysql_fetch_array($result2))
    {
		$numrecibo=$row2[0];
		$montobs=$row2[1];
		$montosus=$row2[2];
		$concepto=$row2[3];
		$fecha=$row2[4];
		$estudiante=$row2[5];
		$numfactura=$row2[6];
		$acummontosus=$acummontosus+$montosus;		
	}
	mysql_free_result($result2);	
	return $acummontosus;
}
function cambio_bs_sus($estudiante,$bd,$link)
{
	$acummontobssus=0;	
	$sql="select distinct numrecibo,montobs,montosus,concepto,fecha,estudiante,numfactura from pagop9 where estudiante='$estudiante' and (numrecibo<>'0' or numfactura<>'0') and numfactura<>numrecibo ORDER BY numrecibo";
	$result2=$bd->ejecutar($sql);       
	while($row2 = mysql_fetch_array($result2))
	{
		$numrecibo=$row2[0];
		$montobs=$row2[1];
		$montosus=$row2[2];
		$concepto=$row2[3];
		$fecha=$row2[4];
		$estudiante=$row2[5];
		$numfactura=$row2[6];
			//if (strtoupper($estudiante)=="LUQUE BURGOA MIGUEL ANTONIO")
			//echo "**  cambio_bs_sus **  $estudiante  select cambioo from tipocambio where fecha='$fecha'<br>";     		
			
			$result33=$bd->ejecutar("select cambioo from tipocambio where fecha='$fecha'");   
			while($row33 = mysql_fetch_array($result33))
			{	
				$cambioo=$row33['cambioo'];	
			}
			mysql_free_result($result33);	
			
       		if($cambioo!=0)
      		{
       			$acummontobssus=$acummontobssus+bcdiv($montobs,$cambioo,2);
       		}
		
	}
	mysql_free_result($result2);
	return $acummontobssus;
}

function descuentos($estudiante,$bd,$link)
{
	$acumdescuentos=0;
	$sql="select distinct monto from descuento where estudiante='$estudiante' order by periodo";      
	
    $result6=$bd->ejecutar($sql);   
	while($row6 = mysql_fetch_array($result6))
    {
       	$descuento=$row6[0];        	      
	 	$acumdescuentos=$acumdescuentos+$descuento;
	}
	mysql_free_result($result6);	
	return $acumdescuentos;
}


function costo_convalidacion($estudiante,$bd,$link)
{
	$acumcostoconv=0;

	$result7=$bd->ejecutar("select distinct cod_materia,cod_periodo,cod_conv from asigconvalidacion where estudiante='$estudiante'");
    while($row7 = mysql_fetch_array($result7))
    {        	
		$cod_conv=$row7[2];		
		$result33=$bd->ejecutar("select costo_mat from convalidacion where cod_conv='$cod_conv'");   
			while($row33 = mysql_fetch_array($result33))
			{	
				$costo_mat=$row33['costo_mat'];	
			}
			mysql_free_result($result33);	
		$acumcostoconv=$acumcostoconv+$costo_mat;		
	}
	mysql_free_result($result7);	
	return $acumcostoconv;
}	

function numero_convalidaciones($estudiante,$bd,$link)
{
	$cantmatconv=0;	
	$result7=$bd->ejecutar("select distinct materia from computacion where estudiante='$estudiante' and obs='CONVALIDACION'");      
	while($row7 = mysql_fetch_array($result7))
	{        	
		$cantmatconv=$cantmatconv+1;
	}
	mysql_free_result($result7);	
	return $cantmatconv;
}
function monto_planes_noactivos($estudiante,&$acumcantmatp,&$montoporpagarp,$bd,$link)
{
	$acumcantmatp=0;
	$montoporpagarp=0;
	$frecuencia_pago=1;					
	$cantmatriculasp=0;
	$result12=$bd->ejecutar("SELECT DISTINCT e.cod_plan,i.cantmat,e.monto_total,e.monto_mes,e.monto_mat, e.nombre,  e.frecuencia_pago, e.frecuencia_matricula from plan_inversion e,planpago i where i.estudiante='$estudiante' and e.cod_plan=i.cod_plan and i.estado='NoActivo'");  
	while($row12 = mysql_fetch_array($result12))
    {        		
        		$cantmatp=$row12[1];
        		$monto_total=$row12[2];
          		$monto_cuota=$row12[3];
          		$monto_mat=$row12[4];        
          		$frecuencia_pago=$row12[6]; 
				$frecuencia_matri=$row12[7];         		
           		$acumcantmatp=$acumcantmatp+$cantmatp;  

           		if($monto_mat!=0)
           		{
            			if ($cantmatp%$frecuencia_matri>0)
				{
					$cantmatriculasp=1+(bcdiv ($cantmatp,$frecuencia_matri,0));
				}
				else	
				{
					$cantmatriculasp=bcdiv ($cantmatp,$frecuencia_matri,0);
				}
           		}
           
           		$numcuotasp=$cantmatp/$frecuencia_pago;
           		if($numcuotasp<=1)
           		{
          			$numcuotasp=1;
           		}
           		else
           		{
	           		if($cantmatp%$frecuencia_pago==0)
        	   		{
					$numcuotasp=$cantmatp/$frecuencia_pago;
		   		}
           	   		else 
            		{
						$numcuotasp=1+bcdiv ($cantmatp,$frecuencia_pago,0);
		   			}
           		}
            		$montoporpagarp=$montoporpagarp+($numcuotasp*$monto_cuota)+($monto_mat*$cantmatriculasp);
				 				
        } 
		mysql_free_result($result12);				
}	

function monto_plan_activos($ci,$estudiante,$cod_plan,$cantmat,$cantmatconv,$acumcantmatp,$bd,$link)
{
	$montoporpagarpa=0;
	$frecuencia_pago=1;
	$cantmatriculaspa=0;

        //se calcula cuanto deberia el alumno por las materias tomadas y por su plan  de pago actual hasta la fecha

	$result11=$bd->ejecutar("SELECT DISTINCT pi.cod_plan, pp.cantmat,pi.monto_total,pi.monto_mes,pi.monto_mat, pi.nombre,  pi.frecuencia_pago, pi.frecuencia_matricula from plan_inversion pi inner join planpago pp on pi.cod_plan=pp.cod_plan where pp.ci=$ci and pp.estado='activo' ");  
    while($row11 = mysql_fetch_array($result11))
    {
	        	$cod_plan=$row11[0];
	        	$cantmatpa=$row11[1];	        	
	           	$monto_total=$row11[2];
	          	$monto_cuotaa=$row11[3];
	          	$monto_mata=$row11[4];
	          	$plana=$row11[5];
	          	$frecuencia_pago=$row11[6]; 
				$frecuencia_matri=$row11[7];         	         	         	
	          	if ( $frecuencia_pago>0)
	          	{	
				$numcuotaspa=(($cantmat-$acumcantmatp)-$cantmatconv)/$frecuencia_pago;
				}	
	          	else
	          		$numcuotaspa=(($cantmat-$acumcantmatp)-$cantmatconv);

				          	
	          	if($numcuotaspa<=1)
	          	{
	          		$numcuotaspa=1;
	          	}
	          	else
	          	{
	           		if ( $frecuencia_pago>0)
	           		{
	           			if((($cantmat-$acumcantmatp)%$frecuencia_pago)==0)
	            			{
						$numcuotaspa=(($cantmat-$acumcantmatp)-$cantmatconv)/$frecuencia_pago;
					}
	           			else 
	            			{
						$numcuotaspa=1+bcdiv ((($cantmat-$acumcantmatp)-$cantmatconv),$frecuencia_pago,0);
					} 					
				}
				else
				{
					if((($cantmat-$acumcantmatp)%$frecuencia_pago)==0)
	            			{
						$numcuotaspa=(($cantmat-$acumcantmatp)-$cantmatconv);
					}
	           			else 
	            			{
						$numcuotaspa=1+bcdiv ((($cantmat-$acumcantmatp)-$cantmatconv),$frecuencia_pago,0);
					} 
				}
	          	}
	           	if($monto_mata!=0)
	           	{
	            		if(($cantmat-$acumcantmatp)%$frecuencia_matri>0)
						{
							$cantmatriculaspa=1+(bcdiv (($cantmat-$acumcantmatp),$frecuencia_matri,0));
						}
						else	
						{
							$cantmatriculaspa=bcdiv (($cantmat-$acumcantmatp),$frecuencia_matri,0);
						}
				
			}	          
	          	$montoporpagarpa=$montoporpagarpa+($monto_cuotaa*$numcuotaspa)+($monto_mata*$cantmatriculaspa);	         
		}
		mysql_free_result($result11);
		return $montoporpagarpa;
}

function datos_deuda($ci,$estudiante,$bd,$Periodo,&$montoporpagar,&$debe,&$cantmat_a,&$cantmat,&$acummontobs,&$acummontosus,&$acummontobssus,&$acumdescuentos,&$totalsus,&$monto_total,&$monto_cuotaa,&$monto_mata,&$plana,$mat_adi,$link)
{
	$cantmat_a=materias_actuales($estudiante,$Periodo,$bd,$link);
	$cantmat=materias_anteriores($estudiante,$Periodo,$bd,$link);
	//echo "$cantmat=materias_anteriores($estudiante,$Periodo,bd,link);<br>";
	$cantmatconv=numero_convalidaciones($estudiante,$bd,$link);
	//echo "$cantmatconv=numero_convalidaciones($estudiante,$link);<br>";
	
	$cantmat=$cantmat+$mat_adi-$cantmatconv;	
	
	$acummontobs=pagos_bs($estudiante,$bd,$link);
	$acummontosus=pagos_sus($estudiante,$bd,$link);
	$acummontobssus=cambio_bs_sus($estudiante,$bd,$link);
	$acumdescuentos=descuentos($estudiante,$bd,$link);	
	$acumcostoconv=costo_convalidacion($estudiante,$bd,$link);																																																																																																																																																																																																																																																																																																																																																													/*aqui if  ( (date("m")>="11") && (date("d")>"10")){ $acummontosus=$acummontosus*0.3;$acummontobssus=$acummontobssus*0.45;}*/
	$totalsus=$acummontosus+$acummontobssus;							    		
		//echo "$totalsus=$acummontosus+$acummontobssus;<br>";
	monto_planes_noactivos($estudiante,$acumcantmatp,$montoporpagarp,$bd,$link);        			
	
	$cod_plan="";
	$plana="xx";
	$monto_mata=0;
	$monto_cuotaa=0;	
	$result11=$bd->ejecutar("SELECT DISTINCT pi.monto_total, pi.monto_mes, pi.monto_mat, pi.nombre, pp.cod_plan from plan_inversion pi inner join planpago pp on  pi.cod_plan=pp.cod_plan where pp.ci=$ci and pp.estado='activo' ");       
	while($row11 = mysql_fetch_array($result11))
	{	 
		$monto_total=$row11[0];
		$monto_cuotaa=$row11[1];
		$monto_mata=$row11[2];
		$plana=$row11[3];
		$cod_plan=$row11[4];		
	}
	mysql_free_result($result11);																
	
	if ($cod_plan!="")
		$montoporpagarpa=monto_plan_activos($ci,$estudiante,$cod_plan,$cantmat,$cantmatconv,$acumcantmatp,$bd,$link);																																    else
		$montoporpagarpa=0;
		
	if ($plana=="xx")
		$plana="Sin Plan";
      	
    $total_por_pagar=$montoporpagarpa+$montoporpagarp;
    $xxx=plan_cyt($cod_plan,$cantmat);	                     
	//echo ("PLan=$cod_plan monto = $xxx");
	if($xxx!=-111)
		$total_por_pagar=$xxx;     
        
     $montoporpagar=0;	    		   	
	//	echo "$montoporpagar=$total_por_pagar+$acumcostoconv;<br>";	    
	$montoporpagar=$total_por_pagar+$acumcostoconv;	
	$debe=$montoporpagar-($totalsus+$acumdescuentos);
	//echo "$debe=$montoporpagar-($totalsus+$acumdescuentos);";	
	
}
function ingreso_actual($estudiante,$bd,$Periodo,&$montoporpagar,&$cantmat_a,&$cantmat,&$plana,&$pago_cuota,&$pago_matri,$link)
{
	$cantmat_a=materias_actuales($estudiante,$Periodo,$bd,$link);
	$cantmat=materias_anteriores($estudiante,$Periodo,$bd,$link);
	$cantmatconv=numero_convalidaciones($estudiante,$link);
	$xx=monto_planes_noactivos($estudiante,$acumcantmatp,$montoporpagarp,$link);        		
	$materia_plan_act=$cantmat-$cantmatconv-$acumcantmatp;
	$plana="xx";
	$monto_cuotaa=0;
	$monto_matri=0;
	 
	$result11=$bd->ejecutar("SELECT DISTINCT e.monto_mes,e.monto_mat, e.nombre,  e.frecuencia_pago,e.frecuencia_matricula from plan_inversion e,planpago i where i.estudiante='$estudiante' and e.cod_plan=i.cod_plan and i.estado='activo' "); 	   
	while($row11 = mysql_fetch_array($result11))
	{	 			
	        $monto_cuota=$row11[0];
	        $monto_matri=$row11[1];
	        $plana=$row11[2];
			$frec_cuota=$row11[3];
			$frec_matri=$row11[4];

			/*if ( (strtoupper($estudiante)=="CONDORI JUYARI MERY") || (strtoupper($estudiante)=="GALVEZ GIL MILKO FERNANDO") )
			{
				echo "$materia_plan_act=$cantmat-$cantmatconv-$acumcantmatp<br>";
				echo "Mat Plan A=$materia_plan_act ** $monto_cuota=$row11[0]  **   $monto_matri=$row11[1] ** $plana=$row11[2]  **  $frec_cuota=$row11[3]  **  $frec_matri=$row11[4]<br>";
			}*/

			$pago_cuota=0;
          	if (($monto_cuota>0)&&( $frec_cuota>0))
          	{	
				if ($frec_cuota==1)
					$pago_cuota=$monto_cuota;
				else
				{
					if ($frec_cuota>1)
					{
						$aa=($materia_plan_act)%$frec_cuota;
						if ( ($aa==1) || ($aa==$cantmat_a) )
						{
							$pago_cuota=$monto_cuota;
						}
					}
				}
			}			
			$pago_matri=0;
          	if (($monto_matri>0)&&( $frec_matri>0))
          	{	
				if ($frec_matri==1)
					$pago_matri=$monto_matri;
				else
				{
					if ($frec_matri>1)
					{
						$aa=($materia_plan_act)%$frec_matri;
						if (($aa==1)||($aa==$cantmat_a))
						{
							$pago_matri=$monto_matri;
						}
					}
				}
			}	
	}
	mysql_free_result($result11);	
	$montoporpagar=$pago_cuota+$pago_matri;
	/*if ( (strtoupper($estudiante)=="CONDORI JUYARI MERY") || (strtoupper($estudiante)=="GALVEZ GIL MILKO FERNANDO") )
				echo "$aa ** $montoporpagar=$pago_cuota+$pago_matri<br>";
	*/
}
	

function plan_cyt($cod_plan,$cantmat)
{	
	$total_por_pagar=-111;	
	if($cod_plan==50)
	{
	        if ($cantmat==1)
	        	$total_por_pagar=42;
	        else if ($cantmat==2)
	        	$total_por_pagar=47;
	        		else if ($cantmat==3)
		        		$total_por_pagar=54;
	        		else if ($cantmat==4)
		        		$total_por_pagar=61;
	        		else if ($cantmat==5)
			        	$total_por_pagar=70;
		        	else if ($cantmat==6)
		        		$total_por_pagar=116;
		        	else if ($cantmat==7)
		        		$total_por_pagar=127;
		        	else if ($cantmat==8)
		        		$total_por_pagar=138;
		        	else if ($cantmat==9)
		        		$total_por_pagar=151;
		        	else if ($cantmat==10)
		        		$total_por_pagar=164;
		        	else if ($cantmat==11)
		        		$total_por_pagar=216;
		        	else if ($cantmat==12)
		        		$total_por_pagar=231;
		        	else if ($cantmat==13)
		        		$total_por_pagar=248;
		        	else if ($cantmat==14)
		        		$total_por_pagar=265;
		        	else if ($cantmat==15)
		        		$total_por_pagar=284;
		        	else if ($cantmat==16)
		        		$total_por_pagar=340;
					else if ($cantmat==17)
		        		$total_por_pagar=369;
	        		else if ($cantmat==18)
		        		$total_por_pagar=398;
	        		else if ($cantmat==19)
			        	$total_por_pagar=427;
		        	else if ($cantmat==20)
		        		$total_por_pagar=456;
		        	else if ($cantmat==21)
		        		$total_por_pagar=522;
		        	else if ($cantmat==22)
		        		$total_por_pagar=551;
		        	else if ($cantmat==23)
		        		$total_por_pagar=580;
		        	else if ($cantmat==24)
		        		$total_por_pagar=609;
		        	else if ($cantmat==25)
		        		$total_por_pagar=638;
		        	else if ($cantmat==26)
		        		$total_por_pagar=704;
		        	else if ($cantmat==27)
		        		$total_por_pagar=733;
		        	else if ($cantmat==28)
		        		$total_por_pagar=762;
		        	else if ($cantmat==29)
		        		$total_por_pagar=791;
		        	else if ($cantmat==30)
		        		$total_por_pagar=	820;         		
	}            
	return $total_por_pagar;
}

function datos_compromiso($cii,$fecha_fin,&$ccc,&$suma_aldia,$bd,$link)
{
	$fechax=date("Y-m-d");        
    //selecionamos los detalles de los compromisos firmados con estado=SI del alumno actual      
	$result11=$bd->ejecutar("SELECT DISTINCT contenido_compromiso.monto,contenido_compromiso.fecha FROM contenido_compromiso, compromiso_pago
        						WHERE  (compromiso_pago.cod_compromiso = contenido_compromiso.cod_compromiso) AND 
							       (compromiso_pago.ci = $cii) AND (compromiso_pago.fecha<='$fecha_fin') AND 
							       (compromiso_pago.estado = 'SI') ");  
									   	   									      
	$ccc=0;				   
	$suma_aldia=0;
      	while($row11 = mysql_fetch_array($result11))
      	{
      		//acumulo los monto comprometido
      		$ccc=$ccc+$row11[0];
      		//acumulo lo que debria haber cancelado a la fecha
      		if($row11[1]<=$fechax)
      		{
      			$suma_aldia=$suma_aldia+$row11[0];
      		}      		
      	}
		mysql_free_result($result11);	
}

function datos_mora($ccc,$suma_aldia,$debe,&$enmora,&$puede_deber)
{
	
      	if($ccc>0)
      	{
      	
      		//calculo cuanto podria deber a la fecha
		if($ccc>$suma_aldia)
			$puede_deber=$ccc-$suma_aldia; 
		else
			$puede_deber=0;
				 
		//si su deuda actual es menor a lo que puede deber segun compromizo		
      			if (bcdiv($debe,1,0)<=$puede_deber)	
      			{
      				$enmora=0;
      			}
      			else
      			{
      				$enmora=$debe-$puede_deber;
      			}      		
      	}
      	else
      	{
      		$puede_deber=0;
      		$enmora=$debe;      		
      	}
}
?>