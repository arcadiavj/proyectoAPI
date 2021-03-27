<?php
function limpiarConraseña($array){
$limpio = array();
$i = 0;
foreach ($array as $arr) {
        foreach ($arr as $key => $value ) {
            if($key == 'contrasena'){
               unset($arr[$key]);                
            }
            $limpio[$i] = $arr;            
        }    
        $i++;
        //$limpio = $arr;  
    }
   return $limpio;
}

function limpiarConraseñaArray($array){
    $limpio = array();
        foreach ($array as $key => $value ) {
           if($key == 'contrasena'){
                unset($array[$key]);                
            }
            $limpio = $array;
        }
    return $limpio;
    }

function buscarProvincias(){
    $provincias = ['provincias', 'ciudades', 'localidades'];

    for ($i=0; $i < count($provincias); $i++) { 
        include_once '../controladores/ControladorUbicacion_'.$provincias[$i].'.php';
        $controlador = 'ControladorUbicacion_'.$provincias[$i];
        $consulta = new $controlador();
        $registros[$provincias[$i]] = $consulta->buscar();
        $i++;
    }
    return $registros;
}