<?php
class Usuario{
    private $idUsuario;
    private $email;
    private $nombre; 
    private $apellido1; 
    private $apellido2; 
    private $efectividad;
    private $password;
    private $provincia;
    private $localidad;
    private $sexo;
    private $arbitro;
    private $perfil; 
    
    
    public function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario; 
    }
    public function getIdUsuario(){
        return $this->idUsuario;
    }

    public function setEmail($email){
        $this->email = $email; 
    }
    public function getEmail(){
        return $this->email;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre; 
    }
    public function getNombre(){
        return $this->nombre;
    }

    public function setApellido1($ape1){
        $this->apellido1 = $ape1;
    }
    public function getApellido1(){
        return $this->apellido1;
    }
    
    public function setApellido2($ap2){
        $this->apellido2 = $ap2;
    }
    public function getApellido2(){
        return $this->apellido2;
    }

    public function setEfectividad($efect){
        $this->efectividad = $efect;
    }
    public function getEfectividad(){
        return $this->efectividad;
    }

    public function setPassword($pass){
        $this->password = $pass;
    }
    public function getPassword(){
        return $this->password;
    }

    public function setprovincia($ca){
        $this->provincia = $ca;
    }
    public function getprovincia(){
        return $this->provincia;
    }
    
    public function setlocalidad($ciu){
        $this->localidad = $ciu;
    }
    public function getlocalidad(){
        return $this->localidad;
    }
    
    public function setSexo($sex){
        $this->sexo = $sex;
    }
    public function getSexo(){
        return $this->sexo;
    }
    
    public function setArbitro($ar){
        $this->arbitro = $ar;
    }
    public function getArbitro(){
        return $this->arbitro;
    }
    
    public function setPerfil($perfil){
        $this->perfil = $perfil; 
    }
    public function getPerfil(){
        return $this->perfil; 
    }
}
?>