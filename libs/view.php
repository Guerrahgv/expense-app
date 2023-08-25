<?php

class View{

    function __construct(){
    }
    /*
     * Constructor de la clase View.
     */

    function render($nombre, $data = []){
        $this->d = $data;
        
        $this->handleMessages();
        /*
         * Método para renderizar una vista.
         * Recibe el nombre de la vista a renderizar y un arreglo opcional de datos.
         * Asigna los datos al atributo $this->d.
         * Luego, invoca el método handleMessages() para manejar los mensajes en la URL.
         * Finalmente, requiere el archivo de la vista correspondiente.
         */

        require 'views/' . $nombre . '.php';
    }
    /*
     * Método para renderizar una vista.
     * Recibe el nombre de la vista a renderizar y un arreglo opcional de datos.
     * Construye la ruta del archivo de la vista y lo requiere.
     */

    private function handleMessages(){
        if(isset($_GET['success']) && isset($_GET['error'])){
            // no se muestra nada porque no puede haber un error y success al mismo tiempo
        }else if(isset($_GET['success'])){
            $this->handleSuccess();
        }else if(isset($_GET['error'])){
            $this->handleError();
        }
    }
    /*
     * Método privado para manejar los mensajes en la URL.
     * Verifica si existen los parámetros 'success' y 'error' en la URL.
     * Si ambos existen, no se muestra nada ya que no puede haber un error y éxito al mismo tiempo.
     * Si solo existe 'success', invoca el método handleSuccess() para manejar el mensaje de éxito.
     * Si solo existe 'error', invoca el método handleError() para manejar el mensaje de error.
     */

    private function handleError(){
        if(isset($_GET['error'])){
            $hash = $_GET['error'];
            $errors = new Errors();

            if($errors->existsKey($hash)){
                $this->d['error'] = $errors->get($hash);
            }else{
                $this->d['error'] = NULL;
            }
        }
    }
    /*
     * Método privado para manejar el mensaje de error.
     * Verifica si existe el parámetro 'error' en la URL.
     * Si existe, obtiene el valor del parámetro 'error' y lo utiliza para obtener el mensaje de error correspondiente desde la instancia de la clase Errors.
     * Si el mensaje de error existe, se asigna al arreglo de datos ($this->d['error']), de lo contrario se asigna NULL.
     */

    private function handleSuccess(){
        if(isset($_GET['success'])){
            $hash = $_GET['success'];
            $success = new Success();

            if($success->existsKey($hash)){
                $this->d['success'] = $success->get($hash);
            }else{
                $this->d['success'] = NULL;
            }
        }
    }
    /*
     * Método privado para manejar el mensaje de éxito.
     * Verifica si existe el parámetro 'success' en la URL.
     * Si existe, obtiene el valor del parámetro 'success' y lo utiliza para obtener el mensaje de éxito correspondiente desde la instancia de la clase Success.
     * Si el mensaje de éxito existe, se asigna al arreglo de datos ($this->d['success']), de lo contrario se asigna NULL.
     */

    public function showMessages(){
        $this->showError();
        $this->showSuccess();
    }
    /*
     * Método público para mostrar los mensajes.
     * Invoca los métodos showError() y showSuccess() para mostrar los mensajes de error y éxito, respectivamente.
     */

    public function showError(){
        if(array_key_exists('error', $this->d)){
            echo '<div class="error">'.$this->d['error'].'</div>';
        }
    }
    /*
     * Método público para mostrar el mensaje de error.
     * Verifica si existe la clave 'error' en el arreglo de datos ($this->d).
     * Si existe, muestra el mensaje de error dentro de un div con la clase "error".
     */

    public function showSuccess(){
        if(array_key_exists('success', $this->d)){
            echo '<div class="success">'.$this->d['success'].'</div>';
        }
    }
    /*
     * Método público para mostrar el mensaje de éxito.
     * Verifica si existe la clave 'success' en el arreglo de datos ($this->d).
     * Si existe, muestra el mensaje de éxito dentro de un div con la clase "success".
     */

}

?>
