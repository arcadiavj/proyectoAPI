<?php
function limpiarConraseña($array){
$limpio = array();
$i = 0;
foreach ($array as $arr) {
        foreach ($arr as $key => $value ) {
            if($key == 'subid' ||
            $key == 'ingreso'||
            $key == 'precio'||
            $key == 'unitario'||
            $key == 'base'||
            $key == 'comision'||
            $key == 'fecha_anterior'||
            $key == 'precio_anterior'||
            $key == 'unitario_anterior'||
            $key == 'datas'||
            $key == 'rol'||
            $key == 'avatar'||
            $key == 'observaciones'||
            $key == 'idtiki'||
            $key == 'provincia'||
            $key == 'ciudad'
            ){                               
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


function contrasenaCrear($cadena){
    $cadena = mb_strtoupper($cadena);
    return ( strlen($cadena)>0 ) ? md5($cadena) : NULL;
}

function arrayProvincias($registro, $provincia){
    $i=0;
    foreach ($registro as $key => $value) {
        // foreach ($provincia as $llave => $valor) {
        //     //var_dump($value['localidad']);}
        //     var_dump($valor);    
        // }
        if($value['localidad'] == null){
            $value['localidad'] = '1';
            $provincia[$value['localidad']] = [
                '0'=>[
                    'nombre'=>['0'=>'null', '1'=>'null', '2'=>'null']
                    ]
                ];
        }
            
      $registro[$i]['localidad'] =['localidad'=>$provincia[$value['localidad']]];
      $i++;
    }
    return $registro;

}