
function gestionarSpinner(spinner){
	
	if(spinner.className.indexOf("disabled") != -1){ // el spinner esta desactivado.
		spinner.className = spinner.className.replace("disabled", "enabled");
	}
	else if(spinner.className.indexOf("enabled") != -1){ // el spinner esta activado. 
		spinner.className = spinner.className.replace("enabled", "disabled"); 
	}
	
}

/* Buscador de pareja de torneo */

function buscarParejaTorneo() {
	var textoBusqueda = $("#busquedaParejaTorneo").val();
	if (textoBusqueda != "") {
		$.post("includes/peticionesAjaxYRedirecciones/buscarParejaTorneo.php", {
			parejaTorneo : textoBusqueda
		}, function(mensaje) {
			$("#resultadoBusqueda").html(mensaje);
		});
	} else {
		$("#resultadoBusqueda")
				.html(
						'<p> No hemos encontrado ningun jugador/a con este nombre y apellidos</p>');
	}
	;
};

function popupUsuario(id) {
	let popup = document.getElementById("info_wrapper");
	if (popup.className.indexOf("disabled") != -1) {
		popup.className = popup.className.replace("disabled", "enabled");
	} else {
		popup.className = popup.className + " enabled";
	}
	if (id != "") {
		$.post("includes/peticionesAjaxYRedirecciones/buscarDatosUsuario.php", {
			idUsuario : id, operation: 1
		}, function(mensaje) {
			$("#info_wrapper").html(mensaje);
		});
	} else {
		$("#info_wrapper")
				.html(
						'<p> Error en la aplicación: Esta funcionalidad no funciona correctamente en este moemento. </p>');

	}
	;
};

function cerrarPopUp() {
	let popup = document.getElementById("info_wrapper");
	popup.className = popup.className.replace("enabled", "disabled");
}

function comprobarFormularioApuntarmeTorneo(){
	let check = document.getElementById("terminos_si");  
	if(check.checked == true){
		$("#terminos_error").hide(); 
	
		if(!document.querySelector('input[name="pareja_seleccionada"]:checked')) {
			$("#error_seleccionar_pareja").show(); 
		      }
		
		else{
			$("#error_seleccionar_pareja").hide();
			return true;
		}
	}
	else{
		$("#terminos_error").show(); 
		if(document.querySelector('input[name="pareja_seleccionada"]:checked')){
			$("#error_seleccionar_pareja").hide();
		}
		check.focus();
	}
	
	return false; 
}

function confirmarSolicitudPareja(){
	let rellenado = false;
	rellenado = comprobarFormularioApuntarmeTorneo();
	if(rellenado == true){
	let popup = document.getElementById("confirm_wrapper");
	if (popup.className.indexOf("disabled") != -1) {
		popup.className = popup.className.replace("disabled", "enabled");
	} else {
		popup.className = popup.className + " enabled";
	}
	
	html =  '<p> ¿ Estás seguro de que deseas apuntarte al torneo?, si lo haces se'; 
	html += ' enviará una solicitud para formar pareja contigo al jugador/a que has elegido '; 
	html += 'para formar pareja. </p>';
	html += '<label class = "label_error" id = "confirm_error"> Vaya!! Parece que te has dejado algún campo sin rellenar en el formulario anterior. </label>'; 
	html += '<div class = "buttons_wrapper">'; 
	html += '<a class = "boton rojo medio" onclick = "cerrarConfirm();"> Cancelar </a>';
	html += '<div class = "boton_cargando pequeño verde">';
    html += '<div class = "spinner disabled" id = "spinner_apuntarme_torneo"></div>'; 
    html += '<input type = "submit" value = "Apuntarme al torneo">';
    html += '</div>'; 
	html += '</div>';
	$("#confirm_wrapper").html(html);
	}
}

function validarFormularioApuntarmeTorneo(formulario){
	let okForm = false; 
	/* Spinner de carga */ 
	let spinner = document.getElementById("spinner_apuntarme_torneo"); 
	gestionarSpinner(spinner); 
	
	okForm = comprobarFormularioApuntarmeTorneo(); 
	if(okForm == true){
		return true; 
	}
	else{
		gestionarSpinner(spinner);
		$("#confirm_error").show(); 
		return false; 
	}
}

function cerrarConfirm(){
	let confirm = document.getElementById("confirm_wrapper"); 
	confirm.className = confirm.className.replace("enabled", "disabled");
}




/* ----------------------- EDITAR RESULTADOS DE UN TORNEO ----------------- */ 

function comprobarFormularioEditarResultadoTorneo(formulario){
	let ok = true; 
	if((solo_numeros(formulario.puntuacion1.value) == false) || (formulario.puntuacion1.value.length == 0) || formulario.puntuacion1.value < 0){
		$("#error_puntuacion1").show(); 
		ok = false; 
	}
	else{
		$("#error_puntuacion1").hide(); 
	}
	if(formulario.puntuacion2.value.length == 0 || (solo_numeros(formulario.puntuacion2.value)) == false || formulario.puntuacion2.value < 0){
		$("#error_puntuacion2").show(); 
		ok = false; 
	}
	else{
		$("#error_puntuacion2").hide(); 
		
	}
	
	return ok; 
}

function validarFormularioEditarResultadoTorneo(formulario){
	let okForm = false; 
	
	okForm = comprobarFormularioEditarResultadoTorneo(formulario); 
	if(okForm == true){
		return true; 
	}
	else{
		return false; 
	}
}


/* ----------------- EDITAR TORNEO --------------------------- */ 

var okEditarTorneo = false; 

function comprobarFormularioEditarTorneo(formulario){
	let ok = false; 
	let hoy = new Date();  
	
	let errorLong = false; 
	if(formulario.nombre.value.length > 40){
		$("#nombre_error").show();
		errorLong = true; 
	}
	else if(formulario.nombre.value.length > 0){
		ok = true; 
		$("#nombre_error").hide();
	}
	
	if(formulario.provincia.value.length > 30){
		$("#provincia_error").show();
		errorLong = true; 
	}
	else if(formulario.provincia.value.length > 0 && formulario.provincia.value != -1){
		ok = true; 
		$("#provincia_error").hide();
	}
	
	if(formulario.localidad.value.length > 30){
		$("#localidad_error").show();
		errorLong = true; 
	}
	else if(formulario.localidad.value.length > 0 && formulario.localidad.value != -1){
		ok = true; 
		$("#localidad_error").hide();
	}
	
	if(formulario.direccion.value.length > 30){
		$("#direccion_error").show();
		errorLong = true; 
	}
	else if(formulario.direccion.value.length > 0){
		ok = true;
		$("#direccion_error").hide();
	}
	
	if(formulario.fecha_inicio.value != ""){
		
		let fecha = formulario.fecha_inicio.value; 
		let array_fecha = fecha.split("-"); 
		
		let ano = array_fecha[0]; 
		let mes = (array_fecha[1] - 1); 
		let dia = (array_fecha[2]); 
		let hora = "23"; 
		let min = "59"; 
		let fechaDate = new Date(ano, mes,dia, hora, min); 
		if(fechaDate < hoy){
			$("#fecha_inicio_error").show(); 
		}
		else{
			ok = true;
		}
	}
	if(formulario.fecha_fin.value != ""){
		let fecha = formulario.fecha_fin.value; 
		let array_fecha = fecha.split("-"); 
		
		let ano = array_fecha[0]; 
		let mes = (array_fecha[1] - 1); 
		let dia = (array_fecha[2]); 
		let hora = "23"; 
		let min = "59"; 
		let fechaDate = new Date(ano, mes,dia, hora, min); 
		if(fechaDate < hoy){
			$("#fecha_fin_error").show(); 
		}
		else{
			ok = true;
		}
	}
	
	if(formulario.fecha_inscripcion.value != ""){
		let fecha = formulario.fecha_inscripcion.value; 
		let array_fecha = fecha.split("-"); 
		
		let ano = array_fecha[0]; 
		let mes = (array_fecha[1] - 1); 
		let dia = (array_fecha[2]); 
		let hora = "23"; 
		let min = "59"; 
		let fechaDate = new Date(ano, mes,dia, hora, min); 
		if(fechaDate < hoy){
			$("#fecha_inscripcion_error").show(); 
		}
		else{
			ok = true;
		}
		
	}
	
	if(ok == false && errorLong == false){
		$("#campos_vacios").show(); 
	}
	if(errorLong == true){
		ok = false; 
	}
	return ok; 
	
}




function validarEditarTorneo(formulario){
let okForm = false; 
	
	okForm = comprobarFormularioEditarTorneo(formulario); 
	if(okForm == true){
		return true; 
	}
	else{
		return false; 
	}
}





/* -------------------------- REGISTRO --------------------------- */ 

// JORGE
function comprobarFormularioRegistro(formulario){
	let ok = true;
	if(formulario.email.value.length == 0 || formulario.email.value.length > 30){
		$("#email_error").show();
		ok = false;
	}
	else{
		$("#email_error").hide();
	}

	if(formulario.email2.value.length == 0 || formulario.email2.value.length > 30){
		$("#email_error_2").show();
		ok = false;
	}
	else{
		$("#email_error_2").hide();
	}
	if(formulario.email.value != formulario.email2.value){
		$("#email_iguales_error").show(); 
		ok = false; 
	}
	else{
		$("#email_iguales_error").hide(); 
	}
	if(formulario.password.value.length == 0 || formulario.password.value.length > 256){
		$("#pass_error").show();
		ok = false;
	}
	else{
		$("#pass_error").hide();
	}
	
	if(formulario.password_val.value.length == 0 || formulario.password_val.value.length > 256){
		$("#pass_error_2").show();
		ok = false;
	}
	else{
		$("#pass_error_2").hide();
	}
	
	if(formulario.password.value != formulario.password_val.value){
		$("#password_iguales_error").show(); 
		ok = false; 
	}
	else{
		$("#password_iguales_error").hide(); 
	}
	if(formulario.nombre.value.length == 0 || formulario.nombre.value.length > 20){
		$("#nombre_error").show();
		ok = false;
	}
	else{
		$("#nombre_error").hide();
	}
	if(formulario.apellido1.value.length == 0 || formulario.apellido1.value.length > 25){
		$("#apellido1_error").show();
		ok = false;
	}
	else{
		$("#apellido1_error").hide();
	}
	if(formulario.apellido2.value.length == 0 || formulario.apellido2.value.length > 25){
		$("#apellido2_error").show();
		ok = false;
	}
	else{
		$("#apellido2_error").hide();
	}
	if((solo_numeros(formulario.provincia.value) == false) || formulario.provincia.value.length > 30){
		$("#provincia_error").show();
		ok = false;
	}
	else{
		$("#provincia_error").hide();
	}
	if((solo_numeros(formulario.localidad.value) == false) || formulario.localidad.value.length > 30){
		$("#localidad_error").show();
		ok = false;
	}
	else{
		$("#localidad_error").hide();
	}
	if(formulario.terms.checked == false){
		$("#error_terminos").show(); 
		ok = false; 
	}
	else{
		$("#error_terminos").hide(); 
	}
	return ok; 
}

function validarFormularioRegistro(formulario){
	let spinner = document.getElementById("spinner_registro"); 
	gestionarSpinner(spinner); 
	let okValidacion = comprobarFormularioRegistro(formulario);  
	
	if(okValidacion == true){
		return true; 
	}
	else{
		gestionarSpinner(spinner); 
		return false; 
	}
	
	
}

function solo_numeros(texto){
	for(var i = 0; i < texto.length; i++){
		if(isNaN(texto[i]) == true){
			return false;
		}
	}
	return true;
}

/* -------------------------- EDITAR PERFIL ---------------------- */
function comprobarFormularioEditarPerfil(formulario){
	let ok = false;
	let errorLong = false; 
	if(formulario.email.value.length > 30){
		$("#email_error").show();
		errorLong = true; 
	}
	else if(formulario.email.value.length > 0){
		ok = true; 
		$("#email_error").hide();
	}

	if(formulario.email2.value.length > 30){
		$("#email_error_2").show();
		errorLong = true; 
	}
	else if(formulario.email.value.length > 0){
		ok = true;
		$("#email_error_2").hide();
	}
	if(formulario.password.value.length > 256){
		$("#pass_error").show();
		errorLong = true;  
	}
	else if(formulario.password.value.length > 0){
		ok = true; 
		$("#pass_error").hide();
	}
	
	if(formulario.password_val.value.length > 256){
		$("#pass_error_2").show();
		errorLong = true; 
	}
	else if(formulario.password_val.value.length > 0){
		ok = true; 
		$("#pass_error_2").hide();
	}
	
	if(formulario.nombre.value.length > 20){
		$("#nombre_error").show();
		errorLong = true; 
	}
	else if(formulario.nombre.value.length > 0){
		ok = true; 
		$("#nombre_error").hide();
	}
	if(formulario.apellido1.value.length > 25){
		$("#apellido1_error").show();
		errorLong = true; 
	}
	else if(formulario.apellido1.value.length > 0){
		ok = true; 
		$("#apellido1_error").hide();
	}
	if(formulario.apellido2.value.length > 25){
		$("#apellido2_error").show();
		errorLong = true; 
	}
	else if(formulario.apellido2.value.length > 0){
		ok = true; 
		$("#apellido2_error").hide();
	}
	if(formulario.perfil.value.length > 400){
		$("#perfil_error").show(); 
		errorLong = true; 
	}
	else if(formulario.perfil.value.length > 0){
		ok = true; 
		$("#perfil_error").hide(); 
	}
	
	if(formulario.provincia.value.length > 30){
		$("#provincia_error").show();
		errorLong = true; 
	}
	else if(formulario.provincia.value.length > 0 && formulario.provincia.value != -1){
		ok = true; 
		$("#provincia_error").hide();
	}
	
	if(formulario.localidad.value.length > 30){
		$("#localidad_error").show();
		errorLong = true; 
	}
	else if(formulario.localidad.value.length > 0 && formulario.localidad.value != -1){
		ok = true; 
		$("#localidad_error").hide();
	}
	if(ok == false && errorLong == false){
		$("#campos_vacios").show(); 
	}
	if(errorLong == true){
		ok = false; 
	}
	return ok; 
}

 function validarFormularioEditarPerfil(formulario){
	let spinner = document.getElementById("spinner_editarperfil"); 
	gestionarSpinner(spinner); 
	let okValidacion = comprobarFormularioEditarPerfil(formulario); 
	if(okValidacion == true){
		return true; 
	}
	else{
		gestionarSpinner(spinner); 
		return false; 
	}
 }

/* -------------------------- INICIAR SESION ---------------------- */ 

// JORGE
function comprobarFormularioLogin(formulario){
	let ok = true; 
	if(formulario.email.value.length == 0 || formulario.email.value.length > 30){
		$("#email_error").show(); 
		ok = false; 
	}
	else{
		$("#email_error").hide(); 
	}
	if(formulario.pass.value.length == 0 || formulario.pass.value.length > 256){
		$("#pass_error").show(); 
		ok = false; 
	}
	else{
		$("#pass_error").hide(); 
	}
	return ok; 
}


function validarFormularioLogin(formulario){
	let spinner = document.getElementById("spinner_login"); 
	gestionarSpinner(spinner); 
	let okValidacion = comprobarFormularioLogin(formulario); 
	if(okValidacion == true && usuarioCorrecto == true && passCorrecto == true){
		return true; 
	}
	else{
		gestionarSpinner(spinner); 
		return false; 
	}
	
	
	
	
}

/* -------------------------- CREAR TORNEO ----------------------- */ 

// JORGE
function comprobarFormularioCrearTorneo(formulario){
	let ok = true;
	let hoy = new Date();  
	if(formulario.nombre.value.length == 0 || formulario.nombre.value.length > 40){
		$("#nombre_error").show();
		ok = false;
	}
	else{
		$("#nombre_error").hide(); 
	}

	if((solo_numeros(formulario.provincia.value) == false) || formulario.provincia.value.length > 30){
		$("#provincia_error").show();
		ok = false;
	}
	else{
		$("#provincia_error").hide();
	}
	if((solo_numeros(formulario.localidad.value) == false) || formulario.localidad.value.length > 30){
		$("#localidad_error").show();
		ok = false;
	}
	else{
		$("#localidad_error").hide();
	}

	if(formulario.direccion.value.length == 0 || formulario.direccion.value.length> 30){
		$("#direccion_error").show();
		ok = false;
	}
	else{
		$("#direccion_error").hide();
	}

if(formulario.fecha_inicio.value != ""){
		
		let fecha = formulario.fecha_inicio.value; 
		let array_fecha = fecha.split("-"); 
		
		let ano = array_fecha[0]; 
		let mes = (array_fecha[1] - 1); 
		let dia = (array_fecha[2]); 
		let hora = "23"; 
		let min = "59"; 
		let fechaDate = new Date(ano, mes,dia, hora, min); 
		if(fechaDate < hoy){
			$("#fecha_inicio_error").show(); 
		}
		else{
			$("#fecha_inicio_error").hide(); 
			ok = true;
		}
	}
	if(formulario.fecha_fin.value != ""){
		let fecha = formulario.fecha_fin.value; 
		let array_fecha = fecha.split("-"); 
		
		let ano = array_fecha[0]; 
		let mes = (array_fecha[1] - 1); 
		let dia = (array_fecha[2]); 
		let hora = "23"; 
		let min = "59"; 
		let fechaDate = new Date(ano, mes,dia, hora, min); 
		if(fechaDate < hoy){
			$("#fecha_fin_error").show(); 
		}
		else{
			$("#fecha_fin_error").hide(); 
			ok = true;
		}
	}
	
	if(formulario.fecha_inscripcion.value != ""){
		let fecha = formulario.fecha_inscripcion.value; 
		let array_fecha = fecha.split("-"); 
		
		let ano = array_fecha[0]; 
		let mes = (array_fecha[1] - 1); 
		let dia = (array_fecha[2]); 
		let hora = "23"; 
		let min = "59"; 
		let fechaDate = new Date(ano, mes,dia, hora, min); 
		if(fechaDate < hoy){
			$("#fecha_inscripcion_error").show(); 
		}
		else{
			$("#fecha_inscripcion_error").hide(); 
			ok = true;
		}
		
	}
	if(formulario.max_parejas.value.length == 0 || formulario.max_parejas.value.length > 3){
		$("#max_parejas_error").show();
		ok = false;
	}
	else{
		$("#max_parejas_error").hide();
	}
	if(formulario.premios.value.length <= 1 || formulario.premios.value.length > 40){
		$("#premios_error").show();
		ok = false;
	}
	else{
		$("#premios_error").hide();
	}
	if(formulario.efectividad.value.length == 0 || formulario.efectividad.value.length > 10){
		$("#efectividad_error").show();
		ok = false;
	}
	else{
		$("#efectividad_error").hide();
	}
	
	return ok; 
}


function validarFormularioCrearTorneo(formulario){
	let spinner = document.getElementById("spinner_crear_torneo"); 
	gestionarSpinner(spinner); 
	let okValidacion = comprobarFormularioCrearTorneo(formulario); 
	if(okValidacion == true){
		return true; 
	}
	else{
		gestionarSpinner(spinner); 
		return false; 
	}
	
}






var usuarioCorrecto = false; 
var passCorrecto = false; 
$(document).ready(function(){
	var emailUserGlobal = ""; 
$("#email_input").on("keyup", function(){
	$("#email_error").hide(); 
	$("#pass_error").hide(); 
	let emailUsuario = $("#email_input").val(); 
	let passUsuario = document.getElementById("pass_input"); 
	$("#pass_jq_error").hide(); 
	passUsuario.value = ""; 
	$.post("includes/peticionesAjaxYRedirecciones/buscarDatosUsuario.php", 
			{email: emailUsuario,  operation: 4 
			}, function(mensaje){
				if(mensaje != "SUCCESS"){
					$("#email_jq_error").show(); 
					usuarioCorrecto = false; 
				}
				else if(mensaje != "-1ERROR"){
					$("#email_jq_error").hide(); 
					emailUserGlobal = emailUsuario;
					usuarioCorrecto = true; 
				}
				else if(mensaje == "-1ERROR"){
					usuarioCorrecto = false; 
					handleError("Las funciones de JavaScript no estan funcionando correctamente en este momento, es posible que la pagina no responda como se espera. "); 
				}
			});	
});

$("#pass_input").on("keyup", function(){
	$("#email_error").hide(); 
	$("#pass_error").hide(); 
	let passUsuario = $("#pass_input").val(); 
	$.post("includes/peticionesAjaxYRedirecciones/buscarDatosUsuario.php", 
			{password: passUsuario, operation: 5, email: emailUserGlobal
			}, function(mensaje){
				if(mensaje != "SUCCESS"){
					$("#pass_jq_error").show(); 
					passCorrecto = false; 
				}
				else if(mensaje != "-1ERROR"){
					$("#pass_jq_error").hide(); 
					passCorrecto = true; 
				}
				else if(mensaje == "-1ERROR"){
					handleError("Las funciones de JavaScript no estan funcionando correctamente en este momento, es posible que la pagina no responda como se espera. ");
					passCorrecto = false; 
				}
				
				
			}); 
	
});
});

