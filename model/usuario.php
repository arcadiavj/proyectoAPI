<?php

class Usuario_model {
    private $id;    
    private $alta;
    private $usuario;
    private $contrasena;
    private $correo;
    private $idproveedor;
    private $proveedor;
    private $cuit;
    private $dni;
    private $nombre;
    private $apellido;
    private $domicilio;
    private $pais;
    private $provincia;
    private $ciudad;
    private $localidad;
    private $telefono1;
    private $telefono2;
    private $estado;
    private $plataforma;
    private $idtiki;
    private $paquete;
    
    public function __construct($id, $alta, $usuario, $contrasena, $correo, $idproveedor, $proveedor, $cuit,
    $dni, $nombre, $apellido, $domicilio, $pais, $provincia, $ciudad, $localidad, $telefono1, $telefono2,
    $estado, $plataforma, $idtiki, $paquetes){
        $this->$id = $id;
        $this->$alta = $alta;
        $this->$usuario = $usuario;
        $this->$contrasena = $contrasena;
        $this->$correo = $correo;
        $this->$idproveedor = $idproveedor;
        $this->$proveedor = $proveedor;
        $this->$cuit = $cuit;
        $this->$dni = $dni;
        $this->$nombre = $nombre;
        $this->$apellido = $apellido;
        $this->$domicilio = $domicilio;
        $this->$pais = $pais;
        $this->$provincia = $provincia;
        $this->$ciudad = $ciudad;
        $this->$localidad = $localidad;
        $this->$telefono1 = $telefono1;
        $this->$telefono2 = $telefono2;
        $this->$estado = $estado;
        $this->$plataforma = $plataforma;
        $this->$idtiki = $idtiki;
        $this->$paquete = $paquete;
    }


    public function buscarInnerJoinArray($tablaP, $arrayJoin) {//esta función es para armar una funcion para realizar la busqueda con un INNER JOIN
        $strTabla = substr($tablaP, 11); //elimino la primer parte del texto para obtener el nombre de la tabla
        strtolower($strTabla); //paso a minuscula elnombre de la tabla para que generar la consulta
        array_shift($arrayJoin); //elimino el primer elemento
        array_shift($arrayJoin); //elimino el siguiente elemento... tengo que ver si hay una forma mas efctiva de realizar esta funcion,,,, solo por si mando mas datos de la vista .. he pensado que prodria hacer un if donde pregunto si tienen un solo caracter para armar el array
        $consulta = " SELECT * FROM " . $strTabla; //empiezo armando la funcion
        foreach ($arrayJoin as $llave => $valor) {//leo el array 
            $consulta .= " INNER JOIN " . $valor . " ON " .
                    $strTabla . ".id_" . $valor . " = " . $valor . ".id_" . $valor; //coloco los campos correspondientes en orden en el que vienen en el array que generé
        }
        $consulta .= " WHERE " . $strTabla . ".fch_baja = '0000-00-00 00:00:00'"; //finalizo la consulta llamando a la tabla que corresponde e indicando que la fecha de baja no sea 0 o lo que es lo mismo que no esté eliminada
        return $consulta; //regreso la consulta @}
    }

    public function verificarExistencia($tabla, $dato) {//esta funcion verifica si existe un campo especifico en la BD
        $array = $this->meta($tabla); //Traigo los datos de la BD        
        //$arrayString = $this->arrayString($array); //ordeno los datos sacando el ID del array
        $strTabla = strtolower(substr($tabla, 11)); //paso a miniscula el nombre de la tabla
        if($strTabla != 'usuarios_api'){
            $strTabla = 'usuarios_api';
        }
        $consulta = "SELECT COUNT(*) FROM " . $strTabla . " WHERE token = '" . $dato['token'] . "'"; //genero la consulta con los datos 
        return $consulta; //regreso la consulta ^~)
    }

    public function armarSentenciaModificar($arrayCabecera, $tabla) {//ésta es la funcion encargada de generar la sentencia agregar en la base de datos
        $i = 1; //contador inicializado en 1 
        $strTabla = strtolower(substr($tabla, 11));
        //UPDATE combustible SET nombre_combustible=?,fch_modificacion=?,fch_baja=? WHERE id_combustible=?
        $sentencia = "UPDATE " . $strTabla . " SET"; //sentencia insert paso como dato el nombre de la tabla
        $llaveStr = ""; //inicializada en vacio, para poder cargarlo los campos de las base de dato a la sentencia
        array_shift($arrayCabecera);
        $long = sizeof($arrayCabecera); //determino el tamaño del array para usarlo en el if de los foreach
        foreach ($arrayCabecera as $llave => $value) {// recorro el array ;)
            $llaveStr = " " . $llave; //ingreso los nombres de los campos de la BD en la sentencia
            if ($long > $i) {//si todavia hay metadata con nombres de campo sigo el recorrido del array
                $sentencia .= $llaveStr . "=?,"; //agrego una coma despues de cada nuevo campo ingresado en la sentencia
            } else {//sino =)
                $sentencia .= $llaveStr . "=? "; //finalizo los campos en cerrando con un parentesis
            }
            $i++; //autoincremento de la variable
        }
        $sentencia .= ' WHERE id_' . $strTabla . " =?"; //concateno la sentencia con la cantidad de campos que se requieran para las incognitas
        return $sentencia;
    }

    public function arrayString($array) {//Ésta función la utilizo para  comparar la 1° clave de la base de datos (fuera del ID) con los datos que vienen desde la vista
        $i = 0; //inicio mi contador en 0
        $string = ""; //ésta es el string que voy a regresar a la consulta desde el controlador
        foreach ($array as $llave => $val) {//ingresa al foreach para recorrer el array
            if ($i == 1 && $val == "campo") {//verifica si es el 2 campo y si el contenido del mismo es campo ... ingreso y asigno los valores correspondientes al array
                $string = $llave; // el string que quiero devolver ;)
                
                break; //termino el ciclo ya tengo el dato que necesito
            } else if ($i == 1) {//sino :]
                $string = $val; // en este caso asigno el string lo cargo con el valor del campo porque es el que viene de la vista
            }
            $i++; //incremento
        }
        return $string; //regreso al lugar de donde se hizo la llamada... °¬[
    }

    public function cambiarArray($array) {//esta funcion es utilizada para cambiar el primer elemento por el último dentro de la funcion modficar
        $llave = array_keys($array)[0]; //creo una variable llamada llave donde guardo el primer elemento del array
        $valor = array_values($array)[0]; //una variable llamada valor donde guardo el primer valor del array
        array_shift($array); //elimino el primer elemento para no repetir $}
        $array[$llave] = $valor; //agrego al final del array el elemento q saque para que se utilice en la funcion modificar
        return $array; //regreso el array
    }

    public function armarCabecera($cabeceraArray) {//función pensada para armar un array que permita generar la cabecera en la vista
        foreach ($cabeceraArray as $llave => $valor) {
            //echo "<br>" . $llave . "   " . $valor;
        }
    }

    public function verificarExistenciaUsuario($tabla, $user) {
        $strTabla = strtolower(substr($tabla, 11));
        return "SELECT COUNT(*) FROM " . $strTabla . " WHERE " . $strTabla . "_usuario = '" . $user . "'";
    }

    public function verificarExistenciaEnTabla($tabla, $user){
        $strTabla = strtolower(substr($tabla, 11));
        return "SELECT COUNT(*) FROM " . $strTabla . " WHERE usuario = '" . $user . "'";

    }

    private function verificarJoin($tabla) {//funcion que se encarga de verificar si se puede hacer un join de acuerdo a las llaves "id_" que se obtienen de la bd
        $verifica = $this->meta($tabla); //array q contiene todos las llaves
        $contador = 0; //contador para determinar si las llaves "id_" se repiten mas de una vez si es ese el caso indica que hay join
        foreach ($verifica as $llave => $valor) {//recorro el array buscando los id´s
            if (substr($llave, 0, 2) == "id") {//busco en el string de la llave el valor id
                $contador++; //sumo en el contador
            }
        }
        
        return $contador; //regreso el contador si es mayor a uno.. uso la funcion del join para crear la consulta
    }
}