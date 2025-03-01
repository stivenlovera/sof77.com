<?php	 		
	/// update pictures on the ones does not have 
	
	session_name("Administrador");
	session_start();		
			
	require('Library/Control_Cache.php');	
	require('Library/Open_Conexion.php');	
	require('Library/funciones.php');	
	
	exit('not in service contact the ADM OR DISIGNER !');
	
			
			$consulta7="select * from registro_diario_actividad rda inner join registro_diario rd on rda.Reg_ID=rd.Reg_ID join task t on t.Task_ID=rda.Task_ID where rd.Pro_ID=1617 and (rd.Foto_Ingreso is null or rd.Foto_Ingreso='432019796042.jpeg')and not t.Nombre like '%no show%'";

			echo $consulta7."<br>";	
			//exit ();
			$result7=$bd->ejecutar($consulta7); 	
			while (($row7 = mysqli_fetch_array($result7) ))							
			{	
			
				$actID=$row7["Actividad_ID"];
				$regID=$row7["Reg_ID"];
				$emp_ID=$row7["Empleado_ID"];
				$Foting=$row8["Foto_Ingreso"];
				$Fotsal=$row8["Foto_Salida"];
				$HoraSal=$row8["Hora_Salida"];
				$HoraIng=$row8["Hora_Ingreso"];
				$consulta8 = "SELECT * FROM registro_diario  where Empleado_ID='".$emp_ID."' and Pro_ID<>1617 and Foto_Ingreso is not null and Foto_Salida is not null and Foto_Ingreso<>'432019796042.jpeg'"; 
				echo $consulta8."<br>";	
				//exit ();
				$result8=$bd->ejecutar($consulta8); 	
				while (($row8 = mysqli_fetch_array($result8) ))							
				{	
					$Foting=$row8["Foto_Ingreso"];
					$Fotsal=$row8["Foto_Salida"];
					$HoraSal=$row8["Hora_Salida"];
					$HoraIng=$row8["Hora_Ingreso"];
					if ($Foting<>null  )
					{
					$consulta9="Update registro_diario set Foto_Ingreso='".$Foting."',Foto_Salida='".$Fotsal."',Hora_Ingreso='".$HoraIng."',Hora_Salida='".$HoraSal."' where Reg_ID=".$regID." and Empleado_ID=".$emp_ID;
					echo $consulta9."<br>";	
						$result9=$bd->ejecutar($consulta9); 		
						break;	
					}
				
				}
			
			
			}
		
	
		mysqli_free_result($result7);
		mysqli_free_result($result8);
		mysqli_free_result($result9);
	
	require('Library/Close_Conexion.php');	
?>