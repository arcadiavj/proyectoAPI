<?php
/**
 *API REST Conexión a base de datos y utilzción de Framework Slim para generar endPoints 
 * Proyecto 
 **/

/* Los headers permiten acceso desde otro dominio (CORS) a nuestro REST API o desde un cliente remoto via HTTP
 * Removiendo las lineas header() limitamos el acceso a nuestro RESTfull API a el mismo dominio
 * Nótese los métodos permitidos en Access-Control-Allow-Methods. Esto nos permite limitar los métodos de consulta a nuestro RESTfull API
 * Mas información: https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS
 **/
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: X-Requested-With");
header('Content-Type: text/html; charset=utf-8');
header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"'); 


require '../libs/Slim/Slim.php'; 
\Slim\Slim::registerAutoloader(); 
$app = new \Slim\Slim();//instancia del framework


/* Uso de GET para hacer las respectivas consultas a cada tabla en la BD */

$app->get('/bonificaciones', function() {
    $response = array();
    include_once '../controladores/ControladorBonificaciones.php';
    $consulta = new ControladorBonificaciones();
    $registros = $consulta->buscar();    
    $response["error"] = false;
    $response["message"] = "Registros Guardados: " . count($registros); //podemos usar count() para conocer el total de valores de un array
    $response["registros"] = $registros;

    echoResponse(200, $response);
});

$app->get('/bonificacionesDestinatarios', function() {
    $response = array();
    include_once '../controladores/ControladorBonificaciones_destinatarios.php';
    $consulta = new ControladorBonificaciones_destinatarios();
    $registros = $consulta->buscar();    
    $response["error"] = false;
    $response["message"] = "Registros Guardados: " . count($registros); //podemos usar count() para conocer el total de valores de un array
    $response["registros"] = $registros;

    echoResponse(200, $response);
});

$app->get('/contableDiario', function() {
    $response = array();
    include_once '../controladores/ControladorContable_diario.php';
    $consulta = new ControladorContable_diario();
    $registros = $consulta->buscar();    
    $response["error"] = false;
    $response["message"] = "Registros Guardados: " . count($registros); //podemos usar count() para conocer el total de valores de un array
    $response["registros"] = $registros;

    echoResponse(200, $response);
});

$app->get('/contableResumen', function() {
    $response = array();
    include_once '../controladores/ControladorContable_resumen.php';
    $consulta = new ControladorContable_resumen();
    $registros = $consulta->buscar();    
    $response["error"] = false;
    $response["message"] = "Registros Guardados: " . count($registros); //podemos usar count() para conocer el total de valores de un array
    $response["registros"] = $registros;

    echoResponse(200, $response);
});

$app->get('/notificaciones', function() {
    $response = array();
    include_once '../controladores/ControladorNotificaciones.php';
    $consulta = new ControladorNotificaciones();
    $registros = $consulta->buscar();    
    $response["error"] = false;
    $response["message"] = "Registros Guardados: " . count($registros); //podemos usar count() para conocer el total de valores de un array
    $response["registros"] = $registros;

    echoResponse(200, $response);
});

$app->get('/notificacionesDestinatarios', function() {
    $response = array();
    include_once '../controladores/ControladorNotificaciones_destinatarios.php';
    $consulta = new ControladorNotificaciones_destinatarios();
    $registros = $consulta->buscar();    
    $response["error"] = false;
    $response["message"] = "Registros Guardados: " . count($registros); //podemos usar count() para conocer el total de valores de un array
    $response["registros"] = $registros;

    echoResponse(200, $response);
});

$app->get('/paquetes', function() {
    $response = array();
    include_once '../controladores/ControladorPaquetes.php';
    $consulta = new ControladorPaquetes();
    $registros = $consulta->buscar();    
    $response["error"] = false;
    $response["message"] = "Registros Guardados: " . count($registros); //podemos usar count() para conocer el total de valores de un array
    $response["registros"] = $registros;

    echoResponse(200, $response);
});

$app->get('/paquetesProveedores', function() {
    $response = array();
    include_once '../controladores/ControladorPaquetes_proveedores.php';
    $consulta = new ControladorPaquetes_proveedores();
    $registros = $consulta->buscar();    
    $response["error"] = false;
    $response["message"] = "Registros Guardados: " . count($registros); //podemos usar count() para conocer el total de valores de un array
    $response["registros"] = $registros;

    echoResponse(200, $response);
});

$app->get('/paquetesUsuarios', function() {
    $response = array();
    include_once '../controladores/ControladorPaquetes_usuarios.php';
    $consulta = new ControladorPaquetes_usuarios();
    $registros = $consulta->buscar();    
    $response["error"] = false;
    $response["message"] = "Registros Guardados: " . count($registros); //podemos usar count() para conocer el total de valores de un array
    $response["registros"] = $registros;

    echoResponse(200, $response);
});

$app->get('/promocionesDestinatarios', function() {
    $response = array();
    include_once '../controladores/ControladorPromociones.php';
    $consulta = new ControladorPromociones();
    $registros = $consulta->buscar();    
    $response["error"] = false;
    $response["message"] = "Registros Guardados: " . count($registros); //podemos usar count() para conocer el total de valores de un array
    $response["registros"] = $registros;

    echoResponse(200, $response);
});

$app->get('/registroEventos', function() {
    $response = array();
    include_once '../controladores/ControladorRegistro_eventos.php';
    $consulta = new ControladorRegistro_eventos();
    $registros = $consulta->buscar();    
    $response["error"] = false;
    $response["message"] = "Registros Guardados: " . count($registros); //podemos usar count() para conocer el total de valores de un array
    $response["registros"] = $registros;

    echoResponse(200, $response);
});

$app->get('/sistemaPool', function() {
    $response = array();
    include_once '../controladores/ControladorSistema_pool.php';
    $consulta = new ControladorSistema_pool();
    $registros = $consulta->buscar();    
    $response["error"] = false;
    $response["message"] = "Registros Guardados: " . count($registros); //podemos usar count() para conocer el total de valores de un array
    $response["registros"] = $registros;

    echoResponse(200, $response);
});

$app->get('/solicitudes', function() {
    $response = array();
    include_once '../controladores/ControladorSolicitudes.php';
    $consulta = new ControladorSolicitudes();
    $registros = $consulta->buscar();    
    $response["error"] = false;
    $response["status"] = 200;
    $response["message"] = "Registros Guardados: " . count($registros); //podemos usar count() para conocer el total de valores de un array
    $response["registros"] = $registros;

    echoResponse(200, $response);
});

$app->get('/soporte', function() {
    $response = array();
    include_once '../controladores/ControladorSoporte.php';
    $consulta = new ControladorSoporte();
    $registros = $consulta->buscar();    
    $response["error"] = false;
    $response["status"] = 200;
    $response["message"] = "Registros Guardados: " . count($registros); //podemos usar count() para conocer el total de valores de un array
    $response["registros"] = $registros;

    echoResponse(200, $response);
});

$app->get('/tickets', function() {
    $response = array();
    include_once '../controladores/ControladorTickets.php';
    $consulta = new ControladorTickets();
    $registros = $consulta->buscar();    
    $response["error"] = false;
    $response["status"] = 200;
    $response["message"] = "Registros Guardados: " . count($registros); //podemos usar count() para conocer el total de valores de un array
    $response["registros"] = $registros;

    echoResponse(200, $response);
});

$app->get('/ticketsHilo', function() {
    $response = array();
    include_once '../controladores/ControladorTickets_hilo.php';
    $consulta = new ControladorTickets_hilo();
    $registros = $consulta->buscar();    
    $response["error"] = false;
    $response["status"] = 200;
    $response["message"] = "Registros Guardados: " . count($registros); //podemos usar count() para conocer el total de valores de un array
    $response["registros"] = $registros;

    echoResponse(200, $response);
});

$app->get('/ciudades', function() {
    $response = array();
    include_once '../controladores/ControladorUbicacion_ciudades.php';
    $consulta = new ControladorUbicacion_ciudades();
    $registros = $consulta->buscar();    
    $response["error"] = false;
    $response["status"] = 200;
    $response["message"] = "Registros Guardados: " . count($registros); //podemos usar count() para conocer el total de valores de un array
    $response["registros"] = $registros;

    echoResponse(200, $response);
});

$app->get('/localidades', function() {
    $response = array();
    include_once '../controladores/ControladorUbicacion_localidades.php';
    $consulta = new ControladorUbicacion_localidades();
    $registros = $consulta->buscar();    
    $response["error"] = false;
    $response["status"] = 200;
    $response["message"] = "Registros Guardados: " . count($registros); //podemos usar count() para conocer el total de valores de un array
    $response["registros"] = $registros;

    echoResponse(200, $response);
});

$app->get('/provincias', function() {
    $response = array();
    include_once '../controladores/ControladorUbicacion_provincias.php';
    $consulta = new ControladorUbicacion_provincias();
    $registros = $consulta->buscar();    
    $response["error"] = false;
    $response["status"] = 200;
    $response["message"] = "Registros Guardados: " . count($registros); //podemos usar count() para conocer el total de valores de un array
    $response["registros"] = $registros;

    echoResponse(200, $response);
});

$app->get('/vistaBonificaciones', function() {
    $response = array();
    include_once '../controladores/ControladorV_bonificaciones_destinatarios.php';
    $consulta = new ControladorV_bonificaciones_destinatarios();
    $registros = $consulta->buscar();    
    $response["error"] = false;
    $response["status"] = 200;
    $response["message"] = "Registros Guardados: " . count($registros); //podemos usar count() para conocer el total de valores de un array
    $response["registros"] = $registros;

    echoResponse(200, $response);
});

$app->get('/vistaNotificaciones', function() {
    $response = array();
    include_once '../controladores/ControladorV_notificaciones_destinatarios.php';
    $consulta = new ControladorV_notificaciones_destinatarios();
    $registros = $consulta->buscar();    
    $response["error"] = false;
    $response["status"] = 200;
    $response["message"] = "Registros Guardados: " . count($registros); //podemos usar count() para conocer el total de valores de un array
    $response["registros"] = $registros;

    echoResponse(200, $response);
});

$app->get('/usuarios', function() {
    $response = array();
    include_once '../controladores/ControladorUsuarios.php';
    $consulta = new ControladorUsuarios();
    $registros = $consulta->buscar();    
    $response["error"] = false;
    $response["status"] = 200;
    $response["message"] = "Registros Guardados: " . count($registros); //podemos usar count() para conocer el total de valores de un array
    $response["registros"] = $registros;

    echoResponse(200, $response);
});

$app->get('/usuariosApi', function() {
    $response = array();
    include_once '../controladores/ControladorUsuarios_api.php';
    $consulta = new ControladorUsuarios_api();
    $registros = $consulta->buscar();    
    $response["error"] = false;
    $response["status"] = 200;
    $response["message"] = "Registros Guardados: " . count($registros); //podemos usar count() para conocer el total de valores de un array
    $response["registros"] = $registros;

    echoResponse(200, $response);
});



/* Crear rutas con metodo POST para insertar datos desde la API
    ver que metodo de autenticacion se va a utilizar
    como se van a traer los datos desde la vista etc...
    la siguiente función es a modo de ejemplo
*/

$app->post('/bonificacion',/*'authenticate'*/ function() use ($app) {
    // check for required params
    //verifyRequiredParams(array());
    var_dump($app->request);    
    $response = array();
    /*capturamos los parametros recibidos y los almacenamos como un nuevo array asociativo 
    para poder enviarlos a la BD*/
    $param['creacion']  = $app->request->post('creacion');
    $param['creador'] = $app->request->post('creador');
    $param['periodo']  = $app->request->post('periodo');
    $param['monto']  = $app->request->post('monto');
    $param['observacion']  = $app->request->post('observacion');
    $param['tipo']  = $app->request->post('tipo');


    /* llamamos al metodo que almacene el nuevo dato, por ejemplo: */

    include_once '../controladores/ControladorBonificaciones.php';
    $consulta = new ControladorBonificaciones();
    $registros = $consulta->guardar($param);        
    

    if ( is_array($param) ) {
        $response["error"] = false;
        $response["message"] = "Registro creado satisfactoriamente!";
        $response["registro"] = $param;
    } else {
        $response["error"] = true;
        $response["message"] = "Error al crear registro. Por favor intenta nuevamente.";
    }
    echoResponse(201, $response);
});

/* corremos la aplicación */
$app->run();

/*********************** USEFULL FUNCTIONS **************************************/

/**
 * Verificando los parametros requeridos en el metodo o endpoint
 */
function verifyRequiredParams($required_fields) {
    $error = false;
    $error_fields = "";
    $request_params = array();
    $request_params = $_REQUEST;
    // Handling PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }
    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }
 
    if ($error) {
        // Required field(s) are missing or empty
        // echo error json and stop the app
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoResponse(400, $response);
        
        $app->stop();
    }
}
 
/**
 * Validando parametro email si necesario; un Extra ;)
 */
function validateEmail($email) {
    $app = \Slim\Slim::getInstance();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["error"] = true;
        $response["message"] = 'Email address is not valid';
        echoResponse(400, $response);
        
        $app->stop();
    }
}
 
/**
 * Mostrando la respuesta en formato json al cliente o navegador
 * @param String $status_code Http response code
 * @param Int $response Json response
 */
function echoResponse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);
 
    // setting response content type to json
    $app->contentType('application/json');
 
    echo json_encode($response);
}



