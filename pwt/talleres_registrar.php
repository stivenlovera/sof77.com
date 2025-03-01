<?php	 		
	session_name("Administrador");
	session_start();		
	if ($_SESSION["EntityID"] == "")
	{
		header("Location:sessionexpired.php"); 	
	}	 	
		
	require('Library/Control_Cache.php');	
	require('Library/Open_Conexion.php');	
	require('Library/funciones.php');
	
	$fecha_desde=ConvertDateToMysqlFormat($_GET['f_Mes_Reporte']);
	
	
	$anio=substr($fecha_desde,0,4);
	$mes_configuracion=substr($fecha_desde,5,2);

	
	$consulta = "SELECT  c.Nombre, c.Apellido, co.Conduce_Movil, co.Conduce_Dias_Taller, co.Conduce_Monto_Frecuencia, co.Forma_de_Pago, co.Cond_ID 
					FROM conduce co INNER JOIN conductor c ON co.Cond_ID=c.Cond_ID WHERE  co.Fecha_Baja IS NULL AND c.Agent_ID=".$_SESSION["EntityID"] ." ORDER BY co.Conduce_Movil " ;   
	//echo $consulta . "<br>";
	$contador=1;
	$result44=$bd->ejecutar($consulta); 	
	
	while (($row44 = mysqli_fetch_array($result44) ))  							
	{	
		$contador++;	
		//if ($contador>=50)
		if (1==1)
		{ 
			$Cond_ID = $row44["Cond_ID"];
			$Nombre=$row44["Nombre"]." ".$row44["Apellido"];
			$Movil=$row44["Conduce_Movil"];
			$Conduce_Dias_Taller=$row44["Conduce_Dias_Taller"];
			$Conduce_Monto_Frecuencia=$row44["Conduce_Monto_Frecuencia"];
			$Forma_de_Pago=$row44["Forma_de_Pago"];
			$Conduce_Dias_Taller=$row44["Conduce_Dias_Taller"];
			
			$Ultimo_dia_mes=$anio."-".$mes_configuracion."-".getUltimoDiaMes($anio,$mes_configuracion);
			
			$Talleres_Ya_Registrados=0; 
			//$consulta = "SELECT COUNT(*) AS Talleres_Ya_Registrados FROM deuda WHERE Deuda_Cond_ID=".$Cond_ID." AND  Fecha_Deuda>'".$anio."-".$mes_configuracion."-05' AND Tipo_Deuda_ID=1 AND Monto=0 AND Fecha_Deuda!='2015-12-06' AND  Fecha_Deuda!='2015-09-20'";			 
			$consulta = "SELECT COUNT(*) AS Talleres_Ya_Registrados FROM deuda WHERE Deuda_Cond_ID=".$Cond_ID." AND  Fecha_Deuda>'".$anio."-".$mes_configuracion."-05' AND Tipo_Deuda_ID=1 AND Monto=0 AND Fecha_Deuda<>'2016-09-10 00:00:00' ";			 
			//echo $consulta."<br>";
			$result=$bd->ejecutar($consulta); 
			if ($row = mysqli_fetch_array($result))  							
			{
				if ( is_null($row["Talleres_Ya_Registrados"]) )
					$Talleres_Ya_Registrados=0; 
				else
					$Talleres_Ya_Registrados = $row["Talleres_Ya_Registrados"];	
			}
			mysqli_free_result($result);	
			
			$consulta = "SELECT * FROM deuda WHERE Deuda_Cond_ID=".$Cond_ID." AND  Fecha_Deuda>NOW() AND Tipo_Deuda_ID=1 AND Monto=0 ";			 
			$result77=$bd->ejecutar($consulta); 
			//if ( (!($row77 = mysqli_fetch_array($result77))) || (1==1))  							
			if  (!($row77 = mysqli_fetch_array($result77)))   							
			{			
				if ( ($Conduce_Monto_Frecuencia<16)  && ($Forma_de_Pago!="Dia Trabajado") && ( ($Talleres_Ya_Registrados<3) || ( ($Conduce_Monto_Frecuencia<10) && ($Talleres_Ya_Registrados<10) ) )   )
				{	
					
					/*if ($Conduce_Monto_Frecuencia<10)
					{
						$total_dias = 3;
						$f_fecha_estado='2014-03-27';	
					}
					else
					{
						$total_dias = 1-$Talleres_Ya_Registrados;	
						$f_fecha_estado='2014-03-29';
					}*/
					
					$total_dias = ($Conduce_Dias_Taller-1)-$Talleres_Ya_Registrados;
					
					$i=0;
					$j=0;
						
					if ($total_dias>0)
					{
						$consulta = "SELECT DATE_ADD('".$Ultimo_dia_mes."', INTERVAL -".$total_dias." DAY) AS fecha  ";				 
						//echo $consulta."<br>";
						$result=$bd->ejecutar($consulta); 
						if (($row = mysqli_fetch_array($result) ))							
						{									
							$f_fecha_estado = $row["fecha"];			
						}
						mysqli_free_result($result);	
						
						//echo $total_dias."<br>";;
						
						//$Fecha_Deuda = $Ultima_Fecha_Pago;						
						$Monto=$Conduce_Monto_Frecuencia;				
					}
					
										
					//if	($Movil==66)							
						//echo $Movil."-".$Talleres_Ya_Registrados."-".$Conduce_Dias_Taller."<br>";
					$cont=1;
					while ( ($i<=$total_dias) && ($j<1000)	)						
					{		
								
						if ($i!=0)
						{
							$consulta = "SELECT DATE_ADD('".$f_fecha_estado."', INTERVAL 1 DAY) AS fecha  ";				 
							//echo $consulta."<br>";
							$result=$bd->ejecutar($consulta); 
							if (($row = mysqli_fetch_array($result) ))							
							{									
								$f_fecha_estado = $row["fecha"];			
							}
							mysqli_free_result($result);	
						}					
											
						//************************* INICIO: SE VERIFICA QUE NO SE TENGA DEUDA REGISTRAD AEN LA FECHA ACTUAL  **********************								
						$consulta = "SELECT * FROM deuda WHERE Deuda_Cond_ID=".$Cond_ID." AND  Fecha_Deuda='".$f_fecha_estado."'";			 
						//echo $consulta;
						$result=$bd->ejecutar($consulta); 
						if (! (($row = mysqli_fetch_array($result) ))  )							
						{	
							$sql = "insert into deuda (Fecha_Registro, Tipo_Deuda_ID, Deuda_Cond_ID, Monto, Fecha_Deuda) values (NOW(),1,".$Cond_ID.", 0, '".$f_fecha_estado."')";																		
							//echo $Movil."-".$Nombre."-".$Talleres_Ya_Registrados.")".$sql."<br>";
							echo $Movil."-".$Nombre."- Taller ".$cont."-".$f_fecha_estado."<br>";
							$res1=$bd->ejecutar($sql);		
							$i++;	
							$cont++;						
						}
						else
						{
							if ($i==0)
							{
								$i++;
								$total_dias++;							
							}	
						}	
						mysqli_free_result($result);	
						//************************* FIN: SE VERIFICA QUE NO SE TENGA DEUDA REGISTRAD AEN LA FECHA ACTUAL  **********************			
						
						$j++;						
					}								
				}
				else
				{
					if ($Forma_de_Pago=="Dia Trabajado")
					{
						//if ($Talleres_Ya_Registrados>15
					}
				}
			}
			mysqli_free_result($result77);	

		}
		echo "<br>";
	}
	mysqli_free_result($result44);		
		
	require('Library/Close_Conexion.php');	
?>