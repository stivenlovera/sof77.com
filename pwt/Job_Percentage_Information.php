
<script type="text/javascript">


function Job_Percentage_Record(ID_Editable) 

	{
		//window.alert("llego at Job_Percentage_Record(ID_Editable) ");
		//window.alert(ID_Editable);
		eval( "$('#"+ID_Editable+"').editable('Job_Percentage_Record.php');" );		 			 

	}	


</script>


<?php	 		
	session_name("Administrador");

	session_start();		

	if ($_SESSION["EntityID"] == "")

	{

		header("Location:sessionexpired.php"); 	

	}	 	

		

	require('Library/Control_Cache.php');	

	require('Library/Open_Conexion.php');	
	
	$date_per=$_GET["Date_Per"];
	$opt_rep=$_GET["Opt_Rep"];
	$Pro_ID=$_GET['Pro_ID_Per'];	
	
	
	//require('Library/funciones.php');
	//require('funciones_php/Actividades.php');
	if ($opt_rep=='')
	{	
	//echo " enter to percentages: ";
	$opt_rep=$_SESSION["day"];
	$Pro_ID=$_SESSION["Pro_ID"];
	$date_per=$_SESSION["Date_Work"];
	}
	


	
	$vdia=substr($date_per,3,2);
 	$vmes=substr($date_per,0,2);
  	$vano=substr($date_per,6,4);
	if ($vano>2020 & $vano<2035)
		$datesql=$vano."-".$vmes."-" .$vdia;
	  else
	  	{
	  	$datesql=$date_per;
		/*$vdia=substr($date_per,8,2);
 		$vmes=substr($date_per,5,2);
		$vano=substr($date_per,0,4);
		$date_per=$vmes."-" .$vdia."-".$vano;*/
		
		}
	
	//echo "datesql:".$datesql." Date:".$date_per," Opt.Rep:".$opt_rep."  Pro Id",$Pro_ID,"<br>";
	//exit();

//	echo "<script type='text/javascript'>alert('llego a Job_Percentage_Information--!!--');
	
?> 

<fieldset>
	<legend>
	Update Percentage Completed:</u>
<table class="tabla_Datos_Personal">

	  <thead>	

		  <tr>

				<th width="70" height="58" style="font-size:x-small;"><p>&nbsp;</p>
			    <p>Area of Work </p></th>	

				<th width="150" style="font-size:x-small;"><p>&nbsp;</p>
			    <p>Cost Code/Task </p></th>

				<th width="70" style="font-size:x-small;"><p>Enter here</p>
		    <p> Last.% completed</p></th>	

				<th width="150" style="font-size:x-small;"><p>&nbsp;</p>
			    <p>Daily Report / Notes</p></th>			

				<th width="80" style="font-size:x-small;"><p>Last D.</p>
			    <p> Recorded</p></th>

				<th width="80" style="font-size:x-small;"><p>&nbsp;</p>
			    <p>by </p></th>

				<th width="50" style="font-size:x-small;"><p>%Before</p>
			    <p> last record</p></th>

				<th width="70" style="font-size:x-small;"><p>B.Last</p>
			    <p> record date.</p></th>
                
                	

		  </tr>	

		 </thead>	

		 <tbody>

<?php   				       	
	///   put cero to all sums 
			$sql="UPDATE task t SET t.Total_HCode = 0 WHERE t.Pro_ID=". $Pro_ID;
				$result89=$bd->ejecutar($sql);
				mysqli_free_result($result89);
		
	
			$sql="UPDATE task t INNER JOIN (SELECT Task_ID, SUM(Horas_Contract) 'suma' FROM registro_diario_actividad GROUP BY Task_ID) ra ON t.Task_ID=ra.Task_ID SET t.Total_HCode = ra.suma WHERE t.Pro_ID=".$Pro_ID;
				$result89=$bd->ejecutar($sql);
		mysqli_free_result($result89);
		

	//$consulta = "select DISTINCT t.B_Last_Percentage,t.B_Last_Date, t.Task_ID,t.Pro_ID,t.Area_ID,t.NumAct,t.Task_ID,t.Last_Date_Per_Recorded,t.Last_Per_Recorded,t.Usr,t.Note,t.NumAct, a.Nombre as ANom,t.Nombre as TNom FROM task t INNER JOIN area_control a on a.Area_ID=t.Area_ID ";
	
	$consulta = "select t.B_Last_Percentage,t.B_Last_Date, t.Task_ID,t.Pro_ID,t.Floor_ID,t.Area_ID,t.NumAct,t.Task_ID,t.Last_Date_Per_Recorded,t.Last_Per_Recorded,t.Usr,t.Note,t.NumAct, a.Nombre as ANom,t.Nombre as TNom,t.Total_HCode as SHoras, t.Horas_Estimadas,ff.Nombre as FNom,ff.Flo_IDT,a.Nombre,a.Are_IDT,t.Nombre,t.Tas_IDT FROM task t LEFT JOIN area_control a on a.Area_ID=t.Area_ID LEFT JOIN floor ff ON a.Floor_ID=ff.Floor_ID ";
	
	if ($opt_rep=="day")
		$consulta = $consulta." LEFT JOIN registro_diario_actividad rda on rda.Task_ID=t.Task_ID LEFT JOIN registro_diario rd on rda.Reg_ID=rd.Reg_ID and rd.Fecha='".$datesql."' ";
		else
		$consulta = $consulta." LEFT JOIN registro_diario_actividad rda on rda.Task_ID=t.Task_ID LEFT JOIN registro_diario rd on rda.Reg_ID=rd.Reg_ID ";
		
	$consulta =	$consulta." WHERE t.Pro_ID=".$Pro_ID." AND t.Horas_Estimadas>1";
	if ($opt_rep=="day")
		$consulta =	$consulta." AND  rd.Fecha='".$datesql."' ";
	if ($opt_rep=="completed")
			$consulta =	$consulta." AND Last_Per_Recorded<100";
		

	if ($opt_rep=="whours" || $opt_rep=="completed")
			$consulta =	$consulta." AND t.Total_HCode>0";
			
	//$consulta =	$consulta." GROUP BY t.Task_ID ORDER BY  ff.Nombre,a.Nombre,t.Tas_IDT";
	$consulta =	$consulta." GROUP BY t.Task_ID ORDER BY  ff.Nombre,ff.Flo_IDT,a.Nombre,a.Are_IDT,t.Tas_IDT";
	//echo $opt_rep,"<br>";
	//echo $consulta;
	//exit;
	$result2=$bd->ejecutar($consulta);
	$contador=1;	 	  	 	  	  
	while (($row2 = mysqli_fetch_array($result2) ))
	{	
		$Task_ID=$row2["Task_ID"];
		$AreNom =$row2["FNom"]."/".$row2["ANom"];
		$TasIDT = $row2["Tas_IDT"];
		$TasNom=$row2["TNom"];
		$HEstimadas=$row2["Horas_Estimadas"];
		$TasCodNom=rtrim($TasIDT)." ".rtrim($TasNom)." /Hrs.Est:".$row2["Horas_Estimadas"]."H.Used:";
		if ($row2["SHoras"]>0)
				$TasCodNom=$TasCodNom."<font color='blue'></b>".$row2["SHoras"]."<b>";
				
				
		$Las_Per_Date=$row2["Last_Date_Per_Recorded"];
		$Las_Per = $row2["Last_Per_Recorded"];
		$B_Las_Per=$row2["B_Last_Percentage"];
		$B_Las_Date=$row2["B_Last_Date"];

		
		$Usr=$row2["Usr"];
		$Note=$row2["Note"];
		$NumAct=1;
		//$row2["NumAct"];
		$Celular = "";
		$HTM = 0;
		$Nombre="AA";
		$Apellido_Materno="pat";
		$Celular="15611";
		if ($Las_Per=='')
			$Las_Per=0;
			
		//$datos=$datesql."-".$Note;
			
		$HContract=$Las_Per;
			
		?>		

			<tr >											

				<td align="left" style="font-size:x-small"><?php echo  $AreNom; ?></td>

				<td align="left" style="font-size:x-small"><?php echo  $TasCodNom; ?></td>
                
                
                
                

				<td align="right" style="font-size:x-small;">

					<div id="HContract-<?php echo  $Pro_ID;?>-<?php echo  $Task_ID;?>-<?php echo  $datesql;?>"><?php echo $HContract;?></div>

					<img src="images/spacer.gif" onload="Job_Percentage_Record('HContract-<?php echo  $Pro_ID;?>-<?php echo  $Task_ID;?>-<?php echo  $datesql;?>');" />

				</td>
                 <td align="right" style="font-size: x-small; ">
						
                        <div id="Note-<?php echo  $Pro_ID;?>-<?php echo  $Task_ID;?>-<?php echo  $datesql;?>"><?php echo $Note;?></div>
                        
					<img src="images/spacer.gif" onload="Job_Percentage_Record('Note-<?php echo  $Pro_ID;?>-<?php echo  $Task_ID;?>-<?php echo  $datesql;?>');" />
				</td>
                
    
			  <td align="right" style="font-size:x-small">
              
              <div id="Div_Fecha-<?php echo  $Task_ID;?>-<?php echo  $datesql;?>"><?php echo  $Las_Per_Date;?></div></td>	

				               

				<td align="right" style="font-size:x-small"><div id="Usr_Record-<?php echo  $Task_ID;?>-<?php echo  $datesql;?>"><?php echo  $Usr;?></div></td>	

				
                <td align="right" style="font-size:x-small"><div id="B_Las_Per-<?php echo  $Task_ID;?>-<?php echo  $datesql;?>"><?php echo  $B_Las_Per;?></div></td>	
                
			  <td align="right" style="font-size:x-small"><div id="B_Las_Date-<?php echo  $Task_ID;?>-<?php echo  $datesql;?>"><?php echo  $B_Las_Date;?></div></td>	
              
              
                
                
		  </tr>		

<?php

		$contador++;

	}

	mysqli_free_result($result2);

?>	

		</tbody>

	</table> 

<img src="images/spacer.gif" onload="$('.tabla_Datos_Personal').flexigrid({nowrap: false, showTableToggleBtn : true,width : 580,height :300, singleSelect: true	});" /> 		

</fieldset>




<?php

	require('Library/Close_Conexion.php');	

?>

