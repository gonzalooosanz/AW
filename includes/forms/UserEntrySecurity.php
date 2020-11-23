<?php

class UserEntrySecurity{
    
    public static function asegurarEntradaUsuario($entrada){
        $res = htmlspecialchars(trim(strip_tags($entrada)));
        return $res;
    }
    
    public static function asegurarFicheroDeSubida($cadena){
        $pruebas = array();
        $encontrado = false;
        $i = 0;
        $nPruebas = 5;
        $pruebas[0] = "passwd";
        $pruebas[1] = "root";
        $pruebas[2] = "admin";
        $pruebas[3] = "user";
        $pruebas[4] = "id";
        // y muchas mas... 
        for($i = 0; $i < $nPruebas; $i++){
            if(($encontrado = self::contiene($cadena, $pruebas[$i])) === 0){
                return true;
            }
        }
        return false;
    }
    
    public static function contiene($cadena, $palabra){
        return stripos($cadena, $palabra);
    }
}
?>