<?php
require_once("includes/forms/loginForm.php");
require_once("includes/configuration/Definitions.php");
require_once("includes/forms/UserEntrySecurity.php");
require_once("includes/control/Errores.php");
require_once("includes/model/DAOs/DAOPartidosTorneos.php"); 
require_once("includes/model/DAOs/PartidosTorneos.php");
require_once("includes/forms/editarResultadosTorneoForm.php");
require_once("includes/model/DAOs/DAOTorneo.php"); 
require_once("includes/model/DAOs/Torneo.php");
require_once("includes/control/TorneosControl.php");
require_once("includes/forms/editarTorneoForm.php"); 


?>

<!DOCTYPE html>
<html lang = "es">
<head>
	<title> Padel2u: Editar resultados de torneo</title>
	<meta charset = "UTF-8">
	<link rel = "stylesheet" type = "text/css" href = "estilos/general.css">
	<link rel = "stylesheet" type = "text/css" href = "estilos/form.css">
	<script src = "includes/resources/jquery.js"></script>
	<script src = "includes/js/forms.js"></script>
	<script src = "includes/js/vista.js"></script>
	<!--  PROVINCIAS Y POBLACIONES SCRIPT DE INCLUSION -->
	<script src = "includes/js/provinciasypoblaciones.js"></script>
</head>

<body>
	<?php 
	/* Fija la seccion de la pagina en la que nos encontramos */
	   require("includes/common/cabecera.php");
	?>
		<div class = "external_wrapper"> 
		<h1 class = "titulo_form"> Formulario de edicion de torneos en Padel2u </h1>
		<div class = "form_wrapper"> 
		
		<?php 
		  $tipoUsuario = SessionControl::tipoUsuarioLogeado(); 
		  $ok = false; 
		  $idTorneo = UserEntrySecurity::asegurarEntradaUsuario($_GET['id']); 
		  $torneo = DAOTorneo::selectById($idTorneo); 
		  $idSesion = SessionControl::getIdSesion(); 
		  if($idTorneo != NULL && $idSesion != NULL){
		      if(($comrprobaciones = TorneosControl::comprobarApuntarseTorneo($idTorneo, $idSesion)) == ARBITRO_EDITAR_TORNEO){
		          SessionControl::setIdRecurso($idTorneo); 
		          $opciones = array(); 
		          $opciones[] = "validarEditarTorneo(this);";
		          $opciones[] = "?id=".$idTorneo; 
		          $form = new EditarTorneoForm("editarTorneoForm", $opciones); 
		          $form->gestiona(); 
		          $ok = true; 
		      }
		      
		  }
		  if($ok == false){
		      $opciones = array();
		      $enlace = '<a href = "torneosView.php" class = "boton azul medio"> Volver al catalogo de Torneos. </a>';
		      $error = "Vaya, parece que no puedes editar este torneo, esto puede deberse a: ";
		      $opciones[] = "1. El torneo no exista actualmente en Padel2u. ";
		      $opciones[] = "2. Para editar un torneo debes ser arbitro. ";
		      $opciones[] = "3. El torneo no puede estar cerrado. ";
		      
		      echo Errores::generarPantallaInaccesible($error,$opciones, $enlace); 
		  }
		 
		?>
		
		</div>
	</div>
	<script>
			var prov = document.getElementById('ps-prov');
			var mun = document.getElementById('ps-mun');
		// Create PS
		Pselect().create(prov, mun);


	</script>
</body>
</html>