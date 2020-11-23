function parejasInscritasTorneo(id){
	
	
	let divInscritos = document.getElementById("parejas_inscritas_torneo"); 
	let inscritosClass = divInscritos.className; 
	if(inscritosClass.includes("disabled") == true || $("#parejas_inscritas_torneo").is(':hidden')){
		
	$.post("includes/peticionesAjaxYRedirecciones/obtenerDatosTorneo.php", {
		operation: 4, idTorneo: id
	}, function(mensaje){
		$("#parejas_inscritas_torneo").show(); 
		$("#parejas_inscritas_torneo").html(mensaje); 
		$("#parejas_inscritas_button").html("Hacer click para ocultar "); 
		let provincias = document.getElementsByClassName("provincia_usuario"); 
		let ciudades = document.getElementsByClassName("localidad_usuario"); 
		let i = 0; 
		if(provincias.length != ciudades.length){
			alert("ERROR: En este momento la pagina no esta funcionando correctamente. "); 
		}
		for(i = 0; i < provincias.length; i++){
			mostrarUbicacion(provincias[i], ciudades[i]); 
		}
		$("#ocultar_inscritos_torneo").show(); 
	});
	
	divInscritos.className = divInscritos.className.replace("disabled", ""); 
	}
	else if($("#parejas_inscritas_torneo").is(':visible')){
		$("#ocultar_inscritos_torneo").hide(); 
		$("#parejas_inscritas_button").html("Hacer click para desplegar "); 
		$("#parejas_inscritas_torneo").hide(); 
	}
}