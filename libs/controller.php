<?php

class Controller{

    function __construct(){
        $this->view = new View();
    }
    /*
     * Constructor de la clase Controller.
     * Crea una nueva instancia de la clase "View" y la asigna a la propiedad "$this->view".
     */

    function loadModel($model){
        $url = 'models/'.$model.'model.php';

        if(file_exists($url)){
            require_once $url;

            $modelName = $model.'Model';
            $this->model = new $modelName();
        }
    }
    /*
     * Carga un modelo en base al nombre proporcionado como parámetro.
     * Construye la ruta del archivo del modelo y verifica si existe.
     * Si el archivo existe, lo incluye mediante "require_once".
     * Luego, construye el nombre de la clase del modelo y crea una instancia del modelo.
     * La instancia del modelo se asigna a la propiedad "$this->model".
     */

     function existPOST($params){
        foreach ($params as $param) {
            if(!isset($_POST[$param])){
                error_log("ExistPOST: No existe el parametro $param" );
                return false;
            }
        }
        return true;
    }
    
    /*
     * Verifica la existencia de parámetros en la variable $_POST.
     * Recibe un arreglo de parámetros como argumento y recorre cada uno de ellos.
     * Si algún parámetro no existe, se registra un mensaje de error en el registro de errores y se devuelve false.
     * Si todos los parámetros existen, se registra un mensaje indicando que existen y se devuelve true.
     */

    function existGET($params){
        foreach ($params as $param) {
            if(!isset($_GET[$param])){
                return false;
            }
        }
        return true;
    }
    /*
     * Verifica la existencia de parámetros en la variable $_GET.
     * Recibe un arreglo de parámetros como argumento y recorre cada uno de ellos.
     * Si algún parámetro no existe, devuelve false.
     * Si todos los parámetros existen, devuelve true.
     */

    function getGet($name){
        return $_GET[$name];
    }
    /*
     * Obtiene el valor de un parámetro específico de la variable $_GET.
     * Recibe el nombre del parámetro como argumento y devuelve su valor correspondiente.
     */

    function getPost($name){
        return $_POST[$name];
    }
    /*
     * Obtiene el valor de un parámetro específico de la variable $_POST.
     * Recibe el nombre del parámetro como argumento y devuelve su valor correspondiente.
     */

    function redirect($url, $mensajes = []){
        $data = [];
        $params = '';
        
        foreach ($mensajes as $key => $value) {
            array_push($data, $key . '=' . $value);
        }
        $params = join('&', $data);
        
        if($params != ''){
            $params = '?' . $params;
        }
        header('location: ' . constant('URL') . $url . $params);
    }
    /*
     * Redirige la solicitud a una URL específica.
     * Recibe dos parámetros: $url, que es la URL a la que se desea redirigir,
     * y $mensajes, que es un arreglo opcional de mensajes que se pueden pasar como parámetros en la URL.
     *
     * Dentro del método, se construye una cadena de consulta a partir del arreglo $mensajes.
     * Cada clave y valor del arreglo se concatenan con un signo igual (=) y se separan por un ampersand (&).
     * Luego, se verifica si la cadena de consulta no está vacía y, si no lo está, se le agrega un signo de interrogación (?) al principio.
     * Finalmente, se envía una respuesta de redirección al cliente mediante la función header(),
     * que incluye la URL completa a la que se desea redirigir, incluyendo la constante URL y la cadena de consulta si corresponde.
     */

}

?>
