<?php

define("__URL__", "http://localhost/proyecto17-3/app/apiRest/v1/");  
define("__TOKEN__", "token: ULRGVHAGWDLKR6LS0IFF0HLJWITTFMWLFYOQ2C5V");  

class Services{

  public $respuesta;

  public $opciones = array(
    /*CURLOPT_URL => __URL__."localidades",*/
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    __TOKEN__
      ));

     
  
  public function getLocalidades(){
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

  public function getUsuarios(){
    $ch = curl_init();  
    curl_setopt_array($ch, array(
        CURLOPT_URL => __URL__."usuarios",
        CURLOPT_RETURNTRANSFER => true,        
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,        
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json",
        "token: abc123"
          ),
         ));
         
    $res = curl_exec($ch);
    //$data = json_decode(file_get_contents($res));
    curl_close($ch);
    echo $res;    
    
    }




}
