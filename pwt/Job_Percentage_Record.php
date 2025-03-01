<script type="text/javascript" >
function Update_Info_Percentage(id, Pro_ID, Task_ID, datesql, value, B_Las_Per, B_Las_Date, usr) 

	{
		//window.alert(id);
		//window.alert(Task_ID+"-"+datesql)
		eval(" $('#Div_Fecha-"+Task_ID+"-"+datesql+"').html('"+datesql+"');");
		eval(" $('#Usr_Record-"+Task_ID+"-"+datesql+"').html('"+usr+"');");
		eval(" $('#B_Las_Per-"+Task_ID+"-"+datesql+"').html('"+B_Las_Per+"');");
		eval(" $('#B_Las_Date-"+Task_ID+"-"+datesql+"').html('"+B_Las_Date+"');");
		
		
		eval(" $('#Note-"+Task_ID+"-"+datesql+"-"+"').html('"+Note+"');");
		//window.alert(Note);
	//	eval(" $('#Div_Total_Horas-"+Empleado_ID+"-"+Actividad_ID+"').html('"+Total+"');");
		eval(" $('#"+id+"').html('"+value+"');");  // delete the object from the variable 
		
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
	//require('Library/funciones.php');	
	//require('funciones_php/Actividades.php');

	$id=$_POST['id'];
	//echo $id;
	//exit();
	$data  = explode("-",$_POST['id']);
	
	$campo = $data[0]; // nombre del campo
	$Pro_ID = $data[1]; // nombre del campo
	$Task_ID = $data[2]; // nombre del campo
	$datesql = $data[3]; // nombre del campo	
	$datesql = $datesql."-".$data[4];
	$datesql = $datesql."-".$data[5];
	$Note = $data[6]; // nombre del campo	
	$datesqlx1=$datesql;
	//echo $datesql."<br>";
	//exit ();
	

	$value = $_POST['value']; 
	$usr=$_SESSION["username"];
	
	
	$consulta = "select * FROM task WHERE Task_ID=".$Task_ID;
		$result33=$bd->ejecutar($consulta); 	

		while (($row33 = mysqli_fetch_array($result33) ))							
		{		
			$usrx=$row33["Usr"];
			$Busr=$row33["BUsr"];
			$Las_Per_datex=$row33["Last_Date_Per_Recorded"];
			$datesqlx=$Las_Per_datex;
			$Las_Per_Recordedx=$row33["Last_Per_Recorded"];
			$B_Las_Perx=$row33["B_Last_Percentage"];
			$B_Las_Datex=$row33["B_Last_Date"];
		}
		mysqli_free_result($result33);
	
	
	

//echo "Llego:".$campo." ProID".$Pro_ID." Task_ID:".$Task_ID." value:".$value." usr:".$usr." datesql".$Datesql." Note:".$Note."<br>";
//exit();
	if ($campo=="HContract")
		$campo="Last_Per_Recorded";

if ($datesqlx!=$datesql || $usrx!=$usr)
		$strSQL = "UPDATE task SET B_Last_Percentage=Last_Per_recorded,B_Last_Date=Last_Date_Per_Recorded,BUsr=Usr,".$campo."='".$value."',Last_Date_Per_Recorded='".$datesql."',Usr='".$usr."', Note='".$Note."'  WHERE Task_ID=".$Task_ID;					
	else 
		$strSQL = "UPDATE task SET ".$campo."='".$value."',Last_Date_Per_Recorded='".$datesql."',Usr='".$usr."'  WHERE Task_ID=".$Task_ID;

	//echo $strSQL."<br>";
	//exit();				
	$res1=$bd->ejecutar($strSQL);  		
	
	if ($res1)
	{
		echo $value; // shows the value changed 
		$consulta = "select * FROM task WHERE Task_ID=".$Task_ID;
		$result2=$bd->ejecutar($consulta); 	

		while (($row2 = mysqli_fetch_array($result2) ))							
		{		
			$HContract = $row2["Last_Per_Recorded"];
			$HTM = 0;
			$Note=$row2["Note"];
			$usr=$row2["Usr"];
			$Las_Per_date=$row2["Last_Date_Per_Recorded"];
			$datesql=$Las_Per_date;
			$Las_Per_Recorded=$row2["Last_Per_Recorded"];
			$NumAct=$row2["NumAct"];
			$B_Las_Per=$row2["B_Last_Percentage"];
			$B_Las_Date=$row2["B_Last_Date"];
			
		}
		mysqli_free_result($result2);
		
	
		
		//////  record the historic 
			$strSQL = "SELECT count(Task_ID) as Conta FROM percentage_complete  WHERE Task_ID=".$Task_ID." AND Date_Recorded='".$datesql."' AND Usr='".$usr."' AND Pro_ID=".$Pro_ID;

		$res1=$bd->ejecutar($strSQL);
		while (($row2 = mysqli_fetch_array($res1) ))							
		{		
			$Conta=$row2["Conta"];
			
		}
		mysqli_free_result($res1);
		//echo "Conta:".$Conta."br";
		//echo $strSQL."<br>";
			//exit();			
		if ($datesql<"2021-01-01") $datesql=$datesqlx1;

		if ($Conta>0)
		{
		$strSQL = "UPDATE percentage_complete SET Per_Recorded=".$Las_Per_Recorded.",Note='".$Note."'  WHERE Task_ID=".$Task_ID." AND Date_Recorded='".$datesql."' AND Usr='".$usr."' AND Pro_ID=".$Pro_ID;
				
			//echo $strSQL."<br>";
			//exit();				
		$res1=$bd->ejecutar($strSQL);  		
		}
	 else
	 	{
		$strSQL = "INSERT INTO percentage_complete (Task_ID,Date_Recorded,Per_Recorded,Usr,Note,Pro_ID) VALUES (".$Task_ID.",'".$datesql."',".$Las_Per_Recorded.",'"
		.$usr."','".$Note."',".$Pro_ID.")";
		//echo $strSQL."<br>";
		//exit();				
		$res1=$bd->ejecutar($strSQL);
	
		}
			
		//echo $Total.":".$Note." Val:".$value." id:".$id."<br>";
		//exit();
		$Total=0;
		//$B_Las_Per=80;
		//$B_Las_Date='2020-06-30';
		//echo "date".$datesql;
		
?>
	      
    
    <img src="images/spacer.gif" onload="Update_Info_Percentage( '<?php echo $id; ?>', <?php echo $Pro_ID; ?>, <?php echo $Task_ID; ?>,'<?php echo $datesql; ?>','<?php echo $value; ?>', <?php echo $B_Las_Per; ?>,'<?php echo $B_Las_Date; ?>',' <?php echo $usr; ?>');" width="1" height="1" />  


<?php



	}
	else
		echo "ERROR";	
		
	require('Library/Close_Conexion.php');	
	
	
	
?>	
