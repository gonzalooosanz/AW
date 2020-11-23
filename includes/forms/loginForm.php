<?php
require_once("Form.php");
require_once("includes/model/DAOs/DAOUsuario.php");
require_once("includes/forms/UserEntrySecurity.php");
require_once("includes/configuration/Definitions.php");
require_once("includes/control/SessionControl.php"); 

class LoginForm extends Form{
    
    protected function generaCamposFormulario($datosFormulario){
        return ' 
            <form action = "#" method = "post" name = "loginForm">
               <div class = "segmento">
                <div class = "input-group">
                    <label> Email: </label>
                    <input type = "email" name = "email" id = "email_input">
                </div>

                 <label class = "label_error" id = "email_error"> El email no puede estar vacio ni superar los 30 caracteres.  </label> 
                 <label class = "label_error" id = "email_jq_error"> El email introducido no esta registrado en Padel2U </label>
                <div class = "input-group">
                    <label> Contraseña: </label>
                    <input type = "password" name = "pass" id = "pass_input">
                </div>
                <label class = "label_error" id = "pass_error"> La contraseña no puede estar vacia ni superar los 256 caracteres. </label> 
                <label class = "label_error" id = "pass_jq_error"> La contraseña no es correcta para este usuario. </label> 
                
            </div>
               <div class = "boton_cargando grande azul">
                    <div class = "spinner disabled" id = "spinner_login"></div>
                    <input type = "submit" value = "Iniciar Sesion">
                </div>
             </form>
        '; 
    }
    
    protected function procesaFormulario($datos){
        $erroresFormulario = array(); 
        /* 1. Comprobacion de email correcto */ 
        $email = UserEntrySecurity::asegurarEntradaUsuario($_POST['email']); 
        $user = NULL; 
        $user = DAOUsuario::selectUserByEmail($email); 
        if($user != NULL){
            /* 2. Comprobacion de la contraseña */ 
            $okPass = false; 
            $passIntroducida = UserEntrySecurity::asegurarEntradaUsuario($_POST['pass']);
            $okPass = DAOUsuario::verifyPassword($user->getIdUsuario(), $passIntroducida); 
            if($okPass == true){
                $tipoUsuario = USUARIO_NORMAL; 
                if(($arbitro = $user->getArbitro()) == true){
                    $tipoUsuario = USUARIO_ARBITRO;
                }
                else{
                    $tipoUsuario = USUARIO_NORMAL; 
                }
                
                SessionControl::iniciarSesion($user->getIdUsuario(),$tipoUsuario, $user->getEfectividad()); 
                return 'index.php'; 
            }
            else{
                $erroresFormulario[] = "Contraseña del usuario incorrecta. "; 
            }
        }
        else{
            $erroresFormulario[] = "Email introducido incorrecto. "; 
        }
        return $erroresFormulario;
    }
    
}