<?PHP
// Recibo los datos de la imagen
$nombre_img = $_FILES['archivo1']['name'];
$tipo = $_FILES['archivo1']['type'];
$tamano = $_FILES['archivo1']['size'];
 
 echo "llego";
//Si existe imagen y tiene un tamaño correcto
if (($nombre_img == !NULL) && ($_FILES['imagen']['size'] <= 200000)) 
{
   //indicamos los formatos que permitimos subir a nuestro servidor
   if (($_FILES["archivo1"]["type"] == "image/gif")
   || ($_FILES["archivo1"]["type"] == "image/jpeg")
   || ($_FILES["archivo1"]["type"] == "image/jpg")
   || ($_FILES["archivo1"]["type"] == "image/png"))
   {
      // Ruta donde se guardarán las imágenes que subamos
      $directorio = $_SERVER['DOCUMENT_ROOT'].'/pwt/fotos/';
	  $hoy = getdate();
	  $nombre_img="archivo1".$hoy["year"].$hoy["mon"].$hoy["mday"].$hoy["hours"].$hoy["minutes"].$hoy["seconds"].".".str_replace("image/", "", $_FILES["archivo1"]["type"]);
      // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
	  echo $directorio.$nombre_img."<br>";
      move_uploaded_file($_FILES['archivo1']['tmp_name'],$directorio.$nombre_img);
	  
	  $nombre_img="archivo2".$hoy["year"].$hoy["mon"].$hoy["mday"].$hoy["hours"].$hoy["minutes"].$hoy["seconds"].".".str_replace("image/", "", $_FILES["archivo2"]["type"]);
      move_uploaded_file($_FILES['archivo2']['tmp_name'],$directorio.$nombre_img);
	  echo $directorio.$nombre_img."<br>";
	  echo "Archivos subidos exitosamente";
    } 
    else 
    {
       //si no cumple con el formato
       echo "No se puede subir una imagen con ese formato ";
    }
} 
else 
{
   //si existe la variable pero se pasa del tamaño permitido
   if($nombre_img == !NULL) echo "La imagen es demasiado grande "; 
}

?>