<?php 
 
/* Clase encargada de gestionar las conexiones a la base de datos */ 
Class Db{ 
 
   private $servidor; 
   private $usuario; 
   private $password; 
   private $base_datos; 
   private $link; 
   private $stmt; 
   private $array; 
   private $result;
   public static $showErrors;
 
   static $_instance; 
 
   /*La función construct es privada para evitar que el objeto pueda ser creado mediante new*/ 
   private function __construct(){ 
      $this->setConexion(); 
      $this->conectar(); 
   } 
   public function __destruct(){
        //codigo que implementa el destructor
		unset($conf);
	}  
 
   /*Método para establecer los parámetros de la conexión*/ 
   private function setConexion(){ 
      $conf = Conf::getInstance(); 
      $this->servidor=$conf->getHostDB(); 
      $this->base_datos=$conf->getDB(); 
      $this->usuario=$conf->getUserDB(); 
      $this->password=$conf->getPassDB(); 
   } 
 
   /*Evitamos el clonaje del objeto. Patrón Singleton*/ 
   private function __clone(){ } 
 
   /*Función encargada de crear, si es necesario, el objeto. Esta es la función que debemos llamar desde fuera de la clase para instanciar el objeto, y así, poder utilizar sus métodos*/ 
   public static function getInstance(){ 
      if (!(self::$_instance instanceof self)){ 
         self::$_instance=new self(); 
      } 
         return self::$_instance; 
   } 
 
   /*Realiza la conexión a la base de datos.*/ 
   private function conectar()
   { 
		/*$this->link=mysql_connect($this->servidor, $this->usuario, $this->password); 
		mysql_select_db($this->base_datos,$this->link); 
		@mysql_query("SET NAMES 'utf8'"); */
	  
	  	$this->link=mysqli_connect($this->servidor, $this->usuario, $this->password); 
		if (!$this->link) { 
			die('Could not connect: ' . mysql_error()); 
		} 		
		mysqli_select_db($this->link, $this->base_datos); 
		@mysql_query("SET NAMES 'utf8'"); 
   } 
 
   /*Método para ejecutar una sentencia sql*/ 
   public function ejecutar($sql)
   { 
      $this->stmt=mysqli_query($this->link, $sql); 
		/* Si hemos tenido éxito en la consulta devuelve 
		el identificador de la conexión, sino devuelve 0 */
	  	if (!$this->stmt) 
		{
			$this->Errno = mysql_errno();
			$this->Error = mysql_error();
			return 0;
		}
		else
		{			
			return $this->stmt; 
		}	     
   } 
   /**
	  * selecciona registros SELECTS
	  *
	  * @param string $consulta
	  * @return array
	*/
	public function dbSelect($consulta)
	{
	 	$res=array();
		$this->result = mysqli_query($this->link,$consulta);
		if(self::$showErrors)
		{
			if(mysql_errno($this->link)!=0)
				echo "Error ".mysql_errno($this->link)." : ".mysql_error($this->link);
		}
		$fila= mysql_num_rows($this->result);
		$i=0;
		while ($row = mysqli_fetch_object($this->result))
		{
			$res[$i]=$row;
			$i++;
		}
		mysql_free_result($this->result);
		return $res;
	}
 
   /*Método para obtener una fila de resultados de la sentencia sql*/ 
   public function obtener_fila($stmt,$fila)
   { 
      if ($fila==0)
	  { 
         $this->array=mysqli_fetch_array($stmt); 
      }
	  else
	  { 
         mysql_data_seek($stmt,$fila); 
         $this->array=mysqli_fetch_array($stmt); 
      } 
      return $this->array; 
   } 
   /**;
	 * realiza consultas como:UPDATE,INSERT AND DELETE
	 * retorna true si la consulta se ejecuto correctamente caso contrario false
	 *
	 * @param string $consulta
	 * @return boolean
	 */
	public function dbABM($consulta)
	{
		$r=false;
		$this->result = mysqli_query($consulta);
		if(self::$showErrors)
		{
			if(mysql_errno($this->link)!=0)
			echo "Error ".mysql_errno($this->link)." : ".mysql_error($this->link);
		}
		//mysql_free_result($this->result);
		if ($this->result) 
		{
			$r=true;
		}
		//Devuelve false en caso de error
		return $r;
	}	 
 
   //Devuelve el último id del insert introducido 
   public function lastID(){ 
      return mysql_insert_id($this->link); 
   } 
   
    /**
	 * Inicia la transaccion, retorna true si la transaccion se Inicia correctamente caso contrario false
	 *
	 * @return Boolean
	 */
	public function dbBeginTransaction(){
		 $this->result = mysqli_query("BEGIN");
		 if ($this->result) 
		 {
			return true;
		 }
		 else 
		    return false;
	}
	/**
	 * Cancela la transaccion, retorna true si la transaccion es cancelada correctamente caso contrario false
	 *
	 * @return Boolean
	 */
    public function dbCancelTransaction()
	{
 		$this->result = mysqli_query("ROLLBACK");	
		if ($this->result) 
		{
			return true;//$r=true;
			//echo "Transaccion Cancelada";
		 }
		 else 
		    return false; 
	}
	/**
	 * Termina la transaccion, retorna true si la transaccion termina correctamente caso contrario false
	 *
	 * @return Boolean
	 */
	public function dbEndTransaction()
	{
		$this->result = mysqli_query("COMMIT");
		if ($this->result) 
		{
		 	return true;
			//echo "Transaccion Terminada";
		} 
		else
		    return false;
	}
	public function dbClose()
	{
		mysqli_close($this->link);	
	}
 
}
?>