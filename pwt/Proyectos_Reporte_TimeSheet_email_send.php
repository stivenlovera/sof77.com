	
<?php
		
//************************************************************************************************
//////// Inicio function reporte timesheets
//function Proyectos_Reporte_TimeSheet_email_send($var1)
	//{
?>
	<div id="Res_envio">
	<textarea name="wysiwyg" id="wysiwyg" rows="30" cols="110">	
	</textarea>	
	</div>
	<div id="Div_Reporte_Email" style="display:none">

<?php	
//	$fechatope=date('Y-m-d', strtotime('-1 days'));
	echo "<br> Function send TimeSheets to everyone <br>";	
	//echo $fechaini."  ".$fechatope."<br>";
	$To="marioolmosvk@hotmail.com";
	$Cc=" ";
	$Subject="Timesheet of the Week";
	$Contenido="This is your timesheet "."<br>";
	$Contenido=$Contenido."Por favor revise y si tiene alguna duda u observacion no dude en comunicarse a la oficina!"."<br><br><br>";		
	
	
	$vfrom_date=$_POST["vfrom_date"];
	$vto_date=$_POST["vto_date"];
	$vdia=substr($vfrom_date,3,2);
	$vmes=substr($vfrom_date,0,2);
	$vano=substr($vfrom_date,8,2);
	$f1="20".$vano."-".$vmes."-" .$vdia;
	$fechaini=$f1;
	$fechatope=$f1;
	$fechatope=date("Y-m-d", strtotime($f1. ' -1 day'));
	$fechaini=date("Y-m-d", strtotime($f1. ' -1 day'));
	$dia=date("D", strtotime($fechaini));
//	echo "FecIni:".$fechaini." Fectop:".$fechatope."<br>";
//	echo "Fecha ingresada vfrom:".$vfrom_date." vto date:".$vto_date."<br>";
//	echo "Dia de fechaini:".$dia."<br>";

	while ($dia<>'Mon')
	{
			$fechaini=date('Y-m-d',strtotime($fechaini. ' -1 day'));
			$dia=date("D", strtotime($fechaini));
		//	echo "Dia:".$dia."<br>";
			
	}
	

//echo "F1:".$fechaini." F2:".$fechatope."<br>";
$f1=FormatDateTime($fechaini, 8);
$f2=FormatDateTime($fechatope, 8);
//echo "F1:".$f1." F2:".$f2."<br>";

//exit ();
	
$sql90 = "SELECT pr.Codigo, p.Numero,p.Nombre as Emp_Nombre,p.Apellido_Paterno as Ape_Pat,rd.Hora_Ingreso,rd.Hora_Salida,p.Nick_Name,p.email,p.Empleado_ID,rd.Pro_ID,rda.Horas_Contract,pr.Nombre,rd.Fecha FROM personal p inner join registro_diario rd on p.Empleado_ID=rd.Empleado_ID inner join proyectos pr on pr.Pro_ID=rd.Pro_ID left join registro_diario_actividad rda on rda.Reg_ID=rd.Reg_ID where p.aux5='F' and rd.Fecha BETWEEN '".$fechaini. "' and '".$fechatope."'  and p.Empleado_ID<300 order by p.Empleado_ID,rd.Fecha,pr.Pro_ID";
				echo $sql90."<br>";		
				$empidaux='';
				$empid='';
				$tothoras=0;
				$Regis=1;
				$email="";
				$result90=$bd->ejecutar($sql90);
				while($row90=mysqli_fetch_array($result90))
				{
					$empid=$row90["Empleado_ID"];	
					$EmpNum=$row90["Numero"];	
					$empname=$row90["Emp_Nombre"]." ".$row90["Ape_Pat"];
					$Hora_Ingreso=substr($row90["Hora_Ingreso"],0,5);
					if ($Hora_Ingreso=="00:00:00")   $Hora_Ingreso="------";
					$Hora_Salida=substr($row90["Hora_Salida"],0,5);	
					if ($Hora_Salida=="00:00:00")   $Hora_Salida="------";
					$Pronom=$row90["Nombre"].str_repeat('_',45)."/";
					$Pronom=substr($Pronom,0,28);	
					$Horas_Contract=$row90["Horas_Contract"];


					if ($Regis!=1 && $empid!=$empidaux)
					{
						$TimeSheet=$TimeSheet."_________________________________________________________________________________________"."<br>";
						$TimeSheet=$TimeSheet."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp".str_repeat('&nbsp;',77)."   T o t a l  &nbsp&nbsp&nbsp  H o u r s   &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp ".$tothoras."<br>";
						$TimeSheet=$TimeSheet."_________________________________________________________________________________________"."<br>";
						echo $TimeSheet."<br>";
						$Contenido=$Contenido.$TimeSheet;
						enviar_email($Contenido,$Subject,$To,$Cc);
						echo $Subject." email to:".$To." ".$Cc."<br>";
						$TimeSheet="";
						$Contenido="";
						$tothoras=0;
						$Regis=1;
						$empidaux="";
						//exit ();
					}
					if ($Regis==1 && $empid!=$empidaux)
					{
					$TimeSheet="Precision Wall Tech"."<br>"."<br>";
					$TimeSheet=$TimeSheet."Report of hours of the week from:".$f1."  to:".$f2."<br>"."<br>";
					$TimeSheet=$TimeSheet."Employee#:".$EmpNum."<br>";
					$TimeSheet=$TimeSheet."  Name:".$empname."<br>";
					$TimeSheet=$TimeSheet."_________________________________________________________________________________________"."<br>";
					$TimeSheet=$TimeSheet." Project # &nbsp&nbsp&nbsp Project Name &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Date   &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  Check In&nbsp&nbsp&nbsp&nbsp     Check Out&nbsp&nbsp&nbsp&nbsp   Hours Worked"."<br>";
					$TimeSheet=$TimeSheet."_________________________________________________________________________________________"."<br>";
					$tothoras=0;
					$empidaux=$empid;
					//$email=$row90["email"];
					$Regis=2;
					}
					$Fecha=$row90["Fecha"];	
					$ProNum=$row90["Codigo"];	
					$Fecha=FormatDateTime($Fecha, 8)."_________________";					
					$Fecha=substr($Fecha,0,23);
					$TimeSheet=$TimeSheet." ".$ProNum."&nbsp&nbsp&nbsp".$Pronom."&nbsp&nbsp&nbsp".$Fecha."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp".$Hora_Ingreso."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp".$Hora_Salida."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp".$Horas_Contract."<br>"."<br>";
					$tothoras=$tothoras+$Horas_Contract;
					
			}
	    mysqli_free_result($result90);
				
				   
/////////  end function envio timesheet 

	
?>

	</div>
	<img src='images/spacer.gif' onload='Proyectos_Reporte_Actividad_Copiar();' />	

<?php
   