<?php
session_start();

class SessionControl{
    
    /* Aclaracion: 
     * 
     * $_SESSION['errorMsg']: Contiene el mensaje de error que genera la ULTIMA operacion 
     * que se ejecutó y que necesita mostrar feedback al usuario del error producido durante su ejecucion. 
     * $_SESSION['exitoMsg']: Contiene el mensaje de exito que genera la ULTIMA operacion
     * que se ejecutó y que necesita mostrar feedback al usuario de que la operación finalizó correctamente. 
     * Por ejemplo en el caso de que el email introducido por el usuario ya exista necesitaremos dar un feedback 
     * negativo al usuario de porque no se ha completado su registro. 
     * Pasa igual en el caso de que el usuario se registre correctamente, necesitamos informar de que el usuario 
     * se ha registrado correctamente cuando le redirigimos a la pantalla principal de la aplicacion. 
     * $_SESSION['status']: Indica si la ultima operacion realizada por la aplicacion (que necesite mostrar feedback al usuario)
     *  produjo un error(si $_SESSION['status'] == "ERROR") o si la ultima operacion realizada por la aplicacion(que necesite mostrar feedback al usuario)
     *  se completó correctamente (si $_SESSION['status'] == "EXITO"). 
     *  
     *  
     *  $_SESSION['idSesion']: Contiene el id del usuario de la sesion(es decir, el usuario que ha iniciado sesion y no la ha cerrado, o se la ha hecho 
     *  logout por inactividad(automatico)). 
     *  $_SESSION['tipoUsuario']: Contiene el tipo de usuario que ha iniciado sesion en la aplicacion (arbitro o usuario normal). 
     *  
     */
    
    
    
    
    public static function inicializarSesion(){
        
    }
    
    /** Permite marcar un mensaje de error que se mostrará como feedback al usuario
     * tras finalizar la operacion por la que se produjo. 
     *  $texto:  texto del mensaje de error. 
     */
    public static function marcarError($texto){
        $_SESSION['errorMsg'] = $texto;
        $_SESSION['exitoMsg'] = NULL;
        $_SESSION['status'] = "ERROR";
    }
    
    public static function setIdRecurso($id){
            $_SESSION['idRecurso'] = $id; 
    }
    
    public static function getIdRecurso(){
        $aux = NULL; 
        if(isset($_SESSION['idRecurso']) && $_SESSION['idRecurso'] != NULL){
            $aux = $_SESSION['idRecurso'];
        }
        return $aux; 
    }
    
    
    /** Permite marcar un mensaje de exito que se mostrará como feedback al usuario 
     * tras finalizar la operacion por la que se produjo. 
     * $texto: Texto del mensaje de exito. 
     */
    public static function marcarExito($texto){
        $_SESSION['exitoMsg'] = $texto;
        $_SESSION['errorMsg'] = NULL;
        $_SESSION['status'] = "EXITO"; 
    }
    
    public static function getFeedbackEntrante(){
        $aux = NULL; 
        $html = ""; 
        if(isset($_SESSION['status']) && $_SESSION['status'] != NULL){
            if($_SESSION['status'] == "ERROR"){
                $aux = $_SESSION['errorMsg']; 
                $html = self::generarHTMLFeedbackError($aux); 
                
            }
            else if($_SESSION['status'] == "EXITO"){
                $aux = $_SESSION['exitoMsg']; 
                $html = self::generarHTMLFeedbackExito($aux); 
            }
            else{
                $html = ""; 
            }
            $_SESSION['status'] = NULL; 
            $_SESSION['exitoMsg'] = NULL; 
            $_SESSION['errorMsg'] = NULL; 
        }
        return $html; 
    }
    
    public static function generarHTMLFeedbackExito($texto){
        return '
             <div class = "feedback_container_exito" onmouseover = "esconderFeedback()" id = "feedback">
		<div class = "mensaje_exito_wrapper" id = "icono_feedback">
			<span class="icon-checkmark2"></span>
		</div>
		<p class = "feedback_mensaje" id = "mensaje_feedback">'.$texto.'</p>
	</div>
    '; 
    }
    
    public static function generarHTMLFeedbackError($texto){
        return '
            <div class = "feedback_container_error" onmouseover = "esconderFeedback()" id = "feedback">
		<div class = "mensaje_error_wrapper">
			<span class="icon-cross"></span>
		</div>
		<p class = "feedback_mensaje">'.$texto.'</p>
	</div>
    ';
    }
    /** Marca la sesion con el id del usuario que ha iniciado sesion e indicando el tipo de usuario que ha iniciado sesion. 
     */
    public static function iniciarSesion($id, $tipoUsuario, $efectividad){
        $_SESSION['idSesion'] = $id; 
        $_SESSION['tipoUsuario'] = $tipoUsuario; 
        $_SESSION['efectividadSesion'] = $efectividad; 
    }
    
    public static function getEfectividadSesion(){
        $aux = NULL; 
        if(isset($_SESSION['efectividadSesion']) && $_SESSION['efectividadSesion'] != NULL){
            $aux = $_SESSION['efectividadSesion']; 
            return $aux; 
        }
    }
    
    /* Usado para saber en que seccion de la pagina te encuentras: Mi perfil, torneos, partido o jugadores */ 
    public static function setSeccion($seccion){
        $_SESSION['seccion'] = $seccion; 
    }
    
    public static function getSeccion(){
        $aux = NULL; 
        if(isset($_SESSION['seccion']) && $_SESSION['seccion'] != NULL){
            $aux = $_SESSION['seccion']; 
        }
        return $aux; 
    }
    
    /** Devuelve una cadena con el tipo de usuario que esta mirando la pagina por esta conexion. 
     * Puede devolver los siguientes valores: "USUARIO_NO_LOGEADO", "USUARIO_LOGEADO", "ARBITRO"
     */
    public static function tipoUsuarioLogeado(){
        $aux = NULL; 
        if(isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario'] != NULL){
            $aux = $_SESSION['tipoUsuario']; 
        }
        return $aux; 
    }
    
    public static function getIdSesion(){
        $aux = NULL; 
        if(isset($_SESSION['idSesion']) && $_SESSION['idSesion'] != NULL){
            $aux = $_SESSION['idSesion']; 
            return $aux; 
        }
    }
    
    /** Elimina la sesion para que se pierdan todos los datos del usuario en la sesion (a efectos practicos indica que el usuario del ordenador que esta viendo la pagina
     * no ha iniciado sesion y permanece como un usuario no logeado. 
     */
    public static function cerrarSesion(){
        unset($_SESSION);
        session_destroy();
    }
    
    
    
}