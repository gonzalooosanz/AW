<?php



class DateOperations{
    
    public static function getTodayDate(){
        $fecha = date("Y-m-d");
        return $fecha;
    }
    
    public static function cambiarFecha($offsetAno, $offsetMes, $offsetDia, $offsetHora, $offsetMin){
       $hoy = self::getTodayDate(); 
       $fecha = "";
       $fechaFinal = "";
       
       if($offsetHora != 0 || $offsetMin != 0){
       $fecha = date("d-m-Y H:i");
       }
       else{
           $fecha = date("d-m-Y");
       }
       // Comprobamos la operacion a realizar: 
       if($offsetDia > 0){
           $fechaFinal =  strtotime("+".$offsetDia." days", strtotime($fecha)); 
       }
       else if($offsetDia < 0){
           $offsetDia = abs($offsetDia);
           $fechaFinal =  strtotime("-".$offsetDia." days", $fechaFinal); 
       }
       if($offsetMes > 0){
           $fechaFinal =  strtotime("+".$offsetMes." months", $fechaFinal); 
       }
       else if($offsetMes < 0){
           $offsetMes = abs($offsetMes);
           $fechaFinal =  strtotime("-".$offsetMes." months", $fechaFinal);
       }
       if($offsetAno > 0){
           $fechaFinal =  strtotime("+".$offsetAno." years", $fechaFinal);
       }
       else if($offsetAno < 0){
           $offsetAno = abs($offsetAno);
           $fechaFinal =  strtotime("-".$offsetAno." years", $fechaFinal);
       }
       if($offsetHora != 0 || $offsetMin != 0){ // la fecha contiene hora
           if($offsetHora > 0){
               $fechaFinal =  strtotime("+".$offsetHora." hour", $fechaFinal);
           }
           if($offsetMin > 0){
               $fechaFinal =  strtotime("+".$offsetMin." minute", $fechaFinal);
           }
           $fechaFinal = date("d-m-Y H:i", $fechaFinal); 
       }
       else{
           $fechaFinal = date("d-m-Y", $fechaFinal); 
       }
       return $fechaFinal;  
    }
    
   
}