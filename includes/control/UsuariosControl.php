<?php

$ruta = $_SERVER['PHP_SELF'];
if(strpos($ruta, "includes") != false){
    require_once("../model/DAOs/DAOUsuario.php");
    require_once("../model/DAOs/Usuario.php"); 
    require_once("../control/SessionControl.php");
    require_once("../configuration/Definitions.php");
}
else{
    require_once("includes/model/DAOs/DAOUsuario.php");
    require_once("includes/model/DAOs/Usuario.php");
    require_once("includes/control/SessionControl.php");
    require_once("includes/configuration/Definitions.php");
}


class UsuariosControl{
    
    
    
    public static function registroUsuario(Usuario $usuario){
        $idUsuario = DAOUsuario::obtenerProximoIdInsertar(); 
        if(($nFilas = DAOUsuario::insertUser($usuario)) == 1){
            SessionControl::iniciarSesion($idUsuario, USUARIO_NORMAL, EFECTIVIDAD_INICIAL); 
            SessionControl::marcarExito("Te has registrado correctamente en Padel2u");
            return OPERACION_CORRECTA; 
        }
        else{
            SessionControl::marcarError("La aplicacion no está funcionando correctamente. Intentalo mas tarde. "); 
            return ERROR_APLICACION; 
        }
    }
    
    public static function EditarUsuario(Usuario $usuario){
        if(($nFilas = DAOUsuario::updateUser($usuario)) == 1){
            SessionControl::marcarExito("Has editado tu perfil correctamente en Padel2u");
            return OPERACION_CORRECTA;
        }
        else{
            SessionControl::marcarError("La aplicacion no está funcionando correctamente. Intentalo mas tarde. ");
            return ERROR_APLICACION;
        }
    }
    
    public static function usuarioRepetido($email){
        $usuario = NULL; 
        if(($usuario = DAOUsuario::selectUserByEmail($email)) != NULL){
            return ERROR_USUARIO_REPETIDO; 
        }
        else{
            return COMPROBACION_CORRECTA; 
        }
    }
    
    public static function obtenerUltimoIdUsuarioLibre(){
        return DAOUsuario::obtenerUltimoIdUsuario() + 1;
    }
    
    // Resuelve inconsistencias en la BD de integridad.
    public static function borrarUltimaFilaInsertada(){
        $idBorrar = DAOUsuario::obtenerUltimoIdUsuario(); 
        if(($filas = DAOUsuario::deleteUser($idBorrar)) == 1){
            return OPERACION_CORRECTA;
        }
        else{
            return ERROR_APLICACION;
        }
    }
    
    
}