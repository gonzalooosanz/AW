<?php




class Errores{
    
    public static function generarPantallaInaccesible($error, $opciones = array(), $enlace){
        $html2 = "";
        $html3 = "";
        $html1 =  '
            <div class = "error_wrapper">
                <h3 class = "rojo">'.$error.'</h3>
                <p> Este error puede deberse a cualquiera de las siguientes opciones: </p>
                    <ul>';
        foreach($opciones as $clave){
            $html2 .= '<li><p>'.$clave.'</p></li>';
        }
        $html3 = '</ul>
                  '.$enlace.'
                </div>';
        return $html1.$html2.$html3;
    }
    
}