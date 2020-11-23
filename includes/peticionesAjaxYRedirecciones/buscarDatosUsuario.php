<?php
require_once ("../forms/UserEntrySecurity.php");
require_once ("../resultadosJuegos.php");
require_once ("../model/DAOs/Usuario.php");
require_once ("../model/DAOs/DAOUsuario.php");
require_once("../model/DAOs/DAONotificaciones.php"); 
require_once("../model/DAOs/Notificacion.php"); 
require_once ("../configuration/Definitions.php");
require_once("../control/NotificacionesControl.php"); 

if(isset($_POST['operation']) && $_POST['operation'] != NULL){
    $idUsuario = NULL; 
    $idNotificacion = NULL; 
    
    if(isset($_POST['idUsuario']) && $_POST['idUsuario'] != NULL){
    $idUsuario = UserEntrySecurity::asegurarEntradaUsuario($_POST['idUsuario']);
    }
    $operation = UserEntrySecurity::asegurarEntradaUsuario($_POST['operation']);
    if(isset($_POST['idNotificacion']) && $_POST['idNotificacion'] != NULL){
        $idNotificacion = UserEntrySecurity::asegurarEntradaUsuario($_POST['idNotificacion']); 
    }
    $notificacion = NULL; 
    $usuario = NULL;
        $html = "";
        switch ($operation) {
            case OPERACION_DATOS_USUARIO_Y_ESTADISTICAS:
                if(isset($_POST['idUsuario']) && $_POST['idUsuario'] != NULL){
                $usuario = DAOUsuario::selectById($idUsuario); 
                $html .= '<div class = "info_usuario_wrapper">
            <div class = "photo_wrapper">';
                if (($img = $usuario->getPerfil()) != NULL) {
                    $html .= '<img src = "' . $usuario->getPerfil() . '" alt = "Imagen del usuario">';
                } else {
                    $html .= '<img src = "img/user_icon.png" alt = "Imagen del usuario">';
                }
                $html .= '</div>
            <div class = "datos_wrapper">
                <h3>' . $usuario->getNombre() . ' ' . $usuario->getApellido1() . ' ' . $usuario->getApellido2() . '</h3>
                <h3> Efectividad: ' . $usuario->getEfectividad() . '</h3>
                <h3> <span class = "provincia_usuario"' . $usuario->getprovincia() . ' </span> | <span class = "localidad_usuario">' . $usuario->getlocalidad() . ' </span></h3>
            </div>
            </div> '; 
                }
                else{
                    $html = "-1ERROR"; 
                }
                break;
            case OPERACION_NOTIFICACIONES_USUARIO: 
                if(isset($_POST['idUsuario']) && $_POST['idUsuario'] != NULL){
                $html .= NotificacionesControl::imprimirNotificacionesUsuario(UserEntrySecurity::asegurarEntradaUsuario($_POST['idUsuario'])); 
                }
                else{
                    $html = "-1ERROR"; 
                }
                break; 
            case OPERACION_BORRAR_NOTIFICACION: 
                if(isset($_POST['idNotificacion']) && $_POST['idNotificacion'] != NULL){
                if(($res = NotificacionesControl::borrarNotificacionUsuario($idNotificacion)) == OPERACION_CORRECTA){
                    $html = "00000SUCCESS"; 
                }
                else{
                   $html = "-1ERROR"; 
                }
                }
                else{
                    $html = "-1ERROR"; 
                }
                break; 
            case OPERACION_COMPROBAR_EMAIL_USUARIO: 
                if(isset($_POST['email']) && $_POST['email'] != NULL){
                $usuario = NULL; 
                $usuario = DAOUsuario::selectUserByEmail(UserEntrySecurity::asegurarEntradaUsuario($_POST['email'])); 
                if($usuario != NULL){
                    $html = "SUCCESS"; 
                }
                else{
                    $html =  "USUARIO_NO_EXISTE"; 
                }
                }
                else{
                    $html = "-1ERROR"; 
                }
                break; 
            case OPERACION_COMPROBAR_PASSWORD_USUARIO: 
                if(isset($_POST['password']) && $_POST['password'] != NULL && isset($_POST['email']) && $_POST['email'] != NULL){
                    $passOk = false; 
                    $user = DAOUsuario::selectUserByEmail(UserEntrySecurity::asegurarEntradaUsuario($_POST['email'])); 
                    $passOk = DAOUsuario::verifyPassword($user->getIdUsuario(), UserEntrySecurity::asegurarEntradaUsuario($_POST['password']));
                    if($passOk == true){
                        $html = "SUCCESS"; 
                    }
                    else{
                        $html = "PASS_INCORRECTA"; 
                    }
                    
                }
                else{
                    $html = "-1ERROR"; 
                }
                
        }
        
        echo $html;
    
} else {
    echo "<p> Usuario No Encontrado: Error en la aplicacion. </p>";
}

    
        
    
    
    
    
    
 
   

