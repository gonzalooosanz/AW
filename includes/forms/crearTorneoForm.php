<?php
require_once("Form.php");
require_once("includes/forms/UserEntrySecurity.php");
require_once("includes/configuration/Definitions.php");
require_once("includes/model/DAOs/DAOTorneo.php");
require_once("includes/control/SessionControl.php"); 

class CrearTorneoForm extends Form{
    
    protected function generaCamposFormulario($datosFormulario){
        return '
         <form action = "#" method = "post" enctype = "multipart/form-data"
         name = "crearTorneoForm">
          <div class = "segmento">
            <div class = "input-group">
                <label> Nombre: </label>
                <input type = "text" name = "nombre" >
            </div>
            
            <label class = "label_error" id = "nombre_error"> El campo nombre no puede estar vacío ni superar 40 caracteres. </label>
            
            <div class = "input-group">
                <label> Provincia: </label>
                    <select id="ps-prov" name = "provincia" >
                    <option value = "nada"> Selecciona tu provincia </option>
                    </select>
		        </div>
                <label class = "label_error" id = "provincia_error"> Selecciona una provincia. </label>
                <div class = "input-group">
                   <label> Municipio: </label>
                    <select id="ps-mun" name = "localidad" ></select>
                </div>
            
                <label class = "label_error" id = "localidad_error"> Selecciona un municipio. </label>
            
            
            
            <div class = "input-group">
                <label> Direccion: </label>
                <input type = "text" name = "direccion" >
            </div>
            <label class = "label_error" id = "direccion_error"> El campo direccion no puede estar vacío ni superar 40 caracteres. </label>
            
             <div class = "input-group">
                <label> Fecha de inicio:  </label>
                <input id = "fecha_inicio" name = "fecha_inicio" type = "date" >
            </div>
            <label class = "label_error" id = "fecha_inicio_error"> La fecha de inicio no puede ser vacia o ser previa a la actual. </label>
            
            
          </div>
            
          <div class = "segmento">
            <div class = "input-group">
                <label> Fecha limite de inscripcion:  </label>
                <input id = "fecha_inscripcion" name = "fecha_inscripcion" type = "date" >
            </div>
             <label class = "label_error" id = "fecha_inscripcion_error"> La fecha de inscripcion no puede ser vacia o ser previa a la actual. </label>
            
            <div class = "input-group">
                <label> Fecha de finalizacion del torneo:  </label>
                <input id = "fecha_fin" name = "fecha_fin" type = "date" >
            </div>
            <label class = "label_error" id = "fecha_fin_error"> La fecha de finalizacion no puede ser vacia o ser previa a la actual. </label>
            
            <div class = "input-group">
                <label> Maximo numero de parejas permitidas:   </label>
                <input type = "number" name = "max_parejas" min = "4" max = "100" >
            </div>
             <label class = "label_error" id = "max_parejas_error"> Debes de ajustar un maximo de parejas para el torneo no vacio ni superior a 100.</label>
            
            <div class = "input-group">
                <label> Premios para el ganador: </label>
                <textarea name = "premios" placeholder = "premios"> </textarea>
            </div>
            <label class = "label_error" id = "premios_error"> Debes de ajustar un premio para el partido. </label>
            
            <div class = "input-group">
                <label> Efectividad requerida para el torneo: </label>
                <input type = "number" name = "efectividad" min = "0" max = "99999" >
            </div>
            
            <label class = "label_error" id = "efectividad_error"> Debes de ajustar una efectividad para el torneo entre 0 y 99999. </label>
            
          </div>
           <div class = "segmento">
                 <div class = "boton_cargando grande azul">
                    <div class = "spinner disabled" id = "spinner_crear_torneo"></div>
                    <input type = "submit" value = "Crear Torneo">
                </div>
            
           </div>
            </form>
        '; 
    }
    
    protected function procesaFormulario($datos){
        $erroresFormulario = array(); 
        $okFormulario = true; 
        /* 1. Comprobar permisos de creacion de torneo */ 
        $tipoSesion = SessionControl::tipoUsuarioLogeado(); 
        if($tipoSesion == USUARIO_ARBITRO){
            /* 2. Comprobar que el torneo no este repetido por nombre */ 
            $nombre = UserEntrySecurity::asegurarEntradaUsuario($_POST['nombre']); 
            $torneo = NULL; 
            $torneo = DAOTorneo::selectByNombre($nombre); 
            if($torneo != NULL){
                $erroresFormulario[] = "El nombre introducido para el torneo ya existe. "; 
            }
            else{
                /* 3. Construimos el objeto torneo y lo insertamos */ 
                $torneo = new Torneo(); 
                if(isset($_POST['nombre']) && $_POST['nombre'] != NULL){
                    $nombre = UserEntrySecurity::asegurarEntradaUsuario($_POST['nombre']); 
                    if(empty($nombre) || mb_strlen($nombre) > SIZE_TORNEO_NOMBRE){
                        $erroresFormulario[] = "El nombre del torneo no puede estar vacio o contener mas de 40 caracteres. "; 
                        $okFormulario = false; 
                    }
                    else{
                        $torneo->setNombre($nombre); 
                    }
                }
                else{
                    $erroresFormulario[] = "El nombre del torneo no puede estar vacio. "; 
                    $okFormulario = false; 
                }
                
                if(isset($_POST['provincia']) && $_POST['provincia'] != "nada"){
                    $provincia = UserEntrySecurity::asegurarEntradaUsuario($_POST['provincia']); 
                    if(empty($provincia) || mb_strlen($provincia) > SIZE_TORNEO_CIUDAD){
                        $erroresFormulario[] = "La provincia del torneo no puede estar vacia o contener mas de 40 caracteres. "; 
                        $okFormulario = false; 
                    }
                    else{
                        $torneo->setProvincia($provincia); 
                    }
                }
                else{
                    $erroresFormulario[] = "La provincia del torneo no puede estar vacia. "; 
                    $okFormulario = false; 
                }
                
                if(isset($_POST['localidad']) && $_POST['localidad'] != "nada"){
                    $localidad = UserEntrySecurity::asegurarEntradaUsuario($_POST['localidad']); 
                    if(empty($localidad) || mb_strlen($localidad) > SIZE_TORNEO_CIUDAD){
                        $erroresFormulario[] = "La localidad del torneo no puede estar vacia o contener mas de 40 caracteres. ";
                        $okFormulario = false;
                    }
                    else{
                        $torneo->setCiudad($localidad);
                    }
                }
                else{
                    $erroresFormulario[] = "La localidad del torneo no puede estar vacia. ";
                    $okFormulario = false;
                }
                
                
                if(isset($_POST['direccion']) && $_POST['direccion'] != NULL){
                    $direccion = UserEntrySecurity::asegurarEntradaUsuario($_POST['direccion']); 
                    if(empty($direccion) || mb_strlen($direccion) > SIZE_TORNEO_DIRECCION){
                        $erroresFormulario[] = "La direccion del torneo no puede estar vacia o contener mas de 40 caracteres. ";
                        $okFormulario = false;
                    }
                    else{
                        $torneo->setdireccion($direccion);
                    }
                }
                else{
                    $erroresFormulario[] = "La direccion del torneo no puede estar vacia. ";
                    $okFormulario = false;
                }
                
                if(isset($_POST['fecha_inicio']) && $_POST['fecha_inicio'] != NULL){
                    $fechaInicio = UserEntrySecurity::asegurarEntradaUsuario($_POST['fecha_inicio']); 
                    if(empty($fechaInicio) || mb_strlen($fechaInicio) > SIZE_TORNEO_FECHA_INICIO){
                        $erroresFormulario[] = "La fecha de inicio del torneo no puede estar vacia o contener mas de 20 caracteres. ";
                        $okFormulario = false;
                    }
                    else{
                        $torneo->setFechaInicio($fechaInicio);
                    }
                }
                else{
                    $erroresFormulario[] = "La fecha de inicio del torneo no puede estar vacia. ";
                    $okFormulario = false;
                }
                
                if(isset($_POST['fecha_inscripcion']) && $_POST['fecha_inscripcion'] != NULL){
                    $fechaInscripcion = UserEntrySecurity::asegurarEntradaUsuario($_POST['fecha_inscripcion']); 
                    if(empty($fechaInscripcion) || mb_strlen($fechaInscripcion) > SIZE_TORNEO_FECHA_INSCRIPCION){
                        $erroresFormulario[] = "La fecha de inscripcion del torneo no puede estar vacia o contener mas de 20 caracteres. ";
                        $okFormulario = false;
                    }
                    else{
                        $torneo->setFechaInscripcion($fechaInscripcion);
                    }
                }
                else{
                    $erroresFormulario[] = "La fecha de inscripcion del torneo no puede estar vacia. ";
                    $okFormulario = false;
                }
                
                if(isset($_POST['fecha_fin']) && $_POST['fecha_fin'] != NULL){
                    $fechaFin = UserEntrySecurity::asegurarEntradaUsuario($_POST['fecha_fin']); 
                    if(empty($fechaFin) || mb_strlen($fechaFin) > SIZE_TORNEO_FECHA_FIN){
                        $erroresFormulario[] = "La fecha de finalizacion del torneo no puede estar vacia o contener mas de 20 caracteres. ";
                        $okFormulario = false;
                    }
                    else{
                        $torneo->setFechaFin($fechaFin);
                    }
                }
                else{
                    $erroresFormulario[] = "La fecha de finalizacion no puede estar vacia. ";
                    $okFormulario = false;
                }
                
                if(isset($_POST['max_parejas']) && $_POST['max_parejas'] != NULL){
                    $maxParejas = UserEntrySecurity::asegurarEntradaUsuario($_POST['max_parejas']); 
                    if(empty($maxParejas) || mb_strlen($maxParejas) > SIZE_TORNEO_MAX_PAREJAS){
                        $erroresFormulario[] = "El numero de parejas maximas del torneo  no puede estar vacio o contener mas de 3 caracteres. ";
                        $okFormulario = false;
                    }
                    else{
                        $torneo->setmaxParejas($maxParejas);
                    }
                }
                else{
                    $erroresFormulario[] = "El numero de parejas maximas del torneo no puede estar vacio. ";
                    $okFormulario = false;
                }
                if(isset($_POST['premios']) && $_POST['premios'] != NULL){
                    $premios = UserEntrySecurity::asegurarEntradaUsuario($_POST['premios']); 
                    if(mb_strlen($premios) > SIZE_TORNEO_PREMIO){
                        $erroresFormulario[] = "El campo premios no puede contener mas de 40 caracteres. ";
                        $okFormulario = false;
                    }
                    else{
                        $torneo->setPremio($premios);
                    }
                }
                
                if(isset($_POST['efectividad']) && $_POST['efectividad'] != NULL){
                    $efectividad = UserEntrySecurity::asegurarEntradaUsuario($_POST['efectividad']); 
                    if(empty($efectividad) || mb_strlen($efectividad) > SIZE_TORNEO_EFECTIVIDAD_REQUERIDA){
                        $erroresFormulario[] = "El campo efectividad requerida no puede estar vacio o contener mas de 10 caracteres. ";
                        $okFormulario = false;
                    }
                    else{
                        $torneo->setEfectividadRequerida($efectividad);
                    }
                }
                else{
                    $erroresFormulario[] = "El campo efectividad requerida no puede estar vacio. ";
                    $okFormulario = false;
                }
                
                $torneo->setnumParejas(0); 
                $torneo->setCerrado(false); 
                $torneo->setMaxRondas(0); 
                $filasInsertadas = -1; 
                if($okFormulario == true){
                    $filasInsertadas = DAOTorneo::insertTorneo($torneo); 
                }
                if($okFormulario == true && $filasInsertadas == 1){
                    SessionControl::marcarExito("Torneo creado correctamente"); 
                    return 'torneosView.php'; 
                }   
                else if($okFormulario == false && $filasInsertadas != 1){
                    SessionControl::marcarError("Se ha producido un error con las BBDD de la aplicacion, vuelva a intentarlo mas tarde. ");
                }
                
            }
        }
        else{
            $erroresFormulario[] = "Solo un arbitro puede crear un torneo. "; 
        }
        return $erroresFormulario;
    }
    
    
    
}