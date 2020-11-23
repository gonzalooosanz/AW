<?php 
    require_once("includes/control/SessionControl.php"); 
    require_once("includes/model/DAOs/DAOUsuario.php"); 
    require_once("includes/model/DAOs/Usuario.php"); 
     require_once("includes/model/DAOs/DAONotificaciones.php"); 
    require_once("includes/configuration/Definitions.php"); 
    require_once("includes/forms/UserEntrySecurity.php"); 
    require_once("includes/control/Errores.php"); 

?>

<!DOCTYPE html>
<html lang = "es">
<head>
	<title> Padel2u: Perfil de Jugador </title>
	<meta charset = "UTF-8">
	<link rel = "stylesheet" type = "text/css" href = "estilos/general.css">
	<link rel = "stylesheet" type = "text/css" href = "estilos/perfil.css">
	<link rel = "stylesheet" type = "text/css" href = "fonts/style.css">
	<script src = "includes/resources/jquery.js"></script>
	<script src = "includes/js/usuario.js"></script>
	<script src = "includes/js/vista.js"></script>
	<script src = "includes/js/provinciasypoblaciones.js"></script>
</head>

<body>

	<?php 
	SessionControl::setSeccion(SECCION_JUGADOR); 
	require("includes/common/cabecera.php"); 
	
	echo SessionControl::getFeedbackEntrante(); 
	if(isset($_GET['idJugador']) && $_GET['idJugador'] != NULL){
	    
	    $idJugador = UserEntrySecurity::asegurarEntradaUsuario($_GET['idJugador']); 
	    $jugador = DAOUsuario::selectById($idJugador); 
	    if($jugador != NULL){
	        
	        ?> 
	        <!--  ------------------- MUESTRA EL PERFIL DE JUGADOR  ----------------------------------------- -->
	        <div class = "main"> 
	        	
	        	<!--  ----------------- 1. INFORMACION PRINCIPAL DEL JUGADOR  -----------------------------------  -->
	        	<div class = "account_info_wrapper"> 
	        		<div class = "photo_wrapper"> 
	        			<?php 
	        			if($jugador->getPerfil() != NULL){
	        			    echo '<img src = "'.$jugador->getPerfil().'" alt = "Imagen de perfil de'.$jugador->getNombre().'">';
	        			}
	        			else{
	        			    echo '<img src = "img/user_icon.png" alt = "Imagen de perfil de'.$jugador->getNombre().'">';
	        			}
	        			?>
	        		</div>
	        		
	        		<div class = "info_wrapper"> 
	        			<?php 
					               echo '<h3>Nombre: '.$jugador->getNombre().'</h3>';
					               echo '<h3>Primer Apellido: '.$jugador->getApellido1().'</h3>';
					               echo '<h3>Segundo Apellido: '.$jugador->getApellido2().'</h3>';
					               echo '<h3> Efectividad: '.$jugador->getEfectividad().'</h3>'; 
				              ?>
	        		</div>
	        	</div>
	        	´
	        	<!-- ------------------------------ SUBSECCIONES DEL PERFIL DE JUGADOR -----------------------------  -->
	        	<!--  ------------------------- 2. ESTADISTICAS DEL JUGADOR ---------------------------------  -->
	        	<?php 
			          echo '<div class = "separator continuacion" onclick = "datosYEstadisticasUsuario('.$jugador->getIdUsuario().', estadisticas)">'; 
			?>
						<h3> Informacion personal y mis estadisticas </h3>
						<h4 id = "estadisticas_usuario_button"> Hacer click para desplegar </h4>
						<?php echo '</div>'; ?>
						<div class = "estadisticas_usuario_wrapper disabled" id = "estadisticas_usuario">
						</div> <!--  Fin de estadisticas del jugador  -->
						
				<!--  ------------------------------- 3. PAREJAS DEL JUGADOR (PASADAS Y ACTUALES) ------------------------  -->
				<?php 
			          echo '<div class = "separator continuacion" onclick = "parejasUsuario('.$jugador->getIdUsuario().')">';
			    ?>
					<h3> Parejas de este jugador (pasadas y actuales) </h3>
					<h4 id = "parejas_usuario_button"> Hacer click para desplegar </h4>
					<?php echo '</div>'; ?>
					<div class = "parejas_usuario_wrapper disabled" id = "parejas_usuario"> 
					</div> <!--  Fin de parejas del jugador  -->
					
				<!--  -------------------------------- 4. TORNEOS EN LOS QUE ESTA APUNTADO EL JUGADOR ------------------------------------  -->
				<?php  
				    echo '<div class = "separator continuacion" onclick = "torneosUsuario('.$jugador->getIdUsuario().')">'; 
				?>
				<h3> Torneos a los que se ha apuntado este jugador  </h3>
			    <h4 id = "torneos_usuario_button"> Hacer click para desplegar </h4>
				<?php echo '</div>'; ?>
				<div class = "torneos_usuario_wrapper disabled" id = "torneos_usuario"> 
				</div> <!--  Fin de torneos en los que esta apuntado el jugador  -->
				
				<!--  --------------------------------- 5. PARTIDOS AMISTOSOS EN LOS QUE ESTA APUNTADO EL JUGADOR ------------------------  -->
				<?php 
				    echo '<div class = "separator continuacion" onclick = "partidosAmistososUsuario('.$jugador->getIdUsuario().')">'; 
				?>
				<h3> Partidos amistosos a los que se ha apuntado este jugador  </h3>
			    <h4 id = "partidos_amistosos_usuario_button"> Hacer click para desplegar </h4>
				<?php echo '</div>'; ?>
               	<div class = "partidos_amistosos_usuario_wrapper disabled" id = "partidos_amistosos_usuario"> 	
               </div> <!--  Fin de partidos amistosos en los que esta apuntado el jugador   -->  
	        </div>
	        <?php 
	        require("includes/common/pie.php"); 
	    
	    } // fin if($jugador != NULL) 
	else{
	    $opciones = array();
	    $enlace = '<a href = "jugadoresView.php" class = "boton azul medio"> Volver al ranking de jugadores. </a>';
	    $error = "Vaya, parece que este usuario no existe";
	    $opciones[] = "1. Este jugador se haya dado de baja en Padel2U o no sea un jugador existente en nuestra aplicacion. ";
	    $opciones[] = "2. Estemos teniendo actualmente algun problema en las Bases de Datos de la aplicación. Por favor, vuelva a intentarlo más tarde. ";
	    
	    echo Errores::generarPantallaInaccesible($error,$opciones, $enlace);
	}
	
	} // fin if (isset($_GET['idJugador']....)
	

else{
    $opciones = array();
    $enlace = '<a href = "jugadoresView.php" class = "boton azul medio"> Volver al ranking de jugadores. </a>';
    $error = "Vaya, parece que este usuario no existe";
    $opciones[] = "1. Este jugador se haya dado de baja en Padel2U o no sea un jugador existente en nuestra aplicacion. ";
    $opciones[] = "2. Estemos teniendo actualmente algun problema en las Bases de Datos de la aplicación. Por favor, vuelva a intentarlo más tarde. ";
    
    echo Errores::generarPantallaInaccesible($error,$opciones, $enlace);
    
    
}
?>
</body> 
</html> 
	    
	
	