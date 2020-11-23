<?php
require_once("includes/forms/loginForm.php");
require_once("includes/configuration/Definitions.php");
require_once("includes/forms/UserEntrySecurity.php");
require_once("includes/control/Errores.php");
require_once("includes/model/DAOs/DAOPartidosTorneos.php"); 
require_once("includes/model/DAOs/PartidosTorneos.php");
require_once("includes/forms/editarResultadosTorneoForm.php");


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
</head>

<body>
	<?php 
	/* Fija la seccion de la pagina en la que nos encontramos */
	   require("includes/common/cabecera.php");
	?>
		<div class = "external_wrapper"> 
		<h1 class = "titulo_form"> Formulario de edicion de resultados de torneo en Padel2u </h1>
		
		<div class = "form_wrapper"> 
		
		<?php 
		  $tipoUsuario = SessionControl::tipoUsuarioLogeado(); 
		  $id = UserEntrySecurity::asegurarEntradaUsuario($_GET['id']); 
		  $partido = DAOPartidosTorneos::selectById($id);
		  $ok = false; 
		 
		  // Un usuario solo puede editar los resultados de un torneo si es arbitro, el partido existe, el torneo está cerrado, el partido no contiene resutlados y el partido dos parejas jugadoras. 
		  if($tipoUsuario == USUARIO_ARBITRO && $partido != NULL){
		      $torneo = DAOTorneo::selectById($partido->getTorneoAsociado()); 
		      if($torneo->getCerrado() == true && $partido->getResultados() == NULL && $partido->getPareja1() != NULL && $partido->getPareja2() != NULL){
		      SessionControl::setIdRecurso($id); 
		      $opciones = array(); 
		      $opciones[] = "validarFormularioEditarResultadoTorneo(this);";
		      $opciones[] = "?id=".$id; 
		      $form = new EditarResultadoTorneoForm("editarResultadoTorneoForm", $opciones); 
		      $form->gestiona(); 
		      $ok = true; 
		      }
		  }
		  if($ok == false){
		      $opciones = array();
		      $enlace = '<a href = "torneosView.php" class = "boton azul medio"> Volver al catalogo de Torneos. </a>';
		      $error = "Vaya, parece que no puedes editar los resultados de este partido";
		      $opciones[] = "1. El torneo no exista actualmente en Padel2u. ";
		      $opciones[] = "2. Para editar los resultados de un torneo debes ser arbitro. ";
		      $opciones[] = "3. El torneo debe estar cerrado. ";

		      echo Errores::generarPantallaInaccesible($error,$opciones, $enlace); 
		  }
		
		
		
		
		?>
		
		</div>
	</div>
</body>
</html>