<?PHP
	define("DEFAULT_CURRENCY_SYMBOL",  "$"); 
	define("DEFAULT_MON_DECIMAL_POINT",  "."); 
	define("DEFAULT_MON_THOUSANDS_SEP",  ", "); 
	define("DEFAULT_POSITIVE_SIGN",  ""); 
	define("DEFAULT_NEGATIVE_SIGN",  "-"); 
	define("DEFAULT_FRAC_DIGITS",  2); 
	define("DEFAULT_P_CS_PRECEDES",  true); 
	define("DEFAULT_P_SEP_BY_SPACE",  false); 
	define("DEFAULT_N_CS_PRECEDES",  true); 
	define("DEFAULT_N_SEP_BY_SPACE",  false); 
	define("DEFAULT_P_SIGN_POSN",  3); 
	define("DEFAULT_N_SIGN_POSN",  3); 
	
	
	define("DEFAULT_DATE_FORMAT",  "mm-dd-yyyy"); 
	define("EW_DATE_SEPARATOR", "-"); 
	//------------------------------------------------------------------------------- 
	// Functions for default date format 
	// FormatDateTime 
	/* 
	Format a timestamp,  datetime,  date or time field from MySQL 
	$namedformat: 
	0 - General Date, 
	1 - Long Date, 
	2 - Short Date (Default), 
	3 - Long Time, 
	4 - Short Time, 
	5 - Short Date (yyyy/mm/dd), 
	6 - Short Date (mm/dd/yyyy), 
	7 - Short Date (dd/mm/yyyy) 
	*/ 
	
	// Convert a date to MySQL format 
	function ConvertDateToMysqlFormat($dateStr) 
	{ 
		@list($datePt,  $timePt) = explode(" ",  $dateStr); 
		$arDatePt = explode(EW_DATE_SEPARATOR,  $datePt); 
		if (count($arDatePt) == 3) { 
			switch (DEFAULT_DATE_FORMAT) { 
			case "yyyy" . EW_DATE_SEPARATOR . "mm" . EW_DATE_SEPARATOR . "dd": 
				list($year,  $month,  $day) = $arDatePt; 
				break; 
			case "mm" . EW_DATE_SEPARATOR . "dd" . EW_DATE_SEPARATOR . "yyyy": 
				list($month,  $day,  $year) = $arDatePt; 
				break; 
			case "dd" . EW_DATE_SEPARATOR . "mm" . EW_DATE_SEPARATOR . "yyyy": 
				list($day,  $month,  $year) = $arDatePt; 
				break; 
			} 
			return trim($year . "-" . $month . "-" . $day . " " . $timePt); 
		} else { 
			return $dateStr; 
		} 
	} 
	
	
	function FormatDateTime($ts,  $namedformat) 
	{ 
	  	$DefDateFormat = str_replace("yyyy",  "%Y",  DEFAULT_DATE_FORMAT); 
		$DefDateFormat = str_replace("mm",  "%m",  $DefDateFormat); 
		$DefDateFormat = str_replace("dd",  "%d",  $DefDateFormat); 
		if (is_numeric($ts)) // timestamp 
		{ 
			switch (strlen($ts)) { 
				case 14: 
					$patt = '/(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/'; 
					break; 
				case 12: 
					$patt = '/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/'; 
					break; 
				case 10: 
					$patt = '/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/'; 
					break; 
				case 8: 
					$patt = '/(\d{4})(\d{2})(\d{2})/'; 
					break; 
				case 6: 
					$patt = '/(\d{2})(\d{2})(\d{2})/'; 
					break; 
				case 4: 
					$patt = '/(\d{2})(\d{2})/'; 
					break; 
				case 2: 
					$patt = '/(\d{2})/'; 
					break; 
				default: 
						return $ts; 
			} 
			if ((isset($patt))&&(preg_match($patt,  $ts,  $matches))) 
			{ 
				$year = $matches[1]; 
				$month = @$matches[2]; 
				$day = @$matches[3]; 
				$hour = @$matches[4]; 
				$min = @$matches[5]; 
				$sec = @$matches[6]; 
			} 
			if (($namedformat==0)&&(strlen($ts)<10)) $namedformat = 2; 
		} 
		elseif (is_string($ts)) 
		{ 						
			if (preg_match('/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/',  $ts,  $matches)) // datetime 
			{ 
				$year = $matches[1]; 
				$month = $matches[2]; 
				$day = $matches[3]; 
				$hour = $matches[4]; 
				$min = $matches[5]; 
				$sec = $matches[6]; 
			} 
			elseif (preg_match('/(\d{4})-(\d{2})-(\d{2})/',  $ts,  $matches)) // date 
			{ 
				$year = $matches[1]; 
				$month = $matches[2]; 
				$day = $matches[3]; 
				if ($namedformat==0) $namedformat = 2; 
			} 
			elseif (preg_match('/(^|\s)(\d{2}):(\d{2}):(\d{2})/',  $ts,  $matches)) // time 
			{ 
				$hour = $matches[2]; 
				$min = $matches[3]; 
				$sec = $matches[4]; 
				if (($namedformat==0)||($namedformat==1)) $namedformat = 3; 
				if ($namedformat==2) $namedformat = 4; 
			} 
			else 
			{ 				
				return $ts; 
			} 
		} 
		else 
		{ 
			return $ts; 
		} 
		
		if (!isset($year)) $year = 0; // dummy value for times 
		if (!isset($month)) $month = 0; 
		if (!isset($day)) $day = 0; 
		if (!isset($hour)) $hour = 0; 
		if (!isset($min)) $min = 0; 
		if (!isset($sec)) $sec = 0; 
		$uts = @mktime($hour,  $min,  $sec,  $month,  $day,  $year); 
		
		/*$consulta = "SELECT DATE_FORMAT('".$year."-".$month,."-".$day."' ,'%W') as Dia_Textual";				 
		//echo $consulta."<bR>";
		$result2=$bd->ejecutar($consulta); 
		if (($row2 = mysqli_fetch_array($result2) ))							
		{			
			$Dia_Textual = $row2["Dia_Textual"];
		}
		mysqli_free_result($result2);*/				
		
		if ($uts < 0) { // failed to convert 				
			$year = substr_replace("0000",  $year,  -1 * strlen($year)); 
			$month = substr_replace("00",  $month,  -1 * strlen($month)); 
			$day = substr_replace("00",  $day,  -1 * strlen($day)); 
			$hour = substr_replace("00",  $hour,  -1 * strlen($hour)); 
			$min = substr_replace("00",  $min,  -1 * strlen($min)); 
			$sec = substr_replace("00",  $sec,  -1 * strlen($sec)); 
			$DefDateFormat = str_replace("yyyy",  $year,  DEFAULT_DATE_FORMAT); 
			$DefDateFormat = str_replace("mm",  $month,  $DefDateFormat); 
			$DefDateFormat = str_replace("dd",  $day,  $DefDateFormat); 		
			
			switch ($namedformat) { 
				case 0: 
					return $DefDateFormat." $hour:$min:$sec"; 
					break; 
				case 1://unsupported,  return general date 
					return $DefDateFormat." $hour:$min:$sec"; 
					break; 
				case 2: 
					return $DefDateFormat; 
					break; 
				case 3: 
						if (intval($hour)==0) 
							return "12:$min:$sec AM"; 
						elseif (intval($hour)>0 && intval($hour)<12) 
							return "$hour:$min:$sec AM"; 
						elseif (intval($hour)==12) 
							return "$hour:$min:$sec PM"; 
						elseif (intval($hour)>12 && intval($hour)<=23) 
							return (intval($hour)-12).":$min:$sec PM"; 
						else 
							return "$hour:$min:$sec"; 
					break; 
				case 4: 
					return "$hour:$min:$sec"; 
					break; 
				case 5: 
					return "$year". EW_DATE_SEPARATOR . "$month" . EW_DATE_SEPARATOR . "$day"; 
					break; 
				case 6: 
					return "$month". EW_DATE_SEPARATOR ."$day" . EW_DATE_SEPARATOR . "$year"; 
					break; 
				case 7:	
					//echo "$day" . EW_DATE_SEPARATOR ."$month" . EW_DATE_SEPARATOR . "$year"; 					
					return "$day" . EW_DATE_SEPARATOR ."$month" . EW_DATE_SEPARATOR . "$year"; 
					break; 
				case 8: 
					return $Dia_Textual.", ".$month. EW_DATE_SEPARATOR ."$day" . EW_DATE_SEPARATOR . "$year"; 
					break; 
			} 
		} else { 			
			switch ($namedformat) { 
				case 0: 
					return strftime($DefDateFormat." %H:%M:%S",  $uts); 
					break; 
				case 1: 
					return strftime("%A,  %B %d,  %Y",  $uts); 
					break; 
				case 2: 
					return strftime($DefDateFormat,  $uts); 
					break; 
				case 3: 
					return strftime("%I:%M:%S %p",  $uts); 
					break; 
				case 4: 
					return strftime("%H:%M:%S",  $uts); 
					break; 
				case 5: 
					return strftime("%Y" . EW_DATE_SEPARATOR . "%m" . EW_DATE_SEPARATOR . "%d",  $uts); 
					break; 
				case 6: 
					return strftime("%m" . EW_DATE_SEPARATOR . "%d" . EW_DATE_SEPARATOR . "%Y",  $uts); 
					break; 
				case 7: 					
					return strftime("%d" . EW_DATE_SEPARATOR . "%m" . EW_DATE_SEPARATOR . "%Y",  $uts); 
					break; 
				case 8: 
					return date("l", $uts).", ".$month. EW_DATE_SEPARATOR ."$day" . EW_DATE_SEPARATOR . "$year"; 
					break; 
			} 
		} 
	}
	
	//funcion que devuelve el último día de un mes y año dados
	function ultimoDia($mes,$ano){
		$ultimo_dia=28;
		while (checkdate($mes,$ultimo_dia,$ano)){
				$ultimo_dia++;
		}    
		$ultimo_dia--;
		return $ultimo_dia;
	}
	
	//funcion que devuelve el último día de un mes y año dados
	function Dias_Habiles($Fecha_Inicio, $Fecha_Fin, $bd)
	{
		$feriados = array("1-1","13-2","13-4","26-5","02-11","25-12");   
	
		$consulta = "SELECT DATEDIFF('".$Fecha_Fin."', '".$Fecha_Inicio."') as dias";	
		//echo $consulta."<br>";		 
		$result=$bd->ejecutar($consulta); 

		if (($row = mysqli_fetch_array($result) ))							
		{			
			$total_dias = $row["dias"]+1;
			
			$diasTrans      = 0; // dias transcurridos  
			$diasHabiles    = 0;  
			while($diasTrans<($total_dias))  
			{   
				$consulta = "SELECT DATE_ADD('".$Fecha_Inicio."', INTERVAL ".($diasTrans)." DAY) AS Fecha_Nuevo_Dia, DAYOFWEEK(DATE_ADD('".$Fecha_Inicio."', INTERVAL ".($diasTrans)." DAY)) AS Dia_Semana, EXTRACT(DAY FROM DATE_ADD('".$Fecha_Inicio."', INTERVAL ".($diasTrans)." DAY) ) AS Dia, EXTRACT(MONTH FROM DATE_ADD('".$Fecha_Inicio."', INTERVAL ".($diasTrans)." DAY) ) AS Mes   ";				 
				//echo $consulta."<bR>";
				$result2=$bd->ejecutar($consulta); 
				if (($row2 = mysqli_fetch_array($result2) ))							
				{			
					$Fecha_Nuevo_Dia = $row2["Fecha_Nuevo_Dia"];
					$Dia_Semana = $row2["Dia_Semana"];
					$Dia = $row2["Dia"];
					$Mes = $row2["Mes"];
				}
				mysqli_free_result($result2);		
				
				//echo $Fecha_Nuevo_Dia."***".$Dia_Semana."***".$Dia."***".$Mes."<br>";
				if($Dia_Semana!=1 && $Dia_Semana!=7)  
				{   
					$feriado    = $Dia."-".$Mes;  
					//echo $feriado."<br>";
					if(!in_array($feriado,$feriados))  
					{   $diasHabiles++; }  
				}  
				$diasTrans++;  
			}  
		}
		mysqli_free_result($result);		
		
		/*echo "<br /><br /><b>Fecha_Inicial:".$fechaInicial."</b>";	
		echo "<br /><br /><b>Fecha_Fin:".$Fecha_Fin."</b>";	
		echo "<br /><br /><b>Total Dias:".$total_dias."</b>";			
		echo "<br /><br /><b>Dias Habiles:".$diasHabiles."</b>";	*/
		return $diasHabiles;
	}
	function Es_Dia_Habil($Fecha, $bd)
	{
		$feriados = array("1-1","13-2","13-4","26-5","02-11","25-12");  
	
		$consulta = "SELECT DAYOFWEEK('".$Fecha."') AS Dia_Semana, EXTRACT(DAY FROM '".$Fecha."') AS Dia, EXTRACT(MONTH FROM '".$Fecha."') AS Mes   ";				 
		//echo $consulta."<bR>";
		$result2=$bd->ejecutar($consulta); 
		if (($row2 = mysqli_fetch_array($result2) ))							
		{			
			$Dia_Semana = $row2["Dia_Semana"];
			$Dia = $row2["Dia"];
			$Mes = $row2["Mes"];
			
			if($Dia_Semana!=1 && $Dia_Semana!=7)  
			{   
				$feriado    = $Dia."-".$Mes;  
				//echo $feriado."<br>";
				if(!in_array($feriado,$feriados))  
				{   
					$resultado=true;
				}  
				else
				{
					$resultado=false;
				}
			}  
			else
			{
				$resultado=false;
			}
		}
		else
		{
			$resultado=false;
		}
		mysqli_free_result($result2);									
				
		return $resultado;
	}
	
	
	function calcula_numero_dia_semana($dia,$mes,$ano){
		$numerodiasemana = date('w', mktime(0,0,0,$mes,$dia,$ano));
		if ($numerodiasemana == 0) 
			$numerodiasemana = 6;
		else
			$numerodiasemana--;
		return $numerodiasemana;
	}
	
	function dame_nombre_mes($mes){
		 switch ($mes){           
			case 1:
				$nombre_mes="January";
				break;
			case 2:
				$nombre_mes="February";
				break;
			case 3:
				$nombre_mes="March";
				break;
			case 4:
				$nombre_mes="April";
				break;
			case 5:
				$nombre_mes="May";
				break;
			case 6:
				$nombre_mes="June";
				break;
			case 7:
				$nombre_mes="July";
				break;
			case 8:
				$nombre_mes="August";
				break;
			case 9:
				$nombre_mes="September";
				break;
			case 10:
				$nombre_mes="October";
				break;
			case 11:
				$nombre_mes="November";
				break;
			case 12:
				$nombre_mes="December";
				break;
		}
		return $nombre_mes;
	}
	//------------------------------------------------------------------------------- 
	// Function for debug 
	function Trace($aMsg) 
	{ 
		$ts = fopen ("debug.txt", "a+"); 
		$ts.file_put_contents($aMsg); 
		$ts.fclose; 
	} 	
	
	function left($str, $length) 
	{
		return substr($str, 0, $length);
	}
		
	function right($str, $length) 
	{
		return substr($str, -$length);
	}



	
	// formatcurrency 
	/* 
	formatcurrency(Expression[, NumDigitsAfterDecimal [, IncludeLeadingDigit 
	 [, UseParensForNegativeNumbers [, GroupDigits]]]]) 
	NumDigitsAfterDecimal is the numeric value indicating how many places to the 
	right of the decimal are displayed 
	-1 Use Default 
	The IncludeLeadingDigit,  UseParensForNegativeNumbers,  and GroupDigits 
	arguments have the following settings: 
	-1 True 
	0 False 
	-2 Use Default 
	*/ 
	function formatcurrency($amount,  $NumDigitsAfterDecimal,  $IncludeLeadingDigit,  $UseParensForNegativeNumbers,  $GroupDigits) 
	{ 	
		// export the values returned by localeconv into the local scope 
		if (function_exists("localeconv")) extract(localeconv()); 
	
		// set defaults if locale is not set 
		if (empty($currency_symbol)) $currency_symbol = DEFAULT_CURRENCY_SYMBOL; 
		if (empty($mon_decimal_point)) $mon_decimal_point = DEFAULT_MON_DECIMAL_POINT; 
		if (empty($mon_thousands_sep)) $mon_thousands_sep = DEFAULT_MON_THOUSANDS_SEP; 
		if (empty($positive_sign)) $positive_sign = DEFAULT_POSITIVE_SIGN; 
		if (empty($negative_sign)) $negative_sign = DEFAULT_NEGATIVE_SIGN; 
		if (empty($frac_digits) || $frac_digits == CHAR_MAX) $frac_digits = DEFAULT_FRAC_DIGITS; 
		if (empty($p_cs_precedes) || $p_cs_precedes == CHAR_MAX) $p_cs_precedes = DEFAULT_P_CS_PRECEDES; 
		if (empty($p_sep_by_space) || $p_sep_by_space == CHAR_MAX) $p_sep_by_space = DEFAULT_P_SEP_BY_SPACE; 
		if (empty($n_cs_precedes) || $n_cs_precedes == CHAR_MAX) $n_cs_precedes = DEFAULT_N_CS_PRECEDES; 
		if (empty($n_sep_by_space) || $n_sep_by_space == CHAR_MAX) $n_sep_by_space = DEFAULT_N_SEP_BY_SPACE; 
		if (empty($p_sign_posn) || $p_sign_posn == CHAR_MAX) $p_sign_posn = DEFAULT_P_SIGN_POSN; 
		if (empty($n_sign_posn) || $n_sign_posn == CHAR_MAX) $n_sign_posn = DEFAULT_N_SIGN_POSN; 
	
		// check $NumDigitsAfterDecimal 
		if ($NumDigitsAfterDecimal > -1) 
			$frac_digits = $NumDigitsAfterDecimal; 
	
		// check $UseParensForNegativeNumbers 
		if ($UseParensForNegativeNumbers == -1) { 
			$n_sign_posn = 0; 
			if ($p_sign_posn == 0) { 
				if (DEFAULT_P_SIGN_POSN != 0) 
					$p_sign_posn = DEFAULT_P_SIGN_POSN; 
				else 
					$p_sign_posn = 3; 
			} 
		} elseif ($UseParensForNegativeNumbers == 0) { 
			if ($n_sign_posn == 0) 
				if (DEFAULT_P_SIGN_POSN != 0) 
					$n_sign_posn = DEFAULT_P_SIGN_POSN; 
				else 
					$n_sign_posn = 3; 
		} 
	
		// check $GroupDigits 
		if ($GroupDigits == -1) { 
			$mon_thousands_sep = DEFAULT_MON_THOUSANDS_SEP; 
		} elseif ($GroupDigits == 0) { 
			$mon_thousands_sep = ""; 
		} 
	
		// start by formatting the unsigned number 
		$number = number_format(abs($amount), 
								$frac_digits, 
								$mon_decimal_point, 
								$mon_thousands_sep); 
	
		// check $IncludeLeadingDigit 
		if ($IncludeLeadingDigit == 0) { 
			if (substr($number,  0,  2) == "0.") 
				$number = substr($number,  1,  strlen($number)-1); 
		} 
		if ($amount < 0) { 
			$sign = $negative_sign; 
	
			// "extracts" the boolean value as an integer 
			$n_cs_precedes  = intval($n_cs_precedes  == true); 
			$n_sep_by_space = intval($n_sep_by_space == true); 
			$key = $n_cs_precedes . $n_sep_by_space . $n_sign_posn; 
		} else { 
			$sign = $positive_sign; 
			$p_cs_precedes  = intval($p_cs_precedes  == true); 
			$p_sep_by_space = intval($p_sep_by_space == true); 
			$key = $p_cs_precedes . $p_sep_by_space . $p_sign_posn; 
		} 
		$formats = array( 
	
		  // currency symbol is after amount 
	
		  // no space between amount and sign 
		  '000' => '(%s' . $currency_symbol . ')', 
		  '001' => $sign . '%s ' . $currency_symbol, 
		  '002' => '%s' . $currency_symbol . $sign, 
		  '003' => '%s' . $sign . $currency_symbol, 
		  '004' => '%s' . $sign . $currency_symbol, 
	
		  // one space between amount and sign 
		  '010' => '(%s ' . $currency_symbol . ')', 
		  '011' => $sign . '%s ' . $currency_symbol, 
		  '012' => '%s ' . $currency_symbol . $sign, 
		  '013' => '%s ' . $sign . $currency_symbol, 
		  '014' => '%s ' . $sign . $currency_symbol, 
	
		  // currency symbol is before amount 
	
		  // no space between amount and sign 
		  '100' => '(' . $currency_symbol . '%s)', 
		  '101' => $sign . $currency_symbol . '%s', 
		  '102' => $currency_symbol . '%s' . $sign, 
		  '103' => $sign . $currency_symbol . '%s', 
		  '104' => $currency_symbol . $sign . '%s', 
	
		  // one space between amount and sign 
		  '110' => '(' . $currency_symbol . ' %s)', 
		  '111' => $sign . $currency_symbol . ' %s', 
		  '112' => $currency_symbol . ' %s' . $sign, 
		  '113' => $sign . $currency_symbol . ' %s', 
		  '114' => $currency_symbol . ' ' . $sign . '%s'); 
	
	  // lookup the key in the above array 
		return sprintf($formats[$key],  $number); 
	} 
	
	// formatnumber 
	/* 
	formatnumber(Expression[, NumDigitsAfterDecimal [, IncludeLeadingDigit 
		[, UseParensForNegativeNumbers [, GroupDigits]]]]) 
	NumDigitsAfterDecimal is the numeric value indicating how many places to the 
	right of the decimal are displayed 
	-1 Use Default 
	The IncludeLeadingDigit,  UseParensForNegativeNumbers,  and GroupDigits 
	arguments have the following settings: 
	-1 True 
	0 False 
	-2 Use Default 
	*/ 
	function formatnumber($amount,  $NumDigitsAfterDecimal,  $IncludeLeadingDigit,  $UseParensForNegativeNumbers,  $GroupDigits) 
	{ 
	
	  // export the values returned by localeconv into the local scope 
	  if (function_exists("localeconv")) extract(localeconv()); 
	
		// set defaults if locale is not set 
		if (empty($currency_symbol)) $currency_symbol = DEFAULT_CURRENCY_SYMBOL; 
		if (empty($mon_decimal_point)) $mon_decimal_point = DEFAULT_MON_DECIMAL_POINT; 
		if (empty($mon_thousands_sep)) $mon_thousands_sep = DEFAULT_MON_THOUSANDS_SEP; 
		if (empty($positive_sign)) $positive_sign = DEFAULT_POSITIVE_SIGN; 
		if (empty($negative_sign)) $negative_sign = DEFAULT_NEGATIVE_SIGN; 
		if (empty($frac_digits) || $frac_digits == CHAR_MAX) $frac_digits = DEFAULT_FRAC_DIGITS; 
		if (empty($p_cs_precedes) || $p_cs_precedes == CHAR_MAX) $p_cs_precedes = DEFAULT_P_CS_PRECEDES; 
		if (empty($p_sep_by_space) || $p_sep_by_space == CHAR_MAX) $p_sep_by_space = DEFAULT_P_SEP_BY_SPACE; 
		if (empty($n_cs_precedes) || $n_cs_precedes == CHAR_MAX) $n_cs_precedes = DEFAULT_N_CS_PRECEDES; 
		if (empty($n_sep_by_space) || $n_sep_by_space == CHAR_MAX) $n_sep_by_space = DEFAULT_N_SEP_BY_SPACE; 
		if (empty($p_sign_posn) || $p_sign_posn == CHAR_MAX) $p_sign_posn = DEFAULT_P_SIGN_POSN; 
		if (empty($n_sign_posn) || $n_sign_posn == CHAR_MAX) $n_sign_posn = DEFAULT_N_SIGN_POSN; 
	
		// check $NumDigitsAfterDecimal 
		if ($NumDigitsAfterDecimal > -1) 
			$frac_digits = $NumDigitsAfterDecimal; 
	
		// check $UseParensForNegativeNumbers 
		if ($UseParensForNegativeNumbers == -1) { 
			$n_sign_posn = 0; 
			if ($p_sign_posn == 0) { 
				if (DEFAULT_P_SIGN_POSN != 0) 
					$p_sign_posn = DEFAULT_P_SIGN_POSN; 
				else 
					$p_sign_posn = 3; 
			} 
		} elseif ($UseParensForNegativeNumbers == 0) { 
			if ($n_sign_posn == 0) 
				if (DEFAULT_P_SIGN_POSN != 0) 
					$n_sign_posn = DEFAULT_P_SIGN_POSN; 
				else 
					$n_sign_posn = 3; 
		} 
	
		// check $GroupDigits 
		if ($GroupDigits == -1) { 
			$mon_thousands_sep = DEFAULT_MON_THOUSANDS_SEP; 
		} elseif ($GroupDigits == 0) { 
			$mon_thousands_sep = ""; 
		} 
	
	  // start by formatting the unsigned number 
	  $number = number_format(abs($amount), 
							  $frac_digits, 
							  $mon_decimal_point, 
							  $mon_thousands_sep); 
	
		// check $IncludeLeadingDigit 
		if ($IncludeLeadingDigit == 0) { 
			if (substr($number,  0,  2) == "0.") 
				$number = substr($number,  1,  strlen($number)-1); 
		} 
		if ($amount < 0) { 
			$sign = $negative_sign; 
			$key = $n_sign_posn; 
		} else { 
			$sign = $positive_sign; 
			$key = $p_sign_posn; 
		} 
		$formats = array( 
			'0' => '(%s)', 
			'1' => $sign . '%s', 
			'2' => $sign . '%s', 
			'3' => $sign . '%s', 
			'4' => $sign . '%s'); 
	
		// lookup the key in the above array 
		return sprintf($formats[$key],  $number); 
	} 
	
	// FormatPercent 
	/* 
	FormatPercent(Expression[, NumDigitsAfterDecimal [, IncludeLeadingDigit 
		[, UseParensForNegativeNumbers [, GroupDigits]]]]) 
	NumDigitsAfterDecimal is the numeric value indicating how many places to the 
	right of the decimal are displayed 
	-1 Use Default 
	The IncludeLeadingDigit,  UseParensForNegativeNumbers,  and GroupDigits 
	arguments have the following settings: 
	-1 True 
	0 False 
	-2 Use Default 
	*/ 
	function FormatPercent($amount,  $NumDigitsAfterDecimal,  $IncludeLeadingDigit,  $UseParensForNegativeNumbers,  $GroupDigits) 
	{ 
	
	  // export the values returned by localeconv into the local scope 
	  if (function_exists("localeconv")) extract(localeconv()); 
	
		// set defaults if locale is not set 
		if (empty($currency_symbol)) $currency_symbol = DEFAULT_CURRENCY_SYMBOL; 
		if (empty($mon_decimal_point)) $mon_decimal_point = DEFAULT_MON_DECIMAL_POINT; 
		if (empty($mon_thousands_sep)) $mon_thousands_sep = DEFAULT_MON_THOUSANDS_SEP; 
		if (empty($positive_sign)) $positive_sign = DEFAULT_POSITIVE_SIGN; 
		if (empty($negative_sign)) $negative_sign = DEFAULT_NEGATIVE_SIGN; 
		if (empty($frac_digits) || $frac_digits == CHAR_MAX) $frac_digits = DEFAULT_FRAC_DIGITS; 
		if (empty($p_cs_precedes) || $p_cs_precedes == CHAR_MAX) $p_cs_precedes = DEFAULT_P_CS_PRECEDES; 
		if (empty($p_sep_by_space) || $p_sep_by_space == CHAR_MAX) $p_sep_by_space = DEFAULT_P_SEP_BY_SPACE; 
		if (empty($n_cs_precedes) || $n_cs_precedes == CHAR_MAX) $n_cs_precedes = DEFAULT_N_CS_PRECEDES; 
		if (empty($n_sep_by_space) || $n_sep_by_space == CHAR_MAX) $n_sep_by_space = DEFAULT_N_SEP_BY_SPACE; 
		if (empty($p_sign_posn) || $p_sign_posn == CHAR_MAX) $p_sign_posn = DEFAULT_P_SIGN_POSN; 
		if (empty($n_sign_posn) || $n_sign_posn == CHAR_MAX) $n_sign_posn = DEFAULT_N_SIGN_POSN; 
	
		// check $NumDigitsAfterDecimal 
		if ($NumDigitsAfterDecimal > -1) 
			$frac_digits = $NumDigitsAfterDecimal; 
	
		// check $UseParensForNegativeNumbers 
		if ($UseParensForNegativeNumbers == -1) { 
			$n_sign_posn = 0; 
			if ($p_sign_posn == 0) { 
				if (DEFAULT_P_SIGN_POSN != 0) 
					$p_sign_posn = DEFAULT_P_SIGN_POSN; 
				else 
					$p_sign_posn = 3; 
			} 
		} elseif ($UseParensForNegativeNumbers == 0) { 
			if ($n_sign_posn == 0) 
				if (DEFAULT_P_SIGN_POSN != 0) 
					$n_sign_posn = DEFAULT_P_SIGN_POSN; 
				else 
					$n_sign_posn = 3; 
		} 
	
		// check $GroupDigits 
		if ($GroupDigits == -1) { 
			$mon_thousands_sep = DEFAULT_MON_THOUSANDS_SEP; 
		} elseif ($GroupDigits == 0) { 
			$mon_thousands_sep = ""; 
		} 
	
		// start by formatting the unsigned number 
		$number = number_format(abs($amount)*100, 
								$frac_digits, 
								$mon_decimal_point, 
								$mon_thousands_sep); 
	
		// check $IncludeLeadingDigit 
		if ($IncludeLeadingDigit == 0) { 
			if (substr($number,  0,  2) == "0.") 
				$number = substr($number,  1,  strlen($number)-1); 
		} 
		if ($amount < 0) { 
			$sign = $negative_sign; 
			$key = $n_sign_posn; 
		} else { 
			$sign = $positive_sign; 
			$key = $p_sign_posn; 
		} 
		$formats = array( 
			'0' => '(%s%%)', 
			'1' => $sign . '%s%%', 
			'2' => $sign . '%s%%', 
			'3' => $sign . '%s%%', 
			'4' => $sign . '%s%%'); 
	
	  // lookup the key in the above array 
		return sprintf($formats[$key],  $number); 
	} 
/* ****************************************************************************************************************/
/* ****************************************************************************************************************/
/* ****************************************************************************************************************/

	function displayANInumber($ani,$agente)
	{	
		if ($agente == 252)
		{
			return "xxxxxxxx:".substr($ani, -3);
		}
		else
		{
			return $ani;
		}
	}

	/*sub addH(cadena)
	textoHtml = textoHtml & replace(cadena,"^",chr(34)) & chr(13)
	End Sub*/

	// nCurrency
	// Imprime el valor de un campo, validandolo y con el formato Currency
	// si la cadena es null, o caracter devuelve la cadena 'n.a.'
	function ncurrency($campo, $numdecimales)
	{
		if (is_numeric($campo) == false) 
			return "n.a.";
		else
		{
			return formatcurrency($campo,$numdecimales);
		}
	}

	// formatMoney
	// Imprime el valor de un campo, validandolo y con el formato Currency
	//' si la cadena es null, o caracter devuelve la cadena 'n.a.'
	function formatMoney($campo, $numdecimales)
	{
		if ($_SESSION["EntityID"] == 253) 
			return "&euro;".formatnumber($campo, $numdecimales, -1, 0, -1);
		else
		{
			return formatcurrency($campo,$numdecimales);
		}
	}

	function formatMoneyAgent($agente, $campo, $numdecimales)
	{
		if ($agente == 253) 
			return "&euro;".formatnumber(campo, numdecimales, -1, 0, -1);
		else
		{
			return formatcurrency(campo,numdecimales);
		}
	}

	// nval
	// devuelve el valor numerico de un campo, si este es NULL devuelve 0
	function nval($campo)
	{
		if (is_numeric($campo) == false) 
			return 0;
		else
		{
			return $campo;
		}
	}

	// verifica que la divisione entre campo1 y campo2 sea valida caso contrario devuelve n.a.
	function valDiv($campo1,$campo2)
	{
		if ($campo2 == 0 )
			return "n.a.";
		else
		{
			return $campo1/$campo2;
		}
	}

	// idem a valdiv pero devuelve el entero de la division de campo1/campo2
	function valDivInteger($campo1,$campo2)
	{
		if ( (is_numeric($campo2) == false) || (is_numeric($campo1) == false )  )
			return "N.a.";
		else
		{
			if ($campo2 == 0 )
				return  "n.a.";
			else
			{
				return formatnumber($campo1/$campo2,0);
			}
		}
	}

	// idem a valdiv pero devuelve el numero con formato de la division de campo1/campo2 con decimales
	function valDivPercent($campo1,$campo2,$digitos)
	{
		if ( (is_numeric($campo2) == false) || ( is_numeric(campo1) == false )  )
			return  "N.a.";
		else
		{
			if ($campo2 == 0 )
				return "n.a.";
			else
			{
				return formatnumber($campo1/$campo2, $digitos);
			}
		}
	}



	// Print string
	// Imprime la cadena string
	function print_($cadena)
	{
		echo $cadena;
	}

	// Print string
	// Imprime la cadena string
	function printHex($cadena)
	{
		if (is_null($cadena)  )
		{
			echo "n.a.";
		}
		else
		{
			echo acentos($cadena);
		}
	}


	//pt(cadena)
	//devuelve una cadena de texto luego de verificarla
	function ptex($texto,$nombre)
	{
		if (is_null($texto) )
			echo "";
		else
		{
			echo texto;
		}
	}	

	
	function ConvertSeconds($Seconds) 
	{	
		 $dif=Seconds;
		 $hours = floor($dif / 3600);
		 $temp_remainder = $dif - ($hours * 3600);
			
		 $minutes = floor($temp_remainder / 60);
		 $temp_remainder = $temp_remainder - ($minutes * 60);
			
		 $seconds = $temp_remainder;
			  
		 // leading zero's - not bothered about hours
		 $min_lead=':';
		 if($minutes <=9)
			$min_lead .= '0';
		  $sec_lead=':';
		 if($seconds <=9)
			$sec_lead .= '0';
			
	  // difference/duration returned as Hours:Mins:Secs e.g. 01:29:32
	
	  return $hours.$min_lead.$minutes.$sec_lead.$seconds;
	}	 	

	function validaRol($menuId,$bd)
	{	
		$sql = "select * from  rolesmenuitems where mnu_ID = ".$menuId." and Rol_ID = ".$_SESSION["Rol_ID"];
		//echo $sql."<bR>";	
		$result=$bd->ejecutar($sql); 
		if (( $row = mysqli_fetch_array($result) ))			
		{		
			return 1; 	//'1  'True	
		}
		else
		{
			return 0;	//'0 False
		}			
	}
	

	/*function nameBatch(BatchID)
	Set rol = server.CreateObject ("ADODB.recordset")
	str = "select * from batch_group where batch_group_id = " & BatchID 
	rol.open str, GBill
	if rol.eof  
		nameBatch = "n.a."
	else
	{
		nameBatch = rol.fields("batch_group_description")
	}
	rol.close
	set rol = nothing
	End function
	
	Function formatnumbernoComas(monto,decimales)
	formatnumbernoComas = replace(formatnumber(monto,decimales),",","")
	End function
	
	
	Function BorrarArchivo(archivo)
		dim fs
		Set fs = Server.CreateObject("Scripting.FileSystemObject")
		if fs.FileExists(archivo)  fs.DeleteFile(archivo)
		Set fs = Nothing
	End function
	
	
	Function BorrarCarpeta(carpeta)
		Dim fs
		Set fs = Server.CreateObject("Scripting.FileSystemObject")
		if fs.FolderExists(carpeta)  fs.DeleteFolder(carpeta)
		Set fs = Nothing
	End Function*/


	function acentos($x) 
	{
		// Caracteres español portugues, frances
		// Tambien acepta dobles comillas y comillas simples, corchetes
		str_replace("%body%", "black", "<body text='%body%'>");

		$x = str_replace("¡","&#xA1;",$x);
		$x = str_replace("&iexcl;","&#xA1;",$x);
		$x = str_replace("¿","&#xBF;",$x);	
		$x = str_replace("&iquest;","&#xBF;",$x);
		$x = str_replace("À","&#xC0;",$x);	
		$x = str_replace("&Agrave;","&#xC0;",$x);
		$x = str_replace("à","&#xE0;",$x);	
		$x = str_replace("&agrave;","&#xE0;",$x);
		$x = str_replace("Á","&#xC1;",$x);	
		$x = str_replace("&Aacute;","&#xC1;",$x);
		$x = str_replace("á","&#xE1;",$x);	
		$x = str_replace("&aacute;","&#xE1;",$x);
		$x = str_replace("Â","&#xC2;",$x);
		$x = str_replace("&Acirc;","&#xC2;",$x);
		$x = str_replace("â","&#xE2;",$x);
		$x = str_replace("&acirc;","&#xE2;",$x);
		$x = str_replace("Ã","&#xC3;",$x);
		$x = str_replace("&Atilde;","&#xC3;",$x);
		$x = str_replace("ã","&#xE3;",$x);
		$x = str_replace("&atilde;","&#xE3;",$x);
		$x = str_replace("Ä","&#xC4;",$x);
		$x = str_replace("&Auml;","&#xC4;",$x);
		$x = str_replace("ä","&#xE4;",$x);
		$x = str_replace("&auml;","&#xE4;",$x);
		$x = str_replace("Å","&#xC5;",$x);
		$x = str_replace("&Aring;","&#xC5;",$x);
		$x = str_replace("å","&#xE5;",$x);
		$x = str_replace("&aring;","&#xE5;",$x);
		$x = str_replace("Æ","&#xC6;",$x);
		$x = str_replace("&AElig;","&#xC6;",$x);
		$x = str_replace("æ","&#xE6;",$x);
		$x = str_replace("&aelig;","&#xE6;",$x);
		$x = str_replace("Ç","&#xC7;",$x);
		$x = str_replace("&Ccedil;","&#xC7;",$x);
		$x = str_replace("ç","&#xE7;",$x);
		$x = str_replace("&ccedil;","&#xE7;",$x);
		$x = str_replace("È","&#xC8;",$x);
		$x = str_replace("&Egrave;","&#xC8;",$x);
		$x = str_replace("è","&#xE8;",$x);
		$x = str_replace("&egrave;","&#xE8;",$x);
		$x = str_replace("É","&#xC9;",$x);
		$x = str_replace("&Eacute;","&#xC9;",$x);
		$x = str_replace("é","&#xE9;",$x);
		$x = str_replace("&eacute;","&#xE9;",$x);
		$x = str_replace("Ê","&#xCA;",$x);
		$x = str_replace("&Ecirc;","&#xCA;",$x);
		$x = str_replace("ê","&#xEA;",$x);
		$x = str_replace("&ecirc;","&#xEA;",$x);
		$x = str_replace("Ë","&#xCB;",$x);
		$x = str_replace("&Euml;","&#xCB;",$x);
		$x = str_replace("ë","&#xEB;",$x);
		$x = str_replace("&euml;","&#xEB;",$x);
		$x = str_replace("Ì","&#xCC;",$x);
		$x = str_replace("&Igrave;","&#xCC;",$x);
		$x = str_replace("ì","&#xEC;",$x);
		$x = str_replace("&igrave;","&#xEC;",$x);
		$x = str_replace("Í","&#xCD;",$x);
		$x = str_replace("&Iacute;","&#xCD;",$x);
		$x = str_replace("í","&#xED;",$x);
		$x = str_replace("&iacute;","&#xED;",$x);
		$x = str_replace("Î","&#xCE;",$x);
		$x = str_replace("&Icirc;","&#xCE;",$x);
		$x = str_replace("î","&#xEE;",$x);
		$x = str_replace("&icirc;","&#xEE;",$x);
		$x = str_replace("Ï","&#xCF;",$x);
		$x = str_replace("&Iuml;","&#xCF;",$x);
		$x = str_replace("ï","&#xEF;",$x);
		$x = str_replace("&iuml;","&#xEF;",$x);
		$x = str_replace("Ñ","&#xD1;",$x);
		$x = str_replace("&Ntilde;","&#xD1;",$x);
		$x = str_replace("ñ","&#xF1;",$x);
		$x = str_replace("&ntilde;","&#xF1;",$x);
		$x = str_replace("Ò","&#xD2;",$x);
		$x = str_replace("&Ograve;","&#xD2;",$x);
		$x = str_replace("ò","&#xF2;",$x);
		$x = str_replace("&ograve;","&#xF2;",$x);
		$x = str_replace("Ó","&#xD3;",$x);
		$x = str_replace("&Oacute;","&#xD3;",$x);
		$x = str_replace("ó","&#xF3;",$x);
		$x = str_replace("&oacute;","&#xF3;",$x);
		$x = str_replace("Ô","&#xD4;",$x);
		$x = str_replace("&Ocirc;","&#xD4;",$x);
		$x = str_replace("ô","&#xF4;",$x);
		$x = str_replace("&ocirc;","&#xF4;",$x);
		$x = str_replace("Õ","&#xD5;",$x);
		$x = str_replace("&Otilde;","&#xD5;",$x);
		$x = str_replace("õ","&#xF5;",$x);
		$x = str_replace("&otilde;","&#xF5;",$x);
		$x = str_replace("Ö","&#xD6;",$x);
		$x = str_replace("&Ouml;","&#xD6;",$x);
		$x = str_replace("ö","&#xF6;",$x);
		$x = str_replace("&ouml;","&#xF6;",$x);
		$x = str_replace("Ø","&#xD8;",$x);
		$x = str_replace("&Oslash;","&#xD8;",$x);
		$x = str_replace("ø","&#xF8;",$x);
		$x = str_replace("&oslash;","&#xF8;",$x);
		$x = str_replace("Ù","&#xD9;",$x);
		$x = str_replace("&Ugrave;","&#xD9;",$x);
		$x = str_replace("ù","&#xF9;",$x);
		$x = str_replace("&ugrave;","&#xF9;",$x);
		$x = str_replace("Ú","&#xDA;",$x);
		$x = str_replace("&Uacute;","&#xDA;",$x);
		$x = str_replace("ú","&#xFA;",$x);
		$x = str_replace("&uacute;","&#xFA;",$x);
		$x = str_replace("Û","&#xDB;",$x);
		$x = str_replace("&Ucirc;","&#xDB;",$x);
		$x = str_replace("û","&#xFB;",$x);
		$x = str_replace("&ucirc;","&#xFB;",$x);
		$x = str_replace("Ü","&#xDC;",$x);
		$x = str_replace("&Uuml;","&#xDC;",$x);
		$x = str_replace("ü","&#xFC;",$x);
		$x = str_replace("&uuml;","&#xFC;",$x);
		
		$x = str_replace("[","&#x5B;",$x);
		$x = str_replace("]","&#x5D;",$x);
	
		$x = str_replace("¢","&#xA2;",$x);
		$x = str_replace("&cent;","&#xA2;",$x); 
		$x = str_replace("£","&#xA3;",$x);
		$x = str_replace("&pound;","&#xA3;",$x);
		//$x = str_replace("€","&#xAC;",$x);
		$x = str_replace("€","&euro;",$x);	
		//$x = str_replace("&euro;","&#xAC;",$x); 
		$x = str_replace("©","&#xA9;",$x);
		$x = str_replace("&copy;","&#xA9;",$x); 
		$x = str_replace("®","&#xAE;",$x);
		$x = str_replace("&reg;","&#xAE;",$x); 
		$x = str_replace("ª","&#xAA;",$x);
		$x = str_replace("&ordf;","&#xAA;",$x); 
		$x = str_replace("º","&#xBA;",$x);
		$x = str_replace("&ordm;","&#xBA;",$x); 
		$x = str_replace("°","&#xB0;",$x);
		$x = str_replace("&deg;","&#xB0;",$x); 
		$x = str_replace("±","&#xB1;",$x);
		$x = str_replace("&plusmn;","&#xB1;",$x);
		$x = str_replace("×","&#xD7;",$x);
		$x = str_replace("&times;","&#xD7;",$x); 
			
		return $x;
	}
	
	function acentos_voz($x) 
	{
		/*$x = str_replace("-","Á",$x);//193
		$x = str_replace("ß","á",$x);//225
		$x = str_replace("+","É",$x);//201
		$x = str_replace("T","é",$x);//233
		$x = str_replace("-","Í",$x);//205
		$x = str_replace("f","í",$x);//237
		$x = str_replace("+","Ó",$x);//211
		$x = str_replace("=","ó",$x);//243
		$x = str_replace("+ ","Ú",$x);//218
		$x = str_replace("·","ú",$x);//250*/
		//$x = str_replace("- ","Ñ",$x);//209
		//$x = str_replace("±","ñ",$x);//241
		//$x = str_replace("¦"," Numeral ",$x);//186		
		$x = str_replace("#"," Numeral ",$x);
				
		return $x;
	}

	function FormatPhoneNumber($strNumber)
	{		
		/*$strInput       
		$strTemp        	
		$I*/	           
			
		$strInput = UCase($strNumber);
		
		for ($I = 0; strlen($strInput)-1;$I++)
		{
			$strCurrentChar = substr($strInput, $I, 1);
			
			// Numbers (0 to 9)
			
			if ( (ord("0") <= ord($strCurrentChar)) && (ord($strCurrentChar) <= ord("9") ) )
			{ 
				$strTemp = $strTemp.$strCurrentChar;
			} 			
		}	
		return $strTemp;
	}

	//imprime el texto en color rojo si se encuentra encerrado entre []
	function textoRojo($texto)
	{
		if ( (strpos($texto, "[") > 0 ) && ( strpos($texto, "]") > 0 ) )
		{
			$nuevo_texto = str_replace($texto,"[","<font color=#993300>" );
			$nuevo_texto = str_replace($nuevo_texto,"]","</font>");
		}
		else
		{
			$nuevo_texto = $texto;
		}
		return $nuevo_texto;
	}

	function textoColor($texto)
	{
	 	$textoColor_nuevo = $texto;
		if ( (strpos($textoColor_nuevo, "{") > 0) && (strpos($textoColor_nuevo, "}") > 0   ) )
		{
			$textoColor_nuevo = str_replace($textoColor_nuevo,"{","<font color=#993300>" );
			$textoColor_nuevo = str_replace($textoColor_nuevo,"}","</font>");
		}
		if ((strpos($textoColor_nuevo, "[") > 0) && (strpos($textoColor_nuevo, "]") > 0 ))
		{
			$textoColor_nuevo = str_replace($textoColor_nuevo,"[","<font color=#0000CC>" );
			$textoColor_nuevo = str_replace($textoColor_nuevo,"]","</font>");
		}	
		return $textoColor_nuevo;
	}

// Functions to provide encoding/decoding of strings with Base64.
// 
// Encoding: myEncodedString = base64_encode( inputString )
// Decoding: myDecodedString = base64_decode( encodedInputString )
//
// Programmed by Markus Hartsmar for ShameDesigns in 2002. 
// Email me at: mark@shamedesigns.com
// Visit our website at: http://www.shamedesigns.com/
//
// Functions for encoding string to Base64
/*function base64_encode( $strIn )
{
	for ($n=0; strlen( $strIn )-1; $n=$n+3)
	{
		$c1 = ord( substr ( $strIn, $n, 1 ) );
		$c2 = ord( substr ( $strIn, $n + 1, 1 ) + chr(0) );
		$c3 = ord( substr ( $strIn, $n + 2, 1 ) + chr(0) );
		$w1 = (int)( $c1 / 4 ) 
		$w2 = ( $c1 && 3 ) * 16 + (int)( $c2 / 16 )
		if (strlen( $strIn ) >= $n + 1 )  
			$w3 = ( $c2 && 15 ) * 4 + (int)( $c3 / 64 ) ;
		else
		{ 
			$w3 = -1;
		}
		if (strlen( $strIn ) >= $n + 2  )
			$w4 = ($c3 &&63) ;
		else
		{ 
			$w4 = -1;
		}
		$strOut = $strOut + mimeencode( $w1 ) + mimeencode( $w2 ) + mimeencode( $w3 ) + mimeencode( $w4 );
	}
	return $strOut;
}

function mimeencode( $intIn )
{
	$Base64Chars =	"ABCDEFGHIJKLMNOPQRSTUVWXYZ" & _
			"abcdefghijklmnopqrstuvwxyz" & _
			"0123456789" & _
			"+/"
			
	if ($intIn >= 0  )
		return = substr( $Base64Chars, $intIn + 1, 1 ) 
	else
	{ 
		return = ""
	}
}


// Function to decode string from Base64
function base64_decode( $strIn )
//'	Dim w1, w2, w3, w4, n, strOut
	for ($n=0; strlen( $strIn )-1;$n=$n+4)
	{
		$w1 = mimedecode( substr( $strIn, $n, 1 ) );
		$w2 = mimedecode( substr( $strIn, $n + 1, 1 ) );
		$w3 = mimedecode( substr( $strIn, $n + 2, 1 ) );
		$w4 = mimedecode( substr( $strIn, $n + 3, 1 ) );
		if ($w2 >= 0 ) 
			$strOut = $strOut + chr( ( ( $w1 * 4 + (int)( $w2 / 16 ) ) && 255 ) );
		if ($w3 >= 0 )
			$strOut = $strOut + chr( ( ( $w2 * 16 + (int)( $w3 / 4 ) ) && 255 ) );
		if ($w4 >= 0 )
			$strOut = strOut + chr( ( ( $w3 * 64 + $w4 ) && 255 ) );
	}
	return strOut;
}

function mimedecode( $strIn )
{
	$Base64Chars =	"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
	if (strlen( $strIn ) == 0  )
		return -1 ;
	else
	{
		return strpos( $Base64Chars, $strIn ) - 1;
	}
}*/

//Mid=substr
//InStr=strpos
//Chr=chr
//Asc=ord
//UCase=strtoupper 
//split=explode
//ubound=sizeof 
//left = substr($strNumber,0,1)
//right = substr($strNumber,-1,1)

function DisplayMaskPhone($strNumber)
{
	$a = substr($strNumber,0,1);
	$b = substr($strNumber,1,3);
	$c = substr($strNumber,4,3);
	$d = substr($strNumber,-1,1);
	return  $a."(".$b.")".$c."-".$d;
}

/*function makePassword($maxLen)
{
	Randomize
	for ($intCounter = 1; $maxLen*5;$intCounter++)
	{
		$whatsNext = (int)(Rnd(day(now)) *10)
		$strNewPass = $strNewPass.Cstr(Int((whatsNext + 1) * Rnd * 3))
	}
	return left(strNewPass,maxLen)
}


function exist($batch, $Listabatch)
{
	$result = false;
	$lista = explode($Listabatch,"'");
	for ( $VarExistI = 0; sizeof($lista);$VarExistI ++)
	{
		if ($Batch == $lista($VarExistI)) 
		{
			result = true;
			break;
		}
	}	
	return $result;
}

function validaAgenteBolivia()
Set tabla2 = server.CreateObject ("ADODB.recordset")

str = "select * from BnP_Sellers_Alo_Hisp where SellerID in (select sellerID from Bnp_Operators_to_Sellers where OperatorID = "&session("OperatorID")&" )"
tabla2.open str, gbill
if tabla2.eof 
	validaAgenteBolivia = true
else
{
	validaAgenteBolivia = false
}
tabla2.close
set tabla2 = nothing
end function


function capturaDataCCard()
capturaDataCCard = validaRol(249)
end function


'********************************
'  colocar prefijos al numero de telefono segun segun el pais y batch
'********************************
function prefixPhNumero(country, BatchGroupID, numero)
	select case country 
		case "USA"
			if BatchGroupID = "63"    ' acceso 800 globalink
				 prefixPhNumero = "57" & trim(numero)
			else
{if BatchGroupID = "66"    'acceso 800 hispatelecom agregar un prefijo 9 por proveedor T1
				 prefixPhNumero = "579" & trim(numero)
			else
{
				prefixPhNumero = "1" & trim(numero)
			}
		case "COLOMBIA"	 
			 prefixPhNumero = "57" & trim(numero)
		case "SPAIN"
			prefixPhNumero = "34" & trim(numero)					
		case else
{
			 prefixPhNumero = "1" & trim(numero)
	 end select	
End function

'******************************************
'Insertar logs de clientes
'******************************************
sub insertLog_call(numerocuenta, tipo, detalle)
	str = "insert into log_call (BillingAccountId,lc_DateAndTime,lc_Agent,lc_CallType,lc_Detail) values ("&numerocuenta&",'" & now & "','"&session("username")&"','"& tipo &"', '" & detalle & "' )"
	gbill.execute str
end sub

sub insertLog_callDelay(numerocuenta, tipo, detalle, tiemposegundos)
	str = "insert into log_call (BillingAccountId,lc_DateAndTime,lc_Agent,lc_CallType,lc_Detail) values ("&numerocuenta&",'" & dateAdd("s", tiemposegundos, now) & "','"&session("username")&"','"& tipo &"', '" & detalle & "' )"
	gbill.execute str
end sub


sub BnP_InsertarlogCliente(BillingAccountId, tipo, detalle)
	
 CmdStr = "BnP_InsertarlogCliente " 	       
 CmdStr = CmdStr & BillingAccountId & ",'"
 CmdStr = CmdStr & now & "','"	
 CmdStr = CmdStr & session("username") & "','"					 
 CmdStr = CmdStr & tipo & "', '"			
 CmdStr = CmdStr & detalle & "'"			
	  
 Gbill.Execute (CmdStr)	
end sub

sub BnP_InsertarlogClienteDelay(BillingAccountId, tipo, detalle, tiemposegundos)

 CmdStr = "BnP_InsertarlogCliente " 	       
 CmdStr = CmdStr & BillingAccountId & ",'"
 CmdStr = CmdStr & dateAdd("s", tiemposegundos, now) & "','"	
 CmdStr = CmdStr & session("username") & "','"					 
 CmdStr = CmdStr & tipo & "', '"			
 CmdStr = CmdStr & detalle & "'"	
 
  Gbill.Execute (CmdStr)	
end sub


'Agregar una cadena de texto a un archivo

Sub EscribeArchivo(archivo,cadena)
ParaLectura = 1
ParaEscritura = 2
ParaAnexar = 8

if archivo <> "" 
	set confile = createObject("scripting.filesystemobject")  
	  
	if not confile.FileExists(archivo)  
		set fich = confile.CreateTextFile(archivo)
		fich.WriteLine(cadena)
		fich.close()
		set fich = Nothing
	else
{
		Set fich = confile.OpenTextFile(archivo, ParaAnexar, True)
 		fich.WriteLine(cadena)
		fich.close()
		set fich = Nothing
		
	}
}
end sub

'*************************************************
'
' Funciones para productos
'
'*************************************************

Function es_PinFree(BatchGroupID)  '
	es_PinFree = exist(BatchGroupID,"40,38,19,18,31,32,33,34,35,60,54,67,117,114,136,139")
End Function

Function es_AdvantagePlan(BatchGroupID)  '
	es_AdvantagePlan = exist(BatchGroupID,"136,139")
End Function

Function es_SIP(BatchGroupID)
	es_SIP = exist(BatchGroupID,"61,62,64,79,129,130,111,109,112,124,121,123,135")
End Function

Function es_SIP_str()
	es_SIP_str = "37,61,62,64,79,129,130,111,109,112,124,121,123,135"
	'37 = Internal Use mitelefono
End Function

Function es_809(BatchGroupID)
	es_809 = exist(BatchGroupID,"73,78,119,120,137,138")
End Function

'Acceso 800
Function es_800(BatchGroupID)
	es_800 = exist(BatchGroupID,"63,66")
End Function

Function es_SIPDID(BatchGroupID)   
	es_SIPDID = exist(BatchGroupID,"129,130,109,121,111,112,123,124")    
End Function

Function es_SIPDIDPinFree(BatchGroupID)   
	es_SIPDIDPinFree = exist(BatchGroupID,"109,121,111,112,123,124")  
End Function

Function es_Locutorio(BatchGroupID)
	es_Locutorio = exist(BatchGroupID,"69")
End Function

'Por paises
Function es_SIPDID_USA(BatchGroupID)   'DID USA
	es_SIPDID_USA = exist(BatchGroupID,"129,130,109,121,111,124")    
End Function

Function es_SIPDID_RD(BatchGroupID)  'DID Republica Dominicana 
	es_SIPDID_RD = exist(BatchGroupID,"112,123")    
End Function

Function es_SIPSimple(BatchGroupID)  'no DID
	es_SIPSimple = exist(BatchGroupID,"61,62,64,79,135")
End Function

Function es_controlMensualidad(BatchGroupID)  
	es_controlMensualidad = exist(BatchGroupID,"61,62,136,139,73,78,137,138,119,120,129,130,111,124,109,121,112,123")
End Function
'********************
Function es_SIPmensualidad(BatchGroupID)
if es_SIPDIDPinFree(BatchGroupID) or es_SIPDID(BatchGroupID) 
	es_SIPmensualidad = true 
else
{
	es_SIPmensualidad = false
}
End Function

Function es_SIPGlobalLink(BatchGroupID)
	es_SIPGlobalLink = exist(BatchGroupID,"104,105")
End Function

Function es_SIPControl(BatchGroupID)
	es_SIPControl = exist(BatchGroupID,"109,121")
End Function

Function es_SIPBasico(BatchGroupID)
	es_SIPBasico = exist(BatchGroupID,"110,122")
End Function

Function es_SIPFamilia(BatchGroupID)
	es_SIPFamilia = exist(BatchGroupID,"111,123")
End Function

Function es_SIPEmpresa(BatchGroupID)
	es_SIPEmpresa = exist(BatchGroupID,"112,124")
End Function
'*******************************
*/

	$numeros =    array("-", "UNO", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE"); 
    $numerosX =   array("-", "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE"); 
    $numeros100 = array("-", "CIENTO", "DOSCIENTOS", "TRECIENTOS", "CUATROCIENTOS", "QUINIENTOS", "SEICIENTOS", "SETECIENTOS", "OCHOCIENTOS", "NOVECIENTOS"); 
    $numeros11 =  array("-", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE"); 
    $numeros10 =  array("-", "-", "-", "TREINTA", "CUARENTA", "CINCUENTA", "SESENTA", "SETENTA", "OCHENTA", "NOVENTA"); 
function tresnumeros($n, $last) { 
            global $numeros100, $numeros10, $numeros11, $numeros, $numerosX; 
            if ($n == 100) return "CIEN "; 
            if ($n == 0) return "CERO "; 
            $r = ""; 
            $cen = floor($n / 100); 
            $dec = floor(($n % 100) / 10); 
            $uni = $n % 10; 
            if ($cen > 0) $r .= $numeros100[$cen] . " "; 

            switch ($dec) { 
                case 0: $special = 0; break; 
                case 1: $special = 10; break; 
                case 2: $special = 20; break; 
                default: $r .= $numeros10[$dec] . " "; $special = 30; break; 
            } 
            if ($uni == 0) { 
                if ($special==30); 
                else if ($special==20) $r .= "VEINTE "; 
                else if ($special==10) $r .= "DIEZ "; 
                else if ($special==0); 
            } else { 
                if ($special == 30 && !$last) $r .= "y " . $numerosX[$n%10] . " "; 
                else if ($special == 30) $r .= "y " . $numeros[$n%10] . " "; 
                else if ($special == 20) { 
                    if ($uni == 3) $r .= "VEINTITRES "; 
                    else if (!$last) $r .= "VEINTI" . $numerosX[$n%10] . " "; 
                    else $r .= "VEINTI" . $numeros[$n%10] . " "; 
                } else if ($special == 10) $r .= $numeros11[$n%10] . " "; 
                else if ($special == 0 && !$last) $r .= $numerosX[$n%10] . " "; 
                else if ($special == 0) $r .= $numeros[$n%10] . " "; 
            } 
            return $r; 
        } 

        function seisnumeros($n, $last) { 
            if ($n == 0) return "CERO "; 
            $miles = floor($n / 1000); 
            $units = $n % 1000; 
            $r = ""; 
            if ($miles == 1) $r .= "MIL "; 
            else if ($miles > 1) $r .= tresnumeros($miles, false) . "MIL "; 
            if ($units > 0) $r .= tresnumeros($units, $last); 
            return $r; 
        } 

        function docenumeros($n) { 
            if ($n == 0) return "CERO "; 
            $millo = floor($n / 1000000); 
            $units = $n % 1000000; 
            $r = ""; 
            if ($millo == 1) $r .= "UN MILLON "; 
            else if ($millo > 1) $r .= seisnumeros($millo, false) . "MILLONES "; 
            if ($units > 0) $r .= seisnumeros($units, true); 
            return $r; 
        }
		
	function mes_literal($numero)
	{
		switch ($numero) 
		{
     		 case 1:
	   	     	return "Enero";
    	     	break;
		     case 2:
	         	return "Febrero";
	       	 	break;
		     case 3:
	         	return "Marzo";
        	 	break;
			case 4:
	   	     	return "Abril";
    	     	break;
		     case 5:
	         	return "Mayo";
	       	 	break;
		     case 6:
	         	return "Junio";
        	 	break;
			case 7:
	   	     	return "Julio";
    	     	break;
		     case 8:
	         	return "Agosto";
	       	 	break;
		     case 9:
	         	return "Septiembre";
        	 	break;
			case 10:
	   	     	return "Octubre";
    	     	break;
		     case 11:
	         	return "Noviembre";
	       	 	break;
		     case 12:
	         	return "Diciembre";
        	 	break;			 
	 	}
	}
	
	function restaFechas($dFecIni, $dFecFin)
	{
		$dFecIni = str_replace("-","",$dFecIni);
		$dFecIni = str_replace("/","",$dFecIni);
		$dFecFin = str_replace("-","",$dFecFin);
		$dFecFin = str_replace("/","",$dFecFin);
	
		ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecIni, $aFecIni);
		ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecFin, $aFecFin);
	
		$date1 = mktime(0,0,0,$aFecIni[2], $aFecIni[1], $aFecIni[3]);
		$date2 = mktime(0,0,0,$aFecFin[2], $aFecFin[1], $aFecFin[3]);
	
		return round(($date2 - $date1) / (60 * 60 * 24));
	}
?>


