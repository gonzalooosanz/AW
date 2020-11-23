<?php






class MathematicOperations{
    public static function calcularMedia($suma, $valorDividir){
        return $suma / $valorDividir;
    }
    
    public static function rondasMaximas($numParejas){
        $maxRondas = 1; 
        while($numParejas > 2){
            $numParejas = $numParejas / 2; // se enfrentan dos parejas por cada partido. 
            $maxRondas = $maxRondas + 1; 
        }
        return $maxRondas; 
    }
    
    public static function potencia($base, $exponente){
        return pow($base, $exponente); 
    }
    
    public static function obtenerRandom($min, $max){
        $random = mt_rand($min, $max); 
        return $random;
    }
    
    public static function random_int($min, $max) {
        if (!function_exists('mcrypt_create_iv')) {
            trigger_error(
                'mcrypt must be loaded for random_int to work',
                E_USER_WARNING
                );
            return null;
        }
        
        if (!is_int($min) || !is_int($max)) {
            trigger_error('$min and $max must be integer values', E_USER_NOTICE);
            $min = (int)$min;
            $max = (int)$max;
        }
        
        if ($min > $max) {
            trigger_error('$max can\'t be lesser than $min', E_USER_WARNING);
            return null;
        }
        
        $range = $counter = $max - $min;
        $bits = 1;
        
        while ($counter >>= 1) {
            ++$bits;
        }
        
        $bytes = (int)max(ceil($bits/8), 1);
        $bitmask = pow(2, $bits) - 1;
        
        if ($bitmask >= PHP_INT_MAX) {
            $bitmask = PHP_INT_MAX;
        }
        
        do {
            $result = hexdec(
                bin2hex(
                    mcrypt_create_iv($bytes, MCRYPT_DEV_URANDOM)
                    )
                ) & $bitmask;
        } while ($result > $range);
        
        return $result + $min;
    }
}