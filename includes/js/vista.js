function esconderFeedback(){
	let feedback = document.getElementById("feedback");
	feedback.style.display = "none"; 
}

function gestionarMenuLateral(){
	let menu = document.getElementById("menu_lateral"); 
	if(menu.style.display == "none"){
		menu.style.display = "block"; 
	}
	else{
		menu.style.display = "none"; 
	}
}

$(document).ready(function(){
	var altura = $('.main_menu').offset().top;
	
	$(window).on('scroll', function(){
		if ( $(window).scrollTop() > altura + 150 ){
			$('.main_menu').addClass('menu-fixed');
		} else {
			$('.main_menu').removeClass('menu-fixed');
		}
	});
 
});



function mostrarUbicacion(provincia, ciudad){
	let valorProvincia = provincia.innerText; 
	let valorCiudad = ciudad.innerText; 
	valorProvincia = valorProvincia.replace( / /g, "");
	valorCiudad = valorCiudad.replace( / /g, ""); 
	let pSelect = Pselect().create(); 
	valorProvincia = toNameProvincia(valorProvincia, pSelect); 
	valorCiudad = toNameCiudad(valorCiudad, pSelect); 
	provincia.innerText = " ( " + valorProvincia + " )"; 
	ciudad.innerText = valorCiudad; 
}


function resultadosTorneo(idTorneo){
	
}
