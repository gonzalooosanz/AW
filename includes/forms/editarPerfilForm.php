<?php 

    require_once("Form.php"); 
    require_once("includes/model/DAOs/DAOUsuario.php"); 
    require_once("includes/forms/SubidaImagenes.php"); 
    require_once("includes/forms/UserEntrySecurity.php"); 
    require_once("includes/configuration/Definitions.php"); 
    require_once("includes/control/SessionControl.php"); 
    require_once("includes/control/UsuariosControl.php");
    require_once("includes/model/DAOs/Usuario.php");
    
class editarPerfilForm extends Form{
    protected function generaCamposFormulario($datosIniciales){
       
           return ' <form action = "#" method = "post"
            enctype="multipart/form-data" name = "editarPerfilForm">
               <div class = "segmento">
                <div class = "input-group">
                    <label> Email: </label>
                    <input type = "email" name = "email"/>
                </div>
                <label class = "label_error" id = "email_error"> El email no puede superar los 30 caracteres. </label>
                <div class = "input-group">
                    <label> Repite email: </label>
                    <input type = "text" name = "email2"/>
                </div>
                <label class = "label_error" id = "email_error_2"> El email  superar los 30 caracteres. </label>
                <div class = "input-group">
                    <label> Contraseña: </label>
                    <input type = "password" name = "password"/>
                </div>
                <label class = "label_error" id = "pass_error"> La contraseña  superar los 256 caracteres. </label>
                <div class = "input-group">
                    <label> Repite Contraseña: </label>
                    <input type = "password" name = "password_val"/>
                </div>
                <label class = "label_error" id = "pass_error_2"> La contraseña  superar los 256 caracteres. </label>
                <div class = "input-group">
                    <label> Nombre: </label>
                    <input type = "text" name = "nombre" />
                    <label class = "label_error" id = "nombre_error">
                </div>
            <label class = "label_error" id = "nombre_error"> El nombre no puede superar los 30 caracteres. </label>
            </div>
            <div class = "segmento">
                
                <div class = "input-group">
                    <label> Primer Apellido: </label>
                    <input type = "text" name = "apellido1"/>
                </div>
                <label class = "label_error" id = "apellido1_error"> El primer apellido no puede superar los 30 caracteres. </label>
                <div class = "input-group">
                    <label> Segundo Apellido: </label>
                    <input type = "text" name = "apellido2" />
                </div>
                <label class = "label_error" id = "apellido2_error"> El segundo apellido no puede superar los 30 caracteres. </label>
                <div class = "input-group">
                    <select name = "sexo">
                        <option value = "nada"> Sexo </option>
                        <option value = "hombre"> Hombre </option>
                        <option value = "mujer"> Mujer </option>
                    </select>
                </div>
                
                <div class = "input-group">
                    <label> Tu imagen de perfil: </label>
                    <input type = "file" name = "perfil" id = "perfil_usuario">
                </div>
                <label class = "label_error" id = "perfil_error"> La ruta de la imagen es demasiado grande. </label>
                
                
                <div class = "input-group">
                   <label> Provincia: </label>
                    <select id="ps-prov" name = "provincia">
                    <option value = "nada"> Selecciona tu provincia </option>    
                    </select>
                
                </div>
  <label class = "label_error" id = "provincia_error"> La provincia no puede superar los 30 caracteres. </label>
                <div class = "input-group">
                   <label> Municipio: </label>
                    <select id="ps-mun" name = "localidad"></select>
                </div>
              <label class = "label_error" id = "localidad_error"> La localidad no puede superar los 30 caracteres.  </label>
             </div>
             <label class = "label_error" id = "campos_vacios"> No pueden estar todos los campos vacios. </label>
                <div class = "boton_cargando grande azul">
                    <div class = "spinner disabled" id = "spinner_editarperfil"></div>
                    <input type = "submit" value = "Guardar cambios">
                </div>
            </form>

        ';  
    }
    
    protected function procesaFormulario($datos){
       /* El formulario ya se ha entregado y validado por js por lo 
        * que suponemos que el unico error posible es que el email este repoetido */
        $erroresFormulario = array(); 
        $idUsuario = SessionControl::getIdSesion();
        $user = DAOUsuario::selectById($idUsuario); 
        $ok = true; 
        if($user != NULL){
        /* 1. Comprobacion de email no repetido */ 
        $usuarioEmail = NULL; 
        $email = UserEntrySecurity::asegurarEntradaUsuario($_POST['email']);
        $repetido = UsuariosControl::usuarioRepetido($email);
        if($repetido != COMPROBACION_CORRECTA){
            $erroresFormulario[] = "El email introducido ya habia sido registrado en la aplicacion. "; 
        }
        else{
          $idInsercion = SessionControl::getIdSesion(); 
            /* 2. Validar datos del servidor y crear el objeto Usuario */ 
            if(isset($_POST['email']) && $_POST['email'] != NULL){
                $email = UserEntrySecurity::asegurarEntradaUsuario($_POST['email']);
                if(empty($email) || mb_strlen($email) > SIZE_USUARIO_EMAIL){
                    $erroresFormulario[] = "El email no puede contener mas de 30 caracteres o estar vacio. ";
                    $ok = false; 
                }
                else{
                    $user->setEmail($email);
                }
            }
            
            if(isset($_POST['password']) && $_POST['password'] != NULL){
                $pass = UserEntrySecurity::asegurarEntradaUsuario($_POST['password']);
                if(empty($pass) || mb_strlen($pass) > SIZE_USUARIO_PASSWORD){
                    $erroresFormulario[] = "La contraseña no puede estar vacia o contener mas de 256 caracteres. "; 
                    $ok = false; 
                }
                else{
                    $user->setPassword($pass);
                }
            }
            
            if(isset($_POST['nombre']) && $_POST['nombre'] != NULL){
                $nombre = UserEntrySecurity::asegurarEntradaUsuario($_POST['nombre']);
                if(empty($nombre) || mb_strlen($nombre) > SIZE_USUARIO_NOMBRE){
                    $erroresFormulario[] = "El nombre no puede estar vacio o contener mas de 20 caracteres. "; 
                    $ok = false; 
                }
                else{
                    $user->setNombre($nombre);
                }
            }
            if(isset($_POST['apellido1']) && $_POST['apellido1'] != NULL){
                $apellido1 = UserEntrySecurity::asegurarEntradaUsuario($_POST['apellido1']);
                if(empty($apellido1) || mb_strlen($apellido1) > SIZE_USUARIO_APELLIDO1){
                    $erroresFormulario[] = "El primer apellido no puede estar vacio o tener mas de 25 caracteres. "; 
                    $ok = false; 
                }
                else{
                    $user->setApellido1($apellido1);
                }
            }
            
            if(isset($_POST['apellido2']) && $_POST['apellido2'] != NULL){
                $apellido2 = UserEntrySecurity::asegurarEntradaUsuario($_POST['apellido2']);
                if(empty($apellido2) || mb_strlen($apellido2) > SIZE_USUARIO_APELLIDO2){
                    $erroresFormulario[] = "El segundo apellido no puede estar vacio o tener mas de 25 caracteres. ";
                    $ok = false;
                }
                else{
                    $user->setApellido2($apellido2);
                }
            }
            
            if(isset($_POST['sexo']) && $_POST['sexo'] != "nada"){
                $sexo = UserEntrySecurity::asegurarEntradaUsuario($_POST['sexo']);
                if(empty($sexo) || mb_strlen($sexo) > SIZE_USUARIO_SEXO){
                    $erroresFormulario[] = "El sexo no puede estar vacio o tener mas de 25 caracteres. ";
                    $ok = false;
                }
                else{
                    $user->setSexo($sexo);
                }
            }
            
            if(isset($_FILES['perfil']) && $_FILES['perfil'] != NULL && $_FILES['perfil']["name"] != NULL){
                $nombreImgSeparado = array();
                $nombreImg = $_FILES['perfil']["name"];
                $nombreImgSeparado = explode('.', $nombreImg);
                $carpeta = '/usuario/'.$idInsercion; /* Inserto la imagen en usuario/(id del usuario)/perfil.jpg/png */
                $rutaImagen = SubidasImagen::subirImagen('perfil', $carpeta, 'perfil.'.$nombreImgSeparado[1]);
                switch($rutaImagen){
                    case ERROR_FORMATO_IMAGEN:
                        $erroresFormulario[] = "Solo se admiten imagenes en JPG o PNG. ";
                        $ok = false;
                        break;
                    case ERROR_IMAGEN_MALICIOSA:
                        $erroresFormulario[] = "Tu imagen no ha superado el control de seguridad de la aplicacion. ";
                        $ok = false;
                        break;
                    case ERROR_TAMAÑO_IMAGEN:
                        $erroresFormulario[] = "El tamaño maximo permitido para una imagen es de 2kB. ";
                        $ok = false;
                        break;
                    case ERROR_SUBIDA_IMAGEN:
                        $erroresFormulario[] = "En este momento no podemos subir la imagen introducida, por favor intentalo mas tarde. ";
                        $ok = false;
                        break;
                }
                if($ok == true){
                    $user->setPerfil($rutaImagen);
                }
            }
            
            
            if(isset($_POST['provincia']) && $_POST['provincia'] != "nada"){
                $provincia = UserEntrySecurity::asegurarEntradaUsuario($_POST['provincia']);
                if(empty($provincia) || mb_strlen($provincia) > SIZE_USUARIO_PROVINCIA){
                    $erroresFormulario[] = "La provincia no puede estar vacia o tener mas de 30 caracteres. ";
                    $ok = false;
                }
                else{
                    $user->setprovincia($provincia);
                }
            }
            
            if(isset($_POST['localidad']) && $_POST['localidad'] != "nada"){
                $localidad = UserEntrySecurity::asegurarEntradaUsuario($_POST['localidad']);
                if(empty($localidad) || mb_strlen($localidad) > SIZE_USUARIO_LOCALIDAD){
                    $erroresFormulario[] = "El campo localidad no puede estar vacio o tener mas de 30 caracteres. ";
                    $ok = false;
                }
                else{
                    $user->setlocalidad($localidad);
                }
            }
         /* 3. Terminamos de construir el objeto Usuario(con los datos no recogidos en el formulario), reemplazamos el usuario editado.*/ 
            if($ok == true){
                $status = UsuariosControl::EditarUsuario($user); 
                return 'miCuentaView.php'; 
            }
        
        }
        }
        else{
            SessionControl::marcarError(TEXTO_ERROR_ESTANDAR); 
            return 'miCuentaView.php'; 
        }
        return $erroresFormulario; 
    }
    
    
}
?>
