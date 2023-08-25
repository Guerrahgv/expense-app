<?php

include_once 'libs/imodel.php';

class Model{

    function __construct(){
        $this->db = new Database();
    }
    /*
     * Constructor de la clase Model.
     * Crea una instancia de la clase Database y la asigna al atributo $db.
     */

    function query($query){
        return $this->db->connect()->query($query);
    }
    /*
     * Método para ejecutar una consulta SQL sin preparar.
     * Recibe la consulta SQL como parámetro y la ejecuta utilizando la conexión a la base de datos ($this->db->connect()).
     * Retorna el resultado de la consulta.
     */

    function prepare($query){
        return $this->db->connect()->prepare($query);
    }
    /*
     * Método para preparar una consulta SQL.
     * Recibe la consulta SQL como parámetro y la prepara utilizando la conexión a la base de datos ($this->db->connect()).
     * Retorna el objeto Statement preparado que se puede utilizar para ejecutar la consulta.
     */
}

?>
