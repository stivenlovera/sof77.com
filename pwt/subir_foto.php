<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload de archivos con Ajax</title>
</head>
<body>
    
    <form enctype="multipart/form-data" id="formuploadajax" method="post">
        Nombre: <input type="text" name="nombre" placeholder="Escribe tu nombre">
        <br />
        <input  type="file" id="archivo1" name="archivo1"/>
        <br />
        <input  type="file" id="archivo2" name="archivo2"/>
        <br />
        <input type="submit" value="Subir archivos"/>
    </form>
    <div id="mensaje"></div>   
    
   
    <script type="text/javascript" src="include/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="include/jquery-ui.1.10.3.js"></script>
    <script type="text/javascript" src="include/iAjax.js"></script>
    
    <script>
    $(function(){
        $("#formuploadajax").on("submit", function(e){
            e.preventDefault();
            var f = $(this);
            var formData = new FormData(document.getElementById("formuploadajax"));
            formData.append("dato", "valor");
            //formData.append(f.attr("name"), $(this)[0].files[0]);
            $.ajax({
                url: "recibir_foto.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
	     processData: false
            })
                .done(function(res){
                    $("#mensaje").html("Respuesta: " + res);
                });
        });
    });
    </script>
</body>
</html>