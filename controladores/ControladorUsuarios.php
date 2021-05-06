<?php

require_once 'ControladorGeneral.php';
require_once 'ControladorMaster.php';
require_once 'SqlQuery.php';
include_once '../helper/helper.php';




class ControladorUsuarios extends ControladorGeneral {        

    
    public function buscar() {//busca usando la clase SqlQuery
        (string) $tabla = get_class($this); //uso el nombre de la clase que debe coincidir con la BD         
        $master = new ControladorMaster();        
        return $master->buscar($tabla);        
    }
    public function existe($datosCampos) {//busca usando la clase SqlQuery
        (string) $tabla = get_class($this); //uso el nombre de la clase que debe coincidir con la BD         
        $master = new ControladorMaster();
        $master->verificar($tabla,$datosCampos);        
        $this->buscar();        
    }

   
    public function eliminar($id) {//elimina usando SqlQuery clase
        (string) $tabla = get_class($this); //adquiero el nombre de la clase para usar en la tabla
        $master = new ControladorMaster();
        $master->eliminar($tabla, $id);       
        return ["eliminado"=>"eliminado"];
    }

    public function buscarUsuarioXId($dato) {//este método es el encargado de realiza la busqueda del último usuario insertado usando SqlQuery      
        (string) $tabla = get_class($this); //adquiero el nombre de la clase para usar en la tabla
        $master = new ControladorMaster();
        $array = $master->buscarUsuarioId($dato, $tabla);
        $limpio = limpiarConraseña($array);
        return $limpio;
    }

    
    public function buscarUsuario($dato){
    (string) $tabla = get_class($this); //adquiero el nombre de la clase para usar en la tabla
        $master = new ControladorMaster();
        $array = $master->buscarUsuario($dato, $tabla);
        $limpio = limpiarConraseña($array);
        return $limpio;
    }
    public function sugerir($token){
        (string) $tabla = get_class($this); //adquiero el nombre de la clase para usar en la tabla
            $master = new ControladorMaster();
            $array = $master->sugerir($token, $tabla);
            $sugerido = armarSugerencia($array);
            return $sugerido;
        }

    public function guardar($datosCampos) {//funcion guardar con SqlQuery implementado
        $token = $datosCampos['token'];
        (string) $tabla = get_class($this); //obtengo el nombre de la clase para poder realizar la consulta
        $master = new ControladorMaster();
        $sql = new SqlQuery();
        $arrayMaestro = $sql->meta($tabla);
        array_shift($arrayMaestro);
        $datosCampos = compararVista($arrayMaestro, $datosCampos);
        $datosCampos['token'] = $token;
        var_dump($datosCampos);
        $datosCampos['contrasena'] = contrasena($datosCampos['contrasena']);
        $datosCampos['alta']=fecha();
        $arrayProvincias = $master->verificarProvincia($datosCampos);
        $provincias = validarProvinciasHelper($arrayProvincias, $datosCampos);
        if($provincias['error']){
            return $provincias;
        }
        $usuario = $master->verificarExistenciaEnTabla($tabla, $datosCampos['usuario']);
        if($usuario['0']['COUNT(*)'] == '0'){
            require_once '../services/tiki.php';
            $tiki = new TikiLive();
            $guardar = $tiki->usuarioNuevo($datosCampos['usuario'],
            $datosCampos['contrasena'],$datosCampos['correo'],
            $datosCampos['nombre'],$datosCampos['apellido'],
            $datosCampos['estado']);
            $datosCampos['idtiki'] = $guardar;
            //$array = limpiarIndiceToken($datosCampos);
            return $master->guardar($tabla,$datosCampos);
        }else{            
            return $respuesta = array("codigo" => '400');
        }
                 
    }

    public function ultimo() {//utiliza clase SqlQuery para automatizar consulta        
        (string) $tabla = get_class($this); //obtengo el nombre de la clase para realizar la consulta en la BD
        $master = new ControladorMaster();
        return $master->bucarUltimo($tabla);
    }

    public function modificar($datosCampos) {//utiliza clase SqlQuery para automatizar consulta
        $guardar = new SqlQuery(); //instancio objeto de la clase sqlQuery
        (string) $tabla = get_class($this); //obtengo el nombre de la clase para poder realizar la consulta
        $master = new ControladorMaster();
        return $master->modificar($tabla, $datosCampos);
    }
    

    public function buscarProvincias($datosCampos){
        $resultados = array();
        $guardar = new SqlQuery(); //instancio objeto de la clase sqlQuery
        (string) $tabla = get_class($this); //obtengo el nombre de la clase para poder realizar la consulta
        $master = new ControladorMaster();
        foreach ($datosCampos as $key => $value) {
            if($value['localidad'] == null){
                $value['localidad'] = '1';
            };
            $resultados[$value['localidad']] = $master->buscarLocalidad($value['localidad']);
        }
        return $resultados;
    }
    
    public function buscarPaquetes($datosCampos){
        $resultados = array();
        $guardar = new SqlQuery(); //instancio objeto de la clase sqlQuery
        $master = new ControladorMaster();
        if($datosCampos){
            $resultados = $master->buscarPaquetes($datosCampos);
        }else{
        foreach ($datosCampos as $key => $value) {
            if($value['paquete'] == null){
                $value['paquete'] = '1';
            };
            $resultados[$value['paquete']] = $master->buscarPaquetes($value['paquete']);
        }    
     }   
        return $resultados;
    }

}