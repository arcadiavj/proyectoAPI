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

    public function guardar($datosCampos) {//funcion guardar con SqlQuery implementado
        (string) $tabla = get_class($this); //obtengo el nombre de la clase para poder realizar la consulta
        $master = new ControladorMaster();
        $usuario = $master->verificarExistenciaEnTabla($tabla, $datosCampos['usuario']);
        if($usuario['0']['COUNT(*)'] == '0'){
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
    

    

}