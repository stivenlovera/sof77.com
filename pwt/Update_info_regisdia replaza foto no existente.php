<?php	 		
	/// update pictures on the ones does not have 
	
	session_name("Administrador");
	session_start();		
			
	require('Library/Control_Cache.php');	
	require('Library/Open_Conexion.php');	
	require('Library/funciones.php');	
	
	exit('not in service contact the ADM OR DISIGNER !');
	
	/// remplaza fotos 
			$consulta7="select * from registro_diario where Pro_ID=1617";
			echo $consulta7."<br>";	
			//exit ();
			$result7=$bd->ejecutar($consulta7); 	
			while (($row7 = mysqli_fetch_array($result7) ))
			{
				$regID=$row7["Reg_ID"];
				$emp_ID=$row7["Empleado_ID"];
				$Foto_Ingreso=$row7["Foto_Ingreso"];
				$Foto_Salida=$row7["Foto_Salida"];
				$Foto_Ingreso=$row7["Foto_Ingreso"];
				$Fecha=$row7["Fecha"];
				$xfoto="";
				$xfotos="";
					$file_pointer = "fotos/".$Foto_Ingreso;
  							if (file_exists($file_pointer) and $Foto_Ingreso<>"archivefoto.jpeg")  
							{ 
								$xfoto="Ex_i"; 
								echo "FOTO ingreso EXISTE "."<br>";
							} 
							else 
							{ 
								//echo "The file".$file_pointer." does 	 not exists"; 
								$xfoto="No";
								echo "Reg.Foto Ingreso no existe foto RD:".$regID."  /Emp.ID:".$emp_ID."  ".$Fecha."<br>";
								//echo "The file:".$Foto_Ingreso." does  not exists"; 
							} 
					$file_pointer = "fotos/".$Foto_Salida;
  							if (file_exists($file_pointer)and $Foto_Salida<>"archivefoto.jpeg")  
							{ 
								$xfotos="ExS"; 
								echo "FOTO salida EXISTE "."<br>";
							} 
							else 
							{ 
								//echo "The file".$file_pointer." does 	 not exists"; 
								$xfotos="No";
								echo "Reg.Foto SALIDA no existe foto RD:".$regID."  /Emp.ID:".$emp_ID."  ".$Fecha."<br>";
								//echo "The file:".$Foto_Ingreso." does  not exists"; 
							} 
				if ($xfotos=="No" or $xfoto=="No" )
				{
					//$month=rand(1,9);
					$month=substr($Fecha,5,2);
					
					$consulta8 = "SELECT * FROM registro_diario  where Empleado_ID='".$emp_ID."' and Pro_ID<>1617 and Foto_Ingreso is not null and Foto_Salida is not null  and Foto_Ingreso<>'' and fecha>'2022-".$month."-01'"; 
				echo $consulta8."<br>";	
				//exit ();
				$result8=$bd->ejecutar($consulta8); 	
				while (($row8 = mysqli_fetch_array($result8) ))							
				{	
					$Foting=$row8["Foto_Ingreso"];
					$Fotsal=$row8["Foto_Salida"];
					$HoraSal=$row8["Hora_Salida"];
					$HoraIng=$row8["Hora_Ingreso"];
					//echo "FotinA".$FotingA."<br>" ;
					//echo "Foting".$Foting."<br>" ;
					$consulta9="Update registro_diario set Foto_Ingreso='".$Foting."',Hora_Ingreso='".$HoraIng."' where Reg_ID=".$regID." and Empleado_ID=".$emp_ID;
					echo $consulta9."<br>";	
					$result9=$bd->ejecutar($consulta9); 		
					$consulta9="Update registro_diario set Foto_Salida='".$Fotsal."',Hora_Salida='".$HoraSal."' where Reg_ID=".$regID." and Empleado_ID=".$emp_ID;
					echo $consulta9."<br>";	
					$result9=$bd->ejecutar($consulta9); 		
					break;	
				}
				echo "//Fin record <br>";
				
				}
			}
				
	
	///fin remplaza foto
	
	
	exit('not in service contact the ADM OR DISIGNER !');
	
			
			$consulta7="select * from registro_diario_actividad rda inner join registro_diario rd on rda.Reg_ID=rd.Reg_ID join task t on t.Task_ID=rda.Task_ID where rd.Pro_ID=1617 and (rd.Foto_Ingreso is null or rd.Foto_Ingreso='432019796042.jpeg' or rd.Foto_Salida is null )and not t.Nombre like '%no show%'";

			echo $consulta7."<br>";	
			//exit ();
			$result7=$bd->ejecutar($consulta7); 	
			while (($row7 = mysqli_fetch_array($result7) ))							
			{	
			
				$actID=$row7["Actividad_ID"];
				$regID=$row7["Reg_ID"];
				$emp_ID=$row7["Empleado_ID"];
				$FotingA=$row8["Foto_Ingreso"];
				$FotsalA=$row8["Foto_Salida"];
				$HoraSal=$row8["Hora_Salida"];
				$HoraIng=$row8["Hora_Ingreso"];
				$consulta8 = "SELECT * FROM registro_diario  where Empleado_ID='".$emp_ID."' and Pro_ID<>1617 and Foto_Ingreso is not null and Foto_Salida is not null and Foto_Ingreso<>''"; 
				echo $consulta8."<br>";	
				//exit ();
				$result8=$bd->ejecutar($consulta8); 	
				while (($row8 = mysqli_fetch_array($result8) ))							
				{	
					$Foting=$row8["Foto_Ingreso"];
					$Fotsal=$row8["Foto_Salida"];
					$HoraSal=$row8["Hora_Salida"];
					$HoraIng=$row8["Hora_Ingreso"];
					echo "FotinA".$FotingA."<br>" ;
					echo "Foting".$Foting."<br>" ;
					if (!empty($Foting) and empty($FotingA) )
					{
					$consulta9="Update registro_diario set Foto_Ingreso='".$Foting."',Hora_Ingreso='".$HoraIng."' where Reg_ID=".$regID." and Empleado_ID=".$emp_ID;
					echo $consulta9."<br>";	
		//				$result9=$bd->ejecutar($consulta9); 		
					}
					echo "FotsalA".$FotsalA."<br>" ;
					echo "Fotsal".$Fotsal."<br>" ;
					if (!empty($Fotsal) and empty($FotsalA) )
					{
					$consulta9="Update registro_diario set Foto_Salida='".$Fotsal."',Hora_Salida='".$HoraSal."' where Reg_ID=".$regID." and Empleado_ID=".$emp_ID;
					echo $consulta9."<br>";	
			//			$result9=$bd->ejecutar($consulta9); 		
					}	
						
						
					break;	
				}
			}
		
	
		mysqli_free_result($result7);
		mysqli_free_result($result8);
		mysqli_free_result($result9);
	
	require('Library/Close_Conexion.php');	
?>