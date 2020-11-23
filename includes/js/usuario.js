
function cargarNotificacionesUsuario(id){
	let divNotificaciones = document.getElementById("notificaciones_usuario"); 
	let classNotificaciones = divNotificaciones.className; 
	
	if(classNotificaciones.includes("disabled") == true && $("#notificaciones_usuario").is(':hidden')){
		$.post("includes/peticionesAjaxYRedirecciones/buscarDatosUsuario.php", {
			idUsuario:id, operation: 2
		}, function(mensaje){
			if(mensaje != "-1ERROR"){
			$("#notificaciones_usuario").show(); 
			$("#notificaciones_usuario").html(mensaje); 
			$("#notificaciones_usuario_button").html("Hacer click para ocultar "); 
			}
			else{
				handleError("ERROR al cargar las notificaciones del usuario, la pagina no funciona correctamente en este momento"); 
			}
		});
	}
	else{
		$("#notificaciones_usuario").hide(); 
		$("#notificaciones_usuario_button").html("Hacer click para desplegar "); 
	}
	
}

function handleError(texto){
	alert(texto); 
}

function mostrarNotificacionCompleta(idCuerpo){
	let asuntoId = "asunto_wrapper"+ idCuerpo; 
	let asunto = document.getElementById(asuntoId); 
	idCuerpo = "cuerpo" + idCuerpo; 
	let cuerpo = document.getElementById(idCuerpo); 
	let clase = cuerpo.className; 
	let idCuerpoJQ = "#" + idCuerpo; 
	
	if(clase.includes("disabled") == true || $(idCuerpoJQ).is(':hidden')){
		$(idCuerpoJQ).show(); 
		cuerpo.className = cuerpo.className.replace("disabled", ""); 
		
		if(asunto.className.includes("first") == true){
			asunto.className = asunto.className.replace("first", ""); 
		}
	}
	else{
		$(idCuerpoJQ).hide(); 
		if(asunto.className.includes("first") == false){
			asunto.className = asunto.className + " first";  
		}
	}
}

function borrarNotificacion(id){
	
	$.post("includes/peticionesAjaxYRedirecciones/buscarDatosUsuario.php", {
		idNotificacion: id, operation: 3
	}, function(mensaje){
		if(mensaje == "00000SUCCESS"){
			let idNotificacion = "#notificacion" + id; 
			$(idNotificacion).hide(); 
		}
		else{
			handleError("ERROR al borrar la notificacion, la aplicacion no esta funcionando correctamente en este momento. "); 
		}
	});
	
}

function popUpPartido(idP, idT){
	let popUp = document.getElementById("popUp"); 
	let popClass = popUp.className; 
	
	if(popClass.includes("disabled", "") || $("#popUp").is(':hidden')){
		$.post("includes/peticionesAjaxYRedirecciones/obtenerDatosTorneo.php", {
			idTorneo: idT, idPartido: idP, operation: 5
		}, function(mensaje){
			if(mensaje == 3347){
				alert("ERROR: Estamos teniendo problemas para cargar el partido, vuelve a intentarlo mas tarde. "); 
			}
			if(mensaje == "-1ERROR"){
				handleError("ERROR al cargar el partido, la aplicacion no funciona correctamente en este momento. "); 
			}
			else{
				$("#popUp").html(mensaje); 
				$("#popUp").show(); 
				let provincias = document.getElementsByClassName("provincia_partido"); 
				let ciudades = document.getElementsByClassName("localidad_partido"); 
				let i = 0; 
				if(provincias.length != ciudades.length){
					alert("ERROR: En este momento la pagina no esta funcionando correctamente. "); 
				}
				for(i = 0; i < provincias.length; i++){
					mostrarUbicacion(provincias[i], ciudades[i]); 
				}
			}
		});
	}
}

// CLASE 
// esta en forms.js al final


