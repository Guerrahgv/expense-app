<?php
/**
 * Controlador que también maneja las sesiones
 */
class SessionController extends Controller{
    
    private $userSession;
    private $username;
    private $userid;

    private $session;
    private $sites;

    private $user;
 
    function __construct(){
        parent::__construct();

        $this->init();
    }

    public function getUserSession(){
        return $this->userSession;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getUserId(){
        return $this->userid;
    }

    /**
     * Inicializa el parser para leer el .json
     */
    private function init(){
        //se crea nueva sesión
        $this->session = new Session();
        //se carga el archivo json con la configuración de acceso
        $json = $this->getJSONFileConfig();
        // se asignan los sitios
        $this->sites = $json['sites'];
        // se asignan los sitios por default, los que cualquier rol tiene acceso
        $this->defaultSites = $json['default-sites'];
        // inicia el flujo de validación para determinar
        // el tipo de rol y permismos
        $this->validateSession();
    }
    /**
     * Abre el archivo JSON y regresa el resultado decodificado
     */
    private function getJSONFileConfig(){
        $string = file_get_contents("config/access.json");
        $json = json_decode($string, true);

        return $json;
    }

    /**
     * Implementa el flujo de autorización
     * para entrar a las páginas
     */
    function validateSession(){
     
        //Si existe la sesión
        if($this->existsSession()){
            $role = $this->getUserSessionData()->getRole();

            if($this->isPublic()){
                $this->redirectDefaultSiteByRole($role);
                }else{
                if($this->isAuthorized($role)){
                    //si el usuario está en una página de acuerdo
                    // a sus permisos termina el flujo
                }else{
                   
                    // si el usuario no tiene permiso para estar en
                    // esa página lo redirije a la página de inicio
                    $this->redirectDefaultSiteByRole($role);
                }
            }
        }else{
            //No existe ninguna sesión
            //se valida si el acceso es público o no
            if($this->isPublic()){
             
                //la pagina es publica
                //no pasa nada
            }else{
                //la página no es pública
                //redirect al login
             
                header('location: '. constant('URL') . '');
            }
        }
    }
    /**
     * Valida si existe sesión, 
     * si es verdadero regresa el usuario actual
     */
    function existsSession(){
        if(!$this->session->exists()) return false;
        if($this->session->getCurrentUser() == NULL) return false;

        $userid = $this->session->getCurrentUser();

        if($userid) return true;

        return false;
    }

    function getUserSessionData(){
        $id = $this->session->getCurrentUser();
        $this->user = new UserModel();
        $this->user->get($id);
        return $this->user;
    }

    public function initialize($user){
            $this->session->setCurrentUser($user->getId());
        $this->authorizeAccess($user->getRole());
    }

    private function isPublic(){
        $currentURL = $this->getCurrentPage();
     
        $currentURL = preg_replace( "/\?.*/", "", $currentURL); //omitir get info
        for($i = 0; $i < sizeof($this->sites); $i++){
            if($currentURL === $this->sites[$i]['site'] && $this->sites[$i]['access'] === 'public'){
                return true;
            }
        }
        return false;
    }

    private function redirectDefaultSiteByRole($role){
        $url = '';
        for($i = 0; $i < sizeof($this->sites); $i++){
            if($this->sites[$i]['role'] === $role){
                $url = '/expense-app/'.$this->sites[$i]['site'];
            break;
            }
        }
        header('location: '.$url);
        
    }

    private function isAuthorized($role){
        $currentURL = $this->getCurrentPage();
        $currentURL = preg_replace( "/\?.*/", "", $currentURL); //omitir get info
        
        for($i = 0; $i < sizeof($this->sites); $i++){
            if($currentURL === $this->sites[$i]['site'] && $this->sites[$i]['role'] === $role){
                return true;
            }
        }
        return false;
    }

    private function getCurrentPage(){
        
        $actual_link = trim("$_SERVER[REQUEST_URI]");
        $url = explode('/', $actual_link);
      
        return $url[2];
    }

    function authorizeAccess($role){
       
        switch($role){
            case 'user':
                $this->redirect($this->defaultSites['user']);
            break;
            case 'admin':
                $this->redirect($this->defaultSites['admin']);
            break;
            default:
        }
    }

    function logout(){
        $this->session->closeSession();
    }
}


?>