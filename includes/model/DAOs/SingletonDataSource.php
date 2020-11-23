<?php
// Script que permite establecer  una conexion unica con la 
// BBDD de la aplicacion. 

// INCLUSION BUSSINESS: DATA SOURCE:
require_once("DataSource.php");

class SingletonDataSource{
    private static $data;
    
    public static function getInstance(){
        if(!isset($data) || $data == NULL){
            $data = new DataSource();
        }
        return $data;
    }
}