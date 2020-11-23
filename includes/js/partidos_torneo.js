function datosPartidosTorneo(id){
	
	/* operaciones: 
	 * 1. Datos de ubicacion. 
	 */
	
	let divPartidos = document.getElementById("resultados_torneo"); 
	let partidosClass = divPartidos.className; 
	if(partidosClass.includes("disabled") == true || $("#resultados_torneo").is(':hidden')){
		$.post("includes/peticionesAjaxYRedirecciones/obtenerDatosTorneo.php", {
			operation: 2, idTorneo: id
		}, function(mensaje) {
			
			$("#resultados_torneo").html(mensaje);
			$("#partidos_torneo_button").html("Hacer click para ocultar "); 
			$("#resultados_torneo").show(); 
			let provincias = document.getElementsByClassName("provincia"); 
			let ciudades = document.getElementsByClassName("ciudad"); 
			let i = 0; 
			if(provincias.length != ciudades.length){
				alert("ERROR: En este momento la pagina no esta funcionando correctamente. "); 
			}
			for(i = 0; i < provincias.length; i++){
				mostrarUbicacion(provincias[i], ciudades[i]); 
			}
			$("#ocultar_partidos_torneo_button").show(); 
		});
		divPartidos.className = divPartidos.className.replace("disabled", ""); 
		
		
	}
	else if($("#resultados_torneo").is(':visible')){
		$("#ocultar_partidos_torneo_button").hide(); 
		$("#partidos_torneo_button").html("Hacer click para desplegar ");
		$("#resultados_torneo").hide(); 
	}
};

