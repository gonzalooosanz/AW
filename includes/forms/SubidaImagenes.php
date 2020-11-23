<?php

require_once("includes/forms/UserEntrySecurity.php");
require_once("includes/control/SessionControl.php"); 
require_once("includes/configuration/Definitions.php"); 
class SubidasImagen{
    
    public static function subirImagen($nombreImagenFormulario, $ruta, $nombreImagenNuevo){
        $nombreImg = $_FILES[$nombreImagenFormulario]['name'];
        $nombreImg = UserEntrySecurity::asegurarEntradaUsuario($nombreImg);
        $resCrearCarpeta = false; 
        $malicioso = UserEntrySecurity::asegurarFicheroDeSubida($nombreImg);
        $nombreImagenFinal = NULL;
        if($malicioso == false){
            if(($nombreImagenFormulario != NULL) && ($_FILES[$nombreImagenFormulario]['size'] <= 200000)){
                if(($_FILES[$nombreImagenFormulario]["type"] == "image/jpg")
                    || ($_FILES[$nombreImagenFormulario]["type"] == "image/png")
                    || ($_FILES[$nombreImagenFormulario]["type"] == "image/jpeg")){
                        $directorio = $_SERVER['DOCUMENT_ROOT'].'/aw-pfinal/uploads'.$ruta;
                        if(!file_exists($directorio)){
                            $resCrearCarpeta = mkdir($directorio, 0777, true);
                        }
                        else{
                            $resCrearCarpeta = true;
                        }
                        $nombreImagenFinal = $directorio.'/'.$nombreImagenNuevo; // la imagen se ha subido al directorio uploads
                        if($resCrearCarpeta == true){
                        $res = move_uploaded_file($_FILES[$nombreImagenFormulario]['tmp_name'], $nombreImagenFinal);
                        $nombreImagenFinal = 'uploads'.$ruta.'/'.$nombreImagenNuevo; 
                        }
                        else{
                            $nombreImagenFinal = ERROR_FORMATO_IMAGEN; 
                        }
                }
            }
            else{
               $nombreImagenFinal = ERROR_TAMAÑO_IMAGEN; 
            }
        }else{
            if($resCrearCarpeta == false){
                $nombreImagenFinal = ERROR_SUBIDA_IMAGEN;
            }
            else{
                $nombreImagenFinal = ERROR_IMAGEN_MALICIOSA;
            }
        }
        return $nombreImagenFinal;
    }
    
}