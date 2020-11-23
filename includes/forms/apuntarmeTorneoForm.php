<?php
require_once("Form.php"); 
require_once("includes/model/DAOs/DAOTorneo.php"); 
require_once("includes/model/DAOs/Torneo.php");
require_once("UserEntrySecurity.php");
require_once("includes/control/NotificacionesControl.php");
require_once("includes/control/SessionControl.php");


class ApuntarmeTorneoForm extends Form{
    
    protected function generaCamposFormulario($datosIniciales){
        $torneo = new Torneo(); 
        $torneo = DAOTorneo::selectById(UserEntrySecurity::asegurarEntradaUsuario($_GET['id'])); 
        return '
        <div class = "form_wrapper">
        <h2> Enhorabuena, ya estás cada vez más cerca de formar parte de '.$torneo->getNombre().'.</h2>

        <div class = "terminos_wrapper">
            <h3> Primer paso: Tus datos: </h3>
            <p> Para formar parte del torneo debes aceptar el tratamiento y representacion de tus datos unicamente en el ámbito del torneo. </p>
            <p> ¿Aceptas? </p>
            <div class = "input-group radio">
                <input type = "radio" name = "terminos" value = "No" id = "terminos_no">
                <label for = "terminos_no"> No acepto </label>
                <input type = "radio" name = "terminos" value = "Si" id = "terminos_si">
                <label for = "terminos_si"> Acepto </label>
        </div>
        <label class = "label_error" id = "terminos_error"> Debes aceptar el tratamiento de tus datos para apuntarte al torneo. </label>
       </div>

        
        <div class = "buscador_wrapper">
           <h3> Segundo paso: Encuentra al jugador/a con el que vas a jugar en el torneo. </h3>
        	<input type = "text" name = "busqueda" id = "busquedaParejaTorneo" value = "" placeholder = "Busca aqui tu pareja"
        		maxlength = "30" onKeyUp="buscarParejaTorneo();" class = "input_ancho"> 
        </div>
        <label class = "label_error" id = "error_seleccionar_pareja"> Debes seleccionar un jugador/a para formar pareja. </label>     
        <div class = "resultados_wrapper" id = "resultadoBusqueda">
        </div>
        <div class = "popup" id = "info_wrapper">
        </div>
        <div class = "submit-group">
            <a id = "submit_apuntar_torneo" onclick = "confirmarSolicitudPareja();" class = "boton azul medio"> Apuntarme al torneo </a>
        </div>
        <div class = "popup" id = "confirm_wrapper">
        </div>
       </div>';
    }
    
    protected function procesaFormulario($datos){
        $erroresFormulario = array(); 
        $ok = false; 
        $idTorneo = UserEntrySecurity::asegurarEntradaUsuario($_GET['id']); 
        $idSesion = SessionControl::getIdSesion(); 
        /* 1. Comprobacion de tratamiento de datos aceptado */ 
        if(isset($_POST['terminos']) && $_POST['terminos'] != NULL){
        $check = UserEntrySecurity::asegurarEntradaUsuario($_POST['terminos']); 
        if($check == "Si"){
            /* 2. Obtenemos el usuario con el que se desea formar pareja */ 
            if(isset($_POST['pareja_seleccionada']) && $_POST['pareja_seleccionada'] != NULL){
            $idUsuarioPareja = UserEntrySecurity::asegurarEntradaUsuario($_POST['pareja_seleccionada']); 
            $usuarioPareja = DAOUsuario::selectById($idUsuarioPareja); 
            if($usuarioPareja != NULL){
                /* 3. Inserta la notificacion de solicitud de pareja */ 
                $res = NotificacionesControl::notificacionSolicitudPareja($usuarioPareja->getIdUsuario(), $idSesion, $idTorneo);
                return 'torneosView.php'; 
            }
            else{
                $erroresFormulario[] = "Tienes que elegir un compañero/a para el torneo. "; 
            }
            }
            else{
                $erroresFromulario[] = "Tienes que elegir un compañero/a para el torneo. "; 
            }
            
        }
        else{
            $erroresFormulario[] = "Tienes que aceptar el tratamiento de tus datos para el torneo para poder continuar. "; 
        }
        }
        else{
            $erroresFormulario[] = "Tienes que aceptar el tratamiento de tus datos para el torneo para poder continuar. "; 
        }
        
        return $erroresFormulario; 
    }
    
    
}