	
<?php
		
//************************************************************************************************
//////// Inicio function cost codes 
//function Proyectos_Reporte_CostCode_email_send($var1)
	//{
		
	$fechaini=date('Y-m-d', strtotime('-7 days'));
	$fechatope=date('Y-m-d');
//	$fechatope=date('Y-m-d', strtotime('-1 days'));
	echo "<br> Enter into and runing function pending CostCode emails to Foreman <br>";	
	//echo $fechaini."  ".$fechatope."<br>";
	$to="mario.olmos@precisionwall.com";
	$cc="";
	$Subject="";

		
	$Contenido="The follow records are not allocated to a cost codes please go to STP_TimeCard report  to allocate to a cost code Thank You"."<br>";
	$Contenido=$Contenido."Los siguientes registros no tinenen asignasion de codigo de costo, por favor ingrese en STP_TimeCard report y asigne los codigos de costo Gracias!"."<br><br><br>";		
		
$sql90 = "SELECT rda.Task_ID,p.Foreman_ID,p.Lead_ID,p.Codigo,p.Nombre,rda.Task_ID,rd.Pro_ID,rd.Fecha, rd.Actividad_Id,rd.Empleado_ID,pe.Nick_Name FROM registro_diario_actividad rda inner join registro_diario rd on rd.Reg_ID=rda.Reg_ID inner join proyectos p on rd.Pro_ID=p.Pro_ID INNER JOIN personal pe on pe.Empleado_ID=rd.Empleado_ID WHERE rd.fecha BETWEEN '".$fechaini."' AND '".$fechatope."' AND rda.Task_ID=0 ORDER BY rd.Pro_ID,rd.Fecha";
//AND (p.Nombre like '%test%')
				//echo $sql90."<br>";		
				//exit ();												
				$result90=$bd->ejecutar($sql90);
				$Pro_IDant=-5;
				$Nombre_proant="";
				$Fechaactant="01-01-2020";
				
				while($row90=mysqli_fetch_array($result90))
				{
				$Foreman_ID=$row90["Foreman_ID"];
				$Lead_ID=$row90["Lead_ID"];
				$Codigo=$row90["Codigo"];
				$Nombre_pro=$row90["Nombre"];
				$Pro_ID=$row90["Pro_ID"];
				$Fechaact=$row90["Fecha"];
			    $Fechaact=date('m-d-Y',strtotime($Fechaact));
				$Nick_Name=$row90["Nick_Name"];
				//echo "Contenido while:".$Contenido;
				if ($Pro_IDant==$Pro_ID)
					{
					 if ($Fechaact != $Fechaactant)
					    {
						   // echo "Fechas:::".$Fechaact.$Fechaactant."<br>";
							$Contenido=$Contenido."<b>".$Fechaact."</b><br>";
							$Fechaactant=$Fechaact;
						}
					$Nombre_proant=$Nombre_pro;
					$Contenido=$Contenido."Job:".$Codigo."   ".$Nombre_pro."  &nbsp&nbsp&nbsp&nbsp&nbsp Date: ".$Fechaact."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  Employee: ".$Nick_Name."<br><br>";
					  //echo "entro en :".$Contenido."<br>";
					  					
					}
				else
					{
			  			if 	($Pro_IDant!=-5)
							{
								$sql91="SELECT p1.Nick_Name, p1.email,p1.Empleado_ID FROM personal p1 where p1.Empleado_ID=".$Foreman_ID;
								//echo "Foreman: ".$sql91."<br>";														
								$result91=$bd->ejecutar($sql91); 		
								while ($row91 = mysqli_fetch_array($result91))
								{									
								$Cc=$row91["email"].",";
								}
					 			mysqli_free_result($result91);
								//echo "envio de email:".$Contenido." //".$Subject."//".$To."//".$Cc."<br>";
								$Subject=$Nombre_proant.": STP_TimeCard/ Cost Codes pending ";
								enviar_email($Contenido,$Subject,$To,$Cc);
							}
					     
					
						$Contenido="You are receiving this email due the follow records are not allocated to a cost codes please go to STP_TimeCard report  to allocate to a cost code Thank You"."<br><br>";
						$Contenido=$Contenido."Ud. esta recibiendo este email proque los siguientes registros no tinenen asignasion de codigo de costo, por favor ingrese en STP_TimeCard report y asigne los codigos de costo Gracias!"."<br><br><br>";
						 $Contenido=$Contenido."<b>".$Fechaact."</b><br>";
						 $Fechaactant=$Fechaact;
						$Contenido=$Contenido."Job:".$Codigo."   ".$Nombre_pro."  &nbsp&nbsp&nbsp&nbsp&nbsp Date: ".$Fechaact."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  Employee: ".$Nick_Name."<br><br>";
						$Pro_IDant=$Pro_ID;
						$Nombre_pro=$Nombre_pro;
					}
					}
				
				    mysqli_free_result($result90);
				
				    $sql91="SELECT p1.Nick_Name, p1.email,p1.Empleado_ID FROM personal p1 where p1.Empleado_ID=".$Foreman_ID;														
						$result91=$bd->ejecutar($sql91); 		
						if (($row91 = mysqli_fetch_array($result91) ))	
						{									
							$Cc=$row91["email"];
							
						}
					 	mysqli_free_result($result91);
						//echo "envio de email al SALIR"."<br>";
						
						enviar_email($Contenido,$Subject,$To,$Cc);
						
				
				
				
//	}			
/////////  end function cost codes 

	
?>
   