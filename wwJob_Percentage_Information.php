
<script type="text/javascript">
function wwJob_Percentage_Record(ID_Editable) 

	{
		//window.alert("llego at Job_Percentage_Record(ID_Editable) ");
		//window.alert(ID_Editable);
		eval( "$('#"+ID_Editable+"').editable('wwJob_Percentage_Record.php')" );		 			 

	}	


</script>


<?php	 		
//echo "llego al lugar 3";
//	echo "<script type='text/javascript'>window.alert('llego a Job_Percentage_Information--!!--'); <f/script>";
	
	


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
		echo " Enter to Percentage completed: !!";
		
		$Pro_ID=$_SESSION["Pro_ID"];
		$date_per=$_SESSION["Date_Work"];
	}
	
	$opt_rep="day";

	
	$vdia=substr($date_per,3,2);
 	$vmes=substr($date_per,0,2);
  	$vano=substr($date_per,6,4);
	if ($vano==2020)
		$datesql=$vano."-".$vmes."-" .$vdia;
	  else
	  	$datesql=$date_per;
	
	
//	echo "datesql:".$datesql." Date:".$date_per," Opt.Rep:".$opt_rep."  Pro Id",$Pro_ID,"<br>";
	//exit();


	
?> 

<fieldset>
  <legend>
  <strong>Record Percentage Completed at today:</strong>(type the number and enter or return)
  <h4>Grabe el porciento completado a hoy:(digite el numero y enter o return)  </h4>
  <table style="background-color:#f0ffe0;"
width="750" height="78" border="=" class="tabla_datos_percentage">
    <thead>	
		  <tr>
          <th width="31"  style="font-size:x-small;"><p>&nbsp;</p>
			    <p>-- </p></th>	
				<th width="98"  style="font-size:x-small;"><p>&nbsp;</p>
			    <p>Today you worked in this Areas </p></th>	

			<th width="110" height="6" style="font-size:x-small;"><p>&nbsp;</p>
			    <p>Cost Code/Task </p></th>

				<th width="77" style="font-size: x-small; color: #00F;"><p><strong>Enter Here</strong></p>
				  <p><strong>% completed</strong></p></th>	

				<th width="300"  style="font-size:x-small;"><p>&nbsp;</p>
		    <p>Daily Report / Notes </p></th>			

				<th width="71" style="font-size:x-small;"><p>Last D.</p>
			    <p> Recorded</p></th>

				<th width="33" style="font-size:x-small;"><p>&nbsp;</p>
			    <p>by </p></th>

				<th width="66" style="font-size:x-small;"><p>%Before</p>
			    <p> last record</p></th>

				<th width="63" style="font-size:x-small;"><p>B.Last</p>
			    <p> record date.</p></th>
		  </tr>	
    </thead>	
		 <tbody>

<?php   				       	

//echo "llego al select "."<br>";

	$consulta = "select DISTINCT t.B_Last_Percentage,t.B_Last_Date, t.Task_ID,t.Pro_ID,t.Area_ID,t.NumAct,t.Task_ID,t.Last_Date_Per_Recorded,t.Last_Per_Recorded,t.Usr,t.Note,t.NumAct, a.Nombre as ANom,t.Nombre as TNom FROM task t INNER JOIN area_control a on a.Area_ID=t.Area_ID ";
	if ($opt_rep=="day")
		$consulta = $consulta." INNER JOIN registro_diario_actividad rda on rda.Task_ID=t.Task_ID INNER JOIN registro_diario rd on rda.Reg_ID=rd.Reg_ID and rd.Fecha='".$datesql."' ";
		
	$consulta =	$consulta." WHERE t.Pro_ID=".$Pro_ID;
	//echo $consulta;
	$result2=$bd->ejecutar($consulta);
	$contador=1;	 	  	 	  	  
	while (($row2 = mysqli_fetch_array($result2) ))
	{	
		$Task_ID=$row2["Task_ID"];
		$AreNom = $row2["ANom"];
		$TasIDT = $row2["Tas_IDT"];
		$TasNom=$row2["TNom"];
		$TasCodNom=rtrim($TasIDT)." ".rtrim($TasNom);
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
		//echo " LlEGO A LA TABLA ";
			
		?>		

			<tr >											
	<td height="57" align="left" style="font-size:x-small"><?php echo  "--"; ?></td>
				<td height="57" align="left" style="font-size:x-small"><?php echo  $AreNom; ?></td>

				<td align="left" style="font-size:x-small"><?php echo  $TasCodNom; ?></td>
                
                
                
                

				<td align="right" style="font-size:x-small">

					<div id="HContract-<?php echo  $Pro_ID;?>-<?php echo  $Task_ID;?>-<?php echo  $datesql;?>"><?php echo $HContract;?></div>

					<img src="images/spacer.gif" onload="wwJob_Percentage_Record('HContract-<?php echo  $Pro_ID;?>-<?php echo  $Task_ID;?>-<?php echo  $datesql;?>');" />

				</td>
                 <td align="left" style="font-size: x-small; box-sizing: content-box;">
						
                        <div id="Note-<?php echo  $Pro_ID;?>-<?php echo  $Task_ID;?>-<?php echo  $datesql;?>" style="margin:0; padding:0;"><?php echo $Note;?></div>
                        
					<img style="text-align:justify;text-wrap:normal;" src="images/spacer.gif" onload="wwJob_Percentage_Record('Note-<?php echo  $Pro_ID;?>-<?php echo  $Task_ID;?>-<?php echo  $datesql;?>');" />
				</td>
                
    
			  <td align="right" style="font-size:x-small">
              
              <div id="Div_Fecha-<?php echo  $Task_ID;?>-<?php echo  $datesql;?>"><?php echo  $Las_Per_Date;?></div></td>	

				               

				<td align="right" style="font-size:x-small"><div id="Usr_Record-<?php echo  $Task_ID;?>-<?php echo  $datesql;?>"><?php echo  $Usr;?></div></td>	

				
                <td align="right" style="font-size:x-small"><div id="B_Las_Per-<?php echo  $Task_ID;?>-<?php echo  $datesql;?>"><?php echo  $B_Las_Per;?></div></td>	
                
			  <td align="right" style="font-size:x-small"><div id="B_Las_Date-<?php echo  $Task_ID;?>-<?php echo  $datesql;?>"><?php echo  $B_Las_Date;?></div></td>	
                
                
		  </tr>		

<?php
//echo "LLEGO CONTADOR";
		$contador++;

	}

	mysqli_free_result($result2);


?>	

		</tbody>
</table> 

<!--<img src="images/spacer.gif" onload="$('.tabla_datos_percentage ').flexigrid({nowrap: false, showTableToggleBtn : true,width : 150,height :100, singleSelect: true	});" /> 	-->

</fieldset>
<br>
<div  style="text-align: center;">
<p align="center"  style="display: inline;"><a href="#" class="enlaceboton open_daily_report">[Record / daily report ]</a> </p>
<h5 align="right"  style="display: inline;"><a href="index.php" class="enlaceboton">[<em>Cancel and Exit</em>]</a> </h5>
</div>
<?php

	require('Library/Close_Conexion.php');	

?>

