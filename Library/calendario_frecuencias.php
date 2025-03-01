<?php	
	/**
	 * Calender class
	 */
	
	 class Calender {
	 	
	 	public  $year = '';
	 	public  $month = '';
		public  $PUEDE_REGISTRAR_ESTADO;
	 	public  $intToDay = array(
	 								0=>'Domingo',
	 								1=>'Lunes',
	 								2=>'Martes',
	 								3=>'Miercoles',
	 								4=>'Jueves' ,
	 								5=>'Viernes' ,
	 								6=>'Sabado' 
	 							   );
		public $intToDayEn = array(
	 								0=>'Sunday',
	 								1=>'Monday',
	 								2=>'Tuesday',
	 								3=>'Wednesday',
	 								4=>'Thursday' ,
	 								5=>'Friday' ,
	 								6=>'Saturday' 
	 							   );
	 	public $intToMonth = array(
	 								1=>'Enero',
	 								2=>'Febrero',
	 								3=>'Marzo',
	 								4=>'Abril' ,
	 								5=>'Mayo' ,
	 								6=>'Junio' ,
	 								7=>'Julio',
	 								8=>'Agosto',
	 								9=>'Septiembre',
	 								10=>'Octubre',
	 								11=>'Noviembre' ,
	 								12=>'Diciembre'  								
	 							   );
	 	
	 	/**
	 	 * constructor function
	 	 */
	 	public function Calender($year, $PUEDE_REGISTRAR_ESTADO) {
	 		
	 		$this->year = $year;
			$this->PUEDE_REGISTRAR_ESTADO = $PUEDE_REGISTRAR_ESTADO;
	 	}
	 	
	 	/**
	 	 * get code for 
	 	 * 
	 	 * @param int $month
	 	 * 
	 	 */
	 	public function getCodeForMonth($month) {	 	
    		
			if (!($link=mysql_connect("localhost","root",""))) 
			{ 
				echo "Error conectando a la base de datos."; 
				exit(); 
			} 
			if (!mysql_select_db("Calls_DB",$link)) 
			{ 
				echo "Error seleccionando la base de datos."; 
				exit(); 
			} 			

			$this->month = $month;
			
	 		$startingDay = date("l", mktime(0, 0, 0, $month, 1, $this->year));
	 		
	 		$returnCode = '<table border="1" align="center" style="color:brown"> <tr>';
				for ($count = 0; $count < 7; $count++) {
					$returnCode .= "<td align=\"center\" style=\"color:red\"><strong>".$this->intToDay[$count]."</strong></td>";
				}
				$returnCode .= "</tr> <tr>";
				
				//for ($count = 0; $count < array_search($startingDay, $this->intToDay); $count++) {
				for ($count = 0; $count < array_search($startingDay, $this->intToDayEn); $count++) {
					$returnCode .=  "<td><br /></td>";
				}
				$ultimo_dia_del_mes=date("d",(mktime(0,0,0,$month+1,1,$this->year)-1));	
				//for ($counter = 1; $counter <= 31; $counter++, $count++) {
				for ($counter = 1; $counter <= $ultimo_dia_del_mes; $counter++, $count++) {
					if (($count % 7) == 0) {
						$returnCode .= "</tr> <tr>";
					}
					$consulta = "SELECT Deuda_ID, Fecha_Deuda, Monto, Acuenta FROM deuda WHERE Tipo_Deuda_ID=1 AND Deuda_Cond_ID=".$_SESSION["Cond_ID"]; 
					$consulta = $consulta . " AND Fecha_Deuda>='".$this->year."-".$month."-".$counter." 00:00:00' AND Fecha_Deuda<='".$this->year."-".$month."-".$counter." 23:59:59'";
					//$consulta = $consulta . " AND Fecha_Deuda='".$this->year."-".($month+1)."-".$counter." 00:00:00'";
							 
					//echo $consulta;
					$contador=1;
					$result=mysql_query($consulta,$link);
					$estado="#FFFFFF";
					if (($row = mysql_fetch_array($result) ))							
					{		
						$Deuda_ID = $row["Deuda_ID"];
						$Fecha_Deuda = $row["Fecha_Deuda"];
						//$Fecha_Pago = $row["Fecha_Pago"];
						$Monto = $row["Monto"];		
						$Acuenta = $row["Acuenta"];	
						
						if ( ($Acuenta==$Monto) && ($Monto>0) )
						{
							$estado="#00FF00";
						}
						
						if ($Monto==0)
						{
							$estado="#FFFF00";
						}						
						/*if ($Monto>$Acuenta)
						{
							$estado="#FF3300";
						}*/
					}
					//$Fecha_Desde=ConvertDateToMysqlFormat($_GET['pagos_desde']);							
					mysql_free_result($result);															
					
					if ( ($estado=="#FFFF00") && ($this->PUEDE_REGISTRAR_ESTADO)  )
						$returnCode .= "<td align=\"center\"  bgcolor=\"".$estado."\"><a href='#' onclick='movil_taller_eliminar(".$Deuda_ID.")'>".$counter."</a></td>";
					else
						$returnCode .= "<td align=\"center\"  bgcolor=\"".$estado."\">".$counter."</td>";
					//$returnCode .= "<td align=\"center\"  bgcolor=\"".$estado."\">".$counter."</td>";					

				}
				$returnCode .= '</table>';					
			mysql_close($link);	
	 		return $returnCode;
	 	}
	 	
	 	public function getCode($month) {
	 		
			$this->month = $month;
			
	 		$startingDay = date("l", mktime(0, 0, 0, $month, 1, $this->year));
	 		
	 		$returnCode = '<table border="1" align="center" style="color:brown"> <tr>';
				for ($count = 0; $count < 7; $count++) {
					$returnCode .= "<td width=\"65\" align=\"center\" style=\"color:#000000;background-color:#6779AC\"><strong>".$this->intToDay[$count]."</strong></td>";
				}
				$returnCode .= "</tr> <tr>";
				
				for ($count = 0; $count < array_search($startingDay, $this->intToDay); $count++) {
					$returnCode .=  "<td><br /></td>";
				}
				
				for ($counter = 1; $counter <= 31; $counter++, $count++) {
					if (($count % 7) == 0) {
						$returnCode .= "</tr> <tr>";
					}
					$monthName = $this->intToMonth[$month];
					
					if ( ($month < date('n') || $this->year < date('Y')) )
					{
						$returnCode .= "<td align=\"center\" style=\"background-color:#ABCED6;\"><span><b>".trim($counter)."</b></span></td>";
					}
					else {
						$returnCode .= "<td align=\"center\" style=\"background-color:#ABCED6;\"><span style=\"cursor:pointer;cursor:hand;background-color:#ABCED6;\" onclick=\"openWindow('$counter-$this->month-$this->year');\"><b>".trim($counter)."</b></span></td>";
					}
				}
				$returnCode .= '</table>';
				
	 		return $returnCode;
	 	}
	 	
	 }	
?>