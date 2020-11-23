<?php
    require_once("includes/forms/editarPerfilForm.php"); 
    require_once("includes/configuration/Definitions.php"); 
    require_once("includes/forms/UserEntrySecurity.php"); 
    

?>

<!DOCTYPE html>
<html lang = "es">
<head>
	<title> Padel2u: Edición de Usuario</title>
	<meta charset = "UTF-8">
	<link rel = "stylesheet" type = "text/css" href = "estilos/general.css">
	<link rel = "stylesheet" type = "text/css" href = "estilos/form.css">
	<script src = "includes/resources/jquery.js"></script>
	<script src = "includes/js/vista.js"></script>
	<script src = "includes/js/forms.js"></script>
	<!--  PROVINCIAS Y POBLACIONES SCRIPT DE INCLUSION -->
	<script src = "includes/js/provinciasypoblaciones.js"></script>
	
	<!--  FIN PROVINCIAS Y POBLACIONES  -->
</head>

<body>
	<?php 
	/* Fija la seccion de la pagina en la que nos encontramos */
	SessionControl::setSeccion(SECCION_PERFIL); 

	   require("includes/common/cabecera.php");
	?>
	
	<div class = "external_container">
		<h1 class = "titulo_form"> Formulario de edición de perfil de usuario de Padel2u </h1>
		
		<div class = "form_wrapper"> 
		
		<?php 
		  $opciones = array(); 
		  $opciones[] = "validarFormularioEditarPerfil(this);";
		  // La opcion 2 no necesitamos pasarle nada, pero hay que ponerlo para poder acceder a la 3 a continuacion. 
		  $opciones[] = "";
		  $opciones[] = "multipart/form-data"; 
		  $editar = new editarPerfilForm("editarPerfilForm", $opciones); 
		  $editar->gestiona(); 
		?>
		
		<script>
		var prov = document.getElementById('ps-prov');
		var mun = document.getElementById('ps-mun');
		// Create PS
		Pselect().create(prov, mun);


		</script>
		
		</div>
	</div>
</body>
</html>
