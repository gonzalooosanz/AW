<?php
require_once ("includes/control/SessionControl.php");
?>

<div class="wrap_header">
	<header>
		<div id = "logo_cabecera" class="logo_wrapper">
			<a class="logo" href="index.php">
				<img src="img/logohead.png" alt="Imagen del logo de PADEL2U" />
			</a>
			
		</div>

		<nav class="main_menu" id = "menu">
			<div class="fit_menu">
			
			<div class = "main_links">
				<?php if(($seccion = SessionControl::getSeccion()) == SECCION_INDEX){
					?> 
					<a href = "index.php" class = "btn_menu selected"> Inicio </a>
				<?php }
				else{
					?>
					<a href="index.php" class = "btn_menu"> Inicio</a> 
				<?php } if(($seccion = SessionControl::getSeccion()) == SECCION_TORNEO){
					?> 
					<a href = "torneosView.php" class = "btn_menu selected"> Torneos </a>
					<?php 
				} else{
					?>
					<a href="torneosView.php" class = "btn_menu"> Torneos</a>
				<?php } if(($seccion = SessionControl::getSeccion()) == SECCION_PARTIDO){
					?> 
					<a href = "partidosView.php" class = "btn_menu selected"> Partidos </a>    
				<?php } else{
					?>
					<a href="partidosView.php" class = "btn_menu"> Partidos </a> 
				<?php } if(($seccion = SessionControl::getSeccion()) == SECCION_JUGADOR){
					?> 
					<a href = "jugadoresView.php" class = "btn_menu selected"> Jugadores </a>
				<?php } else{
					?>
					<a href="jugadoresView.php" class = "btn_menu"> Jugadores </a> 
				<?php } if(($seccion = SessionControl::getSeccion()) == SECCION_ACERCA_DE){
					?> 
					<a href = "acerca_de_view.php" class = "btn_menu selected"> ¿Quiénes somos? </a>
				<?php } else{
					?>    
					<a href="acerca_de_view.php" class = "btn_menu"> ¿Quiénes somos?</a>
				<?php }?>
			</div>

			<!--  Login/registro o Mi perfil/logout -->
			<div class = "account_wrapper">
				<?php
				if (($res = SessionControl::tipoUsuarioLogeado()) != NULL) {
					/* En el caso de entrar imprime el html correspondiente al perfil del usuario */
					?>

					<!-- Comprobacion de si el usuario esta logeado o no -->
					<?php if(($seccion = SessionControl::getSeccion()) == SECCION_PERFIL){
						?>
						<a href = "miCuentaView.php" class = "btn_menu selected"> Mi Perfil </a>
					<?php } else{
						?>
						<a href="miCuentaView.php" class = "btn_menu"> Mi Perfil </a> 
					<?php }?>
					<a href="includes/session/logout.php" class = "btn_menu"> Cerrar Sesión </a>

					<?php
				} /* Cierre del caso HTML generado si el usuario está logeado */
				else { /* Inicio del caso HTML generado si el usuario no está logeado */
					?>
					<?php  if(($seccion = SessionControl::getSeccion()) == SECCION_REGISTRO){
						?>
						<a href = "registro.php" class = "btn_menu selected"> Registro </a>
					<?php } else{
						?>
						<a href="registro.php" class = "btn_menu"> Registro </a> 
					<?php } if(($seccion = SessionControl::getSeccion()) == SECCION_LOGIN){
						?>
						<a href = "login.php" class = "btn_menu selected"> Iniciar Sesión </a>
					<?php }else{?>
						<a href="login.php" class = "btn_menu"> Iniciar
						Sesión </a>
					<?php }?>
				<?php } ?>
			</div>
			</div>
		</nav>

	</header>
</div>