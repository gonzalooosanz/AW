<?php

require_once("SingletonDataSource.php");
require_once("DataSource.php");
require_once("Usuario.php");

class DAOUsuario implements Countable{
    
    public static function selectUsuarios(){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM usuarios");
        $usuario = NULL;
        $usuarios = array();
        foreach ($data_table as $clave => $valor)
        {
            $usuario = new Usuario();
            
            $usuario = self::setEverything($data_table, $usuario, $clave);
            array_push($usuarios,$usuario);
        }
        return $usuarios;
    }
    
    public static function selectUserByEmail($email){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = NULL;
        $data_table_email = $data_source->ejecutarConsulta("SELECT * FROM usuarios WHERE email = :email", array(':email' => $email));
        if($data_table_email != NULL){
        if(count($data_table_email) == 1){
            $data_table = $data_table_email;
        }
        }
        $usuario = NULL; 
        if($data_table != NULL){
            foreach($data_table as $clave => $valor){
                $usuario = new Usuario();
                $usuario = self::setEverything($data_table, $usuario, $clave);
            }
        }
        return $usuario;
        
    }
    
    public static function obtenerProximoIdInsertar(){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance(); 
        $data_table = $data_source->ejecutarConsulta("SELECT AUTO_INCREMENT FROM information_schema.TABLES
            WHERE TABLE_SCHEMA = 'padel2u_db' 
            AND TABLE_NAME = 'usuarios'"); 
        return $data_table[0]["AUTO_INCREMENT"]; 
    }
    
    public static function obtenerUltimoIdUsuario(){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT MAX(id) AS maximo FROM usuarios");
        return $data_table[0]["maximo"];
    }
    
    
    public static function verifyPassword($id, $passIntroducida){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $verifyOk = NULL; 
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM usuarios WHERE id = :id", array(':id' => $id));
        if(count($data_table) == 1){
        
            $passUser = $data_table[0]['password'];
            $verifyOk = password_verify($passIntroducida, $passUser);
            $passUser = NULL;
        }
        return $verifyOk;
    }
    
    
    public static function selectById($id){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM usuarios WHERE id = :id",array(':id' => $id));
        $usuario = NULL;
        if($data_table != NULL){
            foreach($data_table as $clave => $valor){
                $usuario = new Usuario();
                $usuario = self::setEverything($data_table, $usuario, $clave);
            }
        }
        return $usuario;
    }
    
    public static function selectByNombre($nombre){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM usuarios WHERE nombre LIKE '$nombre%'", 
            array(':nombre' => $nombre)); 
                                                        
            $usuarios = array(); 
            $usuario = NULL;
            foreach($data_table as $clave => $valor){
                $usuario = new Usuario();
                $usuario = self::setEverything($data_table, $usuario, $clave);
                array_push($usuarios, $usuario);
            }
        return $usuarios; 
    }
    
    public static function selectByNombreAndPrimerApellido($nombre, $ap1){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM usuarios WHERE nombre LIKE '$nombre%' AND apellido1 LIKE '$ap1%'", array(':nombre' => $nombre, ':apellido1' => $ap1));
        
        $usuarios = array();
        $usuario = NULL;
        foreach($data_table as $clave => $valor){
            $usuario = new Usuario();
            $usuario = self::setEverything($data_table, $usuario, $clave);
            array_push($usuarios, $usuario);
        }
        return $usuarios;
    }
    
 
    public static function selectByNombreAndApellidos($nombre, $ap1, $ap2){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM usuarios WHERE nombre LIKE '$nombre%' AND  apellido1 LIKE '$ap1%' AND 
                                                    apellido2 LIKE '$ap2%'", array(':nombre' => $nombre, ':apellido1' => $ap1, 
                                               ':apellido2' => $ap2));
        $usuario = NULL; 
        if(count($data_table) == 1){
       
            foreach($data_table as $clave => $valor){
                $usuario = new Usuario();
                $usuario = self::setEverything($data_table, $usuario, $clave);
            }
        }
        return $usuario; 
    }
   
    public static function selectByCA($ca){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM usuarios WHERE provincia = :provincia", array(':provincia' => $ca));
        $usuario = NULL;
        $usuarios = array();
        foreach($data_table as $clave => $valor){
            $usuario = new Usuario();
            $usuario = self::setEverything($data_table, $usuario, $clave);
            array_push($usuarios, $usuario);
        }
        
        return $usuarios;
    }

    public static function selectByEfectividad($efect){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM usuarios WHERE efectividad = :efectividad", array(':efectividad' => $efect));
        $usuario = NULL;
        $usuarios = array();
        foreach($data_table as $clave => $valor){
            $usuario = new Usuario();
            $usuario = self::setEverything($data_table, $usuario, $clave);
            array_push($usuarios, $usuario);
        }
        
        return $usuarios;
    }
    
    public static function selectByCiu($ciu){
      $data_source = new SingletonDataSource();
      $data_source = $data_source->getInstance();
      $data_table = $data_source->ejecutarConsulta("SELECT * FROM usuarios WHERE localidad = :localidad", array(':localidad' => $ciu));
      $usuario = NULL; 
      $usuarios = array(); 
          foreach($data_table as $clave => $valor){
              $usuario = new Usuario();
              $usuario = self::setEverything($data_table,$usuario, $clave);
              array_push($usuarios, $usuario);
          }
      
      return $usuarios; 
    }
    
    public static function selectByCAandlocalidad($ca, $ciu){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM usuarios WHERE provincia = :provincia AND localidad = :localidad",
            array(':provincia' => $ca, ':localidad' => $ciu));
        $usuario = NULL; 
        $usuarios = array(); 
            foreach($data_table as $clave => $valor){
                $usuario = new Usuario(); 
                $usuario = self::setEverything($data_table, $usuario, $clave); 
                array_push($usuarios, $usuario);
            }
        
        return $usuarios;
    }

    public static function selectBySexo($sex){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM usuarios WHERE sexo = :sexo", array(':sexo' => $sex));
        $usuario = NULL; 
        $usuarios = array(); 
            foreach($data_table as $clave => $valor){
                $usuario = new Usuario();
                $usuario = self::setEverything($data_table,$usuario, $clave);
                array_push($usuarios, $usuario);
            }
        
        return $usuarios; 
      }
    
    
    public static function insertUser(Usuario $usuario){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $sql = "INSERT INTO usuarios (`email`, `nombre`, `apellido1`,
        `apellido2`, `efectividad`, `password`, `provincia`, `localidad`, `sexo`, `arbitro`, `perfil`) 
        VALUES (:email,:nombre,:apellido1,
        :apellido2,:efectividad, :password, :provincia, :localidad,:sexo,:arbitro,:perfil)";
        $pass = $usuario->getPassword();
        $pass_hash = password_hash($pass,PASSWORD_DEFAULT);
        $usuario->setPassword($pass_hash);
        $resultado = $data_source ->ejecutarActualizacion($sql,array(
            ':email' => $usuario->getEmail(),
            ':nombre' => $usuario->getNombre(),
            ':apellido1' => $usuario->getApellido1(),
            ':apellido2' => $usuario->getApellido2(),
            ':efectividad' => $usuario->getEfectividad(),
            ':password' => $usuario->getPassword(),
            ':provincia' => $usuario->getprovincia(),
            ':localidad' => $usuario->getlocalidad(),
            ':sexo' => $usuario->getSexo(),
            ':arbitro' => $usuario->getArbitro(), 
            ':perfil' => $usuario->getPerfil()));
        return $resultado;
    }
    
    public static function updateUser(Usuario $usuario){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $sql = "UPDATE usuarios SET
        id = :id, 
        email = :email, 
        nombre = :nombre, 
        apellido1 = :apellido1, 
        apellido2 = :apellido2,
        efectividad = :efectividad,
        password = :password, 
        provincia = :provincia, 
        localidad = :localidad, 
        sexo = :sexo, 
        arbitro = :arbitro, 
        perfil = :perfil
        WHERE id = :id";
        $resultado = $data_source ->ejecutarActualizacion($sql,array(
            ':id' => $usuario->getIdUsuario(), 
            ':email' => $usuario->getEmail(),
            ':nombre' => $usuario->getNombre(),
            ':apellido1' => $usuario->getApellido1(),
            ':apellido2' => $usuario->getApellido2(),
            ':efectividad' => $usuario->getEfectividad(),
            ':password' => $usuario->getPassword(),
            ':provincia' => $usuario->getprovincia(),
            ':localidad' => $usuario->getlocalidad(),
            ':sexo' => $usuario->getSexo(),
            ':arbitro' => $usuario->getArbitro(), 
            ':perfil' => $usuario->getPerfil())); 
        return $resultado; 
    }
    
    public static function deleteUser($id){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $resultado = $data_source->ejecutarActualizacion("DELETE FROM usuarios WHERE
        id = :id", array(':id' => $id));
        return $resultado;  
    }
    
    public static function setEverything($data_table = array(), Usuario $usuario, $clave){
        
        $usuario->setIdUsuario($data_table[$clave]["id"]);
        $usuario->setEmail($data_table[$clave]["email"]);
        $usuario->setNombre($data_table[$clave]["nombre"]);
        $usuario->setApellido1($data_table[$clave]["apellido1"]);   
        $usuario->setApellido2($data_table[$clave]["apellido2"]);
        $usuario->setEfectividad($data_table[$clave]["efectividad"]);
        $usuario->setPassword($data_table[$clave]["password"]); 
        $usuario->setprovincia($data_table[$clave]["provincia"]);
        $usuario->setlocalidad($data_table[$clave]["localidad"]);
        $usuario->setSexo($data_table[$clave]["sexo"]);     
        $usuario->setArbitro($data_table[$clave]["arbitro"]);
        $usuario->setPerfil($data_table[$clave]["perfil"]); 
        return $usuario;
    }
    public function count()
    {}

}
?>