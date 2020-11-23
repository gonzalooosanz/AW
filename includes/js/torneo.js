function cargarLocalizacionTorneo(id){
	$("#localizacion_button").hide(); 
	$("#localizacion_wrapper").show(); 
	$("#cerrar_localizacion_button").show(); 
	$.post("includes/peticionesAjaxYRedirecciones/obtenerDatosTorneo.php", {
		operation: 3, idTorneo: id
	}, function(mensaje) {
		$("#localizacion_wrapper").html(mensaje); 
		let ciudades = document.getElementsByClassName("ciudad_torneo"); 
		let provincias = document.getElementsByClassName("provincia_torneo"); 
		let i = 0; 
		if(provincias.length != ciudades.length){
			alert("ERROR: En este momento la pagina no esta funcionando correctamente. "); 
		}
		for(i = 0; i < provincias.length; i++){
			mostrarUbicacion(provincias[i], ciudades[i]);
		}
	});
}


function ocultarLocalizacionTorneo(){
	$("#cerrar_localizacion_button").hide(); 
	$("#localizacion_wrapper").hide(); 
	$("#localizacion_button").show(); 
}
