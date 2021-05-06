<?php
function limpiarConraseña($array){
$limpio = array();
$i = 0;
foreach ($array as $arr) {
        foreach ($arr as $key => $value ) {
            if(
            $key == 'subid' ||
            $key == 'contrasena' ||
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

function contrasena($cadena){
    
    $cadena = mb_strtoupper($cadena);
	return ( strlen($cadena)>0 ) ? md5($cadena) : NULL;
}

function fecha(){
    $fecha = time();
    return $fechaR = date('Y-m-d H:m:s',$fecha);
}

function limpiarIndiceToken($array){
    $limpio = array();
        foreach ($array as $key => $value ) {
           if($key == 'token'){
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

function compararVista($array, $datos){ 
    $nuevo =array_keys($array);
    $nuevo =array_fill_keys($nuevo, NULL );
    foreach ($datos as $key => $value) {
        if(array_key_exists($key, $array)){
            $nuevo[$key] = $datos[$key];
        }
    }
    return $nuevo;
}

function llamadaArray(){
    return $array = [
        'usuarios.id,',
        'usuarios.alta,',
        'usuarios.rol,',
        'usuarios.usuario,',
        'usuarios.contrasena,',
        'usuarios.correo,',
        'usuarios.idproveedor,',
        'usuarios.proveedor,',
        'usuarios.cuit,',
        'usuarios.dni,',
        'usuarios.nombre AS nombreUsuairio,',
        'usuarios.apellido,',
        'usuarios.domicilio,',
        'usuarios.pais,',
        'usuarios.provincia,',
        'usuarios.ciudad,',
        'usuarios.localidad,',
        'usuarios.telefono1,',
        'usuarios.telefono2,',
        'usuarios.estado,',
        'usuarios.plataforma,',
        'usuarios.subid,',
        'usuarios.ingreso,',
        'usuarios.idtiki,',
        'paquetes.nombre AS nombrePaquete,',
        'paquetes_usuarios.paquete'
        ];
}


function camposRequeridos(){
    return $array = [
        'rol',
        'usuario',
        'contrasena',
        'correo',
        'cuit',
        'dni',
        'nombre',
        'apellido',
        'domicilio',
        'pais',
        'provincia',
        'ciudad',
        'localidad',
        'telefono1',
        'estado',
    ];
}

function validarProvinciasHelper($arrayProvincias, $datosCampos){
    $error = 0;
    foreach ($datosCampos as $key => $value) {
       switch ($key) {            
            case 'ciudad':
                $ciudad = array_search($datosCampos[$key],$arrayProvincias[0]);
                if(!$ciudad){
                    $error += 1; 
                }
                break;
            case 'provincia':
                $provincia = array_search($datosCampos[$key],$arrayProvincias[0]);                
                if(!$provincia){
                    $error += 2; 
                }
                break;
           default:
               break;
       }
        
    }
    if($error == 0){  
        $response["error"] = false;      
        return $response;
    }else if($error == 1){
        $response["error"] = true;
        $response["codigo"] = 400;
        $response["message"] = "Error al crear registro. Verifica el campo Ciudad.";
        return $response;
    }else if($error == 2){
        $response["error"] = true;
        $response["codigo"] = 400;
        $response["message"] = "Error al crear registro. Verifica el campos Provincia.";
        return $response;
    }else {
        $response["error"] = true;
        $response["codigo"] = 400;
        $response["message"] = "Error al crear registro. Verifica los campos Ciudad y Provincia.";
        return $response;
    }

}

function camposVacios($datosCampos){
    $array = camposRequeridos();
    $faltantes= array();
    $contar= 0;
    foreach ($datosCampos as $key => $value) {
        for ($i=0; $i < count($array); $i++) { 
            if($array[$i] == $key){
                array_push($faltantes, $key);
                $contar++;
            }
        }
    }
    $arrayDiff = array_diff($array, $faltantes);
    if($contar  == count($array)){
        $response["error"] = false;
        return $response;
    }else{
        $response["error"] = true;
        $response["codigo"] = 400;
        $response["message"] = "Error al crear registro. Verifica los campos obligatorios.";
        $response["faltantes"] = $arrayDiff;    
        return $response;
    }    
}

function armarSugerencia($array){
    $sugerencia = $array[0].'W'.($array[1]+1);
    return $sugerencia;
}
 

