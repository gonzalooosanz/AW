<?php
require_once("includes/control/SessionControl.php");
require_once("includes/configuration/Definitions.php");
require_once("includes/model/DAOs/DAOTorneo.php");
require_once("includes/model/DAOs/Torneo.php");
require_once("includes/forms/UserEntrySecurity.php");
require_once("includes/forms/apuntarmeTorneoForm.php");
require_once("includes/control/TorneosControl.php"); 
require_once("includes/control/Errores.php");


?>

<!DOCTYPE html>
<html lang = "es">
<head>
	<meta charset = "UTF-8">
	<title> Padel2u: Torneos </title>
	<link rel = "stylesheet" type = "text/css" href = "estilos/general.css">
	<link rel = "stylesheet" type = "text/css" href = "fonts/style.css">
	<link rel = "stylesheet" type = "text/css" href = "estilos/form.css">
	<script src = "includes/resources/jquery.js"></script>
	<script src = "includes/js/forms.js"></script>
	<script src = "includes/js/vista.js"></script>
	
</head>

<body>
	<?php 
	/* Fija la seccion de la pagina en la que nos encontramos */
	SessionControl::setSeccion(SECCION_TORNEO); 
	   require("includes/common/cabecera.php");
	?>
		
	<?php 
	   /* Captacion de datos necesarios */ 
       /* Usado para que aparezca el mensaje de exito o error despues de cada operacion */  	  
	   echo SessionControl::getFeedbackEntrante(); 
	   /* id del usuario que ha iniciado sesion */ 
	   $idSesion = SessionControl::getIdSesion(); 
	   /* Si el usuario no ha iniciado sesion no le vamos a mostrar la opcion de apuntarse al torneo */ 
	   if(isset($_GET['id']) && $_GET['id'] != NULL){
	   /* UserEntrySecurity se usa para cualquier elemento que venga por $_GET o $_POST y es necesario para leerlos. */ 
	   $idTorneo = UserEntrySecurity::asegurarEntradaUsuario($_GET['id']);
	   $torneo = new Torneo(); 
	   /* A través del DAO obtenemos el torneo(de la BD) al que queremos apuntarnos */ 
	   $torneo = DAOTorneo::selectById($idTorneo);
	   }
	   else{ // acceso sin pasar id al torneo, se coloca un id imposible en la BD. 
	       $idTorneo = -1;
	   }
	   /* 1. Comprobacion de si el usuario puede apuntarse al torneo */ 
	   
	   /* Si devuelve COMPROBACION_CORRECTA significa que el usuario puede apuntarse al torneo */ 
	   if(($comprobaciones = TorneosControl::comprobarApuntarseTorneo($idTorneo, $idSesion)) == COMPROBACION_CORRECTA){
	       ?>
	       <div class = "external_container">
	       		<h1 class = "titulo_form"> Formulario para apuntarse a <?php echo ''.$torneo->getNombre().''?></h1>
	       <?php 
	       SessionControl::setIdRecurso($idTorneo); 
	       /* Opciones adiccionales para la clase FORM cada formulario deberá implementar las siguientes */ 
	       $opciones = array(); 
	       /* La primera opcion siempre es para indicar la funcion JavaScript que usaremos para validar el formulario */ 
	       $opciones[] = "validarFormularioApuntarmeTorneo(this);";
	       /* La segunda opcion siempre es para pasar un parametro adicional por la URL, en este caso el idTorneo para que el formulario pueda saber a que torneo nos referimos */ 
	       $opciones[] = "?id=".$idTorneo; 
	       $form = new ApuntarmeTorneoForm("apuntarmeTorneoForm", $opciones); 
	       $form->gestiona();
	       ?> </div><?php 
	   }
	   else{ // el usuario no puede apuntarse al torneo aunque este en esta pantalla.
	       $opciones = array(); 
	       $enlace = '<a href = "torneosView.php" class = "boton azul medio"> Volver al catalogo de Torneos. </a>'; 
	       $error = "Vaya, parece que no puedes apuntarte a este torneo."; 
	       $opciones[] = "1. El torneo no exista actualmente en Padel2u. ";
	       $opciones[] = "2. Para apuntarte a un torneo debes haber iniciado sesion. "; 
	       $opciones[] = "3. Necesitas tener por lo menos la efectividad requerida por el torneo."; 
	       $opciones[] = "4. El torneo no puede estar lleno. "; 
	       $opciones[] = "5. La fecha de limite de Inscripción puede haber ya pasado. "; 
	       $opciones[] = "6. Obviamente no puedes apuntarte a un torneo del cual ya eres miembro. "; 
	       echo Errores::generarPantallaInaccesible($error,$opciones, $enlace); 
	   }
	
	   
	   
	   
	   
	   
	?>
	
	
	
	
	
	
	
	
</body>
</html>