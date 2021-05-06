<?php

define("__URL__", "http://localhost/proyecto17-3/app/apiRest/v1/");  //constate con la direccion donde realizar la consulta cambiar por URL producción
define("__TOKEN__", "token: abc123");  //token generado previamente que debe incluirse en los headers de la consutla

class Services{

  public $respuesta;// variable para almacenar la respuesta
  protected $config = 1;//array de configuracion
  

  public function __construct($config = null){// Constructor para inicializar el array de configuracion
    
    $this->$config =array(//array configuracion 
      //CURLOPT_URL => __URL__."usuarios",// url con endpoint para consulta
      CURLOPT_RETURNTRANSFER => true,        
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,        
      CURLOPT_HTTPHEADER => array("Content-Type: application/json",// incluir en header
      __TOKEN__//token que se genera
      )
    );


  } 
  
  public function getUsuarios(){//método para la llamada al servicio
    $config = null;   
    $ch = curl_init();  //cURL  inicializacion 
    curl_setopt($ch, CURLOPT_URL,__URL__."usuarios");
    curl_setopt_array($ch,$this->$config);// opciones de configuracion      
    $res = curl_exec($ch);// respuesta
    curl_close($ch);// cierro consulta
    echo $res;// imprimo respuesta     
    }

    public function getProvincias(){//método para la llamada al servicio
      $config = null;   
      $ch = curl_init();  //cURL  inicializacion 
      curl_setopt($ch, CURLOPT_URL,__URL__."provincias");
      curl_setopt_array($ch,$this->$config);// opciones de configuracion      
      $res = curl_exec($ch);// respuesta
      curl_close($ch);// cierro consulta
      echo $res;// imprimo respuesta     
      }
    public function getCiudades(){//método para la llamada al servicio
        $config = null;   
        $ch = curl_init();  //cURL  inicializacion 
        curl_setopt($ch, CURLOPT_URL,__URL__."ciudades");
        curl_setopt_array($ch,$this->$config);// opciones de configuracion      
        $res = curl_exec($ch);// respuesta
        curl_close($ch);// cierro consulta
        echo $res;// imprimo respuesta     
        }  

        public function setUsuario($usuario){
          $ch = curl_init();  //cURL  inicializacion           
          curl_setopt($ch, CURLOPT_URL,__URL__."usuario");
          curl_setopt($ch,CURLOPT_POSTFIELDS,$usuario);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "application/x-www-form-urlencoded",// incluir en header
            __TOKEN__//token que se genera
              ),
            );              
          $res = curl_exec($ch);
          curl_close($ch);
          echo $res;       
        }

        public function updateUsuario($usuario){
          $ch = curl_init();  //cURL  inicializacion           
          curl_setopt($ch, CURLOPT_URL,__URL__."usuario");
          curl_setopt($ch,CURLOPT_POSTFIELDS,$usuario);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "application/x-www-form-urlencoded",// incluir en header
            __TOKEN__//token que se genera
              ),
            );              
          $res = curl_exec($ch);
          curl_close($ch);
          echo $res;       
        }

        public function getPaquetesUsuario($dato){//método para la llamada al servicio
          $config = null;   
          $ch = curl_init();  //cURL  inicializacion 
          curl_setopt($ch, CURLOPT_URL,__URL__."paquetesUsuarios/".$dato);
          curl_setopt_array($ch,$this->$config);// opciones de configuracion      
          $res = curl_exec($ch);// respuesta
          curl_close($ch);// cierro consulta
          echo $res;// imprimo respuesta     
          }


}

/**
 * public function getLocalidades(){//método par la llamada al servicio
  $opciones = array(
    CURLOPT_URL => __URL__."localidades",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    __TOKEN__
      ));  
  $ch = curl_init();  
  curl_setopt_array($ch, $opciones);
    $res = curl_exec($ch);
    curl_close($ch);
    echo $res; 
  }
  public function getCiudades(){
    $ch = curl_init();  
    curl_setopt_array($ch, array(
        CURLOPT_URL => __URL__."ciudades",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json",
        __TOKEN__
          ),
         ));
      $res = curl_exec($ch);
      curl_close($ch);
      echo $res; 
    }
    public function getProvincias(){
      $ch = curl_init();  
      curl_setopt_array($ch, array(
          CURLOPT_URL => __URL__."provincias",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
          "Content-Type: application/json",
          __TOKEN__
            ),
           ));
        $res = curl_exec($ch);
        curl_close($ch);
        echo $res; 
      }




      curl_setopt_array($ch, array(//array configuracion 
              CURLOPT_URL => $this->__URL__."usuario",
              CURLOPT_RETURNTRANSFER => true,        
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,        
              CURLOPT_POST => true,
              CURLOPT_POSTFIELDS=>$usuario,
              CURLOPT_HTTPHEADER => array(
              "application/x-www-form-urlencoded",// incluir en header
              $this->__TOKEN__//token que se genera
                ),
               ));

     

 */
